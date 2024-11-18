<?php
global $scrapper_configs;
$scrapper_configs["bellinghamchevy"] = array(
	'entry_points' => array(
              'used' => 'https://www.bellinghamchevy.com/searchused.aspx',
		'new' => 'https://www.bellinghamchevy.com/searchnew.aspx',
      
    ),

    'vdp_url_regex' => '/\/(?:new|used)-[^-]*-[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.mfp-arrow-right.mfp-prevent-close'],
    'picture_prevs' => ['.mfp-arrow-left.mfp-prevent-close'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'title' => '/<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'year' => '/<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'make' => '/<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'model' => '/<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
        'body_style' => '/>Body Style:[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)<\/li>\s*<li class="drive/',
        'exterior_color' => '/Transmission:.*\s*<li class="extColor"><strong>Ext. Color: <\/strong>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/class="intColor"><strong>Int. Color: <\/strong>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
         'vin' => '/VIN #:[^>]+>[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'drive_train' => '/Drive Type:[^>]+>(?<drive_train>[^<\/]+)/',
        'price' => '/class="pull-right primaryPrice">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
         'description'  => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"\s*data-loc="available inventory">\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
    //'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);