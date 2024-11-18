<?php
global $scrapper_configs;
$scrapper_configs["shoplangenhealthandsafetyca"] = array( 
	"entry_points" => array(
            'new' => 'https://shop.langenhealthandsafety.ca/products',
        ),
    'vdp_url_regex' => '/\/products\/[a-zA-Z,0-9]+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.elementor-image'],
    'picture_nexts' => [''],
    'picture_prevs' => [''],
    'details_start_tag' => '<div class="products">',
    'details_end_tag' => '<ul class="pagination pull-right">',
    'details_spliter' => '<div class="col-sm-4 col-xs-6">',
    'data_capture_regx' => array(
        'url' => '/<a class="product-title" href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make' => '/<a class="product-title" href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/<a class="product-title" href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price' => '/<div class="product-price">C(?<price>\$[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    
    'next_page_regx' => '/<\/li>\s*<li class="arrow">\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<div class="image-cell"><img src="(?<img_url>https:[^_]+_original)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);


add_filter('filter_shoplangenhealthandsafetyca_field_url', 'filter_shoplangenhealthandsafetyca_field_url');
add_filter('filter_shoplangenhealthandsafetyca_car_data', 'filter_shoplangenhealthandsafetyca_car_data');

function filter_shoplangenhealthandsafetyca_field_url($url) {
    slecho("URL:" . $url);
    return $url;
}

function filter_shoplangenhealthandsafetyca_car_data($car_data) {
    
    $car_data['year'] = "2020";
    $car_data['model'] = str_replace('&#8217;', " ' ", $car_data['model']);
    $car_data['make'] = str_replace('&#8217;', " ' ", $car_data['make']);
    $car_data['make'] = str_replace('&amp;', " & ", $car_data['make']);


    return $car_data;
}
