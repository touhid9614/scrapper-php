<?php

global $scrapper_configs;
$scrapper_configs["oreganstoyotadartmouthcom"] = array(
    'entry_points' => array(
        'used' => 'https://oserv1.oreganscdn.com/api/vehicle-inventory-search/?search.vehicle-inventory-type-ids.0=2&search.vehicle-make-ids.0=45&do-search=1&search.results-offset=0&search.results-limit=50&app.referrer=https%3A%2F%2Foreganstoyotadartmouth.com',
        'new'  => 'https://oserv1.oreganscdn.com/api/vehicle-inventory-search/?search.vehicle-make-ids[]=45&search.vehicle-inventory-type-ids=1&do-search=1&search.results-offset=0&search.results-limit=50&app.referrer=https://oreganstoyotadartmouth.com',
    ),
    'vdp_url_regex' => '/inventory\/(?:pre-owned|New|Used)-[0-9]{4}-/',

        
        'use-proxy' => true,
         'refine'=>false,
        'picture_selectors' => ['.imgRenImage'],
        'picture_nexts' => ['#cboxNext'],
        'picture_prevs' => ['#cboxPrevious'],
        'details_start_tag' => '"results":',
        'details_end_tag' => '}]}}',
        'details_spliter' => '"vehicle":',
        'data_capture_regx' => array(
            'stock_number' => '/ouvsrShortLabel[^"]+">[^>]+>(?<stock_number>[^<]+)/',
            'year' => '/"ouvsrYear[^"]+">(?<year>[0-9]{4})/',
            'make' => '/ouvsrMake[^"]+">(?<make>[^<]+)/',
            'model' => '/ouvsrModel[^"]+">(?<model>[^<]+)/',
            'trim' => '/ouvsrTrim[^"]+">(?<trim>[^<]+)/',
            'price' => '/ouvsrCurrentPrice[^"]+">(?<price>\$[0-9,]+)/',
            'body_style' => '/ouvsrTrim[^"]+">(?<body_style>[^<]+)/',
            'transmission' => '/Transmission[^>]+><span class=[^"]+"ouvsrValue[^"]+">(?<transmission>[^<]+)/',
            'exterior_color' => '/ouvsrColorName[^"]+">(?<exterior_color>[^<]+)/',
            'url' => '/ouvsrHeading[^"]+"><a href=[^"]+"(?<url>[^"]+)/',
            'vin' => '/vin=(?<vin>[^"]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'next_page_regx' => '/"results":[^"]+"(?<next>[^"]+)/',
        'images_regx' => '/<li data-thumb="[^"]+"> <img src="(?<img_url>[^"]+)"/',
    
    
);
add_filter('filter_oreganstoyotadartmouthcom_car_data', 'filter_oreganstoyotadartmouthcom_car_data');
add_filter("filter_oreganstoyotadartmouthcom_next_page", "filter_oreganstoyotadartmouthcom_next_page", 10, 2);

function filter_oreganstoyotadartmouthcom_car_data($car_data) {

    if ($car_data['make'] != 'Toyota') {
        return [];
    }
    $car_data['url'] = str_replace(['\\', " "], ['', '-'], $car_data['url']);
    $car_data['vin'] = str_replace('\\', '', $car_data['vin']);

        $car_data['url'] = preg_replace('/http(s)?:.*(?=\/inventory)/', '', $car_data['url'], -1);
        $car_data['url'] = 'https://www.oreganstoyotadartmouth.com' . $car_data['url'];
        $car_data['svin'] = url_to_svin($car_data['url']);
        slecho("vehicles  usl:: " . $car_data['url']);
    
    $im_urls = [];

    if (isset($car_data['vin']) && $car_data['vin']) {

        $api_url = "https://oserv1.oreganscdn.com/api/vehicle-media/";
 
       $post_data = "json=%7B%22items%22%3A%5B%7B%22imageWidth%22%3A1000%2C%22includeVideoMedia%22%3Atrue%2C%22vehicleId%22%3Anull%2C%22vehicleVin%22%3A%22" . $car_data['vin'] . "%22%2C%22vehicleStockNumber%22%3Anull%2C%22vehicleTrimGid%22%3Anull%2C%22vehicleColorGid%22%3Anull%2C%22vehicleModelYearId%22%3Anull%2C%22exactMatch%22%3Atrue%2C%22id%22%3A1%7D%5D%7D%0A%0A";
             
     
       //slecho("post_data: " . $post_data);
        $in_cookies = '';
        $out_cookies = '';
        $response_data = HttpPost($api_url, $post_data, $in_cookies, $out_cookies, false, true, 'application/x-www-form-urlencoded', ['origin' => 'https://oreganstoyotadartmouth.com']);
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

function filter_oreganstoyotadartmouthcom_next_page($next, $current_page) {

    
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
    

    return $next;
}
