<?php
global $scrapper_configs;
 $scrapper_configs["trunorthprincealbert"] = array( 
	  'entry_points' => array(
        'new' => 'https://www.trunorthprincealbert.ca/imglib/Inventory/cache/608/NVehInv.js?v=4678465',
        'used' => 'https://www.trunorthprincealbert.ca/imglib/Inventory/cache/608/UVehInv.js?v=4022444',
    ),
    'vdp_url_regex' => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
   'required_params' => array('page', 'id'),
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.vehicle-thumb'],
    'picture_nexts' => ['.right.next'],
    'picture_prevs' => ['.left.prev'],
     'details_start_tag'     => 'var Vehicles=',
    'custom_data_capture' => function($url, $resp) {
        $tdata = trim(substr($resp, strlen('var Vehicles=')), ';');
        $inventory = json_decode($tdata);
        if(!$inventory) { slecho($tdata); }
        $to_return = array();

        foreach ($inventory as $obj) {
            if ($obj->type == 'U') {
                $url = "https://www.trunorthprincealbert.ca/default.asp?page=xPreOwnedInventoryDetail";
            } else {
                $url = "https://www.trunorthprincealbert.ca/default.asp?page=xNewInventoryDetail";
            }
            $car_data = array(
                'transmission'  => $obj->transmission,
                'stock_number'  => !empty($obj->stockno) ? $obj->stockno : $obj->id,
                'year'          => $obj->bike_year,
                'make'          => $obj->manuf, 
                'model'         => $obj->model,  
                'body_style'    => $obj->vehtypename,
                'stock_type'    => $obj->type == 'U' ? 'used' : 'new',
                'price'         => !empty($obj->price) ? $obj->price : (!empty($obj->retail_price) ? $obj->retail_price :(!empty($obj->MSRP)) ? $obj->MSRP :'Call for Price'),
                'kilometres'    => isset($obj->miles) ? $obj->miles : '',
                'url'           => $url . '&id=' . $obj->id,
                'exterior_color'=> $obj->color,
                'engine'        => $obj->engine,
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/(?:unitSliderImg">[^\(]+\(|<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src=")(?<img_url>[^(?\)|")]+)/',
    'images_fallback_regx' => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
 