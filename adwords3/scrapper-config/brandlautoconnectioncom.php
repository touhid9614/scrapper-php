<?php
global $scrapper_configs;
$scrapper_configs["brandlautoconnectioncom"] = array( 
		"entry_points" => array(
	       
        'used' => 'https://www.brandlautoconnection.com/st-cloud-used-vehicles',
         
       ),
    'vdp_url_regex'       => '/\/VehicleDetails\//i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.current'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.brandlautoconnection.com/sitemap.xml";
        $vdp_url_regex        = '/\/VehicleDetails\//i';
        $images_regx          = '/data-src="[^\"]+".*full="(?<img_url>[^\"]+)"/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;

        $annoy_func = function ($car_data) {
            if($car_data['stock_number'] == "221125A"){
                slecho("Excluding this stock number 221125A");
                $car_data = [];
            }

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/Type:<\/div>[^>]+>(?<stock_type>[^<]+)/i',
            'year'           => '/infoinfoyear">(?<year>[^<]+)/i',
            'make'           => '/infoinfomake">(?<make>[^<]+)/i',
            'model'          => '/infoinfomodel">(?<model>[^<]+)/i',
            'price'          => '/class="price mainprice".*id="[^>]+>\s*(?<price>[^\s]+)/i',
            'engine'         => '/infoinfoengine">(?<engine>[^<]+)/i',
            'transmission'   => '/infoinfotransmission">(?<transmission>[^<]+)/i',
            'kilometres'     => '/infoinfomileage">(?<kilometres>[^<]+)/i',
            'interior_color' => '/infolabelintcolor">(?<interior_color>[^<]+)/i',
            'exterior_color' => '/infolabelextcolor">(?<exterior_color>[^<]+)/i', 
            'stock_number'   => '/infoinfostock">(?<stock_number>[^<]+)/i',
            'vin'            => '/infoinfovin">(?<vin>[^<]+)/i',
            'body_style'     => '/ infoinfostyle">(?<body_style>[^<]+)/i',
          //  'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
           
      ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        $return_cars = [];

        foreach ($cars as $car) {
       
            if ($car['stock_type'] == 'Used') {
                $car['stock_type'] = 'used';
            }

            $return_cars[] = $car;
        }

        return $return_cars;
    },
   
     'images_regx'          => '/data-src="[^\"]+".*full="(?<img_url>[^\"]+)"/',
     'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);
