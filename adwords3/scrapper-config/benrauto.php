<?php

global $scrapper_configs;
$scrapper_configs["benrauto"] = array(
    'entry_points' => array(
        'used' => 'https://benrauto.com/inventory/'
    ),
    'vdp_url_regex' => '/\/listings\/[0-9]{4}-/i',
    //'inpage_cont_match' => 'Your message has been sent',
    'refine'    => false,
    'use-proxy' => true,
    
    'picture_selectors' => ['.fancybox.fancybox_listing_link'],
    'picture_nexts' => ['.fancybox-nav.fancybox-next'],
    'picture_prevs' => ['.fancybox-nav.fancybox-prev'],
    
    'details_start_tag' => '<div class="content-wrap car_listings row">',
    'details_end_tag' => '<section class="copyright-wrap footer_area">',
    'details_spliter' => 'class="inventory clearfix margin-bottom-20',
    
    'data_capture_regx' => array(
        'url' => '/<a class="inventory.*"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<year>[0-9]{4})/',
        'year' => '/<a class="inventory.*"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<year>[0-9]{4})/',
        'make' => '/Make: <\/td><td class=\'spec\'>(?<make>[^<]+)/',
        'model' => '/Model: <\/td><td class=\'spec\'>(?<model>[^<]+)/',
        'price' => '/<b>Price\s*:[^>]+>[^>]+>\s*<div\s*class="figure">(?<price>[^<]+)/',
        'body_style' => '/Body Style: <\/td><td class=\'spec\'>(?<body_style>[^<]+)/',
        'transmission' => '/Transmission: <\/td><td class=\'spec\'>(?<transmission>[^<]+)/',
        'vin'         => '/VIN: <\/td>[^>]+>(?<vin>[^<]+)/',
        'drivetrain' =>  '/Drivetrain: <\/td>[^>]+>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number: <\/td><td>(?<stock_number>[^<]+)/',
        'kilometres' => '/Kilometres: <\/td><td>(?<kilometres>[^<]+)/',
        'trim' => '/Trim: <\/td><td>(?<trim>[^<]+)/',
        'engine' => '/Engine Type: <\/td><td>(?<engine>[^<]+)/',
        'transmission' => '/Transmission<\/strong>[\s\S]*?<ul class="list--no-style">\s*<li>(?<transmission>[^&<]+)/',
        'exterior_color' => '/Exterior Colour: <\/td><td>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colour: <\/td><td>(?<interior_color>[^<]+)/'
    ),
    'next_page_regx' => '/class="current_page">(?<next>[^<]+)/',
    'images_regx' => '/data-full-image="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);

add_filter("filter_benrauto_next_page", "filter_benrauto_next_page", 10, 2);

function filter_benrauto_next_page($next, $current_page) {
    slecho("Filtering curr url:" . $current_page);
    slecho("Filtering next url:" . $next);

    $newstr = substr_replace($next, "page/", 31, 0);
    $newstr++;
    return $newstr;
}

add_filter("filter_benrauto_field_price", "filter_benrauto_field_price", 10, 3);

function filter_benrauto_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/class="col-lg-3 col-md-3 col-sm-3 text-right xs-padding-none">\s*<h2>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/class=\'strikeout original_price\'>[^>]+><h2>(?<price>[^<]+)/';
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
add_filter("filter_benrauto_car_data", "filter_benrauto_car_data");
function filter_benrauto_car_data($car_data)
    {
      $car_data['vin']=substr( $car_data['vin'], 0, 17); 
        return $car_data;
    }
    