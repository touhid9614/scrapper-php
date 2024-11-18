<?php

    global $scrapper_configs;

    $scrapper_configs['southtrailkia'] = array(
        'entry_points' => array(
            'new' => 'https://www.southtrailkia.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D945%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3DKia%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data',
            'used' => 'https://www.southtrailkia.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D945%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3D%26sc%3Dused%26v1%3D%26st%3Dmodel%252Casc%26ai%3Dtrue%26oem%3DKia%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data'
    ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//i',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts' => ['button.modal-slideshow__next'],
    'picture_prevs' => ['button.modal-slideshow__prev'],

    'custom_data_capture' => function ($url, $data) {
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
                'price' => $obj->sale_price==0?$obj->internet_price:$obj->sale_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                'msrp' => $obj->msrp,
                'url' => "https://www.southtrailkia.com/vehicles/" . strtolower($obj->year) .
                    '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/calgary/ab/' . strtolower($obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                'all_images' => $obj->image->image_original,
                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );

            $response_data = HttpGet($car_data['url']);
            $regex = '/","description":"(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];

            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/image_lg":"(?<img_url>[^"]+)/',
);

// add_filter('filter_southtrailkia_post_data', 'filter_southtrailkia_post_data', 10, 2);
// function filter_southtrailkia_post_data($post_data, $stock_type)
// {

//     if ($stock_type == 'new') {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D945%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dtrue%26qs%3D%26im%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3DKia%26SrpTemplateParams%3D%26defaultParams%3D';
//     } elseif ($stock_type == 'used') {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D945%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dtrue%26qs%3D%26im%3D%26sc%3Dused%26v1%3D%26st%3Dmodel%252Casc%26ai%3Dtrue%26oem%3DKia%26SrpTemplateParams%3D%26defaultParams%3D';
//     }

//     return $post_data;
// }

add_filter("filter_southtrailkia_field_images", "filter_southtrailkia_field_images", 10, 2);
function filter_southtrailkia_field_images($im_urls, $car_data)
{
    $retval = array();
   

    $ignore = "https://www.southtrailkia.com/vehicles/" . strtolower($car_data['year']) . "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/calgary/ab/";

    slecho($ignore);

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786', '\\'], ['', '', ''], rawurldecode($im_url));
    }

    return $retval;
}
