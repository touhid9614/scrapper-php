<?php

global $scrapper_configs;

$scrapper_configs['northerntruckranch'] = array(
    'entry_points' => array(
        'used' => 'https://www.northerntruckranch.com/inventory',
    ),
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
    'picture_selectors' => ['.head-text'],
    'picture_nexts' => ['#darkbox_next'],
    'picture_prevs' => ['#darkbox_prev'],
    'details_start_tag' => '<div class="col-md-9 col-sm-12 mb20 new-cont">',
    'details_end_tag' => '<div class="footer">',
    'details_spliter' => '<div class="vehicle-listing"',
    'data_capture_regx' => array(
        'url' => '/class="eziVehicleName">\s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'title' => '/class="eziVehicleName">\s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/class="eziVehicleName">\s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/class="eziVehicleName">\s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/class="eziVehicleName">\s*<a href="(?<url>[^"]+)">\s*(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'price' => '/class="eziPriceValue">\s*<strike>\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/Odometer\s<\/strong>\s*<span>\s*(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock#<\/strong>\s*<span>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine\s*<\/strong>\s*<span>\s*(?<engine>[^\<]+)/',
        'transmission' => '/Transmission\s*<\/strong>\s*<span>\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior\s*<\/strong>\s*<span>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior\s*<\/strong>\s*<span>\s*(?<interior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    //there is no next page right now//
    //'next_page_regx' => '/next-btn" data-href="(?<next>[^"]+)">/',
    'images_regx' => '/<div class="head-text">\s*<img src="(?<img_url>[^"]+)/',
        // 'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
