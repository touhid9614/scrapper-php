<?php
global $scrapper_configs;
$scrapper_configs["test_smedia_ca_2"] = array(
    "entry_points"           => [
        'all' => 'https://test2.smedia.ca/cars.html',
    ],

    'vdp_url_regex'          => '/\/vdp\/(?:new|used|certified-used|certified)-[0-9]{4}-/i',
    'use-proxy'              => false,
    'refine'                 => false,

    'details_start_tag'      => '<div class="col-lg-9 col-xs-12">',
    'details_end_tag'        => '<footer id="footer">',
    'details_spliter'        => '<div class="col-lg-6 col-md-4 col-sm-6">',

    'data_capture_regx'      => array(
        'url' => '/<div class="courses-detail">\s*<h3><a href="(?<url>[^"]+)"\s*target/',
    ),

    'data_capture_regx_full' => array(
        'stock_type'   => '/<h2 style="text-transform:uppercase">(?<title>(?<stock_type>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*[^<]+)/',
        'year'         => '/<h2 style="text-transform:uppercase">(?<title>(?<stock_type>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*[^<]+)/',
        'make'         => '/<h2 style="text-transform:uppercase">(?<title>(?<stock_type>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*[^<]+)/',
        'model'        => '/<h2 style="text-transform:uppercase">(?<title>(?<stock_type>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*[^<]+)/',
        'title'        => '/<h2 style="text-transform:uppercase">(?<title>(?<stock_type>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*[^<]+)/',
        'stock_number' => '/Stock Number<\/span>\s*<br>\s*<strong>(?<stock_number>[^<]+)/',
        'vin'          => '/VIN<\/span>\s*<br>\s*<strong>(?<vin>[^<]+)/',
        'kilometres'   => '/Mileage<\/span>\s*<br>\s*<strong>(?<kilometres>[^<]+)/',
        'price'        => '/<strong class="text-primary">(?<price>[^<]+)/',
        'transmission' => '/Transmission<\/span>\s*<br>\s*<strong>(?<transmission>[^<]+)/',
        'engine'       => '/Engine<\/span>\s*<br>\s*<strong>(?<engine>[^<]+)/',
        'host'         => '/URL : <\/span>\s*<strong><i><a>(?<host>[^<]+)/',
    ),

    'images_regx'            => '/(?:<div class="col-sm-4 col-xs-6">|<div class="col-md-6 col-xs-12">)\s*<div>\s*<img src="(?<img_url>[^"]+)/',
);