<?php
global $scrapper_configs;
$scrapper_configs["vanislemarinacom"] = array( 
	 'entry_points' => array(
        'used' => 'https://vanislemarina.com/listings/',
    ),
    'vdp_url_regex' => '/\/listings\//i',
    'refine'        => false,
    'use-proxy' => true,
    'required_params'   => array('boatId'),
    'picture_selectors' => ['.slide-thumb'],
    'picture_nexts' => ['.slider-next-btn'],
    'picture_prevs' => ['.slider-prev-btn'],
    'details_start_tag' => '<main class=',
    'details_end_tag' => '<footer class',
    'details_spliter' => '<div class="col-xs-12',
        
    'data_capture_regx' => array(
        'url'           => '/wp_rtp_details_button" href="(?<url>[^"]+)/',
        'year'          => '/YEAR[^>]+>(?<year>[0-9]{4})/',
        'make'          => '/boat-listing-titile">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model'         => '/boat-listing-titile">(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price'         => '/wp_rtp_price">\$\s*(?<price>[^\s]+)\s*CAD/',
        'stock_number'  => '/boat_id=(?<stock_number>[^&]+)/',
        'vin'           => '/boat_id=(?<vin>[^&]+)/',     
    
    ),
    'data_capture_regx_full' => array(
      
    ),
   // 'next_page_regx' => '/"next page-numbers" href=(?<next>[^>]+)/',
    'images_regx'    => '/image : "(?<img_url>[^"]+)/',
    
);
/*
add_filter("filter_vanislemarinacom_field_images", "filter_vanislemarinacom_field_images");
function filter_vanislemarinacom_field_images($im_urls) {
    unset($im_urls[0]);

    return $im_urls;
}
*/