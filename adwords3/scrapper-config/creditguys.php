<?php
global $scrapper_configs;

$scrapper_configs['creditguys'] = array(
    'entry_points'           => array(
        'used' => 'http://www.creditguys.ca/used',
        'atv'  => 'https://www.creditguys.ca/all/segment/atv/',
        'rv'   => 'https://www.creditguys.ca/all/segment/rv'
    ),
    'vdp_url_regex'          => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next.next-small'],
    'picture_prevs'          => ['.left.left-small'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="footer wp"',
    'details_spliter'        => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx'      => array(
        'vin'            => '/VIN:<\/td>[^>]+>(?<vin>[^<]+)/',
        'url'            => '/href="(?<url>[^"]+)"><span/',
        'year'           => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
        'make'           => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
        'model'          => '/itemprop=\'model\'>(?<model>[^\<]+)/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[0-9,]+ km)/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        // 'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
    ),
    'next_page_regx'         => '/class="active"><a\s*href="">[0-9]<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/<img onerror="imgError\(this\);"\s*data-src="(?<img_url>[^"]+)/',
);

/*add_filter('filter_creditguys_car_data', 'filter_creditguys_car_data');

function filter_creditguys_car_data($car_data) {
	$car_data['url'] = forcehttps($car_data['url']);

	return $car_data;
}*/