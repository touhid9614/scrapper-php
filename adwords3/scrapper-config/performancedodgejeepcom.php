<?php
global $scrapper_configs;
$scrapper_configs["performancedodgejeepcom"] = array( 
    "entry_points"        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/performancedodge/performancedodgechryslerjeep.csv',
    ),
    'use-proxy'           => true,
    //'required_params'   => array('vehicleId'),
   'srp_page_regex'         => '/(?:used|new|certified)-inventory\/index/i',
   'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors'   => ['.swiper-slide img'],
    'picture_nexts'       => ['.swiper-slide-next'],
    'picture_prevs'       => ['.swiper-slide-prev'],
    'refine'              => false,
    'custom_data_capture' => function ($url, $resp) {
        $vehicles = convert_CSV_to_JSON($resp);

        $result = [];

        foreach ($vehicles as $vehicle) {
            
           // $images=explode(',', $vehicle['ImageURLs']);
            unset($images[0]);
            
            $car_data = [
                'stock_number'   => $vehicle['StockNumber'],
                'vin'            => $vehicle['VIN'],
                'year'           => $vehicle['Year'],
                'make'           => $vehicle['Make'],
                'model'          => $vehicle['Model'],
                'trim'           => $vehicle['Trim'],
                'body_style'     => $vehicle['BodyStyle'],
                'kilometres'     => $vehicle['Mileage'],
                'price'          => $vehicle['Price'],
                'engine'         => $vehicle['Engine'],
                'transmission'   => $vehicle['Tramsission'],
                'exterior_color' => $vehicle['Color'],
                'interior_color' => $vehicle['Interior'],
                'msrp'           => $vehicle['MSRP'],
                'images'        => explode(',', $vehicle['ImageURLs']),
                //'all_images'    => implode('|', $images),
                'url'            => $vehicle['VehicleDetailsPage'],
                'stock_type' => $vehicle['Condition'] == 'N' ? 'new' : 'used',
                'fuel_type'     => $vehicle['Fuel_Type'],
                //'description'    => $vehicle['Description'],
            ];
            
            $ignore_data=[
                    'P15109',
                   // '62005',
                ];
            if (in_array($car_data['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car_data['stock_number']}");
                continue;

            }
            unset($car_data['images'][0]);
            unset($car_data['images'][1]);
            $car_data['all_images'] = implode('|', $car_data['images']);
            $result[] = $car_data;
        }

        return $result;
    }
);
 
add_filter('filter_performancedodgejeepcom_car_data', 'filter_performancedodgejeepcom_car_data');
function filter_performancedodgejeepcom_car_data($car_data)
{               
            
    if($car_data['url']==""){
        $car_data = [];
    }
    
    return $car_data;
}

add_filter("filter_performancedodgejeepcom_field_images", "filter_performancedodgejeepcom_field_images");
    
function filter_performancedodgejeepcom_field_images($im_urls)
{
    //removing first two image. 
    unset($im_urls[0]);
    unset($im_urls[1]);
       
    return $im_urls;
}
