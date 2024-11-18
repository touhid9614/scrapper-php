<?php

require_once TT_ABSPATH . '/adwords3/tag_db_connect.php';
use Predis\Client as RedisClient;

global $redis, $domain, $CronConfigs, $scrapper_configs;

$redis = new RedisClient($redis_config);
$redis_cache_duration    = 21600;   // 6 hour = 6 * 60 * 60
$v2_redis_cache_duration = 300;     // 5 minute

$smedia_api_host = 'https://api.smedia.ca';

# Cron name
$cron_name_key = "{$domain}_cron_name";
$cron_type_key = "{$domain}_cron_type";

if (($cron_name = $redis->get($cron_name_key)) && ($cron_type = $redis->get($cron_type_key))) {
    if ($debug) {
        echo "\n//Cron name is found in cache: $cron_name\n";
    }

    $cron_name = getVirtualDealer($cron_name, $url);

    if ($debug) {
        echo "\n//Checking dealer virtualization: $cron_name\n";
    }
} else {
    $cron_name = getDomainDealer($domain, $url);
    $redis->set($cron_name_key, $cron_name);
    $redis->expire($cron_name_key, $redis_cache_duration);

    if ($debug) {
        echo "\n//Cron name is pulled from SQL\n";
    }

    $cron_type = $cron_name ? 'FULL' : null;
}

# Check V2 dealer status
$v2_dealerinfo      = null;
$cron_v2_dealer_key = "{$domain}_v2_dealer";

if (($v2_dealerinfo_str = $redis->get($cron_v2_dealer_key))) {
    $v2_dealerinfo = unserialize($v2_dealerinfo_str);

    if ($cron_type != 'FULL' && isset($v2_dealerinfo["success"]) && $v2_dealerinfo["success"]) {
        $cron_type = 'v2';
        $cron_name = $v2_dealerinfo['domain'];
    }

    if ($debug) {
        echo "\n// Cached dealer v2 response: '$v2_dealerinfo_str'\n";
    }
} elseif ($domain) {
    // Pull from API
    $v2_dealerinfo_url = "{$smedia_api_host}/dealerinfo/{$domain}";
    $v2_dealerinfo_str = HttpGet($v2_dealerinfo_url);

    if ($debug) {
        echo "\n// Pulled dealer v2 response from $v2_dealerinfo_url: '$v2_dealerinfo_str'\n";
    }

    if ($v2_dealerinfo_str) {
        $v2_dealerinfo = json_decode($v2_dealerinfo_str, true);

        if ($cron_type != 'FULL' && isset($v2_dealerinfo["success"]) && $v2_dealerinfo["success"]) {
            $cron_type = 'v2';
            $cron_name = $v2_dealerinfo['domain'];
        }

        $redis->set($cron_v2_dealer_key, serialize($v2_dealerinfo));
        $redis->expire($cron_v2_dealer_key, $redis_cache_duration);
    } else {
        $redis->set($cron_v2_dealer_key, serialize([
            'name'    => $cron_name,
            'domain'  => $domain,
            "success" => false,
        ]));

        $redis->expire($cron_v2_dealer_key, $v2_redis_cache_duration);
    }
}

if ($cron_type) {
    $redis->set($cron_type_key, $cron_type);
    $redis->expire($cron_type_key, $redis_cache_duration);
}

# Tag config
$tag_configs_key = "{$cron_name}_tag_configs";

if (($tag_configs_str = $redis->get($tag_configs_key))) {
    $tag_configs = unserialize($tag_configs_str);

    if ($debug) {
        echo "\n// Tag configs are found in cache.\n";
    }
} else {
    $tag_configs = get_meta('tag_configs', $tag_configs_key);
    $redis->set($tag_configs_key, serialize($tag_configs));
    $redis->expire($tag_configs_key, $redis_cache_duration);

    if ($debug) {
        echo "\n// Tag configs are pulled from DB.\n";
    }
}

# Analytics tracking ID
$analytics_tracking_id_key = "{$cron_name}_analytics_tracking_id";

if (($analytics_tracking_id = $redis->get($analytics_tracking_id_key))) {
    if ($debug) {
        echo "\n// Analytics ID is found in cache.\n";
    }
} else {
    $analytics_tracking_id = $cron_name ? get_meta('tracking_ids', $analytics_tracking_id_key) : null;
    $redis->set($analytics_tracking_id_key, $analytics_tracking_id);
    $redis->expire($analytics_tracking_id_key, $redis_cache_duration);

    if ($debug) {
        echo "\n// Analytics ID is pulled from DB.\n";
    }
}

# Facebook pixel ID
$facebook_pixel_id_key = "{$cron_name}_facebook_pixel_id";

if (($facebook_pixel_id = $redis->get($facebook_pixel_id_key))) {
    if ($debug) {
        echo "\n// Facebook Pixel is found in cache.\n";
    }
} else {
    $facebook_pixel_id = $cron_name ? get_meta('tracking_ids', $facebook_pixel_id_key) : null;
    $redis->set($facebook_pixel_id_key, $facebook_pixel_id);
    $redis->expire($facebook_pixel_id_key, $redis_cache_duration);

    if ($debug) {
        echo "\n// Facebook Piexel is pulled from DB.\n";
    }
}

# Bing Tag ID
$bing_tag_id_key = "{$cron_name}_bing_tag_id";

if (($bing_tag_id = $redis->get($bing_tag_id_key))) {
    if ($debug) {
        echo "\n// Bing tag id is found in cache.\n";
    }
} else {
    $bing_tag_id = $cron_name ? get_meta('tracking_ids', $bing_tag_id_key) : null;
    $redis->set($bing_tag_id_key, $bing_tag_id);
    $redis->expire($bing_tag_id_key, $redis_cache_duration);

    if ($debug) {
        echo "\n//Bing tag ID is pulled from DB.\n";
    }
}

# Snapchat pixel ID
$snapchat_pixel_id_key = "{$cron_name}_snapchat_pixel_id";

if (($snapchat_pixel_id = $redis->get($snapchat_pixel_id_key))) {
    if ($debug) {
        echo "\n// Snapchat Pixel is found in cache.\n";
    }
} else {
    $snapchat_pixel_id = $cron_name ? get_meta('tracking_ids', $snapchat_pixel_id_key) : null;
    $redis->set($snapchat_pixel_id_key, $snapchat_pixel_id);    // Was checked and recheck in 1 hours
    $redis->expire($snapchat_pixel_id_key, 3600);               // 1 hour = 1 * 60 * 60

    if ($debug) {
        echo "\n// Snapchat Pixel is pulled from DB.\n";
    }
}

# Adwords tracking ID
$adwords_tracking_id_key = "{$cron_name}_adwords_tracking_id";

if (($adwords_tracking_id = $redis->get($adwords_tracking_id_key))) {
    if ($debug) {
        echo "\n// Adwords tracking ID is found in cache.\n";
    }
} else {
    $adwords_tracking_id = $cron_name ? get_meta('tracking_ids', $adwords_tracking_id_key) : null;
    $redis->set($adwords_tracking_id_key, $adwords_tracking_id);
    $redis->expire($adwords_tracking_id_key, $redis_cache_duration);

    if ($debug) {
        echo "\n// Adwords tracking ID is pulled from DB.\n";
    }
}

if (!$tag_configs) {
    $tag_configs = [
        'vdp'   => [
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
            'install_fbq'           => false,
            'fbq'                   => [],

            'adwords_conversion'    => [
                'id'    => '',
                'label' => '',
            ],

            'additional_scripts'    => [],
        ],

        'ty'    => [
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
            'install_fbq'           => false,
            'fbq'                   => [],

            'adwords_conversion'    => [
                'id'    => '',
                'label' => '',
            ],

            'additional_scripts'    => [],
        ],

        'other' => [
            'install_analytics'     => false,
            'ga'                    => [],
            'profitable_engagement' => false,
            'scroll_depth'          => false,
            'install_fbq'           => false,
            'fbq'                   => [],

            'adwords_conversion'    => [
                'id'    => '',
                'label' => '',
            ],

            'additional_scripts'    => [],
        ],
    ];
}

# Dealer with v2 dealers [No config]
if ($cron_type == 'v2' && $v2_dealerinfo) {
    $CronConfigs[$cron_name] = [
        "name" => $v2_dealerinfo['name'],
    ];

    $scrapper_configs[$cron_name] = [
        'entry_points'  => [],
        'vdp_url_regex' => $v2_dealerinfo['vdpURLRegex'],
    ];

    if ($v2_dealerinfo['analyticsId']) {
        $analytics_tracking_id                       = $v2_dealerinfo['analyticsId'];
        $tag_configs['vdp']['install_analytics']     = true;
        $tag_configs['vdp']['profitable_engagement'] = true;
        $tag_configs['vdp']['ga']                    = ['pageview'];
    }
}

// $install_trade_smart = $v2_dealerinfo && isset($v2_dealerinfo['id']) && isset($v2_dealerinfo['tradeSmart']);

$tradesmart_api_url  = "{$smedia_api_host}/v1/dealer-service/{$domain}/trade-smart";
$tradesmart_api_resp = json_decode(HttpGet($tradesmart_api_url), true);
$install_trade_smart = $tradesmart_api_resp['success'];

# Also update 'tagInstalled'
if ($v2_dealerinfo && isset($v2_dealerinfo['id'])) {
    $request = [];

    if (!$v2_dealerinfo["tagInstalled"]) {
        $request["tagInstalled"] = true;
    }

    if (!$v2_dealerinfo["engagedProspectAvailable"]) {
        $request["engagedProspectAvailable"] = true;
    }

    if (!$v2_dealerinfo['vdpURLRegex'] && $scrapper_configs[$cron_name]['vdp_url_regex']) {
        $request['vdpURLRegex'] = $scrapper_configs[$cron_name]['vdp_url_regex'];
    }

    if (!$v2_dealerinfo["cronName"]) {
        $request["cronName"] = $cron_name;
    }

    if (count(array_keys($request))) {
        $update_url = "{$smedia_api_host}/dealerinfo/{$v2_dealerinfo['id']}";
        $cookies    = '';
        $response   = HttpPost($update_url, json_encode($request), $cookies, $cookies, false, false, 'application/json');

        $req_json = json_encode($request);
        if ($debug) {
            echo "\n//v2 request and response|| URL : $update_url || req : '$req_json' || res : '$response'\n";
        }

        $redis->del($cron_v2_dealer_key); # delete cache so that it's pulled again
    }
}

if (!isset($tag_configs['vdp']['install_analytics'])) {
    $tag_configs['vdp']['install_analytics'] = false;
}

if (!isset($tag_configs['ty']['install_analytics'])) {
    $tag_configs['ty']['install_analytics'] = false;
}

if (!isset($tag_configs['other']['install_analytics'])) {
    $tag_configs['other']['install_analytics'] = false;
}

if (!isset($tag_configs['vdp']['install_fbq'])) {
    $tag_configs['vdp']['install_fbq'] = false;
}

if (!isset($tag_configs['ty']['install_fbq'])) {
    $tag_configs['ty']['install_fbq'] = false;
}

if (!isset($tag_configs['other']['install_fbq'])) {
    $tag_configs['other']['install_fbq'] = false;
}
