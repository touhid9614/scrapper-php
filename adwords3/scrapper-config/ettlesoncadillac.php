<?php
global $scrapper_configs;

$scrapper_configs['ettlesoncadillac'] = array(
    'entry_points' => array(
        'new'  => 'https://www.ettlesoncadillac.com/VehicleSearchResults?search=new',
        'used' => 'https://www.ettlesoncadillac.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|preowned|certified)-[0-9]{4}-/i',

    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['div.arrow.single.next'],
    'picture_prevs'     => ['div.arrow.single.prev'],

    'details_start_tag'    => '<ul each="cards">',
       'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
       'details_spliter'   => 'template="card-body">',

       'data_capture_regx' => array(
           'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
      
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)">\s*<span/',
           'transmission'      => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/bodyType":"(?<body_style>[^"]+)/',
       ),
        'next_page_regx'    => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
       'images_regx'        => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
       'images_fallback_regx' => '/<meta if="content.socialMedia.imageUrl" property="og:image" content="(?<img_url>[^"]+)">/'
   );
    
//     add_filter("filter_auddiebrownchevrolet_next_page", "filter_auddiebrownchevrolet_next_page",10,2);
//     
//     
//    function filter_auddiebrownchevrolet_next_page($next,$current_page) {
//        slecho("Filtering Next url");
//        $car_type= explode('=', $current_page);
//        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
//    }
//    
//    