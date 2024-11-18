<?php
global $scrapper_configs;
$scrapper_configs["boatingfreedomcom"] = array( 
	'entry_points' => array(
            'used'  => array(
                        'https://boatingfreedom.com/yachts-for-sale/power/',
                       // 'https://boatingfreedom.com/yachts-for-sale/?stock=Sail',
                       // 'https://boatingfreedom.com/yachts-for-sale/?stock=House',
                ),
        ),
        'vdp_url_regex'     => '/\/boats\//i',
        'use-proxy' => true,
        'refine'    => false,

        'custom_data_capture' => function($url, $resp){
               $start_tag  = "<boat-listing :boats='";
               $end_tag    = "'></boat-listi";

               if(stripos($resp, $start_tag)) {
                   $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
               }

               if(stripos($resp, $end_tag)) {
                   $resp = substr($resp, 0, stripos($resp, $end_tag));
               }
               
               $inventory     = json_decode($resp);

               $to_return = array();
               $out_stock=array(
                   '7862237',
                   '7836644',
                   '7887308',
                   '7366950',
                   '7068419',
                   '7796332',
                   '8126182',
                   '8049395',
                   '8050812',
                   '7852378',
                   '8126146',
                   '7938886',
                
                );

               foreach($inventory as $obj)
               {

                   $car_data = array(

                       'stock_number'      => !empty($obj->id)?$obj->id:$obj->id,
                       'year'              => $obj->year,
                       'make'              => $obj->make,
                       'model'             => $obj->model,
                       'body_style'        => $obj->type,
                       'price'             => $obj->priceCAD,
                       'trim'              => str_replace('0"', '', $obj->length_ft),
                       'deleted'           => $obj->sold?1:0,
                       'url'               => 'https://boatingfreedom.com/boats/' . str_replace(' ', '-', $obj->search) . '-' . $obj->id . '/',
                       'engine'            => $obj->engine,
                       'drivetrain'        => $obj->Sail,
                       'description'       => $obj->description,
                       'stock_type'        => strtolower($obj->condition),

                   );
                   if(in_array($car_data['stock_number'], $out_stock)){ continue;}
                   if(strpos($obj->stock,"Sold") || $obj->stock=='Other'){
                       slecho("filteredd out");
                       continue;
                   }

                   $to_return[] = $car_data;
               }

               return $to_return;
           },
           //'description'  => '/seller-description"[^>]+>[^\/]+\/strong><\/span>[^>]+>\s*(?<description>[^<]+)/',
           'images_regx'       => '/<img src="(?<img_url>https:\/\/images.boatsgroup.com\/[^"]+)"\s*\/>\s*<img/',
        //'images_fallback_regx'   => '/unitSliderImg">\s[^\n]+\s*[^\n]+\s*<img .* src=\'(?<img_url>[^\']+)/'
    );
