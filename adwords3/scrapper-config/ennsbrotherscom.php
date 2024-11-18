<?php
global $scrapper_configs;
$scrapper_configs["ennsbrotherscom"] = array( 
	 'entry_points' => array(
        'new'   => array(
            'https://www.ennsbrothers.com/imglib/Inventory/cache/4620/NVehInv.js?v=8025586',
            'https://www.ennsbrothers.com/imglib/Inventory/cache/4620/NVehInv.js?v=6859663',     
        ), 

        'used'  => 'https://www.ennsbrothers.com/imglib/Inventory/cache/4620/UVehInv.js?v=6996443',     
        
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'srp_page_regex'         => '/\/--x(?:New|PreOwned)Inventory/i',
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.vehicle-thumb '],
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
           
           $ignore_data=[
                    '851097A',
                    '012698A',
                    'E027820A',
                    '916151A',            
                    'E174948B',
                    'E174948C',
                    'E174948D',
                    '076776A',
                    '101709A',
                    '101701A',
                    '101703A',
                    '077406A',
                    '101701A',
                    '100593CX'
                ];

           foreach($inventory as $obj)
           {    
               if ($obj->imageOverlayText === 'Sold') { continue; }
               if($obj->type == 'U')   
               {
                   $url="https://www.ennsbrothers.com/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.ennsbrothers.com/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'vin'               => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => $obj->manuf,
                   'model'             => $obj->model,
                   'body_style'        => $obj->category,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
                     'url'               => $url.'&id='.$obj->id,
                  // 'exterior_color'    => $obj->vehtypename,
                  // 'exterior_color' => str_replace('&', 'and', $obj->vehtypename),
                   'engine'            => $obj->engine,
                   'custom'            =>  $obj->category,

               );
               
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                
                slecho("Excluding car that has  ,{$car['stock_number']}");
                continue;

            }

            $response_data = HttpGet($car_data['url']);
            $regex = '/Selling Price[^>]+>\s*[^>]+>(?<price>[^<]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['price'] = $matches['price'];
            }
            
            
                if($obj->bike_image)
                {
                    $iu = $obj->bike_image;
                    
                    if(startsWith($iu, '/')) {
                        $car_data['images'][] = "https://cdn.dealerspike.com{$iu}";
                    }else {
                        $p1 = substr($iu, 0, 2);
                        $p2 = substr($iu, 2, 2);
                        $car_data['images'][] = "https://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                    }
                }
                elseif($obj->stock_image)
                {
                    $iu = $obj->stock_image;
                    
                    if(startsWith($iu, '/')) {
                        $car_data['images'][] = "https://cdn.dealerspike.com{$iu}";
                    }else {
                        $p1 = substr($iu, 0, 2);
                        $p2 = substr($iu, 2, 2);
                        $car_data['images'][] = "https://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                    }
                }
                
                if($obj->image2)
                {
                    $iu = $obj->stock_image;
                    
                    if(startsWith($iu, '/')) {
                        $car_data['images'][] = "https://cdn.dealerspike.com{$iu}";
                    }else {
                        $p1 = substr($iu, 0, 2);
                        $p2 = substr($iu, 2, 2);
                        $car_data['images'][] = "https://cdn.dealerspike.com/imglib/v1/800x600/imglib/Assets/Inventory/{$p1}/{$p2}/{$iu}";
                    }
                }
                
               $car_data['all_images'] = implode('|', $car_data['images']);

            $regex         = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }

               
               $to_return[] = $car_data;
           }
           
               
               
                
           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+" data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*[^\(]+\((?<img_url>[^\)]+)/'
);
//    add_filter('filter_ennsbrotherscom_field_make', 'unicodify');
 //   add_filter('filter_ennsbrotherscom_field_model', 'unicodify');

/*
    function ennsbrotherscom_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }
    
    */   
  /*  
    
 add_filter("filter_ennsbrotherscom_field_images", "filter_ennsbrotherscom_field_images");
 function filter_ennsbrotherscom_field_images($im_urls)
    {
           //$retval = [];
         if(count($im_urls)<2){ return [];}
        else{ return $im_urls; }
    }

*/