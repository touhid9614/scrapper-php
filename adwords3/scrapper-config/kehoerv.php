<?php
global $scrapper_configs;
 $scrapper_configs["kehoerv"] = array( 
	 'entry_points' => array(
        'new'   => 'https://www.kehoerv.com/imglib/Inventory/cache/1492/VehInv.js?v=6661360',
        'used'  => 'https://www.kehoerv.com/imglib/Inventory/cache/1492/UVehInv.js?v=3227171',
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['#invUnitSliderTray .item > ul > li'],
    'picture_nexts'     => ['.right.next.carousel-control'],
    'picture_prevs'     => ['.left.prev.carousel-control'],

    'custom_data_capture' => function($url, $resp){
           $start_tag  = 'var Vehicles=';
           $end_tag    = ';';

           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }

           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory as $obj)
           {    
               if ($obj->imageOverlayText === 'Sold') { continue; }
               if($obj->type == 'U')   
               {
                   $url="https://www.kehoerv.com/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.kehoerv.com/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                 
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => unicodify($obj->manuf),
                   'model'             => unicodify($obj->model),
                   'body_style'        => $obj->catname,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => $obj->price,
                  
                  // 'url'               => "http://www.kehoerv.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url.'&id='.$obj->id,
                 
                  

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    add_filter('filter_kehoerv_field_make', 'unicodify');
    add_filter('filter_kehoerv_field_model', 'unicodify');

    function kehoerv_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }

