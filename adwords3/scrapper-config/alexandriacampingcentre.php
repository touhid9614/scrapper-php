<?php

global $scrapper_configs;

$scrapper_configs['alexandriacampingcentre'] = array(
    'entry_points' => array(
        'new'   => 'https://www.alexandriacampingcentre.com/imglib/Inventory/cache/2229/NVehInv.js?v=6978589',
        'used'  => 'https://www.alexandriacampingcentre.com/imglib/Inventory/cache/2229/UVehInv.js?v=6391370',
    ),
    'vdp_url_regex'     => '/\/default.asp\?page=x(?:New|PreOwned)InventoryDetail/i',
    'required_params'   => array('page','id'),
    'use-proxy' => true,
    'refine'    => false,
    'picture_selectors' => ['.vehicle-thumb '],
    'picture_nexts'     => ['.right'],
    'picture_prevs'     => ['.left'],
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
                   $url="https://www.alexandriacampingcentre.com/default.asp?page=xPreOwnedInventoryDetail";
               }
               else 
               {
                   $url="https://www.alexandriacampingcentre.com/default.asp?page=xNewInventoryDetail";
               }
               $car_data = array(

                   'transmission'      => $obj->transmission,
                   'vin'               => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'stock_number'      => !empty($obj->stockno)?$obj->stockno:$obj->id,
                   'year'              => $obj->bike_year,
                   'make'              => $obj->manuf,
                   'model'             => preg_replace('/[^A-Za-z0-9 -]/', '', explode(" ",$obj->model)[0]),
                   'body_style'        => $obj->vehtypename,
                   'stock_type'        => $obj->type == 'U'?'used':'new',
                   'price'             => !empty($obj->price)?$obj->price :(!empty($obj->retail_price)?$obj->retail_price:'Call for Price'),
                   'kilometres'        => isset($obj->miles)?$obj->miles:'',
                  // 'url'               => "http://www.alexandriacampingcentre.com/default.asp?page=xNewInventoryDetail&id={$obj->id}",
                   'url'               => $url.'&id='.$obj->id,
                   'exterior_color'    => $obj->vehtypename,
                   'engine'            => $obj->engine,
                   'custom'            => $obj->imageOverlayText,

               );


               $response_data = HttpGet($car_data['url']);
               $regex         ='/<meta name="description" content="(?<description>[^"]+)/';
               $matches       =[];

               if(preg_match($regex,$response_data,$matches)){
                $car_data['description']=$matches['description'];
               }


               $to_return[] = $car_data;
           }

           return $to_return;
       },
    'images_regx'       => '/<li class="photo image_[0-9]+"[^>]+><a\s*[^\s]+\s*href="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
);
    add_filter('filter_alexandriacampingcentre_field_make', 'unicodify');
    add_filter('filter_alexandriacampingcentre_field_model', 'unicodify');
    add_filter('filter_alexandriacampingcentre_car_data', 'filter_alexandriacampingcentre_car_data');

    function alexandriacampingcentre_images_proc($image_url)
    {
        $tmp = str_replace('120x90', '800x600', $image_url);
        return str_replace('_th.jpg', '.jpg', $tmp);
    }
    
        
// function filter_alexandriacampingcentre_car_data($car_data) {
//     //taking all cars except Corvette

//     if($car_data['stock_number']=="DP235A"){
//         return str_replace("Â®","", $car_data['model']);
//     }
//     if($car_data['stock_number']=='CONJC'|| $car_data['stock_number']=='CONGS'||$car_data['stock_number']=='CONSM'||$car_data['stock_number']=='CONDF' || $car_data['stock_number']=='CONGG'||$car_data['stock_number']=='CONSA'||$car_data['stock_number']=='CONPL')
//     {
//         return NULL;
//     }
    



//     return $car_data;
// }

    
    

