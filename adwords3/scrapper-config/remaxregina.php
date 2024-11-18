<?php

global $scrapper_configs;
$scrapper_configs["remaxregina"] = array(
    "entry_points" => array(
        'new' => 'https://www.remaxregina.ca/advanced-search/',
    ),
    'vdp_url_regex' => '/\/listing\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.figure--image.figure--image__thumbnails'],
    'picture_nexts' => ['.button.button__slideshow.button__next'],
    'picture_prevs' => ['.button.button__slideshow.button__previous'],
    'details_start_tag' => '<div class="page--row page--row__primary">',
    'details_end_tag' => '<div class="footer">',
    'details_spliter' => '<li class="results--item results--item__photo">',
    'data_capture_regx' => array(
        'url' => '/<div class="rps-property-info rps-text-center-sm">\s*<[^>]+>\s*<a href="(?<url>[^"]+)/',
        'title' => '/<div class="rps-property-info rps-text-center-sm">\s*<[^>]+>\s*<a href="(?<url>[^"]+)"><h4>(?<make>[^ ]+)\s*(?<model>[^<]+)/',
        'make' => '/<div class="rps-property-info rps-text-center-sm">\s*<[^>]+>\s*<a href="(?<url>[^"]+)"><h4>(?<make>[^ ]+)\s*(?<model>[^<]+)/',
        'model' => '/<div class="rps-property-info rps-text-center-sm">\s*<[^>]+>\s*<a href="(?<url>[^"]+)"><h4>(?<make>[^ ]+)\s*(?<model>[^<]+)/',
       // 'trim' => '/<div class="rps-property-info  rps-text-center-sm">\s*<[^>]+>\s*<a href="(?<url>[^"]+)"><h4>(?<title>(?<trim>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/<span class="rps-price rps-price-default">(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/MLS[^<]+<\/strong>\s*<\/td>\s*<td [^>]+>\s*(?<stock_number>[^\<]+)/',
    ),
    'next_page_regx' => '/<li><a class="next page-numbers" href="(?<next>[^"]+)"/',
    'images_regx' => '/<li class="slide"><a href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
