<?php

global $scrapper_configs;

$scrapper_configs["aacanadainccom"] = array(
    'entry_points'           => array(
        'used' => 'https://aacanadainc.com/vehicles/',
    ),

    'vdp_url_regex'          => '/\/inventory\/[0-9]{4}-/i',
    'srp_page_regex'          => '/\/vehicles/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'srp_page_regex'         => '/\/vehicles\//i',

    'picture_selectors'      => ['.fit'],
    'picture_nexts'          => ['.carousel__button--next'],
    'picture_prevs'          => ['.carousel__button--previous'],

    'details_start_tag'      => '<article class="rule--top">',
    'details_end_tag'        => '<footer id="footer"',
    'details_spliter'        => '<div id="item-',

    'data_capture_regx'      => array(
        'url'   => '/<a title=".*" href="(?<url>[^"]+)"/',
        'year'  => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'make'  => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'model' => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'title' => '/<a title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))"/',
        'price' => '/itemprop="price">\s*[^>]+>(?<price>\$[0-9,]+)/',
    ),

    'data_capture_regx_full' => array(
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        'kilometres'     => '/Odometer:[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'vin'            => '/VIN:\s*[^>]+>\s*(?<vin>[^<]+)/',
        'stock_number'   => '/Listing ID:\s*(?<stock_number>[^\s]+)/',
        'exterior_color' => '/Exterior Colour[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<exterior_color>[^\&]+)/',
        'engine'         => '/Engine Type[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<engine>[^\&]+)/',
        'transmission'   => '/Transmission[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<transmission>[^\&]+)/',
        'interior_color' => '/Interior Colour[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<interior_color>[^\&]+)/',
        'body_style'     => '/Body Style[^>]+>[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^\&]+)/',
    ),
    'next_page_regx'         => '/class="pagination__next"><a href="(?<next>[^"]+)"/',
    'images_regx'            => '/<img class="js-lazy"\s*src="(?<img_url>[^"]+)"/',
);