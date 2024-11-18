<?php

global $scrapper_configs;

$scrapper_configs['scarboromazda'] = array(
    'entry_points'        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/scarboromazda_en.csv',
    ),
    'vdp_url_regex'       => '/\/en\/.*(?:new|used).*(?:vehicle|catalog|inventory)/i',
    'use-proxy'           => true,
    'refine'              => false,
    'picture_selectors'   => ['.ril__image'],
    'picture_nexts'       => ['.ril-next-button'],
    'picture_prevs'       => ['.ril-prev-button'],
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);
        $result   = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number'   => $vehicle['stock'],
                'vin'            => $vehicle['vin'],
                'year'           => $vehicle['year'],
                'make'           => $vehicle['make'],
                'model'          => $vehicle['model'],
                'trim'           => $vehicle['trim'],
                'drivetrain'     => $vehicle['drive'],
                'fuel_type'      => $vehicle['fuel'],
                'transmission'   => $vehicle['transmission'],
                'body_style'     => $vehicle['body'],
                'images'         => explode(',', $vehicle['photo']),
                'all_images'     => implode('|', explode(',', $vehicle['photo'])),
                'price'          => $vehicle['sale_price'] > 0 ? $vehicle['sale_price'] : $vehicle['regular_price'],
                'url'            => $vehicle['external_url'],
                'stock_type'     => strpos($vehicle['external_url'], "inventory/new") ? "new" : 'used',
                'exterior_color' => $vehicle['extcolour'],
                'interior_color' => $vehicle['intcolour'],
                'engine'         => $vehicle['eng_desc'],
                'description'    => strip_tags($vehicle['special_mentions']),
                'kilometres'     => $vehicle['odometer'],
            ];

            $result[] = $car_data;
        }

        return $result;
    }
);

add_filter('filter_scarboromazda_post_data', 'filter_scarboromazda_post_data', 10, 2);

function filter_scarboromazda_post_data($post_data, $stock_type)
{
    if ($stock_type == 'used') {
        $post_data = '{"operationName":"fetchUsedVehicles","variables":{"first":99,"organizationUnitId":1556,"vehicleCriteria":{"category":"CAR","colanderSlug":"used","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"vehicleOrderField":"DATE_ENTRY","orderDirection":"ASC"}]},"query":"query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(after: $after, first: $first, organizationUnitId: $organizationUnitId, paymentCriteria: $paymentCriteria, vehicleCriteria: $vehicleCriteria, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      showroomVehicleId\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    } else {
        $post_data = '{"operationName":"fetchNewVehicles","variables":{"first":99,"organizationUnitId":1556,"vehicleCriteria":{"category":"CAR","colanderSlug":"new","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":6,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"ASC","vehicleOrderField":"PRICE"}]},"query":"query fetchNewVehicles($after: String, $first: Int!, $vehicleCriteria: NewVehicleCriteria, $organizationUnitId: Int!, $vehicleOrders: [VehicleOrder]) {\n  searchNewVehicles(after: $after, first: $first, newVehicleCriteria: $vehicleCriteria, organizationUnitId: $organizationUnitId, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      showroomVehicleId\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      matchedCatalogVehicle {\n        multimedia {\n          exteriorPictures {\n            side {\n              url\n              __typename\n            }\n            exactMatch\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      prices {\n        sale\n        regular\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }
    return $post_data;
}

add_filter('filter_scarboromazda_car_data', 'filter_scarboromazda_car_data');

function filter_scarboromazda_car_data($car_data)
{
    if ($car_data['stock_number'] === '20468A') {
        slecho("Excluding car that has stock number 20468A ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}