<?php
global $scrapper_configs;
 $scrapper_configs["ridetime"] = array( 
	 "entry_points" => array( 
             'used' => 'https://www.ridetime.ca/buy-used-cars/?sort=created_desc/'
    ),
     
     'use-proxy' => true, 
     //'refine'=>false,
     'vdp_url_regex' => '/(?:new|used)-cars\//i',
     'picture_selectors' => ['ul.lSPager.lSGallery li'],
     'picture_nexts'     => ['.lSAction a.lSNext'],
     'picture_prevs'     => ['.lSAction a.lSPrev'],
    'details_start_tag' => '<div class="eightcol main__content">',
   // 'details_end_tag' => '<section class="cta-row cta-row--black">"',
    'details_spliter' => '<li class="results__item results__item--vehicle product-',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)" class="product-item__link">/',
        'year' => '/<span class="product__name-trim">\s*[^>]+>\s*<small>(?<year>[^<]+)/',
        'make' => '/product__name-make">(?<make>[^<]+)/',
        'model' => '/product__name-model">(?<model>[^<]+)/',   
        'stock_number' => '/Stock:<\/strong>\s*(?<stock_number>[^<]+)/',     
        'price' => '/Total Price:<\/small>\s*(?<price>[^<]+)/',  
    ),
    'data_capture_regx_full' => array(
          'exterior_color' => '/Colour<\/span>[^>]+>(?<exterior_color>[^<]+)/',
          'engine' => '/Engine<\/span>[^>]+>(?<engine>[^<]+)/',
          'title' => '/<meta property="og:title" content="(?<title>[^"]+)/',
          'transmission' => '/Transmission<\/span>\s*.*\s*[^>]+>(?<transmission>[^<]+)/', 
    ),
    'next_page_regx' => '/<strong class="current">.*\s*<a href="(?<next>[^"]+)" class="btn" rel="next"/',
    'images_regx' => '/<div class="embed-container">\s*<img src="(?<img_url>[^"]+)" alt=/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
