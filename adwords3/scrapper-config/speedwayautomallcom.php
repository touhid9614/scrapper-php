<?php
global $scrapper_configs;
 $scrapper_configs["speedwayautomallcom"] = array( 
	 'entry_points' => array(
      
            'used'  => 'https://www.speedwayautomall.com/used-cars/'
        ),
        'vdp_url_regex'     => '/\/details-[0-9]{4}-/i',
        
        'use-proxy'         => true,
        'refine'=>false,
        'picture_selectors' => ['.swiper-slide'],
        'picture_nexts'     => ['.swiper-button-next'],
        'picture_prevs'     => ['.swiper-button-prev'],
        
        'details_start_tag' => '<div id="srp-vehicle-list',
        'details_end_tag'   => '<footer id="footer',
        'details_spliter'   => '<div class="srp-vehicle-title-wrapper',
        
        'data_capture_regx' => array(
            'stock_number'      => '/Stock #:<\/strong>\s*(?<stock_number>[^<]+)/',
            'year'              => '/<h2 class="ebiz-vdp-title color m-0"><a href=[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'make'              => '/<h2 class="ebiz-vdp-title color m-0"><a href=[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'model'             => '/<h2 class="ebiz-vdp-title color m-0"><a href=[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
            'price'             => '/Internet price[^>]+>\s*[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
            'engine'            => '/Engine:<\/strong>\s*(?<engine>[^<]+)/',
            'transmission'      => '/Transmission:<\/strong>\s*(?<transmission>[^<]+)/',
            'kilometres'        => '/Miles:<\/strong>\s*(?<kilometres>[^<]+)/',
            'exterior_color'    => '/Exterior:<\/strong>\s*(?<exterior_color>[^<]+)/',
            'interior_color'    => '/Interior:<\/strong>\s*(?<interior_color>[^<]+)/',
            'url'               => '/<h2 class="ebiz-vdp-title color m-0"><a href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Body Style :(?<body_style>[^<]+)/',
            'trim'          => '/InventoryTrimParam:\s*\'(?<trim>[^\']+)/',
            'make'          => '/InventoryMakeParam:\s*\'(?<make>[^\']+)/',
            'model'          => '/InventoryModelParam:\s*\'(?<model>[^\']+)/'
        ) ,
       'next_page_regx'    => '/<li class="active px-2[^>]+>[^>]+><[^>]+><a href="(?<next>[^"]+)"[^>]+>/',
        'images_regx'       => '/<div class="lightgallery-item" data-src="(?<img_url>[^"]+)/',
    );
