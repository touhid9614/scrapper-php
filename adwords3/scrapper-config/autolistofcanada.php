<?php

global $scrapper_configs;
$scrapper_configs["autolistofcanada"] = array(
    "entry_points" => array(
        'used' => 'http://www.autolistofcanada.com/inventory/',
    ),
    'vdp_url_regex' => '/\/listings\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.#home-slider-thumbs > div > ul > li'],
    'picture_nexts' => ['#home-slider-thumbs > ul > li.flex-nav-next > a'],
    'picture_prevs' => ['#home-slider-thumbs > ul > li.flex-nav-prev > a'],
    'details_start_tag' => '<div class="content-wrap car_listings row">',
        'details_end_tag'   => '<footer',
        'details_spliter'   => 'class="inventory clearfix',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock Number:\s*<\/td>\s*<td[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class=title>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'year'          => '/class=title>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'make'          => '/class=title>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'model'         => '/class=title>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'price'         => '/class=figure>\s*(?<price>\$[0-9,]+)/',
            'body_style'    => '/Body Style:\s*<\/td>\s*<td[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:\s*<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:\s*<\/td>\s*<td[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color:\s*<\/td>\s*<td[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:\s*<\/td>\s*<td[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:\s*<\/td>\s*<td[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class=inventory\s*href=(?<url>[^>]+)/'
        ),
        'data_capture_regx_full' => array(
//            'year'              => '/Year: <\/td><td>(?<year>[^<]+)/',
//            'make'              => '/Make: <\/td><td>(?<make>[^<]+)/',
//            'model'             => '/Model: <\/td><td>(?<model>[^<]+)/',
//            'trim'              => '/Trim: <\/td><td>(?<trim>[^<]+)/',
//            'engine'            => '/Engine: <\/td><td>(?<engine>[^<]+)/',
//            'transmission'      => '/Transmission: <\/td><td>(?<transmission>[^<]+)/',
//            'stock_number'      => '/Stock Number: <\/td><td>(?<stock_number>[^<]+)/',
//           
            
            
        ),
        'next_query_regx'   => '/data-page=[0-9]* class=\'disabled number\'><a\s*href=#>[0-9]*<\/a><\/li><li\s*data-(?<param>[^=]+)=(?<value>[0-9]*)/',
        'images_regx'       => '/data-thumb="[^"]+"> <img\s*src="(?<img_url>[^"]+)"/',
    );
   add_filter('filter_autolistofcanada_post_data', 'filter_autolistofcanada_post_data');
    
    function filter_autolistofcanada_post_data($post_data) {
        return str_replace('page=', 'paged=', $post_data);
    }