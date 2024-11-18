<?php

global $scrapper_configs;

$scrapper_configs['purchaseford'] = array(
    'entry_points'        => array(
        'new'  => 'https://search-a5-jazel-tango.jazel-qa.com/api/passthroughsrp?q=(account_id:1030%20AND%20(vehicle_filter_ids:2)%20AND%20((((make_sidebar:%22Ford%22)))))&size=2000&start=0',
        'used' => 'https://search-a5-jazel-tango.jazel-qa.com/api/passthroughsrp?q=(account_id%3A1030%20AND%20(vehicle_filter_ids%3A3))&q.parser=lucene&size=100&sort=has_price%20desc%2Chas_image%20desc%2Cdisplay_price%20asc&start=0',
    ),
    'vdp_url_regex'       => '/\/inventory\/(?:new|used)-vehicles\/vehicle\//',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'GET',
    'picture_selectors'   => ['.image-gallery-thumbnails-container a'],
    'picture_nexts'       => ['.image-gallery-right-nav'],
    'picture_prevs'       => ['.image-gallery-left-nav'],
    'content_type'        => 'application/json',
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return [];
        }

        $to_return = [];

        foreach ($objects->hits->hit as $obj) {
            $car_data = array(
                'stock_number'   => $obj->fields->stock_number ? $obj->fields->stock_number : $obj->fields->vin,
                'year'           => $obj->fields->year,
                'make'           => $obj->fields->make,
                'model'          => $obj->fields->model,
                'trim'           => $obj->fields->trim,
                'body_style'     => $obj->fields->vehicle_type[0],
                'price'          => $obj->fields->display_price,
                'engine'         => $obj->fields->engine,
                'transmission'   => $obj->fields->transmission,
                'kilometres'     => $obj->fields->mileage,
                'vin'            => $obj->fields->vin,
                'fuel_type'      => $obj->fields->fuel_type,
                'drivetrain'     => $obj->fields->drivetrain,
                'url'            => "https://www.purchaseford.net/inventory/"
                . ($obj->fields->used ? "used" : "new") . "-vehicles/vehicle/" . $obj->fields->vin . "/"
                . ($obj->fields->used ? implode("-", $obj->fields->conditions) . "-" : "") . "{$obj->fields->year}-{$obj->fields->make}-{$obj->fields->model}-"
                . str_replace(', ', '-', $obj->fields->location_city_state_sidebar),
                'exterior_color' => $obj->fields->exterior_color,
                'interior_color' => $obj->fields->interior_factory_color,
                'city'           => $obj->fields->location_city,
            );
            $price_array = [];
            foreach (json_decode($obj->fields->pricings) as $key => $value) {
                if ($value->Name == "@MSRP" || $value->Name == "@SellingPrice" || $value->Name == "@FinalPrice" || $value->Name == "@Price") {
                    $price_array[] = $value->Value;
                }
            }
            $car_data['price'] = min($price_array);
            if ($car_data['price'] <= 0) {
                continue;
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'         => '/"source[^"]+":[^"]+"(?<img_url>[^"]+)/'
);

add_filter("filter_purchaseford_field_images", "filter_purchaseford_field_images", 10, 2);

function filter_purchaseford_field_images($im_urls, $car_data)
{
    $retval = array();
    $ignore = "https://www.purchaseford.net/inventory/" . $car_data['stock_type'] . "-vehicles/vehicle/" . $car_data['vin'] . "/";

    slecho($ignore);

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, "\\", '|'], ['', '', '%7c'], $im_url);
    }

    return $retval;
}
