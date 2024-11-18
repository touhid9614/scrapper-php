<?php
global $scrapper_configs;
$scrapper_configs["fastridetimeca"] = array(
    'entry_points'        => array(
        'used' => 'https://fast.ridetime.ca/api/dealer_used_inventory?deal_type=cash',
    ),
    'vdp_url_regex'       => '/\/express\//i',
    'use-proxy'           => true,
    'refine'              => false,
    'picture_selectors'   => ['.u-dib .FlexEmbed-content img'],
    'picture_nexts'       => ['.Swipe-control--next button'],
    'picture_prevs'       => ['.Swipe-control--prev button'],

    'custom_data_capture' => function ($url, $resp) {
        $object    = json_decode($resp);
        $inventory = $object->vehicles;
        $to_return = [];

        foreach ($inventory as $obj) {
            $url      = "https://fast.ridetime.ca/express/";
            $car_data = array(
                'transmission'   => $obj->transmission->label,
                'stock_number'   => !empty($obj->stock_number) ? $obj->stock_number : $obj->vin,
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'body_style'     => $obj->body,
                'price'          => $obj->dealer_price ? $obj->dealer_price : $obj->roadster_price,
                'kilometres'     => $obj->mileage,
                'url'            => $obj->used ? $url . "used/" . $obj->vin . "?deal_type=cash" : $url . $obj->vin . "?deal_type=cash",
                'exterior_color' => $obj->exterior_color->label,
                'vin'            => $obj->vin,
                'engine'         => $obj->engine->label,
                'drivetrain'     => $obj->drivetrain,
                'fuel_type'      => $obj->engine->type,
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'         => '/images":\["(?<img_url>[^\]]+)\]/',
);

add_filter("filter_fastridetimeca_field_images", "filter_fastridetimeca_field_images");

function filter_fastridetimeca_field_images($im_urls)
{
    $img = str_replace('"', "", $im_urls[0]);
    $img = explode(',', $img);

    return $img;
}
