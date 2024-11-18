<?php

global $scrapper_configs;

$scrapper_configs['clarkcullengroup'] = array(
    'entry_points' => array(
        // 'new'     => 'http://www.clarkcullengroup.ca/idx/'
        'new' => [
            'http://www.clarkcullengroup.ca/listings.php',
            'http://www.clarkcullengroup.ca/residential.php',
            'http://www.clarkcullengroup.ca/commercial.php',
            'http://www.clarkcullengroup.ca/farm-search.php',
            'http://www.clarkcullengroup.ca/acreage-search.php',
            'http://www.clarkcullengroup.ca/land-search.php'
        ]
    ),
    'vdp_url_regex' => '/\/listing\//i',
    'refine' => false,
    //'use-proxy' => true,
    'proxy-area' => 'FL',
    'picture_selectors' => ['#slideshow_1 .slide', '.pswp__item'],
    'picture_nexts' => ['.pswp__button pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button pswp__button--arrow--left'],
    'details_start_tag' => '<div class="listings columns">',
    'details_end_tag' => '<div class="pagination">',
    'details_spliter' => '<div class="mls-compliance">',
    'data_capture_regx' => array(
        'url' => '/-mar-bottom-sm">\s*<a href="(?<url>[^"]+)"[^>]+>(?<title>(?<model>[^\,]+)\,(?<make>[^<]+))/',
        'title' => '/-mar-bottom-sm">\s*<a href="(?<url>[^"]+)"[^>]+>(?<title>(?<model>[^\,]+)\,(?<make>[^<]+))/',
        'make' => '/-mar-bottom-sm">\s*<a href="(?<url>[^"]+)"[^>]+>(?<title>(?<model>[^\,]+)\,(?<make>[^<]+))/',
        'model' => '/-mar-bottom-sm">\s*<a href="(?<url>[^"]+)"[^>]+>(?<title>(?<model>[^\,]+)\,(?<make>[^<]+))/',
        'price' => '/\$(?<price>[0-9,]+)\s*-(?:(?<body_style>[^\,]+\,[^\,]+)\,)?\s*(?<kilometres>[0-9,]+) Sf/',
        'kilometres' => '/\$(?<price>[0-9,]+)\s*-(?:(?<body_style>[^\,]+\,[^\,]+)\,)?\s*(?<kilometres>[0-9,]+) Sf/',
        'stock_number' => '/MLS\&reg;\s*#\s*(?<stock_number>[^\s]+)/',
        'body_style' => '/\$(?<price>[0-9,]+)\s*-(?:(?<body_style>[^\,]+\,[^\,]+)\,)?\s*(?<kilometres>[0-9,]+)\s*Sf/',
    ),
    'data_capture_regx_full' => array(
        'year' => '/Year Built<\/strong><span[^>]+>(?<year>[0-9]{4})/',
        'price' => '/Price<\/strong><span[^>]+>(?<price>\$[0-9,]+)/',
        'exterior_color' => '/>Exterior<\/strong><span[^>]+>(?<exterior_color>[^<]+)/',
        'engine' => '/>Type<\/strong><span[^>]+>(?<engine>[^<]+)/', //Property Type
    ),
    'next_page_regx' => '/class="next" rel="next" href="(?<next>[^"]+)/',
    'images_regx' => '/style="background-image: url\(\'(?<img_url>[^\']+)/',
);

add_filter('filter_clarkcullengroup_car_data', 'filter_clarkcullengroup_car_data');

function filter_clarkcullengroup_car_data($car_data) {

    $car_data['make'] = str_replace('#', '', $car_data['make']);
    $car_data['model'] = str_replace('#', '', $car_data['model']);
    $car_data['title'] = str_replace('#', '', $car_data['title']);
    $car_data['make'] = str_replace('-', '', $car_data['make']);
    $car_data['model'] = str_replace('-', '', $car_data['model']);
    $car_data['title'] = str_replace('-', '', $car_data['title']);

    $car_data['model'] = str_replace("'", "", $car_data['model']);
    $car_data['title'] = str_replace("'", "", $car_data['title']);

    $car_data['model'] = str_replace(',', '', $car_data['model']);
    $car_data['make'] = str_replace(',', '', $car_data['make']);
    $car_data['title'] = str_replace(',', '', $car_data['title']);

    $car_data['model'] = str_replace('.', '', $car_data['model']);
    $car_data['model'] = str_replace('"', '', $car_data['model']);
    $car_data['model'] = str_replace('*', '', $car_data['model']);
    $car_data['title'] = str_replace('.', '', $car_data['title']);
    $car_data['title'] = str_replace('*', '', $car_data['title']);


    $car_data['make'] = str_replace("'", "", $car_data['make']);
    $car_data['make'] = str_replace("&", "", $car_data['make']);
    $car_data['model'] = str_replace("&", "", $car_data['model']);
    $car_data['make'] = str_replace('.', '', $car_data['make']);

    $car_data['body_style'] = str_replace(',', '', $car_data['body_style']);
    $car_data['exterior_color'] = str_replace(',', '', $car_data['exterior_color']);



    return $car_data;
}
