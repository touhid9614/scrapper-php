<?php
global $scrapper_configs;
$scrapper_configs["ponokachryslercom"] = array( 
	"entry_points" => array(
	   'new'  => 'https://www.ponokachrysler.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1384%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dnew%26v1%3D%26st%3Dprice%252Casc%26ai%3D%26oem%3D%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dinte%26pupm%3Dnone%26pupf%3Dnone%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
        'used' => 'https://www.ponokachrysler.com/wp-content/plugins/convertus-vms/include/php/ajax-vehicles.php?endpoint=https%3A%2F%2Fvms.prod.convertus.rocks%2Fapi%2Ffiltering%2F%3Fcp%3D1384%26ln%3Den%26pg%3D1%26pc%3D1000%26dc%3Dfalse%26qs%3D%26im%3D%26sc%3Dused%26v1%3D%26st%3Dprice%252Casc%26ai%3D%26oem%3D%26view%3Dgrid%26SrpTemplateParams%3D%26defaultParams%3D%26pnpi%3Dmsrp%26pnpm%3Dnone%26pnpf%3Dinte%26pupi%3Dinte%26pupm%3Dnone%26pupf%3Dnone%26nnpi%3Dnone%26nnpm%3Dnone%26nnpf%3Dnone%26nupi%3Dnone%26nupm%3Dnone%26nupf%3Dnone%26po%3D&action=vms_data',
    ),

    'vdp_url_regex'       => '/\/vehicles\/[0-9]{4}\//',
    'ajax_url_match'      => '/libs/formProcessor.html',
    'use-proxy'           => true,
    'refine'              => false,

    'init_method'         => 'POST',
    'next_method'         => 'POST',

    'picture_selectors'   => ['.thumbnails__single'],
    'picture_nexts'       => ['button.modal-slideshow__next'],
    'picture_prevs'       => ['button.modal-slideshow__prev'],

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
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
                'price'          => $obj->final_price,
                'engine'         => $obj->engine,
                'transmission'   => $obj->transmission,
                'kilometres'     => $obj->odometer,
                'vin'            => $obj->vin,
                'fuel_type'      => $obj->fuel_type,
                'drivetrain'     => $obj->drive_train,
                'msrp'           => $obj->msrp,
                'url'            => "https://www.ponokachrysler.com/vehicles/" . strtolower($obj->year) . '/' . strtolower($obj->make) . '/' . strtolower(str_replace(" ", "-", trim($obj->model))) . '/ponoka/ab/' . strtolower($obj->ad_id),
                'exterior_color' => $obj->exterior_color,
                'interior_color' => $obj->interior_color,
                'all_images'     => $obj->image->image_original,
                'title'          => $obj->year . ' ' . $obj->make . ' ' . $obj->model,
            );

            $to_return[] = $car_data;
        }

        return $to_return;
    },

    'images_regx'         => '/image_lg":"(?<img_url>[^"]+)/',
);

add_filter("filter_ponokachryslercom_field_images", "filter_ponokachryslercom_field_images", 10, 2);
function filter_ponokachryslercom_field_images($im_urls, $car_data)
{
    $retval = [];
    $ignore = "https://www.ponokachrysler.com/vehicles/" . strtolower($car_data['year']) . "/" . strtolower($car_data['make']) . "/" . strtolower(str_replace(" ", "-", trim($car_data['model']))) . "/ponoka/ab/";

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace([$ignore, '-1024x786', '\\'], ['', '', ''], rawurldecode($im_url));
    }

    return $retval;
}