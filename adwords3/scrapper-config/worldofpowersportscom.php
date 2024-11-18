<?php
global $scrapper_configs;
 $scrapper_configs["worldofpowersportscom"] = array( 
	 'entry_points' => array(
            'used' => 'https://www.worldofpowersports.com/search/inventory/usage/Used',
            'new'  => 'https://www.worldofpowersports.com/search/inventory/usage/New',
            
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
     
        'use-proxy' => true,
        'refine' => false,
        'picture_selectors' => ['.slick-slide'],
        'picture_nexts'     => ['.slick-next','.mfp-arrow .mfp-arrow-right'],
        'picture_prevs'     => ['.slick-prev','.mfp-arrow .mfp-arrow-left'],
        
        'details_start_tag' => '<div class="search-results-list">',
        'details_end_tag'   => '<div class="ari-section footer',
        'details_spliter'   => '<div class="panel panel-default search-result">',
        'data_capture_regx' => array(
            'stock_number' => '/Stock #[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<stock_number>[^\<]+)/',
            'year' => '/data-model-year>(?<year>[0-9]{4})/',
            'price' => '/<span itemprop="price">\s*(?<price>\$[0-9,]+)/',
            'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
            'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',
            'kilometres' => '/Usage<\/strong>\s*.*\s*<td[^>]+>\s*(?<kilometres>[0-9,]+)/',
            'url' => '/<a href="(?<url>[^"]+)" .*>View Details/',
            'engine' => '/Engine Type[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<engine>[^<]+)/',
    ),
        'data_capture_regx_full' => array(
             'model' => '/<strong>Model[^>]+>[^>]+>\s*[^>]+>(?<model>[^<]+)/', 
             'vin' => '/VIN[^>]+>[^>]+>[^>]+>(?<vin>[^<]+)/',
             'make' => '/itemprop="brand manufacturer">(?<make>[^<]+)/',
             'description' => '/<div itemprop="description">\s*(?<description>[\s\S]*?(?=<\/div>))/',
        ),
        
        'next_page_regx'    => '/<li class="active">\s*<a href="[^"]+">[^\n]+\s*<\/li>\s*<li [^>]+>\s*<a href="(?<next>[^"]+)/',
        'images_regx' => '/<img data-highres="[^\?]+\?img=(?<img_url>[^\&]+)/',
    );

add_filter("filter_worldofpowersportscom_field_images", "filter_worldofpowersportscom_field_images");
add_filter("filter_worldofpowersportscom_field_description", "filter_worldofpowersportscom_field_description");

function filter_worldofpowersportscom_field_description($description) {
    return strip_tags($description);
}

function filter_worldofpowersportscom_field_images($im_urls) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['http://www.worldofpowersports.com/inventory/', '%3a', '%2f','http://www.worldofpowersports.com/new-models/','+'], ['', ':', '/','',' '], rawurldecode($im_url));
    }
    //   slecho(implode('|', $retval));
    return $retval;
}
add_filter('filter_worldofpowersportscom_car_data', 'filter_worldofpowersportscom_car_data');

function filter_worldofpowersportscom_car_data($car_data) {

    if(!isset($car_data['exterior_color'])){
        $car_data['exterior_color']="other";
    }
    if(!isset($car_data['vin'])){
        $car_data['vin']=md5($url);
    }
    if(!isset($car_data['body_style'])){
        $car_data['body_style']="other";
    }
    return $car_data;
}