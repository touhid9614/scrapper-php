<?php
global $scrapper_configs;
$scrapper_configs["bmwlavalcom"] = array( 
	'entry_points'        => array(
        'new'  => 'https://www.bmwlaval.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D897%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3D%26svs%3D%26sc%3Dnew%26v1%3D%26st%3D%26ai%3D%26oem%3D%26view%3Dgrid%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dsale%26pnpm%3Dnone%26pnpf%3Dinte-inc%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',

        'used' => 'https://www.bmwlaval.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D897%26ln%3Den%26pg%3D1%26pc%3D15%26dc%3Dtrue%26qs%3D%26im%3D%26svs%3D%26sc%3Dused%26v1%3D%26st%3D%26ai%3D%26oem%3D%26view%3Dgrid%26in_transit%3Dtrue%26in_stock%3Dtrue%26on_order%3Dtrue%26SrpTemplateParams%3D%255Bobject%2520Object%255D%26defaultParams%3D%26pnpi%3Dsale%26pnpm%3Dnone%26pnpf%3Dinte-inc%26pupi%3Dmsrp%26pupm%3Dnone%26pupf%3Dinte%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match'      => '/libs/formProcessor.html',
    'use-proxy'           => true,
    'refine'              => false,
    'init_method'         => 'POST',
    'next_method'         => 'POST',
    'picture_selectors'   => ['.modal-slideshow__gallery__container__img'],
    'picture_nexts'       => ['button.modal-slideshow__next'],
    'picture_prevs'       => ['button.modal-slideshow__prev'],
    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->results as $obj) {
            $car_data = array(
                'stock_number'   => $obj->stock_number ? $obj->stock_number : $obj->vehicle_id,
                'stock_type'     => strtolower($obj->sale_class),
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'body_style'     => $obj->body_style,
                'price'          => $obj->final_price == 0 ? "please call" : $obj->final_price,
                'engine'         => $obj->engine,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fuel_type,
                'drivetrain'     => $obj->drive_train,
                'msrp'           => $obj->msrp,
                'url'            => strtolower("https://www.bmwlaval.com/vehicles/" . $obj->year . '/' . $obj->make . '/' . str_replace(" ", "-", $obj->model) . '/laval/qc/' . $obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,

            );

            $response_data = HttpGet($car_data['url'], true, true);
            $regex         = '/","description":"(?<description>[^"]+)/';
            $matches       = [];

            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }

            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx'         => '/image_lg":"(?<img_url>[^"]+)"/',
);

add_filter("filter_bmwlavalcom_field_images", "filter_bmwlavalcom_field_images", 10, 2);

function filter_bmwlavalcom_field_images($im_urls, $car_data)
{
    $retval = [];
    $ignore = strtolower("https://www.bmwlaval.com/vehicles/" . $car_data['year'] . '/' . $car_data['make'] . '/' . str_replace(" ", "-", $car_data['model']) . '/laval/qc/');

    slecho($ignore);

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '\\', '=', 'NDQwLCJoZWlnaHQiOjEwODAsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ', 'AyNCwiaGVpZ2h0Ijo3NjgsImZpdCI6Imluc2lkZSIsIndpdGhvdXRFbmxhcmdlbWVudCI6dHJ1ZX19fQ'], ['', '', '', 'MDI0LCJoZWlnaHQiOjc2OCwiZml0IjoiaW5zaWRlIiwid2l0aG91dEVubGFyZ2VtZW50Ijp0cnVlfX19', 'Q0MCwiaGVpZ2h0IjoxMDgwLCJmaXQiOiJpbnNpZGUiLCJ3aXRob3V0RW5sYXJnZW1lbnQiOnRydWV9fX0'], rawurldecode($im_url));
    }

    $retval = preg_replace('/http(s)?:.*(?=http)/', '', $retval, -1);

    return $retval;
}
