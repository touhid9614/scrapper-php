<?php
global $scrapper_configs;
$scrapper_configs["cansofordca"] = array(
    "entry_points"        => array(
        'new' => 'https://cansoford.ca/inventory-sitemap.xml',
    ),
    'vdp_url_regex'       => '/\/inventory\/[0-9]{4}-[^\/]+\/[0-9]{7,8}/i',
     'srp_page_regex'      => '/\/(?:new|used)-inventory\//',
    'use-proxy'           => false,
    'refine'              => false,
    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://cansoford.ca/inventory-sitemap.xml";
        $vdp_url_regex        = '/\/inventory\/[0-9]{4}-[^\/]+\/[0-9]{7,8}/i';
        $images_regx          = '/Photo5" data-lazy-src="(?<img_url>[^"]+)"/';
        $images_fallback_regx = null;
        $required_params      = []; // Mandatory url parameters
        $use_proxy            = false; // Uses proxy to reach site
        $keymap               = null; // Return the output data mapped against any car key
        $invalid_images       = []; // List of image urls to be filtered out
        $use_custom_site      = true; // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car) {
            $car['stock_type']       = strtolower($car['stock_type']);
            $car['monroney_sticker'] = 'https://www.windowsticker.forddirect.com/windowsticker.pdf?vin=' . $car['vin'];

            // finance_tenure_n_rate
            // $match = [];
            // $rgx   = '/<option\s*value="(?<months>[^"]+)"\s*data-rate="(?<rate>[^"]+)"[^>]+>(?<month_string>[^<]+)/i';

            // if (preg_match_all($rgx, $car['finance_tenure_n_rate'], $match)) {
            //     $out = [];
            //     $monthMax = null;
            //     foreach ($match['months'] as $key => $val) {
            //         $out[$val] = $match['rate'][$key];
            //         $monthMax = $val;
            //     }
            //     $car['finance_tenure_n_rate'] = financing($car['price'], $out);

            //     if ($monthMax) {
            //         $car['custom'] = round($car['finance_tenure_n_rate'][$monthMax]["monthly"]["emi"], 0);
            //     }
            // } else {
            //     $car['finance_tenure_n_rate'] = null;
            // }

            // // lease_tenure_n_rate
            // $match = [];

            // if (preg_match_all($rgx, $car['lease_tenure_n_rate'], $match)) {
            //     $out = [];
            //     $monthMax = null;
            //     foreach ($match['months'] as $key => $val) {
            //         $out[$val] = $match['rate'][$key];
            //         $monthMax = $val;
            //     }
            //     $car['lease_tenure_n_rate'] = financing($car['price'], $out);

            //     if ($monthMax) {
            //         $car['custom_1'] = round($car['lease_tenure_n_rate'][$monthMax]["monthly"]["emi"], 0);
            //     }
            // } else {
            //     $car['lease_tenure_n_rate'] = null;
            // }

            // sleep(1);

            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'            => '/<title>(?<stock_type>[^\s*]+)\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'year'                  => '/itemprop="releaseDate">(?<year>[^<]+)</i',
            'make'                  => '/itemprop="brand">(?<make>[^<]+)</i',
            'model'                 => '/itemprop="model">(?<model>[^<]+)</i',
            'trim'                  => '/itemprop="vehicleConfiguration">(?<trim>[^<]+)</i',
            'price'                 => '/pricing-price">(?<price>[^<]+)/i',
            'vin'                   => '/_vin=(?<vin>[^\&]+)/i',
            'stock_number'          => '/Stock #\:(?<stock_number>[^<]+)/i',

            'doors'                 => '/Doors[^>]+>[^>]+>(?<doors>[^-]+)/i',
            'fuel_type'             => '/Fuel Type[^>]+>[^>]+>(?<fuel_type>[^<]+)<\/h5>/i',
            'body_style'            => '/Body Style[^>]+>[^>]+>(?<body_style>[^<]+)<\/h5>/i',
            'transmission'          => '/Transmission[^>]+>[^>]+>(?<transmission>[^<]+)<\/h5>/i',
            'exterior_color'        => '/Exterior Colour[^>]+>[^>]+>(?<exterior_color>[^<]+)<\/h5>/i',
            'engine'                => '/Engine[^>]+>[^>]+>(?<engine>[^<]+)<\/h5>/i',
            // 'finance_tenure_n_rate' => '/name="finance_term"\s*id="js-calc-small-finance-term"\s*class="terms-input\s*months">(?<finance_tenure_n_rate>(.|\n)*?)<\/div/i',
            // 'lease_tenure_n_rate'   => '/name="lease_term"\s*id="js-calc-small-lease-term"\s*class="terms-input\s*months">(?<lease_tenure_n_rate>(.|\n)*?)<\/div/i'
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);

add_filter('filter_for_fb_cansofordca', 'filter_for_fb_cansofordca', 10, 3);

//function filter_for_fb_cansofordca($car, $feed_type, $car_stock_type, $redis) {
    function filter_for_fb_cansofordca($car, $feed_type, $car_stock_type) {
    //echo("hghg: " . $car['custom']);
//    if ((!isset($car['custom']) || empty(trim($car['custom']))) && isset($car['svin'])) {
//        
//        $val = $redis->get('cansofordca_emi_' . $car['svin']);
//
//        if (!empty($val) && is_numeric(preg_replace('/[^0-9]/', '', $val))) {
//            $car['custom'] = $val;
//        }
//        else{
//            $car['custom']="...";
//        }
//    }
//    

   // $car['custom_1'] = $car['custom'];
        
        $img_arr= explode("|", $car['all_images']);
        if(count($img_arr)<7){
            return null;
        }
        $car['custom']="....";
    return $car;
}
