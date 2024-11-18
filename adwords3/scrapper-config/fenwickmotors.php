<?php

    global $scrapper_configs;

    $scrapper_configs['fenwickmotors'] = array(
        'entry_points' => array(
            'new'  => 'http://www.fenwickmotors.com/new-inventory/index.htm',
            'used' => 'http://www.fenwickmotors.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        //'proxy-area'        => 'FL',
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext'],
        'picture_prevs'     => ['.imageScrollPrev'],
        
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)/',
            'title'         => '/class="url"\s*href="[^>]+>\s*(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/class="url"\s*href="[^"]+">\s*[0-9]{4}\s*[^\s]+\s*[^\s]+\s*(?<trim>[^<]+)/',
            'price'         => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Kilometres:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock #\:<\/dt>\s*<dd>[^\:]+\:<\/dt>\s*<dd>(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colour:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/<dt>Interior Colour:<\/dt>\s*<dd>(?<interior_color>[^<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            //'body_style' => '@bodyStyle: \'(?<body_style>[^\']+)@',
//            'trim' => '@"trim": "(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<a href="(?<img_url>[^\"]+)\"\s*class="js-link">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^\"]+)\"/'
    );
  
    add_filter('filter_fenwickmotors_car_data', 'filter_fenwickmotors_car_data');
    
    function filter_fenwickmotors_car_data($car_data) 
    {
        //taking all cars except Corvette
        if($car_data['stock_type']=="new") 
        {
            slecho("body_dtyle not available");
            $car_data['body_style']=null;
        }

        
        return $car_data;
    }