<?php
global $scrapper_configs;
$scrapper_configs["allensamuelsdirectcom"] = array( 
	  'entry_points' => array(
      
        'used' => 'https://www.allensamuelsdirect.com/used-vehicles/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thank-you-for-/i',
    'init_method' => 'GET',
    'next_method' => 'POST',
    'picture_selectors' => ['.lazyOwl'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
    //'details_end_tag' => '<div id="footer">',
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'title' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'url' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'stock_number' => '/class="stock-label">Stock #: (?<stock_number>[^<]+)/',
        'price' => '/Price[^>]+<\/span>\s*<span.*(?<price>\$[0-9,]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*<span class="detail-content"> (?<kilometres>[^\n<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/class="lazyOwl" data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
 add_filter('filter_allensamuelsdirectcom_post_data', 'filter_allensamuelsdirectcom_post_data', 10, 3);
    add_filter('filter_allensamuelsdirectcom_data', 'filter_allensamuelsdirectcom_data');
    
    $allensamuelsdirectcom_nonce = '';
            
    function filter_allensamuelsdirectcom_post_data($post_data, $stock_type, $data)
    {
        global $allensamuelsdirectcom_nonce;
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
        if($nonce && isset($nonce)) { $allensamuelsdirectcom_nonce=$nonce; }
        slecho("global ajax_nonce : ".$allensamuelsdirectcom_nonce);
        $post_id = 6;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 7;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$allensamuelsdirectcom_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_allensamuelsdirectcom_data($data)
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