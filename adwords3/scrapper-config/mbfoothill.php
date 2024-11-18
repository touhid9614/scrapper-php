<?php

    global $scrapper_configs;

    $scrapper_configs['mbfoothill'] = array(
        'entry_points' => array(
            'new'    => 'https://www.mbfoothill.com/new-vehicles/',
            'used'   => 'https://www.mbfoothill.com/used-vehicles/'
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<div class="grid-view-results-wrapper">',
        'details_end_tag'   => "<ul class='pagination'",
        'details_spliter'   => '<div class="vehicle-wrap">',
        'data_capture_regx' => array(
            'stock_number'  => '/class="grid-stock">Stock:\s(?<stock_number>[^<]+)/',
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'exterior_color'=> '/class="grid-color">Exterior:\s(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:\s(?<interior_color>[^<]+)/',
            'kilometres'    => '/class="grid-miles">\s*Mileage:\s(?<kilometres>[^<]+)/',  
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'certified'     => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="[^"]+">\s+(?<certified>Certified)\s*[^<]+/'
        ),
         'data_capture_regx_full' => array(
            'transmission'  => '/Trans:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',                    
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'vin'           => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/'
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
    );
    
    add_filter('filter_mbfoothill_post_data', 'filter_mbfoothill_post_data',10, 3);
    add_filter('filter_mbfoothill_data', 'filter_mbfoothill_data');
    add_filter("filter_mbfoothill_field_images", "filter_mbfoothill_field_images");
    
    $mbfoothill_nonce = '';
    
    function filter_mbfoothill_post_data($post_data, $stock_type, $data)
    {
        global $mbfoothill_nonce;
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
        if($nonce && isset($nonce)) { $mbfoothill_nonce=$nonce; }
        slecho("global ajax_nonce : ".$mbfoothill_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }       
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$mbfoothill_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_mbfoothill_data($data)
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
    function filter_mbfoothill_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
   