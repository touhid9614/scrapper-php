<?php
global $scrapper_configs;
 $scrapper_configs["teamblevinschryslerdodgejeep"] = array( 
 'entry_points' => array(
            'new'    => 'https://www.teamblevinschryslerdodgejeep.com/new-vehicles/',
            'used'   => 'https://www.teamblevinschryslerdodgejeep.com/used-vehicles/'
        ),
        //'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
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
            'stock_number'  => '/Stock #:\s*(?<stock_number>[^<]+)/',
            'title'         => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:NEW|PRE-OWNED|CERTIFIED)\s*(?<title>[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'url'           => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?:NEW|PRE-OWNED|CERTIFIED)\s*(?<title>[^<]+)/',
            'price'         => '/Price\s*<\/span>\s*[^>]+>\s*(?<price>[^<]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            //'url'           => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>.*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/',
            'certified'     => '/class="vehicle-title[^>]+>\s*<h2>\s*<a\s*href="[^"]+">\s+(?<certified>Certified)\s*[^<]+/',
            //'msrp'          => '/MSRP<\/span>\s*<span class="price">(?<msrp>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'year'          => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/<meta itemprop="manufacturer" content="(?<make>[^"]+)/',
            'model'         => '/<meta itemprop="model" content="(?<model>[^"]+)/',
           // 'original'      => '/<span class="ctabox-price-label">\s*MSRP\s*<\/span>\s*<span class="ctabox-price">\s*(?<original>[\$0-9,]+)/',
            'price'         => '/Pink Perfection Price<\/span><\/span>\s*[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/'
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<meta itemprop="image" content="(?<img_url>[^"]+)">/'
    );
    
    add_filter('filter_teamblevinschryslerdodgejeep_post_data', 'filter_teamblevinschryslerdodgejeep_post_data', 10, 3);
    add_filter('filter_teamblevinschryslerdodgejeep_data', 'filter_teamblevinschryslerdodgejeep_data');
    add_filter("filter_teamblevinschryslerdodgejeep_field_price", "filter_teamblevinschryslerdodgejeep_field_price", 10, 3);
    add_filter('filter_teamblevinschryslerdodgejeep_field_title', 'filter_teamblevinschryslerdodgejeep_field_title');
    add_filter("filter_teamblevinschryslerdodgejeep_field_images", "filter_teamblevinschryslerdodgejeep_field_images");

    $teamblevinschryslerdodgejeep_nonce = '';
    
    function filter_teamblevinschryslerdodgejeep_post_data($post_data, $stock_type, $data)
    {
        global $teamblevinschryslerdodgejeep_nonce;
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
        if($nonce && isset($nonce)) { $teamblevinschryslerdodgejeep_nonce=$nonce; }
        slecho("global ajax_nonce : ".$teamblevinschryslerdodgejeep_nonce);
        $post_id = 6;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 7;
            $referer = '/used-vehicles/';
        }
               
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$teamblevinschryslerdodgejeep_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_teamblevinschryslerdodgejeep_data($data)
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
    
    function filter_teamblevinschryslerdodgejeep_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Regex Pink Perfection: $price");
        }
        
        $sale_regex =  '/ctabox-price-label">\s*Sale Price\s*<\/span>\s*<span class="ctabox-price">\s*(?<price>[\$0-9,]+)/';
        $price_regex = '/ctabox-price-label">\s*PINK PERFECTION PRICE\s*<\/span>\s*<span class="ctabox-price">\s*(?<price>[\$0-9,]+)/';
        $msrp_regex =  '/ctabox-price-label">\s*MSRP\s*<\/span>\s*<span class="ctabox-price">\s*(?<price>[\$0-9,]+)/';
        
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
    
    function filter_teamblevinschryslerdodgejeep_field_images($im_urls)
    {
        if(count($im_urls) < 2) { return array(); }
        return $im_urls;
    }
    
     function filter_teamblevinschryslerdodgejeep_field_title($title)
    {
        return trim($title);
    }
    
