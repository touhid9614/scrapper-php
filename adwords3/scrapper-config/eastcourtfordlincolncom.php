<?php
global $scrapper_configs;
$scrapper_configs["eastcourtfordlincolncom"] = array( 
	'entry_points' => array(
           'all'   => 'https://eastcourtfordlincoln.com/data/inventory.json?ts=' . time(),
                       
         ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/view\/(?:new|used)-[0-9]{4}-/i',
        'ajax_url_match'    => '/api/v1/lead',
        'ajax_resp_match'   => '"Type":"RequestMoreInformation"',
        'picture_selectors' => ['.lb-image','.slick-slide'],
        'picture_nexts'     => ['.lb-next'],
        'picture_prevs'     => ['.lb-prev'],
        'custom_data_capture'   => function($url, $data){
        
            $objects = json_decode($data);
            
            if(!$objects) { slecho($data); return array(); }
            
            $to_return = array();
            
            foreach($objects->vehicles as $obj)
            {
                if($obj->salepending) { continue; }
                $car_data = array(
                    'stock_number'      => $obj->stocknumber?$obj->stocknumber:$obj->id,
                    'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->bodystyle,
                    'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->mileage,
                    'url'               => "https://eastcourtfordlincoln.com/view/" . strtolower($obj->condition) .
                                           '-' . strtolower($obj->year) . '-' . strtolower($obj->make) . '-' . strtolower($obj->model) . 
                                           '-' . strtolower($obj->id) . '/',
                    'exterior_color'    => $obj->exteriorcolor,
                    'certified'         => $obj->certified?1:0,
                    'images'            => $obj->picture
                );
                
               $details_url = "https://eastcourtfordlincoln.com/data/{$obj->id}.json?{$obj->timestamp}";
                
                slecho("Details Data URL: $details_url");
                
                $details_data = HttpGet($details_url);
                
                if($details_data) {
                    $details_obj = json_decode($details_data);
                    $car_data['interior_color'] = $details_obj->interiorcolor;
                    $car_data['images']         = $details_obj->pictures;
                    array_walk($car_data['images'], function(&$img_url) use($car_data){
                        $img_url = urlCombine($car_data['url'], $img_url);
                    });
                    $image_urls                 = implode('|', $car_data['images']);
                    $car_data['all_images']     = $image_urls;
                }
                else {
                    slecho('Error: Unable to load details data');
                }
                $to_return[] = $car_data;
            }
            
            return $to_return;
        }
    );
    
    
















































//         'used' => 'https://eastcourtfordlincoln.com/used-inventory/',
//         'new' => 'https://eastcourtfordlincoln.com/new-inventory/',
//     ),
//     'use-proxy' => true,
//     'vdp_url_regex' => '/\/view\/(?:new|used)-/i',
//     'refine' => false,
//     'picture_selectors' => ['.vgs__container'],
//     'picture_nexts' => ['.vgs__next'],
//     'picture_prevs' => ['.vgs__prev'],
//     'details_start_tag' => '<main class="main">',
//     'details_end_tag' => 'class="content-info footer-1"',
//     'details_spliter' => '<div class="w-full sm:w-full',
//     'data_capture_regx' => array(
//         'url' => '/<a :href="(?<url>[^"]+">)\s*<h3/'
//     ),
//     'data_capture_regx_full' => array(
//         'make' => '/leading-none text-black">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<\s*]+)/',
//         'year' => '/leading-none text-black">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<\s*]+)/',
//         'model' => '/leading-none text-black">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<\s*]+)/',
//         'stock_number' => '/Stock#:<\/strong>\s*(?<stock_number>[^<\s*]+)/',
//         'price' => '/price":\s*"(?<price>[^"]+)/',
//         'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)<\/span>/',
//         'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)<\/span>/',
//         'body_style' => '/Body Style:[^>]+>[^>]+>(?<body_style>[^<]+)<\/span>/',
//         'exterior_color' => '/Exterior Colour:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
//         'interior_color' => '/Interior Colour:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
//         'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)<\/span>/',
//         'vin' => '/Vin:[^>]+>[^>]+>(?<vin>[^<]+)/',
//     ),
//         'next_page_regx'   => '/page == \'(?<next>[0-8]+)/',
//         'images_regx'       => '/\&quot\;[^\/]+\/[^\/]+\/(?<img_url>car-dealer[^\&]+)\&quot\;/',
// );
//  add_filter('filter_eastcourtfordlincolncom_field_url', 'filter_eastcourtfordlincolncom_field_url');
//  function filter_eastcourtfordlincolncom_field_url($url) {
//     $url = str_replace("'","",$url);
//     $url = str_replace("+","",$url);
//     $url = str_replace('"','',$url);
//     $url = str_replace(" ","",$url);
//     return $url;
//  }
//  add_filter("filter_eastcourtfordlincolncom_next_page", "filter_eastcourtfordlincolncom_next_page",10,2);
//  add_filter("filter_eastcourtfordlincolncom_field_images", "filter_eastcourtfordlincolncom_field_images");
 
//  function filter_eastcourtfordlincolncom_field_images($im_urls) {
//     $retval = [];
//     foreach ($im_urls as $img) {

//         $retval[] = str_replace(['\\','https://eastcourtfordlincoln.com/view/'], ['',''],$img);
//     }

//     return $retval;
// }
 
//  function filter_eastcourtfordlincolncom_next_page($next,$current_page) {
//         // slecho("nextx_:" . $next );
//         // slecho("curr:" . $current_page );


//         $next = $current_page . "?pag=2";

//         if ($next == "https://eastcourtfordlincoln.com/used-inventory/?pag=2" || $next == "https://eastcourtfordlincoln.com/new-inventory/?pag=2") {
//             return $next;
//         }
//         // $next = explode('/', $next);
//         // $index = count($next) - 1;
//         // $next = ($next[$index]);
//         // $next++;
//         // $peg = "pag=" . $next;
//         // $prev = "pag=" . ($next - 1);
//         // $url = str_replace($prev, $peg, $current_page);
//         // slecho($url);
//         // return $next;
//     }

