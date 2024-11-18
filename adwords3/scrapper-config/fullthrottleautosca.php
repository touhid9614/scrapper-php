<?php
global $scrapper_configs;
$scrapper_configs["fullthrottleautosca"] = array( 
	'entry_points' => array(
        'used' => 'https://fullthrottleautos.ca/saskatoon-inventory/',
    ),
    'vdp_url_regex' => '/\/listings\//i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'picture_selectors' => ['.pswp__img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'details_start_tag' => '<div class="sidebar"',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="inventory clearfix',
    'data_capture_regx' => array(
        'url' => '/class="inventory" href="(?<url>[^"]+)"/',
        'year' => '/<div class="title">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
        'make' => '/<div class="title">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
        'model' => '/<div class="title">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)/',
        'price' => '/current-price">Price[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/>Mileage[^>]+>[^>]+>(?<kilometres>[^\s<]+)/',
        'stock_number' => '/>Stock Number[^>]+>[^>]+>(?<stock_number>[^\<]+)/',
        'engine' => '/>Engine[^>]+>[^>]+>(?<engine>[^\s]+)/',
        'body_style' => '/>Body Style[^>]+>[^>]+>(?<body_style>[^\<]+)/',
        'transmission' => '/>Transmission[^>]+>[^>]+>(?<transmission>[^\<]+)/',
        'exterior_color' => '/>Exterior Color[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/>Interior Color[^>]+>[^>]+>(?<interior_color>[^\<]+)/',
        'vin' => '/>VIN Number[^>]+>[^>]+>(?<vin>[^\<]+)/',
        'drivetrain' => '/>Drivetrain[^>]+>[^>]+>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '@make\: \'(?<make>[^\']+)\'@',
        'model' => '@model\: \'(?<model>[^\']+)\'@',
        'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
        'description' => '/itemprop="description">\s*[^>]+>(?<description>[^<]+)/',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)"\s*alt=""/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
