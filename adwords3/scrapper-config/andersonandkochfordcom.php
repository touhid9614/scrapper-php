<?php
global $scrapper_configs;
$scrapper_configs["andersonandkochfordcom"] = array( 
	   'entry_points' => array(
        'new' => 'https://www.andersonandkochford.com/new-inventory/index.htm',
        'used' => 'https://www.andersonandkochford.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.pswp-thumbnail'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<div class="type-2 ddc-content"',
    'details_end_tag' => '<div  class="ddc-footer"',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/<a class="url" href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/<a class="url" href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:Internet Price|Final Price)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:<\/dt>[^>]+>(?<kilometres>[^\s]+)/',
        'stock_number' => '/Stock #:<\/dt>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt>[^>]+>(?<engine>[^<]+)/',
       // 'body_style' => '/Bodystyle:<\/dt>[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/Transmission:<\/dt>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/dt>[^>]+>(?<interior_color>[^<]+)/',
        'vin' => '/VIN:\s*<\/dt>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'trim' => '@"trim": "(?<trim>[^"]+)@'
    ),
    'next_page_regx' => '/a class="btn btn-link btn-xs" href="(?<next>[^"]+)" rel="next"/',
    'images_regx' => '/"id":[^"]+"[^"]+":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_andersonandkochfordcom_field_price", "filter_andersonandkochfordcom_field_price", 10, 3);
add_filter("filter_andersonandkochfordcom_field_images", "filter_andersonandkochfordcom_field_images");

function filter_andersonandkochfordcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
    $internet_regex = '/Conditional Final Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }



    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

function filter_andersonandkochfordcom_field_images($im_urls) {
    $retval = [];

    foreach ($im_urls as $img) {

        $retval[] = str_replace(["|", "%20", "?impolicy=resize&w=650", "?impolicy=resize&w=414", "?impolicy=resize&w=768", "?impolicy=resize&w=1024"], ["%7C", " ", " ", " ", " ", " "], $img);
    }

    return $retval;
}

