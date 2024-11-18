<?php
global $scrapper_configs;

   $scrapper_configs["stoneridgerealty"] = array(
    "entry_points" => array(
        'new' => 'http://idx.myrealpage.com/wps/-/tmpl~v2,noframe~true/myofficelistings/19186/myofficelistings.def/SearchResults.form',
        'used' =>'http://idx.myrealpage.com/wps/-/tmpl~v2,noframe~true/recip/19186/search-1278449.def/SearchResults.form?_fcc=0.914743271371145',
    ),
    'vdp_url_regex' => '/stone-ridge-listings/i',
    'use-proxy' => true,
       
    'picture_selectors' => ['.fotorama__loaded.fotorama__loaded--img'],
    'picture_nexts' => ['.fotorama__arr.fotorama__arr--next'],
    'picture_prevs' => ['.fotorama__arr.fotorama__arr--prev'],
       
    'details_start_tag' => '<ul class="mrp-listing-results"',
    'details_end_tag' => '<div class="listing-results-navigation-bottom">',
    'details_spliter' => '<li class="mrp-listing-result listing-id',
       
    'data_capture_regx' => array(
        'url' => '/mrp-listing-details-link">[^"]+"[^"]+"\s*href="(?<url>[^"]+)/',
         
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/class="mrp-summary-line"><dt>MLS[^>]+><dd >(?<stock_number>[^<]+)/',
        'year' => '/Year Built:<\/dt><dd >(?<year>[0-9]{4})/',
        'make' => '/"mrp-listing-title">(?<trim>[0-9]+)\s*(?<make>[a-zA-Z]+)\s*(?<model>[a-zA-Z]+)/',
        'model' => '/"mrp-listing-title">(?<trim>[0-9]+)\s*(?<make>[a-zA-Z]+)\s*(?<model>[a-zA-Z]+)/',
        'trim' => '/"mrp-listing-title">(?<trim>[0-9]+)\s*(?<make>[a-zA-Z]+)\s*(?<model>[a-zA-Z]+)/',
        'price' => '/mrp-listing-price-info">[^>]+>\s*(?<price>\$[0-9,]+)/',
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*[^"]+"[^"]+"\s*class="next-page-link"/',
    'images_regx' => '/mrp-listing-photo-thumb"[^"]+"(?<img_url>[^"]+)/',
   
);
