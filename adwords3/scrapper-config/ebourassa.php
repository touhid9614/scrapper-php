<?php
global $scrapper_configs;
 $scrapper_configs["ebourassa"] = array( 
	'entry_points' => array(
            'new'  => 'https://ebourassa.com/is-equipment-listings/search/category_type:A;condition:new',
            'used' => 'https://ebourassa.com/ironsearch/search/category_type:A;condition:pre-owned'
        ),
        'vdp_url_regex'     => '/\/is-equipment-listings\/view\//i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => false,
        'refine' => false,
        'no_scrap'        => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.previous'],
        
        'details_start_tag' => '<div class="col-md-8">',
        'details_end_tag'   => '<div class="col-md-4 right-sidebar">',
        'details_spliter'   => '<i class="fa fa-camera">',
        'data_capture_regx' => array(
            'url'           => '/<h4 class="margin-bottom-10"><a href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
            'title'         => '/<h4 class="margin-bottom-10"><a href="(?<url>[^"]+)">\s*(?<title>[^<]+)/',
            'year'          => '/<h4 class="margin-bottom-10"><a href="(?<url>[^"]+)">\s*(?<year>[^\s]+)/',
            'make'          => '/<h4 class="margin-bottom-10"><a href="(?<url>[^"]+)">\s*(?<year>[^\s]+)\s*(?<make>[a-zA-Z]+ [a-zA-Z]+)\s*(?<model>[^<]+)/',
            'model'         => '/<h4 class="margin-bottom-10"><a href="(?<url>[^"]+)">\s*(?<year>[^\s]+)\s*(?<make>[a-zA-Z]+ [a-zA-Z]+)\s*(?<model>[^<]+)/',
            'price'         => '/<\/h4><div><b>(?<price>[^\s]+)/',
            
        ),
        'data_capture_regx_full' => array(        
            'stock_number'          => '/Stock #:<\/strong>\s*(?<stock_number>[^<]+)/',
          
        ) ,
        'next_page_regx'    => '/<li class="active">[^>]+>[^>]+><\/li><li><a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" rel=/',
        'images_fallback_regx'  => '/<a href="(?<img_url>[^"]+)" rel=/'
    );
    