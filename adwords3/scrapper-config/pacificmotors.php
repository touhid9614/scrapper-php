<?php

global $scrapper_configs;
$scrapper_configs["pacificmotors"] = array(
    'entry_points' => array(
        'used' => 'https://www.pacificmotors.ca/used-vehicles-for-sale-in-winnipeg?page=1'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/[0-9]{4}-/i',
    'srp_page_regex'      => '/\/(?:new|used|certified)-vehicles/i',
    'use-proxy' => true,
      'refine' => false,
    'picture_selectors' => ['#Photos div div img'],
    'picture_nexts' => ['li a.flex-next'],
    'picture_prevs' => ['li a.flex-prev'],
    'details_start_tag' => '<div class="page-content-element">',
    'details_end_tag' => '<div class="footer-container',
    'details_spliter' => '<div class="col- dynamic-col">',
    'data_capture_regx' => array(
        'stock_number' => '/class="stocknumber">(?<stock_number>[^<]+)/',
        'url' => '/accent-color1" href="(?<url>[^"]+)"\s* title="(?<title>[^"]+)/',
       // 'title' => '/accent-color1" href="(?<url>[^"]+)"\s* title="(?<title>[^"]+)/',
        'year' => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)/',
        'make' => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)/',
        'model' => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)/',
        'trim' => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+)/',
        'price' => '/pricevalue1 accent-color1"style="">[^\$]+\$<\/span>(?<price>[0-9,]+)/',
        'exterior_color' => '/class="Extcolor">(?<exterior_color>[^<]+)/',
        'interior_color' => '/class="Intcolor">(?<interior_color>[^<]+)/',
        'engine' => '/class="engine">(?<engine>[^<]+)/',
     
        'transmission' => '/class="transmission">(?<transmission>[^<]+)/',
        'vin' => '/class="vin">(?<vin>[^<]+)/',
        'body_style' => '/accent-color1" href="[^"]+"\s* title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^\s*]+).*(?<body_style>(?:SUV|Sedan|Truck|Superduty|Van|Hatchback|Wagon|Coupe))"/',
    ),
    'data_capture_regx_full' => array(
           'kilometres' => '/Kilometers[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
         'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx' => '/(?<next>[0-9])\'\);" title="Next Page">/',
    'images_regx' => '/src\s*:\s*\'(?<img_url>[^\']+)/'
);

add_filter("filter_pacificmotors_next_page", "filter_pacificmotors_next_page", 10, 2);
add_filter("filter_pacificmotors_field_price", "filter_pacificmotors_field_price", 10, 3);

function filter_pacificmotors_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Special Price[^\$]+\$<\/span>(?<price>[0-9,]+)/';
    $wholesale_regex = '/Market Value[^\$]+\$<\/span>(?<price>[0-9,]+)/';
    


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}



function filter_pacificmotors_next_page($next, $current_page) {
   
    
    $next=explode('/',$next);
            $index=count($next)-1;
            $next=($next[$index]);
            $peg="page=" . $next;
            $prev="page=" . ($next-1);
            $url= str_replace($prev, $peg, $current_page);
          
           return $url;
    
 }
 
 add_filter("filter_pacificmotors_field_images", "filter_pacificmotors_field_images", 10, 2);

function filter_pacificmotors_field_images($im_urls, $car_data) {
    $retval = array();
    
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace('\"','', rawurldecode($im_url));
    }
    
    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);

    return $retval;
}