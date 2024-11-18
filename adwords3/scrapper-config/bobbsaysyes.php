<?php
    global $scrapper_configs;

    $scrapper_configs['bobbsaysyes'] = array(
        'entry_points' => array(
            
            'used'  => 'http://www.bobbsaysyes.com/used-cars-trucks-columbus-ohio/'
        ),
        'vdp_url_regex'     => '/\/listing\/[0-9]{4}-/i',
        'ajax_url_match'    => 'wp-admin/admin-ajax.php',
        'ajax_resp_match'   => 'Sent Successfully',

        'use-proxy' => true,
        'picture_selectors' => ['.slides li'],
        'picture_nexts'     => ['fancybox-next'],
        'picture_prevs'     => ['.fancybox-prev'],
        
        'details_start_tag' => '<div class=\'row generate_new\'>',
        'details_end_tag'   => '<footer',
        'details_spliter'   => 'class="inventory clearfix margin-bottom-20 styled_input ">',
        
        'data_capture_regx' => array(
            'stock_number'  => '/Stock Number:\s*<\/td>\s*<td[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'year'          => '/class="title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'make'          => '/class="title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'model'         => '/class="title">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*)\s*[^<]*)/',
            'price'         => '/class="figure">(?<price>\$[0-9,]+)/',
            'body_style'    => '/Body Style:\s*<\/td>\s*<td[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:\s*<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:\s*<\/td>\s*<td[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Color:\s*<\/td>\s*<td[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:\s*<\/td>\s*<td[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:\s*<\/td>\s*<td[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="inventory"\s*href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'year'              => '/Year: <\/td><td>(?<year>[^<]+)/',
            'make'              => '/Make: <\/td><td>(?<make>[^<]+)/',
            'model'             => '/Model: <\/td><td>(?<model>[^<]+)/',
            'trim'              => '/Trim: <\/td><td>(?<trim>[^<]+)/',
            'engine'            => '/Engine: <\/td><td>(?<engine>[^<]+)/',
            'transmission'      => '/Transmission: <\/td><td>(?<transmission>[^<]+)/',
            'stock_number'      => '/Stock Number: <\/td><td>(?<stock_number>[^<]+)/',
            'price'             => '/Price: <\/td><td>(?<price>[^<]+)/'
            
            
        ),
        'next_query_regx'      => '/<li data-page=\'[0-9]*\' class=\'disabled number\'><a href=\'#\'>[0-9]*<\/a><\/li>\s*<li data-(?<param>[^=]+)=\'(?<value>[0-9]*)\'/',
        'images_regx'       => '/<li data-thumb="[^"]+"> <img src="(?<img_url>[^"]+)"/',
    );
    
   add_filter('filter_bobbsaysyes_post_data', 'filter_bobbsaysyes_post_data');
    
    function filter_bobbsaysyes_post_data($post_data) {
        return str_replace('page=', 'paged=', $post_data);
    }