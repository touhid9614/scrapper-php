<?php
global $scrapper_configs;
 $scrapper_configs["orilliahyundaicom"] = array( 
	'entry_points' => array(
             'used'  => 'https://orilliahyundai.com/helper/escadsfilter/?pcompid=30263&page=1',
            'new'   => 'https://orilliahyundai.com/helper/escadsfilter/?pcompid=30249&page=1',
           
          
        ),
        'vdp_url_regex'     => '/\/adid\/[^\/]+\/[0-9]+/i',
        'use-proxy' => true,
      'refine'=>false,
        'details_start_tag' => '<div id="products" class="view-group">',
        'details_end_tag'   => '<!-- End Model Row -->',
        'details_spliter'   => '<div class="item col-xs-4 col-lg-4  ',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock No.: <\/strong><span>\s*(?<stock_number>[^<]+)/',
            'year'          => '/Year: <\/strong><span>\s*(?<year>[0-9]{4})/',
            'make'          => '/Make: <\/strong><span>\s*(?<make>[^<]+)/',
            'model'         => '/Model: <\/strong><span>\s*(?<model>[^<]+)/',
            'price'         => '/class="price">\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^\s*]+)/',
            'engine'        => '/Engine: <\/strong><span>\s*(?<engine>[^<]+)/',
            'kilometres'    => '/Km: <\/strong><span>\s*(?<kilometres>[^<]+)/',
            'url'           => '/<a class="View-Details pushstate" href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            
           // 'trim'              => '/Trim: <\/td><td>(?<trim>[^<]+)/',
            'transmission'  => '/Transmission: <\/td><td>(?<transmission>[^<]+)/',
            'vin'           => '/Vin\s*<\/div>[^>]+>\s*(?<vin>[^\s<]+)/',
           // 'body_style'    => '/Body Style:\s*<\/td>\s*<td[^>]+>(?<body_style>[^<]+)/',
            'exterior_color'=> '/Color\s*<\/div>[^>]+>\s*(?<exterior_color>[^\s<]+)/',
           // 'interior_color'=> '/Interior Color:\s*<\/td>\s*<td[^>]+>(?<interior_color>[^<]+)/',
           
           
            
            
        ),
        'next_query_regx'   => '/(?<param>page)\/(?<value>[0-9]*)\/" onclick="[^>]+>Next/',
        'images_regx'       => '/<img loading="eager".*src="(?<img_url>[^"]+)"\s*alt=/',
    );