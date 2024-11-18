<?php

global $scrapper_configs;

$scrapper_configs['rimrockauto'] = array(
    'entry_points' => array(
        'new' => 'https://www.rimrockauto.com/new-inventory/billings-bozeman-mt.htm',
        'used' => 'https://www.rimrockauto.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/+[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<div class="bd">',
    'details_end_tag' => '<div  class="ddc-footer',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^<]+)/',
        'title' => '/class="[^>]+">\s*<a href="(?<url>[^"]+)"\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="[^>]+">\s*<a href="(?<url>[^"]+)"\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/class="[^>]+">\s*<a href="(?<url>[^"]+)"\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/class="[^>]+">\s*<a href="(?<url>[^"]+)"\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/Internet Price\s*<[^>]+>:<\/span>\s*<\/span>\s*<[^>]+>\s*(?<price>[^\n]+)/',
        'engine' => '/data-engine="(?<engine>[^"]+)/',
        'exterior_color' => '/Exterior Color<\/label>\s*<span>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior Color<\/label>\s*<span>(?<interior_color>[^<\[]+)/',
        'kilometres' => '/Mileage<\/label>\s*<span>(?<kilometres>[^<]+)/',
        'transmission' => '/data-transmission="(?<transmission>[^"]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'url' => '/class="[^>]+">\s*<a href="(?<url>[^"]+)"\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
