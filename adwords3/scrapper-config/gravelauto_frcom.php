<?php
global $scrapper_configs;
$scrapper_configs["gravelauto_frcom"] = array( 
	"entry_points" => array(
	       'used'  => 'https://www.gravelauto.com/fr/inventaire-occasion?limit=500',
               'new'   => 'https://www.gravelauto.com/fr/inventaire-neuf?limit=500',
            
        ),
        'url_resolve'       => array(
        'gravelautocom'       => '/www.gravelauto.com\/en/i',
        'gravelauto_frcom'    => '/www.gravelauto.com\/fr/i',
        ), 
        'picture_selectors' => ['.slick-slide img'],
        'picture_nexts'     => ['.stat-arrow-next'],
        'picture_prevs'     => ['.stat-arrow-prev'],
        'vdp_url_regex'     => '/\/(?:en|fr)\/(?:new|used|inventaire)-(?:occasion|inventory|neuf)\//i',
        'use-proxy'         => true,
        'refine'=>false,
        'details_start_tag' => '<section class="inventory-listing-charlie__content',
        'details_end_tag' => '<footer class',
        'details_spliter' => '<article class="inventory-preview-bravo',
         
           'data_capture_regx' => array(         
            'year' => '/title_borderColor">\s*<a href="(?<url>[^"]+)"\s*[^"]+"\s*[^>]+>.*(?<year>[0-9]{4})/',
            'make' => '/title_borderColor">\s*<a href="\/fr\/[^\/]+\/(?<make>[^\/]+)/',
            'model' => '/title_borderColor">\s*<a href="\/fr\/[^\/]+\/(?<make>[^\/]+)\/(?<model>[^\/]+)\//',
            'price' => '/vehicleCashPurchase_sellingPrice_fontColor">\s*(?<price>[^\$]+)/',
            'kilometres' => '/data-theme-sprite="km"[^>]+><\/i>\s*<[^>]+>(?<kilometres>[^KM]+)/',
            'transmission' => '/data-theme-sprite="transmission"[^>]+><\/i>\s*<[^>]+>(?<transmission>[^<]+)/',
            'url' => '/title_borderColor">\s*<a href="(?<url>[^"]+)"\s*[^"]+"\s*[^>]+>.*(?<year>[0-9]{4})/'
        ),
        'data_capture_regx_full' => array(
            'trim'  => '/Version:<\/div>[^>]+>(?<trim>[^<]+)/',
            'stock_number' => '/Inventaire #:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
            'engine' => '/Cylindres:<\/div>\s*<[^>]+>(?<engine>[^&]+)/',
            'exterior_color' => '/Couleur ext\.:<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Couleur int\.:<\/div>\s*<[^>]+>(?<interior_color>[^<]+)/',
        ),
    'images_regx'   => '/(?:inventoryDetailsHeader_separator_borderColor">|gallery-delta-slider__slide[^>]+>)\s*<img src="\s*(?<img_url>[^"]+)"/',
      
            
    );
  
   