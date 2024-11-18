<?php

global $scrapper_configs;

$scrapper_configs['winnipegporschecentre'] = array(
    'entry_points' => array(
        'used' => 'https://winnipeg.porschedealer.com/inventory/used/',
        'new' => 'https://winnipeg.porschedealer.com/inventory/new/',
        
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:new|certified|used)\//i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
    'picture_selectors' => ['fotorama__nav__frame fotorama__nav__frame--thumb'],
    'picture_nexts' => ['fotorama__arr fotorama__arr--next'],
    'picture_prevs' => ['fotorama__arr fotorama__arr--prev'],
    'details_start_tag' => '<div id="inventory-list-container">',
    'details_end_tag' => '<div id="footer">',
    'details_spliter' => '<a class="vehicle-listing-lead-teaser popup-link"',
    'data_capture_regx' => array(
        'url' => '/<a\shref="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
        'title' => '/<a\shref="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
        'year' => '/<a\shref="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
        'make' => '/<a\shref="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
        'model' => '/<a\shref="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
        // 'trim' => '/<a\shref="(?<url>[^"]+)"\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s(?<trim>[^<]+))/',
        'stock_number' => '/class="vehicle-listing-stock-number">\s*(?<stock_number>[^<]+)/',
        'price' => '/class="vehicle-listing-display-price">\s*(?<price>[^\n]+)/',
        'transmission' => '/class="vehicle-listing-transmission">\s*(?<transmission>[^\n<]+)/',
        'kilometres' => '/<div class="vehicle-listing-mileage">\s*(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\n<]+)/',
        'exterior_color' => '/Exterior Colour:<\/dt>\s*<dd [^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colour:<\/dt>\s*<dd>(?<interior_color>[^<]+)/',
        'vin'            => '/Stock #:<\/dt>\s*<dd>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/<li id="inventory-pager-next"><a\shref="(?<next>[^"]+)/',
    'images_regx' => '/<img\s*src="(?<img_url>[^"]+)"\s*alt="[a-zA-Z0-9]+\s[a-zA-Z0-9]+\s[a-zA-Z0-9]+/'
);

add_filter("filter_winnipegporschecentre_field_images", "filter_winnipegporschecentre_field_images");

function filter_winnipegporschecentre_field_images($im_urls) {
    if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}

//    add_filter("filter_winnipegporschecentre_next_page", "filter_winnipegporschecentre_next_page",10,2);
//    
//    function filter_winnipegporschecentre_next_page($next,$current_page) {
//        slecho("Filtering Next url");
//        $car_type= explode('=', $current_page);
//        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
//    }
//







//    add_filter('filter_winnipegporschecentre_post_data', 'filter_winnipegporschecentre_post_data',10, 3);
//    add_filter('filter_winnipegporschecentre_data', 'filter_winnipegporschecentre_data');
//    add_filter("filter_winnipegporschecentre_field_images", "filter_winnipegporschecentre_field_images");
//    
//    $winnipegporschecentre_nonce = '';
//    
//    function filter_winnipegporschecentre_post_data($post_data, $stock_type, $data)
//    {
//        global $winnipegporschecentre_nonce;
//        if($post_data == '')
//        {
//            $post_data = "page=1";
//        }
//        
//        $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
//        $nonce = '';
//        $matches = [];
//        
//        if($data && preg_match($nonce_regex, $data, $matches)) {
//            $nonce = $matches['nonce'];
//        }
//        slecho("ajax_nonce : ".$nonce);
//        if($nonce && isset($nonce)) { $winnipegporschecentre_nonce=$nonce; }
//        slecho("global ajax_nonce : ".$winnipegporschecentre_nonce);
//        $post_id = 4;
//        $referer = '/new-vehicles/';
//            
//        if($stock_type == 'used') {
//            $post_id = 5;
//            $referer = '/used-vehicles/';
//        }
//        return "action=im_ajax_call&perform=get_results&$post_data&show_all_filters=false&_nonce=$winnipegporschecentre_nonce&_post_id=$post_id&_referer=$referer";
//    }
//
//    function filter_winnipegporschecentre_data($data)
//    {
//        if($data)
//        {
//            if(isJSON($data)){
//                slecho("data is in jSon format");
//                $obj = json_decode($data);
//
//                $data = "{$obj->results}\n{$obj->pagination}";
//            }
//            else { slecho("data is not in jSon format"); }
//        }
//
//        return $data;
//    }
//    function filter_winnipegporschecentre_field_images($im_urls)
//    {
//        return  array_filter($im_urls,function($img_url){
//                return !endsWith($img_url,"notfound.jpg");
//            }
//        );
//    }
//   