<?php
global $scrapper_configs;
 $scrapper_configs["cyvgm"] = array( 
	'entry_points' => array(
        'new'  => 'https://www.cyvgm.ca/VehicleSearchResults?search=new',
        'used' => 'https://www.cyvgm.ca/VehicleSearchResults?search=preowned',
     
    ),
     'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

     'use-proxy' => true,
     'refine' => false,
     // 'proxy-area'        => 'FL',
     'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
     'picture_nexts'     => ['.arrow.single.next'],
     'picture_prevs'     => ['.arrow.single.prev'],
    
     'details_start_tag'    => '<ul each="cards">',
        'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
        'details_spliter'   => '<div class="deck" each="cards">',
        
         'data_capture_regx' => array(
        
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)"/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'stock_number' => '/class="key">Stock Number[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'exterior_color' => '/class="key">Exterior[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'kilometres' => '/Kilometers[^>]+>\s*.*\s*[^>]+>(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/class="key">Interior[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
        'next_page_regx'        => '/data-action="next"\s*href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
    );
    
     add_filter("filter_cyvgm_next_page", "filter_cyvgm_next_page",10,2);
     
     
    function filter_cyvgm_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
add_filter('filter_cyvgm_car_data', 'filter_cyvgm_car_data');
function filter_cyvgm_car_data($car_data) {
    if(strpos($car_data['trim'],"CYV Wholesale As-Traded"))
    {
        return NULL;
    }
    return $car_data;
}
// add_filter('filter_cyvgm_car_data', 'filter_cyvgm_car_data');
// function filter_cyvgm_car_data($car_data) {
//     if(strpos($car_data['trim'],"CYV Wholesale As-Traded"))
//     {
//         return NULL;
//     }
//     return $car_data;
// }

