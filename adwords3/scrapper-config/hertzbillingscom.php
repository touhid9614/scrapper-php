<?php
global $scrapper_configs;
$scrapper_configs["hertzbillingscom"] = array(
    'entry_points'        => array(
        'used' => 'https://www.hertzbillings.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
    ),
    'vdp_url_regex'       => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
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

            $car_data = [
                'stock_number'   => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                'stock_type'     => strtolower($obj->newOrUsed),
                'vin'            => $obj->vin,
                'year'           => $obj->modelYear,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'body_style'     => $obj->bodyStyle,
                'price'          => $obj->askingPrice,
                'trim'           => $obj->trim,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'exterior_color' => $obj->exteriorColor,
                'interior_color' => $obj->interiorColor,
                'fuel_type'      => $obj->fuelType,
                'drive_train'    => $obj->driveLine,
                'options'        => isset($obj->installed_options) ? $obj->installed_options : [],
                'url'            => "https://www.hertzbillings.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-" . str_replace(" ", "+", $obj->model) . "-{$obj->uuid}" . ".htm",
            ];

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'next_page_regx'      => '/enableMyCars":(?<next>[^"]+)/',
    'images_regx'         => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',

);

add_filter("filter_hertzbillingscom_next_page", "filter_hertzbillingscom_next_page", 10, 2);
function filter_hertzbillingscom_next_page($next, $current_page)
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

    $find = "start=" . $resp;
    $rep  = "start=" . $rep_value;
    $next = str_replace($find, $rep, $current_page);
    slecho($next);

    return $next;
}
