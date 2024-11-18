<?php
global $scrapper_configs;
 $scrapper_configs["travelcampcom"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.travelcamp.com/search-rv/?filter%5BCondition%5D%5B%5D=New',
            'used'  => 'https://www.travelcamp.com/search-rv/?filter%5BCondition%5D%5B%5D=Used',
        ),
        'vdp_url_regex' => '/\/inv\//',
         'refine' => false,
        'use-proxy' => true,
       'picture_selectors' => ['.lg-thumb-item'],
       'picture_nexts' => ['.lg-next'],
       'picture_prevs' => ['.lg-prev'],
        'details_start_tag' => '<div class="wpb_column vc_column_container vc_col-sm-9 main-search-rv',
        'details_end_tag'   => '<footer id="footer',
        'details_spliter'   => '<div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1573817871323',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:\s*<span>(?<stock_number>[^<]+)/',
            'url'         => '/<a href="(?<url>[^"]+)" rel="nofollow" class="moreinf-btn tofix-btn"/',
            'year'          => '/class="sa-c-a">(?<year>[0-9]{4})/',
            'make'          => '/class="sa-c-b">\s*(?<make>[^<]+)[^>]+>[^>]+>\s*(?<model>[^<]+)/',
            'model'         => '/class="sa-c-b">\s*(?<make>[^<]+)[^>]+>[^>]+>\s*(?<model>[^<]+)/',
            'price'         => '/Value Price:[^>]+>\$\s*(?<price>[^<]+)/',
   
        ),
        'data_capture_regx_full' => array(
            'vin'           => '/VIN:<\/span>[^>]+>(?<vin>[^<]+)/', 
        ),
        'images_regx'       => '/<div style="[^>]+><img src="(?<img_url>[^"]+)"\s*alt="/',
        'next_page_regx'    => '/class="next page-numbers" href="(?<next>[^"]+)">Next/',
    );