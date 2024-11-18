<?php
global $scrapper_configs;
 $scrapper_configs["suntanmarine"] = array( 
    'entry_points' => array(
        'all' => array(
             //'https://www.suntanmarine.ca/--inventory?pg=3',
             // 'https://www.suntanmarine.ca/--inventory',
             //  'https://www.suntanmarine.ca/--inventory?pg=2',
        ),
        // 'rvs' => 'https://www.suntanmarine.ca/--inventory?category=motorhome&category=trailer&condition=new&pg=1&sortby=Year%7Casc&sz=50',
        //https://smedia-hq.slack.com/archives/C018KT2BQEB/p1679071835087239
        'pinecraft' => 'https://www.suntanmarine.ca/--inventory?brand=princecraft&condition=new&condition=pre-owned&pg=1&sortby=Year%7Casc&sz=50',
        'rvs' => 'https://www.suntanmarine.ca/--inventory?condition=new&condition=pre-owned&pg=1&subcategory=fifth%20wheel&subcategory=travel%20trailer&sortby=Year%7Casc&sz=50',
        'pon' => 'https://www.suntanmarine.ca/default.asp?page=xallinventory&customSearch=new%20pontoon&layout=grid&sz=50',
        //https://app.guidecx.com/app/projects/c2895c56-34be-48ce-bc45-f32bcded9a99/notes
        //we have to scrappe pinecraft inventory  
        
    ),
    'vdp_url_regex' => '/\/[A-z]+-Inventory/i',
     'srp_page_regex'         => '/inventory\?condition/i',
    
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.lS-image-wrapper'],
    'picture_nexts' => ['.lSNext'],
    'picture_prevs' => ['.lSPrev'],
    'details_start_tag' => 'class="header-container">',
    // 'details_end_tag' => 'End of results with your search filters',
    'details_spliter' => 'v7list-results__item',
    'data_capture_regx' => array(
        'stock_type' => '/data-unit-condition="(?<stock_type>[^"]+)/',
        // 'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'url'   => '/"vehicle__image b-lazy" href="(?<url>[^"]+)/',
        'year' => '/data-unit-year="(?<year>[^"]+)/',
        'make' => '/data-unit-make="(?<make>[^"]+)/',
        'model' => '/data-unit-model="(?<model>[^"]+)/',
        'body_style' => '/data-unit-category="(?<body_style>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_type'    => '/Condition[^>]+>[^>]+>(?<stock_type>[^<]+)/',
        'price' => '/class="price-value ">[^>]+>[^>]+>(?<price>[^<]+)/',
        'stock_number'           => '/Stock Number[^>]+>[^>]+>(?<stock_number>[^<]+)/',
    ),
    // 'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/="og:image" content="(?<img_url>[^"]+)/',
);
 
 
add_filter('filter_for_fb_suntanmarine', 'filter_for_fb_suntanmarine', 10, 2);

function filter_for_fb_suntanmarine($car_data, $feed_type)
{
    

    // apply condition for other feeds inside this condition
    if ($feed_type=="tiktok") {
        //echo "ddddddd";
        $car_data['trim']     = "inquire for special cost pricing";
       
        return $car_data;
    }


    return $car_data;
}

 
add_filter('filter_suntanmarine_car_data', 'filter_suntanmarine_car_data');
function filter_suntanmarine_car_data($car_data) {
   
    if($car_data['stock_type']=='Pre-owned'){
        $car_data['stock_type']='cpo';
    }
    else if($car_data['stock_type'] == "New"){
        $car_data['stock_type']='new';
    }
    else if($car_data['stock_type'] == "Used"){
        $car_data['stock_type']='used';
    }

    //custom1 is Pinecraft, & custom 0 is for RVs. we need different feeds. 
    if(strcmp($car_data['make'],"Princecraft") == 0){
        $car_data['custom'] = 1;
    }
    else{
        $car_data['custom'] = 0;
    }

    if($car_data['stock_number'] == "MR1146" || $car_data['stock_number'] == "MR1107" || $car_data['stock_number'] == "MP1110A" || $car_data['stock_number'] == "MP1116A" || $car_data['stock_number'] == "MP1050A"){
        $car_data = [];
    }

    return $car_data;
}

// 	  'entry_points' => array(
//                'used_rv'   => 'https://www.suntanmarine.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
//             'used_boats'  => 'https://www.suntanmarine.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
//             'new_rv'   => 'https://www.suntanmarine.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
//             'new_boats'  => 'https://www.suntanmarine.ca/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php',
           
//         ),
//         'vdp_url_regex'         => '/\/vehicles\/[0-9]{4}\//',
//         'ajax_url_match'        => '/libs/formProcessor.html',
//         'use-proxy'         => true,
//         'refine'            => false,
//         'init_method'       => 'POST',
//         'next_method'       => 'POST',
//         'picture_selectors' => ['.thumbnails__single'],
//         'picture_nexts'     => ['button.modal-slideshow__next'],
//         'picture_prevs'     => ['button.modal-slideshow__prev'],
//         'custom_data_capture'   => function($url, $data){
                
//         $objects = json_decode($data);

                
//         if(!$objects) { slecho($data); return array(); }

                
//         $to_return = array();

                
//         foreach($objects->results as $obj)
//         {
            

//              $car_data = array(
//                 'stock_number'      => $obj->stock_number?$obj->stock_number:$obj->vehicle_id,
//                 'stock_type'        => strtolower($obj->sale_class),
//                 'year'              => $obj->year,
//                 'make'              => $obj->make,
//                 'model'             => $obj->model,
//                 'trim'              => $obj->trim,
//                 'body_style'        => $obj->body_style,
//                 'price'             => $obj->final_price,
//                 'engine'            => $obj->engine,
//                 'transmission'      => $obj->transmission,
//                 'kilometres'        => $obj->odometer,
//                 'vin'               => $obj->vin,
//                 'fuel_type'         => $obj->fuel_type,
//                 'drivetrain'        => $obj->drive_train,
//                 'msrp'              => $obj->msrp,
//                 'url'               => "https://www.suntanmarine.ca/vehicles/" . strtolower($obj->year) .
//                                        '/' . strtolower($obj->make) . '/' . strtolower($obj->model) . '/listowel/on/' . strtolower($obj->ad_id),
//                 'exterior_color'    => $obj->vehicle_class_lvl2,
//                 'interior_color'    => $obj->interior_color,
//                 'all_images'        => $obj->image->image_original,
//                 'title'             => $obj->year .' '. $obj->make . ' ' . $obj->model,
//             );
             
             
              
//        $response_data = HttpGet($car_data['url']);
//        $regex       =  '/","description":"(?<description>[^"]+)/';
        
//         $matches = [];
       
        
//         if(preg_match($regex, $response_data, $matches)) {
           
//             $car_data['description']=$matches['description'];
            
//              //return  $im_urls;
            
//         }      

            

//             $to_return[] = $car_data;
//         }

//         return $to_return;
//     },
//             'data_capture_regx_full' => array(
//                 'description'   => '/","description":"(?<description>[^"]+)/',
//     ),
//    'images_regx'       => '/image_lg":"(?<img_url>[^"]+)/',
// );
    
// add_filter('filter_suntanmarine_post_data', 'filter_suntanmarine_post_data', 10, 2);
// add_filter("filter_suntanmarine_field_images", "filter_suntanmarine_field_images",10,2);

// function filter_suntanmarine_post_data($post_data, $stock_type)
// {
//     if($stock_type == 'new_rv')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2254%26ln%3Den%26pg%3D1%26pc%3D51%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DRV%26st%3D';
//     }
//     elseif($stock_type == 'new_boats')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2254%26ln%3Den%26pg%3D1%26pc%3D28%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3DBoats%26st%3D';
//     }
//     elseif($stock_type == 'used_rv')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2254%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DRV%26st%3D';
//     }
//     elseif($stock_type == 'used_boats')
//     {
//         $post_data = 'action=vms_data&endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2254%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3DBoats%26st%3D';
//     }

//     return $post_data;
// }

// function filter_suntanmarine_field_images($im_urls,$car_data) {
//     $retval = array();
//     // slecho(implode('|', $im_urls));
    
// $ignore="https://www.suntanmarine.ca/vehicles/" . strtolower($car_data['year']) .  "/" . strtolower($car_data['make']) . "/" . strtolower($car_data['model']) . "/" . "listowel/on/";
   
// slecho($ignore);
         
//   foreach ($im_urls as $im_url) {
//         $retval[] = str_replace([$ignore, '-1024x786','\\'], ['', '',''], rawurldecode($im_url));
//         }
     


       
//     return $retval;
// }

