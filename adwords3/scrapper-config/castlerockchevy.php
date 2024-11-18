<?php

global $scrapper_configs;
$scrapper_configs["castlerockchevy"] = array(
    'entry_points' => array(
        'new' => 'https://www.castlerockchevy.com/VehicleSearchResults?search=new',
        'used' => 'https://www.castlerockchevy.com/VehicleSearchResults?search=preowned'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\//i',
    'ty_url_regex' => '/\/thankYou.do/i',
    'ajax_url_match' => 'callback=secureLeadSubmission',
    'use-proxy' => true,
    'picture_selectors' => ['div.media.img-thumbnail'],
    'picture_nexts' => ['div.arrow.single.next'],
    'picture_prevs' => ['div.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',  
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
           'vin' => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'stock_number' => '/Stock Number<\/span>\s*.*[^"]+">(?<stock_number>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',  
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior<\/span>\s*<[^>]+>(?<exterior_color>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'interior_color' => '/Interior<\/span>\s*<[^>]+>(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
  //  'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_castlerockchevy_next_page", "filter_castlerockchevy_next_page", 10, 2);

function filter_castlerockchevy_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}
   add_filter("filter_castlerockchevy_field_images", "filter_castlerockchevy_field_images");
    
    function filter_castlerockchevy_field_images($im_urls)
    {
        
        
         if(count($im_urls)<7)
            {
            return [];
            
            }
       
          return $im_urls;
     
    }
    
    