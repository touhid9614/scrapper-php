<?php
global $scrapper_configs;
$scrapper_configs["marchantchevynet"] = array( 
	'entry_points'        => array(
        'new' => 'https://www.marchantchevy.net/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.marchantchevy.net/sitemap-inventory-sincro.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/og:image" content="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/og:image" content="(?<img_url>[^"]+)/i';
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png',
                                 'https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
                                 'https://media.assets.sincrod.com/websites/5.0-9057/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png',
            ];

        $data_capture_regx_full = [
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'stock_number'   => '/stockNumber":"(?<stock_number>[^"]+)/',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin'           => '/vin":"(?<vin>[^"]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price'          => '/(?:msrp|price)":"(?<price>[^"]+)/',
            'kilometres'        =>'/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);


// add_filter("filter_marchantchevynet_next_page", "filter_marchantchevynet_next_page", 10, 2);

// function filter_marchantchevynet_next_page($next, $current_page)
// {
// 	slecho("Filtering Next url");
// 	$car_type = explode('=', $current_page);
// 	return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
// }