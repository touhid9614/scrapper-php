<?php
global $scrapper_configs;
$scrapper_configs["garyyeomansfordcom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.garyyeomansford.com/searchnew.aspx?pn=1000',
        'used' => 'https://www.garyyeomansford.com/searchused.aspx?pn=1000',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    //'ty_url_regex' => '/\/thankyou.aspx/i',
     'refine' => false,
    //   'proxy-area'        => 'FL',
    'picture_selectors' => ['.hero-carousel__image'],
    'picture_nexts' => ['div.carousel__control--next'],
    'picture_prevs' => ['div.carousel__control--prev'],
    //'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => 'data-vehicle-information',
    'data_capture_regx' => array(
        'vin'           => '/data-vin="(?<vin>[^"]+)/',
        'url' => '/hero-carousel__item--viewvehicle"\s*href="(?<url>[^"]+)/',
        //'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'body_style' => '/data-bodystyle="(?<body_style>[^"]+)/',
        'transmission' => '/data-trans="(?<transmission>[^"]+)/',
        'engine' => '/data-engine="(?<engine>[^"]+)/',
        'exterior_color' => '/data-extcolor="(?<exterior_color>[^"]+)/',
        'interior_color' => '/data-intcolor="(?<interior_color>[^"]+)/',
        'stock_number' => '/Stock:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
      
        'price' => '/data-price="(?<price>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
          'kilometres' => '/Mileage[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
        // 'make' => '/brand":\s*"(?<make>[^"]+)/',
        // 'model' => '/model":\s*"(?<model>[^"]+)/',
        // 'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/<a\s*href=\'(?<next>[^\']+)\'\s*class="stat\-arrow\-next"\s*/',
    'images_regx' => '/<div class="thumbnails--desktop__top">\s*<a href="(?<img_url>[^"]+)/'
);
