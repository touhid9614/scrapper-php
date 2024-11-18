<?php
global $scrapper_configs;
$scrapper_configs["oreganssubarucom"] = array(
    "entry_points" => array(
        'new' => 'https://oserv2.oreganscdn.com/api/vehicle-inventory-search/?search.vehicle-make-ids[]=42&search.vehicle-inventory-type-ids=1&do-search=1&search.results-offset=0&search.results-limit=50&app.referrer=https://www.oreganssubaru.com',
        'used' => 'https://www.oreganssubaru.com/used-cars/?search.location.id=32&search.start-index=0&do-search=1&advanced=&system.view-type.code=ajax',
    ),
    'vdp_url_regex' => '/\/(?:pre-owned|new|used-cars|New).*[0-9]{4}-/',
    'new' => array(
        'vdp_url_regex' => '/\/New-[0-9]{4}-/',
        'use-proxy' => true,
        'picture_selectors' => ['.imgRenImage'],
        'picture_nexts' => ['.ovmpwNextButton'],
        'picture_prevs' => ['.ovmpwPreviousButton'],
        'details_start_tag' => '"results":',
        'details_end_tag' => '}]}}',
        'details_spliter' => '"vehicle":',
        'data_capture_regx' => array(
            'stock_number' => '/Stock #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'year' => '/"ouvsrYear[^"]+">(?<year>[0-9]{4})/',
            'make' => '/ouvsrMake[^"]+">(?<make>[^<]+)/',
            'model' => '/ouvsrModel[^"]+">(?<model>[^<]+)/',
            'trim' => '/ouvsrTrim[^"]+">(?<trim>[^<]+)/',
            'price' => '/ouvsrCurrentPrice[^"]+">(?<price>\$[0-9,]+)/',
            'body_style' => '/ouvsrTrim[^"]+">(?<body_style>[^<]+)/',
            'transmission' => '/Transmission[^>]+><span class=[^"]+"ouvsrValue[^"]+">(?<transmission>[^<]+)/',
            'exterior_color' => '/ouvsrColorName[^"]+">(?<exterior_color>[^<]+)/',
            'url' => '/ouvsrHeading[^"]+"><a href=[^"]+"(?<url>[^"]+)/',
            'vin' => '/VIN[^>]+><span class=[^"]+"ouvsrValue[^"]+">(?<vin>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
        ),
        'next_page_regx' => '/"results":[^"]+"(?<next>[^"]+)/',
        'images_regx' => '/<li data-thumb="[^"]+"> <img src="(?<img_url>[^"]+)"/',
    ),
    'used' => array(
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
                    'url' => "https://www.oreganssubaru.com/used-cars/{$obj->year}-{$obj->vehicleMake->name}-{$obj->vehicleMakeModel->name}-"
                    . str_replace([" ",], ["-"], preg_replace('/[^A-Za-z0-9\-(?=\s)]/', '', $obj->trim)) . "-{$obj->id}",
                    'description' => $obj->shortDescription,
                );

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/vehicles":[^"]+"id"(?<next>[^"]+)/',
        'images_regx' => '/data-src="(?<img_url>\/\/cdn.dealerspike.com\/imglib\/[^"]+)/'
    ),
);
add_filter('filter_oreganssubarucom_car_data', 'filter_oreganssubarucom_car_data');
add_filter("filter_oreganssubarucom_next_page", "filter_oreganssubarucom_next_page", 10, 2);

function filter_oreganssubarucom_car_data($car_data) {

    if ($car_data['make'] != 'Subaru') {
        return [];
    }
    $car_data['url'] = str_replace(['\\', " "], ['', '-'], $car_data['url']);

    if ($car_data['stock_type'] == 'new') {
        $car_data['url'] = preg_replace('/http(s)?:.*(?=http)/', '', $car_data['url'], -1);
        $car_data['url'] = str_replace('https://', 'https://www.oreganssubaru.com', $car_data['url']);
          $car_data['svin']=url_to_svin($car_data['url']);
        slecho("vehicles  usl:: " . $car_data['url']);
    }
    $im_urls = [];

    if (isset($car_data['vin']) && $car_data['vin']) {

        $api_url = "https://oserv2.oreganscdn.com/api/vehicle-photos/";
        $post_data = "json=%7B%22items%22%3A%5B%7B%22vehicleVins%22%3A%5B%22" . $car_data['vin'] . "%22%5D%2C%22id%22%3A1%7D%5D%7D%0A%0A";

        slecho("post_data: " . $post_data);
        $in_cookies = '';
        $out_cookies = '';
        $response_data = HttpPost($api_url, $post_data, $in_cookies, $out_cookies, false, true, 'application/x-www-form-urlencoded', ['origin' => 'https://www.oreganssubaru.com']);
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
    
    if ($car_data['vin']=='4S4BTDDC0L3205084') {
        $car_data['all_images']='https://oserv2.oreganscdn.com/thumbor/SK3IWkJEO5LQTQ_4dnrcB0EpQW8=/trim/fit-in/339x/filters:no_upscale():fill(white,true):format(jpeg)/oserv2.oreganscdn.com/files/provider-photos/4/b241080c38a3fa00e0da64fdefa113522c4ad9c2.png';
    }
    
    if ($car_data['vin']=='4S3BWDD66L3020043') {
        $car_data['all_images']='https://oserv2.oreganscdn.com/thumbor/aHnO0pdypdFNCK9gkkVaL-WDVCU=/trim/fit-in/339x/filters:no_upscale():fill(white,true):format(jpeg)/oserv2.oreganscdn.com/files/provider-photos/4/c9b75de5bf2b014345a06a890e895d61fe024899.png';
    }
    
    if ($car_data['vin']=='4S3GKAG68L3607176') {
        $car_data['all_images']='https://oserv2.oreganscdn.com/thumbor/TjV-DbA-bBaggA4OnZKZf6FTO7A=/trim/fit-in/339x/filters:no_upscale():fill(white,true):format(jpeg)/oserv2.oreganscdn.com/files/provider-photos/4/651a7b233c8565e030fc0ea4121198ba75688ee3.png';
    }
    if ($car_data['vin']=='4S4BTDAC5L3118690') {
        $car_data['all_images']='https://oserv2.oreganscdn.com/thumbor/WCNn-VpAH3Exe0ZsCqdEI2v0eTI=/trim/fit-in/339x/filters:no_upscale():fill(white,true):format(jpeg)/oserv2.oreganscdn.com/files/provider-photos/4/7aab7fe2aaa167ac60d1158358fe08b08be47417.png';
    }
     if ($car_data['vin']=='4S3BWDA64L3014696') {
        $car_data['all_images']='https://oserv2.oreganscdn.com/thumbor/ccNa7HmgMqW7XLMutpoVMRe0oQY=/trim/fit-in/339x/filters:no_upscale():fill(white,true):format(jpeg)/oserv2.oreganscdn.com/files/provider-photos/4/610f12878da19f216d23673c18b859a7fa5b25a5.png';
    }
     if ($car_data['vin']=='JF2SKEFC8LH424583') {
        $car_data['all_images']='https://oserv2.oreganscdn.com/thumbor/N6hCbsg7y-_e7qyWjEjnQKf7flI=/trim/fit-in/339x/filters:no_upscale():fill(white,true):format(jpeg)/oserv2.oreganscdn.com/files/provider-photos/4/de6da2535e3c77dfbd364b927a671fa2c44c0f7b.png';
    }
     
    return $car_data;
}

function filter_oreganssubarucom_next_page($next, $current_page) {

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
