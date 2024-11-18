<?php

global $scrapper_configs;
$scrapper_configs["rockys_harley"] = array(
  'entry_points' => array(
            'used'  => 'https://www.rockys-harley.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1184%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DAll%26st%3Ddays_on_lot%252Cdesc%26ai%3D%26oem%3D%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data',        
            'new'   => 'https://www.rockys-harley.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1184%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DAll%26st%3Ddays_on_lot%252Cdesc%26ai%3D%26oem%3D%26defaultParams%3D&action=vms_data',       
        ),
        'vdp_url_regex'         => '/\/vehicles\/[0-9]{4}\//',
        'ajax_url_match'        => '/libs/formProcessor.html',
        'use-proxy'         => true,
        'refine'            => false,
        'init_method'       => 'POST',
        'next_method'       => 'POST',
        'picture_selectors' => ['.modal-slideshow__gallery__container img'],
        'picture_nexts'     => ['.modal-slideshow__next'],
        'picture_prevs'     => ['.modal-slideshow__prev'],
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
                'price'             => $obj->final_price>0?$obj->final_price:"Please call",
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->odometer,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel_type,
                'drivetrain'        => $obj->drive_train,
                'msrp'              => $obj->final_price>0?$obj->final_price:"Please call",
                'url'               => "https://www.rockys-harley.com/vehicles/" . strtolower($obj->year) .
                                       '/' . strtolower($obj->make) . '/' . str_replace(" ","-",strtolower($obj->model)) . '/london/on/' . strtolower($obj->ad_id),
                'exterior_color'    => $obj->exterior_color,
                'interior_color'    => $obj->interior_color,
                'all_images'        => $obj->image->image_original,
                'title'             => $obj->year .' '. $obj->make . ' ' . $obj->model,
            );

            

            $to_return[] = $car_data;
        }

        return $to_return;
    },
   'images_regx'       => '/image_lg":"(?<img_url>[^"]+)/',
);
    
//add_filter('filter_rockys_harley_post_data', 'filter_rockys_harley_post_data', 10, 2);
add_filter("filter_rockys_harley_field_images", "filter_rockys_harley_field_images",10,2);

// function filter_rockys_harley_post_data($post_data, $stock_type)
// {
//     if($stock_type == 'new')
//     {
//     $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1184%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DAll%26st%3Ddays_on_lot%252Cdesc%26ai%3D%26defaultParams%3D';
    
//     }
//     elseif($stock_type == 'used')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1184%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DAll%26st%3Ddays_on_lot%252Cdesc%26ai%3D%26SrpTemplateParams%3D%26defaultParams%3D';
//         }

//     return $post_data;
// }

function filter_rockys_harley_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    
$ignore="https://www.rockys-harley.com/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . str_replace(" ","-",strtolower($car_data['model'])) . "/london/on/";
   
slecho("xx:" . $ignore);
         
  foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''], rawurldecode($im_url));
        }
     


       
    return $retval;
}


 add_filter("filter_rockys_harley_field_stock_type", "filter_rockys_harley_field_stock_type");

    function filter_rockys_harley_field_stock_type($stock_type) {
        return strtolower($stock_type);
    }