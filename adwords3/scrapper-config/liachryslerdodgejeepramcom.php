<?php
global $scrapper_configs;
$scrapper_configs["liachryslerdodgejeepramcom"] = array(
    'entry_points'           => array(
        'new'  => 'https://www.liachryslerdodgejeepram.com/searchnew.aspx?Dealership=Lia%20Chrysler%20Jeep%20Dodge%20Ram',
        'used' => 'https://www.liachryslerdodgejeepram.com/searchused.aspx?Dealership=Lia%20Chrysler%20Jeep%20Dodge%20Ram',
    ),
    'vdp_url_regex'          => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'srp_page_regex'      => '/\/search(?:new|used)\.aspx/',
    'ty_url_regex'           => '/\/thankyou.aspx/i',
    'use-proxy'             => true,
    'proxy-area' => 'CA',
    'refine'                 => false,
    'details_start_tag' => 'id="sticky_header"',
    'details_end_tag'   => 'class="row srpDisclaimer"',
    'details_spliter'   => '<div data-vehicle-information',
    'data_capture_regx' => array(
        'vin'           => '/data-vin="(?<vin>[^"]+)/',
        // 'make'          => '/data-make="(?<make>[^"]+)/',
        // 'model'         => '/data-model="(?<model>[^"]+)/',
        // 'year'          => '/data-year="(?<year>[^"]+)/',
        'body_style'    => '/data-bodystyle="(?<body_style>[^"]+)/',
        'stock_number'  => '/data-stocknum="(?<stock_number>[^"]+)/',
        // 'trim'          => '/data-trim="(?<trim>[^"]+)/',
        // 'price'         => '/(?:Internet Price|MSRP)[^\&]+\&[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        'price'         => '/data-price="(?<price>[^"]+)/',
        'msrp'          => '/data-msrp="(?<msrp>[^"]+)/',
        'url'           => '/class="hero-carousel__item--viewvehicle"\s*href="(?<url>[^"]+)/',
        //inside custom I am scraping discount value
        'custom_number_0' => '/(?:LIA Discount|Discounts &amp; Rebates):<\/span>[^>]+>(?:-|)(?<custom_number_0>[^<]+)/',
        'custom_1'        => '/(?:LIA Discount|Discounts &amp; Rebates):<\/span>[^>]+>(?:-|)(?<custom_1>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        // 'msrp'          => '/J.D. Power Book Value:[^>]+>[^>]+>(?<price>[^<]+)/',
        'make'          => '/"name": "(?<year>[0-9]{4}+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/',
        'model'         => '/"name": "(?<year>[0-9]{4}+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/',
        'year'          => '/"name": "(?<year>[0-9]{4}+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/',
        'trim'          => '/"name": "(?<year>[0-9]{4}+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^"]+)/',
        'transmission'  => '/class="info__label">Transmission[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'kilometres'    => '/"info__label">Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'exterior_color'=> '/color_exterior: "(?<exterior_color>[^"]+)/',
        'interior_color'=> '/color_interior: "(?<interior_color>[^"]+)/',
    ) ,
    'next_page_regx'    => '/rel="next" href="(?<next>[^"]+)/',
    'images_regx'       => '/subtype=\'hyperlink\'\s*[^>]+>\s*<img src="(?<img_url>[^"]+)"\s*src/',
);

add_filter("filter_liachryslerdodgejeepramcom_field_body_style", "filter_liachryslerdodgejeepramcom_field_body_style");
function filter_liachryslerdodgejeepramcom_field_body_style($body_style) {
    if($body_style == "2D Coupe"){
        $body_style = "COUPE";
    }
    else if($body_style == "2WD Minivans"){
        $body_style = "MINIVAN";
    }
    else if($body_style == "4D Cargo Van"){
        $body_style = "VAN";
    }
    else if($body_style == "4D Passenger Van"){
        $body_style = "VAN";
    }
    else if($body_style == "4D Quad Cab"){
        $body_style = "TRUCK";
    }
    else if($body_style == "4D Sport Utility"){
        $body_style = "SUV";
    }
    else if($body_style == "4WD Sport Utility Vehicles"){
        $body_style = "SUV";
    }
    else if($body_style == "Super Cab"){
        $body_style = "TRUCK";
    }
    else if($body_style == "4D Crew Cab"){
        $body_style = "TRUCK";
    }
    else if($body_style == "4D Sedan"){
        $body_style = "SEDAN";
    }
    else if($body_style == "4D Wagon"){
        $body_style = "WAGON";
    }
    else if($body_style == "Cargo Vans"){
        $body_style = "VAN";
    }
    else if($body_style == "4WD Standard Pickup Trucks"){
        $body_style = "TRUCK";
    }
    else if($body_style == "2D Sport Utility"){
        $body_style = "SUV";
    }
    else if($body_style == "4D Hatchback"){
        $body_style = "HATCHBACK";
    }
    else if($body_style == "4D Extended Cab"){
        $body_style = "TRUCK";
    }
    else{
        $body_style = "OTHER";
    }
    
    return $body_style;
}

add_filter("filter_liachryslerdodgejeepramcom_field_images", "filter_liachryslerdodgejeepramcom_field_images");

function filter_liachryslerdodgejeepramcom_field_images($im_urls)
{
    for($i = 0; $i < count($im_urls) ; $i++){
        if(strpos($im_urls[$i],"assets/stock/") || strpos($im_urls[$i],"/sp/")){
            $im_urls[$i] = NULL;
        }
    }
    return array_filter($im_urls);
}

add_filter("filter_liachryslerdodgejeepramcom_field_price", "filter_liachryslerdodgejeepramcom_field_price", 10, 3);

function filter_liachryslerdodgejeepramcom_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
    }

    $msrp_regex = '/MSRP:\s*<[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    return $price;
}

add_filter('filter_liachryslerdodgejeepramcom_car_data', 'filter_liachryslerdodgejeepramcom_car_data');

function filter_liachryslerdodgejeepramcom_car_data($car_data) {

    if($car_data['custom'] != NULL){
        $car_data['custom'] = $car_data['custom'];
    }
    else{
        $car_data['custom'] = "$0";
    }
    return $car_data;
}