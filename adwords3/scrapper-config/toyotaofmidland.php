<?php

global $scrapper_configs;
$scrapper_configs["toyotaofmidland"] = array(
    'entry_points' => array(
        'new' => 'https://www.toyotaofmidland.com/new-inventory/index.htm',
        'used' => 'https://www.toyotaofmidland.com/used-inventory/index.htm',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel li'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:Price|Sale Price)<span class=[^>]+>:<\/span><\/span>[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
        'kilometres' => '/Mileage:<\/dt>\s*[^>]+>(?<kilometres>[^\s*]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'trim' => '@"trim": "(?<trim>[^"]+)@',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_toyotaofmidland_field_images", "filter_toyotaofmidland_field_images");

function filter_toyotaofmidland_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'unavailable_stockphoto.png');
    });
}
