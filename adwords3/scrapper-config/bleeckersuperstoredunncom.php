<?php
global $scrapper_configs;
$scrapper_configs["bleeckersuperstoredunncom"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.bleeckersuperstoredunn.com/VehicleSearchResults?search=new',
            'used'  => 'https://www.bleeckersuperstoredunn.com/VehicleSearchResults?search=used'
       ),
        'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    'refine'=>false,
    'proxy-area' => 'FL',
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
          
          // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
           'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
            'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
           //'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/'
       ),
         'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

    add_filter("filter_bleeckersuperstoredunncom_next_page", "filter_bleeckersuperstoredunncom_next_page",10,2);
    
    function filter_bleeckersuperstoredunncom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    