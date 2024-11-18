<?php
global $scrapper_configs;
$scrapper_configs["brucegmcom"] = array( 
	  'entry_points' => array(
               'used'   => 'https://webauto-supplier-api.sm360.ca/webauto/graphql',
            'new'   => 'https://www.brucegm.com/en/new-catalog',  
           
             
           
        ),
        'vdp_url_regex'     => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
        'used' => array(
                    'use-proxy'         => true,
                   'refine'            => false,
                   'init_method'       => 'POST',
                   'next_method'       => 'POST',
                   'picture_selectors' => ['.ril-inner img'],
                   'picture_nexts'     => ['.next-button'],
                   'picture_prevs'     => ['.prev-button'],
                   'content_type'      => 'application/json',
                   'custom_data_capture'   => function($url, $data){

                   $objects = json_decode($data);


                   if(!$objects) {
                       //slecho($data);
                        return array();
                   }


                   $to_return = array();
                    if($objects->data->searchVehicles->__typename == 'UsedVehicleConnection')   
                       {
                            foreach($objects->data->searchVehicles->nodes as $obj)
                            {

                       $car_data = array(
                           'stock_number'      => $obj->stockNo?$obj->stockNo:$obj->vin,
                           'year'              => $obj->year,
                           'make'              => $obj->make->name,
                           'model'             => $obj->model->name,
                           'trim'              => $obj->trim->name,
                           'price'             => $obj->prices->sale,
                           'transmission'      => $obj->characteristics->transmission->type,
                           'kilometres'        => $obj->odometer,
                           'vin'               => $obj->vin,
                           'drivetrain'        => $obj->characteristics->transmission->driveTrain->label,
                           'url'               => "https://www.brucegm.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
                          'all_images'         => $obj->multimedia->mainPicture->url?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url:'',
                       );
                         $images = [];
                
                    foreach ($obj->multimedia->pictures as $picture) {
                        $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
                    }
                    
                    if(count($images)<2)
                     {
                        $car_data['all_images']="";
            
                     }
                     else{
                    $car_data['all_images'] = implode("|", $images);
                     }
                    $to_return[] = $car_data;
                }
            }

                   return $to_return;
               },
                   
     ),   
            
     'new' => array(
        'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
        'custom_data_capture' => function($url, $resp) {
            global $proxy_list;

            $inventory = brucegmcom_get_newInventory($url, $resp);

            slecho("Count of vehicles :" . count($inventory));

            $to_return = [];
            foreach ($inventory as $url) {
                slecho("URL = " . $url);
                $car_data = [];
                $car_data['url'] = $url;
                $car_data['stock_number'] = md5($url);
                $temp_data = HttpGet($url, $proxy_list);
                $data_capture_regx_full = array(
                    'make' => '/\&desired_make=(?<make>[^\&]+)/',
                    'model' => '/carId.*desired_model=(?<model>[^\&]+)/',
                    'body_style' => '/<meta property="og:image" content="https:\/\/[^\/]+\/[^\/]+\/newcar(?:\/ca|)\/[0-9]{4}\/[^\/]+\/[^\/]+\/[^\/]+\/(?<body_style>[^\/]+)/',
                    'year' => '/year:\'(?<year>[^\']+)/',
                    'trim' => '/desired_trim=(?<trim>[^"]+)"\s*title="Book/',
                    'price' => '/price__detail-price-price">\s*(?<price>\$[0-9,]+)/',
                   );
                foreach ($data_capture_regx_full as $key => $regx) {
                    if (preg_match($regx, $temp_data, $match)) {
                        if (array_key_exists($key, $match)) {
                            $car_data[$key] = str_replace("\n", '', $match[$key]);
                            if ($key == 'model') {
                                $car_data[$key] = str_replace('+', ' ', $match[$key]);
                            }

                            if ($key == 'trim') {

                                $car_data[$key] = str_replace('+', ' ', $match[$key]);
                            }
                        }
                    } else {
                        //slecho(print_r($match, true));
                        slecho("Error in $key regex");
                    }
                }
                $images_regex = '/data-picture-index="[0-9]*"\s*.*[^>]+>\s*<[^<]+<img\s*src="(?<img_url>[^"]+)/';
                $images_fallback_regex = '/<meta property="og:image" content="(?<img_url>[^"]+)"/';

                $matches = array();

                if (preg_match_all($images_regex, $temp_data, $matches)) {
                    if (count($matches['img_url']) <= 3) {
                        
                    } else {
                        unset($matches['img_url'][0]);

                        $car_data['images'] = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
                        $car_data['all_images'] = implode('|', $car_data['images']);
                    }
                } elseif (preg_match_all($images_fallback_regex, $temp_data, $matches)) {
                    if (count($matches['img_url']) <= 3) {
                        
                    } else {
                        unset($matches['img_url'][0]);
                        $car_data['images'] = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
                        $car_data['all_images'] = implode('|', $car_data['images']);
                    }
                }

                $to_return[] = $car_data;
            }
            return $to_return;
        },
    ),       
);
add_filter('filter_brucegmcom_post_data', 'filter_brucegmcom_post_data', 10, 2);

function filter_brucegmcom_post_data($post_data, $stock_type)
{
    
    if($stock_type == 'used')
    {
        $post_data = '{"operationName":"fetchUsedVehicles","variables":{"first":250,"organizationUnitId":308,"vehicleCriteria":{"category":"CAR","colanderSlug":"used-not-certified-cadillac","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":44,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":41,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":42,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"DESC","vehicleOrderField":"YEAR"}],"after":"b2Zmc2V0LS0tMTE="},"query":"query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(\n    after: $after\n    first: $first\n    organizationUnitId: $organizationUnitId\n    paymentCriteria: $paymentCriteria\n    vehicleCriteria: $vehicleCriteria\n    vehicleOrders: $vehicleOrders\n  ) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      showroomVehicleId\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n      mainPicture {\n        url\n        __typename\n      }\n      pictures {\n        url\n        __typename\n      }\n      video {\n        url\n        __typename\n      }\n      __typename\n    }\n    tagline\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }
   

    return $post_data;
}

function brucegmcom_get_newInventory($url, $temp) {
    global $proxy_list;
    $details_start_tag = '<div id="catalog-listing__hyundai"';
    $details_end_tag = '<p class="catalog-listing__disclaimer smallprint';
    $details_spliter = 'More Details</span>';

    if ($details_start_tag) {
        $temp = substr($temp, stripos($temp, $details_start_tag));
    }

    if ($details_end_tag) {
        $temp = substr($temp, 0, stripos($temp, $details_end_tag));
    }

    $spltd = $temp;
    if ($details_spliter) {
        $spltd = explode($details_spliter, $temp);
    }

    $vdp_url = '';
    $car_url = [];
    $ttl_inventory = [];
    foreach ($spltd as $data) {

        $url_regex = '/<a href="(?<url>[^"]+)"\s*title="[0-9]{4}/';
        if (preg_match($url_regex, $data, $matches)) {
            $vdp_url = 'https://www.brucegm.com' . $matches['url'];
        }
        $vdp_data = HttpGet($vdp_url, $proxy_list);
        $car_url_regx = '/catalog-details__header-vehicle-trims-items">\s*<a href="(?<car_url>[^"]+)"\s*title=/';

        if (preg_match_all($car_url_regx, $vdp_data, $matches)) {
            $car_url = $matches['car_url'];
        }
        $ttl_inventory = array_merge($ttl_inventory, $car_url);
    }
    $ttl_inventory = array_map(function($url) {
        return 'https://www.brucegm.com' . $url;
    }
            , $ttl_inventory);
    return $ttl_inventory;
}
