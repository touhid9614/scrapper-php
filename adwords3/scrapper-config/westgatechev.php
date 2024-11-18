<?php
global $scrapper_configs;
 $scrapper_configs["westgatechev"] = array( 
	'entry_points' => array(
        'new'  => 'https://www.westgatechev.com/inventory/new/',
        'used' => 'https://www.westgatechev.com/inventory/used/'
      
    ),
   'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)/i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
     
   'picture_selectors' => ['.slick-slide img'],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
     
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap loading ">',
     
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        'year' => '/year">\s*(?<year>[0-9]{4})/',
        'make' => '/make notranslate">\s*(?<make>[^\s]+)/',
        'model' => '/model notranslate">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/Westgate Price<\/div>[^\$]+\$[^>]+>(?<price>[0-9,]+)/',
      
    ),
     
    'data_capture_regx_full' => array(
      'kilometres'    => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
     'engine'        => '/Engine:[^>]+>\s*[^>]+>(?<engine>[^\<]+)/',
     'exterior_color'=> '/Exterior Color:[^>]+>\s*[^>]+>(?<exterior_color>[^\<]+)/',
     'interior_color'=> '/Interior Color:[^>]+>\s*[^>]+>(?<interior_color>[^\<]+)/',
     'transmission'  => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^\<]+)/',    
    ),
     
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'    => '/data-lightbox="(?<img_url>[^"]+)"/',
);

add_filter("filter_westgatechev_field_price", "filter_westgatechev_field_price", 10, 3);
  

    function filter_westgatechev_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Price: $price");
        }
        
        $msrp_regex =  '/(?:MSRP|Retail Price)[^>]+>[^>]+>\s*[^>]+>[^>]+>\$[^>]+>[^>]+>(?<price>[0-9,]+)/';
        
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
   