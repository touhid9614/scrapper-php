<?php

/**
 * Return top N significant features, if N <= 0 return all
 * 
 * @param array $features List of features with mean and SD as an associative array ['page_views'=>['mean' => x, 'sd' => y],...]
 * @param number $max_count Maximum number to features to select from significance list
 * @return array Top N most significant features, if N <= 0 return all
 */
function get_significant_features($features, $max_count = 0) {
    $significance_points = [];
    
    foreach($features as $key => $value) {
        if($value['mean'] == 0 || $value['sd'] == 0) {continue; }   #ignore if either value is zero
        $significance_points[$key] = intval(($value['mean']/$value['sd']) * 100);
    }
    
    $top_significants = array_filter($significance_points, function($v) { return $v > 0; });
    
    arsort($top_significants);
    
    return $max_count? array_slice($top_significants, 0, $max_count) : $top_significants;
}

/**
 * 
 * @param array $features Features list be it overall, daily/vehicle or per page view
 * @param array $significant_features list of significant features
 * @return array Associative array with values of significant features extracted from features
 */
function get_significant_values($features, $significant_features) {
    
    $retval = [];
    
    $keys = array_intersect(array_keys($significant_features), array_keys($features));
    
    foreach($keys as $key) {
        $retval[$key] = $features[$key];
    }
    
    return $retval;
}

/**
 * 
 * @param array $features
 * @param array $significance
 * @return Significance value based on the features and significance
 */
function calculate_point_range($features, $significance) {
    $retval = [
        'min'   => 0,
        'max'   => 0
    ];
    
    foreach($significance as $key => $value) {
        $retval['min'] += max(0, ($features[$key]['mean'] - ($features[$key]['sd']/2)) * $value);
        $retval['max'] += max(0, ($features[$key]['mean'] + ($features[$key]['sd'])) * $value);
    }
    
    return $retval;
}

/**
 * 
 * @param array $vehicle_features
 * @param array $significance
 */
function calculate_vehicle_point($vehicle_features, $significance) {
    $retval = 0;
    
    foreach($significance as $key => $value) {
        $retval += max(0, ($vehicle_features[$key] * $value));
    }
    
    return $retval;
}

/**
 * 
 * @param array $vehicle_point features of the current vehicle to predict, only significant features will do
 * @param array $daily_gains Daily gain for each vehicle in the inventory
 * @param array $target_points target feature based on sale matrices
 * @return array Predict maximum and minimum required days or 0 if appears to be outlier
 */
function predict_required_days($vehicle_point, $daily_gains, $target_points) {
    
    $retval = [
        'max'   => -1,
        'min'   => -1
    ];
    
    if($daily_gains['max'] <= 0) { return $retval; } //Can't predict if there isn't any daily gain
    
    $max_required = max(0, $target_points['max'] - $vehicle_point);
    $min_required = max(0, $target_points['min'] - $vehicle_point);
    
    $retval['min'] = ceil($min_required/$daily_gains['max']);
    
    if($daily_gains['min'] > 0) {
        $retval['max'] = ceil($max_required/$daily_gains['min']);
    }
    
    return $retval;
}

/**
 * 
 * @param number $next_n_days Size of the prediction window in days from date of prediction
 * @param number $min_prediction Prediction for minimum number of required days to sale the vehicle
 * @param number $max_prediction Prediction for maximum number of required days to sale the vehicle
 * @return number A percentage signifying the chance of vehicle being sold in next N days
 */
function chance_of_being_sold($next_n_days, $min_prediction, $max_prediction, $max_value = 95, $min_value = 5) {
    
    if($max_prediction == -1) { return 999; }
    
    $days_in_window = $next_n_days - $min_prediction;
    
    if($days_in_window <= 0) { return $min_value; } //Return the minimum chance if the min prediction isn't within n days window
    
    if($max_prediction - $min_prediction <= 0) { return $max_value; } //Return highest chance if the window has already passed
    
    if($max_prediction - $min_prediction < $days_in_window) { $days_in_window = $max_prediction - $min_prediction; }
    
    $chance = max($min_value, ($days_in_window/($max_prediction - $min_prediction)) * $max_value);
    
    return $chance;
}