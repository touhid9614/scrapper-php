<?php
global $scrapper_configs;
$scrapper_configs["canmorecamclarkfordcom"] = array( 
    
//     'entry_points' => array(
//         'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/camclarkfordcanmore.csv'
//     ),
//        'vdp_url_regex'         => '/\/vehicles\//',
//          'use-proxy'         => true,
//        'refine' => false,
//         'picture_selectors' => ['.modal-slideshow__gallery__container__img'],
//         'picture_nexts'     => ['.modal-slideshow__next'],
//         'picture_prevs'     => ['.modal-slideshow__prev'],
    
    
//     'custom_data_capture' => function($url, $resp) {
//         $vehicles = convert_CSV_to_JSON($resp);

//         $result = [];

//         foreach ($vehicles as $vehicle) {
            
//              if(strpos($vehicle['vdpURL'],"www.innisfailchrysler")){
//                continue;
//             }
//              if(strpos($vehicle['vdpURL'],"www.camclarkfordolds")){
//                continue;
//             }
//              if(strpos($vehicle['vdpURL'],"www.camclarkfordreddeer")){
//                continue;
//             }
//              if(strpos($vehicle['vdpURL'],"www.camclarkfordairdrie")){
//                continue;
//             }
           
//             $car_data = [
//                 'stock_number' => $vehicle['StockNumber'],
//                 'vin' => $vehicle['Vin'],
//                 'year' => $vehicle['Year'],
//                 'make' => $vehicle['Make'],
//                 'model' => $vehicle['Model'],
//                 'trim' => $vehicle['Trim'],
//                 'drivetrain' => $vehicle['Drivetrain Desc'],
//                 'fuel_type' => $vehicle['Fuel'],
//                 'transmission' => $vehicle['Transmission'],
//                 'body_style' => $vehicle['Body'],
//                 'images' => explode('|', $vehicle['MainPhoto']),
//                 'all_images' => $vehicle['MainPhoto'],
//                 'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
//                 'url' => $vehicle['vdpURL'],
//                 'stock_type' => strtolower($vehicle['Status']),
//                 'exterior_color' => $vehicle['Exterior Color'],
//                 'interior_color' => $vehicle['Interior Color'],
//                 'engine' => $vehicle['Engine'],
//                 'description' => strip_tags($vehicle['Description']),
//                 'kilometres' => $vehicle['KMS'],
//             ];


//             $result[] = $car_data;
//         }

//         return $result;
//     }
// );


    
	"entry_points" => array(
     'used' => 'https://www.canmorecamclarkford.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D359%26sf%3Dtrue%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3D%26oem%3D%26prr%3D0%252C10000%252C10000%252C25000%252C25000%252C50000%252C50000%252C~%26yrr%3D2010%252C2014%252C2015%252C2017%252C2018%252C2019%252C2019%252C2020%252C2021%252C2022%26odr%3D0%252C25000%252C25000%252C50000%252C50000%252C100000%252C100000%252C250000%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Daski%26pupm%3Dnone%26pupf%3Dsale%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
       'new' => 'https://www.canmorecamclarkford.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D359%26sf%3Dtrue%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3D%26oem%3D%26prr%3D0%252C10000%252C10000%252C25000%252C25000%252C50000%252C50000%252C~%26yrr%3D2010%252C2014%252C2015%252C2017%252C2018%252C2019%252C2019%252C2020%252C2021%252C2022%26odr%3D0%252C25000%252C25000%252C50000%252C50000%252C100000%252C100000%252C250000%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Daski%26pupm%3Dnone%26pupf%3Dsale%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
     
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
                 'url'            => strtolower("https://www.canmorecamclarkford.com/vehicles/" . $obj->year . '/' . $obj->make . '/' . str_replace(" ", "-", $obj->model) . '/canmore/ab/' . $obj->ad_id),
               'exterior_color' => $obj->exterior_color,
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

// add_filter('filter_canmorecamclarkfordcom_post_data', 'filter_canmorecamclarkfordcom_post_data', 10, 2);

// function filter_canmorecamclarkfordcom_post_data($post_data, $stock_type) {

//     if ($stock_type == 'new') {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D359%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DPassenger%2520Vehicles%26st%3D%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3DCam%2520Clark%2520Ford%2520Canmore%26tg%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Daski%26pupm%3Dnone%26pupf%3Dsale%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D';
//     } elseif ($stock_type == 'used') {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D359%26ln%3Den%26pg%3D1%26pc%3D500%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DPassenger%2520Vehicles%26st%3D%26ai%3D%26oem%3D%26mk%3D%26md%3D%26tr%3D%26bs%3D%26tm%3D%26dt%3D%26cy%3D%26ec%3D%26mc%3D%26ic%3D%26pa%3D%26ft%3D%26eg%3D%26v2%3D%26v3%3D%26fp%3D%26fc%3D%26fn%3DCam%2520Clark%2520Ford%2520Canmore%26tg%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Daski%26pupm%3Dnone%26pupf%3Dsale%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D';
//     }

//     return $post_data;
// }

add_filter("filter_canmorecamclarkfordcom_field_images", "filter_canmorecamclarkfordcom_field_images",10,2);
function filter_canmorecamclarkfordcom_field_images($im_urls,$car_data) {
   $retval = array();
   // slecho(implode('|', $im_urls));

    $ignore = strtolower("https://www.canmorecamclarkford.com/vehicles/" . $car_data['year'] . '/' . $car_data['make'] . '/' . str_replace(" ", "-", $car_data['model']) . '/canmore/ab/');
   slecho($ignore);
   
   foreach ($im_urls as $im_url) {
       $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''], rawurldecode($im_url));
   }




   return $retval;
}
