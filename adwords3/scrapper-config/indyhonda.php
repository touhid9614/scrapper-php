<?php

global $scrapper_configs;

$scrapper_configs['indyhonda'] = array(
    'entry_points'        => array(
        'used' => 'https://www.indyhonda.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new'  => 'https://www.indyhonda.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
    ),

    'vdp_url_regex'       => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'srp_page_regex'      => '/\/(?:new|used|certified)-inventory\//i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.pswp-thumbnail'],
    'picture_nexts'       => ['.pswp__button--arrow--right'],
    'picture_prevs'       => ['.pswp__button--arrow--left'],

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
        }

        $to_return = [];

        foreach ($objects->pageInfo->trackingData as $obj) {
            $car_data = array(
                'stock_number'   => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                'stock_type'     => $obj->newOrUsed,
                'vin'            => $obj->vin,
                'vehicle_id'     => $obj->uuid,
                'year'           => $obj->modelYear,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'body_style'     => $obj->bodyStyle,
                'price'          => $obj->askingPrice,
                'msrp'           => $obj->msrp,
                'trim'           => $obj->trim,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'exterior_color' => $obj->exteriorColor,
                'interior_color' => $obj->interiorColor,
                'fuel_type'      => $obj->fuelType,
                'drive_train'    => $obj->driveLine,
                'options'        => isset($obj->installed_options) ? $obj->installed_options : [],
                'url'            => "https://www.indyhonda.com" . $obj->link,
            );
            $ignore_data=[
                    'P7069',
                    'P7208',
                    'IHO1268P'
                    ];
    
                if (in_array($car_data['stock_number'], $ignore_data)) 
                {
                    slecho("Excluding car that has  ,{$car_data['stock_number']}");
                     continue;

                }

            $response_data = HttpGet($car_data['url'], true, true);
            $regex         = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'next_page_regx'      => '/enableMyCars":(?<next>[^"]+)/',
    'images_regx'         => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',

);

add_filter("filter_indyhonda_next_page", "filter_indyhonda_next_page", 10, 2);

function filter_indyhonda_next_page($next, $current_page)
{
    $start_tag = 'start=';
    $end_tag   = '&';

    if (stripos($current_page, $start_tag)) {
        $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
    }

    if (strpos($resp, $end_tag)) {
        $resp = substr($resp, 0, stripos($resp, $end_tag));
    }

    $rep_value = $resp + 18;
    $find      = "start=" . $resp;
    $rep       = "start=" . $rep_value;
    $next      = str_replace($find, $rep, $current_page);

    return $next;
}