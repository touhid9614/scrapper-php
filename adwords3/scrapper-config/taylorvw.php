<?php
global $scrapper_configs;
 $scrapper_configs["taylorvw"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.taylorvw.ca/en/new-inventory?limit=500',
            'used'  => 'https://www.taylorvw.ca/en/used-inventory?limit=500'
        ),
            
             'picture_selectors' => ['.overlay img'],
        'picture_nexts'     => ['.bx-wrapper__small-next'],
        'picture_prevs'     => ['.bx-wrapper__small-prev'],
            'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
            'use-proxy'         => true,
            'details_start_tag' => '<article class="inventory-preview-beta__wrapper',
            'details_end_tag'   => '<span id="price-legal">',
            'details_spliter'   => '<div class="inventory-preview-beta__preview-ctas">',
            'data_capture_regx' => array(
                'stock_number'  => '/Inventory #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
                'title'         => '/<a class="__preview-name" href="(?<url>[^"]+)" title="(?<title>[^"]+)/',
                'year'          => '/desired_year=(?<year>[^"]+)/',
                'make'          => '/desired_make=(?<make>[^\&]+)/',
                'model'         => '/desired_model=(?<model>[^\&]+)/',
                'trim'          => '/desired_trim=(?<trim>[^"]+)/',
                'price'         => '/<div class="inventory-preview-beta__preview-price[^>]+>\s*(?<price>\$[0-9,]+)/',
                'kilometres'    => '/(?<kilometres>[0-9 ,]+)\s*KM/',
                'transmission'  => '/transmission"[^\n]+\s*<span>(?<transmission>[^<]+)/',
                'url'           => '/<a class="__preview-name" href="(?<url>[^"]+)" title="(?<title>[^"]+)/'
            ),
            'data_capture_regx_full' => array(
                'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
                //'engine'        => '/engine-type">\s*[^\n]+\s*(?<engine>[^\n]+)/',
                
            ) ,
                   
            //'next_page_regx'    => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
            'images_regx'       => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
            
        
    
    
            
    );
  
   