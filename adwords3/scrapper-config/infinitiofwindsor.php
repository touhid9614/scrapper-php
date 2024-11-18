<?php

global $scrapper_configs;
$scrapper_configs["infinitiofwindsor"] = array(
    'entry_points' => array(
        'new' => 'http://www.infinitiofwindsor.com/en/new-inventory',
        'used' => 'http://www.infinitiofwindsor.com/en/used-inventory',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used|certified)-inventory\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.gallery-delta__thumbnails-item span.overlay img'],
    'picture_nexts' => ['div.gallery-delta-slider__controls a:nth-of-type(2)'],
    'picture_prevs' => ['div.gallery-delta-slider__controls a:nth-of-type(1)'],
    'details_start_tag' => '<section class="page-content__right">',
    'details_end_tag' => '<footer class="footer"',
    'details_spliter' => '<article class="inventory-list-layout-wrapper',
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'title' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'year' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'make' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'model' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*))/',
        'price' => '/class="inventory-list-layout__preview-price-current vehicle__rebate".*\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Inventory #:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/Mileage<\/span>\s*<[^>]+>(?<kilometres>[^<]+)/',
        'transmission' => '/Transmission<\/span>\s*<[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. Color:<\/div>\s*<[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/<a class="pagination__page-arrows-text\s"\shref="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
    'images_regx' => '/<span class="overlay">\s*<img class="[^"]+"\s*src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
