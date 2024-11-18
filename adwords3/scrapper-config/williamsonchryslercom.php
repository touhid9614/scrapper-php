<?php
global $scrapper_configs;
$scrapper_configs["williamsonchryslercom"] = array( 
	'entry_points'           => array(
        'new'  => 'https://www.williamsonchrysler.com/new/',
        'used' => 'https://www.williamsonchrysler.com/used/',
        
    ),
    'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next'],
    'picture_prevs'          => ['.prev'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="',
    'details_spliter'        => '<!-- vehicle-list-cell -->',
    'must_not_contain_regex' => '/This vehicle is located offsite at one of our Bannis/',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span\s*style=\'/',
        'year'           => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]+)/',
        'make'           => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\' notranslate>(?<model>[^\s<]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'            => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'      => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
        'custom'         => '/Location Alert:\s*<\/strong>(?<custom>[^o]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx'            => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)/'
);

add_filter("filter_williamsonchryslercom_field_price", "filter_williamsonchryslercom_field_price", 10, 3);

function filter_williamsonchryslercom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Our Price:[^>]+>[^>]+>[^>]+>[^>]+>\s*[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
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
