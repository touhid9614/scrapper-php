<?php

global $scrapper_configs;
$scrapper_configs["kirksvilletoyota"] = array(
    'entry_points' => array(
        'used' => 'https://www.kirksvilletoyota.com/used-vehicles-kirksville-mo?limit=300',
        'new' => 'https://www.kirksvilletoyota.com/new-toyota-kirksville-mo?limit=300',
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    //'ty_url_regex' => '/\/eprice-[^\?]+\?.*form-action=success/i',
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.zoom-thumbnails__thumbnail.js-zoom-thumbnail'],
    'picture_nexts' => ['.df-icon-chevron-right.icon'],
    'picture_prevs' => ['.df-icon-chevron-right.icon'],

    'details_start_tag' => '<div class="module-container js-module mod-inventory-listing',
    'details_end_tag' => '<div class="vertical-alignment_content">',
    'details_spliter' => '<div class="vehicle-item inventory-listing__item js-vehicle-item',

    //'must_contain_regx' => '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
    'data_capture_regx' => array(
        'stock_number' => '/<span class="vehicle-highlights__subtitle-value">\s*#\s*(?<stock_number>[^<]+)/',
        'url' => '/class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        //'title' => '/<meta itemprop="name" content="(?<title>[0-9]{4}[^"]+)/',
        'year' => '/class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make' => '/class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model' => '/class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'price' => '/<div class="price_name">\s*Dealer Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'exterior_color' => '/Exterior Color:<\/span>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/span>\s*<[^>]+>(?<interior_color>[^<]+)/',   
        'kilometres' => '/additional-label">Mileage<\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'trim' => '/Trim:<\/div>\s*[^>]+>(?<trim>[^<]+)/',
        'body_style' => '/Body:<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
        //'interior_color' => '/Interior:.*\s*<span class="value">(?<interior_color>[^<]+)/',
        'vin' => '/VIN:<\/div>\s*[^>]+>(?<vin>[^<]+)/',
        'fuel_type' => '/Fuel Type:<\/div>\s*<[^>]+>(?<fuel_type>[^<]+)/',
        //'engine' => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/div>\s*<[^>]+>(?<transmission>[^<]+)/',
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
        'drivetrain' => '/Drivetrain:<\/div>\s*[^>]+>(?<drivetrain>[^<]+)/',
    ),
    //'next_page_regx' => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/class="main-slider__inner-img" src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^\s]+)"/'
);

add_filter("filter_kirksvilletoyota_field_images", "filter_kirksvilletoyota_field_images");

function filter_kirksvilletoyota_field_images($im_urls) {
    if (count($im_urls) < 2) {
        return [];
    }
    return $im_urls;
}
