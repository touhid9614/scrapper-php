<?php
global $scrapper_configs;
$scrapper_configs["platinumautosportcom"] = array( 
	"entry_points" => array(
        
        'used' => 'https://www.platinumautosport.com/used/',
        
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
     'srp_page_regex'      => '/com\/(?:new|used|certified)\//i',
    'refine' => false,
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12">',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer[^>]+><var>(?<make>[^\s*]+)/',
        'model' => '/itemprop=\'model[^>]+><var>(?<model>[^<]+)/',
        'price' => '/<span itemprop="price"[^\>]+>(?<price>[^\<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'vin' => '/"vin":"(?<vin>[^"]+)/',
        'fuel_type'      => '/"fuelType":"(?<fuel_type>[^"]+)/',
        'drivetrain' => '/"driveTrain":"(?<drivetrain>[^"]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
         'stock_number' => '/<td class="col-used-value" itemprop="sku">\s*(?<stock_number>[^<]+)/',
        'fuel_type'      => '/itemprop="fuelType">\s*(?<fuel_type>[^\s*]+)/',
        'drivetrain' => '/itemprop="driveWheelConfiguration">\s*(?<drivetrain>[^\s*]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',
       
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/'
);


 
 add_filter('filter_platinumautosportcom_car_data', 'filter_platinumautosportcom_car_data');

function filter_platinumautosportcom_car_data($car_data) {
    slecho("ar price::" . $car_data['price'] );
    
     if(!isset($car_data['price'])){
        return null;
    }
    if($car_data['price']=='Please Call'){
        return null;
    }
    return $car_data;
}
    add_filter("filter_platinumautosportcom_field_stock_number", "filter_platinumautosportcom_field_stock_number");
    function filter_platinumautosportcom_field_stock_number($stock_number)
    {
        if ( $stock_number == 'N/A') { $stock_number = ''; } 
        return $stock_number;
    }