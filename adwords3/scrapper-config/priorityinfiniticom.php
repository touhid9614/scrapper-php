<?php
global $scrapper_configs;
$scrapper_configs["priorityinfiniticom"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.priorityinfiniti.com/searchnew.aspx',
        'used' => 'https://www.priorityinfiniti.com/searchused.aspx',
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
        'url' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s<]*))/',
        'title' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s<]*))/',
        'year' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s<]*))/',
        'make' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s<]*))/',
        'model' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s<]*))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/(?:Internet|Final) Price.\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
       // 'msrp' => '/MSRP: <\/span><span class="pull-right">(?<msrp>[^<]+)/',
        'vin' => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
        'drivetrain' => '/Drive Type: <\/strong>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/brand":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);

add_filter("filter_priorityinfiniticom_field_images", "filter_priorityinfiniticom_field_images");
add_filter('filter_priorityinfiniticom_field_price', 'filter_priorityinfiniticom_field_price', 10, 3);

function filter_priorityinfiniticom_field_images($im_urls) {
   
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'photo_unavailable_320.gif');
    });
}

function filter_priorityinfiniticom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/(?:Retail Price|MSRP):\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
