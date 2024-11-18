<?php
global $scrapper_configs;
 $scrapper_configs["vancouvertoyota"] = array( 
	'entry_points' => array(
        'new'  => 'https://www.vancouvertoyota.com/toyota-cars-for-sale-vancouver-wa.html',
        'used' => 'https://www.vancouvertoyota.com/used-cars-for-sale-vancouver-wa.html'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'use-proxy' => false,
    'refine' => false,

    //'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
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
    'price' => '/data-price="(?<price>[^"]+)/',
),
'data_capture_regx_full' => array(
    // 'price'     => '/Internet Price\s*<\/span><[^>]+>(?<price>\$[0-9,]+)/',
    'kilometres' => '/Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
    'stock_number' => '/Stock #:\s*<\/span>\s*[^>]+>(?<stock_number>[^<]+)/',
),
    'next_page_regx' => '/<a\s*href=\'(?<next>[^\']+)\'\s*class="stat-arrow-next"\s*/',
    'images_regx' => '/<div class="thumbnails--desktop__top">\s*<a href="(?<img_url>[^"]+)/'
);

add_filter('filter_vancouvertoyota_car_data', 'filter_vancouvertoyota_car_data');

function filter_vancouvertoyota_car_data($car_data) {

    if($car_data['make'] == "Mazda3"){
        $car_data['model'] = "mazda3";
        $car_data['custom'] = $car_data['year']." ".$car_data['make'];
    }
    else{
        $car_data['custom'] = $car_data['year']." ".$car_data['make']." ".$car_data['model'];
    }
    
     $ignore_data=[
                    'U21816',
                    'U21818',
                ];
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                return null;

            }
    
    return $car_data;
} 



add_filter('filter_for_fb_vancouvertoyota', 'filter_for_fb_vancouvertoyota', 10, 2);
function filter_for_fb_vancouvertoyota($car_data, $feed_type)
{
   
    if(strpos($car_data['all_images'],"photo_unavailable") ){
                    
                   
                        return null;
                }

    return $car_data;
}
