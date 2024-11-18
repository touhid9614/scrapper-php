<?php
global $scrapper_configs;
$scrapper_configs["evcitykiwi"] = array( 
	"entry_points" => array(
		 'used'  => 'https://www.evcity.kiwi/vehicles',
        ),
        'vdp_url_regex'     => '/\/vehicle\/[0-9]{4}-/i',  
        'use-proxy' => true,
        'picture_selectors' => ['.vehicle_show img'],
        'picture_nexts'     => ['.right.next'],
        'picture_prevs'     => ['.prev.left'],
        
        'details_start_tag' => '<div class="row vehicle-results gallery">',
        'details_end_tag'   => '<footer>',
        'details_spliter'   => '<li class="vehicle">',     
        'data_capture_regx' => array(
            'url'           => '/div class="small-10 columns">\s*<a href="(?<url>[^"]+)">/',
            'year'          => '/<h6 class="small-12 columns"\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'make'          => '/<h6 class="small-12 columns"\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'model'         => '/<h6 class="small-12 columns"\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'price'         => '/<span class="amount">(?<price>\$[0-9,]+)/',
           
         ),
        'data_capture_regx_full' => array(

            'engine'        => '/Engine<\/div>\s*<[^>]+>(?<engine>[^<]+)/',
		    'kilometres'    => '/Odometer<\/div>\s*<[^>]+>\s*(?<kilometres>[^\s*]+)/',
            'stock_number'  => '/Stock#\s*(?<stock_number>[^\s*]+)/',
            'exterior_color'=> '/Ext Colour<\/div>\s*<[^>]+>\s*(?<exterior_color>[^<]+)/',
		    'transmission'  => '/Transmission<\/div>\s*<[^>]+>\s*(?<transmission>[^\s*]+)/',
            'interior_color'=> '/Interior<\/div>\s*<[^>]+>\s*(?<interior_color>[^,]+)/',
          
            
        ),
     'next_page_regx'    => '/<a class="btn-numerics"[^>]+>[^>]+><a class="btn-next" href="(?<next>[^"]+)"/',
        'images_regx'       => '/onclick="openPSGallery[^>]+>\s*<img src="(?<img_url>[^"]+)"/',
        'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
