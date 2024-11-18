<?php

global $scrapper_configs;

$scrapper_configs['kingstreetcars'] = array(
    'entry_points' => array(
        'used' => 'http://kingstreetcars.co.nz/vehicles.aspx',
    ),
    'vdp_url_regex' => '/vehicle/[^\/]+\/[0-9]+\?s=[0-9]+',
    'use-proxy' => true,
    'picture_selectors' => ['.gallery-thumb-wrapper .gallery-thumbs .thumb-item'],
    'picture_nexts' => ['.gallery-counter .icon-arrow-right'],
    'picture_prevs' => ['.gallery-counter .icon-arrow-left'],

    'details_start_tag' => '<div class="row vehicle-results gallery">',
    'details_end_tag' => '<footer>',
    'details_spliter' => '<li class="vehicle">',
    'data_capture_regx' => array(
        'url' => '/class="small-10 columns">\s*<a href="(?<url>[^"]+)">\s*<h6 class="small-12 columns" data-equalizer-watch>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'year' => '/class="small-10 columns">\s*<a href="(?<url>[^"]+)">\s*<h6 class="small-12 columns" data-equalizer-watch>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make' => '/class="small-10 columns">\s*<a href="(?<url>[^"]+)">\s*<h6 class="small-12 columns" data-equalizer-watch>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model' => '/class="small-10 columns">\s*<a href="(?<url>[^"]+)">\s*<h6 class="small-12 columns" data-equalizer-watch>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'price' => '/<span class="amount">(?<price>[^<]+)/',
        'stock_number' => '/class="small-10 columns">\s*<a href="\/[^\/]+\/[^\/]+\/(?<stock_number>[^\?]+)/',
    ),
    'data_capture_regx_full' => array(
        'title' => '/class="title">\s*<h2>\s*(?<title>[^\n]+)/',
        'body_style' => '/Body<\/div>\s*<[^>]+>(?<body_style>[^<]+)/',
        'exterior_color' => '/Ext Colour<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'engine' => '/Engine<\/div>\s*<[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission<\/div>\s*<[^>]+>\s*(?<transmission>[^\s]+)/',
        'interior_color' => '/Interior<\/div>\s*<div [^>]+>\s*(?<interior_color>[^\n]+)/',
        'kilometres' => '/Odometer<\/div>\s*<[^>]+>\s*(?<kilometres>[^(\s|k)]+)/',
    ),
    'next_page_regx' => '/<a class="btn-next" href="(?<next>[^"]+)">><\/a>/',
    'images_regx' => '/<a style="" onclick[^<]+<img src="..\/..\/(?<img_url>[^"]+)/'
);

add_filter("filter_kingstreetcars_field_images", "filter_kingstreetcars_field_images");
function filter_kingstreetcars_field_images($im_urls)
{
    $new_im_urls = [];
    $url_base = "https://www.kingstreetcars.co.nz";
    foreach ($im_urls as $im_url)
    {
        $new_im_url = preg_replace("/http:\/\/kingstreetcars.co.nz\/vehicle\/[^\/]+/", $url_base, $im_url);
        array_push($new_im_urls, $new_im_url);
    }
    return $new_im_urls;
}