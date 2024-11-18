<?php
global $scrapper_configs;
 $scrapper_configs["huntclubvw"] = array( 
	  'entry_points' => array(
        'new'   => 'https://huntclubvw.com/en/new',
        'used'  => 'https://huntclubvw.com/en/used-inventory'
    ),
    'use-proxy' => true,
    'vdp_url_regex'     => '/\/en\/(?:inventory\/)?(?:new|used)/i',
    'ty_url_regex'      => '/\/thank-you/i',
    'ajax_url_match'    => '/confirm-availability/',
    'ajax_resp_match'   => 'Thank You For Your Inquiry - MacDonald Auto Group',
    
    'picture_selectors' => ['.image-select li a','#bxslider-pager a'],
    'picture_nexts'     => ['','#cboxNext'],
    'picture_prevs'     => ['','#cboxPrevious'],
    'new'   => array(
            'details_start_tag' => '<div id="catalog-listing__volkswagen"',
            'details_end_tag'   => '<p class="catalog-listing__disclaimer',
            'details_spliter'   => '<div class="catalog-block__wrapper',
            'data_capture_regx' => array(
                'url'           => '/class="catalog-block__name-anchor" href="(?<url>[^"]+)"/',
                //'title'         => '/<span class="vehicle-title">(?<title>[^<]+)/',       
                'year'          => '/data-year="(?<year>[^"]+)/',
                 'make'          => '/data-make="(?<make>[^"]+)/',
                'model'         => '/data-model="(?<model>[^"]+)/',
                 'body_style'    => '/data-bodystyle="(?<body_style>[^"]+)/',
                'price'         => '/class="showroom-price__price--regular"\s*[^>]+>\s*(?<price>[^\s]+)/',
               
            ),
            'data_capture_regx_full' => array(
               // 'make'          =>'/<div class="title" itemprop="name">(?<make>[^ ]+) (?<model>[^<]+)/',
               // 'model'         =>'/<div class="title" itemprop="name">(?<make>[^ ]+) (?<model>[^<]+)/',
               // 'year'          =>'/<div class="subtitle" itemprop="releaseDate">(?<year>[^<]+)/',
                //'exterior_color'=>'/<div class="color-index">(?<exterior_color>[^<]+)/',
               // 'interior_color'=>'/<li>\s*(?<interior_color>[^ ]+) interior/',
              //  'transmission'  => '/<li>\s*(?<transmission>[^t]+) transmission/'
            ) ,
                            
            'images_regx'           => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
            'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
        ),
    'used'   => array(
            'details_start_tag' => '<section class="page-content__right">',
            'details_end_tag'   => '<p class="inventory-listing__disclaimer',
            'details_spliter'   => '<article class="inventory-list-layout-wrapper',
           // 'must_contain_regx' => '/Stock #:[^>]+>[^>]+>(?<stock_number>1-[0-9]*[aA])/',
            'data_capture_regx' => array(
              //  'stock_number'  => '/<span class="vehicle-stockno"\s*itemprop="sku">#(?<stock_number>[^<]+)/',
                'title'         => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
                'year'          => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
                'make'          => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
                'model'         => '/preview-name" href="[^"]+" title="(?<title>(?<year>[^\s]+) (?<make>[^\s]+) (?<model>[^\s]+))/',
                'price'         => '/vehicle__rebate" data-theme-style="utilBlackColor__color">\s*(?<price>[^<]+)/',
                'kilometres'    => '/vehiclePreview_secondaryColor">(?<kilometres>[0-9 ,]+)\s*/',
                'url'           => '/preview-name" href="(?<url>[^"]+)/'
            ),
            'data_capture_regx_full' => array(
                'stock_number'  => '/Inventory #:<\/div>\s*[^>]+>(?<stock_number>[^<]+)/',
               // 'transmission'  => '/<span class="clutch">(?<transmission>[^<]+)/',
                'body_style'    => '/Bodystyle:<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
                'engine'        => '/Cylinders:<\/div>\s*[^>]+>(?<engine>[^<]+)/',
                'exterior_color'=> '/Ext\. Color:<\/div>\s*[^>]+>(?<exterior_color>[^<]+)/',
                'interior_color'=> '/Int\. color:<\/div>\s*[^>]+>(?<interior_color>[^<]+)/',
            ) ,
                   
             'next_page_regx'    => '/pagination__page-button-text--selected"[^\n]+\s*[^\n]+\s*[^\n]+\s[^\n]+\s*<li[^>]+>\s.*href="(?<next>[^"]+)/',
             'images_regx'           => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)/',
            'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
        ),
                
    );