<?php

global $scrapper_configs;
$scrapper_configs['brianjesselbmw'] = array(
    'entry_points' => array(
        'new' => 'https://www.brianjesselbmw.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
        'used' => 'https://www.brianjesselbmw.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php'
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
                'price' => $obj->lowest_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                'msrp' => $obj->msrp,
               // 'url' => $obj->vdp_url,
                // 'url' => "https://www.brianjesselbmw.com/vehicles/" . strtolower($obj->year) .
                // '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/vancouver/bc/' . strtolower($obj->ad_id)."?sale_class=".strtolower($obj->sale_class),


                'url' => "https://www.brianjesselbmw.com/vehicles/" . strtolower($obj->year) .
                '/' . strtolower($obj->make) . '/' . strtolower(explode(" ", $obj->model)[0]) . '-' . strtolower(explode(" ", $obj->model)[1]) . '/vancouver/bc/' . strtolower($obj->ad_id),


                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                'all_images' => $obj->image->image_original,
                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );



            $to_return[] = $car_data;
        }

 return $to_return;
},
    'images_regx' => '/image_lg":"(?<img_url>[^"]+)/',
);

add_filter('filter_brianjesselbmw_post_data', 'filter_brianjesselbmw_post_data', 10, 2);

function filter_brianjesselbmw_post_data($post_data, $stock_type) {

    if ($stock_type == 'new') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2362%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dtrue%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3Dmodel%252Casc%26ai%3D%26mk%3DBMW%26md%3D%26tr%3D%26od%3D90%252C2999%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dsale%26pupm%3Daski%26pupf%3Dnone%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D';
    } elseif ($stock_type == 'used') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2362%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dtrue%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3Dmodel%252Casc%26ai%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dsale%26pupm%3Daski%26pupf%3Dnone%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D';
    }

    return $post_data;
}

add_filter("filter_brianjesselbmw_field_images", "filter_brianjesselbmw_field_images",10,2);
function filter_brianjesselbmw_field_images($im_urls, $car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));
   $ignore="https://www.brianjesselbmw.com/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower(explode(" ",$car_data['model'])[0]) . '-'.strtolower(explode(" ",$car_data['model'])[1]) .  "/vancouver/bc/";
    slecho("vvv:". $ignore);
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786', '\\'], ['', '', ''], rawurldecode($im_url));
    }
    return $retval;
}