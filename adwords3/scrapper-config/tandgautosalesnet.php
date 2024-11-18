<?php
global $scrapper_configs;
$scrapper_configs["tandgautosalesnet"] = array(
    'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/tgauto/tgauto.csv'
    ),
    
   'srp_page_regex'         => '/\/cars-for-sale/i', 
    'vdp_url_regex'     => '/details\/(?:new|certified|used)-[0-9]{4}-.*\/[0-9]{4,17}/',
    'use-proxy'         => true,
    'refine'            => false,

    'custom_data_capture' => function($url, $resp) {
      $vehicles = convert_CSV_to_JSON($resp);

      $result = [];

      foreach ($vehicles as $vehicle) {
          $car_data = [
            'stock_number' => $vehicle['vehicle_id'],
            'vin' => $vehicle['Vin'],
            'year' => $vehicle['Year'],
            'make' => $vehicle['Make'],
            'model' => $vehicle['Model'],
            'trim' => $vehicle['Trim'],
            'body_style' => $vehicle['Body Type'],
            'all_images' => str_replace(",", "|", $vehicle['image']),
            'price' => $vehicle['Price'],
            'url' => $vehicle['url'],
            'stock_type' => strtolower($vehicle['state_of_vehicle']),
            'kilometres' => $vehicle['Mileage'],
          ];
          $result[] = $car_data;
      }

      return $result;
  }
);