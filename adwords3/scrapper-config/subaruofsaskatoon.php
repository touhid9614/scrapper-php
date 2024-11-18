<?php

global $scrapper_configs;
$scrapper_configs['subaruofsaskatoon'] = array(
   'entry_points' => array(
          //  'new'   => 'https://www.subaruofsaskatoon.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
            'used'  => 'https://www.subaruofsaskatoon.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php'
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
                'url'               => "https://www.subaruofsaskatoon.ca/vehicles/" . strtolower($obj->year) .
                                       '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/saskatoon/sk/' . strtolower($obj->ad_id),
                'exterior_color'    => $obj->exterior_color,
                'interior_color'    => $obj->interior_color,
                'all_images'        => $obj->image->image_original,
                'title'             => $obj->year .' '. $obj->make . ' ' . $obj->model,
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
   
);
    
add_filter('filter_subaruofsaskatoon_post_data', 'filter_subaruofsaskatoon_post_data', 10, 2);

function filter_subaruofsaskatoon_post_data($post_data, $stock_type)
{
   if($stock_type == 'used')
    {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1390%26ln%3Den%26pg%3D1%26pc%3D200%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3D%26st%3D';
    }

    return $post_data;
}
