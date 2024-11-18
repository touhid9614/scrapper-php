<?php

global $scrapper_configs;

$scrapper_configs['stonegroundpaint'] = array(
    'entry_points' => array(
        'new' => 'https://stonegroundpaint.com/individual-colours/',
        'used' => 'https://stonegroundpaint.com/new-products/',
        'certified' => 'https://stonegroundpaint.com/accessories-2/'
    ),

    'vdp_url_regex' => '/\/(?:earthcolours|small-palettes|accessories-1)\//i',
    //'ty_url_regex' => '/\/thank-you\?formName/i',
    'use-proxy' => true,
    
    
    'picture_selectors' => ['#productThumbnails div img'],
    'picture_nexts' => ['.sqs-lightbox-next'],
    'picture_prevs' => ['.sqs-lightbox-previous'],
    
    'details_start_tag' => '<div id="productList"',
    'details_end_tag' => '<div class="footer-nav">',
    'details_spliter' => '</span>',

    'data_capture_regx' => array(
        'stock_number'   => '/data-item-id="(?<stock_number>[^"]+)/',
        'title' => '/lass="product-title">(?<title>[^<]+)/',
         //'year' => '/data-image-dimensions="(?<year>[^"]+)/',
         'make' => '/lass="product-title">(?<make>[^(?:\s|<)]+)/',
         'model' => '/lass="product-title"[^\s]+(?<model>[^<]+)</',
        'price' => '/class="product-price">\s*[^>]*>(?<price>[^<]+)/',
        'url' => '/<a href="(?<url>[^"]+)" class="pro/'
    ),
    'data_capture_regx_full' => array(
      //  'title' => '/class="product-title"\s[^>]+>(?<title>[^<]+)/',
       //  'price' => '/<span class="sqs-money-native">(?<price>[^<]+)<\/span>/',
    ),
    'images_regx' => '/<img data-load="false" data-src="(?<img_url>[^"]+)" data-image/',
);
