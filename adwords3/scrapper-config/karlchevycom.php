<?php
global $scrapper_configs;
$scrapper_configs["karlchevycom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.karlchevy.com/searchnew.aspx?pn=100',
        'used' => 'https://www.karlchevy.com/searchused.aspx?pn=100',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thankyou.aspx/i',
    'use-proxy'           => true,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['div.carousel__control--next'],
    'picture_prevs' => ['div.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'vin'           => '/VIN #:\s*[^>]+>[^>]+>(?<vin>[^<]+)/',
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'model' => '/class="notranslate">(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+) (?<trim>[^<]+)/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/class="pull-right primaryPrice">(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/brand":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);
