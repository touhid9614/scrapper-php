<?php
global $scrapper_configs;
$scrapper_configs["tonygrahamlexuscom"] = array(
    'entry_points'      => array(
        'used'   => 'https://service.vehicles.sm360.ca/inventory/vehicles-used?includeMetadata=true&location=ON&organizationId=5067&organizationUnitId=8830',
        'new'    => 'https://service.vehicles.sm360.ca/inventory/vehicles-new?includeMetadata=true&location=ON&organizationId=5067&organizationUnitId=8830',  
    ),
	'use-proxy' => true,
	'content_type' => 'application/json;charset=UTF-8',
	'init_method' => 'POST',
	'next_method' => 'POST',
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
                'stock_number' => $obj->stockNo?$obj->stockNo:$obj->serialNo,
                'year' => $obj->year,
                'make' => $obj->make->name,
                'model' => $obj->model->name,
                'price' => $obj->paymentOptions->cashPurchase->sellingPrice,
                'kilometres' => $obj->odometer, 
                'vin'        => $obj->serialNo,
                'body_style' => $obj->bodyStyle->slug,
                'exterior_color' => $obj->exteriorColor->colorDescription,
                'interior_color' => $obj->interiorColor->colorDescription,
                'all_images'   => $obj->multimedia->mainPicture ? "https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture : '',
             );

            $images = [];

            foreach ($obj->multimedia->pictures as $picture) {
                $images[] = 'https://img.sm360.ca/images/inventory' . $picture;
            }

            $car_data['all_images'] = implode("|", $images);
          
            if($obj->newVehicle){
                $car_data['url']=strtolower("https://www.tonygrahamlexus.com/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . 'buildmy-'  . $obj->make->name . '-' . $obj->model->name . '-' . $obj->bodyStyle->slug .'-id' . $obj->vehicleId);
            }
            else{
                $car_data['url']=strtolower("https://www.tonygrahamlexus.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId);
            }
 
            $to_return[] = $car_data;
        }
        return $to_return;
    },
);

add_filter('filter_tonygrahamlexuscom_post_data', 'filter_tonygrahamlexuscom_post_data', 10, 2);

function filter_tonygrahamlexuscom_post_data($post_data, $stock_type) {
    
    if ($stock_type == 'used') {
        $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[50],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"colanderSlug":"used","soldDaysShown":1,"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]}}';
    }
	else{
		$post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[50],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"makeIds":[],"modelIds":[],"colanderSlug":"new","soldDaysShown":1,"textSearch":"","frameStyleIds":[],"transmissionIds":[],"driveTrainIds":[],"fuelIds":[],"exteriorColorIds":[],"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]}}';
	}
  
    return $post_data;
}