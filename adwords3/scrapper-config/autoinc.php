<?php
global $scrapper_configs;

$scrapper_configs['autoinc'] = array(
    'entry_points' => array(
        'used' => 'https://www.autoinc.com/new-inventory/index.htm',
        'new' => 'https://www.autoinc.com/used-inventory/index.htm',
    ),

    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,

    'picture_selectors' => ['.jcarousel li'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.prev'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',

    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:<\/dt> <dd>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/dt> <dd>(?<transmission>[^<]+)/',
        'exterior_color' => '/<dt>Exterior Color:<\/dt> <dd>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<dt>Interior Color:<\/dt> <dd>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Mileage:<\/dt> <dd>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'vin' => '/data-vin="(?<vin>[^"]+)" data-make/',
    ),

    'data_capture_regx_full' => array(
        'drivetrain' => '/<dt class="text-muted col-xs-5">Drivetrain<\/dt><dd class="col-xs-7 p-0"><span>(?<drivetrain>[^<]+)<\/span>/'
    ),

    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);