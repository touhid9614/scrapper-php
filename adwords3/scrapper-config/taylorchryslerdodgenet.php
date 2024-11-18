<?php
global $scrapper_configs;
$scrapper_configs["taylorchryslerdodgenet"] = array( 
	  "entry_points" => array(
        'new' => 'https://www.taylorchryslerdodge.net/searchnew.aspx?Dealership=Taylor%20Chrysler%20Dodge%20Jeep%20Ram',
        'used' => 'https://www.taylorchryslerdodge.net/searchused.aspx?Dealership=Taylor%20Chrysler%20Dodge%20Jeep%20Ram',
    ),
    'refine'=>false,
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev'], 
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'title' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'year' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'make' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'model' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        ///'trim' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine\s*:[^>]+>(?<engine>[^\s]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^\s<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^\s<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^\s<]+)/',
        'price' => '/Taylor E-Price:\s*<\/span><[^>]+>(?<price>[^<]+)/',
        'vin' => '/<strong>VIN\s*#:\s*<\/strong>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*class="stat-arrow-next"\s*data-loc="available\s*inventory">\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
);


add_filter('filter_taylorchryslerdodgenet_field_price', 'filter_taylorchryslerdodgenet_field_price', 10, 3);

function filter_taylorchryslerdodgenet_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Internet Price: $price");
    }

    $msrp_regex = '/MSRP:\s*<\/span><[^>]+>(?<price>[^<]+)/';
    $retail_regex = '/Retail Price:\s*<\/span><[^>]+>(?<price>[^<]+)/';
    $final_regex = '/Final Price:\s*<\/span><[^>]+>(?<price>[^<]+)/';
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail: {$matches['price']}");
    }
 if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Final: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_taylorchryslerdodgenet_field_images", "filter_taylorchryslerdodgenet_field_images");
    
    function filter_taylorchryslerdodgenet_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'comingsoon.jpg');
        });
    }