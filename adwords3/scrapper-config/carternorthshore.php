<?php

global $scrapper_configs;

$scrapper_configs['carternorthshore'] = array(
     'entry_points' => array(
        'new' => 'https://www.carternorthshore.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2150%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dmsrp-inc%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        'used' => 'https://www.carternorthshore.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2150%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dmsrp-inc%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data'
    ),
    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match' => '/libs/formProcessor.html',
    'use-proxy' => true,
    'refine' => false,
    //'init_method' => 'POST',
    //'next_method' => 'POST',
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts' => [],
    'picture_prevs' => [],
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
                'price' => $obj->lowest_price>=200000?"please call": $obj->lowest_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fuel_type,
                'drivetrain' => $obj->drive_train,
                'msrp' => $obj->msrp,

                // 'url' => "https://www.carternorthshore.com/vehicles/" . strtolower($obj->year) .
                // '/' . strtolower($obj->make) . '/' . strtolower(explode(" ", $obj->model)[0]) . '-' . strtolower(explode(" ", $obj->model)[1]) . '/edmonton/ab/' . strtolower($obj->ad_id),


                 'url'            => strtolower("https://www.carternorthshore.com/vehicles/" . $obj->year . '/' . $obj->make . '/' . str_replace(" ", "-", $obj->model) . '/edmonton/ab/' . $obj->ad_id),


                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                // 'all_images' => $obj->image->image_original,
                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );

            $imgs=[];
             foreach($obj->image as $value){
                    
                      $imgs[]=$value->image_lg;
  
            }
            $car_data['all_images']=implode("|",$imgs);

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/image_lg":"(?<img_url>[^"]+)/',
);




add_filter("filter_carternorthshore_field_images", "filter_carternorthshore_field_images", 10, 2);

function filter_carternorthshore_field_images($im_urls, $car_data) {
    $retval = array();

    foreach ($im_urls as $im_url) {
     
       $im_url = str_replace('\\','',$im_url);
        $retval[]=$im_url;
        
        slecho("ddddddd: " . $im_url);
    }
    
    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);

    return $retval;
}

add_filter('filter_for_google_merchant_carternorthshore', 'filter_for_google_merchant_carternorthshore', 10, 1);
function filter_for_google_merchant_carternorthshore($car_data)
{
    $images = explode('|', $car_data['all_images']);
    
    if (count($images) <= 3) {
        $images = [];
    }

    
    

    if (isset($images[0])) {
        unset($images[0]);
    }

//    if (isset($images[1])) {
//        unset($images[1]);
//    }
    
    $car_data['images'] = $images;
    $car_data['all_images'] = implode('|', $images);

    return $car_data;
}