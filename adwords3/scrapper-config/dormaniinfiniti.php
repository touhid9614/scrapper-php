<?php

global $scrapper_configs;
$scrapper_configs["dormaniinfiniti"] = array(
    'entry_points' => array(
        'new' => 'https://www.dormaniinfiniti.com/en/new',
        'used' => 'https://www.dormaniinfiniti.com/en/for-sale/all/used'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:inventory\/)?(?:new|used)/i',
    //   'ty_url_regex' => '/\/thank-you/i',
    //  'ajax_url_match' => '/confirm-availability/',
    //  'ajax_resp_match' => 'Thank You For Your Inquiry - MacDonald Auto Group',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
    'new' => array(
        'details_start_tag' => '<div class="listing-container cf">',
        'details_end_tag' => '<section class="footer-notice',
        'details_spliter' => '<div class="showroom-list catalog-vehicle-preview-list box" ',
        'data_capture_regx' => array(
            'url' => '/href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'title' => '/<a href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/<span class="showroom-price__price--regular ">\s*(?<price>[^\s]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'images_regx' => '/<div class="imgbox">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),
    'used' => array(
        'details_start_tag' => '<div class="column-content f-l">',
        'details_end_tag' => '<section class="footer-notice',
        'details_spliter' => '<div class="box inventory-vehicle-preview-list"',
        'data_capture_regx' => array(
            'stock_number' => '/itemprop="sku">#(?<stock_number>[^<]+)/',
            'title' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'year' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'make' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'model' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'price' => '/class="amount vehicle-new-price">(?<price>[^<]+)/',
     
            'url' => '/<a href="(?<url>[^"]+)"\s*class="vehicle-title">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/'
        ),
        'data_capture_regx_full' => array(
                   'kilometres' => '/<span class="odo">(?<kilometres>[^<]+)/',
            'vin' => '/VIN<\/dt>\s*<dd>\s*(?<vin>[^<]+)/',
            'transmission' => '/<span class="clutch">(?<transmission>[^<]+)/',
           // 'engine' => '/Cylinders<\/dt>\s*<dd>\s*(?<engine>[^&]+)/',
            'exterior_color' => '/Color<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
        ),
        'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        //    'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
    ),
);
