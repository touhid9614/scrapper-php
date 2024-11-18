<?php

global $scrapper_configs;
$scrapper_configs["energydodgecom"] = array(
    'entry_points' => array(
        'new'  => 'https://wordpresscontrol.omni.auto/Inventory/GetAllVehiclesFiltered?siteID=a049d0d5-5927-49b8-ac5d-22a7c8032db3&callFromSRP=true',
        'used' => 'https://wordpresscontrol.omni.auto/Inventory/GetAllVehiclesFiltered?siteID=a049d0d5-5927-49b8-ac5d-22a7c8032db3&callFromSRP=true&',
        
    ),
    'vdp_url_regex' => '/\/Vehicle-Detail-Page/',
    'srp_page_regex' => '/\/inventory-page-(used|new)/',
    'use-proxy' => true,
    'required_params' => ['vdpVin'],
    'init_method' => 'POST',
    'next_method' => 'POST',
    'content_type' => 'multipart/form-data',
    'additional_headers' => ['origin' => 'https://energydodge.com'],
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts' => ['button.modal-slideshow__next'],
    'picture_prevs' => ['button.modal-slideshow__prev'],
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
                //'price'        => $obj->PriceMsrp,
                'price' => $obj->InventoryCalculatedPricingViewModel->CalculatedPrice,
                'kilometres' => $obj->Kilometers,
                'vin' => $obj->Vin,
                'transmission' => $obj->Transmission,
                'engine' => $obj->EngineSizeDisplay,
                'url' => "https://energydodge.com/Vehicle-Detail-Page?vdpVin=" . $obj->Vin,
                'all_images' => "https://wordpresscontrol.omni.auto/Media/InventoryMedia/" . $obj->Vin . "/Optimized/" . $obj->MediaFile->FileName,
            );
            $api_url = "https://wordpresscontrol.omni.auto/Inventory/GetSiteInventoryByVIN?vin={$obj->Vin}&dealerCode=C7058";
            slecho("api url:" . $api_url);
            $useProxy = true;
            $random_proxy = true;
            $in_cookies = '';
            $out_cookies = '';
            $content_type = 'application/json';
            $additional_headers = ['Origin' => 'https://energydodge.com'];
            $annoy_func = null;
            $response_data = HttpGet($api_url, $useProxy, $random_proxy, $in_cookies, $out_cookies, $content_type, $additional_headers, $annoy_func);
            $regex = '/externalSource":\s*"(?<img_url>[^"]+)"/';
            //slecho("imgs url:" . $response_data);
            $matches = [];
            $im_urls=[];

            if (preg_match_all($regex, $response_data, $matches)) {

//                foreach ($matches['img_url'] as $key => $value) {
//                    $im_urls[] = $value;
//                }
               
                $car_data['all_images']=implode('|', $matches['img_url']);
                 slecho("imgs url:" . $car_data['all_images']);
            }
            
            $to_return[] = $car_data;
        }
        return $to_return;
    },
);

add_filter('filter_energydodgecom_post_data', 'filter_energydodgecom_post_data', 10, 2);

function filter_energydodgecom_post_data($post_data, $stock_type) {

    $post_data = [
        'dealercode' => 'C7058',
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

add_filter('filter_energydodgecom_car_data', 'filter_energydodgecom_car_data');

function filter_energydodgecom_car_data($car_data) {

    if (trim($car_data['stock_number']) == '') {
        $car_data['stock_number'] = $car_data['vin'];
    }
    return $car_data;
}

add_filter('filter_for_fb_energydodgecom', 'filter_for_fb_energydodgecom', 10, 2);
function filter_for_fb_energydodgecom($car_data, $feed_type)
{
   // echo "dddddd:" . $car_data['stock_number'];
    if ($car_data['make'] == "") {
        return null;
    }

    return $car_data;
}
