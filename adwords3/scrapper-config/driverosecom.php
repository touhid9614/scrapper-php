<?php

global $scrapper_configs;
$scrapper_configs["driverosecom"] = array(
    'entry_points' => array(
        'used' => 'https://express.driverose.com/inventory/used',
    //'new'   => 'https://minihalifax.ca/en/shopping/inventory',
    ),
    'vdp_url_regex' => '/\/express\/(?:new|used)\//i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.item img'],
    'picture_nexts' => ['.auto-gallery-right'],
    'picture_prevs' => ['.auto-gallery-left'],
    'custom_data_capture' => function($url, $resp) {
        $start_tag = 'window.pageData =';
        $end_tag = '};';

        if (stripos($resp, $start_tag)) {
            $resp = substr($resp, stripos($resp, $start_tag) + strlen($start_tag));
        }

        if (stripos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }
        $resp = $resp . "}";
        $inventory = json_decode($resp);

        $to_return = array();

        foreach ($inventory->search->vehicles as $obj) {

            $car_data = array(
                'transmission' => $obj->transmission->type,
                'vin' => !empty($obj->vin) ? $obj->vin : $obj->stock_number,
                'stock_number' => !empty($obj->stock_number) ? $obj->stock_number : $obj->vin,
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'body_style' => $obj->body,
                //'stock_type'        => $obj->type == 'U'?'used':'new',
                'price' => !empty($obj->dealer_price) ? $obj->dealer_price : (!empty($obj->dealer_price) ? $obj->dealer_price : 'Call for Price'),
                'kilometres' => $obj->mileage,
                'url' => "https://express.driverose.com/express/used/" . $obj->vin,
                'exterior_color' => $obj->exterior_color->label,
                'interior_color' => $obj->interior_color->label,
                'engine' => $obj->engine->label,
                'msrp' => $obj->msrp,
                'drivetrain' => $obj->drivetrain,
                'trim' => $obj->trim,
            );

            $response_data = HttpGet($car_data['url']);
            $regex = '/categorized_options[^\[]+\[(?<img_url>[^\]]+)\]/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['all_images'] = str_replace(['"', ','], ['', '|'], $matches['img_url']);
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
);

