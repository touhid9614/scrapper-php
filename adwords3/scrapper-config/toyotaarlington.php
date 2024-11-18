<?php
global $scrapper_configs;
 $scrapper_configs["toyotaarlington"] = array( 
	 "entry_points" => array(
        'new' => 'https://www.toyotaarlington.com/new-toyota-palatine-il?limit=500',
        'used' => 'https://www.toyotaarlington.com/used-vehicles-palatine-il?limit=500'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
       'srp_page_regex' => '/(?:new|used)-(?:toyota|vehicles)/i',
      'use-proxy' => false,
       'refine' => false,
    'picture_selectors' => ['.thumb-item.thumb-image div img'],
        'picture_nexts'     => ['.glyphicon-menu-right'],
        'picture_prevs'     => ['.glyphicon-menu-left'],
    
    'details_start_tag' => '<div class="inventory-listing js-listing">',
    'details_end_tag' => '<footer class="no-print" role="contentinfo">',
    'details_spliter' => '<div class="inventory-item  clearfix js-vehicle-item"',
    'data_capture_regx' => array(
        'url' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'title' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'year' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'make' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        'model' => '/<h6 class="inventory-item_vehicle-title[^>]+>\s*<a href="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/',
        //'trim' => '/<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock:\s*(?<stock_number>[^<]+)/',
        //https://smedia-hq.slack.com/archives/C01QFVB637V/p1668096017557369
        //by reading this slack conversation you can know what price should pull for this.
        'price' => '/(?:MSRP|Our Price)\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^<]+)/',
        'engine' => '/Engine:\s*(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Color:\s*(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color:\s*(?<interior_color>[^<\[]+)/',
    ),
    'data_capture_regx_full' => array(
       
       
    ),
    //'next_page_regx'    => '/pagination-next" href="(?<next>[^"]+)"/',
    'images_regx'  => '/<picture><source (?:data-srcset|srcset)="(?<img_url>[^\s]+)\s*840w/',
    'images_fallback_regx' => '/meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_toyotaarlington_field_price", "filter_toyotaarlington_field_price", 10, 3);

function filter_toyotaarlington_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>\s*(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/Price before Savings:\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
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
