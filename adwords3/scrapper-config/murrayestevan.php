<?php

global $scrapper_configs;

$scrapper_configs['murrayestevan'] = array(
   
       'entry_points' => array(
        'new' => 'https://www.murrayestevan.com/inventory/new/',
        'used' => 'https://www.murrayestevan.com/inventory/used/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)/i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
     
    'picture_selectors' => ['.owl-item.cloned'],
    'picture_nexts' => ['#newnext'],
    'picture_prevs' => ['#newprev'],
     
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap loading ">',
     
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        //'title' => '/wrap-carbox-title"> <h2>[^\s]+\s(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/year">\s*(?<year>[0-9]{4})/',
        'make' => '/make notranslate">\s*(?<make>[^\s]+)/',
        'model' => '/model notranslate">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/Price<\/div>[^\$]+\$[^>]+>(?<price>[0-9,]+)/',
      
    ),
     
    'data_capture_regx_full' => array(
        'kilometres' => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine'     => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'drivetrain'   => '/Drivetrain:<\/span>[^>]+>(?<drivetrain>[^<]+)/',
        'exterior_color'   => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/', 
        'interior_color'   => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/', 
        'vin'   => '/"vin">(?<vin>[^<]+)/',
        'description'   => '/vehicle-descriptions__value ">(?<description>[^<]+)/',
    ),
     
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'    => '/data-lightbox="(?<img_url>[^"]+)"/',
);
add_filter("filter_murrayestevan_field_images", "filter_murrayestevan_field_images");
function filter_murrayestevan_field_images($im_urls) {
    if(count($im_urls) < 2) { return array(); }
    $retval = [];
    
    for ($i=0;$i<3;$i++) {

        $retval[] = $im_urls[$i];
    }
    return array_filter($retval, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}