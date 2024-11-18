<?php
global $scrapper_configs;
$scrapper_configs["gobencarscom"] = array(
    'entry_points'           => array(
        'used' => 'https://www.gobencars.com/application/browse5.php?d=86,66&type=0'
    ),
    'vdp_url_regex'          => '/\/application\/details2\.php/i',
    'refine'                 => false,
    'required_params'        => ['d', 'v'],

    'use-proxy'              => true,
    'init_method'            => 'GET',
    'next_method'            => 'POST',

    'picture_selectors'      => ['.slides li img'],
    'picture_nexts'          => ['.flex-next'],
    'picture_prevs'          => ['.flex-prev'],

    'details_start_tag'      => '<ul class="browse5List',
    'details_end_tag'        => '<footer class="mainFooter',
    'details_spliter'        => '<li class="browse5Vehicle cf',

    'data_capture_regx'      => array(
        'stock_number'   => '/browse5VehicleHeaderStock">\s*(?<stock_number>[^<]+)/',
        'url'            => '/<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'year'           => '/<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make'           => '/<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model'          => '/<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price'          => '/browse5PriceShowPrice">(?<price>\$[0-9,]+)/',
        'exterior_color' => '/<dd class="browse5VehicleDetailsColor[^>]+>(?<exterior_color>[^<]+)/',
        'engine'         => '/Engine[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission'   => '/Trans[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'kilometres'     => '/Miles[^>]+>[^>]+>(?<kilometres>[^<]+)/'
    ),

    'data_capture_regx_full' => array(
        'vin' => '/details2VehicleDetailsVIN">[^>]+>[^>]+>(?<vin>[^<]+)/'
    ),

    'images_regx'            => '/<img src="(?<img_url>[^"]+)"[^>]+>/'
);

add_filter("filter_gobencarscom_field_images", "filter_gobencarscom_field_images");

function filter_gobencarscom_field_images($im_urls)
{
    return array_filter($im_urls, function ($im_url) {
        if (endsWith($im_url, 'inventory-no-photo-west.jpg')) {
            return false;
        } else if (endsWith($im_url, 'inventory-no-photo-east.jpg')) {
            return false;
        }
        return true;
    });
}