<?php
global $scrapper_configs;
$scrapper_configs["grantmillerchevbuickgmccom"] = array( 
    'entry_points'        => array(
        'new'  => 'https://www.grantmillerchevbuickgmc.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D3654%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3Dtrue%26sc%3Dnew%26v1%3D%26st%3Dprice%252Casc%26ai%3Dtrue%26oem%3D%26dp%3D3654%252C3759%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dmsrp-inc%26pnpf%3Dinte%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',

        'used' => 'https://www.grantmillerchevbuickgmc.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D3654%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3Dtrue%26sc%3Dused%26v1%3D%26st%3Dprice%252Casc%26ai%3Dtrue%26oem%3D%26dp%3D3654%252C3759%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dmsrp-inc%26pnpf%3Dinte%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
    ),
    'srp_page_regex'      => '/\/vehicles\/(?:new|used)\//',
    'vdp_url_regex'       => '/\/vehicles\/[0-9]+\/[A-z]+\//',

    'ajax_url_match'      => '/libs/formProcessor.html',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'POST',
    'next_method'         => 'POST',

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->results as $obj) {
            $car_data = array(
                'stock_number'   => $obj->stock_number ? $obj->stock_number : $obj->vehicle_id,
                'stock_type'     => strtolower($obj->sale_class),
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'body_style'     => $obj->body_style,
                'price'          => $obj->final_price == 0 ? "please call" : $obj->final_price,
                'engine'         => $obj->engine,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fuel_type,
                'drivetrain'     => $obj->drive_train,
                'msrp'           => $obj->msrp,
                'url'            => strtolower(str_replace(" ","-",$obj->vdp_url)),
                // 'url'            => strtolower("https://www.grantmillerchevbuickgmc.com/vehicles/" . $obj->year . '/' . $obj->make . '/' . str_replace(" ", "-", $obj->model) . '/' . str_replace(" ", "-",$obj->company_data->company_city) . '/' . $obj->company_data->company_province. '/' . $obj->ad_id . '?sale_class=' . $obj->sale_class),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,

            );

            $response_data = HttpGet($car_data['url']);
            $images_regex = '/"image_original":"(?<img_url>[^"]+)/';
            $matches = [];
            if(preg_match_all($images_regex, $response_data, $matches))
            {
                $car_data['images']     = $matches['img_url'];
                $car_data['all_images'] = implode('|', $car_data['images']);
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'         => '/"image_original":"(?<img_url>[^"]+)/',
);

add_filter('filter_grantmillerchevbuickgmccom_car_data', 'filter_grantmillerchevbuickgmccom_car_data');

function filter_grantmillerchevbuickgmccom_car_data($car_data) {
    
    $car_data['url'] = str_replace("http:","https:",$car_data['url']);
    $car_data['url'] = str_replace("com//","com/",$car_data['url']);
    $car_data['all_images'] = str_replace('-2048x1536', '', $car_data['all_images']);
    $car_data['all_images'] = str_replace('\\', '', $car_data['all_images']);
    if(!str_contains($car_data['url'], 'grantmillerchevbuickgmc.com')){
        $car_data = [];
    }

    return $car_data;
}

add_filter('filter_for_fb_grantmillerchevbuickgmccom', 'filter_for_fb_grantmillerchevbuickgmccom', 10, 2);
function filter_for_fb_grantmillerchevbuickgmccom($car_data, $feed_type)
{
   
    //$car_data['all_images'] = str_replace('-2048x1536', '', $car_data['all_images']);
    //echo $car_data['all_images'];
    
    //echo $car_data['all_images'];
    return $car_data;
}




// 	'entry_points'        => array(
//         'used' => 'https://www.grantmillerchevbuickgmc.com/used-vehicle-1-sitemap.xml',
//     ),

//     'srp_page_regex'      => '/\/vehicles\/(?:new|used)\//',
//     'vdp_url_regex'       => '/\/vehicles\/[0-9]+\/[A-z]+\//',
//     "use-proxy"           => false,
//     'refine'              => false, 

//     "custom_data_capture" => function ($url, $data) {
//         $site                 = "https://www.grantmillerchevbuickgmc.com/used-vehicle-1-sitemap.xml";
//         $another_site         = "https://www.grantmillerchevbuickgmc.com/new-vehicle-1-sitemap.xml";
//         $vdp_url_regex        = '/\/vehicles\/[0-9]+\/[A-z]+\//';
//         $images_regx          = '/"image_original":"(?<img_url>[^"]+)/i';
//         $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
//         $required_params      = [];     // Mandatory url parameters
//         $use_proxy            = false;   // Uses proxy to reach site
//         $keymap               = null;   // Return the output data mapped against any car key
//         $invalid_images       = [];     // List of image urls to be filtered out
//         $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

//         // Modify car data if needed
//         $annoy_func = function ($car_data) {
//             $car_data['stock_type'] = strtolower($car_data['stock_type']);

//             return $car_data;
//         };

//         $data_capture_regx_full = [
//             'stock_type'   => '/\?sale_class\=(?<stock_type>[^"]+)"\s*\/>/i',
//             'stock_number' => '/"stock_number":"(?<stock_number>[^"]+)"\,"sty/',
//             'vin'          => '/"vin":"(?<vin>[^"]+)"\,"a/',
//             'year'         => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
//             'make'         => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
//             'model'        => '/"year":(?<year>[^\,]+)\,"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"\,"m/',
//             'price'        => '/"final_price":(?<price>[^\,]+)/',
//         ];
//         $new_cars  = sitemap_crawler($another_site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

//         $used_cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

//         return array_merge($new_cars, $used_cars);
//     }
// );
