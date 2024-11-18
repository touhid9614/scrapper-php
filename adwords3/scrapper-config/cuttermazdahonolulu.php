<?php

global $scrapper_configs;
$scrapper_configs["cuttermazdahonolulu"] = array(
    'entry_points' => array(
        'new' => 'https://www.cuttermazdahonolulu.com/new-mazda-for-sale',
        'used' => 'https://www.cuttermazdahonolulu.com/used-cars-for-sale'
    ),
    'vdp_url_regex' => '/\/vehicle-details\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide',],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
    'details_start_tag' => '<div class="srp-vehicle-container"',
    'details_end_tag' => '<div class="footer">',
    'details_spliter' => '<div class="row srp-vehicle" itemprop="offers"',
    'data_capture_regx' => array(
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'stock_number' => '/Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'price' => '/itemprop=\'price\' content=\'(?<price>[0-9]+)/',
        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'make' => '/make":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/trim":\s*"(?<trim>[^"]+)/',
        'body_style' => '/Body Style:<\/span>\s*(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/<a[^>]+>[0-9]<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
);

add_filter("filter_cuttermazdahonolulu_next_page", "filter_cuttermazdahonolulu_next_page", 10, 2);

function filter_cuttermazdahonolulu_next_page($next_page_regex)
{
	slecho("Filtering Next url");
	 return str_replace('inventory', '',  $next_page_regex);
	 
}
