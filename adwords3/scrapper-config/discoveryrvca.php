<?php
global $scrapper_configs;
$scrapper_configs["discoveryrvca"] = array( 
	'entry_points' => array(
		   'new' => 'https://www.discoveryrv.ca/new-recreational-vehicles-cold-lake',
		   'used' => 'https://www.discoveryrv.ca/used-recreational-vehicles-cold-lake',
		   
	   ),
	   'vdp_url_regex' => '/\/[0-9]{4}-/i',
	   'refine' => false,
	   'use-proxy' => true,
	   'picture_selectors' => ['.clickable'],
	   'picture_nexts' => ['.next-button.navButton'],
	   'picture_prevs' => ['.prev-button.navButton'],
	   'details_start_tag' => 'class="DealerSite">',
	   'details_end_tag' => 'class="dsFooterTop">',
	   'details_spliter' => 'class="eziVehicle eziVehicleList"',
	   'data_capture_regx' => array(
		   'url' => '/onclick=([^\']+)\'(?<url>[^\']+)\'">\s*<div\s*class="row/',
		   'year' => '/class="eziVehicleName">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
		   'make' => '/class="eziVehicleName">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
		   'model' => '/class="eziVehicleName">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
		   'price' => '/Our Price<\/span>\s*[^>]+>(?<price>[^<]+)/',
		   'stock_number' => '/Stock\s*#:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
		   'body_style' => 'RV',
		   'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
		   'msrp' => '/<span class=\'eziMSRP\'>MSRP\s*(?<msrp>[^<]+)/',
	   ),
	   'data_capture_regx_full' => array(
		   'vin' => '/VIN:[^>]+>[^>]+>(?<vin>[^<]+)/'
	   ),
	   'next_page_regx' => '/rel="next" href="(?<next>[^"]+)/',
	   'images_regx' => '/data-imagesrc="(?<img_url>[^"]+)/'
   );
   

// add_filter("filter_discoveryrvca_field_price", "filter_discoveryrvca_field_price", 10, 3);

// function filter_discoveryrvca_field_price($price, $car_data, $spltd_data) {
//     $prices = [];

//     slecho('');

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//         slecho(" Price: $price");
//     }

//     $sale_regex = '/Our Price<\/span>\s*[^>]+>(?<price>[^<]+)/';
//     $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//     $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//     $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
//     $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
//     $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


//     $matches = [];

//     if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Sale: {$matches['price']}");
//     }
//     if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex wholesale: {$matches['price']}");
//     }
//     if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex internet: {$matches['price']}");
//     }

//     if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Conditional Price: {$matches['price']}");
//     }

//     if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Retail Price: {$matches['price']}");
//     }
//     if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Asking Price: {$matches['price']}");
//     }

//     if (count($prices) > 0) {
//         $price = butifyPrice(min($prices));
//     }

//     slecho("Sale Price: {$price}" . '<br>');
//     return $price;
// }
