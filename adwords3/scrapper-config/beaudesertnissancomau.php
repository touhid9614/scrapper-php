<?php
global $scrapper_configs;
$scrapper_configs["beaudesertnissancomau"] = array( 
	"entry_points" => array(
     
         'used' => 'https://beaudesertnissan.com.au/used-vehicles/?stockLimit=1000',
         'new' => 'https://beaudesertnissan.com.au/new-vehicles/?stockLimit=1000',
         'demo'  => 'https://beaudesertnissan.com.au/demo-vehicles/?stockLimit=1000',
       
    ),
    'vdp_url_regex' => '/au\/[^-]+-[^-]+-[^-]+-[^-]+-[0-9]{4}/i',
    'use-proxy' => true,
    'refine' => false,
   // 'required_params' => ['info', 'id'],
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts' => ['.slick-next', '.mfp-arrow .mfp-arrow-right'],
    'picture_prevs' => ['.slick-prev', '.mfp-arrow .mfp-arrow-left'],
    'details_start_tag' => '<div id="stockListContainer"',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="stock-item',
    'data_capture_regx' => array(
       // 'stock_number' => '/si-title stockListItemTitleList">\s*[^<]+<small>#(?<stock_number>[^\s*]+)/',
        
        'title' => '/class="si-title stockListItemTitleList">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'year'  => '/class="si-title stockListItemTitleList">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'make'  => '/class="si-title stockListItemTitleList">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'model' => '/class="si-title stockListItemTitleList">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'price' => '/<h4 class="price fullPrice">(?<price>\$[0-9,]+)/',
        
        
       
        'url' => '/<div class="si-thumb si-thumb-view-list stockList_item_img_header col-md-7">\s*<a href="(?<url>[^"]+)"/',
       
    ),
    'data_capture_regx_full' => array(  
         'engine'        => '/Engine<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<engine>[^,]+)/',
         'kilometres'    => '/Odometer<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[0-9]+)/',
        'exterior_color' => '/Colour<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<exterior_color>[^<]+)/',
        'transmission'   => '/Transmission<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<transmission>[^<]+)/',
        'stock_number'   => '/Stock Number<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<stock_number>[^<]+)/',
        'vin'            => '/VIN<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<vin>[^<]+)/',
        'drive_train'    => '/"dd_stock_drive":"(?<drive_train>[^"]+)/',
        'fuel_type'      => '/Fuel Type<\/strong>\s*[^>]+>\s*[^>]+>\s*(?<fuel_type>[^<]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        'trim'           => '/dd_stock_badge":"(?<trim>[^"]+)/',
    ),
    'next_page_regx'    => '/<li class="paginateNext paginateSentinel"><a href="(?<next>[^"]+)">Next/',
    'images_regx'       => '/<li>\s*<img src="(?<img_url>[^"]+)"\s*alt/',
       
);

 add_filter('filter_beaudesertnissancomau_field_url', 'filter_beaudesertnissancomau_field_url');
     function filter_beaudesertnissancomau_field_url($url)
     {
         slecho("URLLL:".$url);
         $url =  "https://beaudesertnissan.com.au/" . $url;
         slecho("URLLL_m:".$url);
         return $url;
     }

add_filter('filter_beaudesertnissancomau_car_data', 'filter_beaudesertnissancomau_car_data');

function filter_beaudesertnissancomau_car_data($car_data) {

     
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
       
 add_filter("filter_beaudesertnissancomau_next_page", "filter_beaudesertnissancomau_next_page", 10, 2);       
 function filter_beaudesertnissancomau_next_page($next, $current_page) {

     $next =preg_replace('/(?:new|used|demo)-vehicles\//', '', $next);
     slecho("abcdefg:" . $next);
    
    return $next;
}
