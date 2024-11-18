<?php

global $scrapper_configs;

$scrapper_configs['rimrockautocredit'] = array(
    'entry_points' => array(
        'used' => 'https://www.rimrockautocredit.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/+[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<div class="bd">',
    'details_end_tag' => '<div  class="ddc-footer',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^<]+)/',
        'title' => '/<a class="url" href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/<a class="url" href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/<a class="url" href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/<a class="url" href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/(?:invoicePrice|internetPrice|stackedFinal|final|salePrice|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/dt>\s*<dd>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color:<\/dt>\s*<dd>(?<interior_color>[^<\[]+)/',
        'kilometres' => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'url' => '/<a class="url" href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
