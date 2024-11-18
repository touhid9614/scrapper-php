<?php
global $scrapper_configs;
$scrapper_configs["regesterchevrolet"] = array(
    "entry_points"        => array(
        'new' => 'https://www.regesterchevrolet.com/',
    ),

    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}/',
    'srp_page_regex'      => '/\/VehicleSearchResults/',

    'use-proxy'           => true,
    'refine'              => false,

    'picture_selectors'   => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'       => ['div.arrow.single.next'],
    'picture_prevs'       => ['div.arrow.single.prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.regesterchevrolet.com/sitemap-inventory-sincro.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}/';
        $images_regx          = '/"photoUrl":"(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = []; // Mandatory url parameters
        $use_proxy            = true; // Uses proxy to reach site
        $keymap               = null; // Return the output data mapped against any car key
        $invalid_images       = ['photo_unavailable_320.gif']; // List of image urls to be filtered out
        $use_custom_site      = true; // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car) {
            // filter stock_numbers
//            $drop_stocks = ['20257', '16334', '22567', '18043'];

//            if (in_array($car['stock_number'], $drop_stocks)) {
//                return [];
//            }

            // filter model
            $car['trim'] = str_replace(['&', ';','*'], [' and ', '',' '], $car['trim']);

            // image filter
            $imgs = explode("|", $car['all_images']);
            if (count($imgs) < 1) {
                return [];
            }



             if (strtolower($car['stock_type']) == 'certified') {
                $car['stock_type'] = 'cpo';
            } 



            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/"category":"(?<stock_type>[^"]+)","/i',
            'year'           => '/","year":"(?<year>[^"]+)","/i',
            'make'           => '/","make":"(?<make>[^"]+)","/i',
            'model'          => '/","model":"(?<model>[^"]+)","trim":"(?<trim>[^"]+)/i',
            'trim'           => '/","model":"(?<model>[^"]+)","trim":"(?<trim>[^"]+)/i',
            'stock_number'   => '/"stockNumber":"(?<stock_number>[^"]+)/',
            'exterior_color' => '/","exterior":"(?<exterior_color>[^"]+)","/',
            'interior_color' => '/","interior":"(?<interior_color>[^"]+)","/',
            'price'          => '/"price":"(?<price>[^"]+)/',
            // 'msrp'           => '/","msrp":(?<msrp>[^,]+),/',
            'engine'         => '/<span class="value" itemprop="vehicleEngine">(?<engine>[^<]+)<\/span>/',
            'transmission'   => '/","transmission":"(?<transmission>[^"]+)"/',
            'drivetrain'     => '/<span class="value" itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)<\/span>/',
            'kilometres'     => '/","miles":"(?<kilometres>[^"]+)","/',
            'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
            'vin'            => '/","vin":"(?<vin>[^"]+)","/',
            'vehicle_id'     => '/<a rel="nofollow" data-vehicleid="(?<vehicle_id>[^"]+)"/',
            'custom'         => '/<span itemprop="mpn">(?<custom>[^<]+)<\/span>/',
            'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);
