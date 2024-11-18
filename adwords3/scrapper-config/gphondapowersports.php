<?php
global $scrapper_configs;
$scrapper_configs["gphondapowersports"] = array(
    'entry_points'           => array(
        // 'new'  => ['https://www.gphonda.ca/new/dealer/Grande+Prairie+Honda+PowerSports'],
        // 'used' => ['https://www.gphonda.ca/used/dealer/Grande+Prairie+Honda+PowerSports'],
    ),

    // 'url_resolve'            => [
    //     // 'grandeprairiehonda' => '/-Langley-/i',
    //     // 'gphondapowersports' => '/-Kamloops-/i',
    // ],

    'vdp_url_regex'          => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'refine'                 => false,
    'use-proxy'              => true,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next.next-small'],
    'picture_prevs'          => ['.left.left-small'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="footer wp"',
    'details_spliter'        => '<div class="col-xs-12 col-sm-12 col-md-12">',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span style/',
        'price'          => '/(?:<span itemprop="price"[^>]+>|<span id="final-price">)(?<price>[^<]+)/',
        'year'           => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\s*]+)/',
        'stock_number'   => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style'     => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'custom' => '/headinggrey">\s*(?<custom>[^<]+)/',
        'vin'    => '/id="vin-(?<vin>[^\']+)/',
        // 'price' => '/(?:<span itemprop="price"[^>]+>|<span id="final-price">)(?<price>[^<]+)/',
        'model'  => '/\&model=(?<model>[^\&]+)/',
        'trim'   => '/\&trim=(?<trim>[^\&]+)/',
    ),
    'next_page_regx'         => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/',
);
add_filter('filter_gphondapowersports_car_data', 'filter_gphondapowersports_car_data');

function filter_gphondapowersports_car_data($car_data)
{
    if ($car_data['custom'] == "") {
        $car_data['custom'] = "PowerSports";
    }

    slecho("ar price::" . $car_data['price']);

    if (!isset($car_data['price'])) {
        return null;
    }

    if ($car_data['price'] == 'Please Call') {
        return null;
    }

    if ($car_data['stock_number'] == 'P21-202') {
        return null;
    }
    $car_data['make']  = ucwords(strtolower($car_data['make']));
    $car_data['model'] = ucwords(strtolower($car_data['model']));
    return $car_data;
}
add_filter("filter_gphondapowersports_field_images", "filter_gphondapowersports_field_images");

function filter_gphondapowersports_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) {
        return !endsWith($im_url, 'new_vehicles_images_coming.png');
    });
}
