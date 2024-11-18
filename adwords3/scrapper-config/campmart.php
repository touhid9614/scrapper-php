<?php

global $scrapper_configs;

$scrapper_configs['campmart'] = array(
    'entry_points' => array(
        'new' => 'https://www.campmart.ca/--inventory?condition=new&pg=1',
        'used' => 'https://www.campmart.ca/--inventory?condition=pre-owned&pg=1',
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => '<div class="v7list-results listview',
    'details_end_tag' => '<footer dst-footer="col5-w-bottom"',
    'details_spliter' => '<li class="v7list-results__item"',
    'data_capture_regx' => array(
        'stock_number' => '/Stock Number:[^>]+>\s*(?<stock_number>[^<]+)/',
        //'stock_type' => '/Condition:\s*(?<stock_type>[^"]+)/',
        'year' => '/vehicle-heading__year">(?<year>[0-9]{4})/',
        'make' => '/vehicle-heading__name">(?<make>[^<]+)/',
        'model' => '/vehicle-heading__model">(?<model>[^<]+)/',
        'url' => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
        'price' => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
    'images_regx' => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);

add_filter("filter_campmart_next_page", "filter_campmart_next_page", 10, 2);
add_filter("filter_campmart_field_images", "filter_campmart_field_images");

function filter_campmart_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);

    return $url;
}

function filter_campmart_field_images($im_urls) {
    $retval = array();

    foreach ($im_urls as $url) {

        $url = str_replace('https://www.campmart.ca/', '', $url);
        $url = str_replace('https://www.campmart.ca/', '', $url);
        $url = str_replace('https://www.campmart.ca/', '', $url);
        $url = str_replace('https://www.campmart.ca/', '', $url);
        $url = str_replace('https://www.campmart.ca/', '', $url);
        $url = str_replace('https://www.campmart.ca/', '', $url);
        $retval[] = str_replace('&#x2F;', '/', $url);
    }
    return $retval;
}
