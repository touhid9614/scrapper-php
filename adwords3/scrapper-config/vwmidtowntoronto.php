<?php
    global $scrapper_configs;

    $scrapper_configs['vwmidtowntoronto'] = array(
        'entry_points' => array(
            'new'   => 'https://www.vwmidtowntoronto.com/en/for-sale/car/new',
            'used'  => 'https://www.vwmidtowntoronto.com/en/for-sale/car/used'
        ),
        'vdp_url_regex'     => '/\/en\/inventory\/(?:new|used)\/vehicle\//i',
        'ty_url_regex'      => '/\/en\/thank-you/i',
        'use-proxy' => true,
        'picture_selectors' => ['.catalog-vehicle-details__gallery-thumbnails'],
///       'picture_selectors' => ['.bx-wrapper img '],
        'picture_nexts'     => ['.bx-next'],
        'picture_prevs'     => ['.bx-prev'],
        
        'details_start_tag' => '<section class="page-content__right">',
        'details_end_tag'   => '<p class="inventory-listing__disclaimer smallprint"',
        'details_spliter'   => '<article class="inventory-list-layout-wrappe',
        'data_capture_regx' => array(
            'title'         => '/inventory-list-layout__preview-name"[^\/]*(?<url>[^"]+)"[^"]+"(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name"[^\/]*(?<url>[^"]+)"[^"]+"(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name"[^\/]*(?<url>[^"]+)"[^"]+"(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name"[^\/]*(?<url>[^"]+)"[^"]+"(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
            'price'         => '/inventory-list-layout__preview-price-current[^$]*(?<price>\$[0-9,]+)/',          
            'url'           => '/inventory-list-layout__preview-name"[^\/]*(?<url>[^"]+)"[^"]+"(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^"]+)/',
            'transmission'  => '/transmission"><\/i>[^>]*>(?<transmission>[^<]+)/',
            'kilometres'    => '/inventory-list-layout__preview-info-picto" data-theme-sprite="km"[^"]*[^>]*>(?<kilometres>[^\s]+)/',
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Bodystyle[^>]*>[^>]*>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders:[^>]*>[^>]*>(?<engine>[^<]+)/',
            'exterior_color'=> '/Ext. Color[^>]*>[^>]*>(?<exterior_color>[^<]+)/',
			'interior_color'=> '/Int. color:[^>]*>[^>]*>(?<interior_color>[^<]+)/',
			'stock_number'  =>  '/Inventory #[^>]*>[^>]*>(?<stock_number>[^<]+)/'
        ),
        'next_page_regx'    => '/<li class="pagination__page-button pagination__page-button--selected".*\s*<a[^>]+>\s*.*\s*<\/li>\s*<li[^>]+>\s*<a class="[^"]+" href="(?<next>[^"]+)/',
        'images_regx'       => '/(?:data-view="ninjabox-gallery"[^"]*[^=]*="|inventory-details__header-image">\s*<img src=")(?<img_url>[^"]+)" alt="/',
        
    );
    
