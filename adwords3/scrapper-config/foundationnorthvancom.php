<?php
global $scrapper_configs;
$scrapper_configs["foundationnorthvancom"] = array( 
    'entry_points' => array(
        'new'  => 'https://wordpresscontrol.omni.auto/Inventory/GetAllVehiclesFiltered?siteID=573ee9c3-070f-41a1-b93e-af3c62e2ac5d&callFromSRP=true',
        'used' => 'https://wordpresscontrol.omni.auto/Inventory/GetAllVehiclesFiltered?siteID=573ee9c3-070f-41a1-b93e-af3c62e2ac5d&callFromSRP=true&',
        
    ),
    'vdp_url_regex' => '/\/Vehicle-Detail-Page/',
    'srp_page_regex' => '/\/inventory-page-(used|new)/',
    'use-proxy' => true,
    'required_params' => ['vdpVin'],
    'init_method' => 'POST',
    'next_method' => 'POST',
    'content_type' => 'multipart/form-data',
    'additional_headers' => ['origin' => 'https://coastchryslernorthvan.ca'],

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];
        foreach ($objects->SiteInventoryCollection as $obj) {
            $car_data = array(
                'stock_number' => $obj->StockNumber,
                'year' => $obj->Year,
                'stock_type' => strtolower($obj->InventoryType),
                'make' => $obj->Make,
                'model' => strtolower($obj->Model),
                'price' => $obj->InventoryCalculatedPricingViewModel->CalculatedPrice,
                'kilometres' => $obj->Kilometers,
                'vin' => $obj->Vin,
                'transmission' => $obj->Transmission, 
                'engine' => $obj->EngineSizeDisplay,
                'url'          => "https://coastchryslernorthvan.ca/Vehicle-Detail-Page/" . $obj->Year . "-" . str_replace(' ', '', $obj->Make) . "-" . str_replace(' ', '', $obj->Model) . "-" . str_replace('/', '-', $obj->Trim) . "-" . $obj->Vin . "?" . "vdpVin=" . $obj->Vin,
                'all_images' => "https://wordpresscontrol.omni.auto/Media/InventoryMedia/" . $obj->Vin . "/Medium/" . $obj->MediaFile->FileName,
            );


            $api_url = "https://wordpresscontrol.omni.auto/Inventory/GetSiteInventoryByVIN?vin={$obj->Vin}&dealerCode=C9095";
            slecho("api url:" . $api_url);
            $useProxy = true;
            $random_proxy = true;
            $in_cookies = '';
            $out_cookies = '';
            $content_type = 'application/json';
            $additional_headers = ['Origin' => 'https://coastchryslernorthvan.ca'];
            $annoy_func = null;
            $response_data = HttpGet($api_url, $useProxy, $random_proxy, $in_cookies, $out_cookies, $content_type, $additional_headers, $annoy_func);
            $regex = '/externalSource":\s*"(?<img_url>[^"]+)"/';
            //slecho("imgs url:" . $response_data);
            $matches = [];
            $im_urls=[];

//             if (preg_match_all($regex, $response_data, $matches)) {

// //                foreach ($matches['img_url'] as $key => $value) {
// //                    $im_urls[] = $value;
// //                }
               
//                 $car_data['all_images']=implode('|', $matches['img_url']);
//                  slecho("imgs url:" . $car_data['all_images']);
//             }
            
            $to_return[] = $car_data;
        }
        return $to_return;
    },
);

add_filter('filter_foundationnorthvancom_post_data', 'filter_foundationnorthvancom_post_data', 10, 2);

function filter_foundationnorthvancom_post_data($post_data, $stock_type) {

    $post_data = [ 
        'dealercode' => 'C9095',
        'query' => '',
        'make' => '',
        'skip' => '',
        'take' => '',
        'orderby' => '',
        'orderbyDir' => '',
        'inventoryType' => $stock_type,
        'model' => '',
        'year' => '',
        'bodystyle' => '',
        'driveType' => '',
        'transmission' => '',
        'engine' => '',
        'mileage' => '',
        'exteriorColor' => '',
        'interiorColor' => '',
        'fuelType' => '',
        'priceMax' => '',
        'priceMin' => '',
        'mileageMin' => '',
        'mileageMax' => '',
        'yearMax' => '',
        'yearMin' => '',
        'url' => '',
    ];

    return $post_data;
}

add_filter('filter_foundationnorthvancom_car_data', 'filter_foundationnorthvancom_car_data');

function filter_foundationnorthvancom_car_data($car_data)
{         
    if (trim($car_data['stock_number']) == '') {
        $car_data['stock_number'] = $car_data['vin'];
    }    
    if($car_data['model'] == "Wagoneer L" || $car_data['model'] == "Wagoneer"){
        $car_data['custom'] = 1;
    }
    else{
        $car_data['custom'] = 0;
    }

    if(str_contains($car_data['all_images'], '.jpg') || str_contains($car_data['all_images'], '.png') || str_contains($car_data['all_images'], '.jpeg')){
        $car_data['all_images'] = $car_data['all_images'];
    }
    else{
        //removing comming soon Image
        //https://app.guidecx.com/app/projects/e66aa954-6bd4-4cb0-b36d-98eef4d89478/notes
        $car_data['all_images'] = "";
        // $car_data['all_images'] = "https://coastchryslernorthvan.ca/wp-content/uploads/Coast-Image-Placeholder-Blue.png";
    }

    return $car_data;
}

add_filter('filter_for_fb_foundationnorthvancom', 'filter_for_fb_foundationnorthvancom', 10, 2);

function filter_for_fb_foundationnorthvancom($car_data, $feed_type)
{
    if (in_array($feed_type, ['google-merchant', 'google-marchant', 'google_merchant', 'google_marchant', 'google-shopping'])) {
        if($car_data['stock_type'] == "new"){
            $converted_kilometres = (int)$car_data['kilometres'];
            if($converted_kilometres>=200){
                $car_data = [];
            }
        }  

        return $car_data;
    }

    return $car_data;
}
