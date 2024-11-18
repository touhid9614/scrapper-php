<?php
global $scrapper_configs;

$scrapper_configs["centralkiaca"] = array( 
	 'entry_points'  => array(
       'used' => 'https://www.centralkia.ca/en/used-inventory/api/listing?limit=500',
       'new'  => 'https://service.vehicles.sm360.ca/inventory/vehicles-new?includeMetadata=true&location=NL&organizationId=650&organizationUnitId=7200',

    ),
    'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\//',
    'used'          => array(
        'use-proxy'           => true,
        'refine'              => false,
        'picture_selectors'   => ['.ril-inner img'],
        'picture_nexts'       => ['.next-button'],
        'picture_prevs'       => ['.prev-button'],
        'content_type'        => 'application/json',
        'custom_data_capture' => function ($url, $data) {

            $objects = json_decode($data);

            if (!$objects) {
                return array();
            }

            $to_return = array();
            foreach ($objects->vehicles as $obj) {

                $car_data = array(
                    'stock_number' => $obj->stockNo ? $obj->stockNo : $obj->serialNo,
                    'year'         => $obj->year,
                    'make'         => $obj->make->name,
                    'model'        => $obj->model->name,
                    'trim'         => $obj->trim->name,
                    'price'        => $obj->salePrice,
                    'transmission' => $obj->transmission,
                    'kilometres'   => $obj->odometer,
                    'vin'          => $obj->serialNo,
                    'drivetrain'   => $obj->driveTrain,
                    'url'          => "https://www.centralkia.ca/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId,
                    'all_images'   => $obj->multimedia->mainPicture ? "https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture : '',
                );

                $images = [];
                foreach ($obj->multimedia->pictures as $picture) {
                    $images[] = 'https://img.sm360.ca/images/inventory' . $picture;
                }

                $car_data['all_images'] = implode("|", $images);

                $to_return[] = $car_data;
            }

            return $to_return;
        },
    ),

    'new'           => array(

    'content_type' => 'application/json;charset=UTF-8',
    'init_method' => 'POST',
    'next_method' => 'POST',
    'additional_headers' => array(
      //  "Content-Length" => "94449",
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
                'stock_number' => $obj->stockNo?$obj->stockNo:$obj->vin,

                'year' => $obj->year,

                'make' => $obj->make->name,

                'model' => $obj->model->name,

                'price' => $obj->paymentOptions->cashPurchase->sellingPrice,

                'kilometres' => $obj->odometer, 

                'vin'               => $obj->vin,

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
                $car_data['url']=strtolower("https://www.centralkia.ca/en/new-catalog/" . $obj->make->name . '/' . $obj->model->name . '/' . 'buildmy-'  . $obj->make->name . '-' . $obj->model->name . '-' . $obj->bodyStyle->slug .'-id' . $obj->vehicleId);
            }
     
           

            $to_return[] = $car_data;
        }
        return $to_return;
    },





    ),
);
add_filter('filter_centralkiaca_post_data', 'filter_centralkiaca_post_data', 10, 2);

function filter_centralkiaca_post_data($post_data, $stock_type) {
    
  
    if ($stock_type == 'new') {
        $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[1],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"makeIds":[],"modelIds":[],"colanderSlug":"new","soldDaysShown":7,"textSearch":"","frameStyleIds":[],"transmissionIds":[],"driveTrainIds":[],"fuelIds":[],"exteriorColorIds":[],"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]}}';
    }
  

    return $post_data;
}
