<?php
global $scrapper_configs;
$scrapper_configs["brucefordca"] = array( 
	'entry_points' => array(
            'used'   => 'https://webauto-supplier-api.sm360.ca/webauto/graphql',
             'new'   => 'https://webauto-supplier-api.sm360.ca/webauto/graphql',
           
        ),
        'vdp_url_regex'         => '/\/en\/(?:new|used|certified)-inventory\//',
         'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.ril__image'],
        'picture_nexts'     => ['.ril-next-button'],
        'picture_prevs'     => ['.ril-prev-button'],
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
                'url'               => "https://www.bruceford.ca/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
               'all_images'         => $obj->multimedia->mainPicture->url?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url:'',
            );
           $to_return[] = $car_data;
            }
            }
               else 
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
                'url'               => "https://www.bruceford.ca/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->id,
               'all_images'         => $obj->multimedia->mainPicture->url?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture->url:'',
            );
           $to_return[] = $car_data;
            }
               }
        
  
        return $to_return;
    },
        
);
add_filter('filter_brucefordca_post_data', 'filter_brucefordca_post_data', 10, 2);

function filter_brucefordca_post_data($post_data, $stock_type)
{
    
    if($stock_type == 'used')
    {
        $post_data = '{"operationName":"fetchUsedVehicles","variables":{"first":500,"organizationUnitId":307,"vehicleCriteria":{"category":"CAR","colanderSlug":"used","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":33,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"DESC","vehicleOrderField":"YEAR"}]},"query":"query fetchUsedVehicles($after: String, $first: Int!, $organizationUnitId: Int!, $paymentCriteria: PaymentCriteria, $vehicleCriteria: VehicleCriteria, $vehicleOrders: [VehicleOrder]) {\n  searchVehicles(\n    after: $after\n    first: $first\n    organizationUnitId: $organizationUnitId\n    paymentCriteria: $paymentCriteria\n    vehicleCriteria: $vehicleCriteria\n    vehicleOrders: $vehicleOrders\n  ) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      showroomVehicleId\n      id\n      odometer\n      onHold\n      stockNo\n      tagline\n      vin\n      year\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      financePaymentInfo {\n        cashdown\n        interestRatePercent\n        payment\n        paymentFrequency\n        paymentTaxes\n        termInMonths\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      trim {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      prices {\n        regular\n        sale\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }
    else{
        $post_data = '{"operationName":"fetchNewVehicles","variables":{"first":500,"organizationUnitId":307,"vehicleCriteria":{"category":"CAR","colanderSlug":"new","vehicleStatuses":["FOR_SALE","SOLD","VIRTUAL"],"onlyBuiltVehicles":true,"drivetrains":[],"fuelTypes":[],"exteriorColorIds":[],"frameStyleTypes":[],"makeIds":[],"modelIds":[],"odometerRange":{},"salePriceRange":{},"textQuery":"","transmissionTypes":[],"yearRange":{}},"vehicleOrders":[{"value":33,"vehicleOrderField":"CATALOG_MAKE_ID"},{"orderDirection":"DESC","vehicleOrderField":"YEAR"}]},"query":"query fetchNewVehicles($after: String, $first: Int!, $vehicleCriteria: NewVehicleCriteria, $organizationUnitId: Int!, $vehicleOrders: [VehicleOrder]) {\n  searchNewVehicles(\n    after: $after\n    first: $first\n    newVehicleCriteria: $vehicleCriteria\n    organizationUnitId: $organizationUnitId\n    vehicleOrders: $vehicleOrders\n  ) {\n    pageInfo {\n      endCursor\n      hasNextPage\n      hasPreviousPage\n      startCursor\n      __typename\n    }\n    totalCount\n    nodes {\n      id\n      odometer\n      onHold\n      showroomVehicleId\n      stockNo\n      tagline\n      vin\n      year\n      stickerStatusOnOrder\n      stickerStatusInTransit\n      characteristics {\n        transmission {\n          label\n          type\n          driveTrain {\n            label\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      flags {\n        label\n        type\n        __typename\n      }\n      make {\n        id\n        name\n        __typename\n      }\n      model {\n        id\n        name\n        __typename\n      }\n      multimedia {\n        mainPicture {\n          url\n          __typename\n        }\n        __typename\n      }\n      matchedCatalogVehicle {\n        multimedia {\n          exteriorPictures {\n            side {\n              url\n              __typename\n            }\n            exactMatch\n            __typename\n          }\n          __typename\n        }\n        __typename\n      }\n      prices {\n        sale\n        regular\n        __typename\n      }\n      inventory {\n        organizationUnit {\n          name\n          __typename\n        }\n        __typename\n      }\n      __typename\n    }\n    __typename\n  }\n}\n"}';
    }

    return $post_data;
}

