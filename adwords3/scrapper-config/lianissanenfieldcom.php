<?php
global $scrapper_configs;
$scrapper_configs["lianissanenfieldcom"] = array( 
 "entry_points" => array(
            'used' => 'https://www.lianissanenfield.com/inventory/used?locations=lia_nissan_of_enfield&instock=true&intransit=true',

            'new' => array(
                'https://www.lianissanenfield.com/inventory/new/nissan/sentra?years=2022&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/kicks?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/rogue?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/rogue-sport?years=2022&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/frontier?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/murano?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/pathfinder?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/maxima?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/ariya?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/titan?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
                'https://www.lianissanenfield.com/inventory/new/nissan/armada?years=2023&locations=lia_nissan_of_enfield&instock=true&intransit=true',
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
    'details_spliter' => 'class="standard-inventory',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*target="_self"/',
        'price' => '/(?:MSRP|Our Price)[^>]+>(?<price>\$[0-9,]+)/',
        'year' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'make' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'model' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'vin' => '/VIN:[^>]+>\s*<div\s*class="vin[^>]+>[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^\s*]+)/',
        'all_images' => '/<img src="(?<all_images>[^"]+)"[^=]+=[^=]+=[^\s*]+[^\s*]+\s*[^\s*]+\s*title/',
        //custom is already in use. As discount will be shown as description thats why I am scraping discount as description.
        'description' => '/Dealer Discount\s*(?<description>[^<]+)/',
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

add_filter('filter_lianissanenfieldcom_car_data', 'filter_lianissanenfieldcom_car_data');
function filter_lianissanenfieldcom_car_data($car_data) {

    if($car_data['description'] != NULL){
        $car_data['description'] = $car_data['description'];
    }
    else{
        $car_data['description'] = "$0";
    }

    if (true) {
        $api_url = "https://www.lianissanenfield.com/api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID={$car_data['custom']}"."&enableNewImageRules=true&vin={$car_data['vin']}";
        slecho("vdpaccountID:" . $car_data['custom']);
        slecho("api url:" . $api_url);
        $response_data = HttpGet($api_url, true, true);

        if ($response_data) {
            $obj = json_decode($response_data);
            $car_data['all_images']= implode("|",$obj->galleryList);
        }
    }
    return $car_data;
}