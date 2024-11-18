<?php
global $scrapper_configs;
$scrapper_configs["topnotchmarinecom"] = array( 
 "entry_points" => array(
        'used' => 'https://www.topnotchmarine.com/boats-for-sale/Used/all/Fort+Pierce-FL-US/',
        'new' => 'https://www.topnotchmarine.com/boats-for-sale/New/?option=100',
       
    ),

    'vdp_url_regex' => '/\/boats-for-sale\/[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['div.galleria-image.lazy > img'],
    'picture_nexts' => ['div.galleria-image-nav-right'],
    'picture_prevs' => ['div.galleria-image-nav-left'],

    'details_start_tag' => 'id="boat-list">',
    'details_end_tag' => 'id="inventory-results-contact-form"',
    'details_spliter' => '<div class="col-xs-12 boat list-group-item">',

    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)">\s*<div/',
        'price' => '/main-boat-price">[^\;]+\;(?<price>[^<]+)/',    
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/id="BoatID-[^"]+" value="(?<stock_number>[^"]+)/',
        'year' => '/Year:<[^\s]+\s(?<year>[^<]+)<\/div>/',
        'make' => '/Make:<[^\s]+\s(?<make>[^<]+)<\/div>/',
        'model' => '/Model:<[^\s]+\s(?<model>[^<]+)<\/div>/',
        'kilometres' => '/Range:<[^\s]+\s(?<kilometres>[^<]+)<\/div>/',
        'vin' => '/id="BoatID-[^"]+" value="(?<vin>[^<]+)"/',
        'stock_number' => '/id="BoatID-[^"]+" value="(?<stock_number>[^"]+)/',
        'description'   => '/description row">[^>]+>[^>]+>\s*(?:<p>|)(?<description>[\s\S]*?(?=<\/div>))/'
       
    ),
    'images_regx' => '/<a href="(?<img_url>[^\?]+)\?[^>]+>\s*<img alt="[^"]+" class="" src="/',
);

add_filter("filter_topnotchmarinecom_field_description", "filter_topnotchmarinecom_field_description");
    add_filter('filter_topnotchmarinecom_field_images','filter_topnotchmarinecom_field_images');
    
    function filter_topnotchmarinecom_field_description($description)
    {
       return strip_tags($description);
    }