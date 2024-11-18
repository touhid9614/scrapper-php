<?php
global $scrapper_configs;
$scrapper_configs["parklanddodgecom"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.parklanddodge.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D970%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3D%26st%3Dprice%252Casc%26ai%3D%26oem%3D%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Daski%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        'new' => 'https://www.parklanddodge.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D970%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3D%26st%3Dprice%252Casc%26ai%3D%26oem%3D%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Daski%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        
    ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
     'picture_selectors' => ['.photo-card'],
    'picture_nexts' => ['#viewer-next-button'],
    'picture_prevs' => ['#viewer-prev-button'],
    'custom_data_capture' => function ($url, $data)
    {
        $objects = json_decode($data);

        if (!$objects)
        {
            slecho($data);
            return array();
        }

        $to_return = array();

        foreach ($objects->results as $obj)
        {
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
               
                'url' => $obj->vdp_url,
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
              //  'all_images' => $obj->image->image_original,
              //  'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );

            $response_data = HttpGet($car_data['url']);
            $regex = '/","description":"(?<description>[^"]+)/';

            $matches = [];

            if (preg_match($regex, $response_data, $matches))
            {
                $car_data['description'] = $matches['description'];

                //return  $im_urls;
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'data_capture_regx_full' => array(
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
    ),

    'images_regx' => '/image_lg":"(?<img_url>[^"]+)/',
);

//add_filter('filter_lindsaynissan_post_data', 'filter_lindsaynissan_post_data', 10, 2);
add_filter("filter_parklanddodgecom_field_images", "filter_parklanddodgecom_field_images", 10, 2);

// function filter_lindsaynissan_post_data($post_data, $stock_type)
// {
//     if ($stock_type == 'new')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D629%26ln%3Den%26pg%3D1%26pc%3D200%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3D%26yr%3D2019%252C2020%26mk%3D%26md%3D%26pr%3D16203%252C82213%26tr%3D%26od%3D13%252C6180%26bs%3D%26tm%3D%26ec%3D%26v2%3D%26fp%3D%26fc%3D%26fn%3D';
//     }
//     elseif ($stock_type == 'used')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D629%26ln%3Den%26pg%3D1%26pc%3D100%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26ec%3D%26ic%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D';
//     }

//     return $post_data;
// }

function filter_parklanddodgecom_field_images($im_urls, $car_data)
{
    $retval = array();

    foreach ($im_urls as $im_url)
    {
        $retval[] = str_replace(['-1024x786', '\\'], ['', ''], rawurldecode($im_url));
    }
    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);

    return $retval;
}

add_filter("filter_parklanddodgecom_field_stock_type", "filter_parklanddodgecom_field_stock_type");

function filter_parklanddodgecom_field_stock_type($stock_type)
{
    return strtolower($stock_type);
}