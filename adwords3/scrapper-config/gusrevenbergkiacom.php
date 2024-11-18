<?php
global $scrapper_configs;
$scrapper_configs["gusrevenbergkiacom"] = array( 
	  'entry_points' => array(
            //'used'   => 'https://www.gusrevenbergkia.com/en/used-inventory/api/listing?limit=500', 
            'new'   => 'https://www.gusrevenbergkia.com/en/new-catalog',  
            
             
           
        ),
        'vdp_url_regex'     => '/-id[0-9]+/i',
         'srp_page_regex'          => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
        'used' => array(
                    'use-proxy'         => true,
                   'refine'            => false,
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
                       foreach($objects->vehicles as $obj)
                            {

                       $car_data = array(
                           'stock_number'      => $obj->stockNo?$obj->stockNo:$obj->serialNo,
                           'year'              => $obj->year,
                           'make'              => $obj->make->name,
                           'model'             => $obj->model->name,
                           'trim'              => $obj->trim->name,
                           'price'             => $obj->salePrice,
                           'transmission'      => $obj->transmission,
                           'kilometres'        => $obj->odometer,
                           'vin'               => $obj->serialNo,
                           'drivetrain'        => $obj->driveTrain,
                           'url'               => "https://www.gusrevenbergkia.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId,
                          'all_images'         => $obj->multimedia->mainPicture?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture:'',
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
            
     'new' => array(
        'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
        'custom_data_capture' => function($url, $resp) {
            global $proxy_list;

            $inventory = gusrevenbergkiacom_get_newInventory($url, $resp);

            slecho("Count of vehicles :" . count($inventory));

            $to_return = [];
            foreach ($inventory as $url) {
                $url = str_replace(' ', "%20", $url);
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
                    'price' => '/"vehicleCashPurchase_sellingPrice_fontColor">\s*(?<price>\$[0-9,]+)/',
                    //'lease' => '/Lease .+Underline">weekly<\/span>\s+from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<lease>\$[0-9,]+)\*<\/span>/',
                    //'lease_term' => '/Term for (?<lease_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<lease_rate>[0-9\.\%]+)/',
                    //'lease_rate' => '/Term for (?<lease_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<lease_rate>[0-9\.\%]+)/',
                    //'finance' => '/Finance weekly from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<finance>\$[0-9,]+)\*<\/span>/',
                    //'finance_term' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
                    //'finance_rate' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
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
                $images_regex = '/class="overlay swiper-slide"  data-overlay>\s*<img\s*src="(?<img_url>[^"]+)/';
                $images_fallback_regex = '/<meta property="og:image" content="(?<img_url>[^"]+)"/';

                $matches = array();

                if (preg_match_all($images_regex, $temp_data, $matches)) {
                    if (count($matches['img_url']) <= 3) {
                        
                    } else {
                        
                        $car_data['images'] = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
                        $car_data['all_images'] = implode('|', $car_data['images']);
                    }
                } elseif (preg_match_all($images_fallback_regex, $temp_data, $matches)) {
                    if (count($matches['img_url']) <= 3) {
                        
                    } else {
                        
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
add_filter('filter_gusrevenbergkiacom_post_data', 'filter_gusrevenbergkiacom_post_data', 10, 2);

function filter_gusrevenbergkiacom_post_data($post_data, $stock_type)
{
    
    if($stock_type == 'used')
    {
        $post_data = '{"operationName":"fetchUsedVehicles","variables":{"first":76,"organizationUnitId":917,"vehicleCriteria":{"category":"CAR","colanderSlug":"used","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":false,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":9,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":15,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":33,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":41,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":42,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":44,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"DESC","vehicleOrderField":"YEAR"}]},"query":"query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(after: $after, first: $first, organizationUnitId: $organizationUnitId, paymentCriteria: $paymentCriteria, vehicleCriteria: $vehicleCriteria, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }
    else{
        $post_data = '{"operationName":"fetchNewVehicles","variables":{"first":225,"organizationUnitId":917,"vehicleCriteria":{"category":"CAR","colanderSlug":"new","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":9,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":15,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":33,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":41,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":42,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":44,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"DESC","vehicleOrderField":"YEAR"}]},"query":"query fetchNewVehicles($after: String, $first: Int!, $vehicleCriteria: NewVehicleCriteria, $organizationUnitId: Int!, $vehicleOrders: [VehicleOrder]) {\n  searchNewVehicles(after: $after, first: $first, newVehicleCriteria: $vehicleCriteria, organizationUnitId: $organizationUnitId, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      showroomVehicleId\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      matchedCatalogVehicle {\n        multimedia {\n          exteriorPictures {\n            side {\n              url\n              __typename\n            }\n            exactMatch\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      prices {\n        sale\n        regular\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }

    return $post_data;
}

function gusrevenbergkiacom_get_newInventory($url, $temp) {
    global $proxy_list;
    $details_start_tag = '<article class="catalog-card-vertical';
    $details_end_tag = '<div class="cell catalog-listing-alpha__disclaimer">';
    $details_spliter = 'More Details</a>';

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
            $vdp_url = 'https://www.gusrevenbergkia.com' . $matches['url'];
        }
        /*
         * $vdp_data = HttpGet($vdp_url, $proxy_list);
        $car_url_regx = '/data-tab-link="(?<car_url>[^"]+)"/';

        if (preg_match_all($car_url_regx, $vdp_data, $matches)) {
            $car_url = $matches['car_url'];
        }
        $ttl_inventory = array_merge($ttl_inventory, $car_url);
         
         */
        $car_url[]=$vdp_url;
    }
//    $ttl_inventory = array_map(function($url) {
//        return 'https://www.gusrevenbergkia.com' . $url;
//    }
//            , $ttl_inventory);
    
    return $car_url;
}
