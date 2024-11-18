<?php

require_once 'utils.php';

$url          = 'https://webauto-supplier-api.sm360.ca/webauto/graphql';
$post_data    = '{"operationName":"fetchUsedVehicles","variables":{"first":90,"organizationUnitId":1617,"vehicleCriteria":{"category":"CAR","colanderSlug":"used","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"vehicleOrderField":"DATE_ENTRY","orderDirection":"ASC"}]},"query": "query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(after: $after, first: $first, organizationUnitId: $organizationUnitId, paymentCriteria: $paymentCriteria, vehicleCriteria: $vehicleCriteria, vehicleOrders: $vehicleOrders) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n  body {\n        doors\n        passengers\n        frameStyle {\n          label\n          type\n          __typename\n        }\n        __typename\n      }\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n   pictures {\n        url\n   }\n     __typename\n      }\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
$content_type = 'application/json';
$cookie       = null;

$data    = HttpPost($url, $post_data, $cookie, $cookie, null, null, $content_type);
$objects = json_decode($data);

$to_return = [];

foreach ($objects->data->searchVehicles->nodes as $obj) {
    $car_data = array(
        'stock_number' => $obj->stockNo ? $obj->stockNo : $obj->vin,
        'year'         => $obj->year,
        'make'         => $obj->make->name,
        'model'        => $obj->model->name,
        'trim'         => $obj->trim->name,
        'price'        => $obj->prices->sale,
        'transmission' => $obj->characteristics->transmission->type,
        'kilometres'   => $obj->odometer,
        'vin'          => $obj->vin,
        'drivetrain'   => $obj->characteristics->transmission->driveTrain->label,
        'body_style'   => $obj->characteristics->body->frameStyle->label,
        'url'          => "https://www.westernused.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,

    );
    $images = [];
    foreach ($obj->multimedia->pictures as $picture) {
        $images[] = 'https://img.sm360.ca/images/inventory' . $picture->url;
    }
    $car_data['all_images'] = implode("|", $images);
    $to_return[]            = $car_data;
}

echo '<pre>';
print_r($to_return);
