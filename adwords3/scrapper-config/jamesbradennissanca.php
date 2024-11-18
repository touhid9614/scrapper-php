<?php

global $scrapper_configs;

$scrapper_configs["jamesbradennissanca"] = array(
    "entry_points"        => array(
        'new' => 'https://jamesbradennissan.ca/new-inventory/',
    ),

    'vdp_url_regex'       => '/\/view\/(?:new|used)-/',
    'use-proxy'           => true,

    'picture_selectors'   => ['.detail-feature-thumb'],
    'picture_nexts'       => ['.lb-next'],
    'picture_prevs'       => ['.lb-prev'],

    'custom_data_capture' => function ($entry_url, $resp_data) {
        $url          = 'https://jamesbradennissan.ca/wp-admin/admin-ajax.php';
        $in_cookies   = '';
        $out_cookies  = '';
        $use_proxy    = true;
        $random_proxy = true;
        $content_type = 'application/x-www-form-urlencoded;';
        $post_data    = 'params%5Byear%5D=all&params%5Bmake%5D=all&params%5Bmodel%5D=all&params%5Btrim%5D=all&params%5Bprice%5D=all&params%5Bmileage%5D=all&params%5Btype%5D=all&params%5Bstatus%5D=all&params%5Btags%5D=all&params%5Bstock%5D=all&params%5Bfilter%5D=true&params%5Blimit%5D=0&params%5Bsort_by%5D=year&params%5Bsort_by_condition%5D=desc&params%5Bflags%5D=none&params%5Blayout%5D=normal&action=get_leadbox_inventory_from_child';

        $resp           = HttpPost($url, $post_data, $in_cookies, $out_cookies, $use_proxy, $random_proxy, $content_type);
        $objects        = json_decode($resp);
        $objects_decode = json_decode($objects->data);
        $to_return      = [];

        foreach ($objects_decode as $key => $obj) {
            $car = [
                'url'            => 'https://jamesbradennissan.ca/view/' . strtolower($obj->condition) . '-' . $obj->year . '-' . $obj->make . '-' . $obj->model . '-' . $obj->id,
                'vin'            => $obj->vin,
                'stock_number'   => $obj->stocknumber,
                'stock_type'     => strtolower($obj->condition),
                'year'           => $obj->year,
                'make'           => $obj->make,
                'model'          => $obj->model,
                'trim'           => $obj->trim,
                'body_style'     => $obj->type,
                'transmission'   => $obj->transmission,
                'engine'         => $obj->engine,
                'drivetrain'     => $obj->drivetrain,
                'exterior_color' => $obj->exteriorcolor,
                'kilometres'     => $obj->mileage,
                'certified'      => $obj->certified,
                'price'          => $obj->price,
            ];

            $img_urls     = [];
            $base_img_raw = explode("?", str_replace('\/', '/', $obj->picture), 2);
            $base_img_url = $base_img_raw[0];

            if (!empty($base_img_url)) {
                $img_urls[] = 'https:' . $base_img_url;
            }

            $picture_seeds = explode(",", $obj->picturesids);
            $car['custom'] = $obj->picturesids;

            $reg   = '/\/(?<base_id>[0-9]{8})-XXL/';
            $match = [];

            preg_match($reg, $base_img_url, $match);
            $base_id = $match['base_id'];

            foreach ($picture_seeds as $imgId) {
                $new_img = str_replace($base_id, $imgId, $base_img_url);

                if (!empty($new_img)) {
                    $img_urls[] = 'https:' . $new_img;
                }
            }

            $car['all_images'] = implode("|", $img_urls);

            $to_return[] = $car;
        }

        return $to_return;
    }
);