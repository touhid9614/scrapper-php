<?php
global $scrapper_configs;
$scrapper_configs["sunvalleyhondacom"] = array( 
      'entry_points'        => array(
        'used' => 'https://www.sunvalleyhonda.com/en/used-inventory/api/listing?limit=500',
        'new'  => 'https://www.sunvalleyhonda.com/en/new-inventory/api/listing?limit=500',
    ),
    'vdp_url_regex'       => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
   
    'use-proxy'           => true,
    'refine'              => false,
    'picture_selectors'   => ['.swiper-slide'],
    'picture_nexts'     => ['.swiper-button-next.carousel__navigation.carousel__navigation--next'],
     'picture_prevs'     => ['.swiper-button-prev.carousel__navigation.carousel__navigation--prev'],
    'content_type'        => 'application/json',
    'custom_data_capture' => function ($url, $data) {

        $objects = json_decode($data);

        if (!$objects) {
            //slecho($data);
            return array();
        }

        $to_return = array();
        foreach ($objects->vehicles as $obj) {
            $stock_type = $obj->newVehicle ? "new" : "used";
            $car_data   = array(
                'stock_number' => $obj->stockNo ? $obj->stockNo : $obj->serialNo,
                'year'         => $obj->year,
                'make'         => $obj->make->name,
                'model'        => $obj->model->name,
                'trim'         => $obj->trim->name,
                'price'        => $obj->salePrice,
                'transmission' => $obj->transmission,
                'kilometres'   => $obj->odometer,
                'body_style'        => $obj->bodyStyle->name,
                'vin'          => $obj->serialNo,
                'drivetrain'   => $obj->driveTrain,
                'url'          => "https://www.sunvalleyhonda.com/en/" . $stock_type . "-inventory/" . strtolower($obj->make->name) . '/' . strtolower($obj->model->name) . '/' . $obj->year . '-' . strtolower($obj->make->name) . '-' . strtolower($obj->model->name) . '-id' . $obj->vehicleId,
                'all_images'   => $obj->multimedia->mainPicture ? "https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture : '',
            );

            $images = [];
            foreach ($obj->multimedia->pictures as $picture) {
                $images[] = 'https://img.sm360.ca/images/inventory' . $picture;
            }

            $car_data['all_images'] = implode("|", $images);

            $response_data = HttpGet($car_data['url']);
            $regex         = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches       = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },

);

    
    
    
    
    
    
    
    
    
    
    
//	 'entry_points' => array(
//        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/sunvalleyhonda_en.csv'
//    ),
//      'vdp_url_regex'         => '/\/inventory\/(?:new|used|preowned)/',
//         'use-proxy'         => true,
//       'refine' => false,
//        'picture_selectors' => ['.car-images'],
//        'picture_nexts'     => ['.swiper-button-next.carousel__navigation.carousel__navigation--next'],
//        'picture_prevs'     => ['.swiper-button-prev.carousel__navigation.carousel__navigation--prev'],
//    
//    
//    'custom_data_capture' => function($url, $resp) {
//        $vehicles = convert_CSV_to_JSON($resp);
//
//        $result = [];
//
//        foreach ($vehicles as $vehicle) {
//            $car_data = [
//                'stock_number' => $vehicle['stock'],
//                'vin' => $vehicle['vin'],
//                'stock_type' => $vehicle["is_new"] == "false" ? "used" : "new",
//                'year' => $vehicle['year'],
//                'make' => $vehicle['make'],
//                'model' => $vehicle['model'],
//                'trim' => $vehicle['trim'],
//                'drivetrain' => $vehicle['drive'],
//                'fuel_type' => $vehicle['fuel'],
//                'transmission' => $vehicle['transmission'],
//                'body_style' => $vehicle['body'],
//                 'images'        => explode(',', $vehicle['photo']),
//                 'all_images'    => implode('|', explode(',', $vehicle['photo'])),   
//                'price' => $vehicle['standard_price'],
//                'url' => $vehicle['external_url'],
//               // 'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
//                'exterior_color' => $vehicle['extcolour'],
//                'interior_color' => $vehicle['intcolour'],
//                'engine' => $vehicle['eng_desc'],
//                'description' => strip_tags($vehicle['description']),
//                'kilometres' => $vehicle['odometer'],
//            ];
//
//
//            $result[] = $car_data;
//        }
//
//        return $result;
//    }
//);
