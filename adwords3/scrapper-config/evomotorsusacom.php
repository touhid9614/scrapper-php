<?php
global $scrapper_configs;
$scrapper_configs["evomotorsusacom"] = array( 
	 "entry_points" => array(
       
        'used' => 'https://www.evomotorsusa.com/buy-cars-in-seffner-fl?limit=500'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
      'use-proxy' => false,
       'picture_selectors' => ['.thumb-item.thumb-image div img'],
        'picture_nexts'     => ['.glyphicon-menu-right'],
        'picture_prevs'     => ['.glyphicon-menu-left'],
    
    'details_start_tag' => '<div class="inventory-listing js-listing">',
    'details_end_tag' => '<footer class="no-print" role="contentinfo">',
    'details_spliter' => '<div class="inventory-item inventory-item_view-btns-hover clearfix js-vehicle-item"',
    'data_capture_regx' => array(
        'url' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'title' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'year' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'make' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'model' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        //'trim' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock:\s*(?<stock_number>[^<]+)/',
        'price' => '/<div class="price_name">\s*W Preferred Payment Discount\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^<]+)/',
        'engine' => '/Engine:\s*(?<engine>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
       
       'exterior_color' => '/Exterior Color[^>]+>[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
       'vin' => '/VIN[^>]+>[^>]+>[^>]+>(?<vin>[^<]+)/',
       
    ),
    //'next_page_regx'    => '/pagination-next" href="(?<next>[^"]+)"/',
    'images_regx'  => '/<picture><source (?:data-srcset|srcset)="(?<img_url>[^\s]+)\s*600w/',
    'images_fallback_regx' => '/meta property="og:image" content="(?<img_url>[^"]+)"/'
);
// add_filter("filter_toyotaarlington_field_price", "filter_toyotaarlington_field_price", 10, 3);

// function filter_toyotaarlington_field_price($price, $car_data, $spltd_data) {
//     $prices = [];

//     slecho('');

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//         slecho(" Price: $price");
//     }

//     $msrp_regex = '/Buy Today For:\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/';
//     $wholesale_regex = '/Price before Savings:\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
//     $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//     $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//     $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
//     $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


//     $matches = [];

//     if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex MSRP: {$matches['price']}");
//     }
//     if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex wholesale: {$matches['price']}");
//     }
//     if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex internet: {$matches['price']}");
//     }

//     if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Conditional Price: {$matches['price']}");
//     }

//     if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Retail Price: {$matches['price']}");
//     }
//     if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Asking Price: {$matches['price']}");
//     }

//     if (count($prices) > 0) {
//         $price = butifyPrice(min($prices));
//     }

//     slecho("Sale Price: {$price}" . '<br>');
//     return $price;
// }
