<?php
global $scrapper_configs;
$scrapper_configs["watsonvillecdjrcom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.watsonvillecdjr.com/searchnew.aspx',
         'used' => 'https://www.watsonvillecdjr.com/searchused.aspx',
       
       
    ),
    'vdp_url_regex' => '/\/(?:new|used)-.*[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    //'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.mfp-img'],
    'picture_nexts' => ['.mfp-arrow-right'],
    'picture_prevs' => ['.mfp-arrow-left'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        //'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'model' => '/class="notranslate">(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+) (?<trim>[^<]+)/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/(?:Internet Price|FINAL PRICE:) <\/span>[^$]+(?<price>\$[0-9,]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/brand":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)/',
    'images_regx'       => '/<img class=\'img-responsive margin-auto\' src="(?<img_url>[^\?]+)\?width=[^"]+"\s*alt/',

);
add_filter("filter_watsonvillecdjrcom_field_price", "filter_watsonvillecdjrcom_field_price", 10, 3);

function watsonvillecdjrcomfilter_watsonvillecdjrcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP: <\/span>[^$]+(?<price>\$[0-9,]+)/';
    $internet_regex = '/Internet Price[^\$]+(?<price>\$[0-9,]+)/';
    $final_regex = '/FINAL PRICE: <\/span>[^$]+(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
 
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex final: {$matches['price']}");
    }

   
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter('filter_watsonvillecdjrcom_car_data', 'filter_watsonvillecdjrcom_car_data');

function filter_watsonvillecdjrcom_car_data($car_data) {

    $car_data['engine'] = str_replace('®', '', $car_data['engine']);
    $car_data['engine'] = str_replace('Â', '', $car_data['engine']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    return $car_data;
}

