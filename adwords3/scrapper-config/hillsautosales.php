<?php

global $scrapper_configs;

$scrapper_configs["hillsautosales"] = [
    "entry_points"           => [
        'used' => 'https://www.hillsautosales.us/cars-for-sale?PageSize=1000',
    ],
    'vdp_url_regex'          => '/\/details\/(?:new|used|certified)-[0-9]{4}-/i',

    'use-proxy'              => true,
    
    'picture_selectors'      => ['.carousel-inner div img'],
    'picture_nexts'          => ['.fa.fa-chevron-right'],
    'picture_prevs'          => ['.fa.fa-chevron-left'],

    'details_start_tag'      => '<ul class="list-unstyled list-inline vehicle-section">',
    'details_end_tag'        => '<section class="footer',
    'details_spliter'        => '<li class="vehicle-snapshot">',

    'data_capture_regx'      => [
        'url'          => '/<a class="font-primary" href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\&]+)/',
        'year'         => '/<a class="font-primary" href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\&]+)/',
        'make'         => '/<a class="font-primary" href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\&]+)/',
        'model'        => '/<a class="font-primary" href="(?<url>[^"]+)"\s*[^>]+>\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\&]+)/',
        'price'        => '/vehicle-snapshot__main-info font-primary">\s(?<price>\$[0-9,]+)\s</',
        'engine'       => '/Engine\s*<\/div><div class="vehicle-snapshot__info-text">\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission\s*<\/div><div class="vehicle-snapshot__info-text">\s*(?<transmission>[^<]+)/',
        'kilometres'   => '/Mileage\s*<\/div>  <div class="vehicle-snapshot__main-info font-primary">\s*(?<kilometres>[^<]+)/',
    ],
    'data_capture_regx_full' => [
        'stock_number'   => '/Stock\s*#[^>]+>[^>]+>(?<stock_number>[^<\n]+)/',
        'exterior_color' => '/Exterior Color<\/div><div class="vdp-info-block__info-item-description">(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/div><div class="vdp-info-block__info-item-description">(?<interior_color>[^<]+)/',
    ],
    'images_regx'            => '/data-lazy="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta content="(?<img_url>[^"]+)" property="og:image"/',
];