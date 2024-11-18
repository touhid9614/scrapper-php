<?php
global $scrapper_configs;
$scrapper_configs["redsautoelectricbiz"] = array( 
	"entry_points" => array(

        'new'   => 'https://www.redsautoelectric.biz/search/inventory/usage/New/availability/In%20Stock',
		'used' => 'https://www.redsautoelectric.biz/search/inventory/usage/Used/availability/In%20Stock'
    ),
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/',
    
    'use-proxy' => true,
      
    'refine'    => false,

    'picture_selectors' => ['.slick-slide img'],
    'picture_nexts' => ['.slick-next.slick-arrow'],
    'picture_prevs' => ['.slick-prev.slick-arrow'],


    'details_start_tag' => '<div class="search-results-list">',
    'details_end_tag' => '<div class="ari-section footer',
    'details_spliter' => '<div class="panel panel-default search-result">',
    'data_capture_regx' => array(
        'url' => '/class="results-heading hidden-xs hidden-sm">\s*<a href="(?<url>[^"]+)">/',
        'year' => '/<span data-model-year>(?<year>[^<]+)/',
        'make' => '/<span data-model-name>(?<make>[^<]+)/',
        'model' => '/<span data-model-brand>(?<model>[^<]+)/',
        'price' => '/class="lead text-right hidden-sm hidden-xs">\s*<span itemprop="price">\s*(?<price>[^\s*]+)/',
        'kilometres' => '/Usage<\/strong>\s*<\/td>\s*<[^>]+>\s*(?<kilometres>[^\s*]+)/',
		'stock_number' => '/Stock #<\/strong>\s*<\/td>\s*<[^>]+>\s*(?<stock_number>[^\s*]+)/',
		'exterior_color' => '/Color<\/strong>\s*<\/td>\s*<[^>]+>\s*(?<exterior_color>[^\<]+)/',
     
    ),
    'data_capture_regx_full' => array(
         'engine' => '/Engine Type:(?<engine>[^<]+)/',
    ),
    //there was no next page right now//
   // 'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/<div class="unit-image-container\s*">\s*<a href="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_redsautoelectricbiz_field_price", "filter_redsautoelectricbiz_field_price", 10, 3);


function filter_redsautoelectricbiz_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }


    $internet_regex = '/"internetPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $cond_final_regex = '/On Sale<\/small>\s*<span itemprop="price">(?<price>\$[0-9,]+)/';
   


    $matches = [];

   
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
