<?php

global $scrapper_configs;
$scrapper_configs["amaranthdesigns"] = array(
    "entry_points" => array(
        'new' => 'https://amaranthdesigns.ca/collections/all',
    ),
    'vdp_url_regex' => '/\/products\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.product-featured-img.js-zoom-enabled '],
    'details_start_tag' => '<div data-section-id="collection-template"',
    'details_end_tag' => '<div id="shopify-section-footer"',
    'details_spliter' => '<div class="grid__item grid',
    'data_capture_regx' => array(
        'url' => '/class="grid-view-item__link" href="(?<url>[^"]+)/',
        'title' => '/class="h4 grid-view-item__title">(?<title>[^<]+)/',
        'make' => '/class="h4 grid-view-item__title">(?<make>[^\s]+)/',
        'model' => '/class="h4 grid-view-item__title">[^\s]+\s(?<model>[^<]+)/',
        'price' => '/class="product-price__price">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="btn btn--secondary btn--narrow">\s*<svg.+\s+<span class="icon__fallback-text">Next<\/span>/',
    'images_regx' => '/<a href="(?<url>[^"]+)".*\s*<img class="product-single__thumbnail-image"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'

);

