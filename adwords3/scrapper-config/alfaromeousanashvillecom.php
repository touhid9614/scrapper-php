<?php
global $scrapper_configs;
$scrapper_configs["alfaromeousanashvillecom"] = array( 
	'entry_points' => array(
            'new'   => 'https://www.alfaromeousanashville.com/new-vehicles/',
            'used'  => 'https://www.alfaromeousanashville.com/used-vehicles/',
        ),
         'use-proxy' => true,
         'refine' => false,
        'vdp_url_regex'     => '/\/inventory\/(?:new|certified|used|certified-used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-for-/i',
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.owl-item'],
        'picture_nexts'     => ['.owl-next'],
        'picture_prevs'     => ['.owl-prev'],
        'details_start_tag' => '<div class="grid-view-results-wrapper">',
        'details_end_tag'   => '<div class="resultsPagination paging  pagination-bottom">',
        'details_spliter'   => '<div class="vehicle-wrap">',
        'data_capture_regx' => array(
            'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'model'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/Our Price<\/span>[^>]+>(?<price>\$[0-9,]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'

        ),
        'data_capture_regx_full' => array(
            'stock_number'  => '/Stock<\/span>[^>]+>(?<stock_number>[^<]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'kilometres'    => '/Mileage:<\/dt>\s*<dd>\s*(?<kilometres>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
            'transmission'  => '/Trans:<\/dt>\s*<dd>\s*(?<transmission>[^<]+)/',
            

        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/lazyOwl" (?:data-src|src)="(?<img_url>[^"]+)"/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
       
    );
    add_filter('filter_alfaromeousanashvillecom_post_data', 'filter_alfaromeousanashvillecom_post_data',10, 3);
    add_filter('filter_alfaromeousanashvillecom_data', 'filter_alfaromeousanashvillecom_data');
    add_filter("filter_alfaromeousanashvillecom_field_images", "filter_alfaromeousanashvillecom_field_images");
    
    $alfaromeousanashvillecom_nonce = '';
    
    function filter_alfaromeousanashvillecom_post_data($post_data, $stock_type, $data)
    {
        global $alfaromeousanashvillecom_nonce;
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
        if($nonce && isset($nonce)) { $alfaromeousanashvillecom_nonce=$nonce; }
        slecho("global ajax_nonce : ".$alfaromeousanashvillecom_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
      
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$alfaromeousanashvillecom_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_alfaromeousanashvillecom_data($data)
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
    function filter_alfaromeousanashvillecom_field_images($im_urls)
    {
        return  array_filter($im_urls,function($img_url){
                return !endsWith($img_url,"notfound.jpg");
            }
        );
    }
add_filter("filter_alfaromeousanashvillecom_field_price", "filter_alfaromeousanashvillecom_field_price", 10, 3);

function filter_alfaromeousanashvillecom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP<\/span>[^>]+>(?<price>\$[0-9,]+)/';
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
