<?php

// Error in line 369:29, 1117:60, 1119:66

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Aws\CloudFront\CloudFrontClient;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Aws\Ses\SesClient;
use Predis\Connection\ConnectionException;
use sMedia\Banner\BannerService;
use sMedia\Core\Registry;
use sMedia\Logger\Logger;

const CONFIG_TYPE_ENABLED   = '*.php';
const CONFIG_TYPE_CANCELLED = '*.cancelled';

global $bannerService, $proxy_list, $CronConfigs;

$bannerService = null;
$proxy_list    = __DIR__ . '/data/proxy-list.txt';

/**
 * cURL initiation
 *
 * @param <type> $url The url
 * @param boolean $proxyPath The proxy path
 * @param boolean $random_proxy The random proxy
 *
 * @return     <type>   ( description_of_the_return_value )
 */
function commonCurlInit($url, $proxyPath = false, $random_proxy = false)
{
    // WARNING: do not echo here, this is called from all the curl functions
    // including the ones generating images and swf banners, it could corrupt the buffer
    global $argv;
    sleep(1);
    $curl = curl_init();

    if ($proxyPath) {
        if ($random_proxy) {
            $p = getRandomProxy($proxyPath);
        } else {
            $p = getSequentialProxy($proxyPath);
        }

        $proxy_parts = explode(':', $p);
        $pwd         = $proxy_parts[2] . ':' . $proxy_parts[3];

        if (($argv && array_key_exists('2', $argv))) {
            slecho('Using proxy: ' . $proxy_parts[0] . ':' . $proxy_parts[1]);
            slecho("Requesting url ==> {$url}");
        }

        curl_setopt($curl, CURLOPT_PROXY, $proxy_parts[0] . ':' . $proxy_parts[1]);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $pwd);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($curl, CURLOPT_ENCODING, '');
    curl_setopt($curl, CURLOPT_URL, str_replace('~', '%7E', $url));
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36');

    return $curl;
}

/**
 * Combines the cookies
 *
 * @param <type> $cookie1 The cookie 1
 * @param <type> $cookie2 The cookie 2
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function cookie_combine($cookie1, $cookie2)
{
    $cookies = [];
    $matches = [];

    $cookie_pair_regex = '/[\s;]*(?<names>[^=]+)=(?<values>[^;]+)[\s;]*/';

    if (preg_match_all($cookie_pair_regex, $cookie1, $matches)) {
        $cookies = array_combine($matches['names'], $matches['values']);
    }

    if (preg_match_all($cookie_pair_regex, $cookie2, $matches)) {
        $cookies = array_merge($cookies, array_combine($matches['names'], $matches['values']));
    }

    $cookie_pairs = [];

    foreach ($cookies as $key => $value) {
        $cookie_pairs[] = "$key=$value";
    }

    return implode('; ', $cookie_pairs);
}

/*
 * @summary    Make http get request using CURL
 *
 * @param      string           url            The url to make the GET request to
 * @param      mixed            $proxyPath     The proxy path
 * @param      boolean          $random_proxy  The random proxy
 * @param      string           $in_cookies    In cookies
 * @param      string           $out_cookies   The out cookies
 *
 *
 * @return     string data obtained through the get request
 * ************************************************************************
 * HttpGet('google.com', true, true);
 * HttpGet('google.com', 'abc.txt', true);
 *
 */
function HttpGet($url, $proxyPath = false, $random_proxy = false, $in_cookies = '', &$out_cookies = '', $content_type = 'application/x-www-form-urlencoded', $additional_headers = [], $annoy_func = null)
{
    global $proxy_list; // default file path

    $url = trim($url);

    if ($proxyPath === true) {
        $proxyPath = $proxy_list;
    }

    $headers = ["Content-type: $content_type"];

    foreach ($additional_headers as $key => $value) {
        $headers[] = "{$key}: {$value}";
    }

    $curl = commonCurlInit($url, $proxyPath, $random_proxy);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_COOKIE, $in_cookies);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $contents       = curl_exec($curl);
    $httpcode       = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $header         = curl_getinfo($curl);
    $header_content = substr($contents, 0, $header['header_size']);
    $body_content   = trim(str_replace($header_content, '', $contents));
    $pattern        = '/Set-Cookie:\s+(?<cookie>(?<name>[^=]+)=(?<value>[^;]+))/';

    if (preg_match_all($pattern, $header_content, $matches)) {
        $out_cookies = cookie_combine($in_cookies, implode("; ", $matches['cookie']));
    } else {
        $out_cookies = $in_cookies;
    }

    if ($curl) {
        curl_close($curl);
    }

    if ($httpcode >= 400) {
        return null;
    }

    if ($contents) {
        if ($annoy_func) {
            return $annoy_func($body_content);
        }

        return $body_content;
    } else {
        return null;
    }
}

/**
 * Gets the image via http get
 *
 * @param string $url The url
 * @param boolean $proxyPath The proxy path
 * @param boolean $random_proxy The random proxy
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function HttpGetImage($url, $proxyPath = false, $random_proxy = false)
{
    global $proxy_list;

    if ($proxyPath == true) {
        $proxyPath = $proxy_list;
    }

    $url       = str_replace(' ', '%20', $url);
    $cachefile = __DIR__ . '/imgcache/' . md5($url);

    if (file_exists($cachefile) && filesize($cachefile) > 1024) {
        if (filemtime($cachefile) > time() - 6 * 60 * 60) {
            return file_get_contents($cachefile);
        }
    }

    $curl = commonCurlInit($url, $proxyPath, $random_proxy);
    // curl_setopt($curl, CURLOPT_MUTE, false);            // CURLOPT_MUTE is deprecated
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // If you set CURLOPT_RETURNTRANSFER to true then the return value from curl_exec will be the actual result from the successful operation. In other words it will not return TRUE on success. Although it will return FALSE on failure.
    curl_setopt($curl, CURLOPT_HEADER, 0);

    $contents = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpcode > 400) {
        return false;
    }

    if ($contents) {
        file_put_contents($cachefile, $contents);

        return $contents;
    } else {
        return false;
    }
}

/**
 * @summary    Make http post request using CURL
 *
 * @param string $url The url
 * @param string $post_data The post data
 * @param string $in_cookies In cookies
 * @param string $out_cookies The out cookies
 * @param mixed $proxyPath The proxy path
 * @param boolean $random_proxy The random proxy
 * @param string $content_type The content type
 * @param array $additional_headers The additional headers
 *
 * @return     string   data obtained through the get request
 */
function HttpPost($url, $post_data, $in_cookies, &$out_cookies, $proxyPath = false, $random_proxy = false, $content_type = 'application/x-www-form-urlencoded', $additional_headers = [], $annoy_func = null)
{
    global $proxy_list;

    if ($proxyPath === true) {
        $proxyPath = $proxy_list;
    }

    $headers = [];

    if ($content_type != 'multipart/form-data') {
        $headers[] = "Content-type: {$content_type}";
    }

    foreach ($additional_headers as $key => $value) {
        $headers[] = "{$key}: {$value}";
    }

    $curl = commonCurlInit($url, $proxyPath, $random_proxy);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_COOKIE, $in_cookies);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($curl, CURLOPT_REFERER, $url);

    $contents       = curl_exec($curl);
    $httpcode       = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $header         = curl_getinfo($curl);
    $header_content = substr($contents, 0, $header['header_size']);
    $body_content   = trim(str_replace($header_content, '', $contents));

    $pattern = '/Set-Cookie:\s+(?<cookie>(?<name>[^=]+)=(?<value>[^;]+))/';

    if (preg_match_all($pattern, $header_content, $matches)) {
        $out_cookies = cookie_combine($in_cookies, implode("; ", $matches['cookie']));
    } else {
        $out_cookies = $in_cookies;
    }

    if ($curl) {
        curl_close($curl);
    }

    if ($httpcode > 400) {
        return null;
    }

    if ($contents) {
        if ($annoy_func) {
            return $annoy_func($body_content);
        }

        return $body_content;
    } else {
        return null;
    }
}

/**
 * Loads proxies from provided proxy path (file).
 *
 * @param <type> $proxyPath The path
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function loadProxies($proxyPath)
{
    return file($proxyPath, FILE_IGNORE_NEW_LINES);
}

/**
 * Gets the sequential proxy from provided proxy path (file).
 *
 * @param <type> $proxyPath The path
 *
 * @return     <type>  The sequential proxy.
 */
function getSequentialProxy($proxyPath)
{
    $proxies = loadProxies($proxyPath);

    $data_file = __DIR__ . '/data/' . basename($proxyPath, '.txt') . '-sequence.dat';
    $index     = 0;

    if (file_exists($data_file)) {
        $index = file_get_contents($data_file);
        $index++;
    }

    if ($index >= count($proxies)) {
        $index = 0;
    }

    file_put_contents($data_file, $index, LOCK_EX);

    return $proxies[$index];
}

/**
 * Gets a random proxy from provided proxy path (file).
 *
 * @param <type> $proxyPath The path
 *
 * @return     <type>  The random proxy.
 */
function getRandomProxy($proxyPath)
{
    $proxies = loadProxies($proxyPath);

    return $proxies[mt_rand(0, count($proxies) - 1)];
}

/**
 * Sends an email using AWS SES.
 *
 * @param array $tos The tos
 * @param string $from The from
 * @param <type> $subject The subject
 * @param <type> $message The message
 * @param string $content_type The content type
 * @param array $bcc The bcc
 *
 * @return     boolean|string  ( description_of_the_return_value )
 */
function SendEmail($tos, $from, $subject, $message, $content_type = '', $bcc = [])
{
    global $ses_config;

    if (!$from) {
        $from = "offer@smedia.ca";
    }

    if (!$subject) {
        $subject = "Email notification from sMedia.";
    }

    $is_html = $content_type !== 'text/plain';

    if (!is_array($bcc)) {
        $bcc = array($bcc);
    }

    if (!is_array($tos)) {
        $tos = array($tos);
    }

    if (count($tos) === 0) {
        return "No reciepent";
    }

    $SesClient = SesClient::factory($ses_config);

    $char_set = 'UTF-8';

    try {
        $email = [
            'Destination'          => [
                'ToAddresses' => array_merge($tos, $bcc),
            ],

            'ReplyToAddresses'     => [
                $from,
            ],

            'Source'               => $from,
            'Message'              => [
                'Body'    => [
                    'Html' => [
                        'Charset' => $char_set,
                        'Data'    => $message,
                    ],

                    'Text' => [
                        'Charset' => $char_set,
                        'Data'    => $message,
                    ],
                ],

                'Subject' => [
                    'Charset' => $char_set,
                    'Data'    => $subject,
                ],
            ],
            'ConfigurationSetName' => 'smedia-logs',
        ];

        if ($is_html) {
            unset($email['Message']['Body']['Text']);
        } else {
            unset($email['Message']['Body']['Html']);
        }

        $trySendingEmail = $SesClient->sendEmail($email);

        return true;
    } catch (AwsException $e) {
        return $e->getMessage();
    }
}

/**
 * Makes an api request ti call drip api.
 *
 * @param array $salesman_numbers
 * @param string $id The identifier
 * @param string $name The name
 * @param string $interest The interest
 * @param string $price The price
 * @param string $number The number
 */
function calldripApiRequest($salesman_numbers = [], $id, $name, $interest, $price, $number)
{
    $url = "https://calldrip-dev.smedia.ca/sales_get.php";

    $post_fields = [
        "id"      => $id,
        "data"    => [
            "name"     => $name,
            "interest" => $interest,
            "price"    => $price,
            "number"   => $number,
        ],

        "numbers" => $salesman_numbers,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
    curl_setopt($ch, CURLOPT_HEADER, 'content-type: application/json');
    curl_exec($ch);
    curl_close($ch);
}

/**
 * Combines url.
 *
 * @param string $host The host
 * @param string $relative The relative
 *
 * @return     string  ( description_of_the_return_value )
 */
function urlCombine($host, $relative)
{
    $host_temp     = str_replace(' ', '%20', $host);
    $relative_temp = str_replace(' ', '%20', $relative);
    $host          = str_replace('>', '', str_replace('&amp;', '&', $host_temp));
    $relative      = str_replace('>', '', str_replace('&amp;', '&', $relative_temp));

    $hash_tags = '';

    if (stripos($host, '#')) {
        $hash_tags = substr($host, stripos($host, '#'));
        $host      = substr($host, 0, stripos($host, '#'));
    }

    if (startsWith($relative, '//')) {
        return "https:{$relative}";
    }

    if (preg_match('/^https?:\/\//', $relative)) {
        return $relative;
    }

    if (startsWith($relative, '/')) {
        if (stripos($host, '/', 9) !== false) {
            $temp = substr($host, 0, stripos($host, '/', 9));
        } else {
            $temp = $host;
        }

        return $temp . $relative;
    } elseif (startsWith($relative, '?')) {
        if (strpos($host, '?') > 0) {
            $existing = substr($host, stripos($host, '?') + 1);
            $host     = substr($host, 0, stripos($host, '?'));
            parse_str($existing, $existing_array);
            parse_str(substr($relative, 1), $new_array);
            $resulting_array = array_merge($existing_array, $new_array);
            $resulting       = http_build_query($resulting_array);
            $relative        = "?{$resulting}";
        }

        return "{$host}{$relative}{$hash_tags}";
    } else {
        $temp = substr($host, 0, strripos($host, '/') + 1);

        return "{$temp}{$relative}";
    }
}

/**
 * Splits a string.
 *
 * @param <type> $string The string
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function descSplit($string)
{
    if (!$string) {
        return false;
    }

    $desc1 = '';
    $desc2 = '';
    $words = explode(' ', $string);

    foreach ($words as $word) {
        if (strlen($desc1) + (strlen($word) + 1) <= 36) {
            $desc1 .= $word . ' ';
        } else {
            $desc2 .= $word . ' ';
        }
    }

    if (strlen($desc1) > 0) {
        $desc1 = substr($desc1, 0, strlen($desc1) - 1);
    }

    if (strlen($desc2) > 0) {
        $desc2 = substr($desc2, 0, strlen($desc2) - 1);
    }

    return array($desc1, $desc2);
}

/**
 * Performs serial echo.
 *
 * @param <type> $data The data
 */
function slecho($data, $type = 'info')
{
    if (defined('noprint')) {
        return;
    }

    //command line detection / multi process worker
    global $argv, $worker_logfile;

    if (isset($worker_logfile) && Logger::getByPath($worker_logfile)) {
        $logger = Logger::getByPath($worker_logfile);

        if ($type == 'info') {
            $logger->info($data);
        } elseif ($type == 'error') {
            $logger->error($data);
        } elseif ($type == 'warning') {
            $logger->warning($data);
        }
    } elseif (isset($argv[2])) {
        try {
            logme($data);
        } catch (Exception $e) {
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    } else {
        secho($data);
    }
}

/**
 * Performs serial echo.
 *
 * @param string $data The data
 */
function secho($data)
{
    global $argv;

    if (isset($argv[2])) {
        try {
            logme($data);
        } catch (Exception $e) {
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    } elseif (!defined('dont_print')) {
        echo $data . '<br />';
        flush();
        @ob_flush();
    }
}

/**
 * Processes a text template.
 *
 * @param <type> $template The template
 * @param <type> $param The parameter
 * @param boolean $force The force
 * @param string $null_price The null price
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function processTextTemplate($template, $param, $force = false, $null_price = '')
{
    if (!is_array($param)) {
        return $template;
    }

    foreach ($param as $key => $val) {
        $template = str_ireplace("{{$key}}", "[$key]", $template);
        if (stripos($template, "[$key]") === false) {
            continue;
        }

        if (in_array($key, ['price', 'biweekly', 'msrp'])) {
            if (numarifyPrice($val) != -1) {
                $template = str_ireplace("[$key]", $val, $template);
            } else {
                if (!$force) {
                    $template = str_ireplace("[$key]", $null_price, $template);
                    $key = ucfirst($key);
                    $template = str_ireplace("{{$key}", $null_price, $template);
                } else {
                    return false;
                }
            }
        } else {
            if (is_string($val) || is_numeric($val)) {
                $template = str_ireplace("[$key]", $val, $template);
            }
        }
    }

    return trim(str_replace('  ', ' ', $template));
}

/**
 * Prettifies a string.
 *
 * @param <type> $str The string
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function prettyString($str)
{
    return $str;
}

/**
 * Gets the dealer domain.
 *
 * @param <type> $cron_name The cron name
 *
 * @return     <type>  The dealer domain.
 */
function getDealerDomain($cron_name)
{
    global $scrapper_configs;

    if (!isset($scrapper_configs[$cron_name])) {
        return null;
    }

    $entry_points = $scrapper_configs[$cron_name]['entry_points'];

    if (!is_array($entry_points)) {
        return null;
    }

    $eu = array_values($entry_points);

    if (count($eu) > 0) {
        $eus = $eu[0];

        if (!is_array($eus)) {
            $eus = array($eus);
        }

        if (count($eus) > 0) {
            $domain = GetDomain($eus[0]);
            return $domain;
        }
    }

    return null;
}

/**
 * Retrieves the best profile id.
 *
 * @param Analytics $analytics The analytics
 * @param <type> $domain The domain
 *
 * @return     <type>     ( description_of_the_return_value )
 */
function retrive_best_profileId(Analytics $analytics, $domain)
{
    $data = $analytics->GetHostSummary($domain);

    if (!$data) {
        return null;
    }

    $profileId = null;
    $pageViews = 0;

    foreach ($data as $report) {
        if ($profileId == null) {
            $profileId = $report->profileInfo->profileId;
            $pageViews = $report->totalsForAllResults->{'ga:pageviews'};
        } elseif ($report->totalsForAllResults->{'ga:pageviews'} > $pageViews) {
            $profileId = $report->profileInfo->profileId;
            $pageViews = $report->totalsForAllResults->{'ga:pageviews'};
        }
    }

    return $profileId;
}

/**
 * Calculates the points.
 *
 * @param integer $rank_data The rank data
 *
 * @return     integer  The points.
 */
function calculate_points($rank_data)
{
    # Baseline = Images + Description
    $car_rank = 15 + 100; // but why?
    # VDP TBD
    # Days in market
    $car_rank += $rank_data['avg_day_count'] - $rank_data['day_count'];
    # Images
    $car_rank += min($rank_data['image_count'] - $rank_data['avg_image_count'], 5);
    # Description
    $car_rank += max(min(round(($rank_data['desc_count'] - $rank_data['avg_desc_count']) / 10), 10), -10);
    # Price Rank TBD
    # Price
    $quality_score = $car_rank;

    if ($rank_data['price'] > 0) {
        $quality_score *= $rank_data['price'];
    }

    return $quality_score;
}

/**
 * Gets the analytics start date.
 *
 * @param boolean $on15 On 15
 *
 * @return     <type>   The analytics start date.
 */
function getAnalyticsStartDate($on15 = false)
{
    $date = new DateTime(date('Y-m-d'));

    $today = date('d');

    if ($on15) {
        if ($today < 15) {
            $date->sub(new DateInterval('P1M'));
        }

        return $date->format('Y-m-15');
    }

    return $date->format('Y-m-01');
}

/**
 * Sort one array of objects by one of the object's property
 *
 * @param      mixed   $array     , the array of objects
 * @param      mixed   $property  , the property to sort with
 *
 * @return     mixed,  the sorted $array
 */
function sortByProperty($array, $property)
{
    $cur           = 1;
    $stack[1]['l'] = 0;
    $stack[1]['r'] = count($array) - 1;

    do {
        $l = $stack[$cur]['l'];
        $r = $stack[$cur]['r'];
        $cur--;

        do {
            $i   = $l;
            $j   = $r;
            $tmp = $array[(int) (($l + $r) >> 1)];

            // split the array in to parts-new
            // first: objects with "smaller" property $property
            // second: objects with "bigger" property $property
            do {
                while ($array[$i]->{$property} < $tmp->{$property}) {
                    $i++;
                }

                while ($tmp->{$property} < $array[$j]->{$property}) {
                    $j--;
                }

                // Swap elements of two parts-new if necesary
                if ($i <= $j) {
                    $w         = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $w;

                    $i++;
                    $j--;
                }
            } while ($i <= $j);

            if ($i < $r) {
                $cur++;
                $stack[$cur]['l'] = $i;
                $stack[$cur]['r'] = $r;
            }

            $r = $j;
        } while ($l < $r);
    } while ($cur != 0);

    return $array;
}

/**
 * Sorts an array by value.
 *
 * @param array $array The array
 * @param <type> $key The key
 *
 * @return     array   ( description_of_the_return_value )
 */
function sortByValue($array, $key)
{
    $cur           = 1;
    $stack[1]['l'] = 0;
    $stack[1]['r'] = count($array) - 1;

    do {
        $l = $stack[$cur]['l'];
        $r = $stack[$cur]['r'];
        $cur--;

        do {
            $i   = $l;
            $j   = $r;
            $tmp = $array[(int) (($l + $r) >> 1)];

            do {
                while ($array[$i][$key] < $tmp[$key]) {
                    $i++;
                }

                while ($tmp[$key] < $array[$j][$key]) {
                    $j--;
                }

                // Swap elements of two parts-new if necesary
                if ($i <= $j) {
                    $w         = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $w;

                    $i++;
                    $j--;
                }
            } while ($i <= $j);

            if ($i < $r) {
                $cur++;
                $stack[$cur]['l'] = $i;
                $stack[$cur]['r'] = $r;
            }

            $r = $j;
        } while ($l < $r);
    } while ($cur != 0);

    return $array;
}

/**
 * Gets the virtual dealer.
 *
 * @param      <type>  $cron_name  The cron name
 * @param      <type>  $url        The url
 *
 * @return     <type>  The virtual dealer.
 */
function getVirtualDealer($cron_name, $url)
{
    global $scrapper_configs;

    $scrapper_config = isset($scrapper_configs) ? @$scrapper_configs[$cron_name] : null;

    if (!$scrapper_config || !isset($scrapper_config['url_resolve'])) {
        return $cron_name;
    }

    $url_resolve = $scrapper_config['url_resolve'];

    foreach ($url_resolve as $c_name => $resolve_regex) {
        if (preg_match($resolve_regex, $url)) {
            $cron_name = $c_name;
            break;
        }
    }

    return $cron_name;
}

/**
 * Gets the domain dealer using the meta table.
 *
 * @param <type> $domain The domain
 * @param <type> $url The url
 *
 * @return     <type>  The domain dealer.
 */
function getDomainDealer($domain, $url)
{
    $cron_name = get_meta('dealer_domain', $domain);

    if (!$cron_name) {
        if (startsWith($domain, 'www.')) {
            $cron_name = get_meta('dealer_domain', substr($domain, 4));
        } else {
            $cron_name = get_meta('dealer_domain', "www.$domain");
        }
    }

    return getVirtualDealer($cron_name, $url);
}

/**
 * Gets the dealership from url.
 *
 * @param      <type>  $url    The url
 */
function getDealershipFromURL($url)
{
    $url_parts = parse_url($url);
    $domain    = $url_parts['host'];

    return getDomainDealer($domain, $url);
}

/**
 * Get cURL contents.
 *
 * @param <type> $url The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

/**
 * Get http headers.
 *
 * @param <type> $Url The url
 * @param integer $Format The format
 * @param integer $Depth The depth
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function http_get_headers($Url, $Format = 0, $Depth = 0)
{
    if ($Depth > 5) {
        return;
    }

    $Parts = parse_url($Url);

    if (!array_key_exists('path', $Parts)) {
        $Parts['path'] = '/';
    }

    if (!array_key_exists('port', $Parts)) {
        $Parts['port'] = 80;
    }

    if (!array_key_exists('scheme', $Parts)) {
        $Parts['scheme'] = 'http';
    }

    $Return = [];
    $fp     = fsockopen($Parts['host'], $Parts['port'], $errno, $errstr, 30);

    if ($fp) {
        $Out = 'GET ' . $Parts['path'] . (isset($Parts['query']) ? '?' . @$Parts['query'] : '') . " HTTP/1.1\r\n" . 'Host: ' . $Parts['host'] . ($Parts['port'] != 80 ? ':' . $Parts['port'] : '') . "\r\n" . 'Connection: Close' . "\r\n";
        fwrite($fp, $Out . "\r\n");
        $Redirect    = false;
        $RedirectUrl = '';

        while (!feof($fp) && $InLine = fgets($fp, 1280)) {
            if ($InLine == "\r\n") {
                break;
            }

            $InLine            = rtrim($InLine);
            list($Key, $Value) = explode(': ', $InLine, 2);

            if ($Key == $InLine) {
                if ($Format == 1) {
                    $Return[$Depth] = $InLine;
                } else {
                    $Return[] = $InLine;
                }

                if (strpos($InLine, 'Moved') > 0) {
                    $Redirect = true;
                }
            } else {
                if ($Key == 'Location') {
                    $RedirectUrl = $Value;
                }

                if ($Format == 1) {
                    $Return[$Key] = $Value;
                } else {
                    $Return[] = $Key . ': ' . $Value;
                }
            }
        }

        fclose($fp);

        if ($Redirect && !empty($RedirectUrl)) {
            $NewParts = parse_url($RedirectUrl);

            if (!array_key_exists('host', $NewParts)) {
                $RedirectUrl = $Parts['host'] . $RedirectUrl;
            }

            if (!array_key_exists('scheme', $NewParts)) {
                $RedirectUrl = $Parts['scheme'] . '://' . $RedirectUrl;
            }

            $RedirectHeaders = http_get_headers($RedirectUrl, $Format, $Depth + 1);

            if ($RedirectHeaders) {
                $Return = array_merge_recursive($Return, $RedirectHeaders);
            }
        }

        return $Return;
    }

    return false;
}

/**
 * Calculates the template hash.
 *
 * @param <type> $cron_name The cron name
 *
 * @return     <type>  The template hash.
 */
function calculate_template_hash($cron_name)
{
    global $bannerService;

    if (!$bannerService) {
        $bannerService = new BannerService(
            Registry::get('banner_s3'),
            Registry::get('cache_dir'),
            Registry::get('template_bucket'),
            Registry::get('banner_redis'),
            Registry::get('banner_prefix'),
            Registry::get('template_prefix')
        );
    }

    return $bannerService->template_service->getHash($cron_name);
}

/**
 * Copy a directory.
 *
 * @param <type> $source The source
 * @param <type> $dest The destination
 */
/* function copyDir($source, $dest)
{
    mkdir($dest, 0755);

    foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item) {
        if ($item->isDir()) {
            mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        } else {
            copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        }
    }
} */

/**
 * { function_description }
 *
 * @param      string  $src    The source
 * @param      string  $dst    The destination
 */
function recurse_copy($source, $dest)
{
    $dir = opendir($source);
    @mkdir($dest, 0755);

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($source . '/' . $file)) {
                recurse_copy($source . '/' . $file, $dest . '/' . $file);
            } else {
                copy($source . '/' . $file, $dest . '/' . $file);
            }
        }
    }

    closedir($dir);
}

/**
 * Encodes the pipe symbol.
 *
 * @param <type> $im_urls The im urls
 *
 * @return     array   ( description_of_the_return_value )
 */
function image_pipe_filter($im_urls)
{
    $retval = [];

    foreach ($im_urls as $url) {
        $retval[] = str_replace('|', '%7C', $url);
    }

    return $retval;
}

/**
 * Decodes a csv file to get car data
 *
 * @param <type> $data The data
 *
 * @return     array   ( description_of_the_return_value )
 */
function csv_real_decode($data)
{
    $result   = [];
    $lines    = explode("\n", $data);
    $headings = explode(',', $lines[0]);

    array_walk($headings, function (&$val) {
        $val = trim($val, "\" \t\n\r\0\x0B");
    });

    for ($i = 1, $line_count = count($lines); $i < $line_count; $i++) {
        if (!$lines[$i]) {
            continue;
        }

        $result[$i - 1] = [];
        $elems          = explode(',', $lines[$i]);
        $index          = 0;
        $quote          = false;

        for ($j = 0, $elem_count = count($elems); $j < $elem_count; $j++) {
            if ($elems[$j] && $elems[$j][0] == '"') {
                $quote     = true;
                $elems[$j] = substr($elems[$j], 1);
            }

            if ($quote) {
                // To avoid Undefined index notice
                if (!isset($result[$i - 1][$headings[$index]])) {
                    $result[$i - 1][$headings[$index]] = '';
                } else {
                    $result[$i - 1][$headings[$index]] .= ',';
                }

                $result[$i - 1][$headings[$index]] .= $elems[$j];

                if (($ind = strlen($elems[$j]) - 1) >= 0 && $elems[$j][$ind] == '"') {
                    $result[$i - 1][$headings[$index]] = substr($result[$i - 1][$headings[$index]], 0, strlen($result[$i - 1][$headings[$index]]) - 1);
                    $quote                             = false;
                }
            } else {
                $result[$i - 1][$headings[$index]] = $elems[$j];
            }

            if (!$quote) {
                $index++;
            }
        }
    }

    return $result;
}

/**
 * { function_description }
 *
 * @param string $csv_data The csv data
 *
 * @return     array   ( description_of_the_return_value )
 */
function convert_CSV_to_JSON($csv_data)
{
    $data    = array_map("str_getcsv", explode("\n", $csv_data));
    $columns = $data[0];
    $json    = [];

    foreach ($data as $row_index => $row_data) {
        if ($row_index === 0) {
            continue;
        }

        $json[$row_index] = [];

        foreach ($row_data as $column_index => $column_value) {
            $label                    = $columns[$column_index];
            $json[$row_index][$label] = $column_value;
        }
    }

    return $json;
}

/**
 * { function_description }
 *
 * @param <type> $xml_data The xml data
 *
 * @return     array   ( description_of_the_return_value )
 */
function convert_xml_to_json($xml_data)
{
    $xmlContent = str_replace(array("\n", "\r", "\t"), '', $xml_data);
    $xmlContent = trim(str_replace('"', "'", $xmlContent));
    $simpleXML  = simplexml_load_string($xmlContent);
    $json       = json_encode($simpleXML);
    return $json;
}

/**
 * Checks if $needle exists in $haystack
 *
 * @param <type> $needle The needle
 * @param <type> $haystack The haystack
 *
 * @return     <bool>  ( description_of_the_return_value )
 */
function contains($needle, $haystack)
{
    return strContains($haystack, $needle);
}

/**
 * Checks if $needle exists in $haystack
 *
 * @param <type> $needle The needle
 * @param <type> $haystack The haystack
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function includes($needle, $haystack)
{
    return strContains($haystack, $needle);
}

/**
 * { function_description }
 *
 * @param <type> $string The string
 * @param <type> $substring The substring
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function strContains($string, $substring)
{
    if (strpos($string, $substring) !== false) {
        return true;
    }

    return false;
}

/**
 * { function_description }
 *
 * @param <type> $url The url
 * @param <type> $required_params The required parameters
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function clear_query($url, $required_params)
{
    $components = parse_url($url);

    $new_queries = [];
    $queries     = [];

    parse_str(isset($components['query']) ? $components['query'] : '', $queries);

    foreach ($queries as $name => $value) {
        if (stripos($name, 'utm_') === false && (!is_array($required_params) || in_array($name, $required_params))) {
            $new_queries[$name] = $value;
        }
    }

    $components['query'] = http_build_query($new_queries);

    return build_url($components);
}

/**
 * Change special characters in url for web
 *
 * @param <string> $url The url
 * @param <string> $required_params The required parameters
 *
 * @return     <string>  ( description_of_the_return_value )
 */
function mild_url_encode($url, $required_params = null)
{
    $search  = ['$', ' ', '+', "\"", ",", "(", ")", "'", "®", "!"];
    $replace = ['%24', '%20', '%2B', "%22", '%2C', "%28", "%29", "%27", "%C2%AE", "%21"];

    return str_replace($search, $replace, clear_query($url, $required_params));
}

/**
 * Determines if json.
 *
 * @param <string> $string The string
 *
 * @return     boolean  True if json, False otherwise.
 */
function isJSON($string)
{
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

/**
 * Gets the data cache.
 *
 * @param <string> $filename The filename
 * @param integer $hours The hours
 *
 * @return     <type>   The data cache.
 */
function get_data_cache($filename, $hours = 24)
{
    if (!file_exists($filename)) {
        return null;
    }

    $now  = time();
    $ft   = filemtime($filename);
    $diff = $now - $ft;

    if ($diff < (3600 * $hours)) // 1 hour = 60 * 60 seconds = 3600 seconds
    {
        $data   = file_get_contents($filename);
        $u_data = unserialize($data);

        return $u_data;
    } else {
        return null;
    }
}

/**
 * Stores a data cache.
 *
 * @param <string> $filename The filename
 * @param <type> $data The data
 */
function store_data_cache($filename, $data)
{
    $cdata = serialize($data);
    file_put_contents($filename, $cdata, LOCK_EX);
}

/**
 * Clears chache of tags
 *
 * @param <string> $dealership The dealership
 */
function clear_tag_cache($dealership)
{
    $domain = getDealerDomain($dealership);

    if (startsiWith($domain, 'www.')) {
        $domain = str_replace('www.', '', $domain);
    }

    // $root = "https://tm.smedia.ca";
    $root = dirname(__DIR__);

    $tag_cache_dir = $root . '/tag-cache/*' . $domain . '-*.tag';
    $files         = glob($tag_cache_dir);

    foreach ($files as $file) {
        unlink($file);
    }
}

/**
 * Gets the configuration path.
 *
 * @param string $cron_name The cron name
 * @param const $config_type The configuration type
 *
 * @return     string   The configuration path.
 */
function get_config_path($cron_name, $config_type = CONFIG_TYPE_ENABLED)
{
    $config_directory = __DIR__ . "/config/";

    if (is_dir($config_directory)) {
        foreach (glob($config_directory . $config_type) as $file) {
            $content       = file_get_contents($file);
            $regex_pattern = '/\$CronConfigs\[[\'"]' . $cron_name . '[\'"]\]/';

            if (preg_match($regex_pattern, $content)) {
                return $file;
            }
        }
    }

    return null;
}

/**
 * Gets the file by pattern.
 *
 * @param <type> $pattern The pattern
 * @param <type> $dir The dir
 * @param string $file_type The file type
 *
 * @return     <type>  The file by pattern.
 */
function get_file_by_pattern($pattern, $dir, $file_type = '*.php')
{
    if (is_dir($dir)) {
        foreach (glob($dir . $file_type) as $file) {
            header('Content-Type: text/plain');
            $content = file_get_contents($file);
            header('Content-Type: text/html');

            if (preg_match("/$pattern/", $content)) {
                return $file;
            }
        }
    }

    return null;
}

/**
 * Change the configuration status to *.php or *.cancelled based on status
 *
 * @param string $cron_name The cron name
 * @param const $target_status The target status shall be either CONFIG_TYPE_ENABLED or CONFIG_TYPE_CANCELLED
 */
function change_config_status($cron_name, $target_status)
{
    // Expected current status is always the opposit of the target status
    $current_status = ($target_status === CONFIG_TYPE_ENABLED ? CONFIG_TYPE_CANCELLED : CONFIG_TYPE_ENABLED);

    // Check if there is a file in expected status
    $file = get_config_path($cron_name, $current_status);

    if ($file) {
        // Now rename to desired extension (Make sure to move/rename)
        if ($target_status == CONFIG_TYPE_CANCELLED) {
            $fileNewName = $file . '.cancelled';
            rename($file, $fileNewName);
        } else if ($target_status == CONFIG_TYPE_ENABLED) {
            $fileNewName = $file;
            $fileNewName = str_replace('.cancelled', '', $fileNewName);
            rename($file, $fileNewName);
        }
    }
}

/**
 * Gets the white listed characters in facebook advertisement.
 *
 * @return     array  The white list.
 */
function getWhiteList()
{
    $whiteList = ['$', ',', '.', '%', '@', '!', '?'];

    foreach (range('A', 'Z') as $ch) {
        array_push($whiteList, $ch);
    }

    foreach (range('a', 'z') as $ch) {
        array_push($whiteList, $ch);
    }

    foreach (range(0, 9) as $ch) {
        array_push($whiteList, $ch);
    }

    return $whiteList;
}

/**
 * Gets the black listed characters in facebook advertisement.
 *
 * @return     array  The black list.
 */
function getBlackList()
{
    return ['<', '>', '=', '~', '`', '^'];
}

/**
 * Gets all directoris from a directory path.
 *
 * @param string $directory_path The directory path
 *
 * @return     array   All directoris.
 */
function getAllDirectoris($directory_path)
{
    $directories = [];

    if (is_dir($directory_path)) {
        $scan_dir = scandir($directory_path);

        for ($i = 2; $i < count($scan_dir); $i++) {
            $type = 'folder';
            $path = $directory_path . $scan_dir[$i] . '/';

            if (is_file($directory_path . '/' . $scan_dir[$i])) {
                $type = 'file';
                $path = $directory_path . $scan_dir[$i];
            }

            $directories[] = [
                'name' => $scan_dir[$i],
                'type' => $type,
                'path' => $path,
            ];
        }
    }

    return $directories;
}

/**
 * Gets the geo location based on postal address.
 *
 * @param <type> $address The address
 *
 * @return     <type>  The geo location.
 */
function getGeoLocation($address)
{
    global $maps_api_endpoint, $maps_api_key;

    if (!$address) {
        return null;
    }

    // Check Location from cache
    $cache_file = __DIR__ . '/caches/marketplace-feeds/location-' . sha1($address);

    $retval = get_data_cache($cache_file, 365 * 24);

    if ($retval) {
        return $retval;
    }

    $url  = "{$maps_api_endpoint}&key={$maps_api_key}&address=" . rawurlencode($address);
    $json = HttpGet($url);

    if (!$json) {
        return null;
    }

    $obj = json_decode($json, true);

    if (!$obj) {
        return null;
    }

    if ($obj['status'] != 'OK') {
        return null;
    }

    if (count($obj['results']) == 0) {
        return null;
    }

    $location = $obj['results'][0];

    $retval = isset($location['geometry']['location']) ? $location['geometry']['location'] : null;

    if ($retval) {
        store_data_cache($cache_file, $retval);
    }

    return $retval;
}

/**
 * { function_description }
 *
 * @param <type> $url The url
 * @param array $required_params The required parameters
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function url_to_svin($url, $required_params = [])
{
    if (!is_array($required_params)) {
        $required_params = [];
    } else {
        sort($required_params);
    }

    $required_query = array_combine($required_params, $required_params);
    $components     = parse_url($url);
    $path           = rtrim($components['path'], '/');
    $queries        = [];
    parse_str(isset($components['query']) ? $components['query'] : '', $queries);
    $valid_queries = http_build_query(array_intersect_key($queries, $required_query));
    $identity      = strtolower("$path?$valid_queries");

    # Return the hash
    return hash('sha256', $identity);
}

/**
 * formats a number as phone number.
 *
 * @param <type> $number The number
 *
 * @return     string  ( description_of_the_return_value )
 */
function format_number($number)
{
    $number = preg_replace(array('/-/', '/\+/', '/\s/', '/\(/', '/\)/'), '', $number);

    return "+$number";
}

/**
 * Writes a log.
 *
 * @param <type> $file_path The file path
 * @param string $message The message
 */
function writeLog($file_path, $message)
{
    if (!file_exists($file_path)) {
        $log_file = fopen($file_path, "a+");
        chmod($file_path, 0755);
    } else {
        $log_file = fopen($file_path, "a+");
    }

    fwrite($log_file, date('Y-m-d H:i:s T P') . ": " . $message . "\n");
    fclose($log_file);
}

/**
 * Gets the random regina post code.
 */
function getAllReginaPostCode()
{
    $path = __DIR__ . "./data/regina_post_code.txt";

    return file($path, FILE_IGNORE_NEW_LINES);
}

/**
 * Gets the random regina post code.
 */
function getRandomReginaPostCode()
{
    $post = getAllReginaPostCode();

    return $post[mt_rand(0, count($post) - 1)];
}

/**
 * Gets all make.
 *
 * @return     array  All make.
 */
function getAllMake()
{
    $path = __DIR__ . "./data/car_make.txt";

    return file($path, FILE_IGNORE_NEW_LINES);
}

/**
 * Gets the random make.
 *
 * @return     <type>  The random make.
 */
function getRandomMake()
{
    $make = getAllMake();

    return $make[mt_rand(0, count($make) - 1)];
}

/**
 * Register for banner in the new server, it will return the banner Id or null if request fails
 */
function register_banner_set($template_name, $banner_set, $attempt = 0)
{
    global $bannerService;

    if (!$bannerService) {
        $bannerService = new BannerService(
            Registry::get('banner_s3'),
            Registry::get('cache_dir'),
            Registry::get('template_bucket'),
            Registry::get('banner_redis'),
            Registry::get('banner_prefix'),
            Registry::get('template_prefix')
        );
    }

    $banner_set_serialized = serialize($banner_set);

    // $all_params = array_filter(filter_input_array(INPUT_GET), function ($k) {
        // return (stripos($k, 'utm_') !== 0 && stripos($k, 'view') !== 0);
    // }, ARRAY_FILTER_USE_KEY);

    # Need to include hash in the set to make the set unique
    $all_params['_hash'] = $banner_set['_hash'];

    //Always on same order
    ksort($all_params);

    $param_string    = http_build_query($all_params, '', ':');
    $banner_set_hash = sha1($param_string);

    $key = "banners/{$template_name}/{$banner_set_hash}";

    try {
        $bannerService->template_service->redis_client->set($key, $banner_set_serialized, 'EX', 72 * 60 * 60);

        return $banner_set_hash;
    } catch (ConnectionException $ex) {
        if ($attempt < 3) {
            $dealy = rand(1000, $attempt * 1000000);
            usleep($dealy);

            return register_banner_set($template_name, $banner_set, $attempt++);
        } else {
            return null;
        }
    }
}

/**
 * { function_description }
 *
 * @param <type> $name The name
 * @param <type> $id The identifier
 * @param <type> $label The label
 * @param boolean $checked The checked
 * @param string $value The value
 * @param array $atts The atts
 * @param boolean $echo The echo
 *
 * @return     string   ( description_of_the_return_value )
 */
function form_group_checkbox($name, $id, $label, $checked = false, $value = "yes", $atts = [], $echo = true)
{
    $default_atts = [
        'label_class'         => 'col-sm-4',
        'input_wrapper_class' => 'col-sm-8',
    ];

    $atts     = array_merge($default_atts, $atts);
    $checked  = ($checked == true) ? "checked='checked'" : "";
    $checkbox =
        "<div class='form-group'>
            <label class='{$atts['label_class']} control-label' for='{$id}'> {$label} </label>
            <div class='{$atts['input_wrapper_class']}'>
                <input id='{$id}' type='checkbox' {$checked} name='{$name}' value='{$value}'>
            </div>
        </div>";

    if ($echo == true) {
        echo $checkbox;
    } else {
        return $checkbox;
    }
}

/**
 * { function_description }
 *
 * @param <type> $name The name
 * @param <type> $id The identifier
 * @param <type> $label The label
 * @param boolean $checked The checked
 * @param string $value The value
 * @param array $atts The atts
 * @param boolean $echo The echo
 */
function form_group_toggle_switch($name, $id, $label, $checked = false, $value = "yes", $atts = [], $echo = true)
{
    $default_atts = [
        'input_wrapper_class' => 'col-sm-8 sm-toggle-switch',
    ];

    $atts = array_merge($default_atts, $atts);
    form_group_checkbox($name, $id, $label, $checked, $value, $atts, $echo);
}

/**
 * This will allow you to pass variables to a file added using include
 *
 * @param <type> $fileName The file name
 * @param array $variables The variables in an array (any kind)
 */
function includeFileWithVariables($fileName, $variables)
{
    extract($variables);
    include $fileName;
}

/**
 * Removes parameters.
 *
 * @param <type> $url The url
 * @param string $after The after
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function removeParams($url, $required_params = [], $after = '?')
{
    $original_url = $url;

    if (stripos($url, $after, 0) !== false) {
        $url = substr($url, 0, stripos($url, $after, 0));
    }

    if (count($required_params) > 0) {
        sort($required_params);
        $required_query = array_combine($required_params, $required_params);
        $components     = parse_url($original_url);
        $path           = rtrim($components['path'], '/');
        $queries        = [];
        parse_str(isset($components['query']) ? $components['query'] : '', $queries);
        $valid_queries = http_build_query(array_intersect_key($queries, $required_query));
        $url           = "$path?$valid_queries";
    }

    return $url;
}

/**
 * Generates a random string.
 *
 * @param integer $length The length
 */
function randomString($length = 10, $isPassword = false)
{
    if ($isPassword && $length < 8) {
        $length = 8;
    }

    $pass     = [];
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890~!@#%^&*?|.,-_=+/}{)(][';

    if ($isPassword) {
        // password must contain one from the following four strings
        $lower   = 'abcdefghijklmnopqrstuvwxyz';
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $number  = '1234567890';
        $special = '~!@#%^&*?|.,-_=+/}{)(][';

        $pass[] = $lower[mt_rand(0, strlen($lower) - 1)];
        $pass[] = $upper[mt_rand(0, strlen($upper) - 1)];
        $pass[] = $number[mt_rand(0, strlen($number) - 1)];
        $pass[] = $special[mt_rand(0, strlen($special) - 1)];

        $length -= 4;
    }

    for ($i = 0, $alphaLength = strlen($alphabet) - 1; $i < $length; $i++) {
        $pass[] = $alphabet[mt_rand(0, $alphaLength)];
    }

    shuffle($pass);
    $password = implode($pass);

    if ($isPassword && strlen(trim($password)) != $length + 4) {
        return randomString($length, $isPassword);
    }

    if ($isPassword) {
        $passReg = '/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\,\|\=\|\+\-\/~!@#\$%\^&\*\?\.\]\[\}\{\)\(])/';

        if (!(preg_match($passReg, $password))) {
            return randomString($length + 4, true);
        }
    }

    return '' . $password;
}

/**
 * Encrypt string using AES256 bit algorithm
 *
 * @param string $data
 * @param string $key
 * @return string
 */
function sm_encrypt($data, $key = ENCRYPTION_KEY)
{
    $cypherMethod   = 'AES256';
    $encryption_key = base64_decode($key);
    $iv             = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cypherMethod)); // not secure
    $encrypted      = openssl_encrypt($data, $cypherMethod, $encryption_key, 0, $iv);

    return base64_encode($encrypted . '::' . $iv);
}

/**
 * Decrypt encrypted string created by sm_encrypt
 *
 * @param $data
 * @param $key
 * @return string
 */
function sm_decrypt($data, $key = ENCRYPTION_KEY)
{
    $encryption_key            = base64_decode($key);
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'AES256', $encryption_key, 0, $iv);
}

/**
 * Unserialize value only if it was serialized.
 *
 * @param string $original Maybe unserialized original, if is needed.
 * @return mixed Unserialized data can be any type.
 */
function maybe_unserialize($original)
{
    if (is_serialized($original)) {
        return @unserialize($original);
    }

    return $original;
}

/**
 * Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 *
 * @param string $data Value to check to see if was serialized.
 * @param bool $strict Optional. Whether to be strict about the end of the string. Default true.
 * @return bool False if not serialized and true if it was.
 */
function is_serialized($data, $strict = true)
{
    if (!is_string($data)) {
        return false;
    }

    $data = trim($data);

    if ('N;' == $data) {
        return true;
    }

    if (strlen($data) < 4) {
        return false;
    }

    if (':' !== $data[1]) {
        return false;
    }

    if ($strict) {
        $lastc = substr($data, -1);

        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
    } else {
        $semicolon = strpos($data, ';');
        $brace     = strpos($data, '}');

        // Either ; or } must exist.
        if (false === $semicolon && false === $brace) {
            return false;
        }

        // But neither must be in the first X characters.
        if (false !== $semicolon && $semicolon < 3) {
            return false;
        }

        if (false !== $brace && $brace < 4) {
            return false;
        }
    }

    $token = $data[0];

    switch ($token) {
        case 's':
            if ($strict) {
                if ('"' !== substr($data, -2, 1)) {
                    return false;
                }
            } elseif (false === stripos($data, '"')) {
                return false;
            }
        // or else fall through
        case 'a':
        case 'O':
            return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
        case 'b':
        case 'i':
        case 'd':
            $end = $strict ? '$' : '';

            return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
    }

    return false;
}

/**
 * Crop and resize image
 * @param $file
 * @param int $size
 * @return bool|resource
 */
function image_resize_rectangle($file, $size = 512)
{
    list($org_w, $org_h) = getimagesize($file);

    $new_w = $size;
    $new_h = $size;

    $new_r = $new_w / $new_h;

    $org_r = $org_w / $org_h;

    if ($org_r < $new_r) {
        $src_w = $org_w;
        $src_h = $org_h - $org_h * ($new_r - $org_r);
        $src_x = 0;
        $src_y = ($org_h - $src_h) >> 1;
    } else {
        $src_w = $org_w - $org_w * ($org_r - $new_r);
        $src_h = $org_h;
        $src_x = ($org_w - $src_w) >> 1;
        $src_y = 0;
    }

    $image_p = imagecreatetruecolor($new_w, $new_h);
    $image   = imagecreatefromjpeg($file);

    if (!imagecopyresampled($image_p, $image, 0, 0, $src_x, $src_y, $new_w, $new_h, $src_w, $src_h)) {
        return false;
    }

    return $image_p;
}

/**
 * { function_description }
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function current_user()
{
    global $user;
    return $user;
}

/**
 * Class DealerConfigFactory
 * TODO: move DealerConfigFactory class to it's own file
 */
class DealerConfigFactory
{
    private static $_loadedConfigs   = [];
    private static $_allConfigLoaded = false;

    public static function getConfig($dealership, $reload = true)
    {
        if ($reload == true) {
            self::destroyConfig($dealership);
        }

        if (!isset(self::$_loadedConfigs[$dealership])) {
            self::$_loadedConfigs[$dealership] = new DealerConfig($dealership);
            return self::$_loadedConfigs[$dealership];
        }

        return self::$_loadedConfigs[$dealership];
    }

    public static function getAllConfig($reload = false)
    {
        if ($reload == true) {
            self::$_allConfigLoaded = false;
            self::$_loadedConfigs   = [];
        }

        if (self::$_allConfigLoaded != true) {
            $loaded_config_names = implode("','", array_keys(self::$_loadedConfigs));

            $query  = "SELECT * FROM dealerships WHERE dealership NOT IN ('{$loaded_config_names}');";
            $result = mysqli_query(DbConnect::get_connection_read(), $query);

            if ($result) {
                if (mysqli_num_rows($result)) {
                    while ($config_row = mysqli_fetch_assoc($result)) {
                        self::$_loadedConfigs[$config_row['dealership']] = new DealerConfig($config_row['dealership'], $config_row);
                    }
                }

                self::$_allConfigLoaded = true;
            }
        }

        return self::$_loadedConfigs;
    }

    public static function destroyConfig($dealership)
    {
        $backup = false;

        if (isset(self::$_loadedConfigs[$dealership])) {
            $backup = self::$_loadedConfigs[$dealership];
            unset(self::$_loadedConfigs[$dealership]);
        }

        self::$_allConfigLoaded = false;

        return $backup;
    }
}

/**
 * Class DealerConfig
 * TODO: move DealerConfig class to it's own file
 */
class DealerConfig
{
    private $_data = null;
    public $id;
    public $dealership;
    public $saler_type;
    public $company_name;
    public $group_name;
    public $address;
    public $city;
    public $state;
    public $post_code;
    public $country_name;
    public $billing_address;
    public $billing_city;
    public $billing_state;
    public $billing_post_code;
    public $phone;
    public $calldrip;
    public $salesman_numbers;
    public $websites;
    public $website_rep;
    public $company_rep;
    public $fb_page_id;
    public $privacy_policy_url;
    public $inventories;
    public $brands;
    public $oem;
    public $campaign_types;
    public $config;
    public $sessions;
    public $start_date;
    public $end_date;
    public $last_contacted;
    public $happiness;
    public $status;
    public $assigned_to;
    public $star_to;
    public $adf_to;
    public $lead_to;
    public $lead_from;
    public $lead_to_new;
    public $adf_to_new;
    public $lead_to_used;
    public $adf_to_used;
    public $crm;
    public $buttons_live;
    public $form_live;
    public $google_account_id;
    public $bing_account_id;
    public $google_ad_campaign;
    public $bing_ad_campaign;
    public $scrapper_type;

    public function __construct($dealership, $data = null)
    {
        if ($data == null) {
            $query  = "SELECT * FROM dealerships WHERE dealership = '{$dealership}';";
            $result = mysqli_query(DbConnect::get_connection_read(), $query);

            if ($result) {
                $this->_data = mysqli_fetch_assoc($result);
            }
        } else {
            $this->_data = $data;
        }

        if ($this->_data != null) {
            foreach ((array) $this->_data as $field => $value) {
                if (property_exists($this, $field)) {
                    $this->$field = maybe_unserialize($value);
                }
            }
        }
    }
}

/**
 * { function_description }
 *
 * @param integer $size The size
 *
 * @return     <type>   ( description_of_the_return_value )
 */
function formatSizeUnits($size)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;

    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

/**
 * { Deletes, files older than a certain days in a directory. }
 * // 3 days = 60 * 60 * 24 * 3 sec = 259200 sec
 */
function deleteOldFiles($dir, $age = 259200)
{
    if ($dir[-1] != '/') {
        $dir .= '/';
    }

    $files = glob($dir . "*");
    $now   = time();

    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= $age) {
                unlink($file);
            }
        }
    }
}

/**
 * @brief       { function_description }
 * @param       $dealership { parameter_description }
 * @param       $start_date { parameter_description }
 * @param       $end_date { parameter_description }
 * @param       $group_by { parameter_description }
 * @return      { description_of_the_return_value }
 */
function get_ai_button_total_data($dealership, $start_date = '', $end_date = '', $group_by = 'button_type, line_type')
{
    if ($start_date == '' && $end_date == '') {
        $date_query = '';
    } else {
        $date_query = "AND (tbl_ai_button_data.date <= '$end_date' AND tbl_ai_button_data.date > '$start_date' )";
    }

    if ($group_by == '') {
        $group_by_query = '';
    } else {
        $group_by_query = ' GROUP BY button_type, Type';
    }

    $db = DbConnect::get_connection_read();

    $query  = "SELECT  IF(tbl_ai_button_combination.combination = 'baseline', 'baseline', 'endline') AS Type, tbl_ai_button_combination.button_type AS Button_Type, SUM(tbl_ai_button_data.view) AS View, SUM(tbl_ai_button_data.click) AS Click, SUM(tbl_ai_button_data.fill_up) AS Fill_Up FROM tbl_ai_button_data LEFT JOIN tbl_ai_button_combination ON tbl_ai_button_data.combination_id=tbl_ai_button_combination.id LEFT JOIN dealerships ON tbl_ai_button_combination.dealership_id=dealerships.id  WHERE dealerships.dealership='{$dealership}' {$group_by_query};";
    $result = $db->query($query);
    $data   = [];

    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    return $data;
}

/**
 * @brief       { function_description }
 * @param       $dealership { parameter_description }
 * @param       $start_date { parameter_description }
 * @param       $end_date { parameter_description }
 * @param       $group_by { parameter_description }
 * @return      { description_of_the_return_value }
 */
function get_ai_button_daily_total_data($dealership, $start_date = '', $end_date = '', $group_by = 'date, line_type, listing_type')
{
    if ($start_date == '' && $end_date == '') {
        $date_query = '';
    } else {
        $date_query = " and date BETWEEN '{$start_date}' AND '{$end_date}' ";
    }

    if ($group_by == '') {
        $group_by_query = '';
    } else {
        $group_by_query = ' GROUP BY button_type, Type';
    }

    $db = DbConnect::get_connection_read();

    $query = "SELECT
            IF(tbl_ai_button_combination.combination = 'baseline', 'baseline', 'endline') AS line_type,
            IF(tbl_ai_button_combination.button_type LIKE 'listing%', 'srp', 'vdp') AS listing_type,
            sum(view) AS s_view,
            sum(click) AS s_click,
            sum(fill_up) AS s_fill_up,
            date
            FROM tbl_ai_button_data
            LEFT JOIN tbl_ai_button_combination ON tbl_ai_button_combination.id=tbl_ai_button_data.combination_id
            LEFT JOIN dealerships ON dealerships.id=tbl_ai_button_combination.dealership_id
            WHERE
            dealerships.dealership='{$dealership}'
            {$date_query}
            GROUP BY {$group_by};";

    $result = $db->query($query);
    $data   = [];

    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    return $data;
}

/**
 * Gets the ai button option data.
 *
 * @param <type> $dealership The dealership
 * @param string $start_date The start date
 * @param string $end_date The end date
 *
 * @return     array   The ai button option data.
 */
function get_ai_button_option_data($dealership, $start_date = '', $end_date = '')
{
    if ($start_date == '' && $end_date == '') {
        $date_query = '';
    } else {
        $date_query = " and date BETWEEN '{$start_date}' AND '{$end_date}' ";
    }

    $db = DbConnect::get_connection_read();

    $query = "SELECT
            sum(tbl_ai_button_data.view) AS total_view,
            sum(tbl_ai_button_data.click) AS total_click,
            sum(tbl_ai_button_data.fill_up) AS total_fill_up,
            tbl_ai_button_combination.combination AS combination,
            lower(tbl_ai_button_data.stock_type) AS stock_type,
            replace(replace(tbl_ai_button_combination.button_type, 'listing-', ''), 'Listing ', '') AS t_button_type
            FROM tbl_ai_button_data
            join tbl_ai_button_combination ON combination_id=tbl_ai_button_combination.id
            join dealerships ON dealerships.id=tbl_ai_button_combination.dealership_id
            WHERE
            dealerships.dealership='{$dealership}'
            AND tbl_ai_button_combination.combination <> 'baseline'
            {$date_query}
            GROUP BY tbl_ai_button_combination.combination,tbl_ai_button_data.stock_type, t_button_type;";

    $result = $db->query($query);
    $data   = [];

    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    return $data;
}

/**
 * Gets the ai button type total data.
 *
 * @param <type> $dealership The dealership
 * @param string $start_date The start date
 * @param string $end_date The end date
 *
 * @return     array   The ai button type total data.
 */
function get_ai_button_type_total_data($dealership, $start_date = '', $end_date = '')
{
    if ($start_date == '' && $end_date == '') {
        $date_query = '';
    } else {
        $date_query = " and date BETWEEN '{$start_date}' AND '{$end_date}' ";
    }

    $db = DbConnect::get_connection_read();

    $query = "SELECT IF(tbl_ai_button_combination.combination = 'baseline', 'baseline', 'endline') AS line_type,
        tbl_ai_button_combination.button_type AS button_type,
        SUM(tbl_ai_button_data.view) AS view,
        SUM(tbl_ai_button_data.click) AS click,
        SUM(tbl_ai_button_data.fill_up) AS fill_up,
        (SUM(tbl_ai_button_data.click)/SUM(tbl_ai_button_data.view))*100 AS cr1,
        (SUM(tbl_ai_button_data.fill_up)/SUM(tbl_ai_button_data.click))*100 AS cr2
        FROM tbl_ai_button_data
        LEFT JOIN tbl_ai_button_combination ON tbl_ai_button_data.combination_id=tbl_ai_button_combination.id
        LEFT JOIN dealerships ON tbl_ai_button_combination.dealership_id=dealerships.id
        WHERE dealerships.dealership='$dealership'
        $date_query
        GROUP BY button_type, line_type;";

    $result = $db->query($query);
    $data   = [];
    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }
    return $data;
}

/**
 * Gets the ai button total view, click and fill up (for endline and baseline
 * separately) for all dealership
 *
 * @param      string  $start_date  The start date
 * @param      string  $end_date    The end date
 *
 * @return     array   The ai button dealership total data.
 */
function get_ai_button_dealership_total_data($start_date = '', $end_date = '')
{
    if ($start_date == '' && $end_date == '') {
        $date_query = '';
    } else {
        $date_query = " WHERE date BETWEEN '{$start_date}' AND '{$end_date}' ";
    }

    $db = DbConnect::get_connection_read();

    $query = "SELECT
            dealerships.dealership,
            IF(tbl_ai_button_combination.combination = 'baseline', 'baseline', 'endline') AS line_type,
            SUM(tbl_ai_button_data.view) AS total_view,
            SUM(tbl_ai_button_data.click) AS total_click,
            SUM(tbl_ai_button_data.fill_up) AS total_fill_up
            FROM tbl_ai_button_data
            LEFT JOIN tbl_ai_button_combination ON tbl_ai_button_combination.id=tbl_ai_button_data.combination_id
            LEFT JOIN dealerships ON dealerships.id=tbl_ai_button_combination.dealership_id
            $date_query
            GROUP BY dealerships.dealership, line_type";

    $result = $db->query($query);
    $data   = [];

    while ($row = mysqli_fetch_object($result)) {
        if (!isset($data[$row->dealership])) {
            $data[$row->dealership] = [];
        }

        if ($row->line_type == 'baseline') {
            $data[$row->dealership] = array_merge(
                $data[$row->dealership], [
                    'baseline_view'     => intval($row->total_view),
                    'baseline_clicks'   => intval($row->total_click),
                    'baseline_fillupts' => intval($row->total_fill_up),
                ]
            );
        } else {
            $data[$row->dealership] = array_merge(
                $data[$row->dealership], [
                    'endline_view'     => intval($row->total_view),
                    'endline_clicks'   => intval($row->total_click),
                    'endline_fillupts' => intval($row->total_fill_up),
                ]
            );
        }
    }

    return $data;
}

/**
 * @brief       { function_description }
 * @param       $file { parameter_description }
 * @return      { description_of_the_return_value }
 */
function get_csv_associative($file)
{
    $rows   = array_map('str_getcsv', file($file));
    $header = array_shift($rows);
    $csv    = [];

    foreach ($rows as $row) {
        $csv[] = array_combine($header, $row);
    }

    return $csv;
}

/**
 * Get an array of all dealership name
 *
 * @return array
 */
function get_dealership_names()
{
    $db     = DbConnect::get_connection_read();
    $query  = "SELECT dealership, company_name FROM dealerships;";
    $result = $db->query($query);
    $data   = [];

    while ($row = mysqli_fetch_object($result)) {
        $data[$row->dealership] = $row->company_name;
    }

    return $data;
}

/**
 * Gets the company name.
 *
 * @param      <type>  $dealership  The dealership
 *
 * @return     array   The company name.
 */
function get_company_name($dealership)
{
    $db     = DbConnect::get_connection_read();
    $query  = "SELECT company_name,group_name FROM dealerships WHERE dealership = '$dealership';";
    $result = $db->query($query);
    $data   = [];

    while ($row = mysqli_fetch_object($result)) {
        $data['company_name'] = $row->company_name;
        $data['group_name']   = $row->group_name;
    }

    return $data;
}

/**
 * Console log in browser as JSON.
 *
 * @param      <type>  $var    The variable
 * @param      <type>  $tags   The tags
 */
function d($var, $tags = null)
{
    PhpConsole\Connector::getInstance()->getDebugDispatcher()->dispatchDebug($var, $tags, 1);
}

/**
 * { Updates data using NLP crawler. }
 *
 * @param <type> $resp_json The response json
 *
 * @return     array   ( description_of_the_return_value )
 */
function nlp_crawler($url, $resp_json, $use_proxy = true)
{
    global $proxy_list;

    $objects    = json_decode($resp_json);
    $to_return  = [];
    $pagination = $objects->pagination;
    $pages      = (int) ($pagination->totalCars / $pagination->pageSize);

    slecho("{$pagination->totalCars} available car found.");

    if (!($pagination->totalCars % $pagination->pageSize)) {
        $pages--;
    }

    foreach ($objects->vehicles as $obj) {
        if (!isset($obj->url)) {
            continue;
        }

        $required_params = isset($objects->required_params) ? $objects->required_params : [];

        $car_data = [
            'url'            => $obj->url,
            'stock_number'   => (isset($obj->stock_number) && !empty($obj->stock_number) && strtolower($obj->stock_number) != 'n/a') ? ifArrayAsString($obj->stock_number) : md5($obj->url),
            'svin'           => isset($obj->svin) ? $obj->svin : url_to_svin($obj->url, $required_params),
            'vin'            => isset($obj->vin) ? ifArrayAsString($obj->vin) : '',
            'year'           => isset($obj->year) ? $obj->year : '',
            'make'           => isset($obj->make) ? $obj->make : '',
            'model'          => isset($obj->model) ? $obj->model : '',
            'trim'           => isset($obj->trim) ? $obj->trim : '',
            'price'          => (isset($obj->price) && $obj->price) ? $obj->price : '',
            'price_history'  => isset($obj->price_history) ? $obj->price_history : [],
            'msrp'           => (isset($obj->msrp) && $obj->msrp > $obj->price) ? $obj->msrp : '',
            'currency'       => isset($obj->currency) ? $obj->currency : '',
            'stock_type'     => isset($obj->condition) ? strtolower($obj->condition) : '',
            'engine'         => isset($obj->engine) ? $obj->engine : '',
            'transmission'   => isset($obj->transmission) ? $obj->transmission : '',
            'kilometres'     => isset($obj->mileage) ? $obj->mileage : '',
            'exterior_color' => isset($obj->exterior_color) ? $obj->exterior_color : '',
            'interior_color' => isset($obj->interior_color) ? $obj->interior_color : '',
            'fuel_type'      => isset($obj->fuel_type) ? $obj->fuel_type : '',
            'description'    => isset($obj->description) ? $obj->description : '',
            'arrival_date'   => isset($obj->first_seen) ? $obj->first_seen : time(),
            'updated_at'     => isset($obj->last_modified) ? $obj->last_modified : (isset($obj->first_seen) ? $obj->first_seen : time()),
            'all_images'     => isset($obj->images) ? implode("|", $obj->images) : "",
            'deleted'        => $obj->deleted == "" ? false : true,
        ];

        if (strtolower($car_data['stock_number']) == 'n/a') {
            $car_data['stock_number'] = md5($obj->url);
        }

        if ($car_data['stock_type'] == '') {
            $car_data['stock_type'] = predict_stock_type($car_data);
        }

        if (strtolower($car_data['stock_type']) != 'new') {
            $car_data['stock_type'] = 'used';
        }

        $to_return[] = $car_data;
    }

    if ($pages) {
        for ($i = 1; $i <= $pages; $i++) {
            if ($use_proxy) {
                $objects = json_decode(HttpGet("{$url}?pageIndex={$i}", $proxy_list));
            } else {
                $objects = json_decode(HttpGet("{$url}?pageIndex={$i}"));
            }

            foreach ($objects->vehicles as $obj) {
                if (!isset($obj->url)) {
                    continue;
                }

                $required_params = isset($objects->required_params) ? $objects->required_params : [];

                $car_data = [
                    'url'            => $obj->url,
                    'stock_number'   => (isset($obj->stock_number) && !empty($obj->stock_number) && strtolower($obj->stock_number) != 'n/a') ? ifArrayAsString($obj->stock_number) : md5($obj->url),
                    'svin'           => isset($obj->svin) ? $obj->svin : url_to_svin($obj->url, $required_params),
                    'vin'            => isset($obj->vin) ? ifArrayAsString($obj->vin) : '',
                    'year'           => isset($obj->year) ? $obj->year : '',
                    'make'           => isset($obj->make) ? $obj->make : '',
                    'model'          => isset($obj->model) ? $obj->model : '',
                    'trim'           => isset($obj->trim) ? $obj->trim : '',
                    'price'          => (isset($obj->price) && $obj->price) ? $obj->price : '',
                    'price_history'  => isset($obj->price_history) ? $obj->price_history : [],
                    'msrp'           => (isset($obj->msrp) && $obj->msrp > $obj->price) ? $obj->msrp : '',
                    'currency'       => isset($obj->currency) ? $obj->currency : '',
                    'stock_type'     => isset($obj->condition) ? strtolower($obj->condition) : '',
                    'engine'         => isset($obj->engine) ? $obj->engine : '',
                    'transmission'   => isset($obj->transmission) ? $obj->transmission : '',
                    'kilometres'     => isset($obj->mileage) ? $obj->mileage : '',
                    'exterior_color' => isset($obj->exterior_color) ? $obj->exterior_color : '',
                    'interior_color' => isset($obj->interior_color) ? $obj->interior_color : '',
                    'fuel_type'      => isset($obj->fuel_type) ? $obj->fuel_type : '',
                    'description'    => isset($obj->description) ? $obj->description : '',
                    'arrival_date'   => isset($obj->first_seen) ? $obj->first_seen : time(),
                    'updated_at'     => isset($obj->last_modified) ? $obj->last_modified : (isset($obj->first_seen) ? $obj->first_seen : time()),
                    'all_images'     => isset($obj->images) ? implode("|", $obj->images) : "",
                    'deleted'        => $obj->deleted == "" ? false : true,
                ];

                if (strtolower($car_data['stock_number']) == 'n/a') {
                    $car_data['stock_number'] = md5($obj->url);
                }

                if ($car_data['stock_type'] == '') {
                    $car_data['stock_type'] = predict_stock_type($car_data);
                }

                if (strtolower($car_data['stock_type']) != 'new') {
                    $car_data['stock_type'] = 'used';
                }

                $to_return[] = $car_data;
            }
        }
    }

    return $to_return;
}

/**
 * { Removes the begining string (usually used to remove domain part from url) }
 *
 * @param <type> $strs The strs
 * @param <type> $begining The begining
 *
 * @return     array   ( description_of_the_return_value )
 */
function excludeBegining($strs, $begining)
{
    $retval = [];

    foreach ($strs as $str) {
        if (stripos($str, $begining) === 0) {
            $retval[] = substr($str, strlen($begining));
        } else {
            $retval[] = $str;
        }
    }

    return $retval;
}

/**
 * { Determines page type. You can define any kind of page type.
 * By default it returns 'other'. }
 *
 * @param <type> $urls The urls
 * @param <type> $patterns The patterns
 *
 * @return     array   ( description_of_the_return_value )
 */
function classifyURLs($urls, $patterns)
{
    $retval = [];

    foreach ($urls as $url) {
        $retval[$url] = 'other';

        foreach ($patterns as $type => $regex) {
            if (@preg_match($regex, $url)) {
                $retval[$url] = $type;
            }
        }
    }

    return $retval;
}

/**
 * Gets the sitemap of a domain.
 *
 * @param      <type>  $sitemap_url  The sitemap url
 * @param      bool    $use_proxy    The use proxy
 *
 * @return     array   The sitemap.
 */
function getSitemap($sitemap_url, $use_proxy = true)
{
    $data = HttpGet($sitemap_url, $use_proxy, $use_proxy);

    try {
        # Intentionally suppress warning, for non xml sitemaps
        $xml = @simplexml_load_string($data);

        if (!$xml) {
            if (endsWith($sitemap_url, '.xml.gz')) {
                $decoded_data = @simplexml_load_string(@gzdecode($data));

                if ($decoded_data->url) {
                    for ($i = 0, $urlLen = count($decoded_data->url); $i < $urlLen; $i++) {
                        $retval[] = strval($decoded_data->url[$i]->loc);
                    }

                    return $retval;
                }
            }

            return [];
        }

        $retval = [];

        if ($xml->sitemap) {
            for ($i = 0, $siteLen = count($xml->sitemap); $i < $siteLen; $i++) {
                $retval = array_merge($retval, getSitemap(trim(strval($xml->sitemap[$i]->loc)), $use_proxy));
            }
        }

        if ($xml->url) {
            for ($i = 0, $urlLen = count($xml->url); $i < $urlLen; $i++) {
                $retval[] = strval($xml->url[$i]->loc);
            }
        }

        return $retval;
    } catch (Exception $ex) {
        return [];
    }
}

/**
 * Updates data using sitemap. Collects data from VDP only. You can send the
 * domain url or sitemap url as $site.
 *
 * @param      <type>   $site                    The domain url or the sitemap
 *                                               url ending with .xml
 * @param      <type>   $vdp_url_regex           The vdp url regular expression
 * @param      <type>   $data_capture_regx_full  The data capture regx full
 * @param      <type>   $images_regx             The images regular expression
 * @param      <type>   $images_fallback_regx    The images fallback regx
 * @param      array    $required_params         The required parameters
 * @param      boolean  $use_proxy               The use proxy
 * @param      <type>   $keymap                  If set to any key (like 'vin')
 *                                               then data will be mapped
 *                                               against that key
 * @param      array    $invalid_images          The invalid images
 * @param      bool     $use_custom_site         If set to true then uses a non xml url sent as $site
 * @param      <type>   $annoy_func              The function to be applied on car data
 *
 * @return     array    ( all cars data )
 */
function sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx = null, $required_params = [], $use_proxy = true, $keymap = null, $invalid_images = [], $use_custom_site = false, $annoy_func = null)
{
    global $proxy_list;

    if (!$site) {
        slecho("Proper domain url or sitemap url is needed.");
    }

    if (!$use_custom_site) {
        if (endsiWith($site, '.xml')) {
            $sitemap_url = $site;
        } elseif (endsiWith($site, '/')) {
            $sitemap_url = "{$site}sitemap.xml";
        } else {
            $sitemap_url = "{$site}/sitemap.xml";
        }
    } else {
        $sitemap_url = $site;
    }

    $url_types = classifyURLs(getSitemap("{$sitemap_url}", $use_proxy), ['vdp' => "{$vdp_url_regex}"]);
    slecho(count($url_types) . " URLs found from XML sitemap.");

    $cars        = [];
    $in_cookies  = '';
    $out_cookies = '';

    foreach ($url_types as $currentUrl => $page_type) {
        if ($page_type === 'vdp') {
            slecho("Trying to get data from => " . $currentUrl);
            $car_data        = [];
            $car_data['url'] = $currentUrl;

            if ($use_proxy) {
                $resp = HttpGet($currentUrl, $proxy_list, $use_proxy, $in_cookies, $out_cookies);
            } else {
                $resp = HttpGet($currentUrl);
            }

            if ($resp) {
                foreach ($data_capture_regx_full as $key => $regex) {
                    $match = [];

                    if (preg_match($regex, $resp, $match)) {
                        if (array_key_exists($key, $match)) {
                            $car_data[$key] = trim(strip_tags(str_replace('"', '\"', str_replace("\n", '', $match[$key]))));
                        } else {
                            $car_data[$key] = null;
                        }
                    }
                }

                $match = [];

                if ($images_regx && preg_match_all($images_regx, $resp, $match)) {
                    if (isset($match['img_url'])) {
                        for ($i = 0, $match_len = count($match['img_url']); $i < $match_len; $i++) {
                            $im_part     = $match['img_url'][$i];
                            $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                        }

                        $im_urls                = image_pipe_filter(array_diff($im_urls, $invalid_images));
                        $car_data['all_images'] = implode('|', $im_urls);
                    }
                } elseif ($images_fallback_regx && preg_match_all($images_fallback_regx, $resp, $match)) {
                    if (isset($match['img_url'])) {
                        $im_urls = [];

                        for ($i = 0, $match_len = count($match['img_url']); $i < $match_len; $i++) {
                            $im_part     = $match['img_url'][$i];
                            $im_urls[$i] = urlCombine($car_data['url'], $im_part);
                        }

                        $im_urls                = image_pipe_filter(array_diff($im_urls, $invalid_images));
                        $car_data['all_images'] = implode('|', $im_urls);
                    }
                }

                if (!isset($car_data['stock_type'])) {
                    $car_data['stock_type'] = trim(strtolower(predict_stock_type($car_data)));
                } else {
                    $car_data['stock_type'] = trim(strtolower($car_data['stock_type']));
                }

                if (!isset($car_data['stock_number'])) {
                    $car_data['stock_number'] = md5($car_data['url']);
                }

                if (!(isset($car_data['price']) && isProperPrice($car_data['price']))) {
                    $car_data['price'] = "Please Call";
                }

                $car_data['svin'] = url_to_svin($car_data['url'], $required_params);

                if ($annoy_func) {
                    $car_data = $annoy_func($car_data);
                }

                if ($keymap) {
                    $cars[$car_data[$keymap]] = $car_data;
                } else {
                    $cars[] = $car_data;
                }
            } else {
                slecho("No response found from => " . $currentUrl);

                $car_data = [
                    'url'  => $currentUrl,
                    'svin' => url_to_svin($currentUrl, $required_params)
                ];

                if ($keymap) {
                    $cars[$car_data[$keymap]] = $car_data;
                } else {
                    $cars[] = $car_data;
                }
            }
        }
    }

    slecho(count($cars) . " vehicles found.");

    return $cars;
}

/**
 * Get data from XML feed
 *
 * @param      <type>  $xmlurl  The xmlurl
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function xml_crawler($xmlurl)
{
    $xmlstring = HttpGet($xmlurl, true, true);
    $xml       = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);

    return json_decode(json_encode($xml), true);
}

/**
 * Create stock type from kilometres
 *
 * @param integer $kilometres The kilometres
 *
 * @return     string   ( description_of_the_return_value )
 */
function predict_stock_type_from_kilometres($kilometres)
{
    if ($kilometres <= 100) {
        return 'new';
    } else if ($kilometres >= 1000) {
        return 'used';
    } else {
        return null;
    }
}

/**
 * { function_description }
 *
 * @param <type> $title The title
 *
 * @return     string  ( description_of_the_return_value )
 */
function predict_stock_type_from_title($title)
{
    $title = strtolower($title);

    if (strContains($title, 'used') || strContains($title, 'preowned') || strContains($title, 'pre-owned')) {
        return 'used';
    } else if (strContains($title, 'certified')) {
        return 'certified';
    } else if (strContains($title, 'new') || strContains($title, 'demo')) {
        return 'new';
    } else {
        return null;
    }
}

/**
 * { function_description }
 *
 * @param <type> $url The url
 *
 * @return     string  ( description_of_the_return_value )
 */
function predict_stock_type_from_url($url)
{
    if (strContains($url, 'used') || strContains($url, 'preowned') || strContains($url, 'pre-owned')) {
        return 'used';
    } else if (strContains($url, 'certified')) {
        return 'certified';
    } else if (strContains($url, 'new') || strContains($url, 'demo')) {
        return 'new';
    } else {
        return null;
    }
}

/**
 * Assumes the stock type from url, title, kilometres
 *
 * @param <type> $carData The car data
 */
function predict_stock_type($carData)
{
    $stock_type = predict_stock_type_from_url($carData['url']);

    if (!$stock_type) {
        $stock_type = predict_stock_type_from_title($carData['title']);

        if (!$stock_type) {
            $stock_type = predict_stock_type_from_kilometres((int) ($carData['kilometres']));
        }
    }

    if (!$stock_type) {
        return 'new';
    }

    return $stock_type;
}

/**
 * { function_description }
 *
 * @param <type> $vinList The vin list
 *
 * @return     array   ( description_of_the_return_value )
 */
function va_group_api_data($vinList)
{
    $baseUrl = "https://engine.drivemotors.com/inventory?";

    foreach ($vinList as $vin) {
        $baseUrl .= 'vin=' . $vin . '&';
    }

    $baseUrl = rtrim($baseUrl, '&');
    $cookies = '';
    $proxy   = true;
    slecho("API : " . $baseUrl);
    // $res = HttpGet($baseUrl, $proxy, $proxy, $cookies, $cookies);
    $res  = HttpGet($baseUrl);
    $cars = [];
    $json = json_decode($res);

    foreach ($json as $obj) {
        $car = [
            "stock_type"     => ($obj->isNew) ? 'new' : 'used',
            "year"           => $obj->style->year,
            "make"           => $obj->make->slug,
            "model"          => $obj->model->slug,
            "trim"           => $obj->style->trim,
            "stock_number"   => $obj->dealerStockCode,
            "vin"            => $obj->vin,
            "url"            => $obj->urlVDP,
            "price"          => $obj->priceCents / 100,
            "engine"         => $obj->motor->name,
            "cylinder"       => $obj->motor->cylinders,
            "transmission"   => $obj->transmission->name,
            "fuel_type"      => $obj->sourceFuelType,
            "exterior_color" => ($obj->exteriorColor->mfgrName == "Unknown Color") ? "" : $obj->exteriorColor->mfgrName,
            "interior_color" => ($obj->interiorColor->mfgrName == "Unknown Color") ? "" : $obj->exteriorColor->mfgrName,
            "body_style"     => $obj->style->allBodyTypes,
            "doors"          => $obj->style->doors,
            "kilometres"     => $obj->miles,
            "drivetrain"     => $obj->style->drivenWheels,
            "description"    => strip_tags($obj->dealerOption[0]->description),
        ];

        $cars[$obj->vin] = $car;
    }

    return $cars;
}

/**
 * { function_description }
 *
 * @param <type> $cars The cars
 *
 * @return     array   ( description_of_the_return_value )
 */
function generate_vinlist($cars)
{
    $vinList = [];

    foreach ($cars as $car) {
        if (isset($car['vin']) && !empty($car['vin']) && strlen($car['vin']) == 17) {
            $vinList[] = $car['vin'];
        }
    }

    return $vinList;
}

/**
 * s3SaveFile save file to s3 bucket
 *
 * @param mixed $key
 * @param mixed $file_path
 * @param mixed $bucket
 * @param string $s3_config
 * @param mixed $
 */
function s3SaveFile($key, $file_path, $bucket, $s3_config = ["region" => "us-east-1", 'version' => '2006-03-01'])
{

    $s3_client = new S3Client($s3_config);
    $prop      = array(
        'Bucket' => $bucket,
        'Key'    => $key,
        'Body'   => file_get_contents($file_path),
    );

    try {
        $result = $s3_client->putObject($prop);
    } catch (S3Exception $e) {
        print_r($e->getMessage());

        return false;
    }

    return $result;
}

/**
 * s3GetUrl - Get pre signed url for s3 object
 *
 * @param mixed $key
 * @param mixed $bucket
 * @param string $time
 * @param array $s3_config
 * @return string | bool
 */
function s3GetUrl($key, $bucket, $time = '+20 minutes', $s3_config = ["region" => "us-east-1", 'version' => '2006-03-01'])
{
    $s3_client = new S3Client($s3_config);

    $prop = array(
        'Bucket' => $bucket,
        'Key'    => $key,
    );

    try {
        $result = $s3_client->getCommand('getObject', $prop);
    } catch (S3Exception $e) {
        print_r($e->getMessage());
        return false;
    }

    $result = $s3_client->createPresignedRequest($result, $time);
    $url    = (string) $result->getUri();
    return $url;
}

function invalidateCache($type, $dealership)
{
    $domains = get_keys("dealer_domain", $dealership);

    switch ($type) {
        case "dealer_data":
            $paths = [];
            foreach ($domains as $domain) {
                $paths[] = "/tag_api/dealer_data-{$domain}.json";
            }
            break;
        case "page_data":
            $paths = [];
            foreach ($domains as $domain) {
                $paths[] = "/tag_api/{$domain}/*.json";
            }
            break;
    }

    $config = ["region" => "us-east-1", 'version' => '2015-07-27'];
    $client = new CloudFrontClient($config);
    $args   = [
        'DistributionId'    => "E2AE4BSW2VTSIM",
        'InvalidationBatch' => [
            'CallerReference' => $dealership . "-" . time(),
            'Paths'           => [
                'Items'    => $paths,
                'Quantity' => count($paths),
            ],
        ],
    ];

    $resp = $client->createInvalidation($args);

    return $resp;
}

/**
 * Increases or decreases the brightness of a color by a percentage of the current brightness.
 *
 * @param string $hexCode Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
 * @param float $adjustPercent A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
 *
 * @return  string
 */
function adjustHexColorBrightness($hexCode, $adjustPercent)
{
    $hexCode = ltrim($hexCode, '#');

    if (strlen($hexCode) == 3) {
        $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as &$color) {
        $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
        $adjustAmount    = ceil($adjustableLimit * $adjustPercent);

        $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
}

/**
 * add_query_arg
 *
 * add_query_arg( array(
 *   'key1' => 'value1',
 *   'key2' => 'value2',
 * ), 'http://example.com' );
 *
 * @param mixed $params
 * @param mixed $url
 */
function add_query_arg($params, $url = false)
{
    // If $url wasn't passed in, use the current url
    if ($url == false) {
        $scheme = $_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https';
        $url    = "{$scheme}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    // Parse the url into pieces
    $url_array = parse_url($url);

    // The original URL had a query string, modify it.
    if (!empty($url_array['query'])) {
        parse_str($url_array['query'], $query_array);

        $query_array = array_merge($query_array, $params);
    } // The original URL didn't have a query string, add it.
    else {
        $query_array = $params;
    }

    return $url_array['scheme'] . '://' . $url_array['host'] . $url_array['path'] . '?' . http_build_query($query_array) . (!empty($url_array['fragment']) ? "#{$url_array['fragment']}" : '');
}

function delete_query_arg($params, $url = false)
{
    // If $url wasn't passed in, use the current url
    if ($url == false) {
        $scheme = $_SERVER['SERVER_PORT'] == 80 ? 'http' : 'https';
        $url    = "{$scheme}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    }

    // Parse the url into pieces
    $url_array = parse_url($url);

    // The original URL had a query string, modify it.
    if (!empty($url_array['query'])) {
        parse_str($url_array['query'], $query_array);
        $query_array = array_filter($query_array, function ($k) use ($params) {
            return !in_array($k, $params);
        }, ARRAY_FILTER_USE_KEY);

    }

    $query_str = http_build_query($query_array);

    return $url_array['scheme'] . '://' . $url_array['host'] . $url_array['path'] . ($query_str ? "?$query_str" : "") . (!empty($url_array['fragment']) ? "#{$url_array['fragment']}" : '');
}

function calculateVINCheckSumDigit($a, $b, $c)
{

}

/**
 * Generates a fake VIN that looks like real and checks true in vin validation software.
 *
 * @return     string  ( description_of_the_return_value )
 */
function generateOriginalLookAlikeVIN()
{
    $selection   = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    $numbersOnly = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    $out         = '';

    for ($i = 1; $i <= 8; $i++) {
        $out .= $selection[mt_rand(0, 32)];
    }

    $out .= 0;

    for ($i = 10; $i <= 11; $i++) {
        $out .= $selection[mt_rand(0, 32)];
    }

    for ($i = 12; $i <= 17; $i++) {
        $out .= $numbersOnly[mt_rand(0, 9)];
    }

    $fakeVIN         = $out;
    $fakeTransVIN    = transliterateVIN($fakeVIN);
    $fakeWeightedVIN = weightedVIN($fakeTransVIN);
    $fakeWeightedSum = array_sum($fakeWeightedVIN);
    $fakeRemainder   = $fakeWeightedSum % 11;

    if ($fakeRemainder == 10) {
        $fakeRemainder = 'X';
    }

    $fakeVIN = substr_replace($fakeVIN, $fakeRemainder, 8, 1);

    return $fakeVIN;
}

/**
 * { Determines whether a VIN is valid }
 *
 * VIN
 * Positions 1-3    : World Manufacturer Identifier (WMI)
 * Positions 4-8    : Vehicle Descriptor Section (VDS)
 * Position 9       : The Check Digit / Vehicle Checksum
 * Position 10      : Model Year
 * Position 11      : The Manufacturing Plant
 * Positions 12-17  : The Serial Number
 *
 * JTHKD5BH0F2123456
 * JTH      = { Geographic: "Asia, Japan", Make: "Lexus"}
 * K        = { Body & Drive Type: "5 Door Liftback, FWD" }
 * D        = { Engine: "1.8L Hybrid Gasoline Engine"}
 * 5        = { Restraint: "Front, Knee, Side and Curtain Airbags"}
 * BH       = { Model: "CT 200h"}
 * 0        = { CheckSum: "0"}
 * F        = { Year: "2015"}
 * 2        = { Plant: "Kyushu, Japan"}
 * 123456   = { Serial Number: "123456"}
 *
 * @param <type> $vin The vin
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function isValidVIN($vin)
{
    // VIN should be uppercase
    $vin = strtoupper($vin);

    // Check length
    if (strlen($vin) !== 17) {
        return false;
    }

    // Check for invalid characters
    if (strContains($vin, "I") || strContains($vin, "O") || strContains($vin, "Q")) {
        return false;
    }

    // Check CheckSum Digit
    $checkSum = substr($vin, 8, 1);

    if (!strContains("0123456789X", $checkSum)) {
        return false;
    }

    // Transliteration
    $transVIN = transliterateVIN($vin);

    // Compute Weighted Products
    $weightedVIN = weightedVIN($transVIN);

    // Compute Sum of Weighted Products
    $weightedSum = array_sum($weightedVIN);

    // Compute Remainder
    $remainder = $weightedSum % 11;

    if ($remainder == 10) {
        $remainder = "X";
    }

    // Compare Remainder to Check Digit
    if ($remainder != $checkSum) {
        return false;
    }

    return true;
}

/**
 * { Transliterates VIN using a mapping table. }
 *
 * @param <type> $vin The vin
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function transliterateVIN($vin)
{
    $transliterationTable = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
        'D' => 4,
        'E' => 5,
        'F' => 6,
        'G' => 7,
        'H' => 8,
        'J' => 1,
        'K' => 2,
        'L' => 3,
        'M' => 4,
        'N' => 5,
        'P' => 7,
        'R' => 9,
        'S' => 2,
        'T' => 3,
        'U' => 4,
        'V' => 5,
        'W' => 6,
        'X' => 7,
        'Y' => 8,
        'Z' => 9,
    ];

    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $vin);
}

/**
 * { Returns weighted VIN parts }
 *
 * @param <type> $transVIN The transaction vin
 */
function weightedVIN($transVIN)
{
    $transVINparts = str_split($transVIN);
    $weightedVIN   = [];

    $weightTable = [
        0  => 8,
        1  => 7,
        2  => 6,
        3  => 5,
        4  => 4,
        5  => 3,
        6  => 2,
        7  => 10,
        8  => 0,
        9  => 9,
        10 => 8,
        11 => 7,
        12 => 6,
        13 => 5,
        14 => 4,
        15 => 3,
        16 => 2,
    ];

    foreach ($transVINparts as $key => $value) {
        $weightedVIN[$key] = $value * $weightTable[$key];
    }

    return $weightedVIN;
}

/**
 * { function_description }
 *
 * @param float $principal The principal
 * @param float $yearly_interest_rate The interest rate    if 9.5% send
 *                                             9.5
 * @param float $time_in_years The time in years
 * @param string $emi_period_size The emi period size
 *
 * $emi_period_size = DAILY, WEEKLY, BIWEEKLY, SEMIMONTHLY, MONTHLY, BIMONTHLY,
 * TRIMONTHLY, QUARTERLY, HALFYEARLY, YEARLY
 *
 * @param integer $number_of_payments The number of payments
 *
 * EMI = P*r*(1+r)^n/((1+r)^n-1)
 *
 * @return     array    ( description_of_the_return_value )
 */
function EMI_calculator($principal, $yearly_interest_rate, $time_in_years, $emi_period_size = 'WEEKLY', $number_of_payments = 0)
{
    $one_year_in_days = 365.25; // Assuming 1 year = 365.25 days

    $period_chart = [
        'DAILY'       => 1,
        'WEEKLY'      => 7,
        'BIWEEKLY'    => 14,
        'SEMIMONTHLY' => 15,
        'MONTHLY'     => $one_year_in_days / 12, // Assuming 1 year = 365.25 days
        'BIMONTHLY'   => $one_year_in_days / 6, // Assuming 1 year = 365.25 days
        'TRIMONTHLY'  => $one_year_in_days / 4, // Assuming 1 year = 365.25 days
        'QUARTERLY'   => $one_year_in_days / 3, // Assuming 1 year = 365.25 days
        'HALFYEARLY'  => $one_year_in_days / 2, // Assuming 1 year = 365.25 days
        'YEARLY'      => $one_year_in_days, // Assuming 1 year = 365.25 days
    ];

    if (!$number_of_payments) {
        $number_of_payments = round(($time_in_years * $one_year_in_days / $period_chart[$emi_period_size]), 0);
    }

    $number_of_payments_per_year = round($number_of_payments / $time_in_years, 0);

    $interest_rate  = $yearly_interest_rate / ($number_of_payments_per_year * 100); // effective_interest_rate
    $complex_factor = pow((1 + $interest_rate), $number_of_payments);

    $emi_amount = round(($principal * $interest_rate * $complex_factor / ($complex_factor - 1)), 2);

    $total_payment = $emi_amount * $number_of_payments;

    $emi_report = [
        'emi'                  => $emi_amount,
        'number_of_payments'   => $number_of_payments,
        'total_payment'        => $total_payment,
        'total_interest'       => $total_payment - $principal,
        'principal'            => $principal,
        'yearly_interest_rate' => $yearly_interest_rate . '%',
    ];

    return $emi_report;
}

/**
 * Gets the currency.
 *
 * @param      string  $country  The country
 *
 * @return     string  The currency.
 */
function get_currency($country)
{
    if ($country == 'USA') {
        return 'USD';
    } else if ($country == 'New Zealand') {
        return 'NZD';
    } else if ($country == 'Australia') {
        return 'AUD';
    } else {
        return 'CAD';
    }
}

/**
 * Gets the mileage.
 *
 * @param      string  $country  The country
 *
 * @return     string  The mileage.
 */
function get_mileage($country)
{
    if ($country == 'USA') {
        return 'MI';
    } else if ($country == 'New Zealand') {
        return 'KM';
    } else if ($country == 'Australia') {
        return 'KM';
    } else {
        return 'KM';
    }
}

/**
 * { function_description }
 *
 * @param      string  $cmd    The command
 */
function execInBackground($cmd)
{
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B {$cmd}", "r"));
    } else {
        exec("{$cmd} > /dev/null &");
    }
}

/*
 * Calculate Engagement
 *
 * @param      <type>   $cron_name     The cron name
 * @param      integer  $engaged       The engaged
 * @param      <type>   $engaged_data  The engaged data
 *
 * @return     <type>   ( description_of_the_return_value )
 */
function calEngagement($cron_name, $engaged, &$engaged_data)
{

    $db_connect = DbConnect::get_connection_read();

    $scrapper_table   = "{$cron_name}_scrapped_data";
    $query            = "SELECT SUM(engaged_vdp.count) AS engaged, title, deleted, vdp_url, stock_number FROM engaged_vdp JOIN $scrapper_table ON engaged_vdp.vdp_url = {$scrapper_table}.url WHERE dealership = '{$cron_name}' AND deleted = 0 GROUP BY vdp_url;";
    $engaged_query    = $db_connect->query($query);
    $total_engagement = 0;
    $i                = 0;
    while ($record = mysqli_fetch_assoc($engaged_query)) {
        $i++;
        $total_engagement += $record['engaged'];
        $engaged_data[$record['vdp_url']] = $record['engaged'];
    }
    $avg = round($total_engagement / $i);

    return round(($avg * $engaged) / 50);
}

/**
 * Calculates the engagement.
 *
 * @param      <type>   $cron_name  The cron name
 * @param      integer  $engaged    The engaged
 *
 * @return     <type>   The engagement.
 */
function calculateEngagement($cron_name, $engaged)
{
    $db_connect     = DbConnect::get_connection_read();
    $scrapper_table = "{$cron_name}_scrapped_data";
    $query          = "SELECT AVG(engaged) as engaged FROM {$scrapper_table} WHERE deleted = 0;";
    $engaged_query  = $db_connect->query($query);
    $avg_engagement = 0;

    while ($record = mysqli_fetch_assoc($engaged_query)) {
        $avg_engagement = $record['engaged'];
    }

    return round(($avg_engagement * $engaged) / 50);
}

/**
 * { function_description }
 *
 * @param      string  $str    The string
 *
 * @return     string  ( description_of_the_return_value )
 */
function ifArrayAsString(string $str)
{
    if (strContains($str, '[') && strContains($str, ']') && strContains($str, ',')) {
        $start = stripos($str, "'");
        $end   = stripos($str, ",");
        return substr($str, $start + 1, $end - $start - 2);
    } else {
        return $str;
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $url           The url
 * @param      bool    $random_proxy  The random proxy
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function lameHttp($url, $random_proxy = false)
{
    global $proxy_list;

    if ($random_proxy) {
        $proxString = getRandomProxy($proxy_list);
    } else {
        $proxString = getSequentialProxy($proxy_list);
    }

    $proxy_parts   = explode(':', $proxString);
    $proxyIP       = $proxy_parts[0];
    $proxyPort     = $proxy_parts[1];
    $proxyUsername = $proxy_parts[2];
    $proxyPassword = $proxy_parts[3];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_PROXY, $proxyIP);
    curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$proxyUsername}:{$proxyPassword}");

    $output = curl_exec($ch);

    return $output;
}

/**
 * { function_description }
 *
 * @param      <type>  $url    The url
 *
 * @return     string  ( description_of_the_return_value )
 */
function forceHTTPS($url)
{
    if (startsiWith($url, 'http://')) {
        return str_replace('http://', 'https://', $url);
    }

    if (startsiWith($url, 'www.')) {
        return 'https://' . $url;
    }
}

/**
 * Determines if proper price.
 *
 * @param      <type>   $price  The price
 * @param      integer  $min    The minimum
 * @param      integer  $max    The maximum
 *
 * @return     boolean  True if proper price, False otherwise.
 */
function isProperPrice($price, $min = 1, $max = 1000000)
{
    $price_number = numarifyPrice($price);

    if ($price_number < $min || $price_number > $max) {
        return false;
    }

    return true;
}

/**
 * Gets the vdps from sitemap.
 *
 * @param      <type>  $siteOrSitemap  The site or sitemap
 * @param      <type>  $vdp_url_regex  The vdp url regular expression
 *
 * @return     array   The vdps from sitemap.
 */
function get_vdps_from_sitemap($siteOrSitemap, $vdp_url_regex)
{
    if (!$siteOrSitemap) {
        slecho("Proper domain url or sitemap url is needed.");
    }

    if (!$vdp_url_regex) {
        slecho("VDP URL regex is required.");
    }

    if (endsiWith($siteOrSitemap, '.xml')) {
        $sitemap_url = $siteOrSitemap;
    } else {
        $sitemap_url = "{$siteOrSitemap}/sitemap.xml";
    }

    $url_types = classifyURLs(getSitemap("{$sitemap_url}"), ['vdp' => "{$vdp_url_regex}"]);
    $vdp_urls  = [];

    foreach ($url_types as $currentUrl => $page_type) {
        if ($page_type === 'vdp') {
            $vdp_urls[] = $currentUrl;
        }
    }

    return $vdp_urls;
}

/**
 * Gets the images from vdp.
 *
 * @param      <type>  $vdp_url               The vdp url
 * @param      <type>  $images_regx           The images regx
 * @param      <type>  $images_fallback_regx  The images fallback regx
 *
 * @return     string  The images from vdp.
 */
function get_images_from_vdp($vdp_url, $images_regx, $images_fallback_regx, $invalid_images = [])
{
    $resp       = HttpGet($vdp_url, true, true);
    $match      = [];
    $all_images = '';

    if ($images_regx && preg_match_all($images_regx, $resp, $match)) {
        if (isset($match['img_url'])) {
            for ($i = 0, $match_len = count($match['img_url']); $i < $match_len; $i++) {
                $im_part     = $match['img_url'][$i];
                $im_urls[$i] = urlCombine($vdp_url, $im_part);
            }

            $im_urls    = image_pipe_filter(array_diff($im_urls, $invalid_images));
            $all_images = implode('|', $im_urls);
        }
    } elseif ($images_fallback_regx && preg_match_all($images_fallback_regx, $resp, $match)) {
        if (isset($match['img_url'])) {
            $im_urls = [];

            for ($i = 0, $match_len = count($match['img_url']); $i < $match_len; $i++) {
                $im_part     = $match['img_url'][$i];
                $im_urls[$i] = urlCombine($vdp_url, $im_part);
            }

            $im_urls    = image_pipe_filter(array_diff($im_urls, $invalid_images));
            $all_images = implode('|', $im_urls);
        }
    }

    return $all_images;
}

/**
 * { function_description }
 *
 * @param      string  $dir     The dir
 * @param      string  $prefix  The prefix
 */
function listFolderFiles($dir, $prefix = "")
{
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1) {
        return;
    }

    foreach ($ffs as $ff) {
        echo $prefix . $ff . "\n";

        if (is_dir($dir . '/' . $ff)) {
            listFolderFiles($dir . '/' . $ff, $prefix . $prefix);
        }
    }
}

/**
 * Scans a dir.
 *
 * @param      <type>  $path                   The path
 * @param      array   $allowed_extensions     The allowed extensions
 * @param      array   $disallowed_extensions  The disallowed extensions
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function scan_dir($path, $allowed_extensions = [], $disallowed_extensions = [])
{
    $ite = new RecursiveDirectoryIterator($path);

    $bytestotal = 0;
    $nbfiles    = 0;

    foreach (new RecursiveIteratorIterator($ite) as $filename => $cur) {
        $filesize = $cur->getSize();
        $bytestotal += $filesize;

        // prevent empty ordered elements
        if (endsWith($filename, ".") || endsWith($filename, "..")) {
            continue;
        }

        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Handle whitelisted extensions
        if (!empty($allowed_extensions) && !in_array($ext, $allowed_extensions)) {
            continue;
        }

        // Handle blacklisted extensions
        if (!empty($disallowed_extensions) && in_array($ext, $disallowed_extensions)) {
            continue;
        }

        $nbfiles++;
        $files[] = $filename;
    }

    $bytestotal = number_format($bytestotal);

    return ['total_files' => $nbfiles, 'total_size' => $bytestotal, 'files' => $files];
}

/**
 * { function_description }
 *
 * @param      <type>  $folder  The folder
 *
 * @return     bool    ( description_of_the_return_value )
 */
function folder_exist($folder)
{
    $path = realpath($folder);

    return ($path !== false and is_dir($path)) ? $path : false;
}

/**
 * Removes an url fragment.
 *
 * @param      string  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function remove_url_fragment($url = '')
{
    $parts = parse_url($url);

    return $parts['scheme'] . '://' .
        (isset($parts['user']) ? $parts['user'] . ':' . '' . $parts['pass'] . '@' : '')
        . $parts['host'] .
        (isset($parts['port']) ? ':' . $parts['port'] : '')
        . $parts['path'] .
        (isset($parts['query']) ? '?' . $parts['query'] : '');
}

/**
 * Determines whether the specified year is leap year.
 *
 * @param      int   $year   The year
 *
 * @return     bool  True if the specified year is leap year, False otherwise.
 */
function isLeapYear($year)
{
    if ($year % 4 == 0) {
        if ($year % 100 == 0) {
            if ($year % 400 == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/**
 * Gets the months in range.
 *
 * @param      string  $startDate  The start date
 * @param      <type>  $endDate    The end date
 *
 * @return     array   The months in range.
 */
function getMonthsInRange($startDate, $endDate)
{
    $months = [];

    while (strtotime($startDate) <= strtotime($endDate)) {
        $month                        = date('m', strtotime($startDate));
        $year                         = date('Y', strtotime($startDate));
        $months[$month . '-' . $year] = [
            'month' => $month,
            'year'  => $year,
        ];

        $startDate = date('01 M Y', strtotime($startDate . '+ 1 month'));
    }

    return $months;
}

/**
 * { function_description }
 *
 * @param      <type>  $remote_url  The remote url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function remote_file_time($remote_url)
{
    $curl = curl_init($remote_url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FILETIME, true);

    $result = curl_exec($curl);

    if ($result === false) {
        die(curl_error($curl));
    }

    $timestamp = curl_getinfo($curl, CURLINFO_FILETIME);

    return $timestamp;
}

/**
 * Gets the redirected url.
 *
 * @param      <type>  $url    The url
 *
 * @return     <type>  The redirected url.
 */
function getRedirectedUrl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseHeaders = curl_exec($ch);
    $redirected_url  = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);

    return $redirected_url;
}

/**
 * get_redirect_url()
 * Gets the address that the provided URL redirects to,
 * or FALSE if there's no redirect.
 *
 * @param string $url
 * @return string
 */
function get_redirect_url($url)
{
    $redirect_url = null;

    $url_parts = @parse_url($url);
    if (!$url_parts) {
        return false;
    }

    if (!isset($url_parts['host'])) {
        return false;
    }
    //can't process relative URLs
    if (!isset($url_parts['path'])) {
        $url_parts['path'] = '/';
    }

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int) $url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) {
        return false;
    }

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?' . $url_parts['query'] : '') . " HTTP/1.1\r\n";
    $request .= 'Host: ' . $url_parts['host'] . "\r\n";
    $request .= "Connection: Close\r\n\r\n";
    fwrite($sock, $request);
    $response = '';
    while (!feof($sock)) {
        $response .= fread($sock, 8192);
    }

    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)) {
        if (substr($matches[1], 0, 1) == "/") {
            return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        } else {
            return trim($matches[1]);
        }
    } else {
        return false;
    }

}

/**
 * get_all_redirects()
 * Follows and collects all redirects, in order, for the given URL.
 *
 * @param string $url
 * @return array
 */
function get_all_redirects($url)
{
    $redirects = [];

    while ($newurl = get_redirect_url($url)) {
        if (in_array($newurl, $redirects)) {
            break;
        }
        $redirects[] = $newurl;
        $url         = $newurl;
    }

    return $redirects;
}

/**
 * get_final_url()
 * Gets the address that the URL ultimately leads to.
 * Returns $url itself if it isn't a redirect.
 *
 * @param string $url
 * @return string
 */
function get_final_url($url)
{
    $redirects = get_all_redirects($url);
    if (count($redirects) > 0) {
        return array_pop($redirects);
    } else {
        return $url;
    }
}

/**
 * Gets the nearest timezone.
 *
 * @param      <type>  $cur_lat       The current lat
 * @param      int     $cur_long      The current long
 * @param      string  $country_code  The country code
 *
 * @return     string  The nearest timezone.
 */
function get_nearest_timezone($cur_lat, $cur_long, $country_code = '')
{
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
    : DateTimeZone::listIdentifiers();

    if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone   = '';
        $tz_distance = 0;

        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {
            foreach ($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];
                $theta    = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                     + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                }
            }
        }

        return $time_zone;
    }

    return null;
}

/**
 * Gets the timehour from timezone.
 *
 * @param      <type>  $time_zone  The time zone
 *
 * @return     array   The timehour from timezone.
 */
function get_timehour_from_timezone($time_zone)
{
    if (!$time_zone) {
        return null;
    }

    $timezone_vs_hour = [
        'America/Detroit'                => 'UTC -5',
        'America/Indiana/Indianapolis'   => 'UTC -5',
        'America/Indiana/Marengo'        => 'UTC -5',
        'America/Indiana/Petersburg'     => 'UTC -5',
        'America/Indiana/Vevay'          => 'UTC -5',
        'America/Indiana/Vincennes'      => 'UTC -5',
        'America/Indiana/Winamac'        => 'UTC -5',
        'America/Kentucky/Monticello'    => 'UTC -5',
        'America/Kentucky/Louisville'    => 'UTC -5',
        'America/New_York'               => 'UTC -5',

        'America/Chicago'                => 'UTC -6',
        'America/Indiana/Knox'           => 'UTC -6',
        'America/Indiana/Tell_City'      => 'UTC -6',
        'America/Menominee'              => 'UTC -6',
        'America/North_Dakota/Beulah'    => 'UTC -6',
        'America/North_Dakota/Center'    => 'UTC -6',
        'America/North_Dakota/New_Salem' => 'UTC -6',

        'America/Boise'                  => 'UTC -7',
        'America/Denver'                 => 'UTC -7',
        'America/Phoenix'                => 'UTC -7',

        'America/Los_Angeles'            => 'UTC -8',

        'America/Anchorage'              => 'UTC -9',
        'America/Juneau'                 => 'UTC -9',
        'America/Metlakatla'             => 'UTC -9',
        'America/Nome'                   => 'UTC -9',
        'America/Sitka'                  => 'UTC -9',
        'America/Yakutat'                => 'UTC -9',

        'America/Adak'                   => 'UTC -10',
        'Pacific/Honolulu'               => 'UTC -10',
    ];

    return $timezone_vs_hour[$time_zone];
}

/**
 * { function_description }
 *
 * @param      <type>  $getUrl  The get url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function gzippedGet($getUrl)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers   = [];
    $headers[] = 'Accept-Encoding: gzip';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    return $result;
}

/**
 * { function_description }
 *
 * @param      <type>  $cron_name  The cron name
 */
function clearTagApiCache($cron_name)
{
    try {
        // Remove files from efs
        $page_data_cache_dir = __DIR__ . "/dealer_cache/dealer_data/{$cron_name}";

        if (is_dir($page_data_cache_dir)) {
            array_map('unlink', glob("{$page_data_cache_dir}/*.*"));
            rmdir($page_data_cache_dir);
            slecho("CACHE_CLEARING: All files inside '{$page_data_cache_dir}' has been deleted");
        }

        // Clear cloudfront cache
        $page_data_resp   = invalidateCache("page_data", $cron_name);
        $dealer_data_resp = invalidateCache("dealer_data", $cron_name);
        slecho("CACHE_CLEARING: Cloud front invalidation done.");

    } catch (Exception $ex) {
        slecho("CACHE_CLEARING: FAILED to invalidate cache for {$cron_name}.");
    }
}


/**
 * Gets the active smart offer clients.
 */
function getActiveSmartOfferClients() {
	global $CronConfigs;
    $active_smart_offer = [];

    foreach ($CronConfigs as $cron => $config) {
        if (isset($config['lead']) &&
            ($config['lead']['live'] ||
                (isset($config['lead']['new']) && $config['lead']['new']['live']) ||
                (isset($config['lead']['used']) && $config['lead']['used']['live']) ||
                (isset($config['lead']['service']) && $config['lead']['service']['live']))) {
            $active_smart_offer[] = $cron;
        }
    }

    return $active_smart_offer;
}

function stringSanitizer($input) {
    $rgx = '/[^(\x20-\x7F)\x0A\x0D]*/';
    $output = str_replace($badStrRegex, '', $input);

    return $output;
}

function replaceAccents($str)
{
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í',
               'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü',
               'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë',
               'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û',
               'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ',
               'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę',
               'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ',
               'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ',
               'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń',
               'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ',
               'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š',
               'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů',
               'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž',
               'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ',
               'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ',
               'ǿ', '€', '™', '˜');
    $b = array('');
    return str_replace($a, $b, $str);
}

function recurseCopy(
    string $sourceDirectory,
    string $destinationDirectory,
    string $childFolder = ''
): void {
    $directory = opendir($sourceDirectory);

    if (is_dir($destinationDirectory) === false) {
        mkdir($destinationDirectory);
    }

    if ($childFolder !== '') {
        if (is_dir("$destinationDirectory/$childFolder") === false) {
            mkdir("$destinationDirectory/$childFolder");
        }

        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir("$sourceDirectory/$file") === true) {
                recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            } else {
                copy("$sourceDirectory/$file", "$destinationDirectory/$childFolder/$file");
            }
        }

        closedir($directory);

        return;
    }

    while (($file = readdir($directory)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_dir("$sourceDirectory/$file") === true) {
            recurseCopy("$sourceDirectory/$file", "$destinationDirectory/$file");
        }
        else {
            copy("$sourceDirectory/$file", "$destinationDirectory/$file");
        }
    }

    closedir($directory);
}
