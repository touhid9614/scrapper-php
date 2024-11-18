<?php
global $scrapper_configs;
$scrapper_configs["kingstonvwca"] = array( 
	'entry_points' => array(
        'new' => 'https://www.kingstonvw.ca/en/new-inventory',
        'used' => 'https://www.kingstonvw.ca/en/used-inventory?',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used|certified)-inventory\//i',
    'ty_url_regex' => '/\/en\/thank-you/i',
    'use-proxy' => true,
     'refine'   => false,
    'picture_selectors' => ['.inventory-details__header-image'],
    'picture_nexts' => ['.widget-ninjabox__bxslider-controls--next'],
    'picture_prevs' => ['.widget-ninjabox__bxslider-controls--prev'],
    'details_start_tag' => '<div class="inventory-listing__vehicles',
    'details_end_tag' => '<p class="inventory-listing__disclaimer smallprint',
    'details_spliter' => '<article class="inventory-list-',
  'data_capture_regx' => array(

            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))/',
            'price'         => '/preview-price-current vehicle__rebate"[^>]+>\s*(?<price>\$[0-9,]+)/',
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Inventory #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
            'transmission'  => '/Transmission[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
            'vin'           => '/vin:\'(?<vin>[^\']+)/',

        ),
        'next_page_regx'    => '/<link rel="next" href="(?<next>[^"]+)"/',
        'images_regx'       => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
        'images_fallback_regx' => '/inventory-details__header-main-picture--center">\s*<img src="(?<img_url>[^"]+)"\s*alt="/'
    );


add_filter("filter_kingstonvwca_field_images", "filter_kingstonvwca_field_images",10,2);
function filter_kingstonvwca_field_images($im_urls, $car_data) {
   
if ($car_data['stock_type'] == 'new') {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'img-no-photo1522780214895.jpg');
    });
        
    } elseif ($car_data['stock_type'] == 'used') {
        if (count($im_urls) < 2) {
            return array();
        }
    }
    return $im_urls;
}