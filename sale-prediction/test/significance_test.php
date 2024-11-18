<?php

require_once dirname(__DIR__) . '/predictor.php';

$featrues = [
    'page_view'     => ['mean' => 296.03,   'sd' => 217.02],
    'time>30'       => ['mean' => 20.70,    'sd' => 14.62],
    'time>60'       => ['mean' => 15.61,    'sd' => 11.53],
    'time>90'       => ['mean' => 12.33,    'sd' => 8.60],
    'scroll>25'     => ['mean' => 12.39,    'sd' => 8.99],
    'scroll>50'     => ['mean' => 7.85,     'sd' => 5.37],
    'scroll>75'     => ['mean' => 3.94,     'sd' => 3.25],
    'scroll=100'    => ['mean' => 1.79,     'sd' => 1.70],
    'button_click'  => ['mean' => 7.79,     'sd' => 5.34],
    'image_hover'   => ['mean' => 12.18,    'sd' => 10.67],
    'image_clicked' => ['mean' => 3.67,     'sd' => 4.77],
    'days'          => ['mean' => 65.363636,'sd' => 53.350651]
];

$vehicle_featrues = [
    'page_view'     => 296.03,
    'time>30'       => 14.62,
    'time>60'       => 11.53,
    'time>90'       => 8.60,
    'scroll>25'     => 8.99,
    'scroll>50'     => 5.37,
    'scroll>75'     => 3.25,
    'scroll=100'    => 1.7,
    'button_click'  => 5.34,
    'image_hover'   => 10.67,
    'image_clicked' => 4.77,
    'days'          => 53.350651
];

$daily_fetaures = [];

foreach($vehicle_featrues as $key => $value) {
    $daily_fetaures[$key] = [
        'mean'  => $vehicle_featrues[$key]/15,
        'sd'    => ($vehicle_featrues[$key]/50)
    ];
}

echo "<pre>\n";
print_r(get_significant_features($featrues));
print_r(get_significant_values($featrues, get_significant_features($featrues)));
echo "Point Range:\n";
$significance = get_significant_features($featrues);
$target_points = calculate_point_range(get_significant_values($featrues, $significance), $significance);
print_r($target_points);
echo "\nDaily Gains:\n";
$daily_gains = calculate_point_range($daily_fetaures, $significance);
print_r($daily_gains);
echo "\nVehicle Point: \n";
$vehicle_point = calculate_vehicle_point($vehicle_featrues, $significance);
print_r($vehicle_point);
echo "\nRequired Days: \n";
$required_days = predict_required_days($vehicle_point, $daily_gains, $target_points);
print_r($required_days);
echo "\nChance of Being Sold in next 7 days: \n";
$chance = chance_of_being_sold(7, $required_days['min'], $required_days['max']);
print_r($chance);
echo "\n</pre>";