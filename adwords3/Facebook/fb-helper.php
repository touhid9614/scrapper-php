<?php

function get_suitable_cars($cars, $cron_config) {
    
    $retval = [];
    
    foreach($cars as $stock_number => $car):
        $stock_number = trim($stock_number);
        if((!$car['deleted'])):
            $car = apply_filters("filter_for_fb_$cron_name", $car);
        
            if(!$car) { continue; }
            
            if(!count($car['images'])) { continue; }
            
            $stock_type = $car['stock_type'];
            $actual_stock_type = $stock_type == 'device'?'new':($stock_type=='accessory'?'new':($stock_type=='new'?'new':'used'));

            if($actual_stock_type != 'new' && $actual_stock_type != 'used') { continue; }
            
            $min_images = isset($cron_config['banner']['min_images'])?$cron_config['banner']['min_images'] : 1;

            if(count($car["images"]) < $min_images) { continue; }
            
            if(numarifyPrice($car['price']) < 0) { continue; }
            
            $car['actual_stock_type'] = $actual_stock_type;
            
            $retval[$stock_number] = $car;
            
        endif;
    endforeach;
    
    return $retval;
}

function standard_delay() {
    sleep(10);
}