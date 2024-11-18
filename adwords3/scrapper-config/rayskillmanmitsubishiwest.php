<?php

global $scrapper_configs;

$scrapper_configs['rayskillmanmitsubishiwest'] = array(
    'entry_points' => array(
        'new' => 'https://www.rayskillmanmitsubishiwest.com/new-vehicles/',
        'used' => 'https://www.rayskillmanmitsubishiwest.com/used-vehicles/'
    ),
    //'use-proxy' => true,
    'init_method'       => 'GET',
    'next_method'       => 'POST',
    'vdp_url_regex' => '/\/inventory\/[0-9]{4}-/i',
    'picture_selectors' => ['.owl-item'],
    'picture_nexts' => ['.owl-next'],
    'picture_prevs' => ['.owl-prev'],
    'details_start_tag' => '<table class="results_table">',
    'details_end_tag' => "<ul class='pagination'",
    'details_spliter' => '<tr class="spacer">',
    'data_capture_regx' => array(
        'url' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'year' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'make' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'model' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'title' => '/<h2>\s*<a\s*href="(?<url>[^"]+)">(?<title>[^\s]+\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^\<]+)/',
        'price' => '/class="price-block our-price[^"]*">[\s\S]*?<span class="price">\s*(?<price>\$[0-9,]+)/',
        'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
        'stock_number' => '/data-stock="(?<stock_number>[^"]+)/',
        'kilometres' => '/Mileage:<\/span>\s*<span[^>]+>\s*(?<kilometres>[^<]+)/',
        'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
        'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
        'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/'
    ),
    'data_capture_regx_full' => array(
        'make' => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model" content="(?<model>[^"]*)/',
        'body_style' => '/Body:<\/dt>\s*<dd>(?<body_style>[^<]+)/'
    ),
    'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
    'images_regx' => '/<img class="lazyOwl" data-src="(?<img_url>[^"]+)"/'
);

    
add_filter('filter_rayskillmanmitsubishiwest_post_data', 'filter_rayskillmanmitsubishiwest_post_data',10, 3);
add_filter('filter_rayskillmanmitsubishiwest_data', 'filter_rayskillmanmitsubishiwest_data');
add_filter("filter_rayskillmanmitsubishiwest_field_images", "filter_rayskillmanmitsubishiwest_field_images");

$rayskillmanmitsubishiwest_nonce = '';

function filter_rayskillmanmitsubishiwest_post_data($post_data, $stock_type, $data)
{
    global $rayskillmanmitsubishiwest_nonce, $proxy_list;
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
    
    $post_id = 4;
    $referer = '/new-vehicles/';

    if($stock_type == 'used') {
        $post_id = 5;
        $referer = '/used-vehicles/';
    }
    
    if(!$nonce) {
        $temp_data = HttpGet("https://www.rayskillmanmitsubishiwest.com$referer", $proxy_list);
        if($temp_data && preg_match($nonce_regex, $temp_data , $matches)) {
            $nonce = $matches['nonce'];
        }
    }
    
    slecho("ajax_nonce : ".$nonce);
    if($nonce && isset($nonce)) { $rayskillmanmitsubishiwest_nonce=$nonce; }
    slecho("global ajax_nonce : ".$rayskillmanmitsubishiwest_nonce);
    
    #Added random sleep between 6 to 12 seconds to make the requests slower
    sleep(rand(6, 12));

    return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$rayskillmanmitsubishiwest_nonce&_post_id=$post_id&_referer=$referer";
}

function filter_rayskillmanmitsubishiwest_data($data)
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

function filter_rayskillmanmitsubishiwest_field_images($im_urls)
{
    return  array_filter($im_urls,function($img_url){
            return !endsWith($img_url,"notfound.jpg");
        }
    );
}
