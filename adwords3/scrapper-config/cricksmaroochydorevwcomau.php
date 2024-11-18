<?php
global $scrapper_configs;
$scrapper_configs["cricksmaroochydorevwcomau"] = array( 
		"entry_points" => array(
         'demo'  => 'https://cricksmaroochydorevw.com.au/demo-models/?stockLimit=1000',
         'used' => 'https://cricksmaroochydorevw.com.au/used-models/?stockLimit=1000',
         'new' => 'https://cricksmaroochydorevw.com.au/new-models/?stockLimit=1000',
         
    ),
    'vdp_url_regex' => '/au\/[a-zA-Z0-9]/i',
    'use-proxy' => false,
    'refine' => false,
    //'required_params' => ['info', 'id'],
    'picture_selectors' => ['.first'],
    'picture_nexts' => ['.flex-next'],
    'picture_prevs' => ['.flex-prev'],
    'details_start_tag' => '<div id="stockListContainer"',
    'details_end_tag' => 'footer-nav',
    'details_spliter' => 'si-view row',
    
    'data_capture_regx' => array(
        'url' => '/class="si-thumb si-thumb-view-grid stockLeft">\s*<a href="(?<url>[^"]+)"\s*class="si-rpmt-cta-vdp"/',
        'stock_number' => '/class="si-title stockListItemTitleList">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)[^>]+>\s*(?<stock_number>[^\s*]+)/',
        'vin' => '/"vehicleVIN":\s*"(?<vin>[^"]+)/',
        // 'title' => '/class="si-title stockListItemTitleList">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'year' => '/class="si-title stockListItemTitleList">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)[^>]+>\s*(?<stock_number>[^\s*]+)/',
        'make' => '/class="si-title stockListItemTitleList">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)[^>]+>\s*(?<stock_number>[^\s*]+)/',
        'model' => '/class="si-title stockListItemTitleList">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)[^>]+>\s*(?<stock_number>[^\s*]+)/',
        'price' => '/class="price fullPrice">(?<price>[^<]+)/',
        'stock_number' => '/class="si-title stockListItemTitleList">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)[^>]+>\s*(?<stock_number>[^\s*]+)/',
    ),
    'data_capture_regx_full' => array(  
        'fuel_type' => '/EngineFuelType"\s*[^"]+"(?<fuel_type>[^"]+)/',
        'transmission' => '/Transmission[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'body_style' => '/Body[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<body_style>[^<]+)/',
        //'stock_number' => '/<span><strong>Stock Number[^>]+>[^>]+>.*\s*(?<stock_number>[^<]+)/',
        'vin'         => '/vehicleVIN":\s*"(?<vin>[^"]+)/',
        'exterior_color' => '/Colour<\/span>[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'drive_train' => '/"dd_stock_drive":"(?<drive_train>[^"]+)/',
        'description' => '<meta name="description" content="(?<description>[^"]+)/',
        'trim' => '/dd_stock_badge":"(?<trim>[^"]+)/',
    ),
    'next_page_regx' => '/<li class="paginateNext paginateSentinel"><a href="(?<next>[^"]+)">Next/',
    'images_regx' => '/<li>\s*<img src="(?<img_url>[^"]+)"\s*alt/',
       
);

 add_filter('filter_cricksmaroochydorevwcomau_field_url', 'filter_cricksmaroochydorevwcomau_field_url');
     function filter_cricksmaroochydorevwcomau_field_url($url)
     {
         slecho("URLLL:".$url);
         $url =  "https://cricksmaroochydorevw.com.au/" . $url;
         slecho("URLLL_m:".$url);
         return $url;
     }

add_filter("filter_cricksmaroochydorevwcomau_field_images", "filter_cricksmaroochydorevwcomau_field_images");
function filter_cricksmaroochydorevwcomau_field_images($im_urls)
   {
      
        $im_urls=array_unique($im_urls);

        if(count($im_urls)<=4){
            return [];
        }
        return $im_urls;
    }
    
    add_filter('filter_cricksmaroochydorevwcomau_car_data', 'filter_cricksmaroochydorevwcomau_car_data');

function filter_cricksmaroochydorevwcomau_car_data($car_data) {

     
    if($car_data['stock_type']=='demo'){
        $car_data['custom']="demo";
        $car_data['stock_type']="new";
    }
    else{
        $car_data['custom']=$car_data['stock_type'];
    }
    $car_data['description'] = strip_tags(preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['description']));
    $car_data['description'] =str_replace("<","",$car_data['description']);
    
    return $car_data;
}