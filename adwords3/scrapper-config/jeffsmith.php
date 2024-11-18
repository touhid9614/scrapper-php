<?php
global $scrapper_configs;

$scrapper_configs['jeffsmith'] = array(
    'entry_points'        => array(
        'used' => 'https://www.countychevroletessex.com/en/sitemap_index.xml',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]+\//',
    "use-proxy"           => false,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.countychevroletessex.com/used-vehicle-1-sitemap.xml";
        $another_site         = "https://www.countychevroletessex.com/new-vehicle-1-sitemap.xml";
        $vdp_url_regex        = '/\/vehicles\/[0-9]+\//';
        $images_regx          = '/"image_original":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = []; // Mandatory url parameters
        $use_proxy            = false; // Uses proxy to reach site
        $keymap               = null; // Return the output data mapped against any car key
        $invalid_images       = ['https://www.countychevroletessex.com/wp-content/themes/convertus-achilles/achilles/assets/images/srp-placeholder/PV.jpg']; // List of image urls to be filtered out
        $use_custom_site      = true; // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $car_data['stock_type'] = strtolower($car_data['stock_type']);

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'   => '/\?sale_class\=(?<stock_type>[^"]+)"\s*\/>/i',
            'stock_number' => '/"stock_number":"(?<stock_number>[^"]+)"\,"sty/',
            'vin'          => '/"vin":"(?<vin>[^"]+)"\,"a/',
            'year'         => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'make'         => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'model'        => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
            'price'        => '/"final_price":(?<price>[^\,]+)/',
            'kilometres'   => '/"odometer":(?<kilometres>[0-9]+)/',
        ];

        $new_cars  = sitemap_crawler($another_site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        $used_cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return array_merge($new_cars, $used_cars);
    }
);
// add_filter("filter_jeffsmith_field_images", "filter_jeffsmith_field_images", 10, 2);

// function filter_jeffsmith_field_images($im_urls, $car_data)
// {
//     if (isset($car_data['stock_number']) && $car_data['stock_number']) {
//         $api_url = "https://api.spincar.com/spin/nottautocorp/{$car_data['stock_number']}";

//         $response_data = HttpGet($api_url, false, false);

//         if ($response_data) {
//             $obj = json_decode($response_data);

//             for ($i = 0; $i < $obj->info->options->numImgCloseup; $i++) {
//                 $img       = "{$obj->cdn_image_prefix}closeups/cu-{$i}.jpg";
//                 $im_urls[] = str_replace('//', 'https://', $img);
//             }
//         }
//     }

//     return $im_urls;
// }