<?php

global $scrapper_configs;

$scrapper_configs['scottsubaru'] = array(
    'entry_points' => array(
        'new' => 'https://www.scottsubaru.com/new-subaru-red-deer',
        'used' => 'https://www.scottsubaru.com/used-cars-red-deer'
    ),
    'vdp_url_regex' => '/\/vehicle\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.i-thumbs-mini img'],
    'picture_nexts' => ['.i-gallery-right'],
    'picture_prevs' => ['.i-gallery-left'],
    'details_start_tag' => '<div class="page-div"',
    'details_end_tag' => '<div class="inv-record inv-record-footer">',
    'details_spliter' => '<div class=\'ibox\'',
    'data_capture_regx' => array(
        'stock_number' => '/div class=\'ibox-stock\'>[^#]+#(?<stock_number>[^<]+)/',
        'title' => '/<div class=\'ibox-title\'>(?<title>[^<]+)/',
        'year' => '/<div class=\'ibox-title\'>(?<year>[0-9]{4})/',
        'make' => '/<div class=\'ibox-title\'>[0-9]{4}\s(?<make>[^\s]+)/',
        'model' => '/<div class=\'ibox-title\'>[0-9]{4}\s[^\s]+\s(?<model>[^\s]+)<\/div>/',
        'price' => '/<div class=\'(?:ahead vstike no-vstrike|ibox-pricing)\'>(?<price>[^<]+)/',
        'url' => '/<a\sclass=\'ibox-aref\'\shref=\'(?<url>[^\']+)/'
    ),
    'data_capture_regx_full' => array(
        'trim' => '/<td class=\'v-trim\'>(?<trim>[^<]+)/',
        'stock_number' => '/Stock #<\/td>\s*[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/Body Type<\/td>\s*[^>]+>(?<body_style>[^<]+)/',
        'engine' => '/Engine<\/td>\s*[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission<\/td>\s*[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior\sColor<\/td>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior\sColor<\/td>\s*[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/Mileage<\/td>\s*[^>]+>(?<kilometers>[^<]+)/',
    ),
    'next_page_regx' => '/<a\shref="(?<next>[^"]+)"\sclass="inv-record-button">/',
    //'images_regx'       => '/<div class=\'i-thumbs-mini\'><[^\']+\'[^\=]+=\'(?<img_url>[^\']+)/',
    'images_fallback_regx' => '/iv-image-image\'[^\']+\'[^\']+\' src=\'(?<img_url>[^\']+)/',
);
add_filter("filter_scottsubaru_field_images", "filter_scottsubaru_field_images");

function filter_scottsubaru_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'coming-soon.png');
    });
}
