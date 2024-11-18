<?php

global $scrapper_configs;

$scrapper_configs['monctonkia'] = array(
    'entry_points' => array(
        'new'   => 'https://www.monctonkia.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D487%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3D%26oem%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D&action=vms_data',
        'used'  => 'https://www.monctonkia.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D487%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3D%26oem%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D&action=vms_data'
    ),
    'vdp_url_regex'         => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match'        => '/libs/formProcessor.html',
    'use-proxy'         => true,
    'refine'            => false,
    'init_method'       => 'POST',
    'next_method'       => 'POST',
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts'     => ['button.modal-slideshow__next'],
    'picture_prevs'     => ['button.modal-slideshow__prev'],
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
                'price'             => $obj->final_price,
                'engine'            => $obj->engine,
                'transmission'      => $obj->transmission,
                'kilometres'        => $obj->odometer,
                'vin'               => $obj->vin,
                'fuel_type'         => $obj->fuel_type,
                'drivetrain'        => $obj->drive_train,
                'msrp'              => $obj->msrp,
                'url'               => "https://www.monctonkia.ca/vehicles/" .strtolower($obj->year).
                    '/' .strtolower($obj->make). '/' .strtolower(explode(" ",$obj->model)[0])  . '-'.strtolower(explode(" ",$obj->model)[1]).  '/fernie/bc/' . strtolower($obj->ad_id),
                'exterior_color'    => $obj->exterior_color,
                'interior_color'    => $obj->interior_color,
                'all_images'        => $obj->image->image_original,
                'title'             => $obj->year .' '. $obj->make . ' ' . $obj->model,
            );



            $response_data = HttpGet($car_data['url']);
            $regex       =  '/","description":"(?<description>[^"]+)/';

            $matches = [];


            if(preg_match($regex, $response_data, $matches)) {

                $car_data['description']=$matches['description'];

                //return  $im_urls;

            }



            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'data_capture_regx_full' => array(
        'description'   => '/","description":"(?<description>[^"]+)/',
    ),
    'images_regx'       => '/image_lg":"(?<img_url>[^"]+)/',
);

add_filter('filter_monctonkia_post_data', 'filter_monctonkia_post_data', 10, 2);

function filter_monctonkia_post_data($post_data, $stock_type)
{
    if($stock_type == 'new')
    {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D487%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3D%26oem%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D&action=vms_data';
    }
    elseif($stock_type == 'used')
    {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D487%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3D%26oem%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D&action=vms_data';
    }

    return $post_data;
}

add_filter("filter_monctonkia_field_images", "filter_monctonkia_field_images",10,2);
function filter_monctonkia_field_images($im_urls,$car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));

    $ignore="https://www.monctonkia.ca/vehicles/new/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/" . "fernie/bc/";
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''], rawurldecode($im_url));
    }


    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);


    return $retval;
}


add_filter("filter_monctonkia_field_stock_type", "filter_monctonkia_field_stock_type");

function filter_monctonkia_field_stock_type($stock_type) {
    return strtolower($stock_type);
}