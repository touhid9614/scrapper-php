<?php

global $scrapper_configs;
$scrapper_configs["southtownechevroletcom"] = array(
    'entry_points' => array(
        'new' => 'https://www.southtownechevrolet.com/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => false,
    'picture_selectors' => ['.scroll-content-item'],
    'picture_nexts' => ['.bx-next'],
    'picture_prevs' => ['.bx-prev'],
    "custom_data_capture" => function ($url, $data) {
        $site = "https://www.southtownechevrolet.com/sitemap-inventory-sincro.xml";
        $vdp_url_regex = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx = '/photoUrl":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params = [];
        $use_proxy = false;
        $invalid_images = ['https://inv.assets.sincrod.com/0/2/6/31212104620.jpg', 'https://images.dealer.com/unavailable_stockphoto.png', 'https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png', 'https://media.assets.sincrod.com/websites/5.0-8620/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];

        $annoy_func = function ($car) {
            if ($car['stock_type'] == 'certified') {
                $car['stock_type'] = 'used';
            }
            return $car;
        };

        $data_capture_regx_full = [
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            'stock_type' => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'stock_number' => '/stockNumber":"(?<stock_number>[^"]+)/',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin' => '/"vin":"(?<vin>[^"]+)/',
            'year' => '/year":"(?<year>[^"]+)/',
            'make' => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model' => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price' => '/"price":"(?<price>[0-9,]+)/',
            'kilometres' => '/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission' => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);
