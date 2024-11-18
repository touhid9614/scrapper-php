<?php
global $scrapper_configs;
 $scrapper_configs["lianissansaratogacom"] = array( 
	"entry_points" => array(
        'used' => 'https://www.lianissansaratoga.com/inventory/used?locations=lia_nissan_of_saratoga&instock=true&intransit=true',
        'new' => array(
            'https://www.lianissansaratoga.com/inventory/new/nissan/rogue?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/titan?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/frontier?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/pathfinder?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/titan-xd?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/rogue-sport?years=2022&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/altima?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/ariya?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/murano?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/sentra?years=2022&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/titan?years=2022&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/versa?years=2022&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/kicks?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/leaf?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/altima?years=2022&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/armada?years=2022&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
            'https://www.lianissansaratoga.com/inventory/new/nissan/armada?years=2023&locations=lia_nissan_of_saratoga&instock=true&intransit=true',
         ),
    ),
    'use-proxy'             => true,
    // 'proxy-area' => 'CA',
    'refine'    => false,
    'srp_page_regex'      => '/inventory\/(?:new|used|cpo)/',
    'vdp_url_regex'       => '/\/viewdetails\/(?:new|used|cpo)\/[^\/]+\/[0-9]{4}-/i',
 
    
    'details_start_tag' => 'website-primary-header position-fixed',
    'details_end_tag' => 'class="footer bgcolor-primary',
    'details_spliter' => 'class="standard-inventory',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*target="_self"/',
        'price' => '/(?:Your Price|Our Price)[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        'msrp'  => '/MSRP<\/div>[^>]+>(?<msrp>[^<]+)/',
        'year' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'make' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'model' => '/title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*[^"]+"\s*alt/',
        'vin' => '/VIN:[^>]+>\s*<div\s*class="vin[^>]+>[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[^\s*]+)/',
        'all_images' => '/<img src="(?<all_images>[^"]+)"[^=]+=[^=]+=[^\s*]+[^\s*]+\s*[^\s*]+\s*title/',
        //custom is already in use. As discount will be shown as description thats why I am scraping discount as description.
        'custom_number_0' => '/Dealer Discount[^>]+>[^>]+>(?<custom_number_0>[^<]+)/',
        'custom_1' => '/Dealer Discount[^>]+>[^>]+>(?<custom_1>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        //this custom is for VDP account ID. We are picking images from api. so the account id may vary from each other.
        //thats why I have taken vdp account id.
        'custom' => '/vdpAccountId = \'(?<custom>[^\']+)/',
        'body_style' => '/body_style:\s*\'(?<body_style>[^\']+)/',
        'price' => '/price:\s*(?<price>[^\,]+)/',
        'transmission' => '/transmission:\s*\'(?<transmission>[^\']+)/',
        'exterior_color' => '/exterior_color:\s*\'(?<exterior_color>[^\']+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/stockNumber\s*=\s*\'(?<stock_number>[^\']+)/',
    ),
        'next_page_regx' => '/_text_color theme-text-color" href="(?<next>[^"]+)"\s*rel="next">/',
        'images_regx' => '/<a itemprop="url" href="(?<img_url>[^"]+)/',
);

add_filter('filter_lianissansaratogacom_car_data', 'filter_lianissansaratogacom_car_data');
function filter_lianissansaratogacom_car_data($car_data)
{
    if (true) {
        $api_url = "https://www.lianissansaratoga.com/api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID={$car_data['custom']}"."&enableNewImageRules=true&vin={$car_data['vin']}";
        slecho("vdpaccountID:" . $car_data['custom']);
        slecho("api url:" . $api_url);
        $response_data = HttpGet($api_url, true, true);

        if ($response_data) {
            $obj = json_decode($response_data);
            $car_data['all_images']= implode("|",$obj->showAllList);
            if(strpos($car_data['all_images'],"images/GetEvoxImage") || strpos($car_data['all_images'],"stock_images/")){
                $car_data['all_images']="";
            } 
        }
    }

    if(true) {
        $price_api = "https://www.lianissansaratoga.com/api/Inventory/vehicle?vin={$car_data['vin']}";
        slecho("API URL: ".$price_api);
        sleep(3);
        $response_data = HttpGet($price_api, true, true);
        $first_res_data = json_decode($response_data);

        if($first_res_data->sellingPrice == NULL || $first_res_data->sellingPrice == ""){
            for ($try = 0; $try <= 3; $try++) {
                sleep(3);
                $response_data = HttpGet($price_api, true, true);
                $try_response_obj =  json_decode($response_data);
                if($try_response_obj->make != NULL || $try_response_obj->make != ""){
                    break;
                }
            }
        }
        if($response_data){
            $car_obj = json_decode($response_data);
            $car_data['price'] = $car_obj->sellingPrice;
            $car_data['msrp'] = $car_obj->msrp;
        }
    }

    if($car_data['custom_1'] != NULL){
        $car_data['custom_1'] = $car_data['custom_1'];
    }
    else{
        $car_data['custom_1'] = "$0";
    }
    return $car_data;
}


add_filter("filter_lianissansaratogacom_field_price", "filter_lianissansaratogacom_field_price", 10, 3);

function filter_lianissansaratogacom_field_price($price, $car_data, $spltd_data)
{
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


add_filter("filter_lianissansaratogacom_field_body_style", "filter_lianissansaratogacom_field_body_style");
function filter_lianissansaratogacom_field_body_style($body_style) {
    
    if($body_style == "4dr Car"){
        $body_style = "SEDAN";
    }
    else if($body_style == "Crew Cab Pickup"){
        $body_style = "TRUCK";
    }
    else if($body_style == "Extended Cab Pickup"){
        $body_style = "TRUCK";
    }
    else if($body_style == "Hatchback"){
        $body_style = "HATCHBACK";
    }
    else if($body_style == "Mini-van, Passenger"){
        $body_style = "MINIVAN";
    }
    else if($body_style == "Sport Utility"){
        $body_style = "SUV";
    }
    else if($body_style == "2dr Car"){
        $body_style = "SEDAN";
    }
    else{
        $body_style = "OTHER";
    }
    
    return $body_style;
}
