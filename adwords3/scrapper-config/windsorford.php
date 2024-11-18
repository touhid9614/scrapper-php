<?php

global $scrapper_configs;

    $scrapper_configs["windsorford"] = array( 
     'entry_points' => array(
         'new_truck' => 'https://www.windsorford.com/inventory/New/?vehicleclass=truck&page=1',
         'new_sport_utility' => 'https://www.windsorford.com/inventory/New/?vehicleclass=Sport+Utility&page=1',
         'new_car' => 'https://www.windsorford.com/inventory/New/?vehicleclass=car&page=1',
         'new_van' => 'https://www.windsorford.com/inventory/New/?vehicleclass=van&page=1',
         
         'used_truck' => 'https://www.windsorford.com/inventory/Used/?vehicleclass=truck&page=1',
         'used_sport_utility' => 'https://www.windsorford.com/inventory/Used/?vehicleclass=Sport+Utility&page=1',
         'used_car' => 'https://www.windsorford.com/inventory/Used/?vehicleclass=car&page=1',
         'used_van' => 'https://www.windsorford.com/inventory/Used/?vehicleclass=van&page=1',
    ),
    'use-proxy' => true,
    'refine'=>false,
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}\//i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
        
    'picture_selectors' => ['.fancybox-image'],
    'picture_nexts' => ['.fancybox-button.fancybox-button--arrow_right'],
    'picture_prevs' => ['.fancybox-button.fancybox-button--arrow_left'],
        
    'details_start_tag' => '<div class="container inventory-vehicle-page',
    'details_end_tag' => '<footer class=',
    'details_spliter' => 'div class="inventory-vehicle-inner-container',
     
    'data_capture_regx' => array(
        'url' => '/class="inventory-vehicle-header" itemprop="name"><a href="(?<url>[^"]+)/',
        'year' => '/data-year="(?<year>[0-9]{4})"/',
        'make' => '/data-make="(?<make>[^"]+)"/',
        'model' => '/data-model="(?<model>[^"]+)"/',     
        'stock_number' => '/STOCK:\s*(?<stock_number>[^<]+)/',
        'price' => '/Dealer Price[^>]+>[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Mileage:[^>]+>(?<kilometres>[^\s]+)/',
        'exterior_color'=> '/Exterior:[^>]+>(?<exterior_color>[^<]+)/',
    ),
   
    'data_capture_regx_full' => array(
         'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission'  => '/Transmission[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'interior_color'=> '/Interior[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'body_style'=> '/Exterior[^>]+>[^>]+>(?<body_style>[^<]+)/',
        'lease'     => '/Condition[^>]+>[^>]+>(?<lease>[^<]+)/',
    ),
   'next_page_regx'  => '/name="page".*value="(?<next>[0-9]*)">/',
    'images_regx' => '/data-thumb="(?<img_url>[^"]+)">/'
);
    
    
    
add_filter('filter_windsorford_car_data', 'filter_windsorford_car_data');  
function filter_windsorford_car_data($car_data) {
    
    if($car_data['stock_type']=='new_truck' || $car_data['stock_type']=='used_truck')
    {
        $car_data['body_style']='truck';;
        $car_data['stock_type']=strtolower($car_data['lease']);
        $car_data['lease']=null;
    }
    
    if($car_data['stock_type']=='new_sport_utility' || $car_data['stock_type']=='used_sport_utility')
    {
        $car_data['body_style']='sport utility';;
        $car_data['stock_type']=strtolower($car_data['lease']);
        $car_data['lease']=null;
    }
    
    if($car_data['stock_type']=='new_car' || $car_data['stock_type']=='used_car')
    {
        $car_data['body_style']='car';;
        $car_data['stock_type']=strtolower($car_data['lease']);
        $car_data['lease']=null;
    }
    
    if($car_data['stock_type']=='new_van' || $car_data['stock_type']=='used_van')
    {
        $car_data['body_style']='van';;
        $car_data['stock_type']=strtolower($car_data['lease']);
        $car_data['lease']=null;
    }

    return $car_data;
}


add_filter("filter_windsorford_next_page", "filter_windsorford_next_page", 10, 2);
function filter_windsorford_next_page($next, $current_page) {
        
           slecho($current_page);
           $next=explode('/',$next);
           $index=count($next)-1;
           $next=($next[$index]);
           $next++;
         if($next<7){
           $peg="page=" . $next;
           $prev="page=" . ($next-1);
           $url= str_replace($prev, $peg, $current_page);
         return $url; 
         }else{
             return null;
         }
           
}
 add_filter("filter_windsorford_field_price", "filter_windsorford_field_price", 10, 3);
 function filter_windsorford_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp-price-strike">[^\s*]+\s*(?<price>[^<]+)/';
    $internet_regex = '/MSRP<br><span>(?<price>[^<]+)/';
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

add_filter("filter_windsorford_field_images", "filter_windsorford_field_images");
function filter_windsorford_field_images($im_urls) {
     if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}
