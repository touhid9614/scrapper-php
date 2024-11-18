<?php
global $scrapper_configs;
 $scrapper_configs["haasnissan"] = array( 
	 'entry_points' => array(
           
            'used'      => 'https://www.haasnissan.com/en/used-inventory',
             'new'       => 'https://www.haasnissan.com/en/new-inventory',
            
        ),
        'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
        'ty_url_regex'      => '/\/en\/thank-you/i',
        'use-proxy' => true,
     
        'picture_selectors' => ['div.slick-slide img'],
        'picture_nexts'     => ['.widget-ninjabox__bxslider-controls--next'],
        'picture_prevs'     => ['.widget-ninjabox__bxslider-controls--prev'],
     
        
        'details_start_tag' => '<div class="inventory-listing__vehicles',
        'details_end_tag'   => '<p class="inventory-listing__disclaimer smallprint"',
        'details_spliter'   => '<article class="inventory-list-layout',
        'data_capture_regx' => array(
            
            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="[^"]+"\s*title="[^>]+>\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'price'         => '/inventory-list-layout__preview-price-current[^>]+>[^>]+>\s[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',          
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Inventory #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'vin'           => '/Inventory #[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
            'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
            'transmission'  => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:<\/div>[^>]+>(?<kilometres>[^<]+)/',
           
        ),
        'next_page_regx'    => '/<a class="pagination__page-arrows-text " href="(?<next>[^"]+)"[^>]+>[^"]+"simple/',
       'images_regx'           => '/<span class="catalog-photo-exterior">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
  add_filter('filter_haasnissan_field_model', 'filter_haasnissan_field_model');
  function filter_haasnissan_field_model($model)
    {
       return  str_replace('...', '', $model);
    }
    
    add_filter("filter_haasnissan_field_images", "filter_haasnissan_field_images",10,2);

     function filter_haasnissan_field_images($im_urls,$car_data)
    {
          
    if(isset($car_data['url']) && $car_data['url'])
    {   
       $id=explode("id",$car_data['url']);
       $api_url="https://www.haasnissan.com/en/inventory/used/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
       $response_data = HttpGet($api_url);
       $regex       =  '/<img src="(?<img_url>[^"]+)" alt=/';
        
        $matches = [];
       
        
        if(preg_match_all($regex, $response_data, $matches)) {
           
            foreach ($matches['img_url'] as $key => $value)
            {
               $im_urls[]=$value;
            }
             
            
        }      
             
        
    }
    
     return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'no-photo1565034281032.jpg');
        });
    
    
    }
  