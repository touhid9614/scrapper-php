<?php
global $scrapper_configs;
 $scrapper_configs["countrytruck"] = array( 
	'entry_points' => array(
            'used'   => 'https://www.countrytruck.net/inventory',
            
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
       
        'use-proxy' => true,
    
        
        'picture_selectors' => ['#myPhotoCarousel5 div div img'],
        'picture_nexts'     => ['.carousel-control.right'],
        'picture_prevs'     => ['.carousel-control.left'],
        'details_start_tag' => '<div class="dealr-elist-',
        'details_end_tag'   => '<div id="scroll-to-top-button"',
        'details_spliter'   => '<div class="dealr-entry desktop-view">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock<\/td>[^>]+>(?<stock_number>[^<]+)/',
            'vin'  => '/Stock<\/td>[^>]+>(?<vin>[^<]+)/',
            'url'           => '/<a class="title-container" href="(?<url>[^"]+)/',
            'year'          => '/<h4>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'make'          => '/<h4>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'model'         => '/<h4>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'price'         => '/<div class="price-container  ">\s*(?<price>\$[0-9,]+)/',
            'drivetrain'    => '/Drivetrain<\/td>\s.*">(?<drivetrain>[^<]+)/',
            'kilometres'    => '/Mileage<\/td>\s.*">(?<kilometres>[^<]+)/',
            'exterior_color'=> '/Exterior<\/td>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior<\/td>[^>]+>(?<interior_color>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
           // 'make'     => '/ctl02_ctl06_ctl00_lblMake">(?<make>[^<]+)/',
            //'model'    => '/ctl02_ctl06_ctl00_lblModel">(?<model>[^<]+)/',
            'description'   => '/Description<\/div>\s.*<p><strong>(?<description>[^<]+)/',
        ),
       // 'next_query_regx'    => '/dxp-num dxp-current">[^\/]+\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl04\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
        'images_regx'       => '/<img class="smallscreen-image"[^"]+"[^"]+" src="(?<img_url>[^\?]+)/'
    );
    