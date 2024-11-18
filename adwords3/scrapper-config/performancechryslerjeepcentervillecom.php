<?php
global $scrapper_configs;
$scrapper_configs["performancechryslerjeepcentervillecom"] = array( 
	"entry_points" => array(
	        'new'   => 'https://www.performancechryslerjeepcenterville.com/new-vehicles/',
            'used'  => 'https://www.performancechryslerjeepcenterville.com/used-vehicles/'
        ),
        // 'use-proxy' => true,
        'vdp_url_regex'     => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
        //'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.lazyOwl.lazyload-loading'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<div class="grid-view-results-wrapper">',
        //'details_end_tag'   => '</table>',
        'details_spliter'   => '<div class="vehicle-wrap">',
        'data_capture_regx' => array(
            'url'                 => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'                => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make' 				  => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'model' 			  => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'price'               => '/Performance Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Stock<\/span><span[^>]+>(?<stock_number>[^<]+)/',
            'transmission'  => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
        ) ,
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<img class="swiper-lazy" data-src="(?<img_url>[^"]+)"/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    add_filter('filter_performancechryslerjeepcentervillecom_post_data', 'filter_performancechryslerjeepcentervillecom_post_data', 10, 3);
    add_filter('filter_performancechryslerjeepcentervillecom_data', 'filter_performancechryslerjeepcentervillecom_data');
    
    $performancechryslerjeepcentervillecom_nonce = '';
            
    function filter_performancechryslerjeepcentervillecom_post_data($post_data, $stock_type, $data)
    {
        global $performancechryslerjeepcentervillecom_nonce;
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
        if($nonce && isset($nonce)) { $performancechryslerjeepcentervillecom_nonce=$nonce; }
        slecho("global ajax_nonce : ".$performancechryslerjeepcentervillecom_nonce);
        $post_id = 6;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 7;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$performancechryslerjeepcentervillecom_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_performancechryslerjeepcentervillecom_data($data)
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

add_filter("filter_performancechryslerjeepcentervillecom_field_price", "filter_performancechryslerjeepcentervillecom_field_price", 10, 3);

function filter_performancechryslerjeepcentervillecom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Sale Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
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
