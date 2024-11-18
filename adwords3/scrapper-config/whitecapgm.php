<?php

global $scrapper_configs;

$scrapper_configs['whitecapgm'] = array(
    'entry_points' => array(
         'used' => 'https://www.whitecapgm.com/VehicleSearchResults?search=preowned',
         'new' => 'https://www.whitecapgm.com/VehicleSearchResults?search=new',
        
       
        
  
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
         'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'msrp' => '/MSRP\s*[^>]+>\s*[^>]+>(?<msrp>[^<]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'stock_type' => '/itemprop="itemCondition">(?<stock_type>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       
    ),
    'data_capture_regx_full' => array(
         'kilometres' => '/Kilometers<\/span>\s*[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'interior_color' => '/Interior<\/span>\s*[^>]+>(?<interior_color>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior<\/span>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'stock_number' => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)" rel="next">Next/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_whitecapgm_field_images", "filter_whitecapgm_field_images");

function filter_whitecapgm_field_images($im_urls) {
    $retval = [];
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace('Width=80&Height=60', 'Width=800&Height=600', $im_url);
    }

    return $retval;
}
  add_filter("filter_whitecapgm_field_stock_type", "filter_whitecapgm_field_stock_type");

    function filter_whitecapgm_field_stock_type($stock_type) {
        
      if($stock_type=="Demo")
       {
           
            $stock_type="new";
       }
         
        return strtolower($stock_type);
    }
    
add_filter("filter_whitecapgm_next_page", "filter_whitecapgm_next_page", 10, 2);


function filter_whitecapgm_next_page($next, $current_page)
{
	slecho("Filtering Next url");
	$car_type = explode('=', $current_page);
	return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}
    