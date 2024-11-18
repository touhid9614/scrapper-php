<?php
global $scrapper_configs;
$scrapper_configs["crestwoodautoauctioncom"] = array( 
	  'entry_points' => array(
        'used' => 'https://crestwoodautoauction.com/newandusedcars?pagesize=500&page=1',
    ),
    'vdp_url_regex' => '/(?:New|Used)-[0-9]{4}\-[^\-]+\-[^\/]+/i',
    'use-proxy' => true,
    'refine'=>false,
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.img-thumbnail'],
    'picture_nexts' => ['.carousel-control-next-icon'],
    'picture_prevs' => ['.carousel-control-prev-icon'],
    'details_start_tag' => '<div class="i10r_mainContent',
    'details_end_tag' => '<footer class="footerWrapper">',
    'details_spliter' => '<div class="row no-gutters invMainCell',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/label>\s*(?<stock_number>[^\s*]+)/',
        'url' => '/class="i10r_vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)"/',
        'year' => '/class="i10r_vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'make' => '/class="i10r_vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'model' => '/class="i10r_vehicleTitle[^>]+>\s*<a.*href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*\s*(?<model>[^<]+)/',
        'price' => '/Price[^>]+>:[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/label>\s*(?<engine>[^\s*]+)/',
        'vin' => '/VIN:<\/label>\s*(?<vin>[^<]+)/',
        'transmission' => '/Trans:[^>]+>\s*(?<transmission>[^\s*]+)/',
        'exterior_color' => '/Color:<\/label>\s*(?<exterior_color>[^\s*]+)/',
        'interior_color' => '/Interior:<\/label>\s*(?<interior_color>[^\s*<]+)/',
        'kilometres'        => '/Mileage:<\/label>\s*(?<kilometeres>[^\s<]+)/',
        'drivetrain'        => '/Drive:<\/label>\s*(?<drivetrain>[^\s<]+)/',
        ),
    'data_capture_regx_full' => array(
          'kilometres'        => '/Mileage:<\/label>\s*(?<kilometeres>[^\s<]+)/',
    ),
    //'next_query_regx' => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl01\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/<img loading="auto" data-src=\'(?<img_url>[^\']+)\'/'
);
add_filter('filter_crestwoodautoauctioncom_field_url', 'filter_crestwoodautoauctioncom_field_url');
function filter_crestwoodautoauctioncom_field_url($url) {
    return trim($url);
}

add_filter("filter_crestwoodautoauctioncom_field_price", "filter_crestwoodautoauctioncom_field_price", 10, 3);
function filter_crestwoodautoauctioncom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/price-1\'>(?<price>[^<]+)/';
    

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
