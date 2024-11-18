<?php
global $scrapper_configs;
$scrapper_configs["rocklandchryslerjeepdodgenet"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.rocklandchryslerjeepdodge.net/used-inventory/index.htm',
       'new' => 'https://www.rocklandchryslerjeepdodge.net/new-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'refine'=>false,
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'picture_selectors' => ['.pswp-thumbnail.ws-vehicle-media-thumbnail'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/Final Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'trim' => '@"trim": "(?<trim>[^"]+)@',
    ),
    'next_page_regx' => '/rel="next"\s*href="(?<next>[^"]+)"/',
  'images_regx' => '/"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_rocklandchryslerjeepdodgenet_field_price", "filter_rocklandchryslerjeepdodgenet_field_price", 10, 3);
add_filter("filter_rocklandchryslerjeepdodgenet_field_images", "filter_rocklandchryslerjeepdodgenet_field_images");

function filter_rocklandchryslerjeepdodgenet_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Internet Price[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
   


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

function filter_rocklandchryslerjeepdodgenet_field_images($im_urls) {
    $retval = [];

    foreach ($im_urls as $img) {
        $retval[] = str_replace('|', '%7c', $img);
    }

    return $retval;
}
