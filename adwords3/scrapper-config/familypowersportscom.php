<?php
global $scrapper_configs;
$scrapper_configs["familypowersportscom"] = array( 
	'entry_points' => array(
        'used'  => 'https://www.familypowersports.com/imglib/Inventory/cache/1069/UVehInv.js?v=5175047',
        'new'   => 'https://www.familypowersports.com/imglib/Inventory/cache/1069/NVehInv.js?v=9781202',  
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.photo'],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],

    'custom_data_capture' => function($url, $resp){
           $start_tag  = 'var Vehicles=';
           $end_tag    = '];';

           if(stripos($resp, $start_tag)) {
               $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
           }

           if(stripos($resp, $end_tag)) {
               $resp = substr($resp, 0, stripos($resp, $end_tag));
           }
           $resp=$resp . "]";

           $inventory     = json_decode($resp);

           $to_return = array();

           foreach($inventory as $obj)
           {
               if($obj->type == 'U')   
               {
                   $url="https://www.familypowersports.com/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.familypowersports.com/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => $obj->manuf,
                   'model'             => $obj->model,
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
                  // 'url'               => "http://www.familypowersportscom.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => !empty($obj->color)?$obj->color:"Other",
                   'engine'            => $obj->engine,
                   'vin'               => !empty($obj->vin)?$obj->vin:$obj->id,
                   'city'              => str_replace(" ","_",strtolower($obj->location)),

               );

               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    add_filter('filter_familypowersportscom_field_make', 'unicodify');
    add_filter('filter_familypowersportscom_field_model', 'unicodify');

    function familypowersportscom_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }