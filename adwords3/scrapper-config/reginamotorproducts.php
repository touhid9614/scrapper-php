<?php

global $scrapper_configs;
$scrapper_configs["reginamotorproducts"] = array(
    'entry_points' => array(
        'new' => 'https://www.rmpchevrolet.com/VehicleSearchResults?search=new',
        'used' => 'https://www.rmpchevrolet.com/VehicleSearchResults?search=used',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
       // 'stock_type' => '/itemprop="itemCondition">(?<stock_type>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'stock_number' => '/Stock Number<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
       // 'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
);

add_filter("filter_reginamotorproducts_next_page", "filter_reginamotorproducts_next_page", 10, 2);
add_filter("filter_reginamotorproducts_field_stock_type", "filter_reginamotorproducts_field_stock_type");
add_filter("filter_reginamotorproducts_field_images", "filter_reginamotorproducts_field_images");

function filter_reginamotorproducts_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

function filter_reginamotorproducts_field_stock_type($stock_type) {
    return strtolower($stock_type);
}

function filter_reginamotorproducts_field_images($im_urls) {
    if (count($im_urls) < 4) {
        return array();
    }
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'photo_unavailable_320.gif');
    });
}
 add_filter('filter_reginamotorproducts_car_data', 'filter_reginamotorproducts_car_data');

function filter_reginamotorproducts_car_data($car_data) {
  
    //clients dont want to see vehicles which have price above $100000
    //https://app.asana.com/0/0/1189624257881084/f
    
    
    if(numarifyPrice($car_data['price'])>100000){
            return null;
        }
   
    return $car_data;
}
