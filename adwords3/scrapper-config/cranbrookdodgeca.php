<?php
global $scrapper_configs;
$scrapper_configs["cranbrookdodgeca"] = array(
    'entry_points'        => array(
        'used' => 'https://wordpresscontrol.omni.auto/Inventory/GetAllVehiclesFiltered?siteID=2df4d4d2-4f22-4859-900e-4dddc344c0dd&callFromSRP=true',
        
    ),

    'vdp_url_regex'       => '/\/Vehicle-Detail-Page\/[0-9]{4}-/',
    'srp_page_regex'      => '/\/inventory-page-(?:new|used)/',
    'use-proxy'           => true,
    'required_params' => ['vdpVin'],

    'init_method'         => 'POST',
    'next_method'         => 'POST',
    'content_type'        => 'multipart/form-data',
    'additional_headers'  => ['origin' => 'https://cranbrookdodge.ca'],

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->SiteInventoryCollection as $obj) {
            $car_data = array(
                'stock_number' => $obj->StockNumber,
                'year'         => $obj->Year,
                'stock_type'   => strtolower($obj->InventoryType),
                'make'         => $obj->Make,
                'model'        => strtolower($obj->Model),
                //'price'        => $obj->PriceMsrp,
                'price'        => $obj->InventoryCalculatedPricingViewModel->CalculatedPrice, 
                'kilometres'   => $obj->Kilometers,
                'vin'          => $obj->Vin,
                'transmission' => $obj->Transmission,
                'engine'       => $obj->EngineSizeDisplay,
                // 'url'          => "https://cranbrookdodge.ca/Vehicle-Detail-Page?vdpVin=" . $obj->Vin,
                'url'          => "https://cranbrookdodge.ca/Vehicle-Detail-Page/" . $obj->Year . "-" . str_replace(' ', '', $obj->Make) . "-" . str_replace(' ', '', $obj->Model) . "-" . str_replace(' ', '', $obj->Trim) . "?" . "vdpVin=" . $obj->Vin,
                // 'all_images'   => "https://wordpresscontrol.omni.auto/Media/ReturnMediaFile/" . isset($obj->MediaFile->FileName),
            );

            if(isset($obj->MediaFile->FileName)){
                $car_data['all_images'] = "https://wordpresscontrol.omni.auto/Media/ReturnMediaFile/" . $obj->MediaFile->FileName;
            }

            $response_data = HttpGet($car_data['url']);
            $regex         = '/<div class="text-description">\s*<p>(?<description>[^<]+)<\/p>\s*<\/div>\s*<\/div>\s*<div id="partscenter/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }


            $to_return[] = $car_data;
        }
        return $to_return;
    },
);

add_filter('filter_cranbrookdodgeca_post_data', 'filter_cranbrookdodgeca_post_data', 10, 0);

function filter_cranbrookdodgeca_post_data()
{
    $post_data = [
        'dealercode'    => 'C9031',
        'query'         => '',
        'make'          => '',
        'skip'          => '',
        'take'          => '',
        'orderby'       => '',
        'orderbyDir'    => '',
        'inventoryType' => '',
        'model'         => '',
        'year'          => '',
        'bodystyle'     => '',
        'driveType'     => '',
        'transmission'  => '',
        'engine'        => '',
        'mileage'       => '',
        'exteriorColor' => '',
        'interiorColor' => '',
        'fuelType'      => '',
        'priceMax'      => '',
        'priceMin'      => '',
        'mileageMin'    => '',
        'mileageMax'    => '',
        'yearMax'       => '',
        'yearMin'       => '',
        'url'           => '',
    ];

    return $post_data;
}

add_filter('filter_cranbrookdodgeca_car_data', 'filter_cranbrookdodgeca_car_data');
function filter_cranbrookdodgeca_car_data($car_data) {

    if(trim($car_data['stock_number'])==''){
       $car_data['stock_number'] = $car_data['vin'];
    }
    return $car_data;
}


