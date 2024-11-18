<?php
global $scrapper_configs;
$scrapper_configs["gravelauto_ilesdessoeurscadillaccom"] = array( 
	'entry_points' => array(
            'used'  => 'http://www.gravelauto-ilesdessoeurscadillac.com/en/used-inventory?limit=200',
            'new'   => 'http://www.gravelauto-ilesdessoeurscadillac.com/en/new-inventory?limit=200',
            
        ),
        'url_resolve'       => array(
        'gravelauto_ilesdessoeurscadillaccom'       => '/www.gravelauto-ilesdessoeurscadillac.com\/en/i',
        'gravelauto_ilesdessoeurscadillac_frcom'    => '/www.gravelauto-ilesdessoeurscadillac.com\/fr/i',
        ),
        'picture_selectors' => ['.slick-slide img'],
        'picture_nexts'     => ['.stat-arrow-next'],
        'picture_prevs'     => ['.stat-arrow-prev'],
            'vdp_url_regex'     => '/\/en\/(?:new|used)-inventory\//i',
            'use-proxy'         => true,
             'refine'=>false,
        'details_start_tag' => '<section class="page-content__right">',
        'details_end_tag' => '<footer class',
        'details_spliter' => '<article class="inventory-list-layout-wrapper',
           // 'must_not_contain_regx' => '/ceLabel_fontColor">\s*Sold at<\/p>/',
           'data_capture_regx' => array(         
            'year' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/<div class="inventory-list-layout__preview-price-current vehicle__rebate"[^>]+>\s*(?<price>[^<]+)/',
            'kilometres' => '/class="inventory-list-layout__preview-km">\s*<[^>]+><\/span>\s*<[^>]+>(?<kilometres>[^\s]+)/',
            'transmission' => '/class="inventory-list-layout__preview-transmission">\s*<[^>]+><\/span>\s*<[^>]+>(?<transmission>[^<]+)/',
           // 'vin' => '/data-vin="(?<vin>[^"]+)/',
            'url' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number' => '/Inventory #:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
            'engine' => '/Cylinders:<\/div>\s*<[^>]+>(?<engine>[^&]+)/',
            'exterior_color' => '/Ext. Color:<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Int. color:<\/div>\s*<[^>]+>(?<interior_color>[^<]+)/',
        ),
    'images_regx'   => '/(?:inventoryDetailsHeader_separator_borderColor">|inventory-photo-gallery-from-catalog__main-picture[^>]+>|gallery-delta-slider__slide[^>]+>)\s*<img src="\s*(?<img_url>[^"]+)"/',
      
            
    );
