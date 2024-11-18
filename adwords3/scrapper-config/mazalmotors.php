<?php
global $scrapper_configs;
$scrapper_configs["mazalmotors"] = array(
    'entry_points'           => array(
        'used' => 'http://www.mazalmotors.com/inventory/?f=1&list=4sale&ty=&con=&bod=&mk=&pr=&mi=&yr=&col=&tr=&fu=&dr=',
    ),
    "no_scrap"               => true,
    'vdp_url_regex'          => '/\/inventory\/\?id=/i',

    'use-proxy'              => false,
    // 'content_type'          => 'text/html',

    'picture_selectors'      => ['.inner-image'],
    'picture_nexts'          => ['.flex-next'],
    'picture_prevs'          => ['.flex-prev'],

    'details_start_tag'      => '<div id="inventory-list-header">',
    'details_end_tag'        => '<div class="footer-bar">',
    'details_spliter'        => '<div class="veh p5 col-sm-6 col-md-4">',
    'data_capture_regx'      => array(
        'url'   => '/class="item-hover sload" href="(?<url>[^"]+)/',
        'year'  => '/class="item-box-desc">\s*<h4>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make'  => '/class="item-box-desc">\s*<h4>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/class="item-box-desc">\s*<h4>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'price' => '/class="veh-main-price">\$\s*(?<price>[^\s]+)/',

    ),
    'data_capture_regx_full' => array(
        'kilometres'     => '/MILEAGE<\/th>\s*<td>\s*(?<kilometres>[^<]+)/',
        'stock_number'   => '/STOCK<\/th>\s*<td>#\s*(?<stock_number>[^<]+)/',
        'engine'         => '/ENGINE<\/th>\s*<td>\s*(?<engine>[^<]+)/',
        'transmission'   => '/TRANS<\/th>\s*<td>\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/EXT<\/th>\s*<td>\s*(?<exterior_color>[^<]+)/',

    ),
    //'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx'            => '/background-image:url\((?<img_url>[^\)]+)/',
);