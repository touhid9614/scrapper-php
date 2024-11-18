<?php

global $scrapper_configs;
$scrapper_configs["okanagandrivescom"] = array(
    'entry_points' => array(      
        'used' => 'https://okanagandrives.com/vehicles/'
    ),
     'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
      'srp_page_regex'       => '/\/vehicles\//i',
        'use-proxy'         => true,
     'refine'         => false,
    'picture_selectors' => ['.img-fluid'],
    'picture_nexts' => ['.slick-next'],
    'picture_prevs' => ['.slick-prev'],
        'details_start_tag' => '<div id="vehicle-results-container',
        'details_end_tag'   => '<footer id="',
        'details_spliter'   => '<div class="vehicle p-2"',
        'data_capture_regx' => array(
        
            'year'              => '/<h4>\s*<a class="[^"]+" href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ "]+)[^"]/',
            'make'              => '/<h4>\s*<a class="[^"]+" href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ "]+)[^"]/',
            'model'             => '/<h4>\s*<a class="[^"]+" href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ "]+)[^"]/',
            'price'             => '/d-inline-block mb-0">(?<price>[^<]+)/',
          //  'exterior_color'    => '/Exterior Colour[^>]+>\s*[^>]+>(?<exterior_color>[^&<]+)/',
            'url'               => '/<h4>\s*<a class="[^"]+" href="(?<url>[^"]+)">(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^ "]+)[^"]/',
           
        ),
        'data_capture_regx_full' => array(
            'stock_number'      => '/dsp_stock=(?<stock_number>[^\&]+)/',
            'body_style'        => '/Body[^>]+>\s*[^>]+>(?<body_style>[^&<]+)/',     
            'transmission'      => '/Transmission[^>]+>\s*[^>]+>\s*(?<transmission>[^&<]+)/',
             'kilometres'        => '/Kilometers:[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
            'exterior_color'    => '/Exterior:[^>]+>\s*[^>]+>(?<exterior_color>[^&<]+)/',
            'description'    => '/<meta property="og:description" content="(?<description>[^"]+)/',
        ),
        'next_page_regx'    => '/class="next page-numbers" href="(?<next>[^"]+)">Next/',
        'images_regx'       => '/<img\s*class="img-fluid[^"]+"\s*src="(?<img_url>[^"]+)/',
    );

    