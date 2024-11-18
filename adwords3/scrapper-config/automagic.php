<?php
global $scrapper_configs;
 $scrapper_configs["automagic"] = array( 
	 'entry_points' => array(
        'new'  => 'https://www.automagic.center/inventory',
        
    ),
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-[a-zA-Z]+-/',

    'use-proxy' => true,
     
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
    
    'details_start_tag'    => '<ul class="inventory text-',
    'details_end_tag'   => '<!-- car listing ends here-->',
    'details_spliter'   => '<li class="prod-box">',
        
    'data_capture_regx' => array(
        'kilometres'        => '/Mileage:<\/span>[^>]+>(?<kilometeres>[^<]+)/',
        'year'              => '/<li class="title">\s*<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make'              => '/<li class="title">\s*<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model'             => '/<li class="title">\s*<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'url'               => '/<li class="title">\s*<a href="(?<url>[^"]+)">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'price'             => '/<div class="price">\s*<h4>(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'exterior_color'   => '/Exterior color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'engine'         => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission'   => '/Transmission:<\/span>\s*[^>]+>(?<transmission>[^<]+)/',
        'stock_number'   => '/Stock number:<\/span>\s*[^>]+>(?<stock_number>[^<]+)/',
    ),
    'next_page_regx'    => '/<a rel="next" href="(?<next>[^"]+)"/',
    'images_regx'       => '/<li>\s*<a [^>]+><img\s*align=""\s*alt=".*"\s*src="(?<img_url>[^"]+)"/',
    );
    
    
    