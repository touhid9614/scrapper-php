<?php
global $scrapper_configs;
 $scrapper_configs["basantmotors"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.basantmotors.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2684%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26sc%3Dused%26v1%3D%26st%3Dyear%252Cdesc%26ai%3Dtrue%26oem%3D%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data'
    ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts' => ['button.modal-slideshow__next'],
    'picture_prevs' => ['button.modal-slideshow__prev'],
    'custom_data_capture' => function($url, $data) {

        $objects = json_decode($data);


        if (!$objects) {
            slecho($data);
            return array();
        }


        $to_return = array();


        foreach ($objects->results as $obj) {


            $car_data = array(
                'stock_number' => $obj->stock_number ? $obj->stock_number : $obj->vehicle_id,
                'stock_type' => strtolower($obj->sale_class),
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->body_style,
                //'price' => $obj->final_price>0?$obj->final_price:"please call",
                'price' => $obj->final_price==0?"please call":$obj->final_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                'msrp' => $obj->msrp,
                'url' => "https://www.basantmotors.com/vehicles/" . strtolower($obj->year) .
                '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/surrey/bc/' . strtolower($obj->ad_id),
                'exterior_color' => $obj->exterior_color ? $obj->exterior_color : "Other",
                'interior_color' => $obj->interior_color,
               // 'all_images' => $obj->image->image_original,
              //  'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
                'finance'   => round(($obj->final_price*1.10465)/364),
            );
             
            $response_data = HttpGet($car_data['url']);
            $regex       =  '/,"description":"(?<description>[^"]+)","doors"/';
            $matches = [];
             if(preg_match($regex, $response_data, $matches)) {
           
             $car_data['description']=$matches['description'];
             
            }      

            $to_return[] = $car_data;
        }

        return $to_return;
    },
            'images_regx'       => '/image_lg":"(?<img_url>[^"]+)/',
);

//add_filter('filter_basantmotors_post_data', 'filter_basantmotors_post_data', 10, 2);
add_filter("filter_basantmotors_field_images", "filter_basantmotors_field_images",10,2);
function filter_basantmotors_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    
$ignore="https://www.basantmotors.com/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/" . "surrey/bc/";
   
slecho($ignore);
         
  foreach ($im_urls as $im_url) {
             $retval[] = str_replace([$ignore, '-1024x786','\\','=','NDQwLCJoZWlnaHQiOjEwODAsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ','AyNCwiaGVpZ2h0Ijo3NjgsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ'], ['', '','','','MDI0LCJoZWlnaHQiOjc2OCwiZml0IjoiaW5zaWRlIiwid2l0aG91dEVubGFyZ2VtZW50Ijp0cnVlfX19','Q0MCwiaGVpZ2h0IjoxMDgwLCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJnZW1lbnQiOnRydWV9fX0'], rawurldecode($im_url));
        }
     


       
    return $retval;
}


// function filter_basantmotors_post_data($post_data, $stock_type) {

//     if ($stock_type == 'new') {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D292%26ln%3Den%26pg%3D1%26pc%3D200%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3D%26yr%3D2019%252C2020%26mk%3D%26md%3D%26pr%3D0%252C58080%26tr%3D%26od%3D18%252C701%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
//     } elseif ($stock_type == 'used') {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D200%26ln%3Den%26pg%3D1%26pc%3D300%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3D%26st%3D';
//     }

//     return $post_data;
// }
