<?php
global $scrapper_configs;
$scrapper_configs["oxnardmazdacom"] = array(
    'entry_points'        => array(
        'all' => 'https://www.oxnardmazda.com/dealer-inspire-inventory/inventory_sitemap',
    ),

    'vdp_url_regex'       => '/(?:express\/(?:used\/|)[A-Z0-9]{17}+|(?:certified-used|used|new)\-)/i',
    'srp_page_regex'      => '/\/inventory\/(?:new|used)\?/i',
    "use-proxy"           => false,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://express.oxnardmazda.com/sitemaps/sitemap.xml";
        $another_site         = "https://www.oxnardmazda.com/dealer-inspire-inventory/inventory_sitemap";
        $vdp_url_regex        = '/(?:express\/(?:used\/|)[A-Z0-9]{17}+|(?:certified-used|used|new)\-)/i';
        $images_regx          = '/<img src="(?<img_url>[^"]+)"\s*alt="[0-9]/i';
        $images_fallback_regx = '/"image" : "(?<img_url>[^"]+)",/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = false;  // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car) {
            // if($car['make'] == "" || $car['model'] == "" || $car['year'] == ""){
            //     $car = [];
            // }
            if($car['custom_2'] != NULL){
                if(strpos($car['url'], "express.oxnardmaz") !== false){
                    $car['all_images'] = "https://" . $car['custom_2'];
                }
            }

            if(strlen($car['stock_number']) > 10 || $car['stock_number'] == ""){
                $car['stock_number'] = $car['custom_1'];
            }
            
            if (strtolower($car['model']) == "mazda3 sedan" || strtolower($car['model']) == "3 sedan") {
                $car["model"] = "3";
            }

            if ($car['stock_type'] == "certified" || $car['stock_type'] == "Certified") {
                $car['stock_type'] = 'cpo';
            }

            if($car['stock_type'] == "New"){
                $car['stock_type'] = "new";
            }
            else{
                $car['stock_type'] = "used";
            }
            if(strpos($car['url'],"inventory/new")){
                     $car['stock_type']= "new";
                 }

            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'   => '/"og:description" content="(?<stock_type>[^\s*]+)/',
            'custom_2'   => '/property="og:image" content="\/\/(?<custom_2>[^"]+)/',
            'year'         => '/"year":(?:"|)(?<year>[0-9]{4}+)(?:\"\,|\,)\"(?:make|license_fee|body)/i',
            'custom_1'     => '/class="stock">STOCK:(?<custom_1>[^<]+)/i',
            'make'         => '/"make":"(?<make>[A-z]+)"\,.model":"(?<model>[^"]+)/i',
            'model'        => '/"make":"(?<make>[A-z]+)"\,.model":"(?<model>[^"]+)/i',
            // 'trim'         => '/"og:title"\s*content="(?<stock_type>[^\s*]+)\s*(?:Pre-Owned|)+\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/i',
            'price'        => '/"price":(?:\s*|")(?<price>[0-9]+)/i',
            'stock_number' => '/(?:STOCK:|"stock_number":")(?<stock_number>[A-z\s*0-9]+)/i',
            'vin'          => '/"vin":"(?<vin>[A-z0-9]{17})/i',
            'kilometres'   => '/Mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'body_style'   => '/"bodytype":"(?<body_style>[^"]+)/',
        ];
        $cars         = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        $another_cars = sitemap_crawler($another_site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return array_merge($cars, $another_cars);
    }
);

//     'entry_points'      => array(
//         'subdomain'  => 'https://express.oxnardmazda.com/sitemaps/sitemap.xml',
//         'main_domain' => 'https://www.northbaytoyota.com/en/used-inventory/api/listing?limit=500',
//     ),

//     'subdomain'           => array(
//         'vdp_url_regex'       => '/\/express\/(?:new|used|certified|[A-z]+|[0-9]+)+/i',
//         'srp_page_regex'      => '/\/inventory\/(?:new|used)\?/i',
//         "use-proxy"           => false,
    
//         "custom_data_capture" => function ($url, $data) {
//             $site                 = "https://express.oxnardmazda.com/sitemaps/sitemap.xml";
//             $vdp_url_regex        = '/\/express\/(?:new|used|certified|[A-z]+|[0-9]+)+/i';
//             $images_regx          = '/<img src="(?<img_url>[^"]+)"\s*alt="[0-9]/i';
//             $images_fallback_regx = '/"image" : "(?<img_url>[^"]+)",/i';
//             $required_params      = [];     // Mandatory url parameters
//             $use_proxy            = false;  // Uses proxy to reach site
//             $keymap               = null;   // Return the output data mapped against any car key
//             $invalid_images       = [];     // List of image urls to be filtered out
//             $use_custom_site      = true;   // Force crawler to use the given url as sitemap url
    
//             $annoy_func = function ($car) {
//                 if($car['make'] == "" || $car['model'] == "" || $car['year'] == ""){
//                     $car = [];
//                 }
//                 if (strtolower($car['model']) == "mazda3 sedan" || strtolower($car['model']) == "3 sedan") {
//                     $car["model"] = "3";
//                 }
    
//                 if ($car['stock_type'] == "certified" || $car['stock_type'] == "Certified") {
//                     $car['stock_type'] = 'cpo';
//                 }
    
//                 if ($car['stock_type'] == "pre-owned" || $car['stock_type'] == "Pre-Owned") {
//                     $car['stock_type'] = "used";
//                 }

//                 $car['stock_type'] = strtolower($car['stock_type']);
    
//                 return $car;
//             };
    
//             $data_capture_regx_full = [
//                 'stock_type'   => '/"og:description" content="(?<stock_type>[^\s*]+)/',
//                 'year'         => '/"year":(?<year>[^\,]+)/i',
//                 'make'         => '/"make":"(?<year>[^"]+)/i',
//                 'model'        => '/"model":"(?<model>[^"]+)/i',
//                 'trim'         => '/"og:title"\s*content="(?<stock_type>[^\s*]+)\s*(?:Pre-Owned|)+\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/i',
//                 'price'        => '/"price": "(?<price>[^"]+)/i',
//                 'stock_number' => '/STOCK:(?<stock_number>[^<]+)/i',
//                 'vin'          => '/VIN:(?<vin>[^<]+)/i',
//                 'kilometres'   => '/Mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
//                 'body_style'   => '/"bodytype":"(?<body_style>[^"]+)/',
//             ];
//             $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
//             return $cars;
//         },
//     ),
//     'main_domain'              => array(
//         'vdp_url_regex'       => '/\/inventory\/(?:new|used|certified)\-[0-9]{4}/i',
//         'srp_page_regex'       => '/\/inventory\/(?:new|used)\?/i',
//         "use-proxy"           => false,
    
//         "custom_data_capture" => function ($url, $data) {
//             $site                 = "https://www.oxnardmazda.com/dealer-inspire-inventory/inventory_sitemap";
//             $vdp_url_regex        = '/\/inventory\/(?:new|used|certified)\-[0-9]{4}/i';
//             $images_regx          = '/<img src="(?<img_url>[^"]+)"\s*alt="[0-9]/i';
//             $images_fallback_regx = '/"image" : "(?<img_url>[^"]+)",/i';
//             $required_params      = [];     // Mandatory url parameters
//             $use_proxy            = false;  // Uses proxy to reach site
//             $keymap               = null;   // Return the output data mapped against any car key
//             $invalid_images       = [];     // List of image urls to be filtered out
//             $use_custom_site      = true;   // Force crawler to use the given url as sitemap url
    
//             $annoy_func = function ($car) {
//                 if($car['make'] == "" || $car['model'] == "" || $car['year'] == ""){
//                     $car = [];
//                 }
//                 if (strtolower($car['model']) == "mazda3 sedan" || strtolower($car['model']) == "3 sedan") {
//                     $car["model"] = "3";
//                 }
    
//                 if ($car['stock_type'] == "certified" || $car['stock_type'] == "Certified") {
//                     $car['stock_type'] = 'cpo';
//                 }
    
//                 if ($car['stock_type'] == "pre-owned") {
//                     $car['stock_type'] = "used";
//                 }
    
//                 return $car;
//             };
    
//             $data_capture_regx_full = [
//                 'stock_type'   => '/"og:title"\s*content="(?<stock_type>[^\s*]+)/',
//                 'year'         => '/"og:title"\s*content="(?<stock_type>[^\s*]+)\s*(?:Pre-Owned|)+\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/i',
//                 'make'         => '/"og:title"\s*content="(?<stock_type>[^\s*]+)\s*(?:Pre-Owned|)+\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/i',
//                 'model'        => '/"og:title"\s*content="(?<stock_type>[^\s*]+)\s*(?:Pre-Owned|)+\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/i',
//                 'trim'         => '/"og:title"\s*content="(?<stock_type>[^\s*]+)\s*(?:Pre-Owned|)+\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/i',
//                 'price'        => '/"price": "(?<price>[^"]+)/i',
//                 'stock_number' => '/STOCK:(?<stock_number>[^<]+)/i',
//                 'vin'          => '/VIN:(?<vin>[^<]+)/i',
//                 'kilometres'   => '/Mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
//                 'body_style'   => '/"bodytype":"(?<body_style>[^"]+)/',
//             ];
//             $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
//             return $cars;
//         },
//     ),
// );

