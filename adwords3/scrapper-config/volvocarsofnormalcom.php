<?php
global $scrapper_configs;
$scrapper_configs["volvocarsofnormalcom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.volvocarsofnormal.com/new-inventory/index.htm',
        'used' => 'https://www.volvocarsofnormal.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

