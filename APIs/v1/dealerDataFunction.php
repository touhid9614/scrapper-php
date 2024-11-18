<?php

global $base_path;

$base_path = dirname(dirname(__DIR__));

/**
 * @param $domain
 * @return array
 */
function blackListCheck($domain)
{
    global $base_path;

    $black_list = "{$base_path}/black-list/{$domain}.txt";
    $ip         = get_all_client_ip();
    $response   = [];

    $response['res'] = false;
    $response['ip']  = $ip;

    if (file_exists($black_list)) {
        $ips = explode("\n", file_get_contents($black_list));

        if (in_array($ip, $ips)) {
            $response['res'] = true;
            return $response;
        }
    }

    return $response;
}

/**
 * @param $url
 * @return string|string[]|null
 */
function domaitoUrl($url)
{
    if (empty($url)) {
        return null;
    }

    // If not have http:// or https:// then prepend it
    if (!preg_match('#^http(s)?://#', $url)) {
        $url = 'http://' . $url;
    }

    $urlParts = parse_url($url);

    // Remove www.
    $domain_name = preg_replace('/^www\./', '', $urlParts['host']);

    // Output
    return $domain_name;
}

/**
 * Gets the cron name by url.
 *
 * @param      <type>         $domain  The domain
 * @param      $domain
 *
 * @return     string[]|null
 */
function getCronNameByUrl($domain)
{
    $query       = "SELECT * FROM dealerships WHERE websites LIKE '%{$domain}%';";
    $result      = DbConnect::get_connection_read()->query($query);
    $resultFinal = mysqli_fetch_assoc($result);

    return $resultFinal;
}

/**
 * Gets the dealer data.
 *
 * @param      <type>         $dealership  The dealership
 * @param      $domain
 *
 * @return     string[]|null
 */
function getDealerData($dealership)
{
    $query       = "SELECT * FROM dealerships WHERE dealership = '{$dealership}';";
    $result      = DbConnect::get_connection_read()->query($query);
    $resultFinal = mysqli_fetch_assoc($result);

    return $resultFinal;
}

/**
 * Gets the multiple tag configuration data.
 *
 * @param      <type>         $website  The website
 * @param      $domain
 *
 * @return     string[]|null
 */
function getMultiTagConfigData($website)
{
    $query       = "SELECT * FROM tag_config WHERE website like '%$website%' AND active = 1;";
    $result      = DbConnect::get_connection_read()->query($query);
    $resultFinal = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($resultFinal[$row['dealership']][$row['tag_type']]) {
            $conf = unserialize($row['config']);

            if ($row['tag_type'] == 'facebook') {
                $conf = fixFbConf($conf);
            }

            array_push($resultFinal[$row['dealership']][$row['tag_type']], [
                'account_id' => $row['account_id'],
                'config'     => $conf,
            ]);
        } else {
            $conf = unserialize($row['config']);

            if ($row['tag_type'] == 'facebook') {
                $conf = fixFbConf($conf);
            }

            $resultFinal[$row['dealership']][$row['tag_type']] = [[
                'account_id' => $row['account_id'],
                'config'     => $conf,
            ]];
        }
    }

    return $resultFinal;
}

/**
 * Gets the single tag configuration.
 *
 * @param      <type>  $dealership  The dealership
 *
 * @return     array   The single tag configuration.
 */
function getSingleTagConfig($dealership)
{
    $query       = "SELECT * FROM tag_config WHERE dealership = '$dealership' AND active = 1;";
    $result      = DbConnect::get_connection_read()->query($query);
    $resultFinal = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($resultFinal[$row['tag_type']]) {
            $conf = unserialize($row['config']);

            if ($row['tag_type'] == 'facebook') {
                $conf = fixFbConf($conf);
            }

            array_push($resultFinal[$row['tag_type']], [
                'account_id' => $row['account_id'],
                'config'     => $conf,
            ]);
        } else {
            $conf = unserialize($row['config']);

            if ($row['tag_type'] == 'facebook') {
                $conf = fixFbConf($conf);
            }

            $resultFinal[$row['tag_type']] = [[
                'account_id' => $row['account_id'],
                'config'     => $conf,
            ]];
        }
    }

    return $resultFinal;
}

/**
 * Make regexes transport safe
 *
 * @param      <type>  $regexSet  The regular expression set
 *
 * @return     array   ( description_of_the_return_value )
 */
function safeRegex($regexSet)
{
    $out = [];

    foreach ($regexSet as $key => $value) {
        $out[$key] = str_replace(['"'], ['\"'], $value);
    }

    return $out;
}

/**
 * Gets the data capture regular expression full.
 *
 * @param      <type>  $scrapper_config  The scrapper configuration
 *
 * @return     array   The data capture regular expression full.
 */
function getDataCaptureRegexFull($scrapper_config)
{
    if (isset($scrapper_config['data_capture_regx_full'])) {
        return safeRegex($scrapper_config['data_capture_regx_full']);
    }

    if (isset($scrapper_config['new']) || isset($scrapper_config['used'])) {
        return [
            'new'  => safeRegex($scrapper_config['new']['data_capture_regx_full']),
            'used' => safeRegex($scrapper_config['used']['data_capture_regx_full']),
        ];
    }

    return null;
}

/**
 * { function_description }
 *
 * @param      <type>  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function smediaUrlEncrypt($url)
{
    $mapping = [
        '%2F' => 'SMEDIA_FORWARD_SLASH',
        '%5C' => 'SMEDIA_BACKWARD_SLASH',
        '%3F' => 'SMEDIA_WHAT',
        '%26' => 'SMEDIA_AMPERSENT',
        '%40' => 'SMEDIA_AT_THE_RATE_OF',
        '%2A' => 'SMEDIA_STAR',
    ];

    return str_replace(array_keys($mapping), array_values($mapping), $url);
}

/**
 * { function_description }
 *
 * @param      <type>  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function smediaUrlDecrypt($url)
{
    $mapping = [
        '%2F' => 'SMEDIA_FORWARD_SLASH',
        '%5C' => 'SMEDIA_BACKWARD_SLASH',
        '%3F' => 'SMEDIA_WHAT',
        '%26' => 'SMEDIA_AMPERSENT',
        '%40' => 'SMEDIA_AT_THE_RATE_OF',
        '%2A' => 'SMEDIA_STAR',
    ];

    return str_replace(array_values($mapping), array_keys($mapping), $url);
}

/**
 * Gets the vehicles.
 *
 * @param      <type>  $dealer  The dealer
 *
 * @return     array   The vehicles.
 */
function getDealerVehicles($dealer, $url_resolve)
{
    $out = [];

    if (!$url_resolve) {
        $url_resolve = [$dealer => ''];
    }

    foreach ($url_resolve as $dealer => $ignore) {
        $query  = "SELECT stock_number, vin, url FROM {$dealer}_scrapped_data WHERE deleted = 0;";
        $result = DbConnect::get_connection_read()->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $out[$row['url']] = [
                'vin'          => $row['vin'],
                'stock_number' => $row['stock_number'],
            ];
        }
    }

    return $out;
}

/**
 * Fixes indexed array issue in fb config
 *
 * @param      <type>  $conf   The conf
 */
function fixFbConf($conf)
{
    $pages = ['vdp', 'srp', 'ty', 'other'];

    foreach ($pages as $pt) {
        $conf[$pt]['fbq'] = array_values($conf[$pt]['fbq']);
    }

    $conf['vdp']['viewcontent'] = array_values($conf['vdp']['viewcontent']);

    return $conf;
}

/**
 * Removes a trail slash.
 *
 * @param      <type>  $str    The string
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function removeTrailSlash($str)
{
    return endsWith($str, '/') ? substr($str, 0, -1) : $str;

}