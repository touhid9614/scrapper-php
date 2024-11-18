<?php
global $scrapper_configs;
$scrapper_configs["bannisterfordedsoncom"] = array( 
	 'entry_points'           => array(
        'used' => 'https://www.bannisterfordedson.com/used/',
        'new'  => 'https://www.bannisterfordedson.com/new/',
    ),
    'srp_page_regex'          => '/\/(?:new|used)/i',
    'vdp_url_regex'          => '/\/vehicle\//i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next.next-small'],
    'picture_prevs'          => ['.left.left-small'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class',
    'details_spliter'        => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span style/',
        'year'           => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\s*<]+)/',
        'model'          => '/itemprop=\'model\'[^>]+>[^>]+>(?<model>[^\<]+)/',
        'price'          => '/<span style="[^"]+"\s*itemprop="price" content="[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',
        'description'   => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/<img onerror="imgError\(this\);" (?:data-src|src)="(?<img_url>[^"]+)"/',
);

add_filter("filter_bannisterfordedsoncom_field_images", "filter_bannisterfordedsoncom_field_images");
add_filter("filter_bannisterfordedsoncom_field_price", "filter_bannisterfordedsoncom_field_price", 10, 3);

function filter_bannisterfordedsoncom_field_images($im_urls)
{
    if (count($im_urls) < 2) {
        return [];

    }
    return array_filter($im_urls, function ($im_url) {

        return !endsWith($im_url, 'new_vehicles_images_coming.png');
    });
}

function filter_bannisterfordedsoncom_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("bannisterfordedsoncom Price: $price");
    }

    $bannisterfordedsoncom_regex = '/Northstar Price:[\S\s]*?itemprop="price" content="(?<price>[0-9,]+)/';
    $price_regex            = '/<span itemprop="price"\s*content="[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($bannisterfordedsoncom_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex bannisterfordedsoncom price: {$matches['price']}");
    }

    if (preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
