<?php

global $scrapper_configs;

$scrapper_configs['bowmargm'] = array(
    'entry_points' => array(
        'new' => 'http://www.bowmargm.ca/VehicleSearchResults?search=new',
        'used' => 'http://www.bowmargm.ca/VehicleSearchResults?search=preowned'
    ),
     'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'refine'            => false,
     'use-proxy' => true,
     'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
     'picture_nexts'     => ['.arrow.single.next'],
     'picture_prevs'     => ['.arrow.single.prev'],
     'details_start_tag' => '<ul each="cards">',
     'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
     'details_spliter'   => '<div class="deck" each="cards">',
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
             'vin'               => '/vehicleIdentificationNumber">(?<vin>[^<]+)/',
            'stock_number'      => '/vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
           'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
           'body_style'        => '/bodyType":"(?<body_style>[^"]+)/'
       ),
         'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
    add_filter("filter_bowmargm_next_page", "filter_bowmargm_next_page",10,2);
    
    function filter_bowmargm_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
add_filter("filter_bowmargm_field_images", "filter_bowmargm_field_images");

function filter_bowmargm_field_images($im_urls) {
   
    /*
    if (count($im_urls) < 2) {
        return [];

    }
    return $im_urls;
    */
    $md5_of_no_car_images = [
        '0905bf1f92418fdbe919ca0173eec097'
    ];

    $im_urls = array_filter($im_urls, function($image_url) use ($md5_of_no_car_images){
        $md5 = md5(file_get_contents($image_url));
        if(in_array($md5, $md5_of_no_car_images)){
            slecho("No car image: " . $image_url);
            return false;
        }
        return true;
    });

    return $im_urls;
}