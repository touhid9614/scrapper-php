<?php

//nasty hack to fix issue introduced by intermediate update
global $argv;

$argv['2'] = true;

function logme($data)
{
    $data = null;
}

function get_domain_unique_entry_urls(DbConnect $db_connect, $scrapper_config, $return_domain = false)
{
    $entry_points    = [];
    $checked_domains = [];

    foreach ($scrapper_config['entry_points'] as $urls) {
        if (!is_array($urls)) {
            $urls = array($urls);
        }

        foreach ($urls as $url) {
            $domain = GetDomain($url);
            if (!$domain || in_array($domain, $checked_domains)) {
                continue;
            }

            $tmp_url = $db_connect->GetLastURL();
            if ($tmp_url) {
                $url = $tmp_url;
            }

            $checked_domains[] = $domain;
            $entry_points[]    = $url;
        }
    }

    return $return_domain ? $checked_domains : $entry_points;
}

function remove_html_comments($data)
{
    $tmp = '';

    while ($data) {
        $i = stripos($data, '<!--');

        if ($i > 0 || $i === 0) {
            $tmp .= substr($data, 0, $i);

            if (stripos($data, '-->') > 0) {
                $data = substr($data, stripos($data, '-->') + 3);
            } else {
                $data = null;
            }
        } else {
            $tmp .= $data;
            $data = null;
        }
    }

    return $tmp;
}

function remove_js_comments($data)
{
    $tmp = '';

    while ($data) {
        $i = stripos($data, '/*');

        if ($i > 0 || $i === 0) {
            $tmp .= substr($data, 0, $i);

            if (stripos($data, '*/') > 0) {
                $data = substr($data, stripos($data, '*/') + 2);
            } else {
                $data = null;
            }
        } else {
            $tmp .= $data;
            $data = null;
        }
    }

    $tmp2 = '';

    $last_char  = '';
    $in_string  = false;
    $is_comment = false;

    for ($i = 0; $i < strlen($tmp); $i++) {
        $char = $tmp[$i];

        if ($char == '"' || $char == "'") {
            $in_string = !$in_string;
        }

        if (!$in_string) {
            if ($last_char == '/' && $char == '/') {
                $tmp2       = rtrim($tmp2, "/");
                $is_comment = true;
            }
        }

        if ($is_comment && $char == "\n") {
            $is_comment = false;
        }

        if (!$is_comment) {
            $tmp2 .= $char;
        }

        $last_char = $char;
    }

    return $tmp2;
}

function check_url_tag($config_name, $url)
{
    global $CronConfigs, $proxy_list;
    $data  = false;
    $tries = 0;

    while ((!$data) && $tries < 3) {
        $data = HttpGet($url, $proxy_list);
        $tries++;
    }

    if (!$data) {
        return array(
            'tag'    => 0, //unchecked
            'banner' => 0,
            'phone'  => 0,
            'conv'   => 0,
        );
    }

    $data = remove_html_comments($data);

    $bt = '<div id="smedia-web-banner">';
    $tt = '<div id="google-adwords-tag-by-smedia" style="display:inline;">';

    $i1 = stripos($data, $bt);
    $i2 = stripos($data, $tt);

    $banner = $i1 > 0;
    $tag    = $i2 > 0;
    $phone  = false;
    $conv   = false;

    $i = max(array($i1 + strlen($bt), $i2 + strlen($tt)));

    $data = substr($data, $i);
    $data = remove_js_comments($data);

    $tagRegx = '/(?<phone1>var phone = \'\';\s*if\(document\.getElementById\(\'phone_number\'\)\) phone = document.getElementById\(\'phone_number\'\).innerHTML;)?\s*filename="http:\/\/adwords\.smedia\.ca\/adwords-tracker-proxy\.php\?ref=" \+ encodeURIComponent\(document\.location\.href\);?(?<phone2> \+ "&phone=" \+ encodeURIComponent\(phone\);)?\s*var fileref=document\.createElement\(\'script\'\);\s*fileref\.setAttribute\("type","text\/javascript"\);\s*fileref\.setAttribute\("src", filename\);\s*document\.getElementsByTagName\("head"\)\[0\]\.appendChild\(fileref\);/';

    $match = null;

    if ($tag && preg_match($tagRegx, $data, $match)) {
        $tag = true;

        if (isset($match['phone1']) && isset($match['phone2'])) {
            $phone = true;
        }

    }

    if (isset($CronConfigs[$config_name]['conversion_tracking_code'])) {
        $conv = true;
    }

    if (isset($CronConfigs[$config_name]['new_phone'])) {
        $phone = true;
    } else {
        $phone = false;
    }

    if (!$tag) {
        $banner = false;
    }

    return array(
        'tag'    => $tag ? 1 : -1,
        'banner' => $banner ? 1 : -1,
        'phone'  => $phone ? 1 : -1,
        'conv'   => $conv ? 1 : -1,
    );
}
