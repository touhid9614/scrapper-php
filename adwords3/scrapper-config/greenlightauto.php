<?php
    global $scrapper_configs;

    $scrapper_configs['greenlightauto'] = array(
          'entry_points' => array(
            'used'    => 'http://www.greenlightauto.ca/browse_used',
        ),
        
        'vdp_url_regex'     => '/\/details\//i',
        'ty_url_regex'      => '/message\/success\//i',
        'use-proxy'         => true,
        'refine'            => false,
        'picture_selectors' => ['.ps-item img'],
        'picture_nexts'     => ['.ps-next'],
        'picture_prevs'     => ['.ps-prev'],
        'details_start_tag' => '<div id="listing-content">',
        'details_end_tag'   => '<ul class="pagination">',
        'details_spliter'   => '<div class="clear">',
       // 'must_contain_regex'=> '/<a class="thumbnail[^"]+" href="[^"]+"><img src="[^"]+"[^>]+><\/a>/',
        
        'data_capture_regx' => array(
            'year'              => '/<h4>\s*<a href="[^>]+><span>(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',   
            'make'              => '/<h4>\s*<a href="[^>]+><span>(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',
            'model'             => '/<h4>\s*<a href="[^>]+><span>(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',
            'price'             => '/<span class="price">(?<price>[^<]+)/',
            'url'               => '/<h4>\s*<a href="(?<url>[^"]+)"><span>(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',
            'stock_number'      => '/<div data="(?<stock_number>[^"]+)" id="/',
            'kilometres'        => '/Mileage: <\/span>[^>]+>(?<kilometres>[^<]+)/',
            'engine'            =>'/Engine: <\/span>[^>]+>(?<engine>[^<]+)/',
            'body_style'        => '/Body Style: <\/span>[^>]+>(?<body_style>[^<]+)/',
            'exterior_color'    => '/Exterior Color: <\/span>[^>]+>(?<exterior_color>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
           
          
            
            'transmission'      =>'/Transmission<\/span>[^>]+>(?<transmission>[^<]+)/',
            
            
        ) ,
       // 'next_page_regx'    => '/<li class="active">\s*<a href="[^"]+">[^<]+<\/a>\s*<\/li>\s*<li>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<img src="(?<img_url>[^"]+)/',
        //'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_greenlightauto_next_page", "filter_greenlightauto_next_page",10,2);
    
    function filter_greenlightauto_next_page($next,$current_page) {
        slecho("Filtering Next url : " .$next);
        return $next;
      //  return urlCombine("https://www.greenlightauto.com", $next);
    }


    
    