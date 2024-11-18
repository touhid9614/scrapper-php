<?php
global $scrapper_configs;

$scrapper_configs['westerngmcbuick'] = array(
   'entry_points' => array(
        'new' => 'https://www.westerngmcbuick.com/inventory/new/',
        'used' => 'https://www.westerngmcbuick.com/inventory/Used/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)/i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
     
   'picture_selectors' => ['.slick-slide',],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
     
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap loading ">',
     
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        //'title' => '/wrap-carbox-title"> <h2>[^\s]+\s(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/year">\s*(?<year>[0-9]{4})/',
        'make' => '/make notranslate">\s*(?<make>[^\s]+)/',
        'model' => '/model notranslate">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/Western Price<\/div>[^\$]+\$[^>]+>(?<price>[0-9,]+)/',
      
    ),
     
    'data_capture_regx_full' => array(
        
        'kilometres' => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine'     => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'drivetrain'   => '/Drivetrain:<\/span>[^>]+>(?<drivetrain>[^<]+)/',
        'exterior_color'   => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/', 
        'interior_color'   => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/', 
        'vin'   => '/"vin">(?<vin>[^<]+)/',
        'description'   => '/vehicle-descriptions__value ">(?<description>[^<]+)/',
        'body_style'    => '/data-vehicle="standardbody" >(?<body_style>[^<]+)/',
  
    ),
     
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'    => '/data-lightbox="(?<img_url>[^"]+)"/',
);

add_filter("filter_westerngmcbuick_field_price", "filter_westerngmcbuick_field_price", 10, 3);
  

    function filter_westerngmcbuick_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Price: $price");
        }
        
        $msrp_regex =  '/MSRP[^>]+>[^>]+>\s*[^>]+>[^>]+>\$[^>]+>[^>]+>(?<price>[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
   add_filter("filter_westerngmcbuick_field_images", "filter_westerngmcbuick_field_images",10,2);

     function filter_westerngmcbuick_field_images($im_urls,$car_data)
    {
          
    if(isset($car_data['url']) && $car_data['url'])
    {   
      
       $api_url="https://www.westerngmcbuick.com/api/ajax_requests/?currentQuery=".$car_data['url'];
       $response_data = HttpGet($api_url);
       $regex       =  '/url":"(?<img_url>[^"]+)","width":"1600","height":"900"/';
       
        $matches = [];
        
        
        if (preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value) {
                $retval= str_replace(['\\'], [''], rawurldecode($value));
                $im_urls[] = $retval;
            }
           
        }
   
    }
    
    return  $im_urls;
    
    
    }