<?php
global $scrapper_configs;
 $scrapper_configs["brucehyundaicom"] = array( 
	  'entry_points' => array(
            'used'   => 'https://service.vehicles.sm360.ca/inventory/vehicles-used?includeMetadata=true&location=NS&organizationId=162&organizationUnitId=917',
            'new'   => 'https://www.brucehyundai.com/en/new-catalog',  
        ),
        'vdp_url_regex'     => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',

  'used'     => array(

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
                        $car_data['url']=strtolower("https://www.brucehyundai.com/en/new-catalog/" . $obj->make->name . '/' . $obj->model->name . '/' . 'buildmy-'  . $obj->make->name . '-' . $obj->model->name . '-' . $obj->bodyStyle->slug .'-id' . $obj->vehicleId);
            }
            else{
                    $car_data['url']=strtolower("https://www.brucehyundai.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId);
            }
 
            $to_return[] = $car_data;
        }
        return $to_return;
    },

    ),

    'new'   => array(
        'details_start_tag' => '<div id="catalog-listing__hyundai"',
        'details_end_tag'   => '<footer class="footer"',
        'details_spliter'   => '<div class="catalog-block__wrapper',
        'data_capture_regx' => array(
            'url'           => '/class="catalog-block__name-anchor" href="(?<url>[^"]+)"/',   
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'body_style'    => '/data-bodystyle="(?<body_style>[^"]+)/',
            'price'         => '/class="showroom-price__price--regular"\s*[^>]+>\s*(?<price>[^\s]+)/',
        ),
        'data_capture_regx_full' => array(
         
        ) ,               
        'images_regx'           => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),

);

add_filter('filter_brucehyundaicom_post_data', 'filter_brucehyundaicom_post_data', 10, 2);

function filter_brucehyundaicom_post_data($post_data, $stock_type) {
    
    if ($stock_type == 'used') {
        $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[9],"sortList":[{"direction":"DESC","vehicleSortParameter":"YEAR"}],"vehicle":{"colanderSlug":"used","soldDaysShown":0,"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]}}';
    }
  
    return $post_data;
}