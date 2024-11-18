<?php
global $scrapper_configs;
$scrapper_configs["bannisterkiapentictoncom"] = array( 
	'entry_points' => array(
		//https://app.guidecx.com/app/projects/f9147be8-8795-4ff6-bf0a-8d17008e3fb6/notes
		//Overriding previous request. 
		'used' => 'https://www.bannisterkiapenticton.com/used/dealer/Bannister+Kia+Penticton',
		// 'used' => 'https://www.bannisterkiapenticton.com/used/',
		'new' =>  'https://www.bannisterkiapenticton.com/new/',
   ),
   'refine' => false,
   'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
   'srp_page_regex'      => '/com\/(?:new|used)/',
   'use-proxy' => true,
//    'proxy-area'    => 'CA',
   'details_start_tag' => '<div class="instock-inventory-content',
   'details_end_tag' => 'class="modal-footer">',
   'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12',
   'data_capture_regx' => array(
	   'url' => '/href="(?<url>[^"]+)"><span style/',
	   'vin'   => '/"vin":"(?<vin>[^"]+)/',
	   'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
	   'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
	   'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
	   'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
	   'stock_number' => '/STK\#\s*(?<stock_number>[^\s*])/',
	   'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
	   'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
	   'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
   ),
   'data_capture_regx_full' => array(
	   'kilometres' => '/Mileage[^>][^"]+"mileage[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
	   'body_style' => '/itemprop="bodyType">(?<body_style>[^<]+)/',
	   'trim' => '/trim:\s*\'(?<trim>[^\']+)/',
	   'price' => '/itemprop="price" content="(?<price>[^"]+)/',
	   'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^<]+)/',
	   'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
	   'vin'                 => '/\&vin=(?<vin>[^\&]+)/',
	   'fuel_type'           => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
	   'engine' => '/itemprop="vehicleEngine">(?<engine>[^<]+)/',
   ),
   'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
   'images_regx' => '/onerror="imgError\(this\);"\s*(?:data-src|src)="(?<img_url>[^"]+)"/'
);
 

add_filter('filter_bannisterkiapentictoncom_car_data', 'filter_bannisterkiapentictoncom_car_data');

function filter_bannisterkiapentictoncom_car_data($car_data)
{         
    if($car_data['all_images'] == "https://static.edealer.ca/V3_1/assets/images/new_vehicles_images_coming.png"){
		$car_data['all_images'] = "";
	}
    return $car_data;
}

