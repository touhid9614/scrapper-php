<?php

global $scrapper_configs;
$scrapper_configs["hayeschevroletcom"] = array(
    'entry_points'        => array(
        'new' => 'https://www.hayeschevrolet.com/',
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'           => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.hayeschevrolet.com/sitemap-inventory-sincro.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/noresponsive\s*data-src=\\"(?<img_url>[^\\]+)\\"\s*lazyLoad/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = false;
        $use_custom_site      = true;
        $invalid_images       = [
            'https://images.dealer.com/unavailable_stockphoto.png',
            'https://media.assets.ansira.net/websites/5.0-9295/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
            'https://inv.assets.sincrod.com/0/6/8/31267684860.jpg', 
            'https://inv.assets.sincrod.com/6/9/9/31278019996.jpg',
            'https://inv.assets.ansira.net/2/5/2/32494984252.jpg',
            'https://inv.assets.ansira.net/6/2/4/32494978426.jpg',
            'https://inv.assets.ansira.net/0/0/7/32494986700.jpg',
            'https://inv.assets.ansira.net/7/1/2/32497310217.jpg',
            'https://inv.assets.ansira.net/4/9/7/32494984794.jpg',
            'https://inv.assets.ansira.net/8/3/7/32494986738.jpg',
            'https://inv.assets.ansira.net/7/8/3/32497312387.jpg'
            ];
        // Post process data
        $annoy_func = function ($car) {
            if ($car['stock_type'] == 'certified') {
                $car['stock_type'] = 'used';
                $car['certified']  = true;
            }
            $car['model'] = strtolower($car['model']);

            $api_maker = "?&uri=view%2FconsumerBlock%3FlinkPath%3D%2Fmain%26fields%3Dhtml%2Cscripts%2Cstyles%2Cjsimports%2CstyleClasses&handler=blockProxyHandler&format=deferred&workflowType=block-component&&respondBlockError=true&signature=-1059014703&componentId=68243a2c79b0ea80941557478ad4190bc38617602b9b47320c494a1c92508713&siteVersion=601e8ef4b615b821d3c12555547d9a73ec71f0762bca6752755a44a47123c7cf_1";
            $api_url  = $car['url'] . $api_maker;

            $response_data = HttpGet($api_url, true, true);
            $regex         = '/noresponsive\s*data-src=\\"(?<img_url>[^\\]+)\\"\s*lazyLoad/';
            $matches       = [];

            if (preg_match_all($regex, $response_data, $matches)) {
                if (count($matches['img_url']) < 5) {
                    $matches['img_url'] = [];
                }
                else {
                    $car['images']     = $matches['img_url'];  
                    $car['all_images'] = implode('|', $car['images']);
                }
            }


            return $car; 
        };

        $data_capture_regx_full = [
            'stock_type'     => '/com\/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'stock_number'   => '/"stockNumber":"(?<stock_number>[^"]+)/',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin'            => '/"vin":"(?<vin>[^"]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"model":"(?<model>[^"]+)"/',
            'price'          => '/"price":"(?<price>[^"]+)/',
            'kilometres'     => '/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);

