<?php
global $scrapper_configs;
$scrapper_configs["frankletaacuracom"] = array(
    'entry_points' => array(
        'new'   => 'https://www.frankletaacura.com/new-acura-cars/',
        'used'  => 'https://www.frankletaacura.com/used-cars-st-louis-missouri/'
    ),
        'vdp_url_regex'     => '/\/inventory\//i',
        'use-proxy' => true,
        'refine' => false,
        'init_method'       => 'GET',
        'next_method'       => 'POST',
        'picture_selectors' => ['.lazyOwl'],
        'picture_nexts'     => ['.fa.fa-angle-right'],
        'picture_prevs'     => ['.fa.fa-angle-left'],
        //'details_start_tag' => '<tr class="hidden-xs">',
        //'details_end_tag'   => 'class="bottom-text">',
        'details_spliter' => '"hidden-xs',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock #:\s*(?<stock_number>[^<]+)/',
        'url'           => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'year'          => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'make'          => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'model'         => '/<h2>\s*<a\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'price'         => '/(?:MSRP|LETA Price)<\/span>\s*<span\s*class="price">(?<price>[^<]+)/',
        'exterior_color'=> '/Exterior:<\/span>\s*[^>]+>\s*(?<exterior_color>[^<]+)/',
        'engine'        => '/Engine:<\/span>\s*<[^>]+>\s*(?<engine>[^<]+)/',
        'kilometres'    => '/Mileage:<\/span>[^>]+>\s*(?<kilometres>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(

        'year' => '/year:\s*\'(?<year>[^\']+)/',
        'make' => '/make:\s*\'(?<make>[^\']+)/',
        'model' => '/model:\s*\'(?<model>[^\']+)/',
        'stock_number' => '/Stock<\/span><span class="vinstock-number">(?<stock_number>[^<]+)/',


        'body_style' => '/Body Style:\s*(?<body_style>[^<]+)/',
    ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<img class="lazyOwl"[^"]+"(?<img_url>[^"]+)/'
);

	add_filter('filter_frankletaacuracom_post_data', 'filter_frankletaacuracom_post_data', 10, 3);
    add_filter('filter_frankletaacuracom_data', 'filter_frankletaacuracom_data');
    
    $frankletaacuracom_nonce = '';
            
    function filter_frankletaacuracom_post_data($post_data, $stock_type, $data)
    {
        global $frankletaacuracom_nonce;
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
        if($nonce && isset($nonce)) { $frankletaacuracom_nonce=$nonce; }
        slecho("global ajax_nonce : ".$frankletaacuracom_nonce);
        $post_id = 4;
        $referer = '/new-acura-cars/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-cars-st-louis-missouri/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$frankletaacuracom_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_frankletaacuracom_data($data)
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