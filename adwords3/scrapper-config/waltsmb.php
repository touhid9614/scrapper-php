<?php

    global $scrapper_configs;

    $scrapper_configs['waltsmb'] = array(
        'entry_points' => array(
            'new'    => 'https://www.waltersmercedesbenzofriverside.com/new-vehicles/',
            //'used'   => 'https://www.waltersmercedesbenzofriverside.com/used-vehicles/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)-[0-9]{4}-/i',
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
            'stock_number'  => '/Stock #: (?<stock_number>[^<]+)/',
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'kilometres'    => '/Mileage:<\/span>\s*<[^>]+>(?<kilometres>[^\n<]+)/',
            'price'         => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'
        ),
        'data_capture_regx_full' => array(           
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'trim'          => '/data-vehicle=\'.*"trim":"(?<trim>[^"]+)"/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
           // 'certified'     => '/<meta itemprop="name" content="(?<certified>Certified)/'
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
    );
    
    add_filter('filter_waltsmb_post_data', 'filter_waltsmb_post_data', 10, 3);
    add_filter('filter_waltsmb_data', 'filter_waltsmb_data');
    add_filter('filter_waltsmb_field_images','filter_waltsmb_field_images');
    
    add_filter('filter_waltsmb_field_trim','filter_waltsmb_field_trim');

     function filter_waltsmb_field_trim($trim)
    {
        return substr(strstr($trim," "), 1);
    }
    
    
    
    $waltsmb_nonce = '';
    
    function filter_waltsmb_post_data($post_data, $stock_type, $data)
    {
        global $waltsmb_nonce;
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
        if($nonce && isset($nonce)) { $waltsmb_nonce=$nonce; }
        slecho("global ajax_nonce : ".$waltsmb_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&show_all_filters=false&_nonce=$waltsmb_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_waltsmb_data($data)
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
    
    function filter_waltsmb_field_images($im_urls)
    {
        array_push($im_urls, array_shift($im_urls));
        
        return $im_urls;
        
    }
   