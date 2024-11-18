<?php
global $scrapper_configs;
global $scrapper_configs;
$scrapper_configs["lauriahyundai"] = array(
     'entry_points' => array(
            'new'   => 'https://sewjn80htn-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN',
            'used'  => 'https://sewjn80htn-2.algolianet.com/1/indexes/*/queries?x-algolia-agent=Algolia%20for%20JavaScript%20(4.9.1)%3B%20Browser%20(lite)%3B%20JS%20Helper%20(3.4.4)&x-algolia-api-key=179608f32563367799314290254e3e44&x-algolia-application-id=SEWJN80HTN'
        ),
        'vdp_url_regex'         => '/\/inventory\/(?:new|used)-[0-9]{4}-/',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.swiper-slide div'],
        'picture_nexts'     => ['.swiper-button-next'],
        'picture_prevs'     => ['.swiper-button-prev'],
        'content_type'      => 'application/json',
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        
 foreach($objects->results[0]->hits as $obj)
        {
          

            $car_data = array(
                'stock_number'      => $obj->stock?$obj->stock:$obj->vin,
                'stock_type'        => $obj->type =='Used'?'used':'new',
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->body,
                'price'             => $obj->our_price,
                'engine'            => $obj->engine_description,
                'transmission'      => $obj->transmission_description,
                'kilometres'        => $obj->miles,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fueltype,
                'drivetrain'        => $obj->drivetrain,
                'msrp'              => $obj->msrp,
                'url'               => $obj->link,
                'exterior_color'    => $obj->ext_color,
                'interior_color'    => $obj->int_color,
                'all_images'        => $obj->thumbnail,
              
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    
    'images_regx' => '/<img class="lazyOwl"[^"]+"(?<img_url>[^"]+)/'
);

add_filter('filter_lauriahyundai_post_data', 'filter_lauriahyundai_post_data', 10, 2);

function filter_lauriahyundai_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
        $post_data = '{"requests":[{"indexName":"lauriahyundai_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22stock%22%2C%22fuel_efficiency%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3ANew%22%5D%5D"},{"indexName":"lauriahyundai_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    } elseif ($stock_type == 'used') {
        $post_data = '{"requests":[{"indexName":"lauriahyundai_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1000&facets=%5B%22features%22%2C%22our_price%22%2C%22lightning.lease_monthly_payment%22%2C%22lightning.finance_monthly_payment%22%2C%22type%22%2C%22api_id%22%2C%22year%22%2C%22make%22%2C%22model%22%2C%22model_number%22%2C%22trim%22%2C%22body%22%2C%22doors%22%2C%22miles%22%2C%22ext_color_generic%22%2C%22features%22%2C%22lightning.isSpecial%22%2C%22lightning.locations%22%2C%22lightning.status%22%2C%22lightning.class%22%2C%22fueltype%22%2C%22engine_description%22%2C%22transmission_description%22%2C%22metal_flags%22%2C%22city_mpg%22%2C%22hw_mpg%22%2C%22days_in_stock%22%2C%22ford_SpecialVehicle%22%2C%22lightning.locations.meta_location%22%2C%22stock%22%2C%22fuel_efficiency%22%5D&tagFilters=&facetFilters=%5B%5B%22type%3AUsed%22%2C%22type%3ACertified%20Used%22%5D%5D"},{"indexName":"lauriahyundai_production_inventory_specials_oem_price","params":"maxValuesPerFacet=250&hitsPerPage=1&page=0&attributesToRetrieve=%5B%5D&attributesToHighlight=%5B%5D&attributesToSnippet=%5B%5D&tagFilters=&analytics=false&clickAnalytics=false&facets=type"}]}';
    }

    return $post_data;
}

// $scrapper_configs["lauriahyundai"] = array( 
// 	 'entry_points' => array(
//             'new'    => 'https://www.lauriahyundai.com/new-vehicles/',
//             'used'   => 'https://www.lauriahyundai.com/used-vehicles/'
//         ),
//        'vdp_url_regex'     => '/\/inventory\/(certified-)?(?:new|used)-[0-9]{4}-/i',
//     'init_method' => 'GET',
//     'next_method' => 'POST',
//     'refine'    => false,
//     'picture_selectors' => ['.owl-item'],
//     'picture_nexts' => ['.owl-next'],
//     'picture_prevs' => ['.owl-prev'],
//     'details_start_tag' => '<table class="results_table">',
//    // 'details_end_tag' => '<footer id="footer',
//     'details_spliter' => '<tr class="spacer">',
//     'data_capture_regx' => array(
//         'stock_number' => '/<span class="stock-label">Stock\s*#:\s*(?<stock_number>[^<]+)/',
//         'title' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
//         'year' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
//         'price' => '/Price<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/',
//         'transmission' => '/Trans:[\s\S]+?<span class="detail-content">\s*(?<transmission>[^\n<]+)/',
//         'engine' => '/Engine:[\s\S]+?<span class="detail-content">\s*(?<engine>[^\n<]+)/',
//         'exterior_color' => '/Exterior:[\s\S]+?<span class="detail-content">\s*(?<exterior_color>[^\n<]+)/',
//         'interior_color' => '/Interior:[\s\S]+?<span class="detail-content">\s*(?<interior_color>[^\n<]+)/',
//         'kilometres' => '/Mileage:[\s\S]+?<span class="detail-content">\s*(?<kilometres>[^\n<]+)/',
//         'url' => '/<div class="vehicle-title">\s*<h2>\s*<a href="(?<url>[^"]+)">\s*(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/'
//     ),
//     'data_capture_regx_full' => array(
//         'trim' => '/"trim":\s*"(?<trim>[^"]+)"[^"]/',
//         'price' => '/"price":\s*"(?<price>[^"]+)"[^"]/',
//         'make' => '/"brand":\s*"(?<make>[^"]+)"/',
//         'model' => '/"model":\s*"(?<model>[^"]+)"[^"]+"mpn/',
//         'body_style'    => '/Body:\s*[^>]+>\s*[^>]+>\s*(?<body_style>[^<]+)/',
//     ),
//     'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)" class="next">/',
//     'images_regx' => '/<img class="lazyOwl" data-src="(?<img_url>[^"]+)"/'
// );

// add_filter('filter_lauriahyundai_post_data', 'filter_lauriahyundai_post_data', 10, 3);
// add_filter('filter_lauriahyundai_data', 'filter_lauriahyundai_data');


// $lauriahyundai_nonce = '';

// function filter_lauriahyundai_post_data($post_data, $stock_type, $data) {
//     global $lauriahyundai_nonce;
//     if ($post_data == '') {
//         $post_data = "page=1";
//     }

//     $nonce_regex = '/"ajax_nonce":"(?<nonce>[^"]+)"/';
//     $nonce = '';
//     $matches = [];

//     if ($data && preg_match($nonce_regex, $data, $matches)) {
//         $nonce = $matches['nonce'];
//     }
//     slecho("ajax_nonce : " . $nonce);
//     if ($nonce && isset($nonce)) {
//         $lauriahyundai_nonce = $nonce;
//     }
//     slecho("global ajax_nonce : " . $lauriahyundai_nonce);
//     $post_id = 6;
//     $referer = '/new-vehicles/';

//     if ($stock_type == 'used') {
//         $post_id = 7;
//         $referer = '/used-vehicles/';
//     }
//     return "action=im_ajax_call&perform=get_results&$post_data&_nonce=$lauriahyundai_nonce&_post_id=$post_id&_referer=$referer";

// } 

// function filter_lauriahyundai_data($data) {
//     if ($data) {
//         if (isJSON($data)) {
//             slecho("data is in jSon format");
//             $obj = json_decode($data);

//             $data = "{$obj->results}\n{$obj->pagination}";
//         } else {
//             slecho("data is not in jSon format");
//         }
//     }

//     return $data;
// }

// add_filter("filter_lauriahyundai_next_page", "filter_lauriahyundai_next_page", 10, 2);

//  function filter_lauriahyundai_next_page($next_page_regex) {
//      slecho("Filtering Next url");
//     return str_replace('?', '', $next_page_regex);
//  }


// add_filter("filter_lauriahyundai_field_price", "filter_lauriahyundai_field_price", 10, 3);

// function filter_lauriahyundai_field_price($price, $car_data, $spltd_data) {
//     $prices = [];

//     slecho('');

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//         slecho(" Price: $price");
//     }

//     $msrp_regex = '/MSRP[^>]+>\s*[^>]+>(?<price>[^<]+)/';
//     $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
//     $internet_regex = '/Internet Price[^>]+>\s*[^>]+>(?<price>[^<]+)/';
//     $cond_final_regex = '/Our Price<\/span>\s*<span class="price">(?<price>\$[0-9,]+)/';
//     $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
//     $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


//     $matches = [];

//     if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex MSRP: {$matches['price']}");
//     }
//     if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex wholesale: {$matches['price']}");
//     }
//     if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex internet: {$matches['price']}");
//     }

//     if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Conditional Price: {$matches['price']}");
//     }

//     if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Retail Price: {$matches['price']}");
//     }
//     if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Asking Price: {$matches['price']}");
//     }

//     if (count($prices) > 0) {
//         $price = butifyPrice(min($prices));
//     }

//     slecho("Sale Price: {$price}" . '<br>');
//     return $price;
// }






// <!--
