<?php
global $scrapper_configs;
$scrapper_configs["rustywallacehondacom"] = array( 
	 'entry_points' => array(
             'used'  => 'https://www.rustywallacehonda.com/used-vehicles/',
            'new'   => 'https://www.rustywallacehonda.com/new-vehicles/',
            
        ),
         'use-proxy' => true,
        'refine'=>false,
        'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
         'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.swiper-lazy'],
        'picture_nexts'     => ['.swiper-button-next'],
        'picture_prevs'     => ['.swiper-button-prev'],
        'details_start_tag' => '<table class="results_table">',
        'details_end_tag'   => '</table>',
        'details_spliter'   => '<tr class="spacer">',
        'data_capture_regx' => array(
            'url'                 => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'year'                => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'make'                => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'model'               => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'title'               => '/<h2>\s*<a href="(?<url>[^"]+)">(?<title>[^\s]+)\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
            'price'               => '/MSRP[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
            'engine'              => '/Engine:<\/span>\s*<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'stock_number'        => '/Stock #:\s(?<stock_number>[^<]+)/',    
            'transmission'        => '/Trans:<\/span>\s*[^>]+>\s(?<transmission>[^\n<]+)/',
            'exterior_color'      => '/Exterior:<\/span>[^>]+>\s(?<exterior_color>[^\n<]+)/',
           
        ),
        'data_capture_regx_full' => array(                
             'make'          => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
             'model'         => '/<meta itemprop="model" content="(?<model>[^"]*)/',
             'body_style'    => '/Body:<\/dt>\s*<dd>(?<body_style>[^<]+)/'
        ) ,
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/class="swiper-lazy" (?:src|data-src)="(?<img_url>[^"]+)/',
       // 'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter('filter_rustywallacehondacom_post_data', 'filter_rustywallacehondacom_post_data', 10, 3);
    add_filter('filter_rustywallacehondacom_data', 'filter_rustywallacehondacom_data');
    
    $rustywallacehondacom_nonce = '';
            
    function filter_rustywallacehondacom_post_data($post_data, $stock_type, $data)
    {
        global $rustywallacehondacom_nonce;
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
        if($nonce && isset($nonce)) { $rustywallacehondacom_nonce=$nonce; }
        slecho("global ajax_nonce : ".$rustywallacehondacom_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$rustywallacehondacom_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_rustywallacehondacom_data($data)
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
add_filter("filter_rustywallacehondacom_field_price", "filter_rustywallacehondacom_field_price", 10, 3);

function filter_rustywallacehondacom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Internet Price[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $cond_final_regex = '/Our Price<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
