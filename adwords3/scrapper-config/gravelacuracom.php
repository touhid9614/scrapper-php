<?php
global $scrapper_configs;
$scrapper_configs["gravelacuracom"] = array( 
	"entry_points" => array(
	       'used'  => 'https://www.gravelacura.com/en/used-inventory?limit=500',
           'new'   => 'https://www.gravelacura.com/en/new-inventory?limit=500',
            
        ),    
        'url_resolve'       => array(
        'gravelacuracom'       => '/www.gravelacura.com\/en/i',
        'gravelacura_frcom'    => '/www.gravelacura.com\/fr/i',
        ),
        'picture_selectors' => ['.slick-slide img'],
        'picture_nexts'     => ['.stat-arrow-next'],
        'picture_prevs'     => ['.stat-arrow-prev'],
        'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
        'use-proxy'         => true,
        'refine'			=> false,
        'details_start_tag' => '<section class="inventory-listing-charlie__content',
        'details_end_tag' => '<footer class',
        'details_spliter' => '<article class="inventory-preview-bravo',
         
           'data_capture_regx' => array(         
            'year' => '/<a href="(?<url>[^"]+)"\s*[^"]+"\s*[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',
            'make' => '/<a href="(?<url>[^"]+)"\s*[^"]+"\s*[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',
            'model' => '/<a href="(?<url>[^"]+)"\s*[^"]+"\s*[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/',
            'price' => '/class="vehicle-cash-purchase-selling-price__value"\s*[^>]+>\s*(?<price>[^<]+)/',
            'kilometres' => '/data-theme-sprite="km"[^>]+><\/i>\s*<[^>]+>(?<kilometres>[^\s*]+)/',
            'transmission' => '/data-theme-sprite="transmission"[^>]+><\/i>\s*<[^>]+>(?<transmission>[^<]+)/',
            'url' => '/<a href="(?<url>[^"]+)"\s*[^"]+"\s*[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^<]*))/'
        ),
        'data_capture_regx_full' => array(
            'stock_number' => '/stock:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
            'engine' => '/Cylinders:<\/div>\s*<[^>]+>(?<engine>[^&]+)/',
            'exterior_color' => '/Ext. Color:<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Int. color:<\/div>\s*<[^>]+>(?<interior_color>[^<]+)/',
        ),
    'images_regx'   => '/(?:inventoryDetailsHeader_separator_borderColor">|gallery-delta-slider__slide[^>]+>)\s*<img src="\s*(?<img_url>[^"]+)"/',   
    );
