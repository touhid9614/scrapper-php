<?php

global $scrapper_configs;
$scrapper_configs["steelechevcom"] = array(
 

	 'entry_points'        => array(
        'used' => 'https://www.steelechev.com/en/used-inventory/api/listing?limit=500',
        'new'  => 'https://www.steelechev.com/en/new-inventory/api/listing?limit=500', 
    ),
    'vdp_url_regex'       => '/\/en\/(?:new|used)-(?:catalog|inventory)\/[^\/]+\/[^\/]+\/[0-9]{4}/i',
    'srp_page_regex'      => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
    'use-proxy'           => true,
    'refine'              => false,
    'picture_selectors'   => ['.ril-inner img'],
    'picture_nexts'       => ['.next-button'],
    'picture_prevs'       => ['.prev-button'],
    'content_type'        => 'application/json',
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->vehicles as $obj) {
            $stock_type = !!$obj->newVehicle ? "new" : "used";
            $car_data   = array(
                'stock_number' => $obj->stockNo ? $obj->stockNo : $obj->serialNo,
                'year'         => $obj->year,
                'make'         => $obj->make->name,
                'model'        => $obj->model->name,
                'trim'         => $obj->trim->name,
                'price'        => $obj->salePrice,
                'transmission' => $obj->transmission,
                'kilometres'   => $obj->odometer,
                'vin'          => $obj->serialNo,
                  'body_style'        => $obj->bodyStyle->name,
                'drivetrain'   => $obj->driveTrain,
                'url'          => strtolower("https://www.steelechev.com/en/" . $stock_type . "-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId),
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