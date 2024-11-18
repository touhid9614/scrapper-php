<?php
global $scrapper_configs;
$scrapper_configs["shieldsautogroupcom"] = array( 
	'entry_points' => array(
            'used' => 'https://www.shieldsautogroup.com/preownedvehicles',
         
         ),
      'vdp_url_regex'       => '/\/VehicleDetails\//i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.current'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.shieldsautogroup.com/sitemap.xml";
        $vdp_url_regex        = '/\/VehicleDetails\//i';
        $images_regx          = '/full="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
          //  'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_type'     => '/Type:<\/div>[^>]+>(?<stock_type>[^<]+)/i',
            'year'           => '/infoinfoyear">(?<year>[^<]+)/i',
            'make'           => '/infoinfomake">(?<make>[^<]+)/i',
            'model'          => '/infoinfomodel">(?<model>[^<]+)/i',
            'price'          => '/class="price mainprice"[^>]+>\s*(?<price>[^<]+)/i',
            'engine'         => '/infoinfoengine">(?<engine>[^<]+)/i',
            'transmission'   => '/infoinfotransmission">(?<transmission>[^<]+)/i',
            'kilometres'     => '/infoinfomileage">(?<kilometres>[^<]+)/i',
            'exterior_color' => '/infoinfoextcolor">(?<exterior_color>[^<]+)/i', 
            'stock_number'   => '/infoinfostock">(?<stock_number>[^<]+)/i',
            'vin'            => '/infoinfovin">(?<vin>[^<]+)/i',
            'body_style'     => '/infoinfostyle">(?<body_style>[^<]+)/i',
            'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
           
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        $return_cars = [];
          $im_urls=[];
        foreach ($cars as $car) {
            $car['transmission'] = str_replace('\x2D', '', $car['transmission']);

            if (!$car['transmission']) {
                $car['transmission'] = '';
            }

            if (strtolower($car['trim']) == 'for') {
                $car['trim'] = '';
            }
            
            
       //     unset($car['custom']);
            $return_cars[] = $car;
        }

        return $return_cars;
    }
);
