<?php
global $scrapper_configs;
$scrapper_configs["sherwoodfordca"] = [
    "entry_points"           => [
        'new'  => [
            'https://www.sherwoodford.ca/new-vehicles-sherwood-park-ab?limit=100&offset=0',
            'https://www.sherwoodford.ca/new-vehicles-sherwood-park-ab?limit=100&offset=100',
            'https://www.sherwoodford.ca/new-vehicles-sherwood-park-ab?limit=100&offset=200',
        ],
        'used' => [
            'https://www.sherwoodford.ca/used-vehicles-sherwood-park-ab?limit=100&offset=0',
            'https://www.sherwoodford.ca/used-vehicles-sherwood-park-ab?limit=100&offset=100',
        ]
    ],
    'srp_page_regex'         => '/(?:new|used)-vehicles/i',
    'vdp_url_regex'          => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    'refine'                 => false,
    'use-proxy'              => true,

    'details_start_tag'      => '<div class="inventory-listing',
    'details_end_tag'        => '<footer class=',
    'details_spliter'        => '<div class="inventory-item  clearfix js-vehicle-item"',
    'data_capture_regx'      => [
        'url'          => '/js-vehicle-item-link" href="(?<url>[^"]+)"/',
        'year'         => '/hicle-title js-vehicle-item-link">\s*<a href="(?<url>[^"]+)" class="vehicle-title ">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'make'         => '/hicle-title js-vehicle-item-link">\s*<a href="(?<url>[^"]+)" class="vehicle-title ">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'model'        => '/hicle-title js-vehicle-item-link">\s*<a href="(?<url>[^"]+)" class="vehicle-title ">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'trim'         => '/hicle-title js-vehicle-item-link">\s*<a href="(?<url>[^"]+)" class="vehicle-title ">\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'price'        => '/price __final-price\s*[^>]+>\s*[^>]+>[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'stock_number' => '/\# (?<stock_number>[^<]+)/',
    ],
    'data_capture_regx_full' => [
        'price'          => '/Giant Deal\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
        'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        // 'stock_number'   => '/Stock<\/div>[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style'     => '/Body Style[^>]+>\s*[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'kilometres'     => '/Mileage[^>]+>\s*[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
        'year'           => '/>Year[^>]+>\s*[^>]+>\s*[^>]+>(?<year>[0-9]{4})/',
        'make'           => '/>Make[^>]+>\s*[^>]+>\s*[^>]+>(?<make>[^<]+)/',
        'model'          => '/>Model<\/div>\s*[^>]+>\s*[^>]+>(?<model>[^<]+)/',
        'exterior_color' => '/Exterior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission'   => '/>Transmission<\/div>\s*[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'drive_train'    => '/>Drivetrain<\/div>\s*[^>]+>\s*[^>]+>(?<drive_train>[^<]+)/',
        'fuel_type'      => '/>Fuel Type<\/div>\s*[^>]+>\s*[^>]+>(?<fuel_type>[^<]+)/',
        'vin'            => '/>VIN<\/div>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
    ],
    'next_page_regx'         => '/<link rel="next" href="(?<next>[^"]+)"/',
    'images_regx'            => '/<picture><source (?:srcset|data-srcset)="(?<img_url>[^\s]+)\s*840w/',
    'images_fallback_regx'   => '/<div class="thumb-preview">\s*<img src="(?<img_url>[^"]+)"/',
    // 'annoy_func'          => function($response_data) {
    //     sleep(10);
    //     return $response_data;
    // }
];

add_filter('filter_sherwoodfordca_car_data', 'filter_sherwoodfordca_car_data');

function filter_sherwoodfordca_car_data($car_data)
{
    sleep(10);

    $car_data['images'] = $arr = array_map(function ($value) {
        return preg_replace('/\/sz_[0-9]{6}\/w_840/', '', $value);
    }, $car_data['images']);

    $car_data['all_images'] = preg_replace('/\/sz_[0-9]{6}\/w_840/', '', $car_data['all_images']);

    return $car_data;
}


add_filter('filter_for_fb_sherwoodfordca', 'filter_for_fb_sherwoodfordca', 10, 2);

function filter_for_fb_sherwoodfordca($car_data, $feed_type)
{
    if ($car_data['stock_number']=='P1006' || $car_data['stock_number']=='P1792') {
        
        $car_data['model']=$car_data['model'] . ' Black Widow';
        $car_data['trim']= ' ';
      
    }
    
    

    return $car_data;
}
