<?php

global $scrapper_configs;
$scrapper_configs["southeastmotorcycle"] = array(
    'entry_points' => array(
        'used' => 'https://www.southeastmotorcycle.com/--xAllInventory?condition=pre-owned&pg=1',
        'new' => 'https://www.southeastmotorcycle.com/--xAllInventory?condition=new&sz=50&pg=1',
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<ul class="v7list-results__list">',
    'details_end_tag' => '<div class="v7list-footer">',
    'details_spliter' => '<li class="v7list-results__item"',
    'data_capture_regx' => array(
        'url' => '/class="vehicle-heading__link" href="(?<url>[^"]+)".*title="(?<title>[^"]+)">\s*<span[^>]+>(?<year>[0-9]{4})<\/span>\s*<span[^>]+>(?<make>[^<]+)<\/span>\s*<span[^>]+>(?<model>[^<]+)/',
        'title' => '/class="vehicle-heading__link" href="(?<url>[^"]+)".*title="(?<title>[^"]+)">\s*<span[^>]+>(?<year>[0-9]{4})<\/span>\s*<span[^>]+>(?<make>[^<]+)<\/span>\s*<span[^>]+>(?<model>[^<]+)/',
        'year' => '/class="vehicle-heading__link" href="(?<url>[^"]+)".*title="(?<title>[^"]+)">\s*<span[^>]+>(?<year>[0-9]{4})<\/span>\s*<span[^>]+>(?<make>[^<]+)<\/span>\s*<span[^>]+>(?<model>[^<]+)/',
        'make' => '/class="vehicle-heading__link" href="(?<url>[^"]+)".*title="(?<title>[^"]+)">\s*<span[^>]+>(?<year>[0-9]{4})<\/span>\s*<span[^>]+>(?<make>[^<]+)<\/span>\s*<span[^>]+>(?<model>[^<]+)/',
        'model' => '/class="vehicle-heading__link" href="(?<url>[^"]+)".*title="(?<title>[^"]+)">\s*<span[^>]+>(?<year>[0-9]{4})<\/span>\s*<span[^>]+>(?<make>[^<]+)<\/span>\s*<span[^>]+>(?<model>[^<]+)/',
        'price' => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',
        'kilometres' => '/Odometer:[^>]+>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Color:[^>]+>(?<exterior_color>[^<]+)/',
        //  'fuel_type' => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
        //  'drivetrain' => '/Vehicle Type:[^>]+>(?<drivetrain>[^<]+)/',
        'engine' => '/Category:[^>]+>(?<engine>[^<]+)/',
        'body_style' => '/Category:[^>]+>(?<body_style>[^<]+)/',
        'vin' => '/Vin:\s*(?<vin>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Stock Number<\/label>\s*<span class="unitValue spnUnitValue">(?<stock_number>[^<]+)/',
        'make'         => '/data-unit-make="(?<make>[^"]+)/',
    ),
    'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
    'images_regx' => '/lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);

add_filter("filter_southeastmotorcycle_next_page", "filter_southeastmotorcycle_next_page", 10, 2);
add_filter("filter_southeastmotorcycle_field_images", "filter_southeastmotorcycle_field_images");

function filter_southeastmotorcycle_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);

    return $url;
}

function filter_southeastmotorcycle_field_images($im_urls) {
    $retval = array();

    foreach ($im_urls as $url) {


        $url = str_replace('https://www.southeastmotorcycle.com/', '', $url);
        $retval_im[] = str_replace('&#x2F;', '/', $url);
    }

    return $retval_im;
}

function filter_southeastmotorcycle_car_data($car_data) {


    $car_data['make'] = str_replace('&#8243;', 'foot', $car_data['make']);




    return $car_data;
}
