<?php
global $scrapper_configs;

$scrapper_configs['winnipegautogroup'] = array(
  
     'entry_points'        => array(
         'used' => 'https://www.winnipegautogroup.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D502%26ln%3Den%26pg%3D1%26pc%3D200%26dc%3Dtrue%26qs%3D%26im%3D%26svs%3D%26sc%3D%26v1%3Dall%26st%3Dmake%252Casc%26ai%3Dtrue%26oem%3D%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dreta%26pnpm%3Daski%26pnpf%3Dinvo%26pupi%3Dreta%26pupm%3Daski%26pupf%3Dinvo%26nnpi%3Dreta%26nnpm%3Daski%26nnpf%3Dinvo%26nupi%3Dreta%26nupm%3Daski%26nupf%3Dinvo%26po%3D&action=vms_data',
     ),
     'vdp_url_regex'       => '/\/[0-9]{4}\//',
     'srp_page_regex'      => '/\/vehicles\//',
     'ajax_url_match'      => '/libs/formProcessor.html/',
     'use-proxy'           => true,
     'refine'              => false,
     'init_method'         => 'POST',
     'next_method'         => 'POST',
     'picture_selectors'   => ['.thumbnails__single'],
     'picture_nexts'       => ['button.modal-slideshow__next'],
     'picture_prevs'       => ['button.modal-slideshow__prev'],
     'custom_data_capture' => function ($url, $data) {
         $objects = json_decode($data);

         if (!$objects) {
             slecho($data);
             return [];
         }

         $to_return = [];

         foreach ($objects->results as $obj) {
             $car_data = array(
                 'stock_number'   => $obj->stock_number ? $obj->stock_number : $obj->vehicle_id,
                 'stock_type'     => strtolower($obj->sale_class),
                 'year'           => $obj->year,
                 'make'           => str_replace('&', 'and', $obj->make),
                 'model'          => str_replace('&', 'and', $obj->model),
                // 'trim'           => $obj->trim,
                 'body_style'     => $obj->body_style,
                 'price'          => $obj->lowest_price,
                 'engine'         => $obj->engine,
                 'transmission'   => $obj->transmission,
                 'kilometres'     => $obj->odometer,
                 'vin'            => $obj->vin,
                 'fuel_type'      => $obj->fuel_type,
                 'drivetrain'     => $obj->drive_train,
                 'msrp'           => $obj->msrp,
                 'url'            => strtolower("https://www.winnipegautogroup.com/vehicles/" . $obj->year . '/' . $obj->make . '/' . str_replace(" ", "-", $obj->model) . '/headingley/mb/' . $obj->ad_id),
                 'exterior_color' => $obj->exterior_color,
                 'interior_color' => $obj->interior_color,
                 'all_images'     => $obj->image->image_original,
                 'title'          => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
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
     'images_regx'         => '/image_md":"(?<img_url>[^"]+)/',
 );

 add_filter('filter_winnipegautogroup_post_data', 'filter_winnipegautogroup_post_data', 10, 2);
 

 function filter_winnipegautogroup_post_data($post_data, $stock_type)
 {
     if ($stock_type == 'used') {
         $post_data = 'endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D502%26ln%3Den%26pg%3D1%26pc%3D200%26dc%3Dtrue%26qs%3D%26im%3D%26svs%3D%26sc%3D%26v1%3Dall%26st%3Dmake%252Casc%26ai%3Dtrue%26oem%3D%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dreta%26pnpm%3Daski%26pnpf%3Dinvo%26pupi%3Dreta%26pupm%3Daski%26pupf%3Dinvo%26nnpi%3Dreta%26nnpm%3Daski%26nnpf%3Dinvo%26nupi%3Dreta%26nupm%3Daski%26nupf%3Dinvo%26po%3D&action=vms_data';
     }

     return $post_data;
 }
