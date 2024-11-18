<?php

global $scrapper_configs;

$scrapper_configs['porscheaustin'] = array(
    'entry_points' => array(
        'new' => 'https://www.porscheaustin.com/new-vehicles/',
        'used' => 'https://www.porscheaustin.com/used-vehicles/',
    //'certified' => 'https://central-austin.porschedealer.com/inventory/certified/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thank-you/i',
    'picture_selectors' => ['.swiper-slide img'],
    'picture_nexts' => ['.swiper-button-next'],
    'picture_prevs' => ['.swiper-button-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => '<div class="footer-content">',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:(?<stock_number>[^<]+)/',
        'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'price' => '/<span class="price">\s*(?<price>[$0-9,]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+))/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
        'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'body_style' => '/data-body="(?<body_style>[^"]+)"\n/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model" content="(?<model>[^"]+)/',
        'price' => '/Porsche Austin Price:\s*<\/span>\s*<span class="ctabox-price">\s*(?<price>\$[0-9,]+)/',
    ),
    'next_page_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<div class="swiper-slide">\s*<img class="" src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

//     add_filter("filter_porscheaustin_field_price", "filter_porscheaustin_field_price", 10, 3);
//    
//    function filter_porscheaustin_field_price($price,$car_data, $spltd_data)
//    {
//        $prices = [];
//        
//        slecho('');
//        
//        if($price && numarifyPrice($price) > 0) {
//            $prices[] = numarifyPrice($price);
//            slecho("Regex Selling Price: $price");
//        }
//        
//        $internet_regex  =  '/Internet Price:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
//        $retail_regex    =  '/Retail Price:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
//        $msrp_regex      =  '/MSRP:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
//        
//        $matches = [];
//        
//        if(preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex Sale Price: {$matches['price']}");
//        }
//        
//        if(preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex Price: {$matches['price']}");
//        }
//        
//        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//            $prices[] = numarifyPrice($matches['price']);
//            slecho("Regex MSRP: {$matches['price']}");
//        }
//        
//        if(count($prices) > 0) {
//            $price = butifyPrice(min($prices));
//        }
//        
//        slecho("Sale Price: {$price}".'<br>');
//        return $price;
//    }
//
