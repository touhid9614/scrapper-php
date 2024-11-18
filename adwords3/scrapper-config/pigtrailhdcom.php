<?php
global $scrapper_configs;
$scrapper_configs["pigtrailhdcom"] = array( 
	 'entry_points' => array(
        
        'used' => 'https://pigtrailhd.com/default-asp-page-xpreownedinventory?page=1',
        'new'  => 'https://pigtrailhd.com/new-inventory?page=1',
       
    ),
    'vdp_url_regex' => '/\/inventory/i',

    'use-proxy' => true,
     'refine'   => false,
    
    'picture_selectors' => ['.r58-slider-stage img'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'details_start_tag'    => '<ul id="inventoryBikesList"',
       'details_end_tag'   => '<div class="list-pagination">',
       'details_spliter'   => '<li class="inventoryList-bike">',

       'data_capture_regx' => array(
           'stock_number'      => '/Stock number:<\/td><td>(?<stock_number>[^<]+)/',
            //'stock_type'        => '/Condition:\s*(?<stock_type>[^"]+)/',
           'year'              => '/vehicleYear =\s*\'(?<year>[0-9]{4})/',
           'make'              => '/vehicleMake =\s*\'(?<make>[^\']+)/',
           'model'             => '/vehicleModel =\s*\'(?<model>[^\']+)/',
           'url'               => '/class="inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)"/',
           
           'kilometres'        => '/Mileage:<\/td><td>(?<kilometres>[^\s<]+)/',
           'exterior_color'    => '/Color:<\/td><td>(?<exterior_color>[^<]+)/',
            'vin'               => '/Stock number:<\/td><td>(?<vin>[^<]+)/',
         
       ),
       'data_capture_regx_full' => array(
           'price'             => '/var vehiclePrice =\s*\'(?<price>[^\']+)/',
           
           'vin'               => '/VIN number:<\/td>\s*<td>(?<vin>[^<]+)/',
       ),
      'next_query_regx'     => '/<a href="[^"]+" data-(?<param>page)="(?<value>[0-9]*)" title="Next page">/',
        'images_regx'           => '/data-gallery="inventoryGallery" data-lightbox[^"]+"(?<img_url>[^"]+)"/',
        
   );
    //  add_filter('filter_pigtrailhdcom_field_price', 'filter_pigtrailhdcom_field_price',10,3);

    
    // function filter_pigtrailhdcom_field_price($price,$car_data,$spltd_data)
    // {
    //     $prices = [];
        
    //     slecho('');
        
    //     if($price && numarifyPrice($price) > 0) {
    //         $prices[] = numarifyPrice($price);
    //         slecho(" Price: $price");
    //     }
        
    //      $msrp_regex = '/Dealer prep:[^>]+>\s*[^>]+>\s*(?<price>[^<]+)/';
      
    //     $matches = [];
        
    //     if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
    //         $prices[] = numarifyPrice($matches['price']);
    //         slecho("Regex MSRP: {$matches['price']}");
    //     }
     
        
    //     if(count($prices) > 0) {
    //         $price = butifyPrice(min($prices));
    //     }
        
    //     slecho("Sale Price: {$price}".'<br>');
    //     return $price;
    // }


 // add_filter('filter_pigtrailhdcom_car_data', 'filter_pigtrailhdcom_car_data');

 // function filter_pigtrailhdcom_car_data($car_data)
 //  {

 //     if($car_data['price']="$1.00"){
 //         $car_data['price']="Please Call";
 //    }

 //    return $car_data;
 // }


add_filter('filter_pigtrailhdcom_car_data', 'filter_pigtrailhdcom_car_data');

 function filter_pigtrailhdcom_car_data($car_data) 
 {
    if ($car_data['price'] === '1.00'|| $car_data['price'] === '0.00') 
    {
        slecho("Excluding car that has price 1.00 and 0.00 ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}

    