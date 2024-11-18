<?php
global $scrapper_configs;
$scrapper_configs["liacarscom"] = array( 
    "entry_points" => array(
    'used' => 'https://www.liacars.com/searchused.aspx',
    'new' => 'https://www.liacars.com/searchnew.aspx',
),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thankyou.aspx/i',
    'refine'=>false,
    'use-proxy'             => true,
    'proxy-area' => 'CA',
    'picture_selectors' => ['.js-carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next.js-carousel__control--next.js-carousel__control  span'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev.js-carousel__control--prev.js-carousel__control span'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div id="srpRow',
    'data_capture_regx' => array(
        'vin'           => '/VIN #:\s*<\/strong>[^>]+>(?<vin>[^<]+)/',
        'stock_number'  => '/Stock\s*#:\s*<\/strong>\s*(?<stock_number>[^<]+)/',
        //this price is for New Cars & Used cars
        'price'         => '/(?:Our Price|MSRP):[^>]+>[^>]+>(?<price>[^<]+)<\/span/',
        //this is MSRP thats needs to pull
        'msrp'          => '/(?:Lia Price|MSRP):[^>]+>[^>]+>(?<msrp>[^<]+)<\/span/',
        'engine'        => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
        'transmission'  => '/Transmission:\s*<\/strong>\s*(?<transmission>[^<]+)/',
        'exterior_color'=> '/Ext. Color:\s*<\/strong>\s*(?<exterior_color>[^<]+)/',
        'interior_color'=> '/Int. Color:\s*<\/strong>\s*(?<interior_color>[^<]+)/',
        'url'           => '/rel="(?<url>[^"]+)">/',
        //inside custom I am scraping discount value
        'custom_number_0'        => '/(?:Discount & Rebates|LIA Discount):[^>]+>[^>]+>\-(?<custom_number_0>[^<]+)/',
        'custom'        => '/(?:Discount & Rebates|LIA Discount):[^>]+>[^>]+>\-(?<custom>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make'          => '/vehicleMake="(?<make>[^"]+)/',
        'model'         => '/vehicleModel="(?<model>[^"]+)/',
        'year'          => '/vehicleYear="(?<year>[^"]+)/',
        'trim'          => '/vehicleTrim="(?<trim>[^"]+)/',
        //'price'         => '/Our Price[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/',
        'body_style'    => '/Body Style:\s*<\/strong>\s*(?<body_style>[^<]+)/',
        'kilometres'    => '/Mileage:\s*<\/strong>\s*(?<kilometres>[^<]+)/',
    ) ,
    'next_page_regx'    => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
    'images_regx'       => '/data-image-full="(?<img_url>[^"]+)"/',
);

add_filter("filter_liacarscom_field_images", "filter_liacarscom_field_images");

function filter_liacarscom_field_images($im_urls)
{
    for($i = 0; $i < count($im_urls) ; $i++){
        if(strpos($im_urls[$i],"assets/stock/") || strpos($im_urls[$i],"/sp/")){
            $im_urls[$i] = NULL;
        }
    }
    return array_filter($im_urls);
}
      
add_filter("filter_liacarscom_field_price", "filter_liacarscom_field_price", 10, 3);

function filter_liacarscom_field_price($price,$car_data, $spltd_data)
{
    numarifyPrice($car_data['custom_number_0']);
    $prices = [];

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
    }

    $msrp_regex   = '/(?:Lia Price|MSRP):[^>]+>[^>]+>(?<price>[^<]+)<\/span/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}


add_filter("filter_liacarscom_field_body_style", "filter_liacarscom_field_body_style");
function filter_liacarscom_field_body_style($body_style) {
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

    

