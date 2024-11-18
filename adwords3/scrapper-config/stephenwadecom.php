<?php

global $scrapper_configs;

$scrapper_configs["stephenwadecom"] = array(
    'entry_points'        => array(
        'all' => 'https://assets.stephenwade.com/node-server-test/autos/',
    ),

    'vdp_url_regex'       => '/\/vehicles\/inventory-/',
    'srp_page_regex'      => '/vehicles\/(?:new|used)\//i',
    'refine'              => false,
    'use-proxy'           => true,

    'init_method'         => 'POST',
    'next_method'         => 'POST',

    'picture_selectors'   => ['.thumbnails__single'],
    'picture_nexts'       => ['button.modal-slideshow__next'],
    'picture_prevs'       => ['button.modal-slideshow__prev'],

    'required_params'     => ['sid'],

    'custom_data_capture' => function ($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            return [];
        }

        $to_return = [];

        foreach ($objects->vehicles as $obj) {
            $car_data = array(
                'stock_number' => $obj->stock_num,
                'year'         => $obj->year,
                'stock_type'   => strtolower($obj->nu),
                'make'         => $obj->make,
                'model'        => $obj->model,
                'price'        => $obj->InternetPrice,
                'kilometres'   => $obj->miles,
                'vin'          => $obj->VIN,
                'transmission' => $obj->Transmission_Description,
                'engine'       => $obj->Engine_Description,
                'custom'       => $obj->Series,
                'url'          => strtolower("https://www.stephenwade.com/vehicles/inventory-listing.php?" . 'sid=' . $obj->stock_num . "&vehicle=" . $obj->stock_num . '-' . $obj->year . '-' . $obj->make . '-' . mild_url_encode($obj->model) . '-' . $obj->custom . '-for-sale-st-george'),
                // 'url'          => strtolower("https://www.stephenwade.com/vehicles/inventory-listing.php?" . 'sid=' . $obj->stock_num),
               // 'all_images'   => $obj->PhotoURLs,
            );

            $to_return[] = $car_data;
        }
        return $to_return;
    },
);

add_filter('filter_stephenwadecom_post_data', 'filter_stephenwadecom_post_data', 10, 2);

function filter_stephenwadecom_post_data($post_data, $stock_type)
{
    $post_data_params = [
        'start'         => 0,
        'end'           => 2000,
        'initials'      => [],
        'makes'         => [],
        'models'        => [],
        'years'         => [],
        'trims'         => [],
        'bodyStyles'    => [],
        'transmissions' => [],
        'features'      => [],
        'fuelType'      => [],
        'color'         => [],
        'priceMin'      => 0,
        'priceMax'      => 200000,
        'mileageMin'    => 0,
        'mileageMax'    => 200000,
        'mpgMin'        => 0,
        'mpgMax'        => 100,
        'new'           => false,
        'used'          => false,
        'certified'     => false,
        'redTagSale'    => false,
        'searchQuery'   => null,
        'orderBy'       => "Default",
    ];

    $post_data_arr = [];

    foreach ($post_data_params as $key => $val) {
        $post_data_arr[] = $key . '=' . rawurlencode(json_encode($val));
    }

    $post_data = implode("&", $post_data_arr);

    return $post_data;
}


add_filter('filter_stephenwadecom_car_data', 'filter_stephenwadecom_car_data');

function filter_stephenwadecom_car_data($car_data)
{
    $img_api_url        = "https://assets.stephenwade.com/node-server-test/vehicles/VDP/" . trim($car_data['stock_number']);
    $useProxy           = true;
    $random_proxy       = true;
    $in_cookies         = '';
    $out_cookies        = '';
    $content_type       = 'application/json';
    $additional_headers = ['Origin' => 'https://www.stephenwade.com'];
    $annoy_func         = null;

    $img_api_resp = HttpGet($img_api_url, $useProxy, $random_proxy, $in_cookies, $out_cookies, $content_type, $additional_headers, $annoy_func);

    if ($img_api_resp) {
        $img_api_resp = json_decode($img_api_resp);
        $images_cat   = $img_api_resp->PhotoURLs;

        /*$images_arr = explode(",", $images_cat);
        $car_data['images'] = $images_arr;
        $car_data['all_images'] = implode("|", $images_arr);*/

        $car_data['all_images'] = str_replace(",", "|", $images_cat);
    }

    if (strtolower($car_data['stock_type']) == 'new') {
        $images = explode("|", $car_data['all_images']);

        foreach ($images as $index => $img) {
            if (startsWith($img, 'https://content.homenetiol.com/2000078/2063085/762x508/stock_images/')) {
                unset($images[$index]);
            }
        }

        $car_data['all_images'] = implode("|", $images);
    }

    return $car_data;
}
