<?php

global $scrapper_configs;

$scrapper_configs["cumberland_auto"] = array(
    
    
    'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP14914.csv'
    ),
      'vdp_url_regex'         => '/\/auto\//',
         'use-proxy'         => true,
       'refine' => false,
        'picture_selectors' => ['.view_all_images_wrapper'],
        'picture_nexts'     => ['.dep_image_slider_alt_next_btn'],
        'picture_prevs'     => ['.dep_image_slider_alt_prev_btn'],
    
    
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['Stock #'],
                'vin' => $vehicle['VIN'],
                'year' => $vehicle['Year'],
                'make' => $vehicle['Make'],
                'model' => $vehicle['Model'],
                'trim' => $vehicle['Series'],
                'drivetrain' => $vehicle['Drivetrain Desc'],
                'fuel_type' => $vehicle['Fuel'],
                'transmission' => $vehicle['Transmission'],
                'body_style' => $vehicle['Body'],
                'images' => explode('|', $vehicle['Photo Url List']),
                'all_images' => $vehicle['Photo Url List'],
                'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
                'url' => $vehicle['Vehicle Detail Link'],
                'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                'exterior_color' => $vehicle['Colour'],
                'interior_color' => $vehicle['Interior Color'],
                'engine' => $vehicle['Engine'],
                'description' => strip_tags($vehicle['Description']),
                'kilometres' => $vehicle['Odometer'],
            ];


            $result[] = $car_data;
        }

        return $result;
    }
);


//    'entry_points' => array(
//        'new' => 'https://www.cumberland-auto.com/new-cars-for-sale',
//        'used' => 'https://www.cumberland-auto.com/used-cars-for-sale'
//    ),
//    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
//    'ty_url_regex' => '/\/thank-you\?formName/i',
//    'use-proxy' => false,
//    // 'proxy-area'        => 'CA',
//    'picture_selectors' => ['.magic-thumbs ul li', '.slick-slide',],
//    'picture_nexts' => ['.mz-button.mz-button-next'],
//    'picture_prevs' => ['.mz-button.mz-button-prev'],
//    'details_start_tag' => '<div class="srp-vehicle-container" >',
//    'details_end_tag' => '<div class="footer">',
//    'details_spliter' => '<div class="row srp-vehicle"',
//    'data_capture_regx' => array(
//        'stock_number' => '/Stock:<\/span>\s*(?<stock_number>[^<]+)/',
//        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
//        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
//        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
//        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
//        'price' => '/(?:MSRP|Net Cost:|Advertised Price):[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/',
//        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
//        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
//        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
//        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
//        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
//        'interior_color' => '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
//    ),
//    'data_capture_regx_full' => array(
//        'make' => '/make":\s*"(?<make>[^"]+)/',
//        'model' => '/model":\s*"(?<model>[^"]+)/',
//        'trim' => '/trim":\s*"(?<trim>[^"]+)/',
//    ),
//    'next_page_regx' => '/current\'><a[^>]+>[0-9]<\/a><\/li><li><a href=\'\/inventory(?<next>[^\']+)/',
//    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
//);
