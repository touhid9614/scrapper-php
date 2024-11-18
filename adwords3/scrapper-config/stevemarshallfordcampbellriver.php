<?php

global $scrapper_configs;

$scrapper_configs['stevemarshallfordcampbellriver'] = array(
    'entry_points' => array(
        'new' => 'https://www.stevemarshallfordcampbellriver.com/new-inventory/?condition=new-cars&sort_order=date_low',
        'used' => 'https://www.stevemarshallfordcampbellriver.com/used-inventory/?condition=used-cars&sort_order=date_low',
    ),
    'vdp_url_regex' => '/\/listings\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel li'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<div class="col-md-9 col-sm-12 ">',
    'details_end_tag' => '<footer id="footer">',
    'details_spliter' => '<div class="listing-list-loop',
    'data_capture_regx' => array(
        'url' => '/class="title heading-font">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'title' => '/class="title heading-font">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/class="title heading-font">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/class="title heading-font">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/class="title heading-font">\s*<a href="(?<url>[^"]+)"[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'price' => '/(?:Employee Price|NOW PRICE:)\s*(?<price>\$[0-9,][^<]+)/',
        'kilometres' => '/Mileage<\/div>\s*<\/div>\s*<[^>]+>\s*(?<kilometres>[^\<]+)/',
        'stock_number' => '/stock#\s*<\/span>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine<\/div>\s*<\/div>\s*<[^>]+>\s*(?<engine>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/Transmission<\/td>\s*<[^>]+>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color<\/td>\s*<[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color<\/td>\s*<[^>]+>(?<interior_color>[^\<]+)/',
    ),
    'next_page_regx' => '/<a class="next page-numbers" href="(?<next>[^"]+)/',
    //  'images_regx' => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);
