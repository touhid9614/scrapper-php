<?php
global $scrapper_configs;
 $scrapper_configs["nacvegascom"] = array( 
	  'entry_points' => array(
            'used'   => array(
                    'https://www.nacvegas.com/inv-scripts/inv/4644110/vehicles?vc=a&f=id%7csn%7cye%7cma%7cmo%7ctr%7cdt%7cta%7ctd%7cen%7cmi%7cdr%7cec%7cic%7cbt%7cpr%7cde%7cim%7ceq%7cvd%7cvin%7chpg%7ccpg%7cvc%7cco%7chi%7ccfx%7cacr%7cvt%7ccy%7cdi%7cft%7clo%7csx%7cdc%7csi&ps=10&pn=1&sb=pr%7cd&sp=n&cb=dws_inventory_listing_1&vsi=0&h=9c8abc21939bd0ee3a31c745168cf899',
                    'https://www.nacvegas.com/inv-scripts/inv/4644110/vehicles?vc=a&f=id%7csn%7cye%7cma%7cmo%7ctr%7cdt%7cta%7ctd%7cen%7cmi%7cdr%7cec%7cic%7cbt%7cpr%7cde%7cim%7ceq%7cvd%7cvin%7chpg%7ccpg%7cvc%7cco%7chi%7ccfx%7cacr%7cvt%7ccy%7cdi%7cft%7clo%7csx%7cdc%7csi&ps=10&pn=0&sb=pr%7cd&sp=n&cb=dws_inventory_listing_1&vsi=0&h=a1a89169de4bec4b96b80d7d1e6767cf',
            )
       
    ),
        'vdp_url_regex'     => '/\/inventory\//i',
        //'ty_url_regex'      => '/\/thank-you\//i',
        'use-proxy' => true,
        'picture_selectors' => ['.carousel .slides>li'],
        'picture_nexts'     => ['.carousel-nav-next'],
        'picture_prevs'     => ['.carousel-nav-prev'],
        'custom_data_capture' => function($url, $resp){
             $start_tag  = '"Vehicles":';
            $end_tag    = '});';

            if(stripos($resp, $start_tag)) {
                $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
            }

            if(stripos($resp, $end_tag)) {
                $resp = substr($resp, 0, stripos($resp, $end_tag));
            }
           $object     = json_decode($resp);
            $to_return = array();
           
            foreach($object as $obj)
            {
                $car_data = array(
                    'stock_number'      => $obj->StockNumber?$obj->StockNumber:$obj->Vin,
                    'vin'               => $obj->Vin,
                    'year'              => $obj->Year,
                    'make'              => $obj->Make,
                    'model'             => $obj->Model,
                    'trim'              => $obj->Trim,
                    'body_style'        => $obj->BodyType,
                    'price'             => $obj->VehiclePrice,
                    'engine'            => $obj->Engine,
                    'transmission'      => $obj->Transmission,
                    'kilometres'        => $obj->Odometer,
                    'url'               => "https://www.nacvegas.com/inventory/" . strtolower($obj->Make) . '/' . strtolower($obj->Model) .
                                           '/' .strtolower($obj->StockNumber),
                    'exterior_color'    => $obj->ExteriorColor,
                    'interior_color'    => $obj->InteriorColor,
                    'description'       => $obj->VehicleDescription,
                    'drivetrain'        => $obj->Drivetrain,
                    'fuel_type'         => $obj->FuelType,
                    
                );
                $to_return[] = $car_data;
            }
            slecho("End Scrap");
            return $to_return;
        },
        'images_regx' => '/ data-base-img-url="(?<img_url>[^"]+)"/'
    );
