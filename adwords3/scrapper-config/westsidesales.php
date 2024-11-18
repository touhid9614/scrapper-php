<?php
global $scrapper_configs;
 $scrapper_configs["westsidesales"] = array( 
	 'entry_points' => array(
           // 'new'   => 'http://www.driveluxury.ca/new/',
            'used'  => 'https://www.westsidesales.ca/used/'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'    => false,
        'picture_selectors' => ['.thumb li'],
        'picture_nexts'     => ['li.next'],
        'picture_prevs'     => ['li.prev'],
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer',
        'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
        'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make'   => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'  => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
       'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',    
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
       
    ),
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/data-src="(?<img_url>[^"]+)/'
    );
    
    // add_filter("filter_westsidesales_field_images", "filter_westsidesales_field_images");
    
    // function filter_westsidesales_field_images($im_urls)
    // {
    //     return array_filter($im_urls, function($im_url){
    //         return !endsWith($im_url, 'no_image-640x480.jpg');
    //     });
    // }

add_filter('filter_westsidesales_car_data', 'filter_westsidesales_car_data');

function filter_westsidesales_car_data($car_data) {

    if(!isset($car_data['vin'])){
        $car_data['vin']=md5($car_data['url']);
    }

    if(!isset($car_data['stock_number'])){
        $car_data['stock_number']=md5($car_data['url']);
    }
    return $car_data;
}