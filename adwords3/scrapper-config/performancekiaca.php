<?php
global $scrapper_configs;
$scrapper_configs["performancekiaca"] = array( 
      "entry_points" => [
           'new'       => 'https://www.performancekia.ca/new-kia-thunder-bay-ontario',
            'used'      => 'https://www.performancekia.ca/used-cars-thunder-bay-ontario',
      ],
      'vdp_url_regex'     => '/ca\/[0-9]{4}-/i',
        'srp_page_regex'          => '/ca\/(?:new|used)-/i',
        'use-proxy' => true,
        'refine' => false,
        'details_start_tag' => '<div class="eziInvListView">',
        'details_end_tag'   => '<div class="footer">',
        'details_spliter'   => '<div class="eziVehicle eziVehicleList"',
        'data_capture_regx' => array(
           'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'year'          => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'make'          => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'model'         => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'price'         => '/id="ezDealerPrice">(?<price>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Trans:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior:[^>]+>[^>]+>(?<interior_color>[^<\[]+)/',
            'kilometres'    => '/Odometer:[^>]+>[^>]+>(?<kilometres>[^\s*]+)/',
            'url'           => '/<div class="eziGetMoreInfo"\s*[^>]+>\s*<a\s*[^"]+"[^"]+"\s*href="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
             'stock_type'  => '/<meta property="og:title" content="(?<stock_type>[^\s*]+)/',
             'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
            'custom' => '/<div class="eziVehicleDetail">[^>]+>[^>]+>\s*(?<custom>[^<]+)/',
        ),
         'next_page_regx'    => '/<a title="Next" href="(?<next>[^"]+)"/',
        'images_regx'       => '/<img src="(?<img_url>[^"]+)" id="wows[^"]+"/'
);

add_filter("filter_performancekiaca_field_price", "filter_performancekiaca_field_price", 10, 3);

function filter_performancekiaca_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/<span class=\'eziPriceValue\'>\s*(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

    
add_filter('filter_performancekiaca_car_data', 'filter_performancekiaca_car_data');

function filter_performancekiaca_car_data($car_data) {

    if(strcmp($car_data['custom'], "This Vehicle has been SOLD") == 0){
        slecho("car removed");
        return null;
    }
//    if ($car_data['stock_number'] == 'K10406'|$car_data['stock_number'] == 'K10126B' | $car_data['stock_number'] == 'K10397B'|$car_data['stock_number'] == 'K10360A') {
//        return null;
//    }
      $stocktype =  $car_data['stock_type'];
    
      $car_data['stock_type']= strtolower($stocktype);
    
     if ($stocktype == "Used") {
            $response_data = HttpGet($car_data['url']);
            $regex = '/<img src="(?<img_url>[^"]+)" id="wows[^"]+"/';
            $matches = [];
              if(preg_match_all($images_regex, $response_data, $matches)) { 
              $car_data['all_images']=implode('|', $matches['img_url']);
                   
           }
              $images = [];
              $images = explode('|', $car_data['all_images']);
             if(count($images)<2){
                $car_data['all_images']="";
           }
           $result[] = $car_data;
       
     }
        return $car_data;
   
}



//add_filter("filter_performancekiaca_field_stock_number", "filter_performancekiaca_field_stock_number");
//function filter_performancekiaca_field_stock_number($stock_number)
//    {
//        if($stock_number == "K10406" | $stock_number == "K10126B" | $stock_number == "K10397B" | $stock_number == "K10360A")
//        {
//            return [];
//        }
//    }

//add_filter("filter_performancekiaca_field_drivetrain", "filter_performancekiaca_field_drivetrain");
//function filter_performancekiaca_field_drivetrain($drivetrain)
//{
//    if(strcmp($drivetrain, "This Vehicle has been SOLD")==0){
//        slecho("removed");
//        slecho(cardata['make']);
//        return null;
//    }
//}