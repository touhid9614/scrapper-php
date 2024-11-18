<?php

global $scrapper_configs;

    $scrapper_configs['touchdownauto118'] = array (
    'entry_points' => array(
                'used'=> 'http://www.touchdownauto.ca/en-CA/used/inventory/-/-/-/0'
    ),
    'vdp_url_regex'     => '/\/(?:new|used)\/[^0-9]+[0-9]{4}/i',
       // 'ty_url_regex'      => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts'     => ['.next'],
    'picture_prevs'     => ['.prev'],
    'details_start_tag' => '<div class="listing">',
    'details_end_tag'   => '<footer class="footer">',
    'details_spliter'   => '<div class="row product',
    
    'data_capture_regx' => array(
           'url'           => '/<a href="(?<url>[^"]+)" class="btn btn-details">Details/',
           'year'          => '/href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s"]*)(?<trim>[^"#]*)/',
           'make'          => '/href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s"]*)(?<trim>[^"#]*)/',
           'model'         => '/href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s"]*)(?<trim>[^"#]*)/', 
           'trim'          => '/href="[^"]+" title="(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s"]*)(?<trim>[^"#]*)/', 
           'exterior_color'=> '/Exterior color<\/strong>\s*:\s*(?<exterior_color>[^<]+)/',
           'interior_color'=> '/Interior color<\/strong>\s*:\s*(?<interior_color>[^<]+)/',
           'price'         => '/<span class="price">&#36\;(?<price>[0-9,]+)/',
           'transmission'  => '/Transmission<\/strong>\s*:\s*(?<transmission>[^<]+)/',          
           'stock_number'  => '/stock #\s*:\s*(?<stock_number>[^<]+)/',
           'kilometres'    => '/Mileage<\/strong>\s*:\s*(?<kilometres>[^<]+)/',

       ),
       'data_capture_regx_full' => array(
           

         ),
       'next_page_regx'    => '/<li class="active"><a[^>]+><span[^<]+<\/[^>]+><\/a><\/li><li><a href="(?<next>[^"]+)/',
       'images_regx'       => '/<img id="img_[0-9]+" src=\'(?<img_url>[^\']+)/',
       'images_fallback_regx'=> '/<meta property="og:image" content="(?<img_url>[^"]+)/',
   );

