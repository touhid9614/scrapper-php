<?php
global $scrapper_configs;
$scrapper_configs["chevroletofpalatinecom"] = array( 
	"entry_points" => array(
        'new'  => 'https://www.chevroletofpalatine.com/VehicleSearchResults?search=new',
        'used' => 'https://www.chevroletofpalatine.com/VehicleSearchResults?search=used',
      
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

     'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],
     'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',
     'data_capture_regx'         => array(
        'stock_number'          => '/stockNumber:(?<stock_number>[^;]+)/',
        'url'                   => '/subject">\s*[^"]+"url" href="(?<url>[^"]+)/',
        'stock_type'            => '/subject">\s*[^"]+"url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year'                  => '/vehicleModelDate">(?<year>[0-9]{4})/',
        'make'                  => '/manufacturer">(?<make>[^<]+)/',
        'model'                 => '/model">(?<model>[^<]+)/',
        'price'                 => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'exterior_color'        => '/exteriorColor:(?<exterior_color>[^;]+)/',
        'trim'                  => '/="trim"[^>]+>(?<trim>[^<]+)/'
    ),

    'data_capture_regx_full'    => array(
        'kilometres'            => '/mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'transmission'          => '/vehicleTransmission">(?<transmission>[^<]+)/',
        'interior_color'        => '/vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'engine'                => '/vehicleEngine">(?<engine>[^<]+)<\/span>/',
        
    ),

    'next_page_regx'            => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx'               => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx'      => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_chevroletofpalatinecom_next_page", "filter_chevroletofpalatinecom_next_page",10,2);
    
    function filter_chevroletofpalatinecom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
