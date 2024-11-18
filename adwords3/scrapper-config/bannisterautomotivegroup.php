<?php
    global $scrapper_configs;

    $scrapper_configs['bannisterautomotivegroup'] = array(
        'entry_points' => array(
            'new'   => 'http://www.bannisterautomotivegroup.com/new-vehicles/new-inventory',
            'used'  => 'http://www.bannisterautomotivegroup.com/pre-owned-vehicles/used-inventory'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|preowned)\//i',
        
        'use-proxy' => true,
        'picture_selectors' => ['#bx-pager img'],
        'picture_nexts'     => ['.bx-next'],
        'picture_prevs'     => ['.bx-prev'],
        
        'details_start_tag' => '<div id="car_list"',
        'details_end_tag'   => '<div id="home-footer-content">',
        'details_spliter'   => '<div class="appitem',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock\s*#:<\/strong>\s*(?<stock_number>[^<]+)/',
            'year'          => '/<h3><a href="[^"]+">\s*(?<year>[0-9]{4})\s*(?<make>[^<]+)<[^>]+>(?<model>[^\s]*)\s*(?<trim>[^<]*)/',
            'make'          => '/<h3><a href="[^"]+">\s*(?<year>[0-9]{4})\s*(?<make>[^<]+)<[^>]+>(?<model>[^\s]*)\s*(?<trim>[^<]*)/',
            'model'         => '/<h3><a href="[^"]+">\s*(?<year>[0-9]{4})\s*(?<make>[^<]+)<[^>]+>(?<model>[^\s]*)\s*(?<trim>[^<]*)/',
            'price'         => '/<h2 class="price".*>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Odometer:<\/strong>\s*(?<kilometres>[^<]+)/',
            'url'           => '/<a.*\s*href="(?<url>[^"]+)".*">DETAILS/',
           
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine:<\/span><span[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/span><span[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/span><span[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/span><span[^>]+>(?<interior_color>[^<]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            
            
        ),

       
        'next_page_regx'    => '/currentPage active numbers"><strong>[0-9]*<\/strong><\/span><span class=" numbers"><a href="(?<next>[^"]+)/',
        'images_regx'       => '/<li><a href="(?<img_url>[^"]+)"><img/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]*)/'
    );
    
    add_filter("filter_bannisterautomotivegroup_field_images", "filter_bannisterautomotivegroup_field_images");
    
    function filter_bannisterautomotivegroup_field_images($im_urls)
    {
       return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'dummy_car.jpg');
        });
    }
    