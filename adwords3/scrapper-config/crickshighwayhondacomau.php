<?php
global $scrapper_configs;
$scrapper_configs["crickshighwayhondacomau"] = array( 
	'entry_points' => array(
             'used'  => 'https://crickshighwayhonda.com.au/stock/used',
            'new'   => 'https://crickshighwayhonda.com.au/stock/new',
            'demo'  => 'https://crickshighwayhonda.com.au/stock/demo',
           
        ),
        'vdp_url_regex'     => '/stock\/details\//i',
        'use-proxy' => true,
        'refine'=>false,
          'picture_selectors' => ['.lslide'],
        'picture_nexts'     => ['.lSNext'],
        'picture_prevs'     => ['.lSPrev'],
        'details_start_tag' => '<div class="cs-layout-grid',
        'details_end_tag'   => '<footer class=',
        'details_spliter'   => '<section class="car-list',
        'data_capture_regx' => array(
            'url'                 => '/<a href="(?<url>[^"]+)"\s*class="btn btn-primary"/',
            'year'                => '/title="(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
            'make'                => '/title="(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
            'model'               => '/title="(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
            'price'               => '/overall-price">[^>]+>(?<price>\$[0-9,]+)/',
            'trim'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)\s*(?<trim>[^"]+))/',
           
        ),
        'data_capture_regx_full' => array(        
            'kilometres'          => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^\s]+)/',
            'stock_number'        => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^\<]+)/',
            'engine'              => '/Engine:[^>]+>[^>]+>(?<engine>[^\s]+)/',
            'body_style'          => '/Body:[^>]+>[^>]+>(?<body_style>[^\<]+)/',
            'transmission'        => '/Transmission:[^>]+>[^>]+>(?<transmission>[^\<]+)/',
            'exterior_color'      => '/Colour:[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
            'fuel_type'           => '/Fuel Type:[^>]+>[^>]+>(?<fuel_type>[^\<]+)/',
            'drive_train'         => '/Drive:[^>]+>[^>]+>(?<drive_train>[^\<]+)/',
            'vin'                => '/VIN:[^>]+>[^>]+>(?<vin>[^\<]+)/',
            'description'         => '/<h2>Comments<\/h2>\s*<p>(?<description>[\s\S]*?(?=<h2>))/',
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" rel="next"\s*class="btn btn-primary"/',
        'images_regx'       => '/<li data-thumb="(?<img_url>[^\?]+)/'
    );

    add_filter('filter_crickshighwayhondacomau_car_data', 'filter_crickshighwayhondacomau_car_data');

function filter_crickshighwayhondacomau_car_data($car_data) {

     
    if($car_data['stock_type']=='demo'){
        $car_data['custom']="demo";
        $car_data['stock_type']="new";
    }
    else{
        $car_data['custom']=$car_data['stock_type'];
    }
    $car_data['description'] = str_replace(['<','"'], ['',''], $car_data['description']);
    $car_data['description'] = strip_tags(preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['description']));
    if($car_data['stock_number']=='UH9019'){
        return null;
    }
    return $car_data;
}


    add_filter("filter_crickshighwayhondacomau_field_price", "filter_crickshighwayhondacomau_field_price", 10, 3);
    function filter_crickshighwayhondacomau_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $was = '/overall-price">[^>]+>Was\s*(?<price>\$[0-9,]+)/';
    $now = '/class="t-large">Now\s*(?<price>\$[0-9,]+)/';



    $matches = [];

    if (preg_match($was, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex was: {$matches['price']}");
    }
    if (preg_match($now, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex now: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_crickshighwayhondacomau_field_images", "filter_crickshighwayhondacomau_field_images");
function filter_crickshighwayhondacomau_field_images($im_urls) {
     if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}
