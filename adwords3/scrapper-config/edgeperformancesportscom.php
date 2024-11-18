<?php

global $scrapper_configs;
$scrapper_configs["edgeperformancesportscom"] = array(
    'entry_points' => array(
        'used' => 'https://staging.psxdigital.com/powersports-marketing-automation/experience/get/units',
        'new'  => 'https://staging.psxdigital.com/powersports-marketing-automation/experience/get/units',
    ),
    'vdp_url_regex' => '/\/product-page\/[0-9]{4}/',
    'use-proxy' => true,
    'content_type' => 'application/x-www-form-urlencoded; charset=UTF-8',
    'init_method' => 'POST',
    'next_method' => 'POST',
    'additional_headers' => array(
        "Content-Length" => "187",
        "Authorization" => "ktVR33l73VJgD-82uMEilvqEbSwA31g3Yg2xj7GfnZU.eyJpbnN0YW5jZUlkIjoiMWEyODkyNjEtNGYyMi00Y2YyLWI5ZDQtMWIzYmYxNGU4OTc4IiwiYXBwRGVmSWQiOiIxMzgwYjcwMy1jZTgxLWZmMDUtZjExNS0zOTU3MWQ5NGRmY2QiLCJtZXRhU2l0ZUlkIjoiMzY2ZDhjODAtMTBlMS00ZGJkLThlNmMtZTZjZDBmMzI2ZjQzIiwic2lnbkRhdGUiOiIyMDIwLTAyLTI3VDEwOjEwOjE0LjM4OVoiLCJkZW1vTW9kZSI6ZmFsc2UsImFpZCI6IjY5MGM3YTEzLWJkZDMtNGZhYi04OTM0LWNlMDZjODNhZmFjOCIsImJpVG9rZW4iOiIyYzQ1MWVlMS01ZmMzLTAxNGYtMzdiOC1mZGY2ZmU3Y2U2M2IiLCJzaXRlT3duZXJJZCI6IjA2NWRkMTJlLWNiZWYtNDllMi1iYmU3LTAzMjg5NDc5OTIyMyJ9",
    ),
    'picture_selectors' => ['.thumbnails__single'],
    'picture_nexts' => ['button.modal-slideshow__next'],
    'picture_prevs' => ['button.modal-slideshow__prev'],
    'custom_data_capture' => function($url, $data) {
        $objects = json_decode($data);

        if (!$objects) {
            slecho($data);
            return array();
        }


        $to_return = array();
        
        foreach ($objects->units->data as $obj) {
            
            $retval = [];
            $car_data = array(
                'stock_number' => $obj->cdk_vehicle->stock_number,
                'year' => $obj->vehicle_year,
                'make' => $obj->vehicle_make,
                'model' => $obj->vehicle_model,
                'price' => $obj->vehicle_price,
                'kilometres' => $obj->vehicle_mileage,
                'vin' => $obj->vehicle_vin,
                'url' =>  $obj->vdp,
                'exterior_color' => $obj->color,
            );
            foreach ($obj->vehicle_photos as $img) {
                $retval[] = $img;
            }
            $car_data['all_images'] = implode("|", $retval);

            $to_return[] = $car_data;
        }
        return $to_return;
    },
    'next_query_regx'   => '/next_page_url[^\?]+\?\s*(?<param>page)=(?<value>[0-9]*)"/',
);

add_filter('filter_edgeperformancesportscom_post_data', 'filter_edgeperformancesportscom_post_data', 10, 2);

function filter_edgeperformancesportscom_post_data($post_data, $stock_type) {
    
    if($post_data == '')
        {
            $post_data = "page=1";
        }
    if ($stock_type == 'used') {
        $post_data = "begin_miles=&begin_price=&category=&down=0&end_miles=&end_price=&make=&model=&new_used=U&$post_data&scope_id=5d2f0e8cbc69d77e1c563ca3&search=&selected_group=0&sort=0&term=72&trim=&type=&year=";
    }
    else{
        $post_data = "begin_miles=&begin_price=&category=&down=0&end_miles=&end_price=&make=&model=&new_used=N&$post_data&scope_id=5d2f0e8cbc69d77e1c563ca3&search=&selected_group=0&sort=0&term=72&trim=&type=&year=";
    }

    return $post_data;
}
