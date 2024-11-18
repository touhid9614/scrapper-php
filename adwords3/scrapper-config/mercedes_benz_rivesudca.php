<?php
global $scrapper_configs;
$scrapper_configs["mercedes_benz_rivesudca"] = array( 
	 "entry_points" => array(
        'used' => 'https://www.mercedes-benz-rivesud.ca/en/used-inventory?limit=117',
        'new' => 'https://www.mercedes-benz-rivesud.ca/en/new-inventory?limit=136',
    ),
    'url_resolve'       => array(
        'mercedes_benz_rivesudca'       => '/www.mercedes-benz-rivesud.ca\/en/i',
        'mercedes_benz_rivesudca_fr'    => '/www.mercedes-benz-rivesud.ca\/fr/i',
        ),
    'picture_selectors' => ['.slick-slide img'],
    'picture_nexts' => ['.stat-arrow-next'],
    'picture_prevs' => ['.stat-arrow-prev'],
    'vdp_url_regex' => '/\/en\/(?:new|used)-inventory\//i',
    'use-proxy' => true,
    'refine' => false,
    'details_start_tag' => '<section class="page-content__right">',
    'details_end_tag' => '<section class="inventory-listing__form',
    'details_spliter' => '<article class="inventory-list-layout-wrapper',
    'data_capture_regx' => array(
        'year' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
        'make' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
        'model' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
        'price' => '/<div class="inventory-list-layout__preview-price-current vehicle__rebate"[^>]+>\s*(?<price>[^<]+)/',
        'kilometres' => '/class="inventory-list-layout__preview-km">\s*<[^>]+><\/span>\s*<[^>]+>(?<kilometres>[^\s]+)/',
        'transmission' => '/class="inventory-list-layout__preview-transmission">\s*<[^>]+><\/span>\s*<[^>]+>(?<transmission>[^<]+)/',
        'url' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/Inventory #:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Cylinders:<\/div>\s*<[^>]+>(?<engine>[^&]+)/',
        'exterior_color' => '/Ext. Color:<\/div>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color:<\/div>\s*<[^>]+>(?<interior_color>[^<]+)/',
    ),
    'images_regx' => '/(?:<span class="overlay">\s*<img\s*src="|img class="in[^"]+"\s*src=")(?<img_url>[^"]+)(?:"|"\s*itemprop="image"\s*alt=)/',
);


