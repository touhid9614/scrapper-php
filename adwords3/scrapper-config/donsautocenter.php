<?php

global $scrapper_configs;
$scrapper_configs["donsautocenter"] = array(
    'entry_points' => array(
        'used' => 'https://www.donsautocenter.com/used-cars-inland-empire',
    ),
    'vdp_url_regex' => '/vehicle\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.ar_mainimage'],
    'picture_nexts' => [''],
    'picture_prevs' => [''],
    'details_start_tag' => '<div class="content-wrap">',
    'details_end_tag' => '<div class="footer-wrap',
    'details_spliter' => '<div class="inv-container">',
    'data_capture_regx' => array(
        'url' => '/class="ar_makemodel"><a href="\/\/[^\/]+\/(?<url>[^?]+)[^>]+>(?<title>[^<]+)/',
        'title' => '/class="ar_makemodel"><a href="(?<url>[^?]+)[^>]+>(?<title>[^<]+)/',
        'year' => '/class="ar_makemodel"><a href="(?<url>[^?]+)[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/class="ar_makemodel"><a href="(?<url>[^?]+)[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/class="ar_makemodel"><a href="(?<url>[^?]+)[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'stock_number' => '/class="ar_sn">Stock : (?<stock_number>[^<]+)/',
        'price' => '/Sale Price<\/span>\s*:\s*<\/span>\s*(?<price>[^<]+)/',
        'exterior_color' => '/Exterior<\/b>\s*:(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior<\/b>\s*:(?<interior_color>[^<]+)/',
        'engine' => '/Engine<\/b>\s*:\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission<\/b>\s*:\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage<\/b>\s*:\s*(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    //there is no next page right now only 109 car is here in 1 page//
    'next_page_regx' => '//',
    'images_regx' => '/<div class="vehicle_fineavail">.*<\/div><img src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);
