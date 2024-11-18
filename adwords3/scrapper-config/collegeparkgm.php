<?php

global $scrapper_configs;

$scrapper_configs['collegeparkgm'] = array(
    'entry_points' => array(
         'used' => 'http://www.collegeparkgm.ca/VehicleSearchResults?search=preowned',
        'new' => 'http://www.collegeparkgm.ca/VehicleSearchResults?search=new',
       
    ),
    'vdp_url_regex' => '/\/VehicleDetails\//i',
    'ty_url_regex' => '/\/thankYou.do/i',
    'ajax_url_match' => 'callback=secureLeadSubmission',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'url' => '/subject[^=]+="url" href="(?<url>[^"]+)/',
        'stock_type' => '/subject[^=]+="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
      
        'trim' => '/class="trim"[^>]+>(?<trim>[^<]+)/',
        'price' => '/itemprop="price" data-action="priceSpecification"[^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
         'engine' => '/class="key">Engine Data[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
        'vin' => '/vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
        'exterior_color' => '/class="key">Exterior Color[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
      //  'certified' => '/"vehicle":\{"category":"(?<certified>certified)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_collegeparkgm_next_page", "filter_collegeparkgm_next_page", 10, 2);

function filter_collegeparkgm_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

add_filter("filter_collegeparkgm_field_images", "filter_collegeparkgm_field_images");

function filter_collegeparkgm_field_images($im_urls) {
    if (count($im_urls) < 2) {
        return [];
    }

    return $im_urls;
}

add_filter('filter_collegeparkgm_car_data', 'filter_collegeparkgm_car_data');

function filter_collegeparkgm_car_data($car_data) {

    if ($car_data['stock_number'] == '9014A') {
        slecho("Excluding car that has stock number 9014A ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}
add_filter("filter_collegeparkgm_field_price", "filter_collegeparkgm_field_price", 10, 3);

function filter_collegeparkgm_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }
    $orginal_regex = '/Original Price[^>]+>\s*[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/';
    $College_regex = '/College Park Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/';
    $msrp_regex = '/MSRP[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/';
    $matches = [];
      if (preg_match($orginal_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) 
      {
      $prices[] = numarifyPrice($matches['price']);
      slecho("Regex orginal: {$matches['price']}");
      }
     if (preg_match($College_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) 
      {
      $prices[] = numarifyPrice($matches['price']);
      slecho("Regex MSRP: {$matches['price']}");
      }
       if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) 
      {
      $prices[] = numarifyPrice($matches['price']);
      slecho("Regex MSRP: {$matches['price']}");
      }
      
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');

    return $price;
}
