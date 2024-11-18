<?php
    global $scrapper_configs;

    $scrapper_configs['yokemtoyota'] = array(
        'entry_points' => array(
            'new'   => 'http://www.yokemtoyota.com/new-vehicles/',
            'used'  => 'http://www.yokemtoyota.com/used-vehicles/'
        ),
       
       
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
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
            'title'         => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)\s*(?<title>[^<]+)/',
            'url'           => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Used|Pre-Owned)\s*(?<title>[^<]+)/',
            'price'         => '/class="price-block our-price "\s*>[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            //'certified'     => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="[^"]+">\s*(?<certified>CERTIFIED)\s*[^<]+/',

        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',

        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
       
    );
    add_filter('filter_yokemtoyota_post_data', 'filter_yokemtoyota_post_data', 10, 3);
    add_filter('filter_yokemtoyota_data', 'filter_yokemtoyota_data');
    add_filter("filter_yokemtoyota_field_price", "filter_yokemtoyota_field_price", 10, 3);
    add_filter("filter_yokemtoyota_field_images", "filter_yokemtoyota_field_images");

    function filter_yokemtoyota_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Price: $price");
        }
        
        $msrp_regex =  '/MSRP.*class=\'value[^>]+>(?<price>[^<]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }
    $yokemtoyota_nonce = '';
            
    function filter_yokemtoyota_post_data($post_data, $stock_type, $data)
    {
        global $yokemtoyota_nonce;
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
        if($nonce && isset($nonce)) { $yokemtoyota_nonce=$nonce; }
        slecho("global ajax_nonce : ".$yokemtoyota_nonce);
        $post_id = 5;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 6;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$yokemtoyota_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_yokemtoyota_data($data)
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
    function filter_yokemtoyota_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
    
    
