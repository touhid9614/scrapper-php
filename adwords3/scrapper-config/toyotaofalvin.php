<?php

    global $scrapper_configs;

    $scrapper_configs['toyotaofalvin'] = array(
        'entry_points' => array(
            'new'    => 'https://www.toyotaofalvin.com/new-vehicles/',
            'used'   => 'https://www.toyotaofalvin.com/used-vehicles/'
        ),
        //'use-proxy' => true,
        'proxy-area'        => 'FL',
        'vdp_url_regex'     => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.hotspot_content','.owl-item'],
        'picture_nexts'     => ['.prev','.owl-next'],
        'picture_prevs'     => ['.next','.owl-prev'],
        'details_start_tag' => '<tr class="hidden-xs">',
        'details_end_tag'   => '<tr class="load-more-results infinite-scrolling-trigger">',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'stock_number'  => '/<span>STOCK #:\s*(?<stock_number>[^<]+)/',
            'title'         => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|Certified)\s*(?<title>[^<]+)/',
            'url'           => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|Certified)\s*(?<title>[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/class="price-block our-price[^"]*"\s*>[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            'certified'     => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="[^"]+">\s+(?<certified>Certified)\s*[^<]+/',
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         =>'/<meta itemprop="price" content="(?<price>[^"]+)/',

        ),
        'next_query_regx'   => '/"ajax_(?<param>nonce)":"(?<value>[^"]+)"/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
    add_filter('filter_toyotaofalvin_post_data', 'filter_toyotaofalvin_post_data', 10, 3);
    add_filter('filter_toyotaofalvin_data', 'filter_toyotaofalvin_data');
    add_filter("filter_toyotaofalvin_field_images", "filter_toyotaofalvin_field_images");
    add_filter("filter_toyotaofalvin_field_price", "filter_toyotaofalvin_field_price", 10, 3);
    add_filter('filter_toyotaofalvin_field_title', 'filter_toyotaofalvin_field_title');

    $toyotaofalvin_current_page = array(
        'new'   => 1,
        'used'  => 1
    );
    $toyotaofalvin_nonce = '';
   
    function filter_toyotaofalvin_post_data($post_data, $stock_type,$data)
    {
        global $toyotaofalvin_current_page,$toyotaofalvin_nonce;
        
        $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
        $page_count_regex = '/"page_count"\s*:"(?<page_count>[^"]+)"/';
        $matches = [];
        $nonce = '';
        $page_count=''; 
        
        if($data && preg_match($nonce_regex, $data, $matches)) {
            $nonce = $matches['nonce'];
        }
        if($data && preg_match($page_count_regex, $data, $matches)) {
            $page_count = $matches['page_count'];
        }
        slecho("ajax_nonce : ".$nonce);
        if($nonce && isset($nonce)) { $toyotaofalvin_nonce=$nonce; }
        slecho("global ajax_nonce : ".$toyotaofalvin_nonce);
        $post_data = '';
        if($post_data == '')
        {
            $post_data="page=$toyotaofalvin_current_page[$stock_type]";
            $toyotaofalvin_current_page[$stock_type]++;
            
            if (isset($page_count) && $page_count) {
                if ($toyotaofalvin_current_page[$stock_type] > $page_count+1) {
                    return null;
                }
            }
        }
    
        
        
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$toyotaofalvin_nonce&_post_id=$post_id&_referer=$referer";
                   
    }

    function filter_toyotaofalvin_data($data)
    {
      global $toyotaofalvin_nonce;
      if($data)
        {
            if(isJSON($data)){
                slecho("data is in jSon format");
                $obj = json_decode($data);

                $data = "{$obj->results}\n{$obj->pagination}\n\"ajax_nonce\":\"{$toyotaofalvin_nonce}\"\n\"page_count\" :\"{$obj->page_count}\"";
            }
            else { slecho("data is not in jSon format") ; }
        }

        return $data;
    }

    function filter_toyotaofalvin_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Toyota of Alvin Price: $price");
        }
        
        $sale_regex =  '/<span class="price-label">\s*Sale Price\s*<\/span>\s*<span class="price">\s*(?<price>[\$0-9,]+)/';
        $price_regex = '/<span class="price-label">\s*Price\s*<\/span>\s*<span class="price">\s*(?<price>[\$0-9,]+)/';
        $msrp_regex =  '/<span class="price-label">\s*MSRP\s*<\/span>\s*<span class="price">\s*(?<price>[\$0-9,]+)/';
        
        $matches = [];
        
        if(preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Sale Price: {$matches['price']}");
        }
        
        if(preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex Price: {$matches['price']}");
        }
        
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
     function filter_toyotaofalvin_field_title($title)
    {
        return trim($title);
    }
    
    
    function filter_toyotaofalvin_field_images($im_urls)
    {
        if(count($im_urls) < 2) { return array(); }
        return $im_urls;
    }