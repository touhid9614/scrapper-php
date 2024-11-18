<?php

global $scrapper_configs;

$scrapper_configs['seegertoyota'] = array(
    'entry_points' => array(
        'new' => 'https://www.seegertoyota.net/searchnew.aspx?pn=1000&Location=St+Robert%2c+MO',
        'used' => 'https://www.seegertoyota.net/searchused.aspx?pn=1000&?ocation=St+Robert%2c+MO'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-St/',
    'ty_url_regex' => '/\/thankyou.aspx/i',
    'use-proxy' => true,
    'picture_selectors' => ['div.carousel__item.js-carousel__item'],
    'picture_nexts' => ['.carousel__control--next.js-carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev.js-carousel__control--prev'],
    'details_start_tag' => '<script type="application/ld+json">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpVehicle',
//        'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
    'data_capture_regx' => array(
        'stock_number' => '/<li class="stockDisplay"><strong>Stock\s#:\s*<\/strong>\s*(?<stock_number>[^<]+)/',
        'url' => '/vehicleTitle margin-x">\s*<a\s*.*href="(?<url>[^"]+)">[^>]+>(?<title>(?<year>[^\s]+)\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s*[^<]+)/',
    //    'title' => '/vehicleTitle margin-x">\s*<a\s*.*href="(?<url>[^"]+)">[^>]+>(?<title>(?<year>[^\s]+)\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s*[^<]+)/',
        'year' => '/vehicleTitle margin-x">\s*<a\s*.*href="(?<url>[^"]+)">[^>]+>(?<title>(?<year>[^\s]+)\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s*[^<]+)/',
        'make' => '/vehicleTitle margin-x">\s*<a\s*.*href="(?<url>[^"]+)">[^>]+>(?<title>(?<year>[^\s]+)\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s*[^<]+)/',
        'model' => '/vehicleTitle margin-x">\s*<a\s*.*href="(?<url>[^"]+)">[^>]+>(?<title>(?<year>[^\s]+)\s(?<make>[^\s]+)\s(?<model>[^\s]+)\s*[^<]+)/',
        'price' => '/primaryPrice">(?<price>\$[0-9,]+)/',
        'exterior_color' => '/<li\s*class="extColor"><strong>Ext.\s*Color:\s*<\/strong>(?<exterior_color>[^<]+)/',
        //   'exterior_color'=> '/Ext.\s*Color:\s*</strong>(?<exterior_color>[^<]+)/',
        'engine' => '/<li\s*class="engineDisplay"><strong>Engine:\s*<\/strong>(?<engine>[^<]+)/',
        'transmission' => '/<li\s*class="transmissionDisplay"><strong>Transmission:\s*<\/strong>(?<transmission>[^<]+)/',
        'kilometres' => '/<li\s*class="mileageDisplay"><strong>Mileage:\s*<\/strong>(?<kilometres>[^<]+)/',
        'interior_color' => '/<li\s*class="intColor"><strong>Int.\s*Color:\s*<\/strong>(?<interior_color>[^<]+)/',
        'exterior_color' => '/<li\s*class="extColor"><strong>Ext.\s*Color:\s*<\/strong>(?<exterior_color>[^<]+)/',
        'body_style' => '/<li\s*class="bodyStyleDisplay"><strong>Body\s*Style:\s*<\/strong>(?<body_style>[^<]+)/',
        'drive_train' => '/<li\s*class="driveTrainDisplay"><strong>Drive\s*Type:\s*<\/strong>(?<drive_train>[^<]+)/',
        'vin' => '/<li\s*class="vinDisplay"><strong>VIN\s*#:\s*<.strong><span>(?<vin>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/<li>Stock\s*#:\s*(?<stock_number>[^<]+)/',
        'make' => '/(?:New|Used)\s*[0-9]{4}[^"]*" \s*href="[^\&]+\&make=(?<make>[^\&]+)\&model=(?<model>[^\&]+)\&trim=(?<trim>[^"]+)/',
        'model' => '/(?:New|Used)\s*[0-9]{4}[^"]*" \s*href="[^\&]+\&make=(?<make>[^\&]+)\&model=(?<model>[^\&]+)\&trim=(?<trim>[^"]+)/',
        'trim' => '/(?:New|Used)\s*[0-9]{4}[^"]*" \s*href="[^\&]+\&make=(?<make>[^\&]+)\&model=(?<model>[^\&]+)\&trim=(?<trim>[^"]+)/',
    ),
    'next_page_regx' => '/<a\s*href="(?<next>[^"]*)"\s*aria-label="Next">/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);

add_filter("filter_seegertoyota_field_price", "filter_seegertoyota_field_price", 10, 3);

function filter_seegertoyota_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Advertised Price<a id[^\$]+(?<price>[^<]+)/';
    $wholesale_regex = '/Discounted Advertised Price:\s*<\/span>[^\$]+(?<price>[^<]+)/';
    $internet_regex = '/Seeger Price:\s*<\/span>[^\$]+(?<price>[^<]+)/';
    $cond_final_regex = '/Market Value Price:\s*<\/span>[^\$]+(?<price>[^<]+)/';
    


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


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

add_filter("filter_seegertoyota_field_images", "filter_seegertoyota_field_images");
 function filter_seegertoyota_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"photo_unavailable_640.jpg");
            }
        );
    }