<?php
global $scrapper_configs;
$scrapper_configs["destinationcyclescom"] = array( 
	"entry_points" => array(
		'used'  => 'http://www.destinationcycles.com/used-motorcycles-calgary',
	),
	'vdp_url_regex'     => '/\/motorcycles\//i',
        'use-proxy' => true,
        'refine'            => false,
    
        'picture_selectors' => ['.img-polaroid'],
        'picture_nexts'     => ['.mfp-arrow.mfp-arrow-right '],
        'picture_prevs'     => ['.mfp-arrow.mfp-arrow-left'],
        
        'details_start_tag' => ' <ul class="djc_layout_buttons djc_clearfix btn-group">',
        'details_end_tag'   => '<div class="djc_pagination_set">',
        'details_spliter'   => '<div class="djc_item_in djc_clearfix">',
        'data_capture_regx' => array(
            'url'              => '/<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            // 'title'            => '/<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'year'             => '/<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'make'             => '/<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'model'            => '/<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'price'            => '/<span class="djc_price_normal djc_price_new">[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/',
        ),
        'data_capture_regx_full' => array(
            'kilometres'       => '/Mileage<\/span>\s*<\/td>\s*<td\s*class="djc_value">\s*(?<kilometres>[^<]+)/',
            'exterior_color'   => '/Colour<\/span>\s*<\/td>\s*<td\s*class="djc_value">\s*(?<exterior_color>[^<]+)/',
            'transmission'     => '/Transmission<\/span>\s*<\/td>\s*<td\s*class="djc_value">\s*(?<transmission>[^<])/',
            'description'      => '/<div class="djc_fulltext">\s*(?<description>[\s\S]*?(?=<\/div>))/',
        ) ,
        
        'next_page_regx'    => '/<a title="Next" href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a data-type="image"\s*(?:data-target=|class=)"[^"]+".*title="[^"]+"\s*href="(?<img_url>[^"]+)"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter('filter_destinationcyclescom_car_data', 'filter_destinationcyclescom_car_data');
add_filter("filter_destinationcyclescom_field_description", "filter_destinationcyclescom_field_description");

    function filter_destinationcyclescom_field_description($description)
    {
       return strip_tags($description);
    }



function filter_destinationcyclescom_car_data($car_data) {
    
    slecho ("mdgg stock_number" . $car_data['stock_number']);
    if($car_data['stock_number'])
    {
    	$car_data['vin']=substr($car_data['stock_number'],0,17);
    	slecho ("generated vin:" . $car_data['vin']);
    } 
    $car_data['fuel_type']='gasoline';
    return $car_data;
}

add_filter("filter_destinationcyclescom_field_price", "filter_destinationcyclescom_field_price", 10, 3);

function filter_destinationcyclescom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/<span class="djc_price_new">[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
