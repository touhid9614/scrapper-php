<?php
global $scrapper_configs;
$scrapper_configs["northernrvca"] = array( 
	 'entry_points' => array(
            'new'   => 'https://www.northernrv.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1662%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DAll%26st%3D%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D&action=vms_data',
            'used'  => 'https://www.northernrv.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1662%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DAll%26st%3D%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D&action=vms_data'
        ),
       'srp_page_regex'         => '/\/(?:used|new)/',
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
                'stock_type'        =>  strtolower($obj->sale_class),
                'year'              => $obj->year,
                'make'              => $obj->make,
                'model'             => strtolower($obj->model),
                'trim'              => $obj->trim,
                'body_style'        => $obj->body_style,
                'price'             => $obj->final_price==0?"please call":$obj->final_price,
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->odometer,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel_type,
                'drivetrain'        => $obj->drive_train,
                'msrp'              => $obj->msrp,
                'url'               => "https://www.northernrv.ca/vehicles/" . strtolower($obj->year) .
                                       '/' . strtolower($obj->make) . '/' . strtolower(explode(" ", $obj->model)[0]) . '-' . strtolower(explode(" ", $obj->model)[1]) .'/sudbury/on/' . strtolower($obj->ad_id),
                'exterior_color'    => $obj->exterior_color,
                'interior_color'    => $obj->interior_color,
                'all_images'        => $obj->image->image_original,
                'title'             => $obj->year .' '. $obj->make . ' ' . $obj->model,
            );

            
            $temp_data = HttpGet($car_data['url']);

            $description_regex    = '/<meta name="description" content="(?<description>[^"]+)"/';

            $matches = array();

            if(preg_match($description_regex, $temp_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }


               $to_return[] = $car_data;
           }

           return $to_return;
       },
            'images_regx'       => '/image_lg":"(?<img_url>[^"]+)/',
);
    
add_filter('filter_northernrvca_post_data', 'filter_northernrvca_post_data', 10, 2);
add_filter("filter_northernrvca_field_images", "filter_northernrvca_field_images",10,2);

function filter_northernrvca_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
    $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1662%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DAll%26st%3D%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D&action=vms_data';}
    elseif($stock_type == 'used')
    {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1662%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DAll%26st%3D%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D&action=vms_data';
    }

    return $post_data;
}

function filter_northernrvca_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    
$ignore="https://www.northernrv.ca/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower(explode(" ",$car_data['model'])[0])  . '-'.strtolower(explode(" ",$car_data['model'])[1]) .  "/" . "sudbury/on/";
   
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
     //      if(count($retval) < 2) { return array(); }
    return $retval;
}

 add_filter("filter_northernrvca_field_stock_type", "filter_northernrvca_field_stock_type");
    function filter_northernrvca_field_stock_type($stock_type) {
        return strtolower($stock_type);
    }