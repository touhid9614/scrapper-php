<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $scrapper_configs;

$dealers            = 'https://api-dev.smedia.ca/v1/dealer';
$useProxy           = true;
$in_cookies         = '';
$content_type       = 'application/x-www-form-urlencoded';
$additional_headers = ['masterToken' => '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b'];
$resp               = json_decode(HttpGet($dealers, $useProxy, $useProxy, $in_cookies, $in_cookies, $content_type, $additional_headers), true);

foreach ($resp as $dealerData) {
    $id           = $dealerData['id'];
    $cron         = $dealerData['cronName'];
    $thisPostUrl  = "https://api-dev.smedia.ca/v1/dealer/{$id}";
    $thisPostData = [
        'vdpURLRegex' => $scrapper_configs[$cron]['vdp_url_regex'],
    ];
    $pin_cookies         = '';
    $pout_cookies        = '';
    $pcontent_type       = 'application/json';
    $padditional_headers = ['masterToken' => '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b'];

    $presp = HttpPost($thisPostUrl, json_encode($thisPostData), $pin_cookies, $pout_cookies, $useProxy, $useProxy, $pcontent_type, $padditional_headers);
}