<?php

global $scrapper_configs;

$scrapper_configs["hondapowersportsparts"] = array(
    'entry_points'        => array(
        'new' => 'https://tm.smedia.ca/adwords3/client-data/hondapowersportsparts/hondapowersportsparts.csv',
    ),

    'vdp_url_regex'       => '/\/(?:oemcatalogs|oemparts)\//',
    'custom_data_capture' => function ($url, $resp) {
        $resp_decode = csv_real_decode($resp);
        $to_return   = [];

        foreach ($resp_decode as $key => $obj) {
            $car_data = array(
                'stock_number' => $obj['PART NUMBER'],
                'make'         => "HONDA",
                'model'        => $obj['PART DESCRIPTION'],
                'price'        => $obj['SUGGESTED RETAIL PRICE'],
                'url'          => 'https://www.hondapowersportsparts.com/oemparts/c/honda/parts',
                'svin'         => url_to_svin('https://www.hondapowersportsparts.com/oemparts/c/honda/parts' . $obj['PART NUMBER']),
            );

            $to_return[] = $car_data;
        }
        return $to_return;
    }
);