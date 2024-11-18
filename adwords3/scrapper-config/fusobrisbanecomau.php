<?php
global $scrapper_configs;
$scrapper_configs["fusobrisbanecomau"] = array( 
	'entry_points' => array(
            'used'  => 'https://www.fusobrisbane.com.au/stock/used-trucks-for-sale-brisbane/',
            'new'   => 'https://www.fusobrisbane.com.au/stock/new-fuso-for-sale-brisbane/',
           
          
        ),
        'vdp_url_regex'     => '/\/for-sale\/mercedes-benz/i',
        'use-proxy' => true,
        'details_start_tag' => '<div class="sl-items-wrapper"',
        'details_end_tag'   => 'class="sl-price-disclaimer"',
        'details_spliter'   => '<div class="stock-list-item"',
        
        'data_capture_regx' => array(
            'stock_number'  => '/sl-spec-stock">(?<stock_number>[^<]+)/',
            'year'          => '/heading-details-link" href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^"]+)/',
            'make'          => '/heading-details-link" href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^"]+)/',
            'model'         => '/heading-details-link" href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^"]+)/',
            'trim'          => '/heading-details-link" href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^"]+)/',
            'price'         => '/sl-heading-prices sl-price">(?<price>\$[0-9,]+)/',
            'engine'        => '/sl-spec-text sl-spec-engine">(?<engine>[^<]+)/',
            'kilometres'    => '/sl-spec-text sl-spec-km">(?<kilometres>[0-9]+)/',
            'url'           => '/heading-details-link"\s*href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'transmission'  => '/Transmission: <\/td><td>(?<transmission>[^<]+)/',
            'vin'           => '/value-vin">(?<vin>[^<]+)/',
            'body_style'    => '/Body<\/p>[^>]+>(?<body_style>[^<]+)/',
            'exterior_color'=> '/Colour<\/p>[^>]+>(?<exterior_color>[^<]+)/',
 
        ),
        //'next_query_regx'   => '/(?<param>page)\/(?<value>[0-9]*)\/" onclick="[^>]+>Next/',
        'images_regx'       => '/sd-image-large lazyOwl" data-src="(?<img_url>[^"]+)/',
    );


add_filter('filter_fusobrisbanecomau_car_data', 'filter_fusobrisbanecomau_car_data');

function filter_fusobrisbanecomau_car_data($car_data) {

     
    if($car_data['stock_type']=='demo'){
        $car_data['custom']="demo";
        $car_data['stock_type']="new";
    }
    else{
        $car_data['custom']=$car_data['stock_type'];
    }
    
    
    return $car_data;
}
