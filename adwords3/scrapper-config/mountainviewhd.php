<?php
global $scrapper_configs;
 $scrapper_configs["mountainviewhd"] = array( 
	 'entry_points' => array(
        
        'used' => 'https://mountainviewhd.com/inventory?condition=preowned',
        'new'  => 'https://mountainviewhd.com/new-inventory',
       
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',

    'use-proxy' => true,
     'refine'   => false,
    
    'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'details_start_tag'    => '<ul id="inventoryBikesList"',
       'details_end_tag'   => '<div class="list-pagination">',
       'details_spliter'   => '<li class="inventoryList-bike">',

       'data_capture_regx' => array(
           'stock_number'      => '/Stock number:<\/td><td>(?<stock_number>[^<]+)/',
            //'stock_type'        => '/Condition:\s*(?<stock_type>[^"]+)/',
           'year'              => '/Year:<\/td><td>(?<year>[^<]+)/',
           'make'              => '/class="inventoryList-bike-details-title">[^>]+>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)/',
           'model'             => '/class="inventoryList-bike-details-title">[^>]+>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+)/',
           'url'               => '/class="inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)"/',
           'price'             => '/inventoryList-bike-details-price ">(?<price>[^<]+)/',
           'kilometres'        => '/Mileage:<\/td><td>(?<kilometres>[^<]+)/',
           'exterior_color'    => '/Colour:<\/td><td>(?<exterior_color>[^<]+)/',
           
           'vin'               => '/Stock number:<\/td><td>(?<vin>[^<]+)/',
         
       ),
       'data_capture_regx_full' => array(
           
           'vin'               => '/VIN number:<\/td>\s*<td>(?<vin>[^<]+)/',
       ),
       'next_page_regx'        => '/<a href="(?<next>[^"]+)" title="Next page"/',
        'images_regx'           => '/data-gallery="inventoryGallery" data-lightbox[^"]+"(?<img_url>[^"]+)"/',
        
   );
    