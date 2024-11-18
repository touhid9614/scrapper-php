<?php
global $scrapper_configs;
$scrapper_configs["brucemazdacom"] = array( 
	 'entry_points' => array(
             'used'      => 'https://www.brucemazda.com/en/used-inventory',
             'new'       => 'https://www.brucemazda.com/en/new-inventory',
        ),
        'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
        
        'use-proxy' => true,
        'refine' => false,
        'picture_selectors' => ['div.slick-slide img'],
        'picture_nexts'     => ['.widget-ninjabox__bxslider-controls--next'],
        'picture_prevs'     => ['.widget-ninjabox__bxslider-controls--prev'],


        'details_start_tag' => '<div class="inventory-listing__vehicles',
        'details_end_tag'   => '<footer class="footer-delta',
        'details_spliter'   => '<article class="inventory-list-layout',
        'data_capture_regx' => array(

            'title'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'year'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'make'          => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/',
            'model'         => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))/',
            'price'         => '/<div class="inventory-list-layout__preview-price-current[^>]+>\s*(?<price>\$[0-9,]+)/',
            'url'           => '/inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+)[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/<div class="inventory-details__header-stock"[^>]+>\s*<span>Inventory #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[^(?:\&|<)]+)/',
            'transmission'  => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
            'exterior_color'=> '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
            'vin'           => '/VIN #<\/span>\s*<span>(?<vin>[^<]+)/',
            'kilometres'    => '/Mileage:<\/div>\s*<[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    => '/<a class="pagination__page-arrows-text " href="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
        'images_regx'       => '/(?:class="inventory-list-layout__preview-image">|class="overlay">)\s*<img.*src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
