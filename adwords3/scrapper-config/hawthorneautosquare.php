<?php
global $scrapper_configs;
 $scrapper_configs["hawthorneautosquare"] = array( 
	 'entry_points' => array(
        'used' => 'https://hawthorneautosquare.com/listings/',
    ),
    'vdp_url_regex' => '/\/listings\/[0-9]{4}-/i',
    'refine'        => false,
    'use-proxy' => true,
    'picture_selectors' => ['.owl-item .stm-single-image img'],
    'picture_nexts' => ['.fancybox-nav.fancybox-next'],
    'picture_prevs' => ['.fancybox-nav.fancybox-prev'],
    'details_start_tag' => 'class="stm-isotope-sorting stm-isotope-sorting-list">',
    'details_end_tag' => 'class="stm_ajax_pagination stm-blog-pagination">',
    'details_spliter' => 'class="listing-list-loop stm-listing-directory-list-loop stm-isotope-listing-item',
    'data_capture_regx' => array(
        'url'           => '/itle heading-font">\s*<a\s*href=(?<url>[^\s]+)[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)</',
        'year'          => '/itle heading-font">\s*<a\s*href=(?<url>[^\s]+)[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)</',
        'make'          => '/itle heading-font">\s*<a\s*href=(?<url>[^\s]+)[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)</',
        'model'         => '/itle heading-font">\s*<a\s*href=(?<url>[^\s]+)[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s(?<model>[^<]+)</',
        'price'         => '/normal-price>[^>]+>(?<price>\$[^<]+)/',
        'stock_number'  => '/stock#[^>]+>(?<stock_number>[^<]+)/',
        'kilometres'    => '/Mileage<\/div><\/div>[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine'        => '/Engine<\/div><\/div>[^>]+>\s*(?<engine>[^<]+)/',
        'transmission'  => '/Transmission<\/div><\/div>[^>]+>\s*(?<transmission>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'body_style'     => '/Body<\/td>[^>]+>(?<body_style>[^<]+)/',
        'exterior_color' => '/Exterior Color<\/td>[^>]+>(?<exterior_color>[^<]+)/',
        'vin'            => '/Vin<\/td>[^>]+>(?<vin>[^<]+)/'
    ),
    'next_page_regx' => '/"next page-numbers" href=(?<next>[^>]+)/',
    'images_regx'    => '/<a\s*href=(?<img_url>[^\s]+)\s*class=stm_fancybox/',
    
);

