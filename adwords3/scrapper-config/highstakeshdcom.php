<?php
global $scrapper_configs;
$scrapper_configs["highstakeshdcom"] = array( 
    'entry_points' => array(
        'used' => 'https://highstakeshd.com/preowned-inventory',
        'new' => 'https://highstakeshd.com/new-inventory',  
    ),
    'vdp_url_regex' => '/\/inventory\//',
    'refine' => false,
    'use-proxy' => true,
    'details_start_tag' => '<section class="mainContent-wrapper">',
    'details_end_tag'   => '<footer class="container-fullWidth">',
	'details_spliter'   => '<li class="inventoryList-bike">',
    'picture_selectors' => ['.r58-slider-slide'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'data_capture_regx' => array(
        'url'                 => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'year'                => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'make'                => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'model'               => '/<a href="(?<url>[^"]+)">(?:[A-Z\s]+|)(?<year>[0-9]+)\s*(?<make>[^\s*<]+)\s*(?<model>[^\s<]+)/',
        'kilometres'          => '/Mileage:<\/td>[^>]+>(?<kilometres>[0-9,]+)/',
        'stock_number'        => '/Stock number:<\/td>[^>]+>(?<stock_number>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(        
        'exterior_color'     => '/Color:<\/td>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'price' => '/price":"(?<price>[^"]+)"/',
    ) , 
    'next_page_regx'    => '/<a\s*href="(?<next>[^"]+)"\s*data-page[^"]+"[^"]+"\s*title="Next page"/',
    'images_regx'       => '/<img\s*src="(?<img_url>[^"]+)"\s*alt=""\s*/'
);
add_filter('filter_highstakeshdcom_car_data', 'filter_highstakeshdcom_car_data');

function filter_highstakeshdcom_car_data($car_data) {
  
    $car_data['vin']=md5($car_data['url']);
    $car_data['make'] = str_replace('®', '', $car_data['make']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);
    $car_data['make'] = str_replace('Â', '', $car_data['make']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    return $car_data;
}
