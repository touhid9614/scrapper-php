<?php

global $scrapper_configs;
$scrapper_configs["tetonvw"] = array(
     'entry_points' => array(
        'new' => 'https://www.tetonvw.com/searchnew.aspx?pn=96',
        'used' => 'https://www.tetonvw.com/searchused.aspx?pn=96',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    //'ty_url_regex' => '/\/thankyou.aspx/i',
     'refine' => false,
    //   'proxy-area'        => 'FL',
    'picture_selectors' => ['.hero-carousel__image'],
    'picture_nexts' => ['div.carousel__control--next'],
    'picture_prevs' => ['div.carousel__control--prev'],
    'details_start_tag' => '<div id="srp-inventory"',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => 'data-vehicle-information',
    'data_capture_regx' => array(
        'vin'           => '/data-vin="(?<vin>[^"]+)/',
        'url' => '/hero-carousel__item--viewvehicle"\s*href="(?<url>[^"]+)/',
        //'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'body_style' => '/data-bodystyle="(?<body_style>[^"]+)/',
        'transmission' => '/data-trans="(?<transmission>[^"]+)/',
        'engine' => '/data-engine="(?<engine>[^"]+)/',
        'exterior_color' => '/data-extcolor="(?<exterior_color>[^"]+)/',
        'interior_color' => '/data-intcolor="(?<interior_color>[^"]+)/',
        'stock_number' => '/Stock:[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
      
        'price' => '/data-price="(?<price>[^"]+)/',
    ),
    'data_capture_regx_full' => array(
          'kilometres' => '/Mileage[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
        // 'make' => '/brand":\s*"(?<make>[^"]+)/',
        // 'model' => '/model":\s*"(?<model>[^"]+)/',
        // 'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/<a\s*href=\'(?<next>[^\']+)\'\s*class="stat\-arrow\-next"\s*/',
    'images_regx' => '/<img\s*src="(?<img_url>[^"]+)"\s*class=/'
);


add_filter("filter_tetonvw_field_images", "filter_tetonvw_field_images");    
function filter_tetonvw_field_images($im_urls)
{
    if(count($im_urls)<2)
    {
        return [];
    }
    return $im_urls;
}

add_filter('filter_tetonvw_car_data', 'filter_tetonvw_car_data');
function filter_tetonvw_car_data($car_data) {
    if(strlen($car_data['stock_number']) > 10){
        $car_data['stock_number'] = $car_data['vin'];
    }
    return $car_data;
}
