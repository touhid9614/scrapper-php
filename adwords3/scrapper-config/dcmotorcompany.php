<?php

global $scrapper_configs;

$scrapper_configs['dcmotorcompany'] = array(
    'entry_points' => array(
        'used' => 'https://www.dcmotorcompany.com/luxury-vehicles-for-sale-in-portland-or'
    ),
      'vdp_url_regex' => '/\/vehicle-details\/[0-9]{4}-/i',
    'use-proxy' => true,
      'refine' => false,
    'picture_selectors' => ['.zoom-thumbnails__slide'],
    'picture_nexts' => ['.df-icon-chevron-right'],
    'picture_prevs' => ['.df-icon-chevron-left'],
    'details_start_tag' => '<div class="inventory-listing',
    'details_end_tag' => '<footer class=',
    'details_spliter' => '<div class="vehicle-item inventory-listing',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)" class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<\s*]*)/',
        'title' => '/<a href="(?<url>[^"]+)" class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<\s*]*)/',
        'year' => '/<a href="(?<url>[^"]+)" class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<\s*]*)/',
        'make' => '/<a href="(?<url>[^"]+)" class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<\s*]*)/',
        'model' => '/<a href="(?<url>[^"]+)" class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)[^<\s*]*)/',
        'price' => '/one-price">\s*(?<price>[^\s*]+)/',
  
    ),
    'data_capture_regx_full' => array(
        'drivetrain'    => '/Drivetrain<\/div><\/td>\s*<[^>]+>(?<drivetrain>[^<]+)/',
        'fuel_type'      => '/Fuel Type<\/div><\/td>\s*<[^>]+>(?<fuel_type>[^<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
         'stock_number' => '/Stock<\/div>[^>]+>\s*[^>]+>(?<stock_number>[^\<]+)/',
        'transmission' => '/Transmission<\/div>[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/Engine<\/div>[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
        'kilometres' => '/Mileage<\/div>[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Exterior Color<\/div>[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/div>[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'year' => '/Year<\/div>[^>]+>\s*[^>]+>(?<year>[0-9]+)/',
        'make' => '/Make<\/div>[^>]+>\s*[^>]+>(?<make>[^<]+)/',
        'model' => '/Model<\/div>[^>]+>\s*[^>]+>(?<model>[^<]+)/',
        'body_style' => '/Body Style<\/div>[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        
    ),
    'next_page_regx' => '/<link rel="next" href="(?<next>[^"]+)/',
    'images_regx' => '/<div class="aspect-ratio-block_inner">\s*<picture><source srcset="(?<img_url>[^\s]+)\s*154w/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_dcmotorcompany_field_images", "filter_dcmotorcompany_field_images");
function filter_dcmotorcompany_field_images($im_urls) {
    $retval = [];
    if (count($im_urls) < 20) {
        return array();
    }
    foreach ($im_urls as $img) {
        $retval[] = str_replace('w_154', 'w_1080', $img);
    }

    return $retval;
}