<?php

global $scrapper_configs;

    $scrapper_configs['spexbyryan'] = array(
       'entry_points' => array(
        'used' => 'https://www.store.spexbyryan.com/?page=1',
    ),
    'vdp_url_regex' => '/\/product-page\//i',
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.next.right.glyphicon.glyphicon-chevron-right'],
    'picture_prevs' => ['.prev.left.glyphicon.glyphicon-chevron-left'],
    'details_start_tag' => '<ul class="_3g4hn _33aXP"',
    'details_end_tag' => '<div id="SITE_FOOTER"',
    'details_spliter' => '<li data-hook="product-list-grid-item">',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*class="_3mKI1"/',
        'price' => '/<span data-hook="product-item-price-to-pay" class="_2-l9W">C(?<price>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'year' => '/<h1 data-hook="product-title" class="_2qrJF">(?<make>[^\s]+)\s(?<model>[^<]+)(?<year>[0-9]{4})/',
        'make' => '/data-hook="product-title" class="_2qrJF">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/data-hook="product-title" class="_2qrJF">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
    ),
    //there is no next page right now//
    //'next_page_regx' => '//',
    'images_regx' => '/<div class="_3j9OG media-wrapper-hook V-iTp" href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

