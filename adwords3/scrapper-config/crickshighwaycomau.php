<?php
global $scrapper_configs;
$scrapper_configs["crickshighwaycomau"] = array( 
	"entry_points" => array(
	       
            'used'  => 'https://crickshighwayusedcars.com.au/stock',
            
        ),
        'vdp_url_regex'     => '/\/stock\/details\//i',
        'use-proxy' => true,
        'picture_selectors' => ['.lSPager.lSGallery'],
        'picture_nexts'     => ['.lSNext'],
        'picture_prevs'     => ['.lSPrev'],
        'details_start_tag' => '<div class="cs-layout-grid">',
        'details_end_tag'   => '<footer class="footer">',
        'details_spliter'   => '<section class="car-list',
        'data_capture_regx' => array(
            'url'                 => '/class="clm-image t-col-6 d-col-4">\s*<a href="(?<url>[^"]+)/',
            'year'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make'                => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model'               => '/<h1 title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price'               => '/<span class="t-large">Now\s*(?<price>\$[0-9,]+)/',
            'stock_number'        => '/class="stock_nos" value="(?<stock_number>[^"]+)/',
 
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
        'next_page_regx'    => '/<a href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<li data-thumb="(?<img_url>[^"]+)">/'
    );

add_filter("filter_crickshighwaycomau_field_price", "filter_crickshighwaycomau_field_price", 10, 3);

function filter_crickshighwaycomau_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/<span class="t-large">(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
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

add_filter('filter_crickshighwaycomau_car_data', 'filter_crickshighwaycomau_car_data');

function filter_crickshighwaycomau_car_data($car_data) {

     
     if($car_data['stock_type']=='demo'){
         $car_data['custom']="demo";
         $car_data['stock_type']="new";
     }
     else{
         $car_data['custom']=$car_data['stock_type'];
     }
    $car_data['description'] = strip_tags(preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['description']));
    $car_data['description'] =str_replace("<","",$car_data['description']);
    
    return $car_data;
}
