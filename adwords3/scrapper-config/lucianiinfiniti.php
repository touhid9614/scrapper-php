<?php

global $scrapper_configs;
$scrapper_configs["lucianiinfiniti"] = array(
    'entry_points' => array(
        'new' => 'https://www.lucianiinfiniti.ca/en/new-catalog',
        'used' => 'https://www.lucianiinfiniti.ca/en/used-inventory?limit=200'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:new|used)-/i',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'new' => array(
        'details_start_tag' => 'class="catalog-listing-alpha__make-block"',
        'details_end_tag' => '<footer class="footer"',
        'details_spliter' => '<div class="catalog-block-alpha__wrapper',
        'data_capture_regx' => array(
            'url' => '/<a class="catalog-block-alpha__name-anchor" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'title' => '/<a class="catalog-block-alpha__name-anchor" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/<a class="catalog-block-alpha__name-anchor" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/<a class="catalog-block-alpha__name-anchor" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/<a class="catalog-block-alpha__name-anchor" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/class="showroom-price__price--regular"[^>]+>\s*(?<price>[^\s]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),
    'used' => array(
        'details_start_tag' => '<section class="page-content__right">',
        'details_end_tag' => '<div class="page-wrapper footer__wrapper">',
        'details_spliter' => '<div class="inventory-list-layout"',
        'data_capture_regx' => array(
            'title' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/<div class="inventory-list-layout__preview-price-current vehicle__rebate"[^>]+>\s*(?<price>[^<]+)/',
            'kilometres' => '/class="inventory-list-layout__preview-km">\s*<[^>]+><\/span>\s*<[^>]+>(?<kilometres>[^<]+)/',
            'transmission' => '/class="inventory-list-layout__preview-transmission">\s*<[^>]+><\/span>\s*<[^>]+>(?<transmission>[^<]+)/',
            'vin' => '/data-vin="(?<vin>[^"]+)/',
            'url' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number' => '/Inventory #:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
            'engine' => '/Cylinders:<\/div>\s*<[^>]+>(?<engine>[^&]+)/',
            'exterior_color' => '/Ext. Color:<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Int. color:<\/div>\s*<[^>]+>(?<interior_color>[^<]+)/',
        ),
        //  'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        //    'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),
);
