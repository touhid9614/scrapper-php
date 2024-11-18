<?php

global $scrapper_configs;
$scrapper_configs["liahondaofalbanycom"] = array(
    "entry_points" => array(
        'used' => array(
            'https://www.liahondaofalbany.com/inventory/used?locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/cpo?locations=lia_honda_albany',
        ),
        'new' => array(
            'https://www.liahondaofalbany.com/inventory/new/honda/cr-v?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/hr-v?years=2023&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/pilot?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/passport?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/accord-sedan?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/ridgeline?years=2023&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/civic-sedan?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/ridgeline?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/cr-v-hybrid?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/civic-si?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/accord-hybrid?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/civic-hatchback?years=2022&instock=true&intransit=true&locations=lia_honda_albany',
            'https://www.liahondaofalbany.com/inventory/new/honda/odyssey?years=2023&instock=true&intransit=true&locations=lia_honda_albany',

        ),
    ),
    'use-proxy' => true,
    'refine'    => false,
    'vdp_url_regex' => '/\/viewdetails\//i',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev'], 
    'details_start_tag' => 'website-primary-header position-fixed',
    'details_end_tag' => 'class="footer bgcolor-primary',
    'details_spliter' => 'standard-inventory',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*target="_self"/',
        'price' => '/(?:MSRP|Our Price)[^>]+>[^>]+>(?<price>[^<]+)/',
        'year' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'make' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'model' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'vin' => '/VIN:[^>]+>\s*<div\s*class="vin[^>]+>[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^\s*]+)/',
        'all_images' => '/<img src="(?<all_images>[^"]+)"[^=]+=[^=]+=[^\s*]+[^\s*]+\s*[^\s*]+\s*title/'
    ),
    'data_capture_regx_full' => array(
        //this custom is for VDP account ID. We are picking images from api. so the account id may vary from each other.
        //thats why I have taken vdp account id.
        'custom' => '/vdpAccountId = \'(?<custom>[^\']+)/',
        'body_style' => '/body_style:\s*\'(?<body_style>[^\']+)/',
        'transmission' => '/transmission:\s*\'(?<transmission>[^\']+)/',
        'exterior_color' => '/exterior_color:\s*\'(?<exterior_color>[^\']+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/stockNumber\s*=\s*\'(?<stock_number>[^\']+)/',
    ),
    'next_page_regx' => '/_text_color theme-text-color" href="(?<next>[^"]+)"\s*rel="next">/',
     'images_regx' => '/<a itemprop="url" href="(?<img_url>[^"]+)/',
);

    add_filter('filter_liahondaofalbanycom_car_data', 'filter_liahondaofalbanycom_car_data');

function filter_liahondaofalbanycom_car_data($car_data) {
  
    if (true) {
        $api_url = "https://www.liahondaofalbany.com/api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID={$car_data['custom']}"."&enableNewImageRules=true&vin={$car_data['vin']}";
        slecho("vdpaccountID:" . $car_data['custom']);
        slecho("api url:" . $api_url);
        $response_data = HttpGet($api_url, true, true);

        if ($response_data) {
            $obj = json_decode($response_data);
            $car_data['all_images']= implode("|",$obj->showAllList);
        }
    }
    return $car_data;
}
/*
add_filter("filter_liahondaofalbanycom_field_images", "filter_liahondaofalbanycom_field_images", 10, 2);

function filter_liahondaofalbanycom_field_images($im_urls, $car_data)
{
    if (true) {
        $api_url = "https://www.liahondaofalbany.com/api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID={$car_data['custom']}"."&enableNewImageRules=true&vin={$car_data['vin']}";
        slecho("vdpaccountID" . $car_data['custom']);
        slecho("api url:" . $api_url);
        $response_data = HttpGet($api_url, true, true);

        if ($response_data) {
            $obj = json_decode($response_data);
            return $obj->showAllList;
        }
    }
}
*/