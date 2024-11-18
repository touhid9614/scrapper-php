<?php
global $scrapper_configs;
$scrapper_configs["eaglechevroletbuickcom"] = array( 
	"entry_points" => array(
        'new'  => 'https://www.eaglechevroletbuick.com/VehicleSearchResults?search=new',
        'used' => 'https://www.eaglechevroletbuick.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}/i',

    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],

    'details_start_tag'    => '<ul each="cards">',
       'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
       'details_spliter'   => '<div class="deck" each="cards">',

       'data_capture_regx' => array(
          
           // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
       
        //'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
       
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
       
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
             'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'stock_number'      => '/<span class="key">Stock Number<\/span>\s*[^>]+>(?<stock_number>[^<]+)/',
             'exterior_color' => '/<span class="key">Exterior<\/span>\s*[^>]+>(?<exterior_color>[^<]+)/',
            'transmission' => '/<span class="key">Transmission<\/span>\s*[^>]+>[^>]+>(?<transmission>[^<]+)/',
           'kilometres'        => '/<span class="key">Miles<\/span>\s*[^>]+>[^>]+>(?<kilometeres>[^<]+)/',
           'interior_color'    => '/<span class="key">Interior<\/span>\s*[^>]+>(?<interior_color>[^<]+)/',
       ),
        'next_page_regx'    => '/data-action="next" href="(?<next>[^"]+)"/',
       'images_regx'        => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
   );
    
     add_filter("filter_eaglechevroletbuickcom_next_page", "filter_eaglechevroletbuickcom_next_page",10,2);
     
     
    function filter_eaglechevroletbuickcom_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
    
