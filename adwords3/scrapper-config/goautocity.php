<?php

    global $scrapper_configs;

    $scrapper_configs['goautocity'] = array(
        'entry_points' => array(
            'used'   => 'https://www.goautocity.com/current-inventory/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/used/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<table class="results_table">',
        'details_end_tag'   => '</table>',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'stock_number'  => '/<span>STOCK #:\s*(?<stock_number>[^<]+)/',
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+)\s*(?<model>[^<]+))/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+)\s*(?<model>[^<]+))/'
        ),
        'data_capture_regx_full' => array(
            
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
           
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
    );
    
    add_filter('filter_goautocity_post_data', 'filter_goautocity_post_data', 10, 3);
    add_filter('filter_goautocity_data', 'filter_goautocity_data');

 
    $goautocity_nonce = '';
    
    function filter_goautocity_post_data($post_data, $stock_type, $data)
    {
        global $goautocity_nonce;
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
        if($nonce && isset($nonce)) { $goautocity_nonce=$nonce; }
        slecho("global ajax_nonce : ".$goautocity_nonce);
        $post_id = 5;
        $referer = '/current-inventory/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/current-inventory/';
        }
        
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$goautocity_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_goautocity_data($data)
    {
        global $goautocity_nonce;
        if($data)
        {
            if(isJSON($data)){
                slecho("data is in jSon format");
                $obj = json_decode($data);

                $data = "{$obj->results}\n{$obj->pagination}\n\"ajax_nonce\":\"{$goautocity_nonce}\"\n\"page_count\" :\"{$obj->page_count}\"";
            }
            else  { slecho("data is not in jSon format"); }
        }

        return $data;
    }
    