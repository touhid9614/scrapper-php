<?php
global $scrapper_configs;
 $scrapper_configs["surreymitsubishi"] = array( 
    'entry_points'        => array(
        'used' => 'https://www.surreymitsubishi.ca/used-vehicle-1-sitemap.xml',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]+\//',
    "use-proxy"           => true,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.surreymitsubishi.ca/used-vehicle-1-sitemap.xml";
        $another_site         = "https://www.surreymitsubishi.ca/new-vehicle-1-sitemap.xml";
        $vdp_url_regex        = '/\/vehicles\/[0-9]+\//';
        $images_regx          = '//i';
        $images_fallback_regx = '//i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $car_data['stock_type'] = strtolower($car_data['stock_type']);

            if($car_data['make'] == "" && $car_data['model'] == ""){
                $car_data = [];
            }

            $temp_data = HttpGet($car_data['url']);
            $images_regex = '/"image":"(?<img_url>[^"]+)/';
            $matches = [];
            if(preg_match_all($images_regex, $temp_data, $matches))
            {
                $img_urls = [];
                $img_urls  =  $matches['img_url'];

                $car_data['all_images'] = implode('|', $img_urls);
            }
            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/\?sale_class\=(?<stock_type>[^"]+)"\s*\/>/i',
            'stock_number'   => '/"stock_number":"(?<stock_number>[^"]+)"\,"sty/',
            'vin'           => '/"vin":"(?<vin>[^"]+)"\,"a/',
            'year'           => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'make'           => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'model'          => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'price'          => '/"final_price":(?<price>[^\,]+)/',
        ];

        $new_cars = sitemap_crawler($another_site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        $used_cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return array_merge($new_cars, $used_cars);
         // return $new_cars;
    }
);
