<?php
global $scrapper_configs;
 $scrapper_configs["escoauto"] = array( 
	 'entry_points' => array(
            'used'   => array( 
                    'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=0',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=10',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=20',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=30',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=40',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=50',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=60',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=70',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=80',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=90',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=100',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=120',
                'https://www.escoauto.com/Inventory/Search?&Condition=pre-owned-cars&startIndex=130',
                
                ),
         ),
        'vdp_url_regex'         => '/\/detail\/[0-9]{4}-/',
        'use-proxy'             => true,
        'srp_page_regex'      => '/com\/pre-owned-cars/i',
        'content_type'          => 'application/json',
        'picture_selectors' => ['.thumbnail'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        'custom_data_capture'   => function($url, $data){
        
            $start_tag  = '<div id="ds-vehicles-json" data-json="';
            $end_tag    = '"></div>';

           if (stripos($data, $start_tag)) {
                $resp = substr($data, stripos($data, $start_tag) + strlen($start_tag));
            }

            if (stripos($data, $end_tag)) {
              $resp = substr($data, 0, stripos($data, $end_tag));
            }
            $objects = json_decode(str_replace('&quot;','"',$data));
            if(!$objects) { slecho($data); return array(); }
            
            $to_return = array();
            
            foreach($objects->vehicles as $obj)
            {
                if ($obj->IsSold == 1) { continue;}
                
                $car_data = array(
                    'stock_number'      => $obj->StockNo?$obj->StockNo:$obj->Vin,
                   // 'stock_type'        => strtolower($obj->condition),
                    'year'              => $obj->Year,
                    'make'              => $obj->Make,
                    'model'             => $obj->Model,
                    'trim'              => preg_replace('/[^A-Za-z0-9 -]/', '', $obj->Trim),
                    'vin'               => $obj->Vin,
                    //'body_style'        => $obj->bodystyle,
                    'price'             => $obj->FinalPrice==0?"please call":$obj->FinalPrice,
                    'engine'            => $obj->Engine,
                    'transmission'      => $obj->Transmission,
                    'kilometres'        => $obj->Mileage,
                    'url'               => "https://www.escoauto.com/pre-owned-cars/detail/" .strtolower($obj->Year).'-'. strtolower($obj->Make) . '-' . strtolower(explode(" ",$obj->Model)[0]) . '-' . strtolower(explode(" ",$obj->Model)[1]).'-'.strtolower(explode(" ",$obj->Model)[2]).'/'.strtolower($obj->VehicleId),
                    'exterior_color'    => $obj->FactoryColorTex,
                    'interior_color'    => $obj->FactoryInteriorText,
                    'certified'         => $obj->CertifiedStatus?1:0,
                    //'images'            => $obj->picture
                );

            $response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }

                
                $to_return[] = $car_data;
            }
            
            return $to_return;
        },
        'images_regx'     =>'/thumbnail ds-detail-thumb">\s*<img.*data-src="(?<img_url>[^"]+)/',
    );
    
    
add_filter('filter_escoauto_field_images','filter_escoauto_field_images');
function filter_escoauto_field_images($im_urls)
 {
    unset($im_urls[0]);
    return $im_urls;
}