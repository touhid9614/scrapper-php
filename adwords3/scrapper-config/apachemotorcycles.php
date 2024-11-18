<?php
    global $scrapper_configs;

    $scrapper_configs['apachemotorcycles'] = array(
        'entry_points' => array(
            'new'       => 'http://www.weridepowersportsmesa.com/imglib/Inventory/shared-cache/4610/NVehInv.js?v=2967481',
            'used'      => 'http://www.weridepowersportsmesa.com/imglib/Inventory/shared-cache/4610/UVehInv.js?v=8093839'
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
                if($obj->makeid == 0) { continue; }
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
                    'url'               => "http://www.weridepowersportsmesa.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                    'exterior_color'    => $obj->color,
                    'images'            => array()
                );
               
                                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx' => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+" data-src="(?<img_url>[^"]+)"/',
        'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
    );
        