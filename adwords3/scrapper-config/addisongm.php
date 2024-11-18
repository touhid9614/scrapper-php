<?php

global $scrapper_configs;
$scrapper_configs["addisongm"] = array(
    'entry_points'           => array(
        'used' => 'https://www.addisononerinmills.com/used/dealer/Addison+on+Erin+Mills+Chevrolet+Buick+GMC',
        // 'used' => 'https://www.addisononerinmills.com/used/',
        // 'new' => 'https://www.addisononerinmills.com/new/',
    ),
    'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next.next-small'],
    'picture_prevs'          => ['.left.left-small'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="opt-4 wp"',
    'details_spliter'        => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span style/',
        'year'           => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\' notranslate>(?<model>[^\<]+)/',
        'trim'           => '/"trim":"(?<trim>[^"]+)"/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/',
        'vin'            => '/itemprop="sku">(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'fuel_type'      => '/Fuel type:<\/td>[^>]+>\s*(?<fuel_type>[^<]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/<li class="active"><a href="">.*<\/a><\/li>\s*<li><a href="(?<next>[^"]+)">/',
    'images_regx'            => '/onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/',
);

add_filter("filter_addisongm_field_images", "filter_addisongm_field_images");
add_filter("filter_addisongm_field_stock_number", "filter_addisongm_field_stock_number");

function filter_addisongm_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) {
        return !endsWith($im_url, 'no_image-640x480.jpg');
    });
}

function filter_addisongm_field_stock_number($stock_number)
{
    if ($stock_number == 'N/A') {
        $stock_number = '';
    }

    return $stock_number;
}
