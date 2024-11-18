<?php
global $scrapper_configs;
 $scrapper_configs["lougheedhyundai"] = array( 
	 'entry_points' => array(
        'used'  => 'https://www.lougheedhyundai.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
            'new'   => 'https://www.lougheedhyundai.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
            
        ),
        'vdp_url_regex'         => '/\/vehicles\/[0-9]{4}\//',
        'ajax_url_match'        => '/libs/formProcessor.html',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.carousel-indicators li'],
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
                'price'             => $obj->final_price>0?$obj->final_price:"please call",
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->odometer,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel_type,
                'drivetrain'        => $obj->drive_train,
                'msrp'              => $obj->msrp,
                'url'               => "https://www.lougheedhyundai.com/vehicles/" . strtolower($obj->year) .
                                       '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/listowel/on/' . strtolower($obj->ad_id),
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
    
add_filter('filter_lougheedhyundai_post_data', 'filter_lougheedhyundai_post_data', 10, 2);
add_filter("filter_lougheedhyundai_field_images", "filter_lougheedhyundai_field_images",10,2);

function filter_lougheedhyundai_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D310%26ln%3Den%26pg%3D1%26pc%3D171%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3D%26yr%3D2019%252C2020%26mk%3D%26md%3D%26pr%3D0%252C52604%26tr%3D%26od%3D0%252C50%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
    }
    elseif($stock_type == 'used')
    {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D310%26ln%3Den%26pg%3D1%26pc%3D36%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3D%26yr%3D2007%252C2019%26mk%3D%26md%3D%26pr%3D0%252C37458%26tr%3D%26od%3D2000%252C186218%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
    }

    return $post_data;
}

function filter_lougheedhyundai_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    
$ignore="https://www.lougheedhyundai.com/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/" . "listowel/on/";
   
slecho($ignore);
         
  foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786','\\','=','LmpwZyIsImVkaXRzIjp7InJlc2l6ZSI6eyJ3aWR0aCI6MTAyNCwiaGVpZ2h0Ijo3NjgsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ'], ['', '','','','LmpwZyIsImVkaXRzIjp7InJlc2l6ZSI6eyJ3aWR0aCI6MTQ0MCwiaGVpZ2h0IjoxMDgwLCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJnZW1lbnQiOnRydWV9fX0'], rawurldecode($im_url));
        }
     
          return array_filter($retval, function($im_url){
            
            if(endsWith($im_url, 'JustArrived_md.jpg'))
            {
                return false;
            }
            elseif (endsWith($im_url, 'JustArrived_map_md.jpg')) {
                 return false;
            }
            if(endsWith($im_url, 'JustArrived_original_md.jpg'))
            {
                return false;
            }
            elseif (endsWith($im_url, 'JustArrived_map_original_md.jpg')) {
                 return false;
            }
            else{
                return true;
            }

        });

    
}


 add_filter("filter_lougheedhyundai_field_stock_type", "filter_lougheedhyundai_field_stock_type");

    function filter_lougheedhyundai_field_stock_type($stock_type) {
        return strtolower($stock_type);
    }