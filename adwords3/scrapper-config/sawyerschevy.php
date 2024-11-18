<?php
    global $scrapper_configs;

    $scrapper_configs['sawyerschevy'] = array(
        'entry_points' => array(
            'new'   => 'https://www.sawyerschevy.com/searchnew.aspx',
            'used'  => 'https://www.sawyerschevy.com/searchused.aspx',
            //'certified'=> 'http://www.sawyerschevy.com/VehicleSearchResults?search=certified'
       ),
        'vdp_url_regex'     => '/\/www.sawyerschevy.com\/(?:new|used|certified)-/i',
        //'ty_url_regex'      => '/\/thankYou.do/i',
        //'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'   => true,
        'refine'   => false,
        'picture_selectors' => ['.carousel__item.js-carousel__item'],
        'picture_nexts'     => ['.carousel__control.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control.carousel__control--prev'],

        'details_start_tag' => 'class="list-unstyled margin-x pager"',
        'details_end_tag'   => 'class="visible-sm visible-xs col-xs-12 text-right"',
        'details_spliter'   => 'class="row srpVehicle hasVehicleInfo"',
        'data_capture_regx' => array(
           'stock_number'      => '/Stock #: <\/strong>(?<stock_number>[^<]+)/',
           // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
           'year'              => '/class="notranslate">(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
           'make'              => '/class="notranslate">(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
           'model'             => '/class="notranslate">(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
         
           'trim'              => '/class="notranslate">(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
           
           'url'               => '/<a class="h2" href="(?<url>[^"]+)/',
           'price'             => '/(?:Retail Price:|MSRP:|Sawyers Price:) <\/span><span style="[^"]+" class="[^"]+">(?<price>\$[0-9,]+)/',
           'body_style'        => '/Body Style: <\/strong>(?<body_style>[^<]+)/',
           'exterior_color'    => '/Ext. Color: <\/strong>(?<exterior_color>[^<]+)/',
           'engine'            => '/Engine: <\/strong>(?<engine>[^<]+)/',
           'transmission'      => '/Transmission: <\/strong>(?<transmission>[^<]+)/',
           'kilometres'        => '/Mileage: <\/strong>(?<kilometeres>[^<]+)/',
           
           'interior_color'    => '/Int. Color: <\/strong>(?<interior_color>[^<]+)/',
           'vin'               => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
           'drivetrain'        => '/Drive Type: <\/strong>(?<drivetrain>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
           
           

       ),
       'next_page_regx'        => '/<a href="(?<next>[^"]+)" aria-label="Next"/',
        'images_regx'           => '/-->\s*<img src="(?<img_url>[^"]+)" alt="/',
        
    );
    add_filter("filter_sawyerschevy_field_price", "filter_sawyerschevy_field_price", 10, 3);

function filter_sawyerschevy_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP: <\/span><span style="[^"]+" class="[^"]+">(?<price>\$[0-9,]+)/';
    $retail_regex = '/Retail Price: <\/span><span style="[^"]+" class="[^"]+">(?<price>\$[0-9,]+)/';
    $sawyers_regex = '/Sawyers Price: <\/span><span style="[^"]+" class="[^"]+">(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    
    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($sawyers_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Sawyers Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
    
add_filter("filter_sawyerschevy_field_images", "filter_sawyerschevy_field_images");
 function filter_sawyerschevy_field_images($im_urls)
    {
              return  array_filter($im_urls,function($img_url){
              return !endsWith($img_url,"photo_unavailable_640.jpg?height=400");
           }
        );
       
      
    }