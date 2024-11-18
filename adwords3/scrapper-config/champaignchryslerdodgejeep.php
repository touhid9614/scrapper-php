<?php

global $scrapper_configs;
$scrapper_configs["champaignchryslerdodgejeep"] = array(
    'entry_points' => array(
        'used' => 'https://www.champaignchryslerdodgejeep.com/searchnew.aspx',
        'new' => 'https://www.champaignchryslerdodgejeep.com/searchused.aspx',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.carousel__item.js-carousel__item img'],
    'picture_nexts' => ['.js-carousel__control--next'],
    'picture_prevs' => ['.js-carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
         'vin'           => '/VIN #:\s*[^>]+>[^>]+>(?<vin>[^<]+)/',
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/(?:MSRP:|Internet Price)\s*<\/span><span[^>]+>\$(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
);
