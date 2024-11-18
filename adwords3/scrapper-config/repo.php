<?php
    global $scrapper_configs;

    $scrapper_configs['repo'] = array(
        'entry_points' => array(
            'used'    => 'https://www.repo.com/browse/vehicles/',
        ),
        
        'vdp_url_regex'     => '/\/listing\//i',
        'ty_url_regex'      => '/message\/success\//i',
        'use-proxy'         => true,
        'refine'            => false,
        'picture_selectors' => ['.photo'],
        'picture_nexts'     => ['#pbNextBtn'],
        'picture_prevs'     => ['#pbPrevBtn'],
        'details_start_tag' => '<div class="listings">',
        'details_end_tag'   => '<ul class="pagination">',
        'details_spliter'   => '<div class="row divider">',
        'must_contain_regex'=> '/<a class="thumbnail[^"]+" href="[^"]+"><img src="[^"]+"[^>]+><\/a>/',
        
        'data_capture_regx' => array(
            'year'              => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',   
            'make'              => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',
            'model'             => '/<p class="description">\s*(?<year>[0-9]+) (?<make>[^\s]+) (?<model>[a-z A-Z]+)/',
            'price'             => '/<span class="price">\$(?<price>[^<]+)/',
            'url'               => '/href="(?<url>[^"]+)">More Info/',
            'stock_number'      => '/class="stock_num">Stock\s#:(?<stock_number>[^<]+)<\/small>/',
            'kilometres'        => '/<small class="odometer">\s(?<kilometres>[^\/]+)/',
        ),
        'data_capture_regx_full' => array(
            'stock_number'      => '/<li class="panel-body">\s*Stock #(?<stock_number>[0-9 A-Z a-z]+)/',
            'exterior_color'    => '/Body:<\/th><td>(?<exterior_color>[^<]+)/',
            'interior_color'    => '/Interior:<\/th><td>(?<interior_color>[^<]+)/',
            'transmission'      =>'/Transmission:<\/th><td>(?<transmission>[^<]+)/',
            'engine'            =>'/Engine:<\/th><td>(?<engine>[^<]+)/',
            'body_style'        => '/>(?<body_style>[^<]+)<\/a><\/li>\s*<li class="active">/',
        ) ,
        'next_page_regx'    => '/<li class="active">\s*<a href="[^"]+">[^<]+<\/a>\s*<\/li>\s*<li>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a href="(?<img_url>[^"]+)" rel="gallery" class="photo thumbnail">/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_repo_next_page", "filter_repo_next_page",10,2);
    
    function filter_repo_next_page($next,$current_page) {
        slecho("Filtering Next url : " .$next);
        return $next;
      //  return urlCombine("https://www.repo.com", $next);
    }


    
    