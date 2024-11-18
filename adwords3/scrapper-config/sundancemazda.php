<?php
    global $scrapper_configs;

    $scrapper_configs['sundancemazda'] = array(
        'entry_points' => array(
            'new'       => 'https://www.sundancemazda.com/en/new-inventory/',
            'used'      => 'https://www.sundancemazda.com/en/used-inventory',
        ),
        
        'vdp_url_regex'     => '/\/en\/(?:new|used)-(?:inventory|catalog)\//i',
        'ty_url_regex'      => '/\/en\/thank-you/i',
        'use-proxy' => true,
     
        'picture_selectors' => ['div.slick-slide img'],
        'picture_nexts'     => ['.widget-ninjabox__bxslider-controls--next'],
        'picture_prevs'     => ['.widget-ninjabox__bxslider-controls--prev'],
        
        'details_start_tag' => '<div class="inventory-listing__vehicles',
        'details_end_tag'   => '<ul class="pagination">',
        'details_spliter'   => '<article class="inventory-list-layout',
        'data_capture_regx' => array(
            'stock_number'  => '/Inventory #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
               'vin' => '/Inventory #[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))/',
            'price'         => '/Available at<\/span>\s*(?<price>\$[0-9,]+)/',          
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'kilometres' => '/Mileage:<\/div>\s*[^>]+>(?<kilometres>[^<]+)/',
            'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
         //   'engine'        => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
            'transmission'  => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
           
        ),
        'next_page_regx'    => '/<a class="pagination__page-arrows-text\s"\shref="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
        'images_regx'       => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
 /*   add_filter("filter_sundancemazda_field_images", "filter_sundancemazda_field_images");

   
    
     function filter_sundancemazda_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'nophoto.jpg');
        });
    }
  
  * 
  */