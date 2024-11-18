<?php

global $scrapper_configs;
$scrapper_configs["joshwoodhomes"] = array(
    "entry_points" => array(
        'used' => 'http://joshwoodhomes.com/index.php/listing/',
    ),
    'use-proxy' => true,
    'refine'    => false,
    'vdp_url_regex' => '/\/listing\//i',
    'picture_selectors' => ['.bx-pager-wrap img'],
    'picture_nexts' => ['.bx-next'],
    'picture_prevs' => ['.bx-prev'],
    'details_start_tag' => '<div id="rps-result-wrap">',
    'details_end_tag' => '<div class="col-md-3 col-sm-4 col-xs-12">',
    'details_spliter' => '<section class="col-xs-12 col-sm-4 col-md-3 listing-container">',
    'data_capture_regx' => array(
        'url' => '/class="rps-property-info rps-text-center-sm">\s*<[^>]+>\s*<a href="(?<url>[^"]+)">/',
        'make' => '/href="(?<url>[^"]+)"><h4>(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'model' => '/href="(?<url>[^"]+)"><h4>(?<make>[^\s]+)\s(?<model>[^<]+)/',
        'price' => '/class="[^>]+>(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx' => '/class="next page-numbers" href="(?<next>[^"]+)"/',
    'images_regx' => '/<a href="(?<img_url>[^"]+)" rel="[^>]+><img src="(?<img_url>[^"]+)/',
    'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter('filter_joshwoodhomes_cookies', 'filter_joshwoodhomes_cookies');

function filter_joshwoodhomes_cookies($cookies) {
    if(!$cookies) {
        $cookies = "disclaimer=accepted";
    }
    
    return $cookies;
}

add_filter("filter_joshwoodhomes_field_make", "filter_joshwoodhomes_field_title");
add_filter("filter_joshwoodhomes_field_model", "filter_joshwoodhomes_field_title");

function filter_joshwoodhomes_field_title($title) {
    return str_replace('&amp;', '&', $title);
}
