<?php
global $scrapper_configs;
$scrapper_configs["somethingsplendidcocom"] = array( 
	'entry_points' => array(
            'new'   => 'https://somethingsplendidco.com/collections/curated-boxes',
            
        ),
        'vdp_url_regex'     => '/\/collections\//i',
        'use-proxy' => true,
       'refine'=>false,
      'picture_selectors' => ['.product__thumb img'],
       'picture_nexts'     => [''],
      'picture_prevs'     => [''],
    
         'details_start_tag' => '<div class="grid grid--uniform grid--collection',
        'details_end_tag'   => '<footer',
        'details_spliter'   => '<div class="grid-product__content',
        'data_capture_regx' => array(
            'url'                 => '/<a href="(?<url>[^"]+)" class="grid-product__link ">/',
          //'year'                => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
            'make'                => '/grid-product__title--body">(?<make>[^\s]+)/',
            'model'               => '/grid-product__title--body">(?<make>[^\s]+)\s*(?<model>[^\<]+)/',
            'price'               => '/grid-product__price">\s*from\s(?<price>\$[0-9.]+)/',
            
        ),
        'data_capture_regx_full' => array(        
            
        ) ,
       
        'images_regx'       => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
    );
    