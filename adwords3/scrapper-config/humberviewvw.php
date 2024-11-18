<?php
global $scrapper_configs;
 $scrapper_configs["humberviewvw"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.humberviewvw.com/en/for-sale/car/new',
            'used'  => 'https://www.humberviewvw.com/en/for-sale/car/used'
        ),
        'vdp_url_regex'     => '/\/en\/inventory\/(?:new|used)\/vehicle\//i',
        'ty_url_regex'      => '/\/en\/thank-you/i',
        'use-proxy' => true,
        'picture_selectors' => ['.catalog-vehicle-details__gallery-thumbnails'],
///       'picture_selectors' => ['.bx-wrapper img '],
        'picture_nexts'     => ['.bx-next'],
        'picture_prevs'     => ['.bx-prev'],
        
        'details_start_tag' => '<div class="inventory-listing__vehicles',
        'details_end_tag'   => '<ul class="pagination">',
        'details_spliter'   => '<article class="inventory-list-layout',
        'data_capture_regx' => array(
            
            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'price'         => '/inventory-list-layout__preview-price-current"[^>]+>\s*(?<price>\$[0-9,]+)/',          
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Inventory #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
            'transmission'  => '/inventory-vehicle-details__header-transmission\">\s*<span>(?<transmission>[^<]+)<\/span>/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
           
        ),
        'next_page_regx'    => '/<li class="pagination__page-button pagination__page-button--selected".*\s*<a[^>]+>\s*.*\s*<\/li>\s*<li[^>]+>\s*<a class="[^"]+" href="(?<next>[^"]+)/',
        'images_regx'       => '/inventory-details__header-image">\s*<img src="(?<img_url>[^"]+)/',
        
    );
    
    add_filter("filter_humberviewvw_field_images", "filter_humberviewvw_field_images");
    
    function filter_humberviewvw_field_images($im_urls)
    {
        
        $im_urls = array_filter($im_urls, function($photos){
                    return !contains('w121h78c', $photos);
                  });
        $retval = array();

        foreach($im_urls as $url) {
            $retval[] = str_ireplace(['w376h250','w200h125c'], 'w560h400', $url);
           
        }
        //if(count($retval) < 2) return [];
        return array_values(array_unique($retval));
    }