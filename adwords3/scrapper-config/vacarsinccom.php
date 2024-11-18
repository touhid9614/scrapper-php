<?php

global $scrapper_configs;
$scrapper_configs["vacarsinccom"] = array(
    'entry_points'         => array(
        'used' => 'https://www.vacarsinc.com/inventory',
    ),
    'vdp_url_regex'        => '/\/VehicleDetails\/[0-9]{4}\/[A-z0-9]{4,9}\/Richmond-VA-[0-9]{4}-/i',
    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "use-proxy"            => true,
    "custom_data_capture"  => function ($url, $data) {
        $site                 = "www.vacarsinc.com";
        $vdp_url_regex        = '/\/VehicleDetails\/[0-9]{4}\/[A-z0-9]{4,9}\/Richmond-VA-[0-9]{4}-/i';
        $images_regx          = '/data-is_stock_image="0" data-src=".*full="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<img class="photoclick" src="(?<img_url>[^"]+)/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            'title'          => '/<h1>(?<title>[^<]+)<div class="internetspeciallabelholder/i',
            'year'           => '/<div class="infoinfo infoinfoyear">(?<year>[0-9]{4})<\/div>/i',
            'make'           => '/<div class="infoinfo infoinfomake">(?<make>[^<]+)<\/div>/i',
            'model'          => '/<div class="infoinfo infoinfomodel">(?<model>[^<]+)<\/div>/i',
            'price'          => '/<div class="price mainprice"[^>]+>(?<price>[^<]+)<\/div>/i',
            'msrp'           => '/<div class="price "[^>]+>(?<msrp>[^<]+)<\/div>/i',
            'engine'         => '/<div class="infoinfo infoinfoengine">(?<engine>[^<]+)<\/div>/i',
            'transmission'   => '/<div class="infoinfo infoinfotransmission">(?<transmission>[^<]+)<\/div>/i',
            'kilometres'     => '/<div class="infoinfo infoinfomileage">(?<kilometres>[^<]+)<\/div>/i',
            'exterior_color' => '/<div class="infoinfo infoinfoextcolor">(?<exterior_color>[^<]+)<\/div>/i',
            'stock_number'   => '/<div class="infoinfo infoinfostock">(?<stock_number>[^<]+)<\/div>/i',
            'vin'            => '/<div class="infoinfo infoinfovin">(?<vin>[^<]+)<\/div>/i',
            'body_style'     => '/<div class="infoinfo infoinfostyle">(?<body_style>[^<]+)<\/div>/i',
        ];

        $cars     = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        $car_data = [];

        foreach ($cars as $car) {
            $car['body_style'] = str_replace('\"', '', $car['body_style']);
            $car['body_style'] = str_replace('"', '', $car['body_style']);
            slecho("dd:" . $car['body_style'] . ":dd");
            $car_data[] = $car;
        }

        return $car_data;
    },

    'images_regx'          => '/data-is_stock_image="0" data-src=".*full="(?<img_url>[^"]+)/i',
    'images_fallback_regx' => '/<img class="photoclick" src="(?<img_url>[^"]+)/i'
);