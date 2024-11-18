<?php

global $scrapper_configs;

$scrapper_configs['folsombuickgmc'] = array(
  'entry_points'        => array(
        'new' => 'https://www.folsombuickgmc.com/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.folsombuickgmc.com/sitemap.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/"photoUrl":"(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = ['https://media.assets.sincrod.com/websites/5.0-8501/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
                                 'https://media.assets.sincrod.com/websites/5.0-8895/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
                                 'https://media.assets.sincrod.com/websites/5.0-8973/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
                                 'https://media.assets.sincrod.com/websites/5.0-9048/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
            
            ];


             $annoy_func = function ($car) {


    if (strtolower($car['stock_type']) == 'certified') {
                $car['stock_type'] = 'cpo';
            } 

            return $car;
        };



        $data_capture_regx_full = [
           // 'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_type'     => '/"category":"(?<stock_type>[^"]+)/i',
            'year'           => '/"year":"(?<year>[^"]+)/i',
            'make'           => '/"make":"(?<make>[^"]+)/i',
            'model'          => '/"model":"(?<model>[^"]+)/i',
            'trim'           => '/trim":"(?<trim>[^"]+)","year/i',
         'price'          => '/"price":"(?<price>[^"]+)/i',    
         'engine'         => '/Engine<\/span>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/i',
         'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
         'kilometres'     => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/i',
           // 'exterior_color' => '/Exterior Colour<\/dt><[^>]+><span>(?<exterior_color>[^<]+)<\/span>/i',
           
        'stock_number' => '/"stockNumber":"(?<stock_number>[^"]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'vin' => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);