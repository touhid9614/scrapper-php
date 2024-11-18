<?php

global $scrapper_configs;
$scrapper_configs["perryfordsantabarbara"] = array(
    'entry_points' => array(
         'used' => 'https://www.perryfordsantabarbara.net/used-inventory/index.htm',
        'new' => 'https://www.perryfordsantabarbara.net/new-inventory/index.htm',
      
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => false,
    'refine'=>false,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/class="internetPrice final-price">.*class=\'value[^>]+>(?<price>[^<]+)/', ///dealer price///
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
       // 'stock_number' => '/Stock:\s*<[^>]+>(?<stock_number>[^<]+)/',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_perryfordsantabarbara_field_price", "filter_perryfordsantabarbara_field_price", 10, 3);
add_filter("filter_perryfordsantabarbara_field_images", "filter_perryfordsantabarbara_field_images");
  

function filter_perryfordsantabarbara_field_images($im_urls) {
   $retval = [];

    foreach ($im_urls as $img) {
        $retval[] = str_replace('|', '%7c', $img);
    }

    return $retval;
}

function filter_perryfordsantabarbara_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }
    $final_regex = '/Final Price[^>]+>[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';//final price
    $msrp_regex = '/MSRP[^>]+>[^>]+>[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';  ///msrp//
    $internet_regex = '/Dealer Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';  //internet price//
    $was_regex = '/class="retailValue final-price">.*class=\'value[^>]+>(?<price>[^<]+)/';  //was price//
    $conditional_final_regex='/Conditional Final Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';//conditional final price
    $best_regex='/Perry\'s Best Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';//perry best price



    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Final price: {$matches['price']}");
    }
   if (preg_match($was_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Was Price: {$matches['price']}");
    }
    if (preg_match($conditional_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }
      if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Internet Price: {$matches['price']}");
    }
     if (preg_match($best_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex perry best Price: {$matches['price']}");
    }
   

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
