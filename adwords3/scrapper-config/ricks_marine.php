<?php

global $scrapper_configs;
$scrapper_configs["ricks_marine"] = array(
    'entry_points' => array(
        'new' => 'https://www.ricks-marine.ca/search/inventory/usage/New',
    ),
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts' => ['.slick-next', '.mfp-arrow .mfp-arrow-right'],
    'picture_prevs' => ['.slick-prev', '.mfp-arrow .mfp-arrow-left'],
    'refine' => false,
    'details_start_tag' => '<div class="search-results-list">',
    'details_end_tag' => '<div class="ari-section footer',
    'details_spliter' => '<div class="panel panel-default search-result">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #<\/strong>\s*.*\s*<td[^>]+>\s*(?<stock_number>[^<]+)/',
        'year' => '/data-model-year>(?<year>[0-9]{4})/',
        'make' => '/data-model-brand>(?<make>[^<]+)/',
        'model' => '/data-model-name>(?<model>[^<]+)/',
        'price' => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
        'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
        'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',
        'url' => '/<a href="(?<url>[^"]+)" .*>View Details/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<li class="active">\s*<a href="[^"]+">[^\n]+\s*<\/li>\s*<li [^>]+>\s*<a href="(?<next>[^"]+)/',
    'images_regx' => '/<img data-highres="[^\?]+\?img=(?<img_url>[^\&]+)/',
);

add_filter("filter_ricks_marine_field_images", "filter_ricks_marine_field_images");

function filter_ricks_marine_field_images($im_urls) {
    $retval = array();

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['http://www.ricks-marine.ca/inventory/', '%3a', '%2f', 'http://www.ricks-marine.ca/new-models/'], ['', ':', '/', ''], ($im_url));
    }

    return $retval;
}
