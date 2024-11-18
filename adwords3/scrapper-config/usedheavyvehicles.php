<?php

global $scrapper_configs;

$scrapper_configs['usedheavyvehicles'] = array(
    'entry_points'           => array(
        'used' => array(
            'https://usedheavyvehicles.com/browse/vehicles',
        ),
    ),
    'vdp_url_regex'          => '/\/listing\//i',
    //  'ty_url_regex'      => '/message\/success\//i',

    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['#photo_thumbs .row .col-md-4', '.pbThumbs li'],
    'picture_nexts'          => ['#pbNextBtn'],
    'picture_prevs'          => ['#pbPrevBtn'],
    'details_start_tag'      => '<div class="listings">',
    'details_end_tag'        => '<div class="layout">',
    'details_spliter'        => '<div class="row listing">',
    'must_contain_regex'     => '<a class="thumbnail[^"]+" href="[^"]+"><img src="[^"]+"[^>]+><\/a>',
    'data_capture_regx'      => array(
        'year'         => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^ ]+) (?<model>[a-zA-Z-0-9 a-zA-Z-0-9]+)/',
        'make'         => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^ ]+) (?<model>[a-zA-Z-0-9 a-zA-Z-0-9]+)/',
        'model'        => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^ ]+) (?<model>[a-zA-Z-0-9 a-zA-Z-0-9]+)/',
        'price'        => '/<span class="price">\$(?<price>[^<]+)/',
        'url'          => '/href="(?<url>[^"]+)">More Info/',
        'stock_number' => '/Stock #:(?<stock_number>[0-9 A-Z a-z]+)/',
        'trim'         => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^ ]+) (?<model>[a-zA-Z-0-9 a-zA-Z-0-9]+) (?<trim>[^,]+)/',
        'kilometres'   => '/<small class="odometer">\s*(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/Interior:<\/th><td>\s*(?<interior_color>[^<]+)/',
        'transmission'   => '/Transmission:<\/th><td>(?<transmission>[^<]+)/',
        'engine'         => '/Engine:<\/th><td>(?<engine>[^<]+)/',
    ),
    'next_page_regx'         => '/<a href="[^"]+">[^<]+<\/a>\s*<\/li>\s*<li>\s*<a href="(?<next>[^"]+)"/',
    'images_regx'            => '/<a href="(?<img_url>[^"]+)" rel="gallery" class="photo thumbnail">/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);
//add_filter("filter_usedheavyvehicles_next_page", "filter_usedheavyvehicles_next_page", 10, 2);
//
//function filter_usedheavyvehicles_next_page($next, $current_page) {
//    slecho("Filtering Next url : " . $next);
//    return $next;
//    //  return urlCombine("https://www.usedheavyvehicles.com", $next);
//}
