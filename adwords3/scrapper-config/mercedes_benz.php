<?php

    global $scrapper_configs;

    $scrapper_configs['mercedes_benz'] = array(
        'entry_points' => array(
            'new'    => 'https://www.mercedes-benz-countryhills.ca/new-vehicles/mercedes-benz-passenger-cars/',
            'used'   => 'https://www.mercedes-benz-countryhills.ca/used-vehicles/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<div class="grid-view-results-wrapper">',
        'details_end_tag'   => '<div class="disclaimer-small">',
        'details_spliter'   => '<div class="vehicle-wrap">',
        'data_capture_regx' => array(
           // 'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/',
            'year'          => '/data-year="(?<year>[^"]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/class="price-block our-price[^"]*"\s*>\s*.*\s*.*\s*[^\n]+\s*<span class="price">\s*(?<price>\$[0-9,]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">/',
            'certified'     => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="[^"]+">\s*(?<certified>Certified)\s*[^<]+/',
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Stock<\/span><span[^>]+>(?<stock_number>[^<]+)/',
            'transmission'  => '/Trans:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometers:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
            
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
           
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
    );
    
    add_filter('filter_mercedes_benz_post_data', 'filter_mercedes_benz_post_data',10, 3);
    add_filter('filter_mercedes_benz_data', 'filter_mercedes_benz_data');
    add_filter("filter_mercedes_benz_field_images", "filter_mercedes_benz_field_images");
    
    $mercedes_benz_nonce = '';
    
    function filter_mercedes_benz_post_data($post_data, $stock_type, $data)
    {
        global $mercedes_benz_nonce;
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
        if($nonce && isset($nonce)) { $mercedes_benz_nonce=$nonce; }
        slecho("global ajax_nonce : ".$mercedes_benz_nonce);
        $post_id = 3177;
        $referer = '/new-vehicles/mercedes-benz-passenger-cars/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$mercedes_benz_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_mercedes_benz_data($data)
    {
        if($data)
        {
            if(isJSON($data)){
                slecho("data is in jSon format");
                $obj = json_decode($data);

                $data = "{$obj->results}\n<div class=\"disclaimer-small\">\n{$obj->pagination}\n\"ajax_nonce\":\"{$_nonce}\"\n\"page_count\" :\"{$obj->page_count}\"";
            }
            else { slecho("data is not in jSon format"); }
        }

        return $data;
    }
    function filter_mercedes_benz_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
   