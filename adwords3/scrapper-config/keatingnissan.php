<?php

    global $scrapper_configs;

    $scrapper_configs['keatingnissan'] = array(
        'entry_points' => array(
            'new'   => 'http://www.keatingnissan.com/new-vehicles/',
            'used'  => 'http://www.keatingnissan.com/used-vehicles/'
        ),
        'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'use-proxy' => true,
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<table class="results_table">',
        'details_end_tag'   => '</table>',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'url'                 => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
            'year'                => '/data-year="(?<year>[0-9]{4})/',
            'make'                => '/data-make="(?<make>[^"]+)/',
            'model'               => '/data-model="(?<model>[^"]+)/',
            'title'               => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
            'price'               => '/class="price-block our-price[^"]*" >[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'engine'              => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'stock_number'        => '/<span>STOCK #:\s*(?<stock_number>[^<]+)/',
            'kilometres'          => '/Mileage:<\/span>\s*<span[^>]+>\s*(?<kilometres>[^<]+)/',
            'transmission'        => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'exterior_color'      => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'      => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/'
        ),
        'data_capture_regx_full' => array(                
             'make'          => '/ <meta itemprop="brand" content="(?<make>[^"]+)/',
             'model'         => '/  <meta itemprop="model" content="(?<model>[^"]*)/',
             'body_style'    => '/Body:<\/dt>\s*<dd>(?<body_style>[^<]+)/'
        ) ,
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)/'
    );
    add_filter('filter_keatingnissan_post_data', 'filter_keatingnissan_post_data', 10, 3);
    add_filter('filter_keatingnissan_data', 'filter_keatingnissan_data');
    
    $keatingnissan_nonce = '';
    
    function filter_keatingnissan_post_data($post_data, $stock_type, $data)
    {
        global $keatingnissan_nonce;
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
        if($nonce && isset($nonce)) { $keatingnissan_nonce=$nonce; }
        slecho("global ajax_nonce : ".$keatingnissan_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$keatingnissan_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_keatingnissan_data($data)
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