<?php
global $scrapper_configs;
 $scrapper_configs["clarkssussex"] = array( 
	  'entry_points' => array(
        'new'  => 'https://www.clarkssussex.ca/VehicleSearchResults?search=new',
        'used' => 'https://www.clarkssussex.ca/VehicleSearchResults?search=preowned',
),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',

    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'     => ['.arrow.single.next'],
    'picture_prevs'     => ['.arrow.single.prev'],

    'details_start_tag'    => '<ul each="cards">',
       'details_end_tag'   => '<div class="content" id="pageDisclaimer">',
       'details_spliter'   => '<section id="card-view/card/ca572d95-3193-4da9-8ec1-745d7128beb9-',

       'data_capture_regx' => array(
           'stock_number'      => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',   
           'year'              => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
           'make'              => '/itemprop="manufacturer">(?<make>[^<]+)/',
           'model'             => '/itemprop="model">(?<model>[^<]+)/',
           'engine'            => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
           'trim'              => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
           'exterior_color'    => '/itemprop="color">(?<exterior_color>[^<]+)/',
           'url'               => '/<a itemprop="url" href="(?<url>[^"]+)/',
           'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
       ),
       'data_capture_regx_full' => array(
           'transmission'      => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
           'kilometres'        => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
           'certified'         =>'/"vehicle":\{"category":"(?<certified>certified)/',
           'interior_color'    => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'body_style'        => '/"bodyType":"(?<body_style>[^"]+)/',
              'price'             => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',

       ),
        'next_page_regx'        => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
        'images_regx'           => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
   );
       
    add_filter("filter_clarkssussex_next_page", "filter_clarkssussex_next_page",10,2);
    add_filter("filter_clarkssussex_field_price", "filter_clarkssussex_field_price", 10, 3); 
    function filter_clarkssussex_next_page($next,$current_page) {
        slecho("Filtering Next url");
        $car_type= explode('=', $current_page);
        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
    }
function filter_clarkssussex_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Regex Grapevine Price: $price");
    }
     $min_price = '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/';
     $sale_regex = '/class="value " value="[^>]+>(?<price>\$[0-9,]+)/';
 

    $matches = [];

    if (preg_match($min_price, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Sale Price: {$matches['price']}");
    }
    if (preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Sale Price: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
