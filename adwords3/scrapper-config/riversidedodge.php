<?php

global $scrapper_configs;

$scrapper_configs['riversidedodge'] = array(
    'entry_points' => array(
          'used' => 'https://www.riversidedodge.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
        'new' => 'https://www.riversidedodge.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
       
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
                'price' => $obj->final_price,
                'engine' => $obj->engine,
                'transmission' => $obj->transmission,
                'kilometres' => $obj->odometer,
                'vin' => $obj->vin,
               // 'fuel_type' => $obj->fuel_type,
               // 'drivetrain' => $obj->drive_train,
             //   'msrp' => $obj->msrp,
                'url' => "https://www.riversidedodge.ca/vehicles/" . strtolower($obj->year) .
                '/'   . strtolower(explode(" ",$obj->make)[0])  . '-'.strtolower(explode(" ",$obj->make)[1]). '/' . strtolower(explode(" ",$obj->model)[0])  . '-'.strtolower(explode(" ",$obj->model)[1]).  '/prince-albert/sk/' . strtolower($obj->ad_id),
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

add_filter('filter_riversidedodge_post_data', 'filter_riversidedodge_post_data', 10, 2);

function filter_riversidedodge_post_data($post_data, $stock_type) {

    if ($stock_type == 'new') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2540%26ln%3Den%26pg%3D1%26pc%3D200%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D';
    } elseif ($stock_type == 'used') {
        $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2540%26ln%3Den%26pg%3D1%26pc%3D80%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26sc%3Dused%26v1%3D%26st%3D%26ai%3Dtrue%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D';
    }

    return $post_data;
}



add_filter("filter_riversidedodge_field_images", "filter_riversidedodge_field_images", 10, 2);
function filter_riversidedodge_field_images($im_urls, $car_data)
{
    $retval = array();
  

   $ignore="https://www.riversidedodge.ca/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower(explode(" ",$car_data['make'])[0])  . '-'.strtolower(explode(" ",$car_data['make'])[1]) . "/" . strtolower(explode(" ",$car_data['model'])[0])  . '-'.strtolower(explode(" ",$car_data['model'])[1]) .  "/" . "prince-albert/sk/";
   
slecho("ignore this:" . $ignore);
         
   foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''],$im_url);
        }
     


       
    return $retval;
}