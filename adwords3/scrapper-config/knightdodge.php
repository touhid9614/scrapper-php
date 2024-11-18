<?php

    global $scrapper_configs;

    $scrapper_configs['knightdodge'] = array(
        'entry_points' => array(
            'used'   => 'https://www.knightdodge.ca/used-vehicles/',
            'new'    => 'https://www.knightdodge.ca/new-inventory/',
            
        ),
        'use-proxy' => true,
        'refine'=>false,
        'vdp_url_regex'     => '/\/(?:new|used|certified|certified-used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-/i',
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
         //   'title'         => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|)\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/',
            'year'          => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|)\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/',
            'make'          => '/data-make="(?<make>[^"]+)/',
            'model'         => '/data-model="(?<model>[^"]+)/',
          //  'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/(?:Knight Price:|Sale Price:)\s*<\/span>[^>]+>\s*(?<price>\$[0-9,]+)/',
            'msrp'          => '/(?:Average Market Price:\s*<\/span>\s*[^>]+>|MSRP:\s*<\/span>\s*[^>]+><del>|MSRP:\s*<\/span>\s*[^>]+>|RETAIL:\s*<\/span>\s*[^>]+><del>|RETAIL:\s*<\/span>\s*[^>]+>)(?<msrp>[^<]+)/',
            'drivetrain'    => '/Drivetrain:[\s\S]+?<span class="detail-content">\s*(?<drivetrain>[^\n<]+)/',
            'url'           => '/class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?:New|Pre-Owned|)\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'make'          =>'/data-make="(?<make>[^"]+)/',
            'model'         =>'/data-model="(?<model>[^"]+)/',
           // 'price'         =>'/<meta itemprop="price" content="(?<price>[^"]+)/',
            'body_style'    => '/Body:<\/dt>\s*<dd>\s*(?<body_style>[^<]+)/',
            'transmission'  => '/Trans:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:<\/dt>\s*<dd>\s*(?<engine>[^<]+)/',
            'exterior_color'=> '/Exterior:<\/dt>\s*<dd>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:<\/dt>\s*<dd>\s*(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometers:<\/dt>\s*<dd>(?<kilometres>[^<]+)/',
            'description'   => '/og:description" content="(?<description>[^"]+)/',
            //'fuel_type'     => '/<li class="fuelType">\s*<strong class="title">\s*Fuel Type:\s*<\/strong>\s*<span class="value">(?<fuel_type>[^<]+)/',
            'vin'           => '/vin: \'(?<vin>[^\']+)/',
        ),
        'next_query_regx'   => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
        'images_regx'       => '/<img class="lazyOwl"\s*(?:data-src|src)="(?<img_url>[^"]+)"/'
    );
    
    add_filter('filter_knightdodge_post_data', 'filter_knightdodge_post_data', 10, 3);
    add_filter('filter_knightdodge_data', 'filter_knightdodge_data');
    add_filter("filter_knightdodge_field_description", "filter_knightdodge_field_description");
    
      function filter_knightdodge_field_description($description)
    {
        
       $temp = str_replace(['<p>', '</p>', '<span class=', '</strong>', '<strong>', '<br />'], ['', '', '', '','',''], $description);
        
       return $temp;
    }

    function filter_knightdodge_post_data($post_data, $stock_type, $data)
    {
        global $knightdodge_nonce;
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
        if($nonce && isset($nonce)) { $knightdodge_nonce=$nonce; }
        slecho("global ajax_nonce : ".$knightdodge_nonce);
        $post_id = 6;
        $referer = '/new-inventory/';
            
        if($stock_type == 'used') {
            $post_id = 8;
            $referer = '/used-vehicles/';
        }
               
        return "action=im_ajax_call&perform=get_results&$post_data&show_all_filters=false&_nonce=$knightdodge_nonce&_post_id=$post_id&_referer=$referer";
    }

    function filter_knightdodge_data($data)
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
    add_filter("filter_knightdodge_field_images", "filter_knightdodge_field_images");

function filter_knightdodge_field_images($im_urls) {
  $final_image=[];
   $check_exist=["7c3d591d2deaec0c9d8f92d62cb29a7f.jpg","912ad8e952a8602a2c006b033b062fba.jpg"];

   foreach ($im_urls as $images){

       $contents = explode('/', $images);
       if (!in_array(end($contents), $check_exist))
       {
           array_push($final_image,$images);
       }
   }
   if (count($final_image) < 2) {
       return array();
   }
   return $final_image;
}
add_filter('filter_knightdodge_car_data', 'filter_knightdodge_car_data');

function filter_knightdodge_car_data($car_data) {

    if(!isset($car_data['exterior_color'])){
        $car_data['exterior_color']="other";
    }

    return $car_data;
}