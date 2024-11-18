<?php
global $scrapper_configs;
 $scrapper_configs["westernmazda"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.westernmazda.com/en/new-inventory?limit=130',
            'used'  => 'https://www.westernmazda.com/en/used-inventory?limit=130'
        ),
            
             'picture_selectors' => ['.overlay img'],
        'picture_nexts'     => ['.bx-wrapper__small-next'],
        'picture_prevs'     => ['.bx-wrapper__small-prev'],
            'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
            'use-proxy'         => true,
     
            'details_start_tag' => '<div class="inventory-listing__vehicles',
            'details_end_tag'   => '<p class="inventory-listing__disclaimer smallprint"',
            'details_spliter'   => '<article class="inventory-list-layout',
     
            'data_capture_regx' => array(
            
            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'price'         => '/inventory-list-layout__preview-price-current[^>]+>\s*(?<price>\$[0-9,]+)/',          
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
            'data_capture_regx_full' => array(
                'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
                //'engine'        => '/engine-type">\s*[^\n]+\s*(?<engine>[^\n]+)/',
                
            ) ,
                   
            //'next_page_regx'    => '/<li class="current\s*test"><a href="[^"]+">[^<]+<\/a><\/li>\s*<li ><a href="(?<next>[^"]+)"/',
            'images_regx'       => '/<span class="overlay">\s*<img (?:class="[^"]+"|)\s*src="(?<img_url>[^"]+)/',
            
    );
  