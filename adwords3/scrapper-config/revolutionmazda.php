<?php

global $scrapper_configs;

$scrapper_configs['revolutionmazda'] = array(
    'entry_points' => array(
            'new'  => 'https://www.revolutionmazda.ca/new-inventory/?condition=new',
            'used' => 'https://www.revolutionmazda.ca/pre-owned-inventory/?condition=used'
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next','.fancybox-next'],
        'picture_prevs'     => ['.owl-prev','.fancybox-prev'],
        
        'details_start_tag' => '<div id="listings-result">',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="listing-list-loop',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'title'         => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'year'          => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'make'          => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'model'         => '/<a href="(?<url>[^"]+)" class[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'price'         => '/class="price">[^>]+>[^>]+>(?<price>\$[0-9,\s]+)/',
            'stock_number'  => '/stock#[^>]+>(?<stock_number>[^<]+)/',

        ),
        'data_capture_regx_full' => array(     
        
            'kilometres'    => '/Odometer[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            //'stock_number'  => '/Vin<\/td>\s*<td[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Body Type<\/span>\s*<\/td>[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'transmission'  => '/Transmission<\/td>\s*[^>]+>(?<transmission>[^\<]+)/',
            'vin'           => '/Vin<\/td>\s*[^>]+>(?<vin>[^<]+)/',
        ) ,
        'next_page_regx'    => '/"next page-numbers" href="(?<next>[^"]+)/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" class="stm_fancybox"/',
       
    );
    add_filter("filter_revolutionmazda_field_price", "filter_revolutionmazda_field_price", 10, 3);

    function filter_revolutionmazda_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Final Price: $price");
        }
        
        
        $msrp_regex =  '/regular-price">\s*(?<price>\$[0-9,\s]+)/';
        $normal_regex  =  '/Sale Price<\/span>\s*<[^>]+>(?<price>\$[0-9,\s]+)/';
        $regular_regex =  '/Regular Price<\/span>\s*<[^>]+>(?<price>\$[0-9,\s]+)/';
        
        
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        if(preg_match($normal_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        
        if(preg_match($regular_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex price: {$matches['price']}");
        }
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
add_filter('filter_revolutionmazda_car_data', 'filter_revolutionmazda_car_data');
function filter_revolutionmazda_car_data($car_data) {

    $car_data['model'] = str_replace('&#8211;', " – ", $car_data['model']);

   $car_data['title'] = str_replace('&#8211;', " - ", $car_data['title']);

    return $car_data;
}
