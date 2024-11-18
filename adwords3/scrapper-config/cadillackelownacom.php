<?php
global $scrapper_configs;
$scrapper_configs["cadillackelownacom"] = array( 
	 'entry_points' => array(
            'used'  => 'https://www.cadillackelowna.com/used',    
            'new'  => 'https://www.cadillackelowna.com/new',
        ),
        'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next'],
    'picture_prevs'          => ['.prev'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="',
    'details_spliter'        => '<!-- vehicle-list-cell -->',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span\s*style=\'/',
        'year'           => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'make'           => '/itemprop=\'manufacturer\' notranslate>[^>]+>(?<make>[^\s*]+)/',
        'model' => '/model[^=]+=[^\']\'(?<model>[^\']+)/',
        'kilometres'     => '/Mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'            => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'      => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
        'custom'         => '/Location Alert:\s*<\/strong>(?<custom>[^o]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    // 'images_regx'            => '/imgError\(this\)\;"\s*data-src="(?<img_url>[^"]+)/',
    'images_regx'            => '/data-src="(?<img_url>[^"]+)"\s*alt/',
);
   add_filter("filter_cadillackelownacom_field_images", "filter_cadillackelownacom_field_images");
    
    function filter_cadillackelownacom_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'new_vehicles_images_coming.png');
        });
    }

    //https://app.asana.com/0/1159366839112632/1193248515790139
add_filter('filter_cadillackelownacom_car_data', 'filter_cadillackelownacom_car_data');

function filter_cadillackelownacom_car_data($car_data) {

    if($car_data['year'] == "2022" && $car_data['stock_type']='new')
    {
        return NULL;
    }
    return $car_data;
}