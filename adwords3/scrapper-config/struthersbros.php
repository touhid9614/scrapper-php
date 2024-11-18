<?php

global $scrapper_configs;

$scrapper_configs['struthersbros'] = array(
    'entry_points' => array(
        
        'used' => 'https://www.struthersbros.com/--xAllInventory?condition=pre-owned&pg=1',
        'new'  => 'https://www.struthersbros.com/--xAllInventory?condition=new&sz=50&pg=1',
       
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
     'srp_page_regex'      => '/condition=(?:new|used|pre-owned)/i',
    'use-proxy' => true,
    'refine'=>false,
    
    'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'details_start_tag'    => '<ul class="v7list-results__list">',
       'details_end_tag'   => '<div class="v7list-footer">',
       'details_spliter'   => '<li class="v7list-results__item"',

       'data_capture_regx' => array(
           'stock_number'      => '/Stock Number:\s*(?<stock_number>[A-Za-z0-9]+)"/',
            //'stock_type'        => '/Condition:\s*(?<stock_type>[^"]+)/',
           'year'              => '/vehicle-heading__year">(?<year>[0-9]{4})/',
           'make'              => '/vehicle-heading__name">(?<make>[^<]+)/',
           'model'             => '/vehicle-heading__model">(?<model>[^<]+)/',
           'url'               => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
           'price'             => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',  
           'exterior_color'    => '/Color:[^>]+>(?<exterior_color>[^<]+)/',
           'fuel_type'         => '/Fuel Type:[^>]+>(?<fuel_type>[^<]+)/',
           'drivetrain'        => '/Vehicle Type:[^>]+>(?<drivetrain>[^<]+)/',
           'engine'            => '/Category:[^>]+>(?<engine>[^<]+)/',
           'body_style'        => '/Category:[^>]+>(?<body_style>[^<]+)/',
           'vin'               => '/Vin:\s*(?<vin>[^"]+)/',
         
       ),
       'data_capture_regx_full' => array(
           'kilometres'        => '/Odometer[^>]+>\s*[^>]+>(?<kilometres>[^\s]+)/',
           'description'      => '/<meta name="description" content="(?<description>[^"]+)/',

       ),
       'next_page_regx'        => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results" >/',
        'images_regx'           => '/lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
        
   );
    
     add_filter("filter_struthersbros_next_page", "filter_struthersbros_next_page",10,2);
      add_filter("filter_struthersbros_field_images", "filter_struthersbros_field_images");
      
    
       function filter_struthersbros_next_page($next,$current_page) {
           
           slecho($current_page);
          $next=explode('/',$next);
           $index=count($next)-1;
           $next=($next[$index]);
           $next++;
           $peg="pg=" . $next;
           $prev="pg=" . ($next-1);
           $url= str_replace($prev, $peg, $current_page);
           
            return $url;
           
   }
   
   
   function filter_struthersbros_field_images($im_urls)
    {
       $retval = array();

        foreach($im_urls as $url) {
            
             
              $url=str_replace('https://www.struthersbros.com/', '', $url);
            $retval_im[] = str_replace('&#x2F;', '/', $url);
           
           
        }
        
        return $retval_im;

    }