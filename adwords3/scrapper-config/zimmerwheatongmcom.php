<?php
global $scrapper_configs;
$scrapper_configs["zimmerwheatongmcom"] = array( 
	'entry_points' => array(
            'new'   => 'https://service.vehicles.sm360.ca/inventory/vehicles?includeMetadata=true&location=BC&organizationId=6076&organizationUnitId=1961',  
        'used'   => 'https://service.vehicles.sm360.ca/inventory/vehicles-used?includeMetadata=true&location=BC&organizationId=802&organizationUnitId=1961',
        
    ), 
    'vdp_url_regex'     => '/\/en\/(?:new|used)-(?:catalog|inventory)\/[^\/]+\/[^\/]+\/[0-9]{4}/i', 
    'srp_page_regex'         => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
    'refine'            => false,
    'content_type' => 'application/json;charset=UTF-8',
    'init_method' => 'POST',
    'next_method' => 'POST',
    'use-proxy'     => true,
    'proxy-area'    => 'CA',
    'additional_headers' => array(
        //"Content-Length" => "94449",
    ),

   'custom_data_capture' => function($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return array();
        }

    $to_return = array();
    
    foreach ($objects->inventoryVehicles as $obj) {
        
        $car_data = array(
            'stock_number' => $obj->stockNo,
            'year' => $obj->year,
            'make' => explode(" ",$obj->make->name)[0],
            'model' => $obj->model->name,
            'price' => $obj->paymentOptions->cashPurchase->sellingPrice,
            'kilometres' => $obj->odometer, 
            // 'vin'        => $obj->serialNo,
            'body_style' => $obj->bodyStyle->slug,
            'exterior_color' => $obj->exteriorColor->colorDescription,
            'interior_color' => $obj->interiorColor->colorDescription,
            'fuel_type' => $obj->fuel->name,
            'vin' => $obj->serialNo,
         );

        
        
            if($obj->newVehicle){
                $car_data['url']=strtolower("https://www.zimmerwheatongm.com/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-' .'id' . $obj->vehicleId);

              
                $car_data['all_images'] = 'https://img.sm360.ca/images/newcar/' . $obj->multimedia->exterior->side;
            }
            else{
                $car_data['url']=strtolower("https://www.zimmerwheatongm.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId);

                //making image URL
                $all_images = [];
                foreach($obj->multimedia->pictures as $picture){
                    $all_images[] = 'https://img.sm360.ca/images/inventory' . $picture;
                }
                $car_data['all_images'] = implode("|", $all_images);
            }

            $to_return[] = $car_data;
        }
        return $to_return;
},

);

add_filter('filter_zimmerwheatongmcom_post_data', 'filter_zimmerwheatongmcom_post_data', 10, 2);

function filter_zimmerwheatongmcom_post_data($post_data, $stock_type) {

if ($stock_type == 'used') {
    $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[44,42],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"colanderSlug":"used-zimmer-gmc","soldDaysShown":0,"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]},"isMarketplaceRequest":false}';
}
else{
    $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[44,42],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"colanderSlug":"new-without-cadillac","soldDaysShown":0,"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]},"isMarketplaceRequest":false}';
}

    return $post_data;
}