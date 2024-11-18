<?php

//Working directory can be different for different requests
//Please use absolute path to include additional files
require_once dirname(dirname(__DIR__)) . '/adwords3/boe_db_connect.php';
use sMedia\AiButton\AiButtonCombination;
use sMedia\AiButton\AiButtonData;

add_filter('filter_button_option', 'filter_button_option', 10, 7);
function filter_button_option($option, $dealership, $available_options, $user_id, $button_name, $option_group, $stock_type)
{
    boedb_bs_set_last_viewed($dealership);

    $rows = boedb_get_rows($dealership, $available_options, $button_name, $option_group, $stock_type, date("Y-m-d"));

    if (!$rows) {
        $i = rand(0, count($available_options) - 1);
        boedb_record_increase_count($dealership, $available_options[$i], $user_id, $button_name, $option_group, $stock_type, '', date("Y-m-d"), 'viewed');
        echo "\n//Randomly returning: " . $available_options[$i] . "\n";
        return $available_options[$i];
    } else {
        $cache_directory = dirname(dirname(__DIR__)) . "/adwords3/caches/button-data/";
    
        $cache_file = $cache_directory . md5(json_encode(func_get_args())) . ".pdat";
        
        if (!($data = get_data_cache($cache_file, 6))) {
            $data = array();
            foreach ($available_options as $item) {
                $data[$item] = 1;
            }

            $min_score = 0;
            foreach ($rows as $row) {
                // dealership, option1, total_viewed, total_clicked, total_fillup
                if ($row['total_viewed'] > 0) {
                    $score = (1.0 * $row['total_clicked'] + 100.0 * $row['total_fillup']) / $row['total_viewed'];
                } else {
                    $score = 0.0;
                }

                if ($score > 0 && $score < $min_score) {
                    $min_score = $score;
                }

                $data[$row['option1']] = $score;
            }
            
            $min_score = $min_score == 0 ? 0.00000001 : $min_score/10000;
            foreach ($available_options as $item) {
                if ($data[$item] == 0) {
                    $data[$item] = $min_score * $min_score * $min_score;
                } else {
                    $data[$item] = $data[$item] * $data[$item] * $data[$item];
                }
            }
            
            store_data_cache($cache_file, $data);
        }

        echo "\n//Data: " . json_encode(normalize_data($data)) . "\n";
        
        $sum = 0;
        foreach ($data as $item) {
            $sum += $item;
        }

        $factor = random_float(0, $sum);

        $cur_sum = 0;
        $sel_option = $available_options[0];
        foreach ($data as $key => $score) {
            $cur_sum += $score;
            if ($cur_sum >= $factor) {
                $sel_option = $key;
                break;
            }
        }

        boedb_record_increase_count($dealership, $sel_option, $user_id, $button_name, $option_group, $stock_type, '', date("Y-m-d"), 'viewed');
        return $sel_option;
    }
}

add_action('smart_button_viewed', 'smart_button_viewed', 10, 6);
function smart_button_viewed($dealership, $option, $user_id, $button_name, $option_group, $stock_type)
{
    boedb_record_increase_count($dealership, $option, $user_id, $button_name, $option_group, $stock_type, '', date("Y-m-d"), 'viewed');
}

add_action('smart_form_viewed', 'smart_form_viewed', 10, 6);
function smart_form_viewed($dealership, $option, $user_id, $button_name, $option_group, $stock_type)
{
    boedb_record_increase_count($dealership, $option, $user_id, $button_name, $option_group, $stock_type, '', date("Y-m-d"), 'form_viewed');
}

add_action('smart_button_clicked', 'smart_button_clicked', 10, 6);
function smart_button_clicked($dealership, $option, $user_id, $button_name, $option_group, $stock_type)
{
    boedb_record_increase_count($dealership, $option, $user_id, $button_name, $option_group, $stock_type, '', date("Y-m-d"), 'clicked');
}


// utility functions

function random_float($min, $max)
{
    return ($min + lcg_value()*(abs($max - $min)));
}

//
add_action('smart_button_fillup', 'smart_button_fillup', 10, 7);
function smart_button_fillup($dealership, $option, $user_id, $button_name, $option_group, $stock_type, $form)
{
    boedb_record_increase_count($dealership, $option, $user_id, $button_name, $option_group, $stock_type, $form, date("Y-m-d"), 'fillup');
}

/*
** Combination - action
*/

add_action('smart_button_combination_viewed', 'smart_button_combination_viewed', 10, 4);
function smart_button_combination_viewed($dealership, $button_name, $combination, $stock_type)
{
    boedb_bs_set_last_viewed($dealership);
    boedb_tbcs_record_increase_count($dealership, $button_name, $combination, $stock_type, '', date("Y-m-d"), 'viewed');
}

add_action('smart_form_combination_viewed', 'smart_form_combination_viewed', 10, 4);
function smart_form_combination_viewed($dealership, $button_name, $combination, $stock_type)
{
    boedb_tbcs_record_increase_count($dealership, $button_name, $combination, $stock_type, '', date("Y-m-d"), 'form_viewed');
}


add_action('smart_button_combination_clicked', 'smart_button_combination_clicked', 10, 4);
function smart_button_combination_clicked($dealership, $button_name, $combination, $stock_type)
{
    boedb_tbcs_record_increase_count($dealership, $button_name, $combination, $stock_type, '', date("Y-m-d"), 'clicked');
}

add_action('smart_button_combination_fillup', 'smart_button_combination_fillup', 10, 5);
function smart_button_combination_fillup($dealership, $button_name, $combination, $stock_type, $form)
{
    boedb_tbcs_record_increase_count($dealership, $button_name, $combination, $stock_type, $form, date("Y-m-d"), 'fillup');
}

/*
 *  $dealership_name: dealership name
 *  $status: True or false
 *
 *  return:
 */
function set_button_live($dealership_name, $status)
{
    boedb_bs_set_status($dealership_name, $status);
    return;
}

function is_button_live($dealership_name)
{
    return boedb_bs_get_status($dealership_name);
}

add_filter('filter_button_is_live', 'filter_button_is_live', 10, 2);
function filter_button_is_live($is_live, $dealership_name)
{
    //return is_button_live($dealership_name);
    return $is_live;
}

function normalize_data(&$data)
{
    $values = array_values($data);
    for ($i = 0; $i < count($values); $i++) {
        if ($values[$i] <= 0) {
            unset($values[$i]);
        }
    }
    
    $min = min($values);
    
    foreach ($data as $key => $value) {
        $data[$key] = $value / $min;
    }
    
    return $data;
}


function update_ai_button_score_in_cache($cache_file, $algorithm, $dealership) {
    if (file_exists($cache_file)) {
        //$re = "/\/\/sm_button_data-{$algorithm}(.|\r|\n|\r\n)*\/\/--sm_button_data-{$algorithm}/m";
        $re = "/\/\/sm_button_data-{$algorithm}(.*(\n))*\/\/--sm_button_data-{$algorithm}/m";
        $jsdata = unserialize(file_get_contents($cache_file));
        $aiButton = new AiButtonCombination($dealership, [], DbConnect::get_connection_read(), $algorithm);
        $json_algo_data = json_encode($aiButton->getData($algorithm));
        $aibutton_data = "//sm_button_data-{$algorithm}\n";
        $aibutton_data .= "sm_button_data['{$algorithm}'] = {$json_algo_data}\n";
        $aibutton_data .= "//--sm_button_data-{$algorithm}\n";
        $newjsdata = preg_replace($re, $aibutton_data, $jsdata);
        file_put_contents($cache_file, serialize($newjsdata));
    }
}

add_action('smart_button_combination_new_viewed', 'increase_button_view', 10, 5);
function increase_button_view($dealership, $combination, $algorithm, $cache_file, $stock_type)
{
    AiButtonData::increaseView($combination, $stock_type, DbConnect::get_connection_read(), DbConnect::get_connection_write(), $algorithm);
    update_ai_button_score_in_cache($cache_file, $algorithm, $dealership);
}

add_action('smart_button_combination_new_clicked', 'increase_button_click', 10, 5);

function increase_button_click($dealership, $combination, $algorithm, $cache_file, $stock_type)
{
    AiButtonData::increaseClick($combination, $stock_type, DbConnect::get_connection_read(), DbConnect::get_connection_write(), $algorithm);
    update_ai_button_score_in_cache($cache_file, $algorithm, $dealership);
}

add_action('smart_button_combination_new_fillup', 'increase_button_fillup', 10, 5);

function increase_button_fillup($dealership, $combination, $algorithm, $cache_file, $stock_type)
{
    AiButtonData::increaseFillUp($combination, $stock_type, DbConnect::get_connection_read(), DbConnect::get_connection_write(), $algorithm);
    update_ai_button_score_in_cache($cache_file, $algorithm, $dealership);
}
