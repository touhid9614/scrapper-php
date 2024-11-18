<?php
global $scrapper_configs;
$scrapper_configs["mcdonaldnissancom"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.mcdonaldnissan.com/en/new-inventory?limit=200&page=1',
            'used'  => 'https://www.mcdonaldnissan.com/en/used-inventory?limit=200&page=1'
        ),
            
         'picture_selectors' => ['.overlay img'],
        'picture_nexts'     => ['.bx-wrapper__small-next'],
        'picture_prevs'     => ['.bx-wrapper__small-prev'],
            'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
            'use-proxy'         => true,
            'refine'=>false,
            'details_start_tag' => '<div class="inventory-listing__vehicles',
            'details_end_tag'   => '<span id="price-legal">',
            'details_spliter'   => '<article class="inventory-list-layout-wrapper',
            'data_capture_regx' => array(
                'stock_number'  => '/inventory-preview-juliette__preview-stock-number".*#\s*(?<stock_number>[^<]+)/',
                'year'          => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+))/',
                'make'          => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+))/',
                'model'         => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+))/',          
                'price'         => '/inventory-list-layout__preview-price-current[^>]+>\s*(?<price>\$[0-9,]+)/',             
                'url'           => '/<a class="inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+))/',
               
                ),
            'data_capture_regx_full' => array(
                  'kilometres'    => '/inventory-details__vehicle-info-value">(?<kilometres>[0-9 ,]+)/',
                  'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^\<]+)/',
                  'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^\<]+)/',
                  'model'         => '/data-desired-model="(?<model>[^"]+)"/',
                  'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',   
                  'transmission'  => '/>Transmission[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
               
            ) ,
  //     'next_page_regx'    => '/<a class="pagination__page-button-text " href="(?<next>[^"]+)"/',
         'images_regx'       => '/(?:overlay|inventory-details__header-main-picture--center)">\s*<img (?:class="[^"]+"|)\s*src="(?<img_url>[^"]+)"\s*alt="/',
            
    );
  
   add_filter("filter_mcdonaldnissancom_field_price", "filter_mcdonaldnissancom_field_price", 10, 3);
    function filter_mcdonaldnissancom_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho(" Price: $price");
        }
        
        $was_regex       =  '/vehiclePreview_priceBgColor[^>]+>(?<price>\$[0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($was_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Was: {$matches['price']}");
        }
       
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }