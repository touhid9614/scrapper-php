<?php

global $scrapper_configs;

$scrapper_configs['matthewsfordbacom'] = array(
    'entry_points' => array(
            
             'new'   => 'https://www.matthewsfordba.com/searchnew.aspx', 
             'used'  => 'https://www.matthewsfordba.com/searchused.aspx',
     ),
        'vdp_url_regex'     => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
        'use-proxy' => true,
        
        'picture_selectors' => ['.carousel__item.js-carousel__item img'],
        'picture_nexts'     => ['.js-carousel__control--next'],
        'picture_prevs'     => ['.js-carousel__control--prev'],
        
        'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
        'details_end_tag'   => '<div class="row srpDisclaimer">',
        'details_spliter'   => '<div id="srpRow-',
        
        'data_capture_regx' => array(
            'url'              => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'title'            => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'year'             => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'make'             => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'model'            => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
            'price'            => '/(?:Price|Final Price:)\s*<\/span><span[^>]+>\$(?<price>[^<]+)/',
            'vin'              => '/VIN #: <\/strong><span>(?<vin>[^<]+)/',
            
        ),
        'data_capture_regx_full' => array(
           
            
        ) ,
        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'       => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
    );
   