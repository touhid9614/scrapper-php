<?php
global $scrapper_configs;
$scrapper_configs["shopkingscrosshyundaica"] = array( 
	'entry_points' => array(
            'used'   => 'https://shop.kingscrosshyundai.ca/api/quickshop/inventory/?condition=Used&page=1',
            'new'   => 'https://shop.kingscrosshyundai.ca/api/quickshop/inventory/?condition=New&page=1',
            
        ),
        'use-proxy' => true,
        'vdp_url_regex'     => '/\/view\/(?:new|used)-[0-9]{4}-/i',
        
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
                    'url'               => "https://shop.kingscrosshyundai.ca/details/" . $obj->id,
                    'exterior_color'    => $obj->exterior_color,
                    'interior_color'    => $obj->interior_color,
                    'vin'               => $obj->vin,
                    'drivetrain'        => $obj->drivetrain,
                    'fuel_type'         => $obj->fuel_type,
                    'description'       => $obj->description,
                    //'all_images'        => $obj->image_url,
                );
                $details_url = "https://shop.kingscrosshyundai.ca/api/quickshop/inventory/{$obj->id}/";
                
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
        'next_page_regx' => '/"current":(?<next>[^\,]+)/',
       
    );

    add_filter("filter_shopkingscrosshyundaica_next_page", "filter_shopkingscrosshyundaica_next_page",10,2);
    add_filter("filter_shopkingscrosshyundaica_field_images", "filter_shopkingscrosshyundaica_field_images");
      
    function filter_shopkingscrosshyundaica_next_page($next,$current_page) {
           
           slecho($current_page);
           $next=explode('/',$next);
           $index=count($next)-1;
           $next=($next[$index]);
           $next++;
           if(strpos($current_page,"Used")){
               if($next<5){
                   $peg="page=" . $next;
                   $prev="page=" . ($next-1);
                   $url= str_replace($prev, $peg, $current_page);
                   return $url;
               }
           }
           elseif(strpos($current_page,"New")){
               if($next<16){
                   $peg="page=" . $next;
                   $prev="page=" . ($next-1);
                   $url= str_replace($prev, $peg, $current_page);
                   return $url;
               }
           }
           
           
            return null;
           
   }
