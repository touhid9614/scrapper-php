<?php
global $scrapper_configs;
$scrapper_configs["palmendodgechryslerjeepofracinecom"] = array( 
	'entry_points' => array(
            'used' => 'https://www.palmendodgechryslerjeepofracine.com/new-vehicles-racine-wi?limit=300',
        'new' => 'https://www.palmendodgechryslerjeepofracine.com/used-vehicles-racine-wi?limit=300',
        
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'=> false,
    'picture_selectors' => ['.zoom-thumbnails__thumbnail'],
    'picture_nexts' => ['.df-icon-chevron-right'],
    'picture_prevs' => ['.df-icon-chevron-left'],
    'details_start_tag' => '<div class="inventory-listing vehicle-items',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="vehicle-item inventory-listing__item',
    'data_capture_regx' => array(
        'stock_number' => '/"Stock">[^>]+>\s*[^\s]+\s(?<stock_number>[^<]+)/',
        'url' => '/vehicle-item-descr">\s*<a href="(?<url>[^"]+)/',
       // 'title' => '/class="vehicle-title ">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'year' => '/vehicle-item-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make' => '/vehicle-item-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model' => '/vehicle-item-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'price' => '/Palmen Racine Price\s*[^>]+>[^>]+>\s*(?<price>\$[0-9,]+)/',
       
    ),
    'data_capture_regx_full' => array(
         'exterior_color' => '/Exterior Color<\/div>[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/div>[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'engine' => '/Engine:\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission<\/div>[^>]+>[^>]+>(?<transmission>[^<]+)/',
     
        'kilometres' => '/Mileage:\s*(?<kilometres>[^<]+)/',
           'vin' => '/VIN<\/div>[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),
    // 'next_page_regx' => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/class="main-slider__inner-img" src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
  add_filter("filter_palmendodgechryslerjeepofracinecom_field_price", "filter_palmendodgechryslerjeepofracinecom_field_price", 10, 3);
     function filter_palmendodgechryslerjeepofracinecom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $msrp_regex       =  '/Palmen Price\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
       

                
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

    
   