<?php
global $scrapper_configs;
$scrapper_configs["mbofmobilecom"] = array( 
'entry_points' => array(
        'new' => 'https://www.mbofmobile.com/new-inventory/index.htm',
        'used' => 'https://www.mbofmobile.com/used-inventory/index.htm',
    ),
    'refine' => false,
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    
    'picture_selectors' => ['.pswp-thumbnail'],
    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">',
    'details_end_tag' => '<div class="clearfix ft">',
    'details_spliter' => '<li class="item hproduct clearfix',
    'data_capture_regx' => array(
        'url' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'title' => '/<h3 class="[^>]+>\s*<a href="(?<url>[^"]+)"\sclass=[^>]+>(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/(?:Price|MSRP)\s*<\/span>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage<\/label>\s*<span>(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^\<]+)/',
         'vin' => '/VIN[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'engine' => '/Engine<\/label>\s*<span>(?<engine>[^\<]+)/',
        'transmission' => '/Transmission<\/label>\s*<span>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Color<\/label>\s*<span>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Color<\/label>\s*<span>(?<interior_color>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx' => '/next-btn" data-href="(?<next>[^"]+)">/',
      'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);
