<?php

global $scrapper_configs;
$scrapper_configs["morreyinfiniti"] = array(
    'entry_points' => array(
        'new' => 'https://www.morreyinfiniti.com/en/new-inventory?limit=200',
        'used' => 'https://www.morreyinfiniti.com/en/pre-owned-inventory?limit=200',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|pre-owned|certified)-inventory\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.gallery-delta__thumbnails-item span.overlay img'],
    'picture_nexts' => ['div.gallery-delta-slider__controls a:nth-of-type(2)'],
    'picture_prevs' => ['div.gallery-delta-slider__controls a:nth-of-type(1)'],
    'details_start_tag' => '<section class="page__content-right">',
    'details_end_tag' => '<footer class="footer"',
    'details_spliter' => '<article class="inventory-list-layout"',
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-list-layout__preview-name make__trim" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'title' => '/<a class="inventory-list-layout__preview-name make__trim" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'year' => '/<a class="inventory-list-layout__preview-name make__trim" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'make' => '/<a class="inventory-list-layout__preview-name make__trim" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'model' => '/<a class="inventory-list-layout__preview-name make__trim" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'price' => '/class="inventory-list-layout__preview-price-current">\s*<span class="notranslate">(?<price>\$[0-9,]+)/',
        'stock_number' => '/#\s*stock<\/span>\s*<span>(?<stock_number>[^<]+)/',
        'kilometres' => '/<div class="inventory-list-layout__preview-info".*\s*.*<span>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine Size:.*\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:.*\s*(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext.\s*Color:.*\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int.\s*color:.*\s*(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/<a class="pager-item pagination__page-arrows-text .*"\s*href="(?<next>[^"]+)"/',
    'images_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<div class="inventory-vehicle-details__header-image-new">\s*<[^>]+>\s*.*\s*.*\s*data-picture-url="(?<img_url>[^"]+)"/'
);
