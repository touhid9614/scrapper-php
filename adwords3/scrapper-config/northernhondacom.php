<?php
global $scrapper_configs;
$scrapper_configs["northernhondacom"] = array( 
	'entry_points' => array(
        'new'  => 'https://www.northernhonda.com/en/new-catalog',    
        'used' => 'https://webauto-supplier-api.sm360.ca/webauto/graphql',    
        
        
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
    'srp_page_regex' => '/\/en\/(?:new|used)-inventory/i',
    'used' => array(
        'use-proxy' => true,
        'refine' => false,
        'init_method' => 'POST',
        'next_method' => 'POST',
        'picture_selectors' => ['.ril-inner img'],
        'picture_nexts' => ['.next-button'],
        'picture_prevs' => ['.prev-button'],
        'content_type' => 'application/json',
        'custom_data_capture' => function($url, $data) {

            $objects = json_decode($data);


            if (!$objects) {
                //slecho($data);
                return array();
            }


            $to_return = array();
            if ($objects->data->searchVehicles->__typename == 'UsedVehicleConnection') {
                foreach ($objects->data->searchVehicles->nodes as $obj) {

                    $car_data = array(
                        'stock_number' => $obj->stockNo ? $obj->stockNo : $obj->vin,
                        'year' => $obj->year,
                        'make' => $obj->make->name,
                        'model' => $obj->model->name,
                        'trim' => $obj->trim->name,
                        'price' => $obj->prices->sale,
                        'transmission' => $obj->characteristics->transmission->type,
                        'kilometres' => $obj->odometer,
                        'vin' => $obj->vin,
                        'drivetrain' => $obj->characteristics->transmission->driveTrain->label,
                        'url' => "https://www.northernhonda.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
                        'all_images' => $obj->multimedia->mainPicture->url ? "https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url : '',
                    );
                    $images = [];
                    foreach ($obj->multimedia->pictures as $picture) {
                        $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
                    }
                    $car_data['all_images'] = implode("|", $images);



$response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }




                    $to_return[] = $car_data;
                }
            }
            /* else 
              {
              foreach($objects->data->searchNewVehicles->nodes as $obj)
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
              'url'               => "https://www.northernhondacom.ca/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
              'all_images'         => $obj->multimedia->mainPicture->url?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url:'',
              );
              $images = [];
              foreach ($obj->multimedia->pictures as $picture) {
              $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
              }
              $car_data['all_images'] = implode("|", $images);
              $to_return[] = $car_data;
              }
              }

             */
            return $to_return;
        },
    ),
    'new' => array(
        'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
        'proxy-area' => 'FL',
        'custom_data_capture' => function($url, $resp) {
            global $proxy_list;

            $inventory = northernhondacom_get_newInventory($url, $resp);

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
                    'trim' => '/desired_trim=(?<trim>[^"]+)"\s*class/',
                    'price' => '/primaryColor_price" itemprop="price"[^>]+>\s*(?<price>\$[0-9,]+)/',
                    'lease' => '/class="showroom-financing__payment"[^>]+>(?<lease>\$[0-9,]+)/',
                    'lease_term' => '/class="showroom-financing__term"[^>]+>(?<lease_term>[0-9]+\s*months)/',
                    'lease_rate' => '/class="showroom-financing__rate"[^>]+>(?<lease_term>[0-9,.%]+\s*)/',
                    'finance' => '/Finance weekly from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<finance>\$[0-9,]+)\*<\/span>/',
                    'finance_term' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
                    'finance_rate' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
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
                if(!isset($car_data['lease'])){
                    continue;
                }

                $response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }

            
                $to_return[] = $car_data;
            }
            return $to_return;
        },
    ),
);
add_filter('filter_northernhondacom_post_data', 'filter_northernhondacom_post_data', 10, 2);

function filter_northernhondacom_post_data($post_data, $stock_type) {

    if ($stock_type == 'used') {
        $post_data = '{"operationName":"fetchUsedVehicles","variables":{"first":50,"organizationUnitId":2031,"vehicleCriteria":{"category":"CAR","colanderSlug":"used","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"vehicleOrderField":"DATE_ENTRY","orderDirection":"ASC"}]},"query":"query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(after: $after, first: $first, organizationUnitId: $organizationUnitId, paymentCriteria: $paymentCriteria, vehicleCriteria: $vehicleCriteria, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      showroomVehicleId\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n   pictures {\n        url\n        __typename\n      }\n     __typename\n      }\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    } else {
        $post_data = '{"operationName":"fetchNewVehicles","variables":{"first":215,"organizationUnitId":1933,"vehicleCriteria":{"category":"CAR","colanderSlug":"new","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":41,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":42,"vehicleOrderField":"CATALOG_MAKE_ID"},{"value":44,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"ASC","vehicleOrderField":"PRICE"}]},"query":"query fetchNewVehicles($after: String, $first: Int!, $vehicleCriteria: NewVehicleCriteria, $organizationUnitId: Int!, $vehicleOrders: [VehicleOrder]) {\n  searchNewVehicles(after: $after, first: $first, newVehicleCriteria: $vehicleCriteria, organizationUnitId: $organizationUnitId, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      showroomVehicleId\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n   pictures {\n        url\n        __typename\n      }\n      __typename\n      }\n      matchedCatalogVehicle {\n        multimedia {\n          exteriorPictures {\n            side {\n              url\n              __typename\n            }\n            exactMatch\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      prices {\n        sale\n        regular\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }

    return $post_data;
}

function northernhondacom_get_newInventory($url, $temp) {
    global $proxy_list;
    $details_start_tag = '<div class="page-wrapper catalog-listing-alpha__vehicles">';
    $details_end_tag = '<p class="catalog-listing-alpha__disclaimer smallprint';
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
            $vdp_url = 'https://www.northernhonda.com' . $matches['url'];
        }
        $vdp_data = HttpGet($vdp_url, $proxy_list);
        $car_url_regx = '/<a href="(?<car_url>[^"]+)"\s*title="[^"]+"\s*class="tabs-title/';

        if (preg_match_all($car_url_regx, $vdp_data, $matches)) {
            $car_url = $matches['car_url'];
        }
        $ttl_inventory = array_merge($ttl_inventory, $car_url);
    }
    $ttl_inventory = array_map(function($url) {
        return 'https://www.northernhonda.com' . $url;
    }
            , $ttl_inventory);
    return $ttl_inventory;
}
