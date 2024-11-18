<?php

global $scrapper_configs;
$scrapper_configs["riversideofprescott"] = array(
    'entry_points' => array(
        'new' => 'https://www.riversideofprescott.com/new/',
        'used' => 'https://www.riversideofprescott.com/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
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
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        // 'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin' => '/vin\s*:\s*\'(?<vin>[^\']+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'model' => '/\&model=(?<model>[^\&]+)/',
        'trim' => '/\&trim=(?<trim>[^\&]+)/',    
        'description' => '/<meta name="description" content="(?<description>[^"]+)/',
       
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/<img onerror="imgError\(this\)\;" (?:data-src|src)="(?<img_url>[^"]+)/'
);

add_filter("filter_riversideofprescott_field_price", "filter_riversideofprescott_field_price", 10, 3);
/*add_filter('filter_riversideofprescott_car_data', 'filter_riversideofprescott_car_data');

function filter_riversideofprescott_car_data($car_data) {
    //they want biweekly price insted of price for new vehicles 
    //https://app.asana.com/0/687248649257779/1151221041916887

    if ($car_data['stock_type'] == 'new' && isset($car_data['biweekly'])) {
        $car_data['price'] = $car_data['biweekly'];
        $car_data['finance_term'] = 84;
        $car_data['finance'] = $car_data['biweekly'];
        return $car_data;
    }
    else{
        return $car_data;
    }
}
*/
function filter_riversideofprescott_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $internet_regex = '/Prescott Price[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';
    $msrp_regex = '/>MSRP[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/';


    $matches = [];

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex msrp: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
 add_filter("filter_riversideofprescott_field_images", "filter_riversideofprescott_field_images");
 function filter_riversideofprescott_field_images($im_urls)
    {
       if(count($im_urls)<3)
            {
            return [];
            
            }
       
        return $im_urls;
    }