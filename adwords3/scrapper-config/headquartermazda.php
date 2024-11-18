<?php

    global $scrapper_configs;

    $scrapper_configs['headquartermazda'] = array(
        'entry_points' => array(
            'new'    => 'https://www.headquartermazda.com/new-vehicles/',
            'used'   => 'https://www.headquartermazda.com/used-vehicles/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.swiper-slide'],
        'picture_nexts'     => ['.swiper-button-next'],
        'picture_prevs'     => ['.swiper-button-prev'],
        'details_start_tag' => '<table class="results_table">',
        'details_end_tag'   => '</table>',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:(?<stock_number>[^<]+)/',
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Kilometers:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'certified'     => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="[^"]+">\s+(?<certified>Certified)\s*[^<]+/'
        ),
        'data_capture_regx_full' => array(
            
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
           
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
    );
    
    add_filter('filter_headquartermazda_post_data', 'filter_headquartermazda_post_data',10, 3);
    add_filter('filter_headquartermazda_data', 'filter_headquartermazda_data');
    add_filter("filter_headquartermazda_field_images", "filter_headquartermazda_field_images");
    
    $headquartermazda_nonce = '';
    
    function filter_headquartermazda_post_data($post_data, $stock_type, $data)
    {
        global $headquartermazda_nonce;
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
        if($nonce && isset($nonce)) { $headquartermazda_nonce=$nonce; }
        slecho("global ajax_nonce : ".$headquartermazda_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$headquartermazda_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_headquartermazda_data($data)
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
    function filter_headquartermazda_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
   