<?php

global $scrapper_configs;
$scrapper_configs["oregansusedcarcentrecom"] = array(
    'entry_points' => array(
        'used' => 'https://www.oregansusedcarcentre.com/used-cars/?search.location.id=2&search.start-index=0&do-search=1&advanced=&system.view-type.code=ajax',
    ),
 
        'vdp_url_regex' => '/\/used-cars\/[0-9]{4}-/',
        'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,
        'picture_selectors' => ['.imgRenImage'],
        'picture_nexts' => ['#cboxNext'],
        'picture_prevs' => ['#cboxPrevious'],
        'custom_data_capture' => function($url, $data) {

            $objects = json_decode($data);

            if (!$objects) {
                slecho($data);
            }

            $to_return = array();

            foreach ($objects->oreg->wuvs->results->vehicles as $obj) {

                $car_data = array(
                    'stock_number' => !empty($obj->id) ? $obj->id : $obj->vinNumber,
                    'vin' => $obj->vinNumber,
                    'year' => $obj->year,
                    'make' => $obj->vehicleMake->name,
                    'model' => $obj->vehicleMakeModel->name,
                    'body_style' => $obj->vehicleType->name,
                    'price' => $obj->currentPrice,
                    'trim' => $obj->trim,
                    'kilometres' => $obj->mileage,
                    'url' => "https://www.oregansusedcarcentre.com/used-cars/{$obj->year}-{$obj->vehicleMake->name}-{$obj->vehicleMakeModel->name}-"
                    . str_replace([" ",], ["-"], preg_replace('/[^A-Za-z0-9\-(?=\s)]/', '', $obj->trim)) . "-{$obj->id}",
                    'description' => $obj->shortDescription,
                );

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/vehicles":[^"]+"id"(?<next>[^"]+)/',
        'images_regx' => '/data-src="(?<img_url>\/\/cdn.dealerspike.com\/imglib\/[^"]+)/'
   
);
add_filter('filter_oregansusedcarcentrecom_car_data', 'filter_oregansusedcarcentrecom_car_data');
add_filter("filter_oregansusedcarcentrecom_next_page", "filter_oregansusedcarcentrecom_next_page", 10, 2);

function filter_oregansusedcarcentrecom_car_data($car_data) {


    $car_data['url'] = str_replace(['\\', " "], ['', '-'], $car_data['url']);

    if ($car_data['stock_type'] == 'new') {
        $car_data['url'] = preg_replace('/http(s)?:.*(?=http)/', '', $car_data['url'], -1);
        $car_data['url'] = str_replace('https://', 'https://www.oregansusedcarcentre.com', $car_data['url']);
        slecho("vehicles  usl:: " . $car_data['url']);
    }
    $im_urls = [];

    if (isset($car_data['vin']) && $car_data['vin']) {

        $api_url = "https://oserv2.oreganscdn.com/api/vehicle-photos/";
        $post_data = "json=%7B%22items%22%3A%5B%7B%22vehicleVins%22%3A%5B%22" . $car_data['vin'] . "%22%5D%2C%22id%22%3A1%7D%5D%7D%0A%0A";

        slecho("post_data: " . $post_data);
        $in_cookies = '';
        $out_cookies = '';
        $response_data = HttpPost($api_url, $post_data, $in_cookies, $out_cookies, false, true, 'application/x-www-form-urlencoded', ['origin' => 'https://www.oregansusedcarcentre.com']);
        //slecho("res:pon:" . $response_data);
        if ($out_cookies) {
            $in_cookies = $out_cookies;
        }
        $regex = '/"sources":[^"]+"url":"(?<img_url>[^"]+)"/';

        $matches = [];


        if (preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value) {
                $im_urls[] = $value;
            }
            //return  $im_urls;
        }
    }
    $car_data['all_images'] = str_replace('\\', '', implode("|", $im_urls));

    return $car_data;
}

function filter_oregansusedcarcentrecom_next_page($next, $current_page) {

    if (strpos($current_page, "used-cars")) {
        $start_tag = 'start-index=';
        $end_tag = '&';

        if (stripos($current_page, $start_tag)) {
            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
        }

        if (strpos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $rep_value = $resp + 10;


        $find = "start-index=" . $resp;
        $rep = "start-index=" . $rep_value;
        $next = str_replace($find, $rep, $current_page);
        slecho($next);
    } else {
        $start_tag = 'results-offset=';
        $end_tag = '&';

        if (stripos($current_page, $start_tag)) {
            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
        }

        if (strpos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $rep_value = $resp + 50;


        $find = "results-offset=" . $resp;
        $rep = "results-offset=" . $rep_value;
        $next = str_replace($find, $rep, $current_page);
        slecho($next);
    }

    return $next;
}