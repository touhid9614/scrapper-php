<?php
global $scrapper_configs;

$scrapper_configs['northbaytoyota'] = array(
    'entry_points'      => array(
        'used' => 'https://www.northbaytoyota.com/en/used-inventory/api/listing?limit=500',
        'new'  => 'https://service.vehicles.sm360.ca/inventory/vehicles-new?includeMetadata=true&location=ON&organizationId=344&organizationUnitId=926',
        
    ),

    "refine"                 => false,
    'srp_page_regex'      => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
    'vdp_url_regex'         => '/\/en\/(?:new|used)-(?:catalog|inventory)\/.*\/[0-9]{4}-/i',
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
                    'custom' => str_replace(" ","_",strtolower($obj->model->name)),
                    'model' => $obj->model->name,  
                    'price' => $obj->paymentOptions->cashPurchase->sellingPrice, 
                    'kilometres' => $obj->odometer, 
                    'vin'               => $obj->serialNo,
                    'body_style' => $obj->bodyStyle->slug,
                    'fuel_type' => $obj->fuel->name,
                    'exterior_color' => $obj->exteriorColor->colorDescription,
                    'interior_color' => $obj->interiorColor->colorDescription,
                    'all_images'   => "https://img.sm360.ca/ir/w360h197c/images/newcar/" . $obj->multimedia->exterior->front,
                 );
                
                 if($obj->vehicleStatus == "SOLD"){
                    $car_data = [];
                 }
                // $images = [];
    
                // foreach ($obj->multimedia->pictures as $picture) {
                //     $images[] = 'https://img.sm360.ca/images/inventory' . $picture;
                // }
                // $car_data['all_images'] = implode("|", $images);
              
                // if($obj->newVehicle){
                $car_data['url']=strtolower("https://www.northbaytoyota.com/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId);
                // }
         
                $to_return[] = $car_data;
            }
            return $to_return;
        },
        ),
    'used'              => array(
       'vdp_url_regex'         => '/\/en\/(?:used-inventory|used-catalog)\//i',
       'custom_data_capture'   => function($url, $data){

                   $objects = json_decode($data);


                   if(!$objects) {
                       //slecho($data);
                        return array();
                   }
                   $ignore_data=[
                    '23497A',
                    '23539A',
                    '23496B',
                    'A23034A',
                ];

                   $to_return = array();
                       foreach($objects->vehicles as $obj)
                            {
                            $stock_type=$obj->newVehicle?"new":"used";
                       $car_data = array(
                           'stock_number'      => $obj->stockNo?$obj->stockNo:$obj->serialNo,
                           'year'              => $obj->year,
                           'make'              => ucwords(strtolower($obj->make->name)),
                           'model'             => ucwords(strtolower($obj->model->name)),
                         //'trim'              => $obj->trim->name,
                           'price'             => $obj->salePrice,
                           'msrp'             => $obj->listPrice,
                           'transmission'      => $obj->transmission,
                           'kilometres'        => $obj->odometer,
                           'vin'               => $obj->serialNo,
                           'fuel_type'         => $obj->fuel->name,
                           'drivetrain'        => $obj->driveTrain,
                           'url'               => "https://www.northbaytoyota.com/en/" . $stock_type . "-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId,
                          'all_images'         => $obj->multimedia->mainPicture?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture:'',
                       );
                       
                         $images = [];
                         foreach ($obj->multimedia->pictures as $picture) {
                             $images[] = 'https://img.sm360.ca/images/inventory' . $picture;
                         }
                          
    
                        if (in_array($car_data['stock_number'], $ignore_data)) 
                        {
                            slecho("Excluding car that has  ,{$car_data['stock_number']}");
                            continue;

                        }
                         
                          $car_data['all_images'] = implode("|", $images);

                          $to_return[] = $car_data;
                       }
                       
                          
                   return $to_return;
               },
    ),

);

// They want those cars only for new
// https://docs.google.com/spreadsheets/d/17TRFNsBLGAigbeouXzsG0WUxByn3r59rUpHSIf73m2o/edit#gid=0

add_filter('filter_northbaytoyota_car_data', 'filter_northbaytoyota_car_data');
function filter_northbaytoyota_car_data($car_data) {
    $car_data['make'] = ucwords(strtolower($car_data['make']));
    $car_data['model'] = ucwords(strtolower($car_data['model']));
    $car_data['trim'] = strtolower($car_data['trim']);
//    if($car_data['stock_type']=='new'){
//        if (preg_match('/id(?:20325|21065|20509|19912|20380|20329|19980|20377|18835|18832|20498|20498|19672|19675|18981|19041|19052|19444|19077|19683|19439|20373|20373|19429)/', $car_data['url'])) {
//            slecho('We are taking this new car');
//        }
//        else {
//            $car_data = [];
//
//            slecho('We are removing this new car');
//        }
//    }
    return $car_data;
}

add_filter("filter_northbaytoyota_field_images", "filter_northbaytoyota_field_images");
function filter_northbaytoyota_field_images($im_urls)
{
    for ($i = 0; $i < count($im_urls); $i++) {
        $im_urls[$i] = str_replace(['w100h75', 'w195h145c'], 'w600h400', $im_urls[$i]);
    }

    return $im_urls;
}

add_filter("filter_northbaytoyota_field_model", "filter_northbaytoyota_field_model");
function filter_northbaytoyota_field_model($model)
{
    return str_replace('+', ' ', $model);
}

add_filter('filter_northbaytoyota_post_data', 'filter_northbaytoyota_post_data', 10, 2);

function filter_northbaytoyota_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[32],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"colanderSlug":"new","soldDaysShown":5,"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]}}';
    }
    return $post_data;
}