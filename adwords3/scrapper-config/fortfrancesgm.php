
<?php

global $scrapper_configs;
$scrapper_configs["fortfrancesgm"] = array(
    'entry_points'           => array(   
        'new'  => 'https://www.fortfrancesgm.com/inventory/new/',
        'used'  => 'https://www.fortfrancesgm.com/inventory/used/',   
    ),
    'use-proxy'              => true,
    'refine'                 => false,
    'vdp_url_regex'          => '/\/inventory\//i',
     'srp_page_regex'          => '/\/inventory\/(?:New|certified|Used)\//i',
    'picture_selectors'      => ['.slick-slide img'],
    'picture_nexts'          => ['.slick-next'],
    'picture_prevs'          => ['.slick-prev'],
    'details_start_tag'      => 'class="srpVehicles__wrap">',
    'details_end_tag'        => 'class="disclaimer__wrap">',
    'details_spliter'        => 'id="carbox',
    'data_capture_regx'      => array(
        'url'          => '/data-permalink="(?<url>[^"]+)/',
        /*'year'         => '/year">\s*(?<year>[0-9]{4})/',
        'make'         => '/vehicle-title--make\s*">\s*(?<make>[^\s]+)/',
        'model'        => '/vehicle-title--model\s*">\s*(?<model>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price'        => '/(?:MSRP|Market Price)<\/div><div\s*[^>]+>\s*<span\s*[^>]+><span\s*[^>]+>[^>]+><span\s*[^>]+>(?<price>[0-9,]+)/',
        'vin'          => '/VIN#:<\/span>\s*<span\s*class="vehicleIds--value"\s*>(?<vin>[^<]+)/',*/
    ),
    'data_capture_regx_full' => array(
        'kilometres'     => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine'         => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission'   => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/',
        'vin'            => '/data-vehicle="vin"[^>]+>(?<vin>[^<]+)/',
        'stock_number'   => '/data-vehicle="stock" >(?<stock_number>[^<]+)/',
        'year'           => '/class="vehicle-title--year">(?<year>[^<]+)/',
        'stock_type'     => '/class="vehicle-title--type">(?<stock_type>[^<]+)/',
        'make'           => '/class="notranslate vehicle-title--make ">(?<make>[^<]+)/',
        'model'          => '/class="notranslate vehicle-title--model ">(?<model>[^<]+)/',
        'trim'           => '/class="notranslate vehicle-title--trim ">(?<trim>[^<]+)/',
        'body_style'     => '/class="title-standardbody vehicle-title--subtitle-item">(?<body_style>[^<]+)/',
        'drivetrain'     => '/class="title-drivetrain vehicle-title--subtitle-item">(?<drivetrain>[^<]+)/',
        'price'          => '/,"price":(?<price>[^,]+),"priceCurrency":"USD"/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx'            => '/class="img-fluid[^"]+"\s*alt="[^"]+"\s*src="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/property="og:image" content="(?<img_url>[^"]+)"/',

);
add_filter("filter_for_aia_fortfrancesgm", "filter_for_aia_fortfrancesgm", 10, 1);

function filter_for_aia_fortfrancesgm($car)
{
    if ($car['price'] == "$0.00" || $car['price'] == "0.00") {
        $car = [];
    }

    return $car;
}