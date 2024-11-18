<?php
global $scrapper_configs;
$scrapper_configs["woodbinetoyotaca"] = array( 
	'entry_points' => array(
            'used'   => 'https://shop.woodbinetoyota.ca/api/quickshop/inventory/?condition=Used&page=1',
            'new'    => array(
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Corolla',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=RAV4',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Highlander',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Camry',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=C-HR',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Venza',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Corolla%20Hatchback',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=4Runner',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Avalon',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Camry%20Hybrid',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Corolla%20Hybrid',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=GR%20Supra',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Highlander%20Hybrid',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Prius',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Prius%20Prime',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=RAV4%20Hybrid',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=RAV4%20Prime',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Sequoia',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Sienna',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Sequoia',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Tacoma',
                'https://shop.woodbinetoyota.ca/api/quickshop/inventory/trims/?condition=New&page=1&model=Tundra',
                
                
                
                ),
            
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/ca\/details\//i',
        
        'custom_data_capture' => function($url, $data){
            $objects = json_decode($data);
            
            $to_return = array();
            
            foreach($objects->results as $obj)
            {
                
                $car_data = array(
                    'stock_number'      => $obj->stock_number,
                    'year'              => $obj->year,
                    'make'              => $obj->make,
                    'model'             => $obj->model,
                    'trim'              => $obj->trim,
                    'body_style'        => $obj->body_type,
                    'price'             => $obj->cash_payment->amount,
                    'engine'            => $obj->vehicle_details->engine_description,
                    'transmission'      => $obj->vehicle_details->transmission,
                    'kilometres'        => $obj->odometer,
                    'url'               => "https://shop.woodbinetoyota.ca/details/" . $obj->id,
                    'exterior_color'    => $obj->exterior_color,
                    'interior_color'    => $obj->interior_color,
                    'vin'               => $obj->vin,
                    'drivetrain'        => $obj->drivetrain,
                    'fuel_type'         => $obj->fuel_type,
                    'description'       => $obj->description,
                    
                );
                $details_url = "https://shop.woodbinetoyota.ca/api/quickshop/inventory/{$obj->id}/";
                
                slecho("Details Data URL: $details_url");
                
                $details_data = HttpGet($details_url);
                $all_imgs=[];
                if($details_data) {
                    $details_obj = json_decode($details_data);
                    $im=$details_obj->main_image->image_url;
                    slecho("main image: $im ");
                    foreach($details_obj->images as $obj){
                        $all_imgs[]=$obj->image_url;
                    }
                    $car_data['all_images']=implode('|', $all_imgs);
                }
                else {
                    slecho('Error: Unable to load details data');
                }
                
                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'next_page_regx' => '/"last":(?<next>[^\,]+)/',
       
    );

    add_filter("filter_woodbinetoyotaca_next_page", "filter_woodbinetoyotaca_next_page",10,2);
    add_filter("filter_woodbinetoyotaca_field_images", "filter_woodbinetoyotaca_field_images");
      
    function filter_woodbinetoyotaca_next_page($next,$current_page) {
           
           $last=explode('/',$next);
           $index=count($last)-1;
           $last=($last[$index]);
           
           $current=explode('page=',$current_page);
           $index=count($current)-1;
           $current=($current[$index]);
           
           
           if($current<$last){
           $next=++$current;
           
           $peg="page=" . $next;
                   $prev="page=" . ($next-1);
                   $url= str_replace($prev, $peg, $current_page);
                   return $url;
           }
           
           
            return null;
           
   }
