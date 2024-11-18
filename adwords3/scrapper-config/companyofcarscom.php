<?php
global $scrapper_configs;
$scrapper_configs["companyofcarscom"] = array(
    'entry_points'           => array(
        'used' => array(
            'https://www.companyofcars.com/listings/?city=vancouver',
            'https://www.companyofcars.com/listings/?city=kelowna',
        ),
    ),
    'vdp_url_regex'          => '/\/[0-9]{4}-/i',
    'srp_page_regex'         => '/\/listings\/\?city/i',
    'refine'                 => false,
    'use-proxy'              => false,

    'picture_selectors'      => ['.stm-single-image'],
    'picture_nexts'          => ['.owl-next'],
    'picture_prevs'          => ['.owl-prev'],
    'details_start_tag'      => '<div class="row row-3 car-listing-row',
    'details_end_tag'        => '<footer',
    'details_spliter'        => 'class="col-md-6 col-sm-6 col-xs-12 col-xxs-12',

    'data_capture_regx'      => array(
        'url'        => '/<a href="(?<url>[^"]+)" class="rmv_txt_drctn"/',
        'year'       => '/class="car-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]+)/',
        'make'       => '/class="car-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]+)/',
        'model'      => '/class="car-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*<]+)/',
        'price'      => '/normal-price">(?<price>[^<]+)/',
        'kilometers' => '/data-mileage="(?<kilometers>[^"]+)/',
        'city'       => '/City:\s*<\/span>\s*(?<city>[^<]+)/',
    ),

    'data_capture_regx_full' => array(
        'stock_number'   => '/stock#\s*<\/span>(?<stock_number>[^<]+)/',
        'transmission'   => '/Transmission<\/td>\s*[^>]+>(?<transmission>[^<]+)/',
        'engine'         => '/Engine<\/td>\s*[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/Exterior Color<\/td>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/td>[^>]+>(?<interior_color>[^<]+)/',
        'city'           => '/<div class=\'text-center\' style=\'margin-left: -30px;\'><span class=\'h3[^>]+>(?<city>[^<]+)<\/span><\/div>/',
        'description'    => '/<meta property="og:description" content="(?<description>[^"]+)/',
    ),

    'images_regx' => '/<img class="external_images_mj" src="(?<img_url>[^\?]+)/',
);

add_filter('filter_companyofcarscom_car_data', 'filter_companyofcarscom_car_data', 10, 1);

function filter_companyofcarscom_car_data($car) {
    $car['city'] = trim(strtolower($car['city']));

    return $car;
}
add_filter("filter_companyofcarscom_field_images", "filter_companyofcarscom_field_images");
    
    function filter_companyofcarscom_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }