<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = $base_dir . "/adwords3/";

echo '<pre>';
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$smedia_api_host = 'https://api-dev.smedia.ca';
$domain          = 'www.barkerkia.com';

$v2_dealerinfo_url = "{$smedia_api_host}/dealerinfo/{$domain}";
$v2_dealerinfo_str = HttpGetUpdate($v2_dealerinfo_url);

sleep(5);
print_r($v2_dealerinfo_str);

if ($v2_dealerinfo_str) {
    $v2_dealerinfo = json_decode($v2_dealerinfo_str, true);
    echo '<br> Data found' . '<br>';
    echo '<pre>';
    print_r($v2_dealerinfo);
} else {
    echo '<br> No Data found' . '<br>';
}

echo "==============";
$domain = 'www.rivershoreram.ca';

$v2_dealerinfo_url = "{$smedia_api_host}/dealerinfo/{$domain}";
$v2_dealerinfo_str = file_get_contents($v2_dealerinfo_url);

print_r($v2_dealerinfo_str);

if ($v2_dealerinfo_str) {
    $v2_dealerinfo = json_decode($v2_dealerinfo_str, true);
    echo '<br> Data found' . '<br>';
    echo '<pre>';
    print_r($v2_dealerinfo);
} else {
    echo '<br> No Data found' . '<br>';
}

echo "==============";
$domain = '';

$v2_dealerinfo_url = "{$smedia_api_host}/dealerinfo/{$domain}";
$v2_dealerinfo_str = file_get_contents($v2_dealerinfo_url);

print_r($v2_dealerinfo_str);

if ($v2_dealerinfo_str) {
    $v2_dealerinfo = json_decode($v2_dealerinfo_str, true);
    echo '<br> Data found' . '<br>';
    echo '<pre>';
    print_r($v2_dealerinfo);
} else {
    echo '<br> No Data found' . '<br>';
}

function HttpGetUpdate($url, $proxyPath = false, $random_proxy = false, $in_cookies = '', &$out_cookies = '')
{
    echo "++++++++++++++++++++++++++++++++++++";
    echo '<br>' . $url . '<br>';
    $curl = commonCurlInit($url);
    echo '<br><b>curl</b><br>';
    print_r($curl);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_COOKIE, $in_cookies);
    sleep(5);
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
    echo '<br><b>contents</b><br>';
    print_r($contents);
    echo '<br><b>header</b><br>';
    print_r($header);
    echo '<br><b>header_content</b><br>';
    print_r($header_content);
    echo '<br><b>body_content</b><br>';
    print_r($body_content);
    if ($curl) {
        curl_close($curl);
    }
    echo "<br><b>Error Code $httpcode</b>";
    if ($httpcode > 400) {
        echo '400' . '<br>';
        return null;
    }

    if ($contents) {
        return $body_content;
    } else {
        echo 'No body content<br>';
        return null;
    }
}

/*
function HttpGetUpdate($url)
{
echo "++++++++++++++++++++++++++++++++++++";
echo '<br>'.$url.'<br>';
$curl = curl_init();

curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_HEADER, false);

$contents       = curl_exec($curl);

echo '<br><b>contents</b><br>';
print_r($contents);

if ($curl) {
curl_close($curl);
}

if ($contents) {
return $contents;
} else {
echo 'No body content<br>';
return null;
}
}
 */
