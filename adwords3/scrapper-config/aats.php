<?php

global $scrapper_configs;
$scrapper_configs["aats"] = array(
    'entry_points' => array(
        'vehicles' => 'https://www.aats.ca/vehicles/',
        'trailer' => 'https://aats.ca/trailer/',
    ),
    'vdp_url_regex' => '/\/(?:trailers|vehicles)\/[0-9]{4}/i',
    'use-proxy' => true,
    'picture_selectors' => ['#gallery-2 .gallery-item'],
    'picture_nexts' => ['#cboxMiddleRight'],
    'picture_prevs' => ['#cboxMiddleLeft'],
    'details_start_tag' => '<main id="main" class="site-main" role="main">',
    'details_end_tag' => '</main>',
    'details_spliter' => '<!-- CLASS: disclaimer -->',
    'data_capture_regx' => array(
        'url' => '/<h2>\s*<a href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'year' => '/<h2>\s*<a href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make' => '/<h2>\s*<a href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model' => '/<h2>\s*<a href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price' => '/trailer-price">\s*(?:[^>]+>[^>]+>\s*\|\s*|)(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/class="nextpostslink" rel="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/class=\'gallery-icon landscape\'>\s*<a href=\'(?<img_url>[^\']+)/'
);
add_filter('filter_aats_field_url', 'filter_aats_field_url');
add_filter('filter_aats_car_data', 'filter_aats_car_data');

function filter_aats_field_url($url) {
    slecho("URL:" . $url);
    return $url;
}

function filter_aats_car_data($car_data) {
    //taking all cars except Corvette

    $car_data['make'] = str_replace('&#8243;', ' foot ', $car_data['make']);
    $car_data['make'] = str_replace('&#8242;', ' inches ', $car_data['make']);
    $car_data['model'] = str_replace('&#8243;', ' foot ', $car_data['model']);
    $car_data['model'] = str_replace('&#8242;', ' inches ', $car_data['model']);
    $car_data['make'] = str_replace('&#8211;', '', $car_data['make']);
    $car_data['model'] = str_replace('&#8211;', '', $car_data['model']);
    $car_data['make'] = str_replace('&#215;', ' X ', $car_data['make']);
    $car_data['model'] = str_replace('&#215;', ' X ', $car_data['model']);
    $car_data['make'] = str_replace('&#8217;', " ' ", $car_data['make']);
    $car_data['model'] = str_replace('&#8217;', " ' ", $car_data['model']);



    return $car_data;
}
