<?php

global $scrapper_configs;
$scrapper_configs["centennialnissanofcharlottetown"] = array(
    'entry_points' => array(
        'new' => 'https://www.centennialnissanofcharlottetown.com/en/new-inventory?filterid=q0-500',
        'used'  => 'https://www.centennialnissanofcharlottetown.com/en/used-inventory?filterid=q0-500',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used)-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts'     => ['.widget-ninjabox__bxslider-controls--next'],
    'picture_prevs'     => ['.widget-ninjabox__bxslider-controls--prev'],
    'details_start_tag' => 'class="off-canvas-wrapper-inner"',
    'details_end_tag' => 'class="footer-delta"',
    'details_spliter' => 'class="inventory-list-layout-wrapper',
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        // 'title' => '/class="divSpan carTitle">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'year' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'make' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'model' => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'price' => '/itemprop="price" content="[^"]+">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Inventory #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'vin'            => '/Inventory #:[^>]+>[^>]+>(?<vin>[^<]+)/',
        'body_style' => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/<link rel="next" href="(?<next>[^"]+)/',
    'images_regx' => '/data-picture-url="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/background-image:url\(\'(?<img_url>[^\']+)/'
);


add_filter("filter_centennialnissanofcharlottetown_field_images", "filter_centennialnissanofcharlottetown_field_images");
add_filter('filter_centennialnissanofcharlottetown_car_data', 'filter_centennialnissanofcharlottetown_car_data');


function filter_centennialnissanofcharlottetown_car_data($car_data) {
    //taking all cars except Corvette

    $car_data['exterior_color'] = str_replace('&agrave;', '', $car_data['exterior_color']);
    $car_data['transmission']   = str_replace('&agrave;', '', $car_data['transmission']);
   

    return $car_data;
}

function filter_centennialnissanofcharlottetown_field_images($im_urls)
{
    $md5_of_no_car_images = [
        'cdf21341e12a698e4e952a68ebdb1651',
        '4419c41236755c6bd3995aba274c0c0b',
        '65305e70a498539e0b19e8b6d2e10eca',
    ];

    $im_urls = array_filter($im_urls, function($image_url) use ($md5_of_no_car_images){
        $md5 = md5(file_get_contents($image_url));
        if(in_array($md5, $md5_of_no_car_images)){
            slecho("No car image: " . $image_url);
            return false;
        }
        return true;
    });

    return $im_urls;
}