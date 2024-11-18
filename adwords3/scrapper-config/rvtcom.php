<?php
global $scrapper_configs;
$scrapper_configs["rvtcom"] = array( 
	'entry_points' => array(
        'new'  => 'https://www.rvt.com/dealersearch.php',
        
       
    ),
        
    'use-proxy' => true,
    'refine'    => false,
        
     'details_start_tag' => '<div class="left">',
     'details_end_tag'   => '<!-- /content-col -->',
     'details_spliter'   => '</a></li>',
     'data_capture_regx' => array(
        
        'url'            => '/<li><a href="(?<url>[^"]+)">/',
        

    ),
    'data_capture_regx_full' => array(
           'make'             => '/<address>[^>]+>(?<make>[^\/]+)/',
           'model'            => '/<address>[^>]+>(?<model>[^\/]+)/',
           'title'            => '/<div class="dl-list-info">\s*<h1>(?<title>[^<]+)/',
           'url'              => '/<li><a href="(?<url>[^"]+)" id="gtm-dlr-site-button-inv"/',
           'interior_color'   => '/<a href="\.\.(?<interior_color>[^"]+)">Dealer Information/',
           
    ),
       
);

add_filter('filter_rvtcom_car_data', 'filter_rvtcom_car_data');

function filter_rvtcom_car_data($car_data) {
    
    $car_data['make'] =strip_tags($car_data['make']);
    $car_data['model']=strip_tags($car_data['model']);
    $api_url="https://www.rvt.com/" . $car_data['interior_color'];
    
     $response_data = HttpGet($api_url);
     $regex       =  '/(?:Sales|Toll Free):(?<description>[^<]+)<br>/';
     $matches = [];
     if(preg_match($regex, $response_data, $matches)) {
           
      $car_data['description']=$matches['description'];
             
      }    

    return $car_data;
}
