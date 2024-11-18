<?php

global $scrapper_configs;
$scrapper_configs["majormotorsramcomau"] = array(
    'entry_points' => array(
        'all' => 'https://data.stock.i-motor.net.au/v3/1274/61/2511/pCvOpLqVlb/stock'
    ),
    'vdp_url_regex' => '/\/for-sale\//i',
    'use-proxy' => true,
    'init_method'       => 'GET',
    'content_type' => 'application/json',
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);
        $to_return = [];

        foreach ($objects as $obj) {
            $series = str_replace(" ", "-", $obj->series);
            $car_data = array(
                'stock_number' => !empty($obj->stock_number) ? $obj->stock_number : $obj->vin,
                'stock_type' => strtolower($obj->veh_type),
                'vin' => strtoupper($obj->vin),
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'body_style' => $obj->body,
                'price' => $obj->price,
                'transmission' => $obj->transmission,
                'custom' => strtolower($obj->veh_type),
                'url' => strtolower("https://www.majormotorsram.com.au/new-cars/for-sale/{$obj->make}/{$obj->model}/{$obj->year}/express/{$series}/$obj->id"),
                'all_images' => implode("|", $obj->images),    
            );
           
            $to_return[] = $car_data;
        }

        return $to_return;
    },
);
