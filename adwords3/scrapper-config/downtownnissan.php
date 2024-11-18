<?php
global $scrapper_configs;
 $scrapper_configs["downtownnissan"] = array( 
	 'entry_points' => array(
        'new' => 'https://www.downtownnissan.com/inventory/new/',
        'used' => 'https://www.downtownnissan.com/inventory/Used/'
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
        'price' => '/Net Price<\/div>[^\$]+\$[^>]+>(?<price>[0-9,]+)/',
      
    ),
     
    'data_capture_regx_full' => array(
  
    ),
     
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx'    => '/data-lightbox="(?<img_url>[^"]+)"/',
);

