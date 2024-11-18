<?php
global $scrapper_configs;
 $scrapper_configs["truckfindersca"] = array( 
  'entry_points' => array(
       
        'used' => 'https://truckfinders.ca/wp-admin/admin-ajax.php?action=ajax_custom_search&cps_use_ajax=1&page=1',
      //  'certified'=>'http://www.georgianchevrolet.com/VehicleSearchResults?search=certified'
       
    ),
    'srp_page_regex' => '/\/inventory\//i',
    'vdp_url_regex' => '/\/[0-9]{4}-/i',
    
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
    
    // 'details_start_tag' => '<ul each="cards">',
    // 'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="result-car">',
     'data_capture_regx' => array(
           //'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
           // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
           'year'              => '/class="vehicle-name"><span class="mini-hide"><\/span>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
           'make'              => '/class="vehicle-name"><span class="mini-hide"><\/span>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
           'model'             => '/class="vehicle-name"><span class="mini-hide"><\/span>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)/',
           'kilometres'        => '/vehicle-miles[^>]+>\s*(?<kilometres>[^\s<]+)/',
           'body_style'        => '/vehicle-secondary-info">(?<body_style>[^\|]+)/',
           'transmission'      => '/vehicle-secondary-info">[^\|]+\|\s*(?<transmission>[^<]+)/',
           'url'               => '/class="result-car-link"\s*href="(?<url>[^"]+)/',
           'price'             => '/<span class="price">(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
           'vin'               => '/VIN:<\/p>\s*(?<vin>[^<]+)/',
           'stock_number'      => '/Stock:<\/p>\s*(?<stock_number>[^<]+)/',
           'drivetrain'        => '/Drive:<\/p>\s*(?<drivetrain>[^<]+)/',
           'exterior_color'    => '/Drive:<\/p>\s*(?<exterior_color>[^<]+)/',
            'description'    => 'description":"(?<description>[^"]+)/'
            


       ),
         'next_query_regx'        => '/convertUrl\s*current\'>[^>]+><a href=\'javascript\:manual_hashchange[^"]+"\%23search\%2F(?<param>page)[^\']+\'\s*class=\'convertUrl\s*\'>(?<value>[0-9]*)/',
        'images_regx'           => '/<a class="gallery" href="(?<img_url>[^"]+)/',
       
);