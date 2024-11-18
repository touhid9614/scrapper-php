<?php
global $scrapper_configs;
$scrapper_configs["loudonmotorsfordnet"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.loudonmotorsford.net/searchnew.aspx',
        'used' => 'https://www.loudonmotorsford.net/searchused.aspx',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^\-]+-[0-9]{4}-/i',
     'refine'=>false,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*)/',
        'title' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*)/',
        'year' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*)/',
        'make' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*)/',
        'model' => '/data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*)/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/(?:Internet|Final) Price.\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
      //  'msrp' => '/MSRP: <\/span><span class="pull-right">(?<msrp>[^<]+)/',
        'vin' => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
        //'drivetrain' => '/Drive Type: <\/strong>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage:(?<kilometres>[^<]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);