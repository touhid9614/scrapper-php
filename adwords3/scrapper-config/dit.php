<?php
global $scrapper_configs;
 $scrapper_configs["dit"] = array( 
	 'entry_points' => array(
     
         'new'   => array(
            'https://www.dit.ca/imglib/Inventory/cache/5960/NVehInv.js?v=8053602',
            'https://www.dit.ca/imglib/Inventory/cache/5960/NVehInv.js?v=1594190',
            'https://www.dit.ca/imglib/Inventory/cache/5960/NVehInv.js?v=3265760',
            
        ), 
        'used'   => array(
            'https://www.dit.ca/imglib/Inventory/cache/5960/UVehInv.js?v=8896391',
            'https://www.dit.ca/imglib/Inventory/cache/5960/UVehInv.js?v=2907331',
            'https://www.dit.ca/imglib/Inventory/cache/5960/UVehInv.js?v=7431226',
            
        ), 
       
       
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.vehicle-thumb'],
    'picture_nexts'     => ['.right.next'],
    'picture_prevs'     => ['.left.prev'],


    'custom_data_capture' => function($url, $resp){
           $start_tag  = 'var Vehicles=';
           $end_tag    = '];';

           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }
           $resp=$resp . ']';
           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory as $obj)
           {
               if($obj->type == 'U')   
               {
                   $url="https://www.dit.ca/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.dit.ca/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => unicodify($obj->manuf),
                   'model'             => unicodify($obj->model),
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',     
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => $obj->color,
                   'engine'            => $obj->engine,

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);



