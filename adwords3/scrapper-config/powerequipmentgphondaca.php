<?php
global $scrapper_configs;
$scrapper_configs["powerequipmentgphondaca"] = array( 
	'entry_points'        => array(
        'new' => array(
            'https://powerequipment.gphonda.ca/collections/generators',
            'https://powerequipment.gphonda.ca/collections/work-industrial',
            'https://powerequipment.gphonda.ca/collections/home-back-up',
            'https://powerequipment.gphonda.ca/collections/snowblowers',
            'https://powerequipment.gphonda.ca/collections/dual-stage',
            'https://powerequipment.gphonda.ca/collections/hybrid',
            'https://powerequipment.gphonda.ca/collections/push-mower',
            'https://powerequipment.gphonda.ca/collections/self-propelled',
            'https://powerequipment.gphonda.ca/collections/professional',
            'https://powerequipment.gphonda.ca/collections/trimmer',
            'https://powerequipment.gphonda.ca/collections/brush-cutter',
            'https://powerequipment.gphonda.ca/collections/versattach',
            'https://powerequipment.gphonda.ca/collections/gardening',
            'https://powerequipment.gphonda.ca/collections/ground-breaking',
            //'https://powerequipment.gphonda.ca/collections/transfer-pumps',
            //'https://powerequipment.gphonda.ca/collections/high-pressure',
            //'https://powerequipment.gphonda.ca/collections/construction',
            
            )
    ),
    'vdp_url_regex'       => '/\/products\//',
    'use-proxy'           => true,
    'refine' => false,
    'details_start_tag' => '<ul id="product-grid" data-id="',
    'details_end_tag'   => '<div id="shopify-section-footer"',
    'details_spliter'   => '<li class="grid__item">',
    'data_capture_regx' => array(
        'url'   => '/class="card__heading h5">\s*<a href="(?<url>[^"]+)/',
        'title' => '/card__heading h5">\s*[^>]+>\s*(?<title>[^<]+)/',
        'make'  => '/card__heading h5">\s*[^>]+>\s*(?<make>[^\s]+)/',
        'model' => '/card__heading h5">\s*[^>]+>\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price' => '/class="price-item price-item--regular">\s*(?<price>\$[0-9,.]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    
    
    'images_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'

);

//add_filter('filter_powerequipmentgphondaca_car_data', 'filter_powerequipmentgphondaca_car_data');
//function filter_powerequipmentgphondaca_car_data($car_data) {
//
//
//    $car_data['year'] = "2023";
//    
//    return $car_data;
//}
