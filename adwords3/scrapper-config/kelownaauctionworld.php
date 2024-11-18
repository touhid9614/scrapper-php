<?php
global $scrapper_configs;
 $scrapper_configs["kelownaauctionworld"] = array( 
	
    "entry_points" => array(
        'new' => 'https://www.kelownaauctionworld.com/components/report/presale/ajax/all/',
    ),
    'vdp_url_regex' => '/\/detail\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb img'],
    'picture_nexts' => ['.next'],
    'picture_prevs' => ['prev'],
     
    'details_start_tag' => '<tbody>',
        'details_end_tag'   => '</tbody>',
        'details_spliter'   => '<tr class="',
        
        'data_capture_regx' => array(
        
            'year'          => '/year number"><span>(?<year>[0-9]{4})/',
            'make'          => '/class="make">(?<make>[^<]+)/',
            'model'         => '/class="model">(?<model>[^<]+)/',
            'url'           => '/<a id="view_link[^"]+" class="" href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/VIN:<\/label>(?<stock_number>[^<]+)/',
            'price'         => '/MSRP:<\/label>(?<price>\$[0-9,]+)/',
            
       
            
            
        ),
       // 'next_query_regx'   => '/data-page=[0-9]* class=\'disabled number\'><a\s*href=#>[0-9]*<\/a><\/li><li\s*data-(?<param>[^=]+)=(?<value>[0-9]*)/',
        'images_regx'       => '/<a class="thumb" href="\/\/(?<img_url>[^"]+)"/',
    );
 