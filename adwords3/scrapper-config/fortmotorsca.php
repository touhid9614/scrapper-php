<?php
global $scrapper_configs;
$scrapper_configs["fortmotorsca"] = array( 
	"entry_points" => array(
        'used'      => 'https://www.fortmotors.ca/used-inventory/',
        'new'       => 'https://www.fortmotors.ca/new-inventory/',
        'rv'        => 'https://www.fortmotors.ca/new-rv-inventory/',
        'trailer'   => 'https://www.fortmotors.ca/all-trailer-inventory/',
    ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine' => false,
        'picture_selectors' => ['.img-fluid'],
        'picture_nexts'     => ['.slick-next'],
        'picture_prevs'     => ['.slick-prev'],
        
        'details_start_tag' => 'id="vehicle-results"',
        'details_end_tag'   => '<footer id="footer"',
        'details_spliter'   => '<div class="featured-card">',
        
        'data_capture_regx' => array(
            'kilometres'    => '/Mileage\s*[^>]+>[^>]+>\s*(?<kilometres>[^KM]+)/',
            'url'           => '/<a\s*href="(?<url>[^"]+)"\s*class="vehicle-card/',
            'year'          => '/class="main-title group-hover:text-ford-2">\s*(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)<)/',
            'make'          => '/class="main-title group-hover:text-ford-2">\s*(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)<)/',
            'model'         => '/class="main-title group-hover:text-ford-2">\s*(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)<)/',  
            //'trim'          => '/<a class="text-body font-weight-bolder" href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
            'title'          => '/class="main-title group-hover:text-ford-2">\s*(?<title>(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^<]+)<)/',
            'price'         => '/price group-hover[^>]+>\s*(?<price>\$[0-9,]+)/',
         ),
        'data_capture_regx_full' => array( 
             
            'vin'           => '/VIN:\s*(?<vin>[^\<]+)/',
            'stock_number'  => '/Stock #:\s*(?<stock_number>[^<]+)/',
            'exterior_color'=> '/Exterior Colour[^>]+>\s*[^>]+>s*(?<exterior_color>[^<]+)/',
            'engine'        => '/Engine<\/p>[^>]+>\s*(?<engine>[^<]+)/',
            //'transmission'  => '/Transmission[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<transmission>[^<]+)/',
            'body_style'    => '/Body Style[^>]+>\s*[^>]+>\s*(?<body_style>[^<]+)/',
            'description'   => '/<meta property="og:description" content="(?<description>[^"]+)/',
        ),
        'next_page_regx'    => '/<a class="next page-numbers" href="(?<next>[^"]+)">Next/',
        'images_regx'       => '/<div class="gallery-photo[^\:]+\:[^"]+"[^"]+"[^"]+"\s*data-lazy-src="(?<img_url>[^\?"]+)/',
    );

add_filter('filter_fortmotorsca_car_data', 'filter_fortmotorsca_car_data');
function filter_fortmotorsca_car_data($car_data) {


    $car_data['title'] = str_replace('&#039;', ' ', $car_data['title']);
    $car_data['title'] = str_replace('&amp;', ' ', $car_data['title']);
    $car_data['vin']   = str_replace('&nbsp;', ' ', $car_data['vin']);
   

    $car_data['stock_number'] = str_replace('&nbsp;', ' ', $car_data['stock_number']);
    $car_data['exterior_color']  = str_replace('&nbsp;', ' ', $car_data['exterior_color']);
    $car_data['transmission'] = str_replace('&nbsp;', ' ', $car_data['transmission']);
    $car_data['body_style']  = str_replace('&nbsp;', ' ', $car_data['body_style']);
    $car_data['engine']  = str_replace('&nbsp;', ' ', $car_data['engine']);

    //$car_data['trim'] = str_replace('&#039;', '', $car_data['trim']);
    // $car_data['make']  = str_replace('&#8217;', " ' ", $car_data['make']);
    // $car_data['model'] = str_replace('&#8217;', " ' ", $car_data['model']);
    return $car_data;
}

add_filter("filter_fortmotorsca_field_images", "filter_fortmotorsca_field_images");

function filter_fortmotorsca_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'nophoto.svg');
    });
}

