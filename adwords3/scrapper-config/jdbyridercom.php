<?php

global $scrapper_configs;

$scrapper_configs['jdbyridercom'] = array(
    'entry_points' => array(
        'used' => 'https://www.jdbyrider.com/dealerships/buy-here-pay-here-albany-12205-ny107/inventory?PageSize=200&pageNumber=1',
    ),
    'vdp_url_regex' => '/\/dealerships\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.tns-lazy-img'],
    'picture_nexts' => ['.slick-next--nav'],
    'picture_prevs' => ['.slick-prev--nav'],
    'details_start_tag' => '<div class="results">',
    'details_end_tag' => '<footer id="colophon"',
    'details_spliter' => 'class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">',
    'data_capture_regx' => array(
        'url' => '/class="d-block text-dark-blue" href="(?<url>[^"]+)/',
        'year' => '/class="h5 font-weight-semibold text-truncate mb-0">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/class="h5 font-weight-semibold text-truncate mb-0">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/class="h5 font-weight-semibold text-truncate mb-0">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/Transmission\s*<\/th>\s*<[^>]+>\s*(?<transmission>[^<]+)/',
        // 'price' => '//',
        'stock_number' => '/Stock #\s*<\/th>\s*<[^>]+>\s*(?<stock_number>[^<]+)/',
        'engine' => '/Engine\s*<\/th>\s*<[^>]+>\s*(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Color\s*<\/th>\s*<[^>]+>\s*(?<exterior_color>[^<]+)/',
        'kilometres' => '/Mileage<\/h3>\s*<[^>]+>\s*(?<kilometeres>[^<]+)/',
        'vin' => '/VIN #\s*<\/th>\s*<[^>]+>\s*(?<vin>[^<]+)/',
    ),
    //  'next_page_regx' => '//',
    'images_regx' => '/<img class="tns-lazy-img" src="[^"]+" data-lazy="(?<img_url>[^"]+)"\s*alt/',
);

