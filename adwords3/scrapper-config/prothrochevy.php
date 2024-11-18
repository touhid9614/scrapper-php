<?php

global $scrapper_configs;

$scrapper_configs['prothrochevy'] = array(
    'entry_points' => array(
        'new' => 'https://www.prothrochevy.com/VehicleSearchResults?search=new',
        'used' => 'https://www.prothrochevy.com/VehicleSearchResults?search=preowned',
        'certified' => 'https://www.prothrochevy.com/VehicleSearchResults?search=certified',
    ),

    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    //'ty_url_regex' => '/\/thank-you\?formName/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section img.co-lazy-loaded'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
    'details_start_tag' => '<div class="title" template="title">',
    'details_end_tag' => '<div role="navigation">',
    'details_spliter' => '<section id="card-view/card/95815046-afeb-4da6-8790-859d57cec6f1-',

    'data_capture_regx' => array(
        'stock_number' => '/<span class="value" itemprop="sku">(?<stock_number>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model'=> '/itemprop="model">(?<model>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'price'=> '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
        'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
