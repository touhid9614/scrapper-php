<?php
global $scrapper_configs;
$scrapper_configs["demo_toyotabountiful_dealerinspire"] = array( 
	   'entry_points' => array(
              'used'   => 'http://toyotabountiful.dev.dealerinspire.com/used-vehicles/',
              'new'    => 'http://toyotabountiful.dev.dealerinspire.com/new-vehicles/',
             
           
            
        ),
       // 'use-proxy' => true,
        //'proxy-area'        => 'FL',
        'vdp_url_regex'     => '/\/inventory\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<div class="grid-view-results-wrapper">',
      //  'details_end_tag'   => '</table>',
        'details_spliter'   => '<div class="vehicle-wrap">',
         'data_capture_regx' => array(
            
            'title'         => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|)\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/',
            'year'          => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|)\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/(?:Performance Price<\/strong><\/span><\/span>[^\$]+|class="price-block our-price real-price"\s*>[\s\S]*?<span class="price">.*)(?<price>\$[0-9,]+)/',
            'msrp'          => '/MSRP<\/span>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<msrp>[^<]+)/',
            
            'url'           => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|)\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          =>'/make:\s*\'(?<make>[^\']+)/',
            'model'         =>'/model:\s*\'(?<model>[^\']+)/',
            'stock_number'  => '/Stock[^>]+>[^>]+>(?<stock_number>[^<]+)<\/span>/',
            'drivetrain'    => '/Drivetrain:(?<drivetrain>[^\n<]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'transmission'  => '/Trans:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:\s*<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
            'description'   => '/<div class="vehicle-description-text" data-height-limit="">\s*<p>\s*(?<description>[^<\*]+)/',
          //  'fuel_type'     => '/<li class="fuelType">\s*<strong class="title">\s*Fuel Type:\s*<\/strong>\s*<span class="value">(?<fuel_type>[^<]+)/',
            'vin'           => '/vin: \'(?<vin>[^\']+)/',
        ),
        
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<img class="swiper-lazy" data-src="(?<img_url>[^"]+)/'
    );
    add_filter('filter_demo_toyotabountiful_dealerinspire_post_data', 'filter_demo_toyotabountiful_dealerinspire_post_data', 10, 3);
    add_filter('filter_demo_toyotabountiful_dealerinspire_data', 'filter_demo_toyotabountiful_dealerinspire_data');
    add_filter("filter_demo_toyotabountiful_dealerinspire_field_images", "filter_demo_toyotabountiful_dealerinspire_field_images");
    
    $demo_toyotabountiful_dealerinspire_nonce = '';
    
    function filter_demo_toyotabountiful_dealerinspire_post_data($post_data, $stock_type, $data)
    {
        global $demo_toyotabountiful_dealerinspire_nonce;
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
        if($nonce && isset($nonce)) { $demo_toyotabountiful_dealerinspire_nonce=$nonce; }
        slecho("global ajax_nonce : ".$demo_toyotabountiful_dealerinspire_nonce);
        $post_id = 6;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 7;
            $referer = '/used-vehicles/';
        }
               
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$demo_toyotabountiful_dealerinspire_nonce&_post_id=$post_id&_referer=$referer";

    }

    function filter_demo_toyotabountiful_dealerinspire_data($data)
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
    function filter_demo_toyotabountiful_dealerinspire_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
   add_filter("filter_demo_toyotabountiful_dealerinspire_field_price", "filter_demo_toyotabountiful_dealerinspire_field_price", 10, 3);

function filter_demo_toyotabountiful_dealerinspire_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Market Sale Price<\/span>\s*[^>]+>\s*(?<price>[^<]+)/';
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
