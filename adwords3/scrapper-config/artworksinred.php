<?php
global $scrapper_configs;
 $scrapper_configs["artworksinred"] = array( 
	"entry_points" => array(
            'new' => 'https://eisenbarth.ca/shop/?v=707f3a40153b',
        ),
    'vdp_url_regex' => '/\/product\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.elementor-image'],
    'picture_nexts' => [''],
    'picture_prevs' => [''],
    'details_start_tag' => '<div class="edge-grid-row">',
    'details_end_tag' => '<footer class="edge-page-footer">',
    'details_spliter' => '<li class="product type-product',
    'data_capture_regx' => array(
        'url' => '/<h5 class="edge-product-list-title"><a href="(?<url>[^"]+)">/',
        'make' => '/<h5 class="edge-product-list-title"><a href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/<h5 class="edge-product-list-title"><a href="(?<url>[^"]+)">(?<make>[^\s]+)\s*(?<model>[^<]+)/',

    ),
    'data_capture_regx_full' => array(
    	  'price'        => '/"price":"(?<price>[^"]+)/',
          'stock_number' => '/"sku":(?<stock_number>[^,]+)/',

    ),
    
    'next_page_regx' => '/<a class="next page-numbers" href="(?<next>[^"]+)"/',
    'images_regx'    => '/data-large_image="(?<img_url>[^"]+)"/',
   
);


add_filter('filter_artworksinred_field_url', 'filter_artworksinred_field_url');
add_filter('filter_artworksinred_car_data', 'filter_artworksinred_car_data');

function filter_artworksinred_field_url($url) {
    slecho("URL:" . $url);
    return $url;
}

function filter_artworksinred_car_data($car_data) {
    
   // $car_data['year'] = "2020";
    $car_data['model'] = str_replace('&#8211;', " - ", $car_data['model']);
    $car_data['model'] = str_replace('&#8217;', " ' ", $car_data['model']);
   // $car_data['make'] = str_replace('&amp;', " & ", $car_data['make']);


    return $car_data;
}
