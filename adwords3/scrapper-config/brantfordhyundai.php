<?php
    global $scrapper_configs;

    $scrapper_configs['brantfordhyundai'] = array(
      'entry_points' => array(
        'used'  => 'https://www.brantfordhyundai.ca/inventory.html?filterid=a8b1q0-10x0-0-0',
        'new' => 'https://www.brantfordhyundai.ca/inventory.html?filterid=a8b3q0-10x0-0-0',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/.*[0-9]{4}-/i',
    'use-proxy' => true,
        'refine'=>false,
    'picture_selectors' => ['.slide a img'],
    'picture_nexts' => ['div a.next'],
    'picture_prevs' => ['div a.previous'],
    'details_start_tag' => 'class="isPageFullWidthEnabled UsedSrp2',
    'details_end_tag' => 'class="certified-logo__container">',
    'details_spliter' => '<li class="carBoxWrapper"',
    'data_capture_regx' => array(
        'stock_number' => '/>Stock:\s*(?<stock_number>[^<]+)/',
        // 'stock_type'   => '/class="divSpan carTitle">\s*<a href="https:\/\/www.brantfordhyundai.ca\/(?<stock_type>[^\/]+)/',
        'url' => '/<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]*))/',
        'year' => '/<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]*))/',
        'make' => '/<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]*))/',
        'model' => '/<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]*))/',
        'price' => '/<span data-tooltip=[^>]+>(?<price>[0-9,]+)/',
        'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine:\s*(?<engine>[^<]+)/',
        'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:\s*(?<exterior_color>[^<]+)/',
        'vin'            => '/VIN:\s*(?<vin>[^<]+)/',
        'model'            => '/Model:\s*(?<model>[^<]+)/',
        'trim'          => '/Trim Level:(?<trim>[^<]+)/',
        'body_style'     => '/>Category:\s*(?<body_style>[^<]+)/',
    ),
    //'next_page_regx' => '//',
    'images_regx' => '/<a rel="slider-lightbox[^"]+"\shref="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image"content="(?<img_url>[^"]+)/'
);


add_filter('filter_brantfordhyundai_car_data', 'filter_brantfordhyundai_car_data');

function filter_brantfordhyundai_car_data($car_data) {
  
    
   if(strpos($car_data['url'], "new")) {

       $car_data['stock_type']="new";
       
    } else {
        $car_data['stock_type']="used";
    }
    return $car_data;
}
add_filter("filter_brantfordhyundai_field_images", "filter_brantfordhyundai_field_images");
    function filter_brantfordhyundai_field_images($im_urls)
    {
      $retval = [];
         if(count($im_urls)<3)
            {
            return [];
            
            }
    foreach ($im_urls as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return $retval;
    }
