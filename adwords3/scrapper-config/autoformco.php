<?php

global $scrapper_configs;

$scrapper_configs['autoformco'] = array(
    'entry_points' => array(
        'used' => 'https://www.aaronvanpykstra.ca/?page=1',
    ),
    'vdp_url_regex' => '/\/vehicles\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.next.right.glyphicon.glyphicon-chevron-right'],
    'picture_prevs' => ['.prev.left.glyphicon.glyphicon-chevron-left'],
    'details_start_tag' => 'data-hook="product-list-wrapper"',
    'details_end_tag' => 'Load More',
    'details_spliter' => '<li data-hook="product-list-grid-item">',
    'data_capture_regx' => array(
        'url' => '/class="_2zTHN _2AHc6"><a href="(?<url>[^"]+)"/',
        'year' => '/data-hook="product-item-name">(?:Sold|SOLD)\s*-\s*(?<year>[0-9]{4})-\s*(?<make>[^-]+)-\s*(?<model>[^<]+)/',
        'make' => '/data-hook="product-item-name">(?:Sold|SOLD)\s*-\s*(?<year>[0-9]{4})-\s*(?<make>[^-]+)-\s*(?<model>[^<]+)/',
        'model' => '/data-hook="product-item-name">(?:Sold|SOLD)\s*-\s*(?<year>[0-9]{4})-\s*(?<make>[^-]+)-\s*(?<model>[^<]+)/',
    // 'price' => '/<h3 class=\'price\'>(?<price>\$[0-9,]+)/',
    // 'kilometres' => '/class=\'af-vehicle-thumb-km\'>\s*(?<kilometres>[^\n]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    //there is no next page right now//
    //'next_page_regx' => '//',
    'images_regx' => '/id="magic-zoom-id-[^"]+" href="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
