<?php

global $scrapper_configs;

$scrapper_configs['motorinnspiritlake'] = array(
    'entry_points'           => array(
        'new'  => 'https://www.motorinnautogroup.com/new-vehicles?SortBy=1&PageSize=1000',
        'used' => 'https://www.motorinnautogroup.com/used-inventory?SortBy=1&PageSize=1000',
    ),

    'vdp_url_regex'          => '/\/inventory\/details\/(?:new|used)\/[^\/]+\/[^\/]+\/[0-9]{4}\//i',
    'srp_page_regex'         => '/\/(?:new|used)-inventory/i',
    'ty_url_regex'           => '/\/form/i',

    'refine'                 => false,
    'proxy-area'             => 'CA',

    'picture_selectors'      => ['.fotorama__nav__shaft.fotorama__grab div'],
    'picture_nexts'          => ['.fotorama__arr.fotorama__arr--next'],
    'picture_prevs'          => ['.fotorama__arr.fotorama__arr--prev'],

    'details_start_tag'      => '<div class="col-md-9 col-lg-9">',
    'details_end_tag'        => '<div class="cb-footer">',
    'details_spliter'        => '<div class="block-grid-item">',

    'data_capture_regx'      => array(
        'vin'            => '/VIN<\/div>[^>]+>(?<vin>[^<]+)/',
        'url'            => '/class="panel-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'year'           => '/class="panel-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'make'           => '/class="panel-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'model'          => '/class="panel-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'trim'           => '/class="panel-title">\s*<a href="(?<url>[^"]+)">(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+)/',
        'price'          => '/Price<\/div>[^>]+>(?<price>[^<]+)/',
        'kilometres'     => '/Mileage<\/div>[^>]+>(?<kilometres>[^<]+)/',
        'stock_number'   => '/Stock No.<\/div>[^>]+>(?<stock_number>[^<]+)/',
        'engine'         => '/Engine<\/div>[^>]+>(?<engine>[^<]+)/',
        'transmission'   => '/Transmission<\/div>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color<\/div>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. Color<\/div>[^>]+>(?<interior_color>[^<]+)/',
        'city'           => '/Lot<\/div>\s*[^>]+>(?<city>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body Style<\/strong><\/td>\s*<td>(?<body_style>[^<]+)/',
        'model'      => '/Model<\/strong><\/td>\s*<td>(?<model>[^<]+)/',
        'make'       => '/Make<\/strong><\/td>\s*<td>(?<make>[^<]+)/',
        'trim'       => '/Package<\/strong><\/td>\s*<td>(?<trim>[^<]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/<li\sclass="active">[^>]+[^a].*[^a]+a\shref="(?<next>[^"]+)">/',
    'images_regx'            => '/<a href="(?<img_url>[^"]+)"\s*data-thumb="[^"]+"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);

add_filter('filter_motorinnspiritlake_car_data', 'filter_motorinnspiritlake_car_data');

function filter_motorinnspiritlake_car_data($car_data)
{
    $car_data['make']  = ucwords($car_data['make']);
    $car_data['model'] = ucwords($car_data['model']);
    $car_data['city']  = strtolower(str_replace(' ', '_', $car_data['city']));
    
     if($car_data['city'] == "knoxville")
    {
        return NULL;
    }

    return $car_data;
}

add_filter("filter_motorinnspiritlake_field_price", "filter_motorinnspiritlake_field_price", 10, 3);
function filter_motorinnspiritlake_field_price($price, $car_data, $spltd_data)
{
    $prices = [];

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
    }

    $msrp_regex      = '/class="price msrp">MSRP:(?<price>[^<]+)/';
    $internet_regex  = '/Price <\/td>[^>]+>\s*<span class="price">\s*(?<price>[^<]+)/';
    $get_offer_regex = '/Net Price:\s*(?<price>\$[0-9,]+)/';
    $condition_regex = '/<span id="cincph/';

    $matches = [];

    if (preg_match($condition_regex, $spltd_data, $matches)) {
        $url          = 'https://www.motorinnautogroup.com/Incentives/GetBestOffer';
        $post_data    = 'vid=' . $car_data['vin'] . '&category=';
        $content_type = 'text/html;';
        $in_cookies   = '';
        $out_cookies  = '';
        $resp         = HttpPost($url, $post_data, $in_cookies, $out_cookies, true, true);

        if ($out_cookies) {
            $in_cookies = $out_cookies;
        }

        if (preg_match($get_offer_regex, $resp, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
        }
    }

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    return $price;
}