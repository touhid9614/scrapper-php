<?php

global $scrapper_configs;
$scrapper_configs['bathursttoyota'] = array(
    'entry_points'           => array(
        'new'  => 'http://www.bathursttoyota.ca/en/for-sale/all/new',
        'used' => 'http://www.bathursttoyota.ca/en/for-sale/all/used'
    ),
    'use-proxy'              => true,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/en\/inventory\/(?:new|used)/i',

    'picture_selectors'      => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts'          => ['#cboxNext'],
    'picture_prevs'          => ['#cboxPrevious'],

    'details_start_tag'      => '<div class="column-content f-l"',
    'details_end_tag'        => '<p class="legal-note">',
    'details_spliter'        => '<div class="box inventory-vehicle-preview-list',
    'data_capture_regx'      => array(
        'stock_number' => '/itemprop="sku">#(?<stock_number>[^<]+)/',
        'title'        => '/<a href="(?<url>[^"]+)" class="vehicle-image hover-img" title="(?<title>(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^"]+))/',
        'year'         => '/<a href="(?<url>[^"]+)" class="vehicle-image hover-img" title="(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^"]+)/',
        'make'         => '/<a href="(?<url>[^"]+)" class="vehicle-image hover-img" title="(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^"]+)/',
        'model'        => '/<a href="(?<url>[^"]+)" class="vehicle-image hover-img" title="(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^"]+)/',
        'price'        => '/itemprop="price">\$(?<price>[^<]+)/',
        'kilometres'   => '/(?<kilometres>[0-9 ,]+)\s*KM/',
        'url'          => '/<a href="(?<url>[^"]+)" class="vehicle-image hover-img" title="(?<title>(?<year>[^ ]+) (?<make>[^ ]+)\s*(?<model>[^"]+))/'
    ),
    'data_capture_regx_full' => array(
        'transmission'   => '/<span class="clutch">(?<transmission>[^<]+)/',
        'body_style'     => '/Vehicle Type<\/dt>\s*<dd>(?<body_style>[^<]+)/',
        'engine'         => '/Cylinders<\/dt>\s*<dd>(?<engine>[ 0-9 a-z A-Z\.]+)/',
        'exterior_color' => '/<dt>Color<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<dt>Interior Color<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
        'vin'            => '/VIN #<\/dt>\s*<dd>\s*(?<vin>[^<]+)/',
        'model'          => '/\&desired_model=(?<model>[^\&]+)/',
        'trim'           => '/\&desired_trim=(?<trim>[^\&]+)/'
    ),
    'next_page_regx'         => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
    'images_regx'            => '/<a data-slide-index="[^"]+"\s*href="(?<img_url>[^"]+)"/'
);

add_filter("filter_bathursttoyota_field_images", "filter_bathursttoyota_field_images");

function filter_bathursttoyota_field_images($im_urls)
{
    if (count($im_urls) < 2) {
        return [];

    }

    return $im_urls;
}