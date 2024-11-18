<?php
global $scrapper_configs;
$scrapper_configs["candhautosalescom"] = array( 
	  "entry_points"         => array(
        'used' => 'https://www.candhautosales.com/online-inventory',
    ),
    'vdp_url_regex'        => '/\/VehicleDetails\//i',
    'srp_page_regex'        => '/\/online-inventory/i',
    // 'use-proxy'            => true,
    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "www.candhautosales.com";
        $vdp_url_regex        = '/\/VehicleDetails\//i';
        $images_regx          = '/full="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)/i';
        $required_params      = [];
        // $use_proxy            = true;

        $data_capture_regx_full = [
            'stock_type'      => '/Type:<\/div><div class="wsefvalue">(?<stock_type>[^<]+)/i',
            'year'           => '/<div class="infoinfo infoinfoyear">(?<year>[0-9]{4})<\/div>/i',
            'make'           => '/<div class="infoinfo infoinfomake">(?<make>[^<]+)<\/div>/i',
            'model'          => '/<div class="infoinfo infoinfomodel">(?<model>[^<]+)<\/div>/i',
            'price'          => '/<div class="price mainprice"[^>]+>\s*(?<price>[^\s*]+)/i',
            'engine'         => '/<div class="infoinfo infoinfoengine">(?<engine>[^<]+)<\/div>/i',
            'transmission'   => '/<div class="infoinfo infoinfotransmission">(?<transmission>[^<]+)<\/div>/i',
            'kilometres'     => '/<div class="infoinfo infoinfomileage">(?<kilometres>[^<]+)<\/div>/i',
            'exterior_color' => '/<div class="infoinfo infoinfoextcolor">(?<exterior_color>[^<]+)<\/div>/i',
            'stock_number'   => '/<div class="infoinfo infoinfostock">(?<stock_number>[^<]+)<\/div>/i',
            'vin'            => '/<div class="infoinfo infoinfovin">(?<vin>[^<]+)<\/div>/i',
            'body_style'     => '/<div class="infoinfo infoinfostyle">(?<body_style>[^<]+)<\/div>/i',
           'description'   => '/<meta name="description" content="(?<description>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
       $return_cars = [];

        foreach ($cars as $car) {
            $car['transmission'] = str_replace(['\x2D', '\x2F\x20'], ['', ''], $car['transmission']);

            if (!$car['transmission']) {
                $car['transmission'] = '';
            }

            if (strtolower($car['trim']) == 'for') {
                $car['trim'] = '';
            }

            $car['stock_type'] = trim(strtolower($car['stock_type']));

            $return_cars[] = $car;
        }

        return $return_cars;
    }
);
