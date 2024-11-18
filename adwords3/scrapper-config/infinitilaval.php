<?php

global $scrapper_configs;
$scrapper_configs["infinitilaval"] = array(
    'entry_points' => array(
        'new' => 'https://www.infinitilaval.ca/showroom',
        'used' => 'https://www.infinitilaval.ca/used'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/(?:showroom|used)\//i',
    'picture_selectors' => ['#imagePreview', '.open-vdp-popover'],
    'picture_nexts' => ['.slick-next.slick-arrow'],
    'picture_prevs' => ['.slick-prev.slick-arrow'],
    'new' => array(
        'details_start_tag' => 'class="container showroom">',
        'details_end_tag' => 'class="footer">',
        'details_spliter' => 'class="showroom-box',
        'data_capture_regx' => array(
            'url' => '/itemprop="url" href="(?<url>[^"]+)">/',
            'title' => '/itemprop="name">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'year' => '/itemprop="name">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'make' => '/itemprop="name">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'model' => '/itemprop="name">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            //there is no price right now . some has msrp but they are cross mark //
            'price' => '//',
        ),
        'data_capture_regx_full' => array(
        ),
        'images_regx' => '/id="imagePreview" src="(?<img_url>[^"]+)"/',
    ),
    'used' => array(
        'details_start_tag' => 'class="container" id="catalogue-display">',
        'details_end_tag' => 'class="footer">',
        'details_spliter' => 'class="car-box car-favorite-discrete used-cars',
        'data_capture_regx' => array(
            'stock_number' => '/Stock:\s<span>(?<stock_number>[^<]+)/',
            'title' => '/itemprop="url" href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/itemprop="url" href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/itemprop="url" href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/itemprop="url" href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/itemprop="price"[^>]+><\/span><meta\s*[^>]+>\s*<span>(?<price>[^<]+)/',
            'kilometres' => '/class="mileage" itemprop="value">(?<kilometres>[^<]+)/',
            'transmission' => '/Transmission:<\/strong>(?<transmission>[^<]+)/',
            'engine' => '/Engine:<\/strong>(?<engine>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor"><strong>[^<]+<\/strong>\s*(?<interior_color>[^<]+)/',
            'url' => '/itemprop="url" href="(?<url>[^"]+)" title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/'
        ),
        'data_capture_regx_full' => array(
            'vin' => '/vin" content="(?<vin>[^"]+)/',
        ),
        'next_page_regx' => '/<a\s*class="next-page" data-page="[0-9]*" href="(?<next>[^"]+)">next/',
        // 'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',      ////all images are blank//
        'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/',
    ),
);
