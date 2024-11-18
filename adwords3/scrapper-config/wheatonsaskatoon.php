<?php

global $scrapper_configs;

$scrapper_configs['wheatonsaskatoon'] = array(
    "entry_points" => array(
        'used' => 'https://www.wheatonsaskatoon.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D3449%26ln%3Den%26pg%3D1%26pc%3D150%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3Dtrue%26sc%3Dused%26v1%3D%26st%3D%26ai%3D%26oem%3D%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Daski%26pnpm%3Dinte%26pnpf%3Dnone%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3Dfixed&action=vms_data',
         'new' => 'https://www.wheatonsaskatoon.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D3449%26ln%3Den%26pg%3D1%26pc%3D150%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3Dtrue%26sc%3Dnew%26v1%3D%26st%3D%26ai%3D%26oem%3D%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Daski%26pnpm%3Dinte%26pnpf%3Dnone%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3Dfixed&action=vms_data',
             ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'POST',
    'next_method' => 'POST',

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
                //'trim' => $obj->trim,
                'body_style' => $obj->body_style,
                // 'price' => $obj->internet_price,
                // 'price' => $obj->lowest_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                // 'msrp' => $obj->msrp,
                'url'            => $obj->vdp_url,
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                'all_images' => $obj->image->image_original,
                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );

           $response_data = HttpGet($car_data['url']);
           $regex = '/"final_price":(?<price>[^\,]+)/';
           $matches = [];
           if (preg_match($regex, $response_data, $matches)) {
               $car_data['price'] = $matches['price'];
           }

           if($car_data['price'] == "0"){
                $car_data['price'] = "Please Call";
           }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/image_lg":"(?<img_url>[^"]+)"/',
);

add_filter('filter_wheatonsaskatoon_post_data', 'filter_wheatonsaskatoon_post_data', 10, 2);

function filter_wheatonsaskatoon_post_data($post_data, $stock_type) {

    if ($stock_type == 'used') {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D533%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dall%26v1%3DPassenger%2520Vehicles%26st%3Dprice%252Cdesc%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3D%26tg%3D&action=vms_data';
    }
     if ($stock_type == 'demo') {
        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D533%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3D%26v1%3DMotorcycle%26st%3Dprice%252Cdesc%26ai%3D%26oem%3D%26yr%3D2014%252C2014%26pr%3D11910%252C11910%26od%3D13655%252C13655%26SrpTemplateParams%3D%26defaultParams%3D&action=vms_data';
    }
    return $post_data;
}
add_filter('filter_wheatonsaskatoon_car_data', 'filter_wheatonsaskatoon_car_data');

function filter_wheatonsaskatoon_car_data($car_data) {

    $retval = array();
    if($car_data['stock_type']=='demo'){
        $car_data['stock_type']="used";
    }
    $ignore_data=[
                    '6979057',
                    '6970113',
                    '7005035',
                    '6995650',
                    '6995616',
                    '6979063',
                    '248033',
                    '6970111',
                    '6975199',
                    '6995663',
                    '6975111',
                    '6975101',
                    '6995595',
                    
                ];
    
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                 return null;

            }
    $im_urls = explode('|', $car_data['all_images']);
    
    foreach ($im_urls as $im_url) {
        
         if(strpos($im_url,"_overlay")){
                 slecho("this vehicles has overlay images");
                 continue;
        }
        $retval[] = $im_url;
    }
     
    $car_data['all_images'] = implode('|', $retval);
    return $car_data;
}
//
//add_filter("filter_wheatonsaskatoon_field_images", "filter_wheatonsaskatoon_field_images",10,2);
//function filter_wheatonsaskatoon_field_images($im_urls,$car_data) {
//    $retval = array();
//        
//    foreach ($im_urls as $im_url) {
//        
//         if(strpos($im_url,"_overlay")){
//                 slecho("this vehicles has overlay images");
//                 continue;
//        }
//        $retval[] = $im_url;
//    }
//     
//    return $retval;
//}
