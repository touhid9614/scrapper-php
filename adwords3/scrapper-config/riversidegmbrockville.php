<?php

global $scrapper_configs;
$scrapper_configs["riversidegmbrockville"] = array(
    'entry_points' => array(
        'used' => 'https://www.riversidegmbrockville.com/used/',
        'new' => 'https://www.riversidegmbrockville.com/new/',
       
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<!-- Footer -->',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
        'make'   => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model'  => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/<td class="col-used-value" itemprop="sku">\s*(?<stock_number>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',    
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
       
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/data-src="(?<img_url>[^"]+)/'
);

//they don't want biweekly price now . they want their website price or msrp price 
//task link-->https://app.asana.com/0/1116316622272921/1199348337548579/f


//add_filter('filter_riversidegmbrockville_car_data', 'filter_riversidegmbrockville_car_data');

// function filter_riversidegmbrockville_car_data($car_data) {
//     //they want biweekly price insted of price for new vehicles 
//     //https://app.asana.com/0/687248649257779/1151221041916887

//     if ($car_data['stock_type'] == 'new' && isset($car_data['biweekly'])) {
//         $car_data['price'] = $car_data['biweekly'];
//         $car_data['finance_term'] = 84;
//         $car_data['finance'] = $car_data['biweekly'];
//     }
//     return $car_data;
// }
add_filter("filter_riversidegmbrockville_field_price", "filter_riversidegmbrockville_field_price", 10, 3);
function filter_riversidegmbrockville_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Riverside Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
    $internet_regex = '/>MSRP[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';



    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }



    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
 add_filter("filter_riversidegmbrockville_field_images", "filter_riversidegmbrockville_field_images");
 function filter_riversidegmbrockville_field_images($im_urls)
    {
       if(count($im_urls)<3)
            {
            return [];
            
            }
       
        return $im_urls;
    }