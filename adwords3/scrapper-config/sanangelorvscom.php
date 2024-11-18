<?php
global $scrapper_configs;
$scrapper_configs["sanangelorvscom"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.sanangelorvs.com/new-rvs-for-sale',
            'used'  => 'https://www.sanangelorvs.com/used-rvs-for-sale',
        ),
        'vdp_url_regex' => '/\/product\/(?:new|used)-[0-9]{4}-/',
        'refine' => false,
        'use-proxy' => true,
        'details_start_tag' => '<div class="unitListHeader">',
        'details_end_tag'   => '<div class="bottomPageContent">',
        'details_spliter'   => '<div class="unitHeader">',

        'picture_selectors' => ['.ll-slide-img'],
        'picture_nexts'     => ['.unit-photo-nav.sliderNext'],
        'picture_prevs'     => ['.unit-photo-nav.sliderPrev'],

        'data_capture_regx' => array(
            
            'year'    => '/<div class="[^>]+><a href="(?<url>[^"]+)">[^ ]+ (?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
            'make'    => '/<div class="[^>]+><a href="(?<url>[^"]+)">[^ ]+ (?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
            'model'   => '/<div class="[^>]+><a href="(?<url>[^"]+)">[^ ]+ (?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
            'url'     => '/<div class="[^>]+><a href="(?<url>[^"]+)">[^ ]+ (?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
            'trim'    => '/<div class="[^>]+><a href="(?<url>[^"]+)">[^ ]+ (?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',

            'price'         => '/Our Price:<\/span> <span class="salePriceText">(?<price>[^<]+)/',
            'stock_number'  => '/Stock #: (?<stock_number>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
       
            'exterior_color'=> '/Exterior Color<\/td>\s*<td class="SpecDescriptionContainer">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color<\/td>\s*<td class="SpecDescriptionContainer">(?<interior_color>[^<]+)/',
            'description' => '/<div class="UnitDescText-main">\s*<p>(?<description>[^<]+)/',
            
        ),
        'images_regx'       => '/<a title="Click to enlarge" href="(?<img_url>[^"]+)" data/',
        
    );

add_filter('filter_sanangelorvscom_car_data', 'filter_sanangelorvscom_car_data');

function filter_sanangelorvscom_car_data($car_data) {
    
    $car_data['vin'] = substr($car_data['stock_number'], 0,17);
  
    return $car_data;
}
