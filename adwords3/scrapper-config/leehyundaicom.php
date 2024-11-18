<?php
global $scrapper_configs;
$scrapper_configs["leehyundaicom"] = array( 
	 'entry_points' => array(
        'all' => 'https://api.hootinteractive.net/v1.0/feed/24493?token=fONWOiZSyz&advertiser=6071&format=Facebook%20(Automotive)&fname=Facebook%20Default%20Feed'
    ),
    'vdp_url_regex' => '/\/auto\//i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
    'refine' => false,
    'custom_data_capture' => function($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            $car_data = [
                'stock_number' => $vehicle['vin'],
                'vin' => $vehicle['vin'],
                'year' => $vehicle['year'],
                'make' => $vehicle['make'],
                'model' => $vehicle['model'],
                'trim' => $vehicle['trim'],
                'drivetrain' => $vehicle['drivetrain'],
                'fuel_type' => $vehicle['fuel_type'],
                'transmission' => $vehicle['transmission'],
                'body_style' => $vehicle['body_style'],
                'images' => explode('|', $vehicle['image[0].url']),
                'all_images' => $vehicle['image[0].url'],
                'price' =>$vehicle['price'] ,
                'url' => $vehicle['url'],
                'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
                'exterior_color' => $vehicle['exterior_color'],
                'interior_color' => $vehicle['interior_color'],
                'engine' => $vehicle['engine'],
                'description' => strip_tags($vehicle['description']),
                'kilometres' => $vehicle['mileage.value'],
            ];

// $images = [];
//             $images = explode('|', $car_data['all_images']);
//             if(count($images)<3)
//                 {
//                  //  slecho("total images:" . $car_data['all_images']);
//                     $car_data['all_images']='';
//                 }
     
            $result[] = $car_data;
        }

        return $result;
    }
);