<?php

global $scrapper_configs;

$scrapper_configs['minnetonkaford'] = array(
    'entry_points' => array(
        'new' => 'https://www.minnetonkaford.com/VehicleSearchResults?search=new',
        'used' => 'https://www.minnetonkaford.com/VehicleSearchResults?search=preowned'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    'used-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'stock_type' => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/<span .*itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'kilometres' => '/<span not="isNumeric" class="value">(?<kilometeres>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/template="vehicle-name"><a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
     
    /*
    //https://app.asana.com/0/687248649257779/1179981231236928
    'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP220.csv'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    'used-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'refine' => false,
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock #'],
                'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
                'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
                'trim' => $vehicle['Series'],
                'drivetrain' => $vehicle['Drivetrain Desc'],
                'fuel_type' => $vehicle['Fuel'],
                'transmission' => $vehicle['Transmission'],
                'body_style' => $vehicle['Body'],
                'images' => explode('|', $vehicle['Photo Url List']),
                'all_images' => $vehicle['Photo Url List'],
                'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
                'url' => $vehicle['Vehicle Detail Link'],
                'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                'exterior_color' => $vehicle['Colour'],
                'interior_color' => $vehicle['Interior Color'],
                'engine' => $vehicle['Engine'],
                'description' => strip_tags($vehicle['Description']),
                'kilometres' => $vehicle['Odometer'],
            ];
            if((stripos($car_data['model'], 'Ranger') !== false)) {
                slecho("Excluding vehicle :- {$car_data['url']}");
                continue;
            }

              $images = [];
             $images = explode('|', $car_data['all_images']);
             if(count($images)<3)
                 {
                  //  slecho("total images:" . $car_data['all_images']);
                     $car_data['all_images']='';
                 }
            
            $result[] = $car_data;
        }

        return $result;
    }*/
);

add_filter("filter_minnetonkaford_next_page", "filter_minnetonkaford_cadillac_next_page", 10, 2);

function filter_minnetonkaford_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

 add_filter("filter_minnetonkaford_field_images", "filter_minnetonkaford_field_images");
    
    function filter_minnetonkaford_field_images($im_urls)
     {
        if(count($im_urls)<3)
             {
             return [];
            
            }
       
        return $im_urls;
     }
     
      add_filter("filter_minnetonkaford_field_price", "filter_minnetonkaford_field_price", 10, 3);

function filter_minnetonkaford_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP\s*<\/span>[^>]+>(?<price>\$[0-9,]+)/';
    


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
