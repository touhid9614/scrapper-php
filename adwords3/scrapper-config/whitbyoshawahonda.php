<?php

global $scrapper_configs;

$scrapper_configs['whitbyoshawahonda'] = array(
    'entry_points' => array(
         'used' => 'https://www.whitbyoshawahonda.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
        'new' => 'https://www.whitbyoshawahonda.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
        
    ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
  //  'refine' => false,
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
              //  'msrp' => $obj->msrp,
                'url' => "https://www.whitbyoshawahonda.com/vehicles/" . strtolower($obj->year) .
                '/' . strtolower($obj->make) . '/' . strtolower(str_replace(" ","-",$obj->model))  . '/whitby/on/' . strtolower($obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                'all_images' => $obj->image->image_original,
                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );



            $to_return[] = $car_data;
        }

        return $to_return;
    },
            'images_regx'       => '/image_lg":"(?<img_url>[^"]+)/',
);

add_filter('filter_whitbyoshawahonda_post_data', 'filter_whitbyoshawahonda_post_data', 10, 2);

function filter_whitbyoshawahonda_post_data($post_data, $stock_type) {

    if ($stock_type == 'new') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D980%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3Dmodel%252Casc%26yr%3D2018%252C2020%26mk%3D%26md%3D%26pr%3D0%252C57635%26tr%3D%26od%3D4%252C60688%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D%26pnpi%3Dnone%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone';
        } elseif ($stock_type == 'used') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D980%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3Dmodel%252Casc%26yr%3D2003%252C2019%26mk%3D%26md%3D%26pr%3D0%252C59900%26tr%3D%26od%3D7%252C334885%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D%26pnpi%3Dnone%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone';
        
        }

    return $post_data;
}
add_filter("filter_whitbyoshawahonda_field_images", "filter_whitbyoshawahonda_field_images",10,2);
function filter_whitbyoshawahonda_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    
    $ignore="https://www.whitbyoshawahonda.com/vehicles/ggggggg" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower(explode(" ",$car_data['model'])[0])  . '-'.strtolower(explode(" ",$car_data['model'])[1]) . "/" . "whitby/on/";
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''], rawurldecode($im_url));
    }


    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);


    return $retval;
}
