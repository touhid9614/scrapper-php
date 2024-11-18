<?php

global $scrapper_configs;

$scrapper_configs['campkins'] = array(
    'entry_points' => array(
        'new' => array (
            'https://campkins.com/rv-showroom/filtered-units/pagenum/1',
            'https://campkins.com/rv-showroom/filtered-units/pagenum/2',
            
            ),
             
    ),
    'vdp_url_regex' => '/\/rv-showroom\/[0-9]{4}-/i',
      'srp_page_regex'      => '/\/rv-inventory\//',
    'ajax_url_match' => 'server/post.forms.php',
    'use-proxy' => true,
    'refine' => false,
    'details_start_tag' => '<div class="jet-listing-grid__items grid-col-desk-4 grid-col-tablet-2',
    'details_spliter' => '<div class="jet-listing-grid__item jet-listing-dynamic-post-',
    
    'data_capture_regx' => array(
        'url'           => '/<a href="(?<url>[^"]+)"\s*class="jet-listing-dynamic-link__link">/',
        'year'          => '/<a href="(?<url>[^"]+)"\s*class="jet-listing-dynamic-link__link">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make'          => '/<a href="(?<url>[^"]+)"\s*class="jet-listing-dynamic-link__link">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model'         => '/<a href="(?<url>[^"]+)"\s*class="jet-listing-dynamic-link__link">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price'         => '/(?:CLEARANCE PRICE|Web Price)\s*[^\$]+[^\$]+(?<price>\$[0-9,]+)/',
        'stock_number'  => '/field__content">Stock\s*(?<stock_number>[^<]+)/',                
    ),
    'data_capture_regx_full' => array(
        
        'stock_type' => '/<div class="jet-listing-dynamic-field__content">(?<stock_type>(?:New|Pre-Owned))/',
        
    ),
    'next_page_regx' => '/right" aria-label="Next(?<next>[^"]+)/',
    'images_regx' => '/data-large_image="(?<img_url>[^"]+)" data/'
);

add_filter('filter_campkins_car_data', 'filter_campkins_car_data');
function filter_campkins_car_data($car_data) {
    
       
     if($car_data['stock_type']=="Pre-Owned")
     {
         $car_data['stock_type']="used";
     }
     $car_data['stock_type']= strtolower($car_data['stock_type']);
     
    return $car_data;
}

        
 add_filter("filter_campkins_next_page", "filter_campkins_next_page", 10, 2);       
 function filter_campkins_next_page($next, $current_page) {

    
        slecho("Filtering Next url : " . $current_page);
	$page_nums  = explode('/', $current_page);
        $page_num   = $page_nums[count($page_nums) - 1];
        $str_prev   = "pagenum/" . $page_num;
        $page_num   = $page_num + 1;
        $str_next   = "pagenum/" . $page_num;
        
        $next       =  str_replace($str_prev,$str_next,$current_page);
        slecho("next page url: " . $next);
        $cccc=30;
        if($page_num>$cccc){
            return null;
        }
        
    return $next;
}