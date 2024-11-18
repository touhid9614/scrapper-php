<?php

global $scrapper_configs;

$scrapper_configs['andreselectronicexperts'] = array(
    'entry_points'           => array(
        'home-speakers'     => array(
            'https://www.andreselectronicexperts.com/products/category/floor-standing-speakers',
            'https://www.andreselectronicexperts.com/products/category/bookshelf-speakers',
            'https://www.andreselectronicexperts.com/products/category/center-channel-speakers',
            'https://www.andreselectronicexperts.com/products/category/subwoofers',
            'https://www.andreselectronicexperts.com/products/category/in-wall-in-ceiling-speakers',
            'https://www.andreselectronicexperts.com/products/category/sound-bar',
            'https://www.andreselectronicexperts.com/products/category/wireless-multi-room-audio',
            'https://www.andreselectronicexperts.com/products/category/headphones',
            'https://www.andreselectronicexperts.com/products/category/outdoor-speakers',
            'https://www.andreselectronicexperts.com/products/category/surround-speaker-packages',
            'https://www.andreselectronicexperts.com/products/category/in-wall-speakers',
            'https://www.andreselectronicexperts.com/products/category/satellite-speakers',
            'https://www.andreselectronicexperts.com/products/category/on-wall-speakers',
            'https://www.andreselectronicexperts.com/products/category/radios-and-clocks',
            'https://www.andreselectronicexperts.com/products/category/multi-room-wireless-speakers',
            'https://www.andreselectronicexperts.com/products/category/surround-speakers',
            'https://www.andreselectronicexperts.com/products/category/commercial-speakers',
            'https://www.andreselectronicexperts.com/products/category/desktop-speakers',
        ),
        'bbqsandgrills'  => array(
            'https://www.andreselectronicexperts.com/products/category/bbqsandgrills'
        ),
        'car-marine-audio'   => array(
            'https://www.andreselectronicexperts.com/products/category/car-speakers',
            'https://www.andreselectronicexperts.com/products/category/car-amplifiers',
            'https://www.andreselectronicexperts.com/products/category/car-subwoofers',
            'https://www.andreselectronicexperts.com/products/category/car-stereos',
            'https://www.andreselectronicexperts.com/products/category/car-stereos',
            'https://www.andreselectronicexperts.com/products/category/car-monitors',
            'https://www.andreselectronicexperts.com/products/category/back-up-cameras',
            'https://www.andreselectronicexperts.com/products/category/dash-cameras',
            'https://www.andreselectronicexperts.com/products/category/marine-speakers',
            'https://www.andreselectronicexperts.com/products/category/marine-subwoofers',
            'https://www.andreselectronicexperts.com/products/category/marine-amplifiers',
            'https://www.andreselectronicexperts.com/products/category/marine-stereos',
            
        ),
        
        'televisions'   => array(
            'https://www.andreselectronicexperts.com/products/category/televisions',
        ),

        'appliances' => array(
            'https://www.andreselectronicexperts.com/products/category/full-size-refrigerators',
           // 'https://www.andreselectronicexperts.com/products/category/compact-refrigerators',
            'https://www.andreselectronicexperts.com/products/category/dishwashers',
            'https://www.andreselectronicexperts.com/products/category/microwave',
            'https://www.andreselectronicexperts.com/products/category/electric-induction-ranges',
            'https://www.andreselectronicexperts.com/products/category/gas-dual-fuel-ranges',
            'https://www.andreselectronicexperts.com/products/category/electric-induction-cooktops',
            'https://www.andreselectronicexperts.com/products/category/gas-cooktops',
            'https://www.andreselectronicexperts.com/products/category/single-wall-oven',
            'https://www.andreselectronicexperts.com/products/category/double-wall-ovens',
            'https://www.andreselectronicexperts.com/products/category/wall-oven-combo',
            'https://www.andreselectronicexperts.com/products/category/warming-drawers',
            'https://www.andreselectronicexperts.com/products/category/freezers',
            'https://www.andreselectronicexperts.com/products/category/ventilation',
            'https://www.andreselectronicexperts.com/products/category/front-load-washers',
            'https://www.andreselectronicexperts.com/products/category/top-load-washers',
            'https://www.andreselectronicexperts.com/products/category/dryers',
        ),
        
    ),

    'vdp_url_regex'          => '/\/products\/view\//i',
    'srp_page_regex'      => '/\/products\/category\//',
    'use-proxy'              => true,
    'proxy-area'             => 'CA',
    'refine'                 => false,

    'details_start_tag'      => '<div class="row products-body">',
    'details_end_tag'        => '<nav class="toolbox toolbox-pagination">',
    'details_spliter'        => 'Add to Compare',
    'must_not_contain_regex' => '/availability_css">[^>]+>[^>]+>\s*<\/i>\s*Not Currently in Stock/',

    'data_capture_regx'      => array(
        'stock_number' => '/<h2 class="product-title">\s*<a class="[^"]+" rel="(?<stock_number>[^"\/]+)/',
        'make'         => '/<h2 class="product-title">\s*<a class="[^"]+" rel="(?<stock_number>[^"\/]+)"\s*href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model'        => '/<h2 class="product-title">\s*<a class="[^"]+" rel="(?<stock_number>[^"\/]+)"\s*href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'title'        => '/<h2 class="product-title">\s*<a class="[^"]+" rel="(?<stock_number>[^"\/]+)"\s*href="(?<url>[^"]+)">(?<title>(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'url'          => '/<h2 class="product-title">\s*<a class="[^"]+" rel="(?<stock_number>[^"\/]+)"\s*href="(?<url>[^"]+)">(?<title>(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'price'        => '/<span class="product-price"><sup>\$<\/sup>(?<price>\s*[0-9,.]+)/',
    ),

    'data_capture_regx_full' => array(
        'body_style' => '/<meta itemprop="category" content="[^>]+>(?<body_style>[^\s*"]+)/',
        'custom'     => '/availability_css">[^>]+>[^>]+>\s*<\/i>\s*(?<custom>[^\s*"]+)/',
    ),

    'next_page_regx'         => '/<li class="next"><a rel="next" href="(?<next>[^"]+)/',
    'images_regx'            => '/class="imgclick" itemprop="image"\s*src="[^>]+>\s*<a\s*href="(?<img_url>[^"]+)"/',
);

// add_filter("filter_andreselectronicexperts_field_price", "filter_andreselectronicexperts_field_price", 10, 3);
// add_filter("filter_andreselectronicexperts_field_msrp", "filter_andreselectronicexperts_field_msrp", 10, 3);
add_filter('filter_andreselectronicexperts_car_data', 'filter_andreselectronicexperts_car_data');

function filter_andreselectronicexperts_car_data($car_data)
{
    $car_data['make']         = str_replace('&', "and", $car_data['make']);
    $car_data['model']        = str_replace('&', "and", $car_data['model']);
    $car_data['stock_number'] = str_replace('&', "and", $car_data['stock_number']);

    $car_data['body_style'] = $car_data['stock_type'];
    $car_data['stock_type'] = "new";

    if (numarifyPrice($car_data['price']) > 15000) {
        return null;
    }

    if (numarifyPrice($car_data['price']) > 8000 && strpos($car_data['body_style'], "elevisions")) {
        return null;
    }
    slecho("availability: " . $car_data['custom']);
    if($car_data['custom']=='Not'){
        return null;
    }

    return $car_data;
}

//
//function filter_andreselectronicexperts_field_price($price, $car_data, $spltd_data)
//{
//    $prices = [];
//
//    if ($price && numarifyPrice($price) > 0) {
//        $prices[] = numarifyPrice($price);
//    }
//
//    $get_offer_regex = '/data-item-price=[^"]"(?<price>[0-9,.]+)/';
//    $internet_regex  = '/price":"[^\$]+\$(?<price>[0-9,.]+)/';
//    $url             = 'https://www.andreselectronicexperts.com/en/asyncresponse';
//
//    $post_data    = 'asyncRequest=getItemPrices&asyncData=%7B%22collection%22%3A%22%22%2C%22product%22%3A%22' . $car_data['stock_number'] . '%22%7D';
//    $content_type = 'application/x-www-form-urlencoded';
//    $in_cookies   = '';
//    $out_cookies  = '';
//    $resp         = HttpPost($url, $post_data, $in_cookies, $out_cookies, true, true, $content_type);
//
//    if ($out_cookies) {
//        $in_cookies = $out_cookies;
//    }
//
//    if (preg_match($get_offer_regex, $resp, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//    }
//
//    if (preg_match($internet_regex, $resp, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//    }
//
//    if (count($prices) > 0) {
//        $price = butifyPrice(min($prices));
//    }
//
//    return $price;
//}

//
//function filter_andreselectronicexperts_field_msrp($price, $car_data, $spltd_data)
//{
//    $get_offer_regex = '/label-product-detail-price-before[^>]+>(?<msrp>\$\s*[0-9,.]+)/';
//    $url             = 'https://www.andreselectronicexperts.com/en/asyncresponse';
//
//    $post_data    = 
//    'asyncRequest=getSingleItemData&asyncData=%7B%22collection%22%3A%22%22%2C%22product%22%3A%22' . $car_data['stock_number'] . '%22%7D';
//    $content_type = 'text/html;';
//    $in_cookies   = '';
//    $out_cookies  = '';
//    $resp         = HttpPost($url, $post_data, $in_cookies, $out_cookies);
//
//    if ($out_cookies) {
//        $in_cookies = $out_cookies;
//    }
//
//    if (preg_match($get_offer_regex, $resp, $matches) && numarifyPrice($matches['msrp']) > 0) {
//        $price = numarifyPrice($matches['msrp']);
//    }
//
//    return $price;
//}
