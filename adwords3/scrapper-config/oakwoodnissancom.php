<?php
global $scrapper_configs;
$scrapper_configs["oakwoodnissancom"] = array( 
	"entry_points" => array(
        'new'  => 'https://www.oakwoodnissan.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1353%26sf%3Dtrue%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3Dtrue%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3Dasking_price%252Casc%26ai%3D%26oem%3D%26prr%3D0%252C10000%252C10000%252C25000%252C25000%252C50000%252C50000%252C103579%26yrr%3D2010%252C2014%252C2015%252C2017%252C2018%252C2019%252C2019%252C2020%252C2021%252C2022%26odr%3D0%252C25000%252C25000%252C50000%252C50000%252C100000%252C100000%252C250000%26yr%3D%26mk%3D%26md%3D%26pr%3D%26tr%3D%26od%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Daski%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        'used' => 'https://www.oakwoodnissan.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1353%26sf%3Dtrue%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3Dtrue%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3Dasking_price%252Casc%26ai%3D%26oem%3D%26prr%3D0%252C10000%252C10000%252C25000%252C25000%252C50000%252C50000%252C82000%26yrr%3D2010%252C2014%252C2015%252C2017%252C2018%252C2019%252C2019%252C2020%252C2021%252C2022%26odr%3D0%252C25000%252C25000%252C50000%252C50000%252C100000%252C100000%252C250000%26yr%3D%26mk%3D%26md%3D%26pr%3D%26tr%3D%26od%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Daski%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data'
    ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',
    'picture_selectors' => ['.modal-slideshow__gallery__container__img'],
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
                'price' => $obj->final_price==0?"please call":$obj->final_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                'msrp' => $obj->msrp,
                //'url' => "https://www.oakwoodnissan.com/vehicles/" . strtolower($obj->year) .
                //'/' . strtolower($obj->make) . '/' . strtolower(explode(" ", $obj->model)[0]) . '-' . strtolower(explode(" ", $obj->model)[1]) . '/airdrie/ab/' . strtolower($obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'url' => preg_replace('/http(s)?:.*(?=vehicles)/', 'https://www.oakwoodnissan.com/', $obj->vdp_url),
                'interior_color' => $obj->interior_color,
                //  'all_images' => $obj->image->image_original,
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
    'images_regx' => '/image_lg":"(?<img_url>[^"]+)"/',
);

add_filter('filter_oakwoodnissancom_post_data', 'filter_oakwoodnissancom_post_data', 10, 2);

function filter_oakwoodnissancom_post_data($post_data, $stock_type) {

    if ($stock_type == 'new') {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1353%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26sc%3Dnew%26v1%3D%26st%3Dyear%252Cdesc%26ai%3Dtrue%26oem%3D%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data';
    } elseif ($stock_type == 'used') {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1353%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26sc%3Dused%26v1%3D%26st%3Dyear%252Cdesc%26ai%3Dtrue%26oem%3D%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data';
    }

    return $post_data;
}
add_filter("filter_oakwoodnissancom_field_images", "filter_oakwoodnissancom_field_images", 10, 2);

function filter_oakwoodnissancom_field_images($im_urls, $car_data) {
    $retval = array();
    // slecho(implode('|', $im_urls));

    $ignore = "https://www.oakwoodnissan.com/vehicles/" . strtolower($car_data['year']) . "/" . strtolower($car_data['make']) . "/" . strtolower(explode(" ",$car_data['model'])[0])  . '-'.strtolower(explode(" ",$car_data['model'])[1]) .  "/airdrie/ab/";

    slecho($ignore);

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore,  '\\', '=',], ['', '', '',], rawurldecode($im_url));
    }
    
    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);

    return $retval;
}