<?php

global $scrapper_configs;
$scrapper_configs["empireautogroupca"] = array(
            'entry_points' => array(
                'used' => 'https://empireautogroup.ca/inventory.php',
            ),
            'vdp_url_regex' => '/\/vehicle-details/i',
            'required_params' => array('stk'),
            'use-proxy' => true,  
       	    'details_start_tag' => '<div class="b-goods-group row">',
            'details_end_tag' => '<nav class="mt-3 mb-5" aria-label="Page navigation example"',        
            'details_spliter' => '<div class="col-lg-4 col-md-6">',
            'data_capture_regx' => array(
                'url' => '/<a class="b-goods__title" href="(?<url>[^"]+)/',
            ),
            'data_capture_regx_full' => array(
                'engine' => '/ENGINE[^>]+>[^>]+>(?<engine>[^<]+)/',
                'transmission' => '/TRANSMISSION[^>]+>[^>]+>(?<transmission>[^<]+)/',
                'kilometres' => '/MILEAGE[^>]+>[^>]+>(?<kilometres>[0-9,]+)/',
                'vin'          => '/>VIN[^>]+>[^>]+>(?<vin>[^<]+)/',
                'year' => '/ui-title text-uppercase">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
                'make' => '/ui-title text-uppercase">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
                'model' => '/ui-title text-uppercase">(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
                'price' => '/Driveaway Price[^\$]+(?<price>\$[^<]+)/',
                'exterior_color' => '/COLOR[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
                'stock_number'  => '/STOCK[^>]+>[^>]+>(?<stock_number>[^<]+)/',
                'body_style' => '/BODY[^>]+>[^>]+>(?<body_style>[^<]+)/',
                
            ),
            'next_page_regx' => '/class="page-link" id="nxt" href="(?<next>[^"]+)/',
            'images_regx' => '/style="background: url\((?<img_url>[^\(]+)\)/',
);
