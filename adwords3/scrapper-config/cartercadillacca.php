<?php

global $scrapper_configs;

$scrapper_configs['cartercadillacca'] = array(
    'entry_points' => array(
        'new' => 'https://search.foxdealer.com/api/vehicle/search?filters%5Btype%5D=new&filters%5Bref%5D=%2Finventory%2FNew&filters%5Bordering%5D=display_price-asc&domain=www.cartercadillac.ca&per_page=200&offset=0',
        'used' => 'https://search.foxdealer.com/api/vehicle/search?filters%5Btype%5D=used&filters%5Bref%5D=%2Finventory%2FUsed&filters%5Bordering%5D=display_price-asc&domain=www.cartercadillac.ca&per_page=200&offset=0'
        ),
    'vdp_url_regex' => '/\/inventory\/(?:new|used|certified-used)-[0-9]{4}-/',
    'use-proxy' => true,
    'refine' => false,
    'init_method' => 'GET',
    'next_method' => 'POST',
    'content_type' => 'application/json',
    'custom_data_capture' => function($url, $data) {

        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return array();
        }

        $to_return = array();

        foreach ($objects->data->hits as $obj) {

            $car_data = array(
                'stock_number' => $obj->stock ? $obj->stock : $obj->vin,
                'stock_type' => strtolower($obj->type),
                'year' => $obj->year,
                'make' => $obj->make,
                'model' => $obj->model,
                'trim' => $obj->trim,
                'body_style' => $obj->body,
                'price' => $obj->display_price,
                'engine' => $obj->engine_description,
                'transmission' => $obj->transmission_description,
                'kilometres' => $obj->miles,
                'vin' => $obj->vin,
                'fuel_type' => $obj->fueltype,
                'drivetrain' => $obj->drivetrain,
                'msrp' => $obj->msrp,
                'url' => "https://www.cartercadillac.ca".$obj->permalink,
                'exterior_color' => $obj->ext_color,
                'interior_color' => $obj->int_color,
                'all_images' => $obj->imagelist[0]->url,
            );



            $to_return[] = $car_data;
        }

        return $to_return;
    },
    'images_regx' => '/class="swiper-slide">\s*<img class="swiper-lazy" data-src="(?<img_url>[^"]+)"/',
);

add_filter('filter_cartercadillacca_post_data', 'filter_cartercadillacca_post_data', 10, 2);

function filter_cartercadillacca_post_data($post_data, $stock_type) {
    if ($stock_type == 'new') {
    $post_data = 'filters%5Btype%5D=new&filters%5Bref%5D=%2Finventory%2FNew&filters%5Bordering%5D=display_price-asc&domain=www.cartercadillac.ca&per_page=1000&offset=0';}
    elseif ($stock_type == 'used') {
        $post_data = 'filters%5Btype%5D=used&filters%5Bref%5D=%2Finventory%2FUsed&filters%5Bordering%5D=display_price-asc&domain=www.cartercadillac.ca&per_page=1000&offset=0';}

    return $post_data;
}