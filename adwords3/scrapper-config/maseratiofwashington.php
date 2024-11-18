<?php
    global $scrapper_configs;

    $scrapper_configs['maseratiofwashington'] = array(

        'entry_points' => array(
                'new' => 'https://www.maseratiofwashington.com/searchnew.aspx',
                'used'=> 'https://www.maseratiofwashington.com/searchused.aspx'
        ),
        'vdp_url_regex'       => '/\/(?:new|used)-Washington\+DC-[0-9]{4}-/i',
        'ty_url_regex'        => '/\/thankyou.aspx/i',
        'use-proxy'           => true,
        'picture_selectors' => ['.carousel__item'],
        'picture_nexts'     => ['.carousel__control--next'],
        'picture_prevs'     => ['.carousel__control--prev'],
        
        'details_start_tag'   => '<div class="row srpVehicle">',
        'details_end_tag'     => '<div class="row srpDisclaimer">',
        'details_spliter'     => '<div id="srpRow-',

        'data_capture_regx' => array(
            'url'              => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^\s]*))/',
            'title'            => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^\s]*))/',
            'year'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^\s]*))/',
            'make'             => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^\s]*))/',
            'model'            => '/data-model=\'(?<model>[^\']+)/',
            'body_style'       => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
            'transmission'     => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
            'engine'           => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
            'exterior_color'   => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'   => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
            'stock_number'     => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
            'kilometres'       => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
            'price'            => '/<li class="priceBlockItem priceBlockItemPrice"\s*><span[^>]+>(?:Internet Price\:|Price\:)\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',

            ),
        'data_capture_regx_full' => array(
            'make'             => '/brand":\s*"(?<make>[^"]+)/',
            'model'            => '/model":\s*"(?<model>[^"]+)/',
            'trim'      => '/var vehicleTrim="(?<trim>[^"]+)/',
        
        ),
   
        'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
        'images_regx'   => '/carousel__item[^>]+><img src="(?<img_url>[^"]+)/'
    );

     add_filter("filter_maseratiofwashington_field_images", "filter_maseratiofwashington_field_images");

        function filter_maseratiofwashington_field_images($im_urls)
        {
            return array_filter($im_urls, function($im_url){
                return !endsWith($im_url, 'photo_unavailable_320.gif');
            });
        }


