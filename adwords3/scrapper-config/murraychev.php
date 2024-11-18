<?php
global $scrapper_configs;
 $scrapper_configs["murraychev"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.murraychev.ca/inventory/new/',
        'used' => 'https://www.murraychev.ca/inventory/used/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',
    'picture_selectors' => ['.slick-lightbox-slick-img'],
    'picture_nexts' => ['.slick-next'],
    'picture_prevs' => ['.slick-prev'],
   'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'id="carbox',
    'data_capture_regx' => array(
         'url'   => '/data-permalink="(?<url>[^"]+)"/',
        'year' => '/class="vehicle-title--year">\s*(?<year>[0-9]{4})/',
        'make' => '/class="notranslate vehicle-title--make\s*">\s*(?<make>[^\s]+)/',
        'model' => '/class="notranslate vehicle-title--model\s*">\s*(?<model>[^<]+)/',
       // 'trim' => '/class="notranslate vehicle-title--trim ">\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/Sale Price<\/div>[^\$]+\$[^>]+>(?<price>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'price' => '/"price":(?<price>[^\,]+)/',
        'kilometres' => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine' => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'drivetrain' => '/class="title-drivetrain vehicle-title--subtitle-item">(?<drivetrain>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/',
        'vin' => '/VIN#:<\/span>\s*<span\s*class="vehicleIds--value"\s*>(?<vin>[^<]+)/',
       // 'description' => '/class="vehicle-description mt-3">\s*(?<description>[^<]+)/',
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_murraychev_field_price", "filter_murraychev_field_price", 10, 3);

function filter_murraychev_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/srp-price--title">\s*Was[^>]+>[^>]+>\s*[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/class="numbers">(?<price>[0-9,]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_murraychev_field_images", "filter_murraychev_field_images",10,2);

     function filter_murraychev_field_images($im_urls,$car_data)
    {
          
    if(isset($car_data['url']) && $car_data['url'])
    {   
      
       $api_url="https://www.murraychev.ca/api/ajax_requests/?currentQuery=".$car_data['url'];
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
  