<?php
global $scrapper_configs;
$scrapper_configs["gravelauto_ilesdessoeurscadillac_frcom"] = array( 
	"entry_points" => array(
	       'used'  => 'https://www.gravelauto-ilesdessoeurscadillac.com/fr/inventaire-occasion?limit=500',
               'new'   => 'https://www.gravelauto-ilesdessoeurscadillac.com/fr/inventaire-neuf?limit=500',
            
        ),
        'url_resolve'       => array(
        'gravelauto_ilesdessoeurscadillaccom'       => '/www.gravelauto-ilesdessoeurscadillac.com\/en/i',
        'gravelauto_ilesdessoeurscadillac_frcom'    => '/www.gravelauto-ilesdessoeurscadillac.com\/fr/i',
        ),
        'picture_selectors' => ['.slick-slide img'],
        'picture_nexts'     => ['.stat-arrow-next'],
        'picture_prevs'     => ['.stat-arrow-prev'],
        'vdp_url_regex'     => '/\/(?:en|fr)\/(?:new|used|inventaire)-(?:occasion|inventory|neuf)\//i',
        'use-proxy'         => true,
        'refine'=>false,
        
        'details_start_tag' => '<section class="page-content__right">',
        'details_end_tag' => '<section class="inventory-listing__form',
        'details_spliter' => '<article class="inventory-list-layout-wrapper',
    
    'data_capture_regx' => array(         
            'year' => '/inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title=".*(?<year>[0-9]{4})/',
            'make' => '/inventory-list-layout__preview-name"\s*href="\/fr\/[^\/]+\/(?<make>[^\/]+)/',
            'model' => '/inventory-list-layout__preview-name"\s*href="\/fr\/[^\/]+\/(?<make>[^\/]+)\/(?<model>[^\/]+)\//',
            'price' => '/rent vehicle__rebate" data-theme-style="utilBlackColor__color">\s*(?<price>[^\$]+)/',
            'kilometres' => '/data-theme-sprite="km"[^>]+><\/span>\s*[^>]+>(?<kilometres>[^KM]+)/',
            'transmission' => '/data-theme-sprite="transmission"[^>]+><\/span>\s*[^>]+>(?<transmission>[^<]+)/',
            'url' => '/inventory-list-layout__preview-name"\s*href="(?<url>[^"]+)"\s*title=".*(?<year>[0-9]{4})/'
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