<?php
global $scrapper_configs;
$scrapper_configs["sunlandfordinccom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.sunlandfordinc.com/searchnew.aspx',
        'used' => 'https://www.sunlandfordinc.com/searchused.aspx',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^\-]+-[0-9]{4}-/i',
     'refine'=>false,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'title' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'make' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'model' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/Red Tag Price:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
       // 'msrp' => '/MSRP: <\/span><span class="pull-right">(?<msrp>[^<]+)/',
        'vin' => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
        'drivetrain' => '/Drive Type: <\/strong>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);

add_filter("filter_sunlandfordinccom_field_price", "filter_sunlandfordinccom_field_price", 10, 3);

function filter_sunlandfordinccom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Final Price:[^>]+>[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
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
