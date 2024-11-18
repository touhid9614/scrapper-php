<?php
global $scrapper_configs;
$scrapper_configs["cartergm"] = array(
    'entry_points'        => array(
        'new'  => 'https://www.cartergm.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2101%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        'used' => 'https://www.cartergm.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D2101%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dtrue%26qs%3D%26im%3Dtrue%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3Dtrue%26oem%3D%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26view%3Dgrid%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dnone%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
    ),
    'vdp_url_regex'       => '/\/vehicles\/[0-9]{4}\//',
    'srp_page_regex'      => '/\/vehicles\/(?:new|used)\//',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'POST',
    'next_method'         => 'POST',

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->results as $obj) {
            $car_data = array(
                'stock_number'   => $obj->stock_number ? $obj->stock_number : $obj->vehicle_id,
                //'stock_type'     => strtolower($obj->sale_class) || 'new',
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'body_style'     => $obj->body_style,
                'price'          => $obj->final_price ? $obj->final_price : "Please call",
                'engine'         => $obj->engine,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fuel_type,
                'drivetrain'     => $obj->drive_train,
                'msrp'           => $obj->msrp,
                'url'            => strtolower("https://www.cartergm.com/vehicles/" . $obj->year . '/' . $obj->make . '/' . str_replace(" ", "-", $obj->model) . '/burnaby/bc/' . $obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,

            );
            $response_data = HttpGet($car_data['url'], true, true);
            $regex         = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {
                $car_data['description'] = $matches['description'];
            }

            $price_regex = '/"sale_price":(?<price>[^\,]+)/';
            $matches     = [];

            if (preg_match($price_regex, $response_data, $matches)) {
                $car_data['price'] = $matches['price'];
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'         => '/image_lg":"(?<img_url>[^"]+)"/',
);

add_filter('filter_for_fb_cartergm', 'filter_for_fb_cartergm', 10, 2);

function filter_for_fb_cartergm($car_data, $feed_type)
{
    if (empty($car_data['all_images'])) {
        return null;
    }

    $images = explode('|', $car_data['all_images']);

    if (isset($images[2])) {
        unset($images[2]);
    }

    // apply condition for other feeds inside this condition
    if (!in_array($feed_type, ['google-merchant', 'google-marchant', 'google_merchant', 'google_marchant'])) {
        $myimg                  = array_values($images);
        $car_data['images']     = $myimg;
        $car_data['all_images'] = implode('|', $myimg);

        return $car_data;
    }

    if (isset($images[0])) {
        unset($images[0]);
    }

    if (count($images) < 2) {
        return null;
    }

    $myimg = array_values($images);

    $car_data['images']     = $myimg;
    $car_data['all_images'] = implode('|', $myimg);

    return $car_data;
}
