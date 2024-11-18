<?php
global $scrapper_configs;
 $scrapper_configs["goimports"] = array( 
	 'entry_points' => array(
            //'new'    => 'https://www.goimports.com/new-vehicles/',
            'used'   => 'https://www.goimports.com/used-vehicles/'
        ),
        'no_scrap'          => true,
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-schedule-your-test-drive\//i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'refine'            => false,
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        //'details_start_tag' => '<table class="results_table">',
        //'details_end_tag'   => '</table>',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'stock_number'  => '/<span class="stock-label">Stock #:\s(?<stock_number>[^<]+)/',
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/data-year="(?<year>[0-9]{4})"\n/',
            'make'          => '/data-make="(?<make>[^"]+)"\n/',
            'model'         => '/data-model="(?<model>[^"]+)"\n/',
            'price'         => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Kilometers:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'body_style'    => '/data-body="(?<body_style>[^"]+)"\n/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            
        ),
        'next_query_regx'   => '/<div class="vehicle-card-(?<param>price)"(?<value>>)/',
         'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/',
        'images_fallback_regx' => '/<div class="item">\s*<img class="[^"]+" src="(?<img_url>[^"]+)"/',
       
    );
    
    add_filter('filter_goimports_post_data', 'filter_goimports_post_data',10, 3);
    add_filter('filter_goimports_data', 'filter_goimports_data');
    add_filter("filter_goimports_field_images", "filter_goimports_field_images");
    
    $goimports_nonce = '';
    $goimports_page_num    = 0;
    
    
    function filter_goimports_post_data($post_data, $stock_type, $data)
    {   
        global $goimports_page_num;
        global $goimports_nonce;
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
        if($nonce && isset($nonce)) { $goimports_nonce=$nonce; }
        slecho("global ajax_nonce : ".$goimports_nonce);
        $post_id = 6;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 7;
            $referer = '/used-vehicles/';
        }
        $goimports_page_num++;
        return "action=im_ajax_call&perform=get_results&page=$goimports_page_num&show_all_filters=false&_nonce=$goimports_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_goimports_data($data)
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
    function filter_goimports_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }