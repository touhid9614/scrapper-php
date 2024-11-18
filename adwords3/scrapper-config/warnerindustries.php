<?php
    global $scrapper_configs;

    $scrapper_configs['warnerindustries'] = array(
        'entry_points' => array(
            'new'       => 'https://www.warnerindustries.ca/imglib/Inventory/cache/3547/NVehInv.js?v=2458814',
            'used'      => 'https://www.warnerindustries.ca/imglib/Inventory/cache/3547/UVehInv.js?v=3298307'
        ),
        'vdp_url_regex'         => '/\/default.asp\?page=x(?:PreOwned|New)InventoryDetail/i',
        'ajax_url_match'        => '/ajax/xxSubmitForm.asp',
        'required_params'       => array('page', 'id'),
        'use-proxy'             => true,
        'picture_selectors' => ['body.InventoryDetail #invUnitSliderTray .item > ul > li','body.InventoryDetail #invUnitCarousel .item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag'     => 'var Vehicles=',
        'custom_data_capture'   => function($url, $data){
            $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
            $inventory     = json_decode($tdata);
            //$objects = json_decode($tdata);
            
            if(!$inventory) { slecho($tdata); }
            
            $to_return = array();
            
            foreach($inventory as $obj)
            {  
                if ($obj->type == 'U') {
                $url = "https://www.warnerindustries.ca/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.warnerindustries.ca/default.asp?page=xNewInventoryDetail";
            }
                $car_data = array(
                    'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                    'year'              => $obj->bike_year,
                    'make'              => $obj->manuf,
                    'model'             => $obj->model,
                    'body_style'        => $obj->catname,
                  //  'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'stock_type'        => $obj->type == "N" ? "new" : "used",
                    'transmission'      => $obj->transmission,
                   // 'kilometres'        => $obj->miles,
                    'price' => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price : 'Call for Price'),
                    'kilometres' => isset($obj->miles) ? $obj->miles : '',
                    'url' => $url . '&id=' . $obj->id, 
                    'exterior_color'    => $obj->color,
                    'images'            => array()
                );
                                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/data-src="(?<img_url>https:\/\/cdn.dealerspike.com\/imglib\/[^"]+)/'
    );
        
    add_filter('filter_warnerindustries_car_data', 'filter_warnerindustries_car_data');
    
    function filter_warnerindustries_car_data($car_data) {
        
        $ignored_catagory = [
            'Enclosed Cargo'
            ,'Enclosed Barn Door'
            ,'Car Trailer Closed'
            ,'Enclosed Ramp'
            ,'Snowmobile Trailer'
            ,'Snowmobile Trailer Closed'
            ,'Equipment and Auto'
            ,'Toy Hauler'
            ,'Dump'
            ,'Equipment Trailer'
            ,'Flatbed'
            ,'Utility'
            ,'Horse Trailer'
            ,'Dry Van'
            ,'Hopper / Grain'
            ,'Drop Deck'
            ,'Lowboy'
            ,'Tank'
            ];
        
            if (in_array($car_data['body_style'], $ignored_catagory)) 
            {
                slecho("ignoring categories...{$car_data['body_style']}");
                return [];
            }
        return $car_data;
    }
   
   