<?php
global $scrapper_configs;
 $scrapper_configs["mitsu"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.mitsu.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
        'new' => 'https://www.mitsu.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
        
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
                'price' => $obj->final_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                'msrp' => $obj->msrp,
                'url' => "https://www.mitsu.ca/vehicles/" . strtolower($obj->year) .
                '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/calgary/ab/' . strtolower($obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                //'all_images' => $obj->image->image_original,
                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );



            $to_return[] = $car_data;
        }

        return $to_return;
    },
            'images_regx'       => '/image_md":"(?<img_url>[^"]+)/',
);

add_filter('filter_mitsu_post_data', 'filter_mitsu_post_data', 10, 2);
add_filter("filter_mitsu_field_images", "filter_mitsu_field_images",10,2);
function filter_mitsu_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    
$ignore="https://www.mitsu.ca/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/" . "calgary/ab/";
   
slecho($ignore);
         
  foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''], rawurldecode($im_url));
        }

        return array_filter($retval, function($im_url){
            
            if(endsWith($im_url, '='))
            {
                return false;
            }

            return true;

        });
     

}


function filter_mitsu_post_data($post_data, $stock_type) {

    if ($stock_type == 'new') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2360%26ln%3Den%26pg%3D1%26pc%3D92%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26ec%3D%26ft%3D%26eg%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
    } elseif ($stock_type == 'used') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2360%26ln%3Den%26pg%3D1%26pc%3D58%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26ec%3D%26ft%3D%26eg%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
    }

    return $post_data;
}
