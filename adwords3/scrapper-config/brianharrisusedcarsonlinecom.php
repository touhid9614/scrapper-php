<?php
global $scrapper_configs;
$scrapper_configs["brianharrisusedcarsonlinecom"] = array( 
	"entry_points" => array(
        'used' => 'https://www.brianharrisusedcarsonline.com/inv-scripts/inv/12569352/vehicles?vc=a&f=id%7csn%7cye%7cma%7cmo%7ctr%7cdt%7cta%7ctd%7cen%7cmi%7cdr%7cec%7cic%7cbt%7cpr%7cde%7cim%7ceq%7cvd%7cvin%7chpg%7ccpg%7cvc%7cco%7chi%7ccfx%7cacr%7cvt%7ccy%7cdi%7cft%7clo%7ccfk%7cdc%7csi&ps=15&pn=0&sb=ma%7ca&sp=n&cb=dws_inventory_listing_1&vsi=0%7c1&h=226e2c4787c1a82d07adfebbf8d3d98b'
        ),
    'vdp_url_regex' => '/\/inventory\/[a-z]{1,20}\//',
    'use-proxy' => false,
    'refine' => false,
//    'init_method' => 'POST',
//    'next_method' => 'POST',
    'picture_selectors' => ['.lslide'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'content_type' => 'application/json',
    'custom_data_capture' => function($url, $resp) {
        $start_tag  = '"Vehicles":';
            $end_tag    = '});';

            if(stripos($resp, $start_tag)) {
                $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
            }

            if(stripos($resp, $end_tag)) {
                $resp = substr($resp, 0, stripos($resp, $end_tag));
            }
        $objects = json_decode($resp);


        if (!$objects) {
            slecho($resp);
            return array();
        }


        $to_return = array();



        foreach ($objects as $obj) {
            

            $car_data = array(
                'stock_number' => $obj->StockNumber,
                'stock_type'   => "used",
                'year'         => $obj->Year,
                'make'         => $obj->Make,
                'model'        => $obj->Model,
                'trim'         => $obj->Trim,
                'body_style'   => $obj->BodyType,
                'price'        => $obj->VehiclePrice,
                'engine'       => $obj->Engine,
                'transmission' => $obj->Transmission,
                'kilometres'   => $obj->Odometer,
                'vin'          => $obj->Vin,
                'fuel_type'    => $obj->FuelType,
                'drivetrain'   => $obj->Drivetrain,
                'url'          => "https://www.brianharrisusedcarsonline.com/inventory/" . strtolower($obj->Make) . '/'. strtolower($obj->Model) . '/'. strtolower($obj->StockNumber) . '/',
                'exterior_color' => $obj->ExteriorColor,
                'interior_color' => $obj->InteriorColor,
            );
            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/data-base-img-url="(?<img_url>[^"]+)/',

);
//
//
//add_filter('filter_brianharrisusedcarsonlinecom_post_data', 'filter_brianharrisusedcarsonlinecom_post_data', 10, 2);
//
//function filter_brianharrisusedcarsonlinecom_post_data($post_data, $stock_type) {
//    if ($stock_type == 'used') {
//    $post_data = 'vc=a&f=id%7csn%7cye%7cma%7cmo%7ctr%7cdt%7cta%7ctd%7cen%7cmi%7cdr%7cec%7cic%7cbt%7cpr%7cde%7cim%7ceq%7cvd%7cvin%7chpg%7ccpg%7cvc%7cco%7chi%7ccfx%7cacr%7cvt%7ccy%7cdi%7cft%7clo%7ccfk%7cdc%7csi&ps=15&pn=0&sb=ma%7ca&sp=n&cb=dws_inventory_listing_1&vsi=0%7c1&h=226e2c4787c1a82d07adfebbf8d3d98b';}
//    
//
//    return $post_data;
//}

