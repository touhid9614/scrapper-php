<?php
global $scrapper_configs;
 $scrapper_configs["wagnermotorsportcom"] = array( 
	 'entry_points' => array(
	     'used'   => 'https://www.wagnermotorsport.com/search/inventory/usage/Used',
             'new'    => 'https://www.wagnermotorsport.com/search/inventory/usage/New',
           
        ),
        'use-proxy' => true,
        'refine'    => false,

        'vdp_url_regex' => '/\/(?:new-models|inventory)\/[0-9]{4}-/i',
         'picture_selectors' => ['.unit-image-container'],
         'picture_nexts' => ['.inventory-gallery-thumbs button.slick-next'],
         'picture_prevs' => ['.inventory-gallery-thumbs button.slick-prev'],
     
        'details_start_tag' => '<div class="search-results-list">',
        'details_end_tag'   => '<footer class="footer-b',
        'details_spliter'   => '<div class="panel panel-default search-result">',

        'data_capture_regx' => array(
        'stock_number'  => '/Stock #<\/strong>\s*.*\s*<td[^>]+>\s*(?<stock_number>[^<]+)/',
        'year' => '/data-model-year>(?<year>[0-9]{4})/',
        'make' => '/data-model-brand>(?<make>[^<]+)/',
        'model' => '/data-model-name>(?<model>[^<]+)/',
        'price' => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
        'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
        'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',     
        'url' => '/<a href="(?<url>[^"]+)" .*>View Details/'
    ),
    'data_capture_regx_full' => array(
        'vin'           => '/VIN[^\=]*[^\>]*\>(?<vin>[^\<]+)/',
        'fuel_type'     => '/Fuel System[^>]*>[^>]*>(?<fuel_type>[^<]+)/',
        'engine'        => '/Engine Type[^>]*>[^>]*>(?<engine>[^<]+)/',
        'drivetrain'    => '/Engine Type[^>]*>[^>]*>(?<drivetrain>[^<]+)/',
        'description'   => '/name=\"description\"[^"]+\"(?<description>[^\"]+)/',
        'kilometres'    => '/strong\>Usage[^=]*[^>]*\>(?<kilometres>[^\<]+)/',

    ),
    'next_page_regx' => '/<li class="active">\s*<a href="[^"]+">[^\n]+\s*<\/li>\s*<li [^>]+>\s*<a href="(?<next>[^"]+)/',
    'images_regx' => '/<img data-highres="[^\?]+\?img=(?<img_url>[^\&]+)/',
);
 
 
 
add_filter("filter_wagnermotorsportcom_field_images", "filter_wagnermotorsportcom_field_images");

function filter_wagnermotorsportcom_field_images($im_urls) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['http://www.wagnermotorsport.com/inventory/','%3a','%2f','+','http://www.wagnermotorsport.com/new-models/'],['',':','/',' ',''],$im_url);
    }
    //   slecho(implode('|', $retval));
    return $retval;
}
add_filter('filter_wagnermotorsportcom_car_data', 'filter_wagnermotorsportcom_car_data');

function filter_wagnermotorsportcom_car_data($car_data) {

    $car_data['engine'] = str_replace('&#176;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#174;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('â„¢', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#39;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#160;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#173;', '', $car_data['engine']);
    
    $car_data['make'] = str_replace('&#174;', '', $car_data['make']);
    $car_data['model'] = str_replace('â„¢', '', $car_data['model']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    $car_data['model'] = str_replace('©', '', $car_data['model']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);

    $car_data['fuel_type'] = str_replace('&#216;', '', $car_data['fuel_type']);

    $car_data['drivetrain'] = str_replace('&#176;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#174;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('â„¢', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#39;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#160;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#173;', '', $car_data['drivetrain']);

    return $car_data;
}

