<?php
global $scrapper_configs;
$scrapper_configs["5stardealer"] = array(
    'entry_points'           => array(
        'used' => 'https://www.5stardealer.com/index.php/inventory',
    ),
    'vdp_url_regex'          => '/\/index.php/info\/',

    'details_start_tag'      => '<main class="l-main-content"',
    'details_end_tag'        => '<aside class="l-sidebar"',
    'details_spliter'        => 'class="b-goods-1__section hidden-th"',

    'data_capture_regx'      => array(
        'year'  => '/b-goods-1__name[^=]+="(?<url>[^"]+)">(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+)[^s]+span>(?<trim>[^<]+)/',
        'make'  => '/b-goods-1__name[^=]+="(?<url>[^"]+)">(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+)[^s]+span>(?<trim>[^<]+)/',
        'model' => '/b-goods-1__name[^=]+="(?<url>[^"]+)">(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+)[^s]+span>(?<trim>[^<]+)/',
        'trim'  => '/b-goods-1__name[^=]+="(?<url>[^"]+)">(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+)[^s]+span>(?<trim>[^<]+)/',
        'url'   => '/b-goods-1__name[^=]+="(?<url>[^"]+)">(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^<]+)[^s]+span>(?<trim>[^<]+)/',
        'price' => '/b class="price[^\$]+\$(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number'   => '/b-car-info__desc-dt">STOCK[^=]+[^>]+>(?<stock_number>[^<]+)/',
        'body_style'     => '/b-car-info__desc-dt">body[^=]+[^>]+>(?<body_style>[^<]+)/',
        'year'           => '/b-car-info__desc-dt">year[^=]+[^>]+>(?<year>[^<]+)/',
        'price'          => '/b class="price[^\$]+\$(?<price>[^<]+)/',
        'fuel_type'      => '/b-car-info__desc-dt">FUEL[^=]+[^>]+>(?<fuel_type>[^<]+)/',
        'vin'            => '/b-car-info__desc-dt">VIN[^=]+[^>]+>(?<vin>[^<]+)/',
        'engine'         => '/b-car-info__desc-dt">ENGINE[^=]+[^>]+>(?<engine>[^<]+)/',
        'kilometres'     => '/b-car-info__desc-dt">MILEAGe[^=]+[^>]+>(?<kilometres>[^<]+)/',
        'transmission'   => '/b-car-info__desc-dt">TRANSMISSION[^=]+[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/b-car-info__desc-dt">colors[^=]+[^>]+>(?<exterior_color>[^\/]+)\/(?<interior_color>[^<]+)/',
        'interior_color' => '/b-car-info__desc-dt">colors[^=]+[^>]+>(?<exterior_color>[^\/]+)\/(?<interior_color>[^<]+)/',
    ),
    'next_page_regx'         => '/<a.*href="(?<next>[^"]+)"\s*data-ci-pagination-page/',
    'images_regx'            => '/<img class="sp-image"[^"]+"(?<img_url>[^"]+)/',

);
