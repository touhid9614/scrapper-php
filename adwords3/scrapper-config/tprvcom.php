<?php
global $scrapper_configs;
$scrapper_configs["tprvcom"] = array( 
	"entry_points"        => array(
        'new' => 'https://www.tprv.com/sitemap-vehicles.xml',
    ),

    'vdp_url_regex'       => '/inventory\/(?:New|Used)\-[0-9]{4}/',
    'srp_page_regex'      => '/\/(?:new|used)\-rv\-inventory/',
    'use-proxy'           => true,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.tprv.com/sitemap-vehicles.xml";
        $vdp_url_regex        = '/\/(?:New|Used)\-[0-9]{4}/';
        $images_regx          = '/Photo\s*[0-9]\'\s*src=\'\/\/(?<img_url>[^\']+)/i';
        $images_fallback_regx = '/<img\s*src=\'\/\/(?<img_url>[^\']+)/i';
        $required_params      = []; // Mandatory url parameters
        $use_proxy            = true; // Uses proxy to reach site
        $keymap               = null; // Return the output data mapped against any car key
        $invalid_images       = ['']; // List of image urls to be filtered out
        $use_custom_site      = true; // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car_data) {
            
           // $car_data['all_images'] = str_replace($car_data['url'], "https://", $car_data['all_images']);
           slecho("img links: " . $car_data['all_images']);
            $car_data['all_images'] = preg_replace('/http[^\/]+\/\/[^\/]+\/[^\/]+\/[^\/]+\/media/', 'https://media', $car_data['all_images']);
           slecho("after img links: " . $car_data['all_images']);
            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/inventory\/(?<stock_type>[^\-]+)\-[0-9]{4}/i',
            'year'           => '/vehicle-year[^>]+>(?<year>[^<]+)/i',
            'make'           => '/vehicle-make[^>]+>(?<make>[^<]+)/i',
            'model'          => '/vehicle-model[^>]+>(?<model>[^<]+)/i',
            'stock_number'   => '/"sku": "(?<stock_number>[^"]+)/',
            'price'          => '/Sale Price[^>]+>[^>]+>(?<price>[^<]+)/',
            'msrp'           => '/Retail Price[^>]+>[^>]+>(?<msrp>[^<]+)/',
            'body_style'     => '/"bodyType": "(?<body_style>[^"]+)/',
            'vin'            => '/"vehicleIdentificationNumber": "(?<vin>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);


