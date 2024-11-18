<?php
global $scrapper_configs;
 $scrapper_configs["buchanansubarucom"] = array( 
	
	 "entry_points" => array(  
         'used' => 'http://www.buchanansubaru.com/used-inventory/index.htm',
        'new' => 'http://www.buchanansubaru.com/new-inventory/index.htm',
             
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified|wholesale-new|exotic-new)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => false,
    'refine'=>false,
  'picture_selectors' => ['.pswp-thumbnail'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
   
     'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="fn\s\s"><a class="url" href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/(?:Sale Price|Final Price|Price)[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/', ///dealer price///
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
       // 'stock_number' => '/Stock:\s*<[^>]+>(?<stock_number>[^<]+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_buchanansubaru_field_price", "filter_buchanansubaru_field_price", 10, 3);
add_filter("filter_buchanansubaru_field_images", "filter_buchanansubaru_field_images");
  

function filter_buchanansubaru_field_images($im_urls) {
   $retval = [];
         foreach($im_urls as $img)
        {
            
             $retval[] = str_replace(["|","%20","?impolicy=resize&w=650","?impolicy=resize&w=414","?impolicy=resize&w=768","?impolicy=resize&w=1024"], ["%7C"," ", " "," "," "," "], $img);
        }
        
        return $retval;
}

function filter_buchanansubaru_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }
 
    $msrp_regex = '/MSRP[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';  ///msrp//
      $final_regex = '/.final-price .price-value">(?<price>[^<]+)/';//final price
  


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
 if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex final: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}



