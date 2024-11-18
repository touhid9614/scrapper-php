<?php
global $scrapper_configs;
$scrapper_configs["oceanstatehdcom"] = array( 
	  'entry_points' => array(
             'used' => 'https://oceanstatehd.com/used-inventory',
            'new'  => 'https://oceanstatehd.com/new-inventory',
            
         ),
        'vdp_url_regex'     => '/inventory\/[^\/]+\/[0-9]{4}/i',
        'use-proxy' => true,
       'refine'=>false,
        'picture_selectors' => ['.r58-slider-slide'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<ul id="inventoryBikesList',
        'details_end_tag'   => '<footer class',
        'details_spliter'   => '<li class="inventoryList-bike',
        'data_capture_regx' => array(
            'url'           => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'year'          => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'make'          => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'model'         => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
            'price'         => '/inventoryList-bike-details-price ">(?<price>\$[0-9,]+)/',
            'stock_number'  => '/Stock number:[^>]+>[^>]+>(?<stock_number>[^\<]+)/',     
            'exterior_color'=> '/>Color:[^>]+>[^>]+>(?<exterior_color>[^\<]+)/',
        ),
        'data_capture_regx_full' => array(   
             'vin'  => '/VIN number:[^>]+>\s*[^>]+>(?<vin>[^\<]+)/',     
             'kilometres'    => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^\<]+)/',
             'description' => '/<meta name="description" content="(?<description>[^"]+)/',
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" data-page=".*" title="Next page">/',
        'images_regx'       => '/data-lightbox-prevent href="(?<img_url>[^"]+)"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
   add_filter("filter_oceanstatehdcom_field_description", "filter_oceanstatehdcom_field_description");

function filter_oceanstatehdcom_field_description($description) {
    return strip_tags($description);
}
