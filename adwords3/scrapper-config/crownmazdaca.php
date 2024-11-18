<?php
global $scrapper_configs;
 $scrapper_configs["crownmazdaca"] = array( 
	 'entry_points' => array(
         'used' => 'https://www.crownmazda.ca/used-vehicles-in-winnipeg-mb/',
        'new' => 'https://www.crownmazda.ca/new-vehicles/',
       
    ),
    'use-proxy' => false,
    'refine' => false,
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.swiper-slide img'],
    'picture_nexts' => ['.swiper-button-next'],
    'picture_prevs' => ['.swiper-button-prev'],
       // 'details_start_tag' => '<div class="grid-view-results-wrapper">',
       // 'details_end_tag'   => '<div id="footer">',
        'details_spliter'   => '<div class="vehicle-wrap">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
      //  'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/Price\s*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/Kilometers:\s*(?<kilometres>[^\n<]+)/',
// 'lease'      => '/(?:Or Finance For:\s*<\/span>\s*<[^>]+>\s*|>FINANCE<\/span>\s*<\/div>\s*<[^>]+>\s*)(?<lease>\$[0-9,.]+)/',
        'biweekly'  => '/(?:class="price-label lease-payment-text visible-xs">LEASE<\/span>\s*|Or Finance For:\s*<\/span>)\s*[^>]+>\s*.*\s*(?<biweekly>\$[0-9,.]+)/',
        'msrp'   => '/MSRP\s*<\/span>\s*<[^>]+>\s*(?<msrp>\$\s*[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin' => '/VIN<\/span><[^>]+>(?<vin>[^<]+)/',
        'exterior_color' => '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^\n<]+)/',
        'engine' => '/Engine:\s*(?<engine>[^\n<]+)/',
        'transmission' => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^\n<]+)/',
        'model' => '/"model"\: "(?<model>[^"]+)"/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/swiper-lazy"\s*data-src="(?<img_url>[^"]+)"/'
);

add_filter('filter_crownmazdaca_post_data', 'filter_crownmazdaca_post_data', 10, 3);
add_filter('filter_crownmazdaca_data', 'filter_crownmazdaca_data');

$crownmazdaca_nonce = '';

function filter_crownmazdaca_post_data($post_data, $stock_type, $data) {
    global $crownmazdaca_nonce;
    if ($post_data == '') {
        $post_data = "page=1";
    }

    $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
    $nonce = '';
    $matches = [];

    if ($data && preg_match($nonce_regex, $data, $matches)) {
        $nonce = $matches['nonce'];
    }
    slecho("ajax_nonce : " . $nonce);
    if ($nonce && isset($nonce)) {
        $crownmazdaca_nonce = $nonce;
    }
    slecho("global ajax_nonce : " . $crownmazdaca_nonce);
    $post_id = 6;
    $referer = '/new-vehicles/';

    if ($stock_type == 'used') {
        $post_id = 7;
        $referer = '/used-vehicles-in-winnipeg-mb/';
    }

     return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$crownmazdaca_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_crownmazdaca_data($data) {
    if ($data) {
        if (isJSON($data)) {
            slecho("data is in jSon format");
            $obj = json_decode($data);

            $data = "{$obj->results}\n{$obj->pagination}";
        } else {
            slecho("data is not in jSon format");
        }
    }

    return $data;
}

add_filter("filter_crownmazdaca_field_price", "filter_crownmazdaca_field_price", 10, 3);

function filter_crownmazdaca_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $internet_regex = '/Your Price\s*<\/span>\s*<span class="price">\s*(?<price>\$[0-9,]+)/';
    $msrp_regex = '/(?:MSRP|Market Price)\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }
    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}


add_filter('filter_crownmazdaca_car_data', 'filter_crownmazdaca_car_data');

function filter_crownmazdaca_car_data($car_data) {

    if($car_data['stock_type'] == 'new') {
        $car_data['price'] = $car_data['msrp'];
    }
    if($car_data['model'] == '3') {
        $car_data['model'] = "Mazda" . $car_data['model'];
    }
    return $car_data;
}
add_filter("filter_crownmazdaca_field_images", "filter_crownmazdaca_field_images");
    
    function filter_crownmazdaca_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }