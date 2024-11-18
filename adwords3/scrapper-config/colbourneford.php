<?php
global $scrapper_configs;
 $scrapper_configs["colbourneford"] = array( 
	 "entry_points" => array(
       'new'  => 'https://www.colbourneford.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2794%26ln%3Den%26pg%3D1%26pc%3D150%26dc%3Dtrue%26qs%3D%26im%3D%26svs%3Dtrue%26sc%3Dnew%26v1%3D%26st%3Ddays_on_lot%252Cdesc%26ai%3Dtrue%26oem%3DFord%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26defaultParams%3D%26downpayment%3D0%26pmnt_frequency%3D26%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte-inc%26pupi%3Dinte%26pupm%3Dnone%26pupf%3Dnone%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        'used' => 'https://www.colbourneford.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2794%26ln%3Den%26pg%3D1%26pc%3D150%26dc%3Dtrue%26qs%3D%26im%3D%26svs%3Dtrue%26sc%3Dused%26v1%3D%26st%3Ddays_on_lot%252Cdesc%26ai%3Dtrue%26oem%3DFord%26dp%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26defaultParams%3D%26downpayment%3D0%26pmnt_frequency%3D26%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte-inc%26pupi%3Dinte%26pupm%3Dnone%26pupf%3Dnone%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match'      => '/libs/formProcessor.html',
    'use-proxy'           => true,
    'refine'              => false,

    'init_method'         => 'GET',
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
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'body_style'     => $obj->body_style,
                'price'          => $obj->final_price,
                'engine'         => $obj->engine,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fuel_type,
                'drivetrain'     => $obj->drive_train,
                'msrp'           => $obj->msrp,
                'url'            => str_replace("\/\/", "//", $obj->vdp_url),
                //'url'            => "https://www.colbourneford.ca/vehicles/" . strtolower($obj->year) . '/' . strtolower($obj->make) . '/' . strtolower(str_replace(" ", "-", trim($obj->model))) . '/kelowna/bc/' . strtolower($obj->ad_id),
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

  
);