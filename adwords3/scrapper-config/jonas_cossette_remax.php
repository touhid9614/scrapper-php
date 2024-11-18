<?php

global $scrapper_configs;
$scrapper_configs["jonas_cossette_remax"] = array(
    "entry_points" => array(
        'new' => 'https://www.remaxregina.ca/advanced-search/',
    ),
    'vdp_url_regex' => '/\/newlistings\//i',
    'refine' => false,
    'use-proxy' => true,
    'picture_selectors' => ['.figure--image.figure--image__thumbnails'],
    'picture_nexts' => ['.button.button__slideshow.button__next'],
    'picture_prevs' => ['.button.button__slideshow.button__previous'],
    'details_start_tag' => '<div id="rps-result-wrap">',
    'details_end_tag' => '<!-- /.rps-result-wrap -->',
    'details_spliter' => '<section class="col-xs-12 col-sm-4 col-md-4 listing-container">',
    'data_capture_regx' => array(
        'url' => '/<figure>\s*<a href="(?<url>[^"]+)/',
        'title' => '/<h4>(?<title>[^<]+)/',
        'make' => '/<h4>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/<h4>(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price' => '/rps-price rps-price-default">(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Number<\/strong>\s*<\/td>[^>]+>\s*(?<stock_number>[^\<]+)/',
        'year' => '/Constructed Date<\/strong>\s*<\/td>[^>]+>\s*(?<year>[^\<]+)/',
    ),
    'next_page_regx' => '/<a class="next page-numbers" href="(?<next>[^"]+)"/',
    'images_regx' => '/<li class="slide[^>]+>\s*<a href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property=\'og:image\' content="(?<img_url>[^"]+)"/'
);
