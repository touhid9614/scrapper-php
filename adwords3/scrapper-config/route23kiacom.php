<?php
global $scrapper_configs;
$scrapper_configs["route23kiacom"] = array( 
	"entry_points" => array(
        'new' => 'https://www.route23kia.com/inventory?type=new&pg=1&limit=500',
        'used' => 'https://www.route23kia.com/inventory?type=used&pg=1&limit=500'
    ),
       'vdp_url_regex'     => '/\/vehicle-details\//i',
        
         'use-proxy' => true,
        
        'picture_selectors' => ['.magic-thumb'],
        'picture_nexts'     => ['.mz-button.mz-button-next'],
        'picture_prevs'     => ['.mz-button.mz-button-prev'],
        
        'details_start_tag' => '<div class="srp-vehicle-container" >',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="row srp-vehicle" itemprop="offers"',
    
        'data_capture_regx' => array(
            'url'           => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
            'title'         => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'year'          => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'make'          => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'model'         => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
            'stock_number'  => '/<span>Stock:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'price'         => '/Special Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
            'exterior_color'=> '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
            'engine'        => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
            'kilometres'    => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
           
        ),
        'data_capture_regx_full' => array(          
           
            
        ),
      
        'images_regx'       => '/vehicleGallery" href="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)"/'
    );