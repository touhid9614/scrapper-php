<?php

global $scrapper_configs;

$scrapper_configs['lindsaygm'] = array(
    'entry_points'        => array(
        'used' => 'https://www.lindsaygm.ca/used-vehicle-1-sitemap.xml',
    ),

    'srp_page_regex'      => '/\/vehicles\/(?:new|used)\//',
    'vdp_url_regex'       => '/\/vehicles\/[0-9]+\/[^\/]+.*\/on\/[0-9]{7,9}/',
    "use-proxy"           => true,
    'refine'              => false, 

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.lindsaygm.ca/used-vehicle-1-sitemap.xml";
        $another_site         = "https://www.lindsaygm.ca/new-vehicle-1-sitemap.xml";
        $vdp_url_regex        = '/\/vehicles\/[0-9]+\/[^\/]+.*\/on\/[0-9]{7,9}/';
        $images_regx          = '/"image_original":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

//        // Modify car data if needed
//        $annoy_func = function ($car_data) {
//
//            $img_urls = explode('|', $car_data['all_images']);
//            if(count($img_urls) < 3)
//            {
//                return [];
//            }
//            $car_data['all_images'] = implode('|', $img_urls);
//       
//            $car_data['stock_type'] = strtolower($car_data['stock_type']);
//            $car_data['images'] = array_map(function ($value) {
//                return str_replace($car_data['url'], '', $value);
//            }, $car_data['images']);
//
//           
//            return $car_data;
//        };
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
        ];
        $new_cars  = sitemap_crawler($another_site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        $used_cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return array_merge($new_cars, $used_cars);
    }
);

add_filter('filter_for_fb_lindsaygm', 'filter_for_fb_lindsaygm', 10, 2);

function filter_for_fb_lindsaygm($car_data, $feed_type)
{
    $images = explode('|', $car_data['all_images']);

    if (!in_array($feed_type, ['google-merchant', 'google-marchant', 'google_merchant', 'google_marchant'])) {
        
        $myimg = array_values($images);
        $car_data['images'] = $myimg;
        $car_data['all_images'] = implode('|', $myimg);
        
        if (strpos($car_data['all_images'], "srp-placeholder") || strpos($car_data['all_images'], "stock-images")) {
        return null;
    }

        return $car_data;
    }
    unset($images[0]);
    $myimg = array_values($images);
    $car_data['images'] = $myimg;
    $car_data['all_images'] = implode('|', $myimg);
    
    if (strpos($car_data['all_images'], "srp-placeholder") || strpos($car_data['all_images'], "stock-images")) {
        return null;
    }

    return $car_data;
}
