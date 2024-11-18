<?php
global $scrapper_configs;
$scrapper_configs["wilsonboatscom"] = array( 
    'entry_points'           => array(
    	'used' => 'https://www.wilsonboats.com/search/inventory/availability/In%20Stock/usage/Used/sort/best-match',
    	'new'  => 'https://www.wilsonboats.com/search/inventory/availability/In%20Stock/usage/New/sort/best-match',
    ),
    'vdp_url_regex'          => '\/inventory\/',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts' => ['.mfp-arrow.mfp-arrow-right'],
    'picture_prevs' => ['.mfp-arrow.mfp-arrow-left'],
    'details_start_tag'      => '<div class="search-results-list">',
    'details_end_tag'        => '<div class="footerarea-bottom row margin0">',
    'details_spliter'        => '<div class="panel-body">',

    'data_capture_regx'      => array(
        'url'   => '/class="results-heading-sm">\s*<a\s*href="(?<url>[^"]+)">\s*/',
        'price' => '/itemprop="price">(?:\s*|)(?<price>[^<\s*]+)/',
    ),
    'data_capture_regx_full' => array(
        'year' => '/itemprop="productionDate">(?<year>[^<]+)/',
        'make' => '/itemprop="brand manufacturer">(?<make>[^<]+)/',
        'model'=> '/itemprop="model">(?<model>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'description' => '/<div itemprop="description">(?:\s*|)(?<description>[^<]+)/',
    ),
    'next_page_regx'         => '/<a href="(?<next>[^"]+)"\s*aria-label="Next">/',
    'images_regx'            => '/">\s*<a href="(?<img_url>[^"]+)"\s*class/',

);
add_filter('filter_wilsonboatscom_car_data', 'filter_wilsonboatscom_car_data');

function filter_wilsonboatscom_car_data($car_data) {
  
    $car_data['vin']=md5($car_data['url']);
    $car_data['exterior_color']="Other";
    $car_data['model'] = str_replace('\/', ' or ', $car_data['model']);

    return $car_data;
}

