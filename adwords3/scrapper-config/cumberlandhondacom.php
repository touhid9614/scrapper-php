<?php

global $scrapper_configs;
$scrapper_configs["cumberlandhondacom"] = array( 
	  'entry_points' => array(
        //'new' => 'https://www.cumberlandhonda.com/new-inventory/',
        'used' => 'https://www.cumberlandhonda.com/vehicles/'
    ),
    'vdp_url_regex' => '/\/inventory\//i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors'   => ['.img-fluid'],
    'picture_nexts'       => ['.slick-next'],
    'picture_prevs'       => ['.slick-prev'],
    'details_start_tag' => 'class="entry-title',
    'details_end_tag' => 'id="footer-menu"',
    'details_spliter' => 'class="vehicle box-shadow--small m-2 d-flex flex-column',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*itemprop="url"/',
        // 'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/alt="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'make' => '/alt="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'model' => '/alt="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'trim' => '/alt="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/',
        'price' => '/vehicle__price">(?<price>[^\s*]+)/',
        'kilometres' => '/class="vehicle__odometer mb-0">[^>]+>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number'   => '/Stock No:<\/td>[^>]+>[^>]+>(?<stock_number>[^<]+)/i',
        'description'    => '/<meta name="description" content="(?<description>[^<]+)/i',
        'exterior_color' => '/Exterior Colour:[^>]+>[^>]+>[^>]+>(?<exterior_color>[^<]+)/i',
        'interior_color' => '/Interior Colour:[^>]+>[^>]+>[^>]+>(?<interior_color>[^<]+)/i',
        'engine'         => '/Engine<\/dt><[^>]+><span>(?<engine>[^<]+)<\/span>/i',
    ),
    'next_page_regx' => '/class=\'current\'><a[^>]+>[0-9]*<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
    'images_regx' => '/<img class="img-fluid" src="(?<img_url>[^\?]+)/',
);

// global $scrapper_configs;

// $scrapper_configs['cumberlandhondacom'] = array(
//     'entry_points'        => array(
//         'used' => 'https://www.cumberlandhonda.com/vehicles/',
//         'new'  => 'https://www.cumberlandhonda.com/new-inventory/',
//     ),
//     'vdp_url_regex'       => '/\/inventory\//i',
//     'use-proxy'           => true,

//     'picture_selectors'   => ['.img-fluid'],
//     'picture_nexts'       => ['.slick-next'],
//     'picture_prevs'       => ['.slick-prev'],

//     "custom_data_capture" => function ($url, $data) {
//         $site                 = "https://www.cumberlandhonda.com/sitemap.xml";
//         $vdp_url_regex        = '/\/inventory\//i';
//         $images_regx          = '/<img class="img-fluid" src="(?<img_url>[^\?]+)/i';
//         $images_fallback_regx = null;
//         $required_params      = [];
//         $use_proxy            = true;
//         $keymap               = null;
//         $invalid_images       = [];
//         $use_custom_site      = true;
//         $annoy_func           = function ($car) {
//             $car['transmission'] = str_replace('\x2D', '', $car['transmission']);

//             if (!$car['transmission']) {
//                 $car['transmission'] = '';
//             }

//             if (strtolower($car['trim']) == 'for') {
//                 $car['trim'] = '';
//             }

//             if (strtolower($car['stock_type']) == 'new') {
//                 $car['stock_type'] = 'new';
//             } else {
//                 $car['stock_type'] = 'used';
//             }

//             return $car;
//         };

//         $data_capture_regx_full = [
//             'stock_type'     => '/<meta property="og:description" content="(?<stock_type>[^\s*]+)/i',
//             'year'           => '/itemprop="year">(?<year>[^<]+)/i',
//             'make'           => '/itemprop="brand">(?<make>[^<]+)/i',
//             'model'          => '/itemprop="model">(?<model>[^<]+)/i',
//             'trim'           => '/itemprop="trim">(?<trim>[^<]+)/i',
//             'price'          => '/Dealer Price[^>]+>\s*[^>]+>\s*<span[^>]+>(?<price>[^<]+)/i',
//             'engine'         => '/Engine<\/dt><[^>]+><span>(?<engine>[^<]+)<\/span>/i',
//             'transmission'   => '/Transmission:\s*(?<transmission>[^<]+)/i',
//             'kilometres'     => '/Odometer[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/i',
//             'exterior_color' => '/Exterior Colour:[^>]+>[^>]+>[^>]+>(?<exterior_color>[^<]+)/i',
//             'interior_color' => '/Interior Colour:[^>]+>[^>]+>[^>]+>(?<interior_color>[^<]+)/i',
//             'stock_number'   => '/Stock No:[^>]+>[^>]+>[^>]+>(?<stock_number>[^<]+)/i',
//             'body_style'     => '/Body Style:[^>]+>[^>]+>[^>]+>(?<body_style>[^<]+)/i',
//             'description'    => '/<meta name="description" content="(?<description>[^<]+)/i',
//         ];

//         $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

//         return $cars;
//     }
//); -->
