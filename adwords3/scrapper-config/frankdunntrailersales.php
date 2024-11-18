<?php
global $scrapper_configs;
 $scrapper_configs["frankdunntrailersales"] = array( 
//	'entry_points' => array(
//             'used'  => 'https://www.frankdunntrailersales.com/imglib/Inventory/cache/4245/UVehInv.js?v=7594236',
//        'new'   => 'https://www.frankdunntrailersales.com/imglib/Inventory/cache/4245/NVehInv.js?v=3528883',
//       
//    ),
//    'vdp_url_regex'     => '/\/default\.asp\?page=x(?:New|PreOwned)Inventory/i',
//    'required_params'   => array('page','id'),
//    'use-proxy' => true,
//    'refine'    => false,
//    'picture_selectors' => ['.photo'],
//    'picture_nexts'     => ['.right'],
//    'picture_prevs'     => ['.left'],
//
//    'custom_data_capture' => function($url, $resp){
//           $start_tag  = 'var Vehicles=';
//           $end_tag    = '];';
//
//           if(stripos($resp, $start_tag)) {
//               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
//           }
//
//           if(stripos($resp, $end_tag)) {
//               $resp = substr($resp, 0, stripos($resp, $end_tag));
//           }
//           $resp=$resp . ']';
//           $inventory     = json_decode($resp);
//
//           $to_return = array();
//
//           foreach($inventory as $obj)
//           {
//               if($obj->type == 'U')   
//               {
//                   $url="https://www.frankdunntrailersales.com/default.asp?page=xPreOwnedInventoryDetail";
//               }
//               else 
//               {
//                   $url="https://www.frankdunntrailersales.com/default.asp?page=xNewInventoryDetail";
//               }
//               $car_data = array(
//
//                   'transmission'      => $obj->transmission,
//                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
//                   'year'              => $obj->bike_year,
//                   'make'              => $obj->manuf,
//                   'model'             => $obj->model,
//                   'body_style'        => $obj->vehtypename,
//                   'stock_type'        => $obj->type == 'U'?'used':'new',
//                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
//                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
//                  // 'url'               => "http://www.fmssaskatoon.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
//                   'url'               => $url.'&id='.$obj->id,
//                   'exterior_color'    => $obj->color,
//                   'engine'            => $obj->engine,
//                   'vin'               => !empty($obj->vin)?$obj->vin:$obj->id,
//                   'msrp'              => $obj->MSRP,
//
//               );
////               if(empty($obj->bike_image) && !empty($obj->stock_image)){
////                   $car_data['all_images'] = "https://cdn.dealerspike.com/imglib/v1/800x600$obj->stock_image";
////               }
////
////               $to_return[] = $car_data;
////           }
// if($obj->bike_image)
//                {
//                    $iu = $obj->bike_image;
//                    $p1 = substr($iu, 0, 2);
//                    $p2 = substr($iu, 2, 2);
//                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/300x225/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
//                }
//                
//                if($obj->image2)
//                {
//                    $iu = $obj->image2;
//                    $p1 = substr($iu, 0, 2);
//                    $p2 = substr($iu, 2, 2);
//                    $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/300x225/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
//                }
//                
//                $car_data['all_images'] = implode('|', $car_data['images']);
//                
//                $to_return[] = $car_data;
//            }
//            
//          
//           return $to_return;
//       },
//    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
//    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
//);
////    add_filter("filter_frankdunntrailersales_field_images", "filter_frankdunntrailersales_field_images");
////
////function filter_frankdunntrailersales_field_images($im_urls)
////{
////   $final_image=[];
////   $check_exist=["6225A85D49FD.jpg",""];
////
////   foreach ($im_urls as $images){
////
////       $contents = explode('/', $images);
////       if (!in_array(end($contents), $check_exist))
////       {
////           array_push($final_image,$images);
////       }
////   }
////   if (count($final_image) < 2) {
////
////       return array();
////   }
////   return $final_image;
////}
     'entry_points' => array(
        'used' => 'https://www.frankdunntrailersales.com/default.asp?page=inventory&condition=pre-owned&pg=1',
        'new' => 'https://www.frankdunntrailersales.com/default.asp?page=inventory&condition=new&pg=1',
        
    ),
    'vdp_url_regex' => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'   => false,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => '<div class="v7list-results listview',
    'details_end_tag' => '<footer',
    'details_spliter' => '<li class="v7list-results__item"',
    'data_capture_regx' => array(
      
        'year' => '/vehicle-heading__year">(?<year>[0-9]{4})/',
        'make' => '/vehicle-heading__name">(?<make>[^<]+)/',
        'model' => '/vehicle-heading__model">(?<model>[^<]+)/',
        'url' => '/<a class="vehicle-heading__link" href="(?<url>[^"]+)"/',
        'price' => '/class="vehicle-price__price ">\s*(?<price>[^\s]+)/',
     
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/Stock Number<\/label>\s*[^>]+>(?<stock_number>[^\<]+)/',
         'vin' => '/Stock Number<\/label>\s*[^>]+>(?<vin>[^<]+)/',
        'fuel_type' => '/Fuel Type<\/label>\s*[^>]+>(?<fuel_type>[^<]+)/',
        'exterior_color' => '/Color<\/label>\s*[^>]+>(?<exterior_color>[^\<]+)/',
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
         'engine' => '/Engine<\/label>\s*[^>]+>(?<engine>[^\<]+)/',
         'kilometres' => '/Odometer<\/label>\s*[^>]+>(?<kilometres>[^\s*]+)/',
        'body_style' => '/Body Style<\/label>\s*[^>]+>(?<body_style>[^\<]+)/',
    ),
    'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results">/',
    'images_regx' => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
);
 add_filter("filter_frankdunntrailersales_next_page", "filter_frankdunntrailersales_next_page", 10, 2);
add_filter("filter_frankdunntrailersales_field_images", "filter_frankdunntrailersales_field_images");

function filter_frankdunntrailersales_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);

    return $url;
}

add_filter("filter_frankdunntrailersales_field_images", "filter_frankdunntrailersales_field_images");
function filter_frankdunntrailersales_field_images($im_urls)
{
    $retval = [];

    foreach($im_urls as $img)
    {
        $retval[] = str_replace(["&#x2F;","https://www.frankdunntrailersales.com/"], ["/",""], $img);
    }

    return $retval;
}

