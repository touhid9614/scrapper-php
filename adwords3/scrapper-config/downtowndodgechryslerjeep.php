<?php
    global $scrapper_configs;

    $scrapper_configs['downtowndodgechryslerjeep'] = array(
        'entry_points' => array(
            'new'   => 'https://www.buydowntown.com/new-vehicles/',
            'used'  => 'https://www.buydowntown.com/used-vehicles/'
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
           // 'stock_number'  => '/Stock<\/span>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            //'kilometres'    => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            'price'         => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            //'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
           // 'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            //'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
           // 'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'

        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Stock<\/span>[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
            'transmission'  => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
            

        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
       
    );
    add_filter('filter_downtowndodgechryslerjeep_post_data', 'filter_downtowndodgechryslerjeep_post_data',10, 3);
    add_filter('filter_downtowndodgechryslerjeep_data', 'filter_downtowndodgechryslerjeep_data');
    add_filter("filter_downtowndodgechryslerjeep_field_images", "filter_downtowndodgechryslerjeep_field_images");
    
    $downtowndodgechryslerjeep_nonce = '';
    
    function filter_downtowndodgechryslerjeep_post_data($post_data, $stock_type, $data)
    {
        global $downtowndodgechryslerjeep_nonce;
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
        if($nonce && isset($nonce)) { $downtowndodgechryslerjeep_nonce=$nonce; }
        slecho("global ajax_nonce : ".$downtowndodgechryslerjeep_nonce);
        $post_id = 5;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 6;
            $referer = '/used-vehicles/';
        }
      
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$downtowndodgechryslerjeep_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_downtowndodgechryslerjeep_data($data)
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
    function filter_downtowndodgechryslerjeep_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
     