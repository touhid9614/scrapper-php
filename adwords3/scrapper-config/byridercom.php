<?php

global $scrapper_configs;

$scrapper_configs["byridercom"] = [
    'entry_points'           => [
        'used' => 'https://www.byrider.com/dealerships/buy-here-pay-here-albany-12205-ny107/inventory?PageSize=200&pageNumber=1',
    ],

    'vdp_url_regex'          => '/\/dealerships\//',
    'use-proxy'              => true,

    'picture_selectors'      => ['.scroll-content-item'],
    'picture_nexts'          => ['.bx-next'],
    'picture_prevs'          => ['.bx-prev'],

    'details_start_tag'      => '<div class="results">',
    'details_end_tag'        => 'id="colophon"',
    'details_spliter'        => 'class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">',

    'data_capture_regx'      => [
        'url' => '/<a class="text-orange text-underline font-montserrat-medium-italic"\s*href="(?<url>[^\"]+)/',
    ],

    'data_capture_regx_full' => [
        'title'          => '/<h1 class="font-montserrat[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/i',
        'year'           => '/<h1 class="font-montserrat[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/i',
        'make'           => '/<h1 class="font-montserrat[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/i',
        'model'          => '/<h1 class="font-montserrat[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/i',
        'price'          => '/<div class="price mainprice"[^>]+>(?<price>[^<]+)<\/div>/i',
        'transmission'   => '/Transmission[^>]+>\s*[^>]+>\s*(?<transmission>[^<]+)/i',
        'exterior_color' => '/Exterior Color[^>]+>\s*[^>]+>\s*(?<exterior_color>[^<]+)/i',
        'stock_number'   => '/Stock #[^>]+>\s*[^>]+>\s*(?<stock_number>[^<]+)/i',
        'vin'            => '/VIN #[^>]+>\s*[^>]+>\s*(?<vin>[^<]+)/i',
        'kilometres'     => '/vdp-price-value[^"]+">\s*(?<kilometres>[^\s*]+)\s*[^>]+>\s*[^>]+>\s*Miles/',
    ],

    'images_regx'            => '/<img class="tns-lazy-img" src="[^"]+"\s*data-lazy="(?<img_url>[^"]+)/i',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)/i',
];