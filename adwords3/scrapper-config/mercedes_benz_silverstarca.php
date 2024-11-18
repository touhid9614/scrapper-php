<?php

global $scrapper_configs;
$scrapper_configs["mercedes_benz_silverstarca"] = array(
    'entry_points' => array(
        'used' => 'https://webauto-supplier-api.sm360.ca/webauto/graphql',
        'new' => 'https://webauto-supplier-api.sm360.ca/webauto/graphql',
    ),
    'url_resolve'       => array(
        'mercedes_benz_silverstarca'    => '/www.mercedes-benz-silverstar.ca\/en/i',
        'mercedes_benz_silverstarcafr'  => '/www.mercedes-benz-silverstar.ca\/fr/i',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used)-/',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.carousel-indicators li'],
    'picture_nexts' => [],
    'picture_prevs' => [],
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
                    'url' => "https://www.mercedes-benz-silverstar.ca/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
                    'all_images' => $obj->multimedia->mainPicture->url ? "https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url : '',
                );
                $images = [];
                foreach ($obj->multimedia->pictures as $picture) {
                    $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
                }
                $car_data['all_images'] = implode("|", $images);
                $to_return[] = $car_data;
            }
        } else {
            foreach ($objects->data->searchNewVehicles->nodes as $obj) {

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
                    'url' => "https://www.mercedes-benz-silverstar.ca/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
                    'all_images' => $obj->multimedia->mainPicture->url ? "https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url : '',
                );
                $images = [];
                foreach ($obj->multimedia->pictures as $picture) {
                    $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
                }
                $car_data['all_images'] = implode("|", $images);
                $to_return[] = $car_data;
            }
        }


        return $to_return;
    },
);
add_filter('filter_mercedes_benz_silverstarca_post_data', 'filter_mercedes_benz_silverstarca_post_data', 10, 2);

function filter_mercedes_benz_silverstarca_post_data($post_data, $stock_type) {

    if ($stock_type == 'used') {
        $post_data = '{"operationName":"fetchUsedVehicles","variables":{"first":12,"organizationUnitId":425,"vehicleCriteria":{"category":"CAR","colanderSlug":"used","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"vehicleOrderField":"DATE_ENTRY","orderDirection":"ASC"}]},"query":"query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(after: $after, first: $first, organizationUnitId: $organizationUnitId, paymentCriteria: $paymentCriteria, vehicleCriteria: $vehicleCriteria, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    } else {
        $post_data = '{"operationName":"fetchNewVehicles","variables":{"first":400,"organizationUnitId":425,"vehicleCriteria":{"category":"CAR","colanderSlug":"new-notdemo","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":4,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"ASC","vehicleOrderField":"PRICE"}],"after":"b2Zmc2V0LS0tMjM="},"query":"query fetchNewVehicles($after: String, $first: Int!, $vehicleCriteria: NewVehicleCriteria, $organizationUnitId: Int!, $vehicleOrders: [VehicleOrder]) {\n  searchNewVehicles(after: $after, first: $first, newVehicleCriteria: $vehicleCriteria, organizationUnitId: $organizationUnitId, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      showroomVehicleId\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n  pictures {\n        url\n        __typename\n      }\n       __typename\n      }\n      matchedCatalogVehicle {\n        multimedia {\n          exteriorPictures {\n            side {\n              url\n              __typename\n            }\n            exactMatch\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      prices {\n        sale\n        regular\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }

    return $post_data;
}
