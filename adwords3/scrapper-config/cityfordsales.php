<?php

global $scrapper_configs;

$scrapper_configs['cityfordsales'] = array(
    'entry_points' => array(
        'new' => 'https://www.cityfordsales.com/new-ford-cars-edmonton',
        'used' => 'https://www.cityfordsales.com/used-cars-edmonton',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)-[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => "<div class='subMain'",
   'details_end_tag' => '<footer>',
    'details_spliter' => '<div class="mainImgWrap">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #<\/td>\s*<td>(?<stock_number>[^<]+)/',
        'url' => '/<div class="invTextWrap">.*\s*<h3><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'title' => '/<div class="invTextWrap">.*\s*<h3><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/<div class="invTextWrap">.*\s*<h3><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/<div class="invTextWrap">.*\s*<h3><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/<div class="invTextWrap">.*\s*<h3><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/<div class="(?:nowPrice|price)">(?:MSRP|Price)\s*(?<price>[^\*<]+)/',
        'vin' => '/VIN<\/td>\s*<td>(?<vin>[^<]+)/',
        'engine' => '/Engine<\/td>\s*<td>(?<engine>[^<]+)/',
        'transmission' => '/Transmission<\/td>\s*<td>(?<transmission>[^<]+)/',
        'kilometres' => '/Odometer<\/td>\s*<td>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    //'next_page_regx' => '//',
    'images_regx' => '/data-image="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
