<?php

    global $scrapper_configs;

    $scrapper_configs['destinationpowersports'] = [
        'entry_points' => array(
            'new'  => 'https://www.destinationpowersports.com/imglib/Inventory/cache/4622/NVehInv.js?v=5207731',
            'used' => 'https://www.destinationpowersports.com/imglib/Inventory/cache/4622/UVehInv.js?v=7058378',
        ),
        'vdp_url_regex'         => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
        'required_params'   => array('page','id'),
        'use-proxy' => true,

        'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag'     => 'var Vehicles=',
            'custom_data_capture'   => function($url, $data){
                $tdata = trim(substr($data, strlen('var Vehicles=')), ';');
                $objects = json_decode($tdata);

                if(!$objects) { slecho($tdata); }

                $to_return = array();

                foreach($objects as $obj)
                {
                    if($obj->type == 'U')   
                    {
                        $url="https://www.destinationpowersports.com/default.asp?page=xPreOwnedInventoryDetail";
                    }
                    else 
                    {
                        $url="https://www.destinationpowersports.com/default.asp?page=xNewInventoryDetail";
                    }
                    $car_data = array(
                        'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                        'year'              => $obj->bike_year,
                        'make'              => $obj->manuf,
                        'model'             => $obj->model,
                        'body_style'        => $obj->catname,
                        'price'             => $obj->price,
                        'engine'            => $obj->engine,
                        'transmission'      => $obj->transmission,
                        'kilometres'        => $obj->miles,
                        'url'               => $url."&id=".$obj->id,
                        'exterior_color'    => $obj->color,
                        'images'            => array()
                    );

                    if($obj->bike_image)
                    {
                        $iu = $obj->bike_image;

                        if(startsWith($iu, '/')) {
                            $car_data['images'][] = "http://cdn.dealerspike.com{$iu}";
                        }else {
                            $p1 = substr($iu, 0, 2);
                            $p2 = substr($iu, 2, 2);
                            $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                        }
                    }
                    elseif($obj->stock_image)
                    {
                        $iu = $obj->stock_image;

                        if(startsWith($iu, '/')) {
                            $car_data['images'][] = "http://cdn.dealerspike.com{$iu}";
                        }else {
                            $p1 = substr($iu, 0, 2);
                            $p2 = substr($iu, 2, 2);
                            $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                        }
                    }

                    if($obj->image2)
                    {
                        $iu = $obj->stock_image;

                        if(startsWith($iu, '/')) {
                            $car_data['images'][] = "http://cdn.dealerspike.com{$iu}";
                        }else {
                            $p1 = substr($iu, 0, 2);
                            $p2 = substr($iu, 2, 2);
                            $car_data['images'][] = "http://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                        }
                    }

                    $car_data['all_images'] = implode('|', $car_data['images']);

                    $to_return[] = $car_data;
                }

                return $to_return;
            },
         'images_regx'            => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+" data-src="(?<img_url>[^"]+)"/',
         'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
    ];
