<?php
global $scrapper_configs;
$scrapper_configs['hzlowell'] = array(

    'entry_points' => array(
        'new' => 'https://www.hzlowell.com/searchnew.aspx',
        'used'=> 'https://www.hzlowell.com/searchused.aspx'
    ),
    'vdp_url_regex'       => '/\/(?:new|used)-Grand[^\-]+-[0-9]{4}-/i',
//    'ty_url_regex'        => '/\/eprice-[^\?]+\?.*form-action=success/i',
    'use-proxy'           => true,
    'details_start_tag'   => '<div class="row srpVehicle">',
    'details_end_tag'     => '<div class="row srpDisclaimer">',
    'details_spliter'     => '<div id="srpRow-',

    'data_capture_regx' => array(
        'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'model'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
        'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price'            => '/Internet\s*Price:\s*[^"]+"[^"]+"\s*>\$(?<price>[^<\/]+)/',

        ),
    'data_capture_regx_full' => array(      
        'transmission'    => '/Transmission[^<]+<\/span>\s*<h3[^>]+>(?<transmission>[^<]+)/',
        'body_style'      => '/Body Style\s*<\/span>\s*<h3[^>]+>(?<body_style>[^<]+)/',
        'make'            => '/var vehicleMake="(?<make>[^"]+)/',
        'model'           => '/var vehicleModel="(?<model>[^"]+)/'
    ) ,
    'next_page_regx' => '/<a href="(?<next>[^"]+)"[^\n]+\s*Next/',
    'images_regx'   => '/<img\s*class=\'img-responsive\'\s*src="(?<img_url>[^"]+)"/'
);

