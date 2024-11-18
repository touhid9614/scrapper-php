<?php
global $scrapper_configs;
$scrapper_configs["jamesbradenfordca"] = array( 
	 'entry_points' => array(
            'all'   => 'https://jamesbradenford.ca/wp-admin/admin-ajax.php',
            //'used'  => 'https://jamesbradenford.ca/wp-admin/admin-ajax.php',
         ),
        'vdp_url_regex'         => '/\/view\/(?:new|used)-/',
        'ajax_url_match'        => '/libs/formProcessor.html',
        'use-proxy'             => true,
        'content_type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        'init_method' => 'POST',
        'next_method' => 'POST',
        'picture_selectors' => ['.detail-feature-thumb'],
        'picture_nexts'     => ['.lb-next'],
        'picture_prevs'     => ['.lb-prev'],
        'custom_data_capture'   => function($url, $resp){
            
            $resp= str_replace("\\", "", $resp);
            
            $start_tag  = 'true,"data":"';
            $end_tag    = ']"}';
            
           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }
            $resp=$resp . "]";
            $resp=preg_replace('/"metadata":"{[^\]]+\][^\}]+\}\}"\,/', "", $resp);
            $resp=preg_replace('/"description":"[^"]+"[^"]+"\,"/', "", $resp);
            $resp=preg_replace('/\{"id":589260,.*(?=\{"id":598042)/', "", $resp);
            $objects = json_decode($resp);
            
            if(!$objects) { slecho($resp); return array(); }
            
            $to_return = array();
            
            foreach($objects as $obj)
            {
                $car_data = array(
                    'stock_number'      => $obj->stocknumber?$obj->stocknumber:$obj->id,
                    'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->bodystyle,
                    'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->mileage,
                    'url'               => "https://www.jamesbradenford.ca/view/" . strtolower($obj->condition) .
                                           '-' . strtolower($obj->year) . '-' . strtolower($obj->make) . '-' . strtolower($obj->model) . 
                                           '-' . strtolower($obj->id) . '/',
                    'exterior_color'    => $obj->exteriorcolor,
                    'certified'         => $obj->certified?1:0,
                    'images'            => $obj->picture
                );
                $retval=[];
                $imgs=explode(",",$obj->picturesids);
                foreach ($imgs as $img_url){
                    $retval[]="https://car-dealer-media.azurewebsites.net/pictures/show/1107/169/" . $img_url . "-XXL";
                }
                $car_data['all_images']=implode("|",$retval);
                
             
                $to_return[] = $car_data;
            }
            
            return $to_return;
        }
    );
    
    add_filter('filter_jamesbradenfordca_post_data', 'filter_jamesbradenfordca_post_data', 10, 2);

function filter_jamesbradenfordca_post_data($post_data, $stock_type) {
    
    
    if ($stock_type == 'used') {
        $post_data = "params%5Byear%5D=all&params%5Bmake%5D=all&params%5Bmodel%5D=all&params%5Btrim%5D=all&params%5Bprice%5D=all&params%5Bmileage%5D=all&params%5Btype%5D=all&params%5Bstatus%5D=New&params%5Btags%5D=all&params%5Bstock%5D=all&params%5Bfilter%5D=true&params%5Blimit%5D=0&params%5Bsort_by%5D=year&params%5Bsort_by_condition%5D=desc&params%5Bflags%5D=none&params%5Blayout%5D=normal&params%5Bvehicle_card%5D=&action=get_leadbox_inventory_from_child";
    }
    else{
        $post_data = "params%5Byear%5D=all&params%5Bmake%5D=all&params%5Bmodel%5D=all&params%5Btrim%5D=all&params%5Bprice%5D=all&params%5Bmileage%5D=all&params%5Btype%5D=all&params%5Bstatus%5D=New&params%5Btags%5D=all&params%5Bstock%5D=all&params%5Bfilter%5D=true&params%5Blimit%5D=0&params%5Bsort_by%5D=year&params%5Bsort_by_condition%5D=desc&params%5Bflags%5D=none&params%5Blayout%5D=normal&params%5Bvehicle_card%5D=&action=get_leadbox_inventory_from_child";
    }

    return $post_data;
}
