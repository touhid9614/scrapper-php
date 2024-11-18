<?php

global $scrapper_configs;
$scrapper_configs["mercedesoftexarkana"] = array(
    'entry_points' => array(
        'new' => 'https://www.mercedesoftexarkana.com/new-inventory/index.htm',
        'used' => 'https://www.mercedesoftexarkana.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/contact-form-confirm.htm/i',
    //'use-proxy' => true,
    'proxy-area' => 'FL',
    'picture_selectors' => ['.jcarousel-item a img'],
    'picture_nexts' => ['.jcarousel-next'],
    'picture_prevs' => ['.jcarousel-prev'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/final-price.*class=\'value[^>]+>\$(?<price>[^<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
        'price' => '/ <li class="final-price">\s*<i .*\s*<span class="price">(?<price>[^<]+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
//        'images_regx'       => '/<li>\s*<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
    'images_regx' => '/<a href="(?<img_url>[^\?]+)\?impolicy=resize&w=[^"]+" class="js-link">/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_mercedesoftexarkana_field_images", "filter_mercedesoftexarkana_field_images");

function filter_mercedesoftexarkana_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'unavailable_stockphoto.png');
    });
}
