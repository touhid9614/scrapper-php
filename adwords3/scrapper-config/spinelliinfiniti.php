<?php

global $scrapper_configs;
$scrapper_configs["spinelliinfiniti"] = array(
    'entry_points' => array(
        'new' => 'http://www.spinelliinfiniti.com/en/new-catalog',
        'used' => 'http://www.spinelliinfiniti.com/en/used-inventory?limit=200'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:new|used)-/i',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'new' => array(
        'details_start_tag' => '<section class="catalog-listing cf',
        'details_end_tag' => '<footer class="footer"',
        'details_spliter' => '<div class="catalog-vehicle-preview-list',
        'data_capture_regx' => array(
            'url' => '/<a class="imglnk" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'title' => '/<a class="imglnk" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/<a class="imglnk" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/<a class="imglnk" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/<a class="imglnk" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/itemprop="price"[^>]+>\s*(?<price>[^\s]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'images_regx' => '/<div class="params"\s*[^>]+><\/div>\s*<img src="(?<img_url>[^"]+)/',
    ),
    'used' => array(
        'details_start_tag' => '<section class="inventory-listing">',
        'details_end_tag' => '<footer class="footer" ',
        'details_spliter' => '<div class="vehicle-preview vehicle-preview__content-row',
        'data_capture_regx' => array(
            'stock_number' => '/<sub>#\s*(?<stock_number>[^<]+)/',
            'title' => '/<div class="title\s*">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/<div class="title\s*">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/<div class="title\s*">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/<div class="title\s*">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/itemprop="price"[^>]+>\s*(?<price>[^<]+)/',
            'kilometres' => '/<span class="km">(?<kilometres>[^<]+)/',
            'transmission' => '/<span class="transmission">(?<transmission>[^<]+)/',
            'vin' => '/data-vin="(?<vin>[^"]+)/',
            'url' => '/<div class="title\s*">\s*<a href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/'
        ),
        'data_capture_regx_full' => array(
            'engine' => '/Engine :\s*<\/span>\s*<span class="list-elem-inventory__elem__value">\s*(?<engine>[^&]+)/',
            'exterior_color' => '/Ext. Color :\s*<\/span>\s*<span class="list-elem-inventory__elem__value">\s*(?<exterior_color>[^<]+)/',
            'interior_color' => '/Int. Color :\s*<\/span>\s*<span class="list-elem-inventory__elem__value">\s*(?<interior_color>[^<]+)/',
        ),
        //  'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        //    'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),
);
