<?php

    global $scrapper_configs;

    $scrapper_configs['crossline'] = array(
        'entry_points' => array(
            'used' => 'https://www.firstlineauto.com/used-cars'
        ),
        'vdp_url_regex'     => '/\/(?:new|used)/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        
        'details_start_tag' => '<div class="vehicle search-result-item vehicleList">',
        'details_end_tag'   => '<footer',
        'details_spliter'   => 'row padding-left-20',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)">\s*<h3\sclass="vehicleName".*\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s\s(?<model>[^\s]+)[^\n]+)/',
            'title'         => '/<a href="(?<url>[^"]+)">\s*<h3\sclass="vehicleName".*\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s\s(?<model>[^\s]+)[^\n]+)/',
            'year'          => '/<a href="(?<url>[^"]+)">\s*<h3\sclass="vehicleName".*\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s\s(?<model>[^\s]+)[^\n]+)/',
            'make'          => '/<a href="(?<url>[^"]+)">\s*<h3\sclass="vehicleName".*\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s\s(?<model>[^\s]+)[^\n]+)/',
            'model'         => '/<a href="(?<url>[^"]+)">\s*<h3\sclass="vehicleName".*\s*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s\s(?<model>[^\s]+)[^\n]+)/',
            //'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/PriceValue PriceValueTop">\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/class="Kilometers">\s*(?<kilometres>[^<]+)/',
            'stock_number'  => '/Stock #:.*">(?<stock_number>[^<]+)/',
            'engine'        => '/Engine:<\/span><span.*">(?<engine>[^<]+)/',
            'body_style'    => '/Body Style:.*">(?<body_style>[^<]+)/',
            'transmission'  => '/Transmission:.*">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/span><span>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/span><span>(?<interior_color>[^<]+)/',
           // 'certified'     => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/',
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@Make:<\/span><span>(?<make>[^<]+)@',
            'model'         => '@Model:<\/span><span>(?<model>[^<]+)@',
            'body_style'    => '@Body Style:<\/span><span>(?<body_style>[^<]+)@',
            'kilometres'    => '@Kilometers:<\/span><span>(?<make>[^<]+)@',
//            'trim'          => '@"trim": "(?<trim>[^"]+)@'
        ) ,
        'next_page_regx'    => '/next page-numbers"\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/data-thumb=".*\s*<img.*src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/"og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter('filter_crossline_field_images', 'filter_crossline_field_images');
    function filter_crossline_field_images($im_urls)
    {
        slecho("Inside Image filter");
        return array_filter($im_urls, function ($url){
            return !contains('thumb_', $url);
        });
    }

