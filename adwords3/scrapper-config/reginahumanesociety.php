<?php

global $scrapper_configs;
$scrapper_configs["reginahumanesociety"] = array(
    "entry_points" => array(
        'used' => 'https://reginahumanesociety.ca/adoptions/',
    ),
    'vdp_url_regex' => '/\/pet-adoptions\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.five.columns.push-seven a img'],
    'details_start_tag' => '<ul class="grid"',
    'details_end_tag' => '<div id="hello"',
    'details_spliter' => '<li class="mix',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)" title="(?<title>[^>]+)"><img src="(?<img_url>[^"]+)/',
        'title' => '/<a href="(?<url>[^"]+)" title="(?<title>[^>]+)"><img src="(?<img_url>[^"]+)/',
        'make' => '/Breed:(?<make>[^\<]+)/',
        'description'   => '/Age:(?<description>[^<]+)/',
        'stock_number' => '/ID:(?<stock_number>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'exterior_color' => '/Colour: <\/strong>(?<exterior_color>[^<]+)/',
        'model' => '/Type: <\/strong>(?<model>[^<]+)/',
        'stock_type' => '/Sex: <\/strong>(?<stock_type>[^<]+)/',
        'trim' => '/Weight: <\/strong>(?<trim>[^<]+)/',

    ),
    'images_regx' => '/<div class="five columns push-seven">\s*.*\s*<img src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_reginahumanesociety_field_make", "filter_reginahumanesociety_field_make");
function filter_reginahumanesociety_field_make($make) {
    return trim($make);
}