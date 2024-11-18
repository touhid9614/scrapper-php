<?php
    global $scrapper_configs;

    $scrapper_configs['cyclespecialtiesperformance'] = array(
        'entry_points' => array(
            'new'       => 'http://www.cyclespecialtiesperformance.com/imglib/Inventory/cache/930/NVehInv.js?v=7926925',
            'used'      => 'http://www.cyclespecialtiesperformance.com/imglib/Inventory/cache/930/UVehInv.js?v=1097137'
        ),
        'vdp_url_regex'         => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/',
        'ajax_url_match'        => '/ajax/xxSubmitForm.asp',
        'required_params'       => array('page', 'id'),
        'use-proxy'             => true,
        'picture_selectors' => ['.camera_thumbs_cont ul li'],
        'picture_nexts'     => ['.camera_next'],
        'picture_prevs'     => ['.camera_prev'],
        'details_start_tag'     => 'var Vehicles=',
        'custom_data_capture'   => function($url, $data){
            $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
            $inventory     = json_decode($tdata);
            //$objects = json_decode($tdata);
            
            if(!$inventory) { slecho($tdata); }
            
            $to_return = array();
            
            foreach($inventory as $obj)
            {   
               
                $car_data = array(
                    'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                    'year'              => $obj->bike_year,
                    'make'              => $obj->manuf,
                    'model'             => $obj->model,
                    'body_style'        => $obj->catname,
                    'price'             => $obj->price,
                    'engine'            => $obj->engine,
                    'stock_type'        => $obj->type == 'U' ? 'used' : 'new',
                    'transmission'      => $obj->transmission,
                    'kilometres'        => $obj->miles,
                    'url'               => "http://www.cyclespecialtiesperformance.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                    'exterior_color'    => $obj->color,
                    'images'            => array()
                );
               
                                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"><img src="(?<img_url>[^"]+)"/',
        'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
    );
        
   add_filter("filter_cyclespecialtiesperformance_field_images", "filter_cyclespecialtiesperformance_field_images");
    
    function filter_cyclespecialtiesperformance_field_images($im_urls)
    {
        for($i = 0; $i < count($im_urls); $i++) {
            $im_urls[$i] = str_replace('300x225', '800x600', $im_urls[$i]);
        }
        
        return $im_urls;
    }
        