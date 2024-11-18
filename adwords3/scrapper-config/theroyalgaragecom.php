<?php
global $scrapper_configs;
 $scrapper_configs["theroyalgaragecom"] = array( 
	 "entry_points" =>  array(
            'used' => 'https://www.theroyalgarage.com/used-inventory/index.htm',
            'new'  => 'https://www.theroyalgarage.com/new-inventory/index.htm',
    
        ),
     
        'vdp_url_regex'     => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.pswp__img'],
        'picture_nexts'     => ['.pswp__button--arrow--right'],
        'picture_prevs'     => ['.pswp__button--arrow--left'],
     
     
     'new'   => array(     
        'details_start_tag' => '<ul class="inventoryList data',
        'details_end_tag'   => '<div  class="ddc-footer"',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
         //   'title'         => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/Discounted Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/',         
            'stock_number'  => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Colou?r:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Colou?r:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
          
        ),
        'data_capture_regx_full' => array(        
            'make'          => '@make\: \'(?<make>[^\']+)\'@',
            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim'          => '@"trim": "(?<trim>[^"]+)@',  
            'vin'           => '/"vin": "(?<vin>[^"]+)/',
        'drivetrain'    => '/driveLine": "(?<drivetrain>[^"]+)/',
        'fuel_type'     =>  '/fuelType": "(?<fuel_type>[^"]+)/',
        'transmission' => '/transmission": "(?<transmission>[^"]+)/',
        ) ,
       
        'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
     ),
    'used'   => array(
        'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled',
        'details_end_tag'   => '<div  class="ddc-footer"',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)"\s*class="url">/', 
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/Price\s*[^>]+>:[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
  
        ),
        'data_capture_regx_full' => array(        
            'kilometres'    => '/>Odometer[^>]+>[^>]+>[^>]+>(?<kilometres>[^\<]+)/',
            'stock_number'  => '/Stock: \s*[^>]+>(?<stock_number>[^\<]+)/',
            'engine'        => '/>Engine:\s*(?<engine>[^<]+)/',
            'body_style'    => '/>Body[^>]+>[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'transmission'  => '/>Transmission:\s*(?<transmission>[^\<]+)/',
            'exterior_color'=> '/Exterior Colour<\/dt>[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
            'interior_color'=> '/Interior Colour<\/dt>[^>]+>[^>]+>[^>]+>[^>]+>(?<interior_color>[^\<]+)/',
        ) ,
       
        'next_page_regx'    => '/rel="next"\s*href="(?<next>[^"]+)" class="btn btn-xsmall btn-xs next-btn"[^>]+>\s*[^>]+>[^>]+>\s*Next/',
        'images_regx' => '/id[^"]+"[^"]+"src[^"]+"[^"]+"(?<img_url>[^"]+)[^"]+"[^"]+"thumbnail/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    ),

     
     );
  