<?php
global $scrapper_configs;
$scrapper_configs["needwheelsca"] = array(
    'entry_points'        => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/needwheels.csv',
    ),
    'vdp_url_regex'       => '/\/view\/(?:used|new)-[0-9]{4}-/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.vgs__container__img'],
    'picture_nexts'       => ['.vgs__next'],
    'picture_prevs'       => ['.vgs__prev'],

    'custom_data_capture' => function ($url, $resp) {
        $exploded = explode("\n", $resp);
        $csvloded = [];
        $vehicles = [];
        $cars     = [];

        foreach ($exploded as $odcsv) {
            $csvloded[] = explode("|", $odcsv);
        }

        $columns     = array_shift($csvloded);
        $columns[29] = 'VdpUrl'; // Change from `VDP Url` which gets rejected

        foreach ($csvloded as $row_index => $row_data) {
            $vehicles[] = array_combine($columns, $row_data);
        }

        foreach ($vehicles as $vehicle) {
            $cars[] = [
                'stock_type'     => strtolower($vehicle['Condition']),
                'year'           => $vehicle['Year'],
                'make'           => $vehicle['Make'],
                'model'          => $vehicle['Model'],
                'trim'           => $vehicle['Trim'],
                'stock_number'   => $vehicle['StockNumer'],
                'vin'            => $vehicle['VIN'],
                'url'            => substr($vehicle['VdpUrl'], 0, -2),
                'price'          => $vehicle['Price'],
                'drivetrain'     => $vehicle['Drive'],
                'fuel_type'      => $vehicle['Fuel'],
                'body_style'     => $vehicle['Type'],
                'all_images'     => $vehicle['Photo'] . '|' . str_replace(';', '|', $vehicle['AdditionalPhotos']),
                'exterior_color' => $vehicle['ExteriorColor'],
                'interior_color' => $vehicle['InteriorColor'],
                'engine'         => $vehicle['Engine'],
                'transmission'   => $vehicle['Transmission'],
                'doors'          => $vehicle['Doors'],
                'description'    => trim(strip_tags($vehicle['Description'])),
                'options'        => trim(strip_tags($vehicle['Options'])),
                'kilometres'     => $vehicle['Kilometers'],
            ];
        }

        return $cars;
    }
);