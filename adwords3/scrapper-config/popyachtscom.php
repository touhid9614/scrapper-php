<?php
global $scrapper_configs;
$scrapper_configs["popyachtscom"] = array(
    'entry_points'           => array(
        'used' => 'https://www.popyachts.com/Get-Listings.asp?u=1575954971248&mode=Search&sea_page=1',
    ),

    'vdp_url_regex'          => '/-[a-zA-Z]-for-sale\//i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'          => ['.arrow.single.next'],
    'picture_prevs'          => ['.arrow.single.prev'],

    'details_spliter'        => '<div class="lis_display_grid">',
    'data_capture_regx'      => array(
        'year'       => '/Year<\/div>[^>]+>(?<year>[0-9]{4})/',
        'make'       => '/Brand<\/div>[^>]+>[^>]+>(?<make>[^<]+)/',
        'model'      => '/Model<\/div>[^>]+>(?<model>[^<]+)/',
        'kilometres' => '/vehicle-miles[^>]+>\s*(?<kilometres>[^\s<]+)/',
        'body_style' => '/Type<\/div>[^>]+>(?<body_style>[^<]+)/',
        'url'        => '/<a class="button special" href="(?<url>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'price'          => '/<span itemprop="price" content="(?<price>[^"]+)">/',
        'vin'            => '/itemprop="productID">(?<vin>[^<]+)/',
        'stock_number'   => '/itemprop="productID">(?<stock_number>[^<]+)/',
        'drivetrain'     => '/Drive:<\/p>\s*(?<drivetrain>[^<]+)/',
        'exterior_color' => '/Category:\s*<\/div>[^>]+>[^>]+>(?<exterior_color>[^<]+)/',

    ),
    'next_query_regx'        => '/checked="checked"[^\n]+\n[^>]+>[^>]+>\s*<input type="radio" id="(?<param>sea_page)_btn_(?<value>[0-9]*)/',
    'images_regx'            => '/background-image:url\(\'(?<img_url>[^\']+)/',
);