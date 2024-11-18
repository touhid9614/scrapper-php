<?php
global $scrapper_configs;
 $scrapper_configs["heartlandtoyota"] = array( 
	'entry_points' => array(
         'new'   => 'https://www.heartlandtoyota.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
            'used'  => 'https://www.heartlandtoyota.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php'
        ),
        'vdp_url_regex'         => '/\/vehicles\/[0-9]{4}\//',
        'ajax_url_match'        => '/libs/formProcessor.html',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.thumbnails__single'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        'custom_data_capture'   => function($url, $data){
                
        $objects = json_decode($data);

                
        if(!$objects) { slecho($data); return array(); }

                
        $to_return = array();

                
        foreach($objects->results as $obj)
        {
            

             $car_data = array(
                'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->vehicle_id,
                'stock_type'        => strtolower($obj->sale_class),
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => $obj->model,
                'trim'              => $obj->trim,
                'body_style'        => $obj->body_style,
                'price'             => $obj->lowest_price,
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->odometer,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel_type,
                'drivetrain'        => $obj->drive_train,
                'msrp'              => $obj->msrp,
                'url'               => "https://www.heartlandtoyota.ca/vehicles/" . strtolower($obj->year) .
                                       '/' . strtolower($obj->make) . '/'  .strtolower(explode(" ",$obj->model)[0])  . '-'.strtolower(explode(" ",$obj->model)[1]). '/williams%20lake/bc/' . strtolower($obj->ad_id),
                'exterior_color'    => $obj->exterior_color,
                'interior_color'    => $obj->interior_color,
                'all_images'        => $obj->image->image_original,
                'title'             => $obj->year .' '. $obj->make . ' ' . $obj->model,
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'       => '/image_md":"(?<img_url>[^"]+)/',
);
    
add_filter('filter_heartlandtoyota_post_data', 'filter_heartlandtoyota_post_data', 10, 2);
function filter_heartlandtoyota_post_data($post_data, $stock_type)
{
   if($stock_type == 'new')
    {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D183%26ln%3Den%26pg%3D1%26pc%3D100%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3D%26yr%3D2018%252C2020%26mk%3D%26md%3D%26pr%3D0%252C73398%26tr%3D%26od%3D0%252C3200%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
    }
if($stock_type == 'used')
    {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D183%26ln%3Den%26pg%3D1%26pc%3D100%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3D%26yr%3D2005%252C2018%26mk%3D%26md%3D%26pr%3D0%252C43547.5%26tr%3D%26od%3D8%252C274173%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
    }
    return $post_data;
}

add_filter("filter_heartlandtoyota_field_images", "filter_heartlandtoyota_field_images",10,2);
function filter_heartlandtoyota_field_images($im_urls,$car_data) {
    $retval = array();
   
$ignore="https://www.heartlandtoyota.ca/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower(explode(" ",$car_data['model'])[0])  . '-'.strtolower(explode(" ",$car_data['model'])[1]) . "/williams lake/bc/";
   
slecho($ignore);        
  foreach ($im_urls as $im_url) {
      //  $retval[] = str_replace([$ignore, '-1024x786','\\','=','NDQwLCJoZWlnaHQiOjEwODAsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ','AyNCwiaGVpZ2h0Ijo3NjgsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ','NDgzOS5KUEciLCJlZGl0cyI6eyJyZXNpemUiOnsid2lkdGgiOjEwMjQsImhlaWdodCI6NzY4LCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJ'], ['', '','','','MDI0LCJoZWlnaHQiOjc2OCwiZml0IjoiaW5zaWRlIiwid2l0aG91dEVubGFyZ2VtZW50Ijp0cnVlfX19','Q0MCwiaGVpZ2h0IjoxMDgwLCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJnZW1lbnQiOnRydWV9fX0',], rawurldecode($im_url));
     
         $retval[] = str_replace([$ignore, '-1024x786','\\','=','AyNCwiaGVpZ2h0Ijo3NjgsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ','NTQyNy5KUEciLCJlZGl0cyI6eyJyZXNpemUiOnsid2lkdGgiOjEwMjQsImhlaWdodCI6NzY4LCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJn'], ['', '','','','Q0MCwiaGVpZ2h0IjoxMDgwLCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJnZW1lbnQiOnRydWV9fX0','NTQxM2phbi5qcGciLCJlZGl0cyI6eyJyZXNpemUiOnsid2lkdGgiOjE0NDAsImhlaWdodCI6MTA4MCwiZml0IjoiaW5zaWRlIiwid2l0aG91dEVubGFyZ2VtZW50Ijp0cnVlfX19'], rawurldecode($im_url));
      
  }
    if(count($retval) < 2) { return array(); }
    return $retval;
}



