<?php

  global $scrapper_configs;

    $scrapper_configs['centralchevyauto'] = array(
        'entry_points' => array(
            'new'   => 'https://www.centralchevyauto.com/new-vehicles/',
            'used'  => 'https://www.centralchevyauto.com/used-vehicles/'
        ),
         'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
         'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.lazyOwl.lazyload-loading'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<table class="results_table">',
        'details_end_tag'   => '</table>',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'url'                 => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'year'                => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'make'                => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'model'               => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'title'               => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'price'               => '/Sale Price<\/span>[^\$]+(?<price>\$[0-9,]+)/',
            'engine'              => '/Engine:<\/span>\s*<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'stock_number'        => '/Stock #:\s(?<stock_number>[^<]+)/',    
            'transmission'        => '/Trans:<\/span>\s*[^>]+>\s(?<transmission>[^\n<]+)/',
            'exterior_color'      => '/Exterior:<\/span>[^>]+>\s(?<exterior_color>[^\n<]+)/',
           
        ),
        'data_capture_regx_full' => array(                
             'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
             'model'         => '/<meta itemprop="model" content="(?<model>[^"]*)/',
             'body_style'    => '/Body:<\/dt>\s*<dd>(?<body_style>[^<]+)/'
        ) ,
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)/',
       // 'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter('filter_centralchevyauto_post_data', 'filter_centralchevyauto_post_data', 10, 3);
    add_filter('filter_centralchevyauto_data', 'filter_centralchevyauto_data');
    
    $centralchevyauto_nonce = '';
            
    function filter_centralchevyauto_post_data($post_data, $stock_type, $data)
    {
        global $centralchevyauto_nonce;
        if($post_data == '')
        {
            $post_data = "page=1";
        }
        
        $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
        $nonce = '';
        $matches = [];
        
        if($data && preg_match($nonce_regex, $data, $matches)) {
            $nonce = $matches['nonce'];
        }
        slecho("ajax_nonce : ".$nonce);
        if($nonce && isset($nonce)) { $centralchevyauto_nonce=$nonce; }
        slecho("global ajax_nonce : ".$centralchevyauto_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$centralchevyauto_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_centralchevyauto_data($data)
    {
        if($data)
        {
            if(isJSON($data)){
                slecho("data is in jSon format");
                $obj = json_decode($data);

                $data = "{$obj->results}\n{$obj->pagination}";
            }
            else { slecho("data is not in jSon format"); }
        }

        return $data;
    }