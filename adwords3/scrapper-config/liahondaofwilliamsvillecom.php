<?php

global $scrapper_configs;
$scrapper_configs["liahondaofwilliamsvillecom"] = array(
    "entry_points" => array(
        'used' => array(
            'https://www.liahondaofwilliamsville.com/inventory/used?locations=lia_honda_williamsville&instock=true&intransit=true',
        ),
        'new' => array(
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/cr-v?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/cr-v-hybrid?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/civic-sedan?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/hr-v?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/accord-sedan?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/accord-hybrid?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/ridgeline?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/odyssey?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/passport?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/pilot?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/civic-hatchback?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/accord-sedan?years=2022&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/civic-si?years=2023&instock=true&intransit=true',
            'https://www.liahondaofwilliamsville.com/inventory/new/honda/pilot?years=2022&instock=true&intransit=true',
        ),
    ),
    'use-proxy' => true,
    'proxy-area' => 'CA',
    'refine' => false,
    'vdp_url_regex' => '/\/viewdetails\//i',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev'],
    'details_start_tag' => 'website-primary-header position-fixed',
    'details_end_tag' => 'class="footer bgcolor-primary',
    'details_spliter' => 'class="inventory-car-parent-box',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*target="_self"/',
        // 'msrp'  => '/MSRP<\/div>[^>]+>(?<msrp>[^<]+)/',
        // 'price' => '/(?:J\.D\. Power Book|)[^"]+"[^"]+"[^"]+"[^"]+"[^"]+"color[^"]+"[^"]+""[^"]+"[^"]+">(?<price>[^<]+)/',
        'year' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'make' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'model' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'vin' => '/VIN:[^>]+>\s*<div\s*class="vin[^>]+>[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^\s*]+)/',
        'custom_number_0' => '/Dealer Discount\s*(?<custom_number_0>[^<]+)/',
        'custom' => '/Dealer Discount\s*(?<custom>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_type' => '/com\/viewdetails\/(?<sstock_type>[^\/]+)/',
        //this custom is for VDP account ID. We are picking images from api. so the account id may vary from each other.
        //thats why I have taken vdp account id.
        'custom_1' => '/vdpAccountId = \'(?<custom_1>[^\']+)/',
        'body_style' => '/body_style:\s*\'(?<body_style>[^\']+)/',
        'transmission' => '/transmission:\s*\'(?<transmission>[^\']+)/',
        'exterior_color' => '/exterior_color:\s*\'(?<exterior_color>[^\']+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/stockNumber\s*=\s*\'(?<stock_number>[^\']+)/',
    ),
    'next_page_regx' => '/_text_color theme-text-color" href="(?<next>[^"]+)"\s*rel="next">/',
    'images_regx' => '/<a itemprop="url" href="(?<img_url>[^"]+)/',
);

add_filter('filter_liahondaofwilliamsvillecom_car_data', 'filter_liahondaofwilliamsvillecom_car_data');

function filter_liahondaofwilliamsvillecom_car_data($car_data) {

    if (true) {
        $api_url = "https://www.liahondaofwilliamsville.com/api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID={$car_data['custom_1']}" . "&enableNewImageRules=true&vin={$car_data['vin']}";
        slecho("vdpaccountID:" . $car_data['custom_1']);
        slecho("api url:" . $api_url);
        $response_data = HttpGet($api_url, true, true);
        if ($response_data) {
            $obj = json_decode($response_data);
            $car_data['all_images'] = implode("|", $obj->showAllList);
            if (strpos($car_data['all_images'], "images/GetEvoxImage") || strpos($car_data['all_images'], "stock_images/")) {
                $car_data['all_images'] = "";
            }
        }
    }

    //pulling price and msrp from here. because in regex its colflicting between new and use price
    if (true) {
        $price_api = "https://www.liahondaofwilliamsville.com/api/Inventory/vehicle?vin={$car_data['vin']}";
        slecho("API URL: " . $price_api);
        sleep(3);
        $response_data = HttpGet($price_api, true, true);
        $first_res_data = json_decode($response_data);

        if ($first_res_data->sellingPrice == NULL || $first_res_data->sellingPrice == "") {
            for ($try = 0; $try <= 3; $try++) {
                sleep(3);
                $response_data = HttpGet($price_api, true, true);
                $try_response_obj = json_decode($response_data);
                if ($try_response_obj->make != NULL || $try_response_obj->make != "") {
                    break;
                }
            }
        }
        if ($response_data) {
            $car_obj = json_decode($response_data);
            $car_data['price'] = $car_obj->sellingPrice;
            $car_data['msrp'] = $car_obj->msrp;
        }
    }
    if ($car_data['custom'] != NULL) {
        $car_data['custom'] = $car_data['custom'];
    } else {
        $car_data['custom'] = "$0";
    }
    return $car_data;
}

add_filter("filter_liahondaofwilliamsvillecom_field_body_style", "filter_liahondaofwilliamsvillecom_field_body_style");

function filter_liahondaofwilliamsvillecom_field_body_style($body_style) {
    if ($body_style == "4dr Car") {
        $body_style = "SEDAN";
    } else if ($body_style == "Crew Cab Pickup") {
        $body_style = "TRUCK";
    } else if ($body_style == "Extended Cab Pickup") {
        $body_style = "TRUCK";
    } else if ($body_style == "Hatchback") {
        $body_style = "HATCHBACK";
    } else if ($body_style == "Mini-van, Passenger") {
        $body_style = "MINIVAN";
    } else if ($body_style == "Sport Utility") {
        $body_style = "SUV";
    } else if ($body_style == "2dr Car") {
        $body_style = "SEDAN";
    } else {
        $body_style = "OTHER";
    }

    return $body_style;
}

add_filter("filter_liahondaofwilliamsvillecom_field_price", "filter_liahondaofwilliamsvillecom_field_price", 10, 3);

function filter_liahondaofwilliamsvillecom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
    }

    $msrp_regex = '/MSRP<\/div>[^>]+>(?<price>[^<]+)/';
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    return $price;
}
