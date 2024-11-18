<?php

global $scrapper_configs;

$scrapper_configs['winegardford'] = array(
    'entry_points'        => array(
        'used' => 'https://www.winegardford.com/used-vehicle-1-sitemap.xml',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]+\//',
    "use-proxy"           => true,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.winegardford.com/used-vehicle-1-sitemap.xml";
        $another_site         = "https://www.winegardford.com/new-vehicle-1-sitemap.xml";
        $vdp_url_regex        = '/\/vehicles\/[0-9]+\//';
        $images_regx          = '/"image_original":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = true;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        // Modify car data if needed
        $annoy_func = function ($car_data) {
            $car_data['stock_type'] = strtolower($car_data['stock_type']);
            
            $retval = [];
           $im_urls= explode('|', $car_data['all_images']);

            foreach ($im_urls as $im_url) {
                $retval[] = str_replace(['\\'], [''], rawurldecode($im_url));
            }

            $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);
            $car_data['all_images']= implode('|', $retval);
            
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
    }
);

add_filter("filter_winegardford_field_images", "filter_winegardford_field_images");

function filter_winegardford_field_images($im_urls) {
    if(count($im_urls)<=2)
    {
        return [];
    }
    return $im_urls;
}
