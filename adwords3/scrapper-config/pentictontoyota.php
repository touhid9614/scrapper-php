<?php

global $scrapper_configs;
$scrapper_configs['pentictontoyota'] = array(
    //https://app.guidecx.com/app/projects/aa44975d-e482-4c20-ac47-b43b37f4d93b/notes they want to scrap using csv
      'entry_points' => array(
      'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/PentictonToyota.csv'
    ),
      'vdp_url_regex'         => '/\/vehicles\//',
        'use-proxy'         => true,
       'refine' => false,
        'picture_selectors' => ['.modal-slideshow__gallery__container__img'],
        'picture_nexts'     => ['.modal-slideshow__next'],
        'picture_prevs'     => ['.modal-slideshow__prev'],
    
    
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

       $result = [];
  foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['StockNumber'],
               'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
               'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
               'trim' => $vehicle['Trim'],
               'drivetrain' => $vehicle['Drivetrain'],
                'fuel_type' => $vehicle['Fuel'],
                'transmission' => $vehicle['Transmission'],
               'body_style' => $vehicle['BodyStyle'],
               'images' => explode('|', $vehicle['Images']),
               'all_images' => $vehicle['Images'],

       'price' => $vehicle['SalePrice'] < $vehicle['RetailPrice'] ? $vehicle['SalePrice'] : $vehicle['RetailPrice'],


                'url' => $vehicle['WebUrl'],
               'stock_type' => strtolower($vehicle['Condition']),
               'exterior_color' => $vehicle['ColorExterior'],
              // 'interior_color' => $vehicle['Interior Color'],
              'engine' => $vehicle['Engine'],
               'description' => strip_tags($vehicle['Description']),
               'kilometres' => $vehicle['Mileage'],
            ];
            if($car_data['price']<=0){
                continue;
            }

           $result[] = $car_data;
     }
  
        return $result;
    }
);   
 	
    
    
    
    
//    'entry_points' => array(
//        'new' => 'https://www.pentictontoyota.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2696%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26view%3Dgrid%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dinte%26pnpm%3Dnone%26pnpf%3Dnone%26pupi%3Dreta%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
//        'used' => 'https://www.pentictontoyota.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2696%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dinte%26pnpm%3Dnone%26pnpf%3Dnone%26pupi%3Dreta%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data'
//    ),
//    'vdp_url_regex' => '/\/vehicles\/[0-9]{4}\//',
//     'srp_page_regex'      => '/\/vehicles\/(?:new|used|certified)\//i',
//    'ajax_url_match' => '/libs/formProcessor.html',
//    'use-proxy' => true,
//    'refine' => false,
//    'init_method' => 'POST',
//    'next_method' => 'POST',
//    'picture_selectors' => ['.thumbnails__single'],
//    'picture_nexts' => ['button.modal-slideshow__next'],
//    'picture_prevs' => ['button.modal-slideshow__prev'],
//    'custom_data_capture' => function ($url, $data) {
//
//        $objects = json_decode($data);
//
//
//        if (!$objects) {
//            slecho($data);
//            return array();
//        }
//
//
//        $to_return = array();
//
//
//        foreach ($objects->results as $obj) {
//
//
//            $car_data = array(
//                'stock_number' => $obj->stock_number ? $obj->stock_number : $obj->vehicle_id,
//                'stock_type' => strtolower($obj->sale_class),
//                'year' => $obj->year,
//                'make' => $obj->make,
//                'model' => $obj->model,
//                'trim' => $obj->trim,
//                'body_style' => $obj->body_style,
//                'price' => $obj->asking_price,
//                'engine' => $obj->engine,
//                'transmission' => $obj->transmission,
//                'kilometres' => $obj->odometer,
//                'vin' => $obj->vin,
//                'fuel_type' => $obj->fuel_type,
//                'drivetrain' => $obj->drive_train,
//                'msrp' => $obj->msrp,
//                'url' => "https://www.pentictontoyota.com/vehicles/" . strtolower($obj->year) .
//                    '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/penticton/bc/' . strtolower($obj->ad_id),
//                'exterior_color' => $obj->exterior_color,
//                'interior_color' => $obj->interior_color,
//             //   'all_images' => $obj->image->image_original,
//                'title' => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
//            );
//
//            $response_data = HttpGet($car_data['url']);
//            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
//            $matches = [];
//            if (preg_match($regex, $response_data, $matches)) {
//
//                $car_data['description'] = $matches['description'];
//            }
//
//            $to_return[] = $car_data;
//        }
//
//        return $to_return;
//    },
//    'images_regx' => '/image_lg":"(?<img_url>[^"]+)/',
//);
//
//add_filter('filter_pentictontoyota_post_data', 'filter_pentictontoyota_post_data', 10, 2);
//add_filter("filter_pentictontoyota_field_images", "filter_pentictontoyota_field_images", 10, 2);
//function filter_pentictontoyota_field_images($im_urls, $car_data)
//{
//    $retval = array();
//    // slecho(implode('|', $im_urls));
//
//    $ignore = "https://www.pentictontoyota.com/vehicles/" . strtolower($car_data['year']) . "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/" . "penticton/bc/";
//
//    slecho($ignore);
//
//    foreach ($im_urls as $im_url) {
//        $retval[] = str_replace([$ignore, '-1024x786','\\','=','LmpwZyIsImVkaXRzIjp7InJlc2l6ZSI6eyJ3aWR0aCI6MTAyNCwiaGVpZ2h0Ijo3NjgsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ'], ['', '','','','LmpwZyIsImVkaXRzIjp7InJlc2l6ZSI6eyJ3aWR0aCI6MTQ0MCwiaGVpZ2h0IjoxMDgwLCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJnZW1lbnQiOnRydWV9fX0'], rawurldecode($im_url));
//    }
//    if (count($retval)<=1) {
//        return array();
//    }
//    return $retval;
//}
//
//function filter_pentictontoyota_post_data($post_data, $stock_type)
//{
//
//    if ($stock_type == 'new') {
//        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2696%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26view%3Dgrid%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dinte%26pnpm%3Dnone%26pnpf%3Dnone%26pupi%3Dreta%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data';
//    } elseif ($stock_type == 'used') {
//        $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2696%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dinte%26pnpm%3Dnone%26pnpf%3Dnone%26pupi%3Dreta%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data';
//    }
//
//    return $post_data;
//}
