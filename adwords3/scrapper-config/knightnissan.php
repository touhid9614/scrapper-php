<?php

    global $scrapper_configs;

    $scrapper_configs['knightnissan'] = array(
        'entry_points' => array(
            'used'   => 'https://www.knightnissan.ca/used-vehicles/',
            'new'    => 'https://www.knightnissan.ca/new-vehicles/',
        ),
        'use-proxy' => true,
        'refine' => false,
       'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used|certified)-[0-9]{4}-/i',
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
            'stock_number'  => '/<span class="stock-label">Stock #:\s*(?<stock_number>[^<]+)/',
            // 'title'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'year'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'make'          => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'model'         => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'price'         => '/(?:Sale Price:|Knight Price:)<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/',
            'transmission'  => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
            'drivetrain'    => '/Drivetrain:[\s\S]+?<span class="detail-content">\s*(?<drivetrain>[^\n<]+)/',
            'engine'        => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
            'exterior_color'=> '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
            'interior_color'=> '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
            'kilometres'    => '/Kilometers:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
            'url'           => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
            'description'   => '/class="vehicle-description-text">\s*(?:\*\*Why Buy at Knight Automotive Group\*\*\s*|)(?<description>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'vin'           => '/VIN:<\/dt>\s*<dd>\s*(?<vin>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
            // 'description'   => '/<div class="vehicle-description-text" data-height-limit="">\s*<p>\s*(?<description>[^<\*]+)/'
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
    
    add_filter('filter_knightnissan_post_data', 'filter_knightnissan_post_data', 10, 3);
    add_filter('filter_knightnissan_data', 'filter_knightnissan_data');



    $knightnissan_nonce = '';
    
    function filter_knightnissan_post_data($post_data, $stock_type, $data)
    {
        global $knightnissan_nonce;
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
        if($nonce && isset($nonce)) { $knightnissan_nonce=$nonce; }
        slecho("global ajax_nonce : ".$knightnissan_nonce);
        $post_id = 4;
        $referer = '/new-vehicles/';
            
        if($stock_type == 'used') {
            $post_id = 5;
            $referer = '/used-vehicles/';
        }
                
        return "action=im_ajax_call&perform=get_results&$post_data&show_all_filters=false&_nonce=$knightnissan_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_knightnissan_data($data)
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

add_filter('filter_knightnissan_car_data', 'filter_knightnissan_car_data');

function filter_knightnissan_car_data($car_data) {

    if(!isset($car_data['exterior_color'])){
        $car_data['exterior_color']="other";
        $car_data['interior_color']="other";
    }

    return $car_data;
}
 add_filter("filter_knightnissan_field_images", "filter_knightnissan_field_images");
 function filter_knightnissan_field_images($im_urls)
    {
               if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }