<?php

use sMedia\AiButton\AiButtonCombination;

require_once ADSYNCPATH . '/boe_db_connect.php';
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

function ai_button_data($dealership, $buttons, $ai_button_algorithm)
{
    $ai_button_combinations = [];

    foreach ($ai_button_algorithm as $algorithm) {
        if ($algorithm != 'default') {
            $aiButton = new AiButtonCombination($dealership, $buttons, DbConnect::get_connection_read(), $algorithm);
            $aiButton->generateCombination()->saveCombination(DbConnect::get_connection_read(), DbConnect::get_connection_write());
            $aibutton_data[$algorithm]          = $aiButton->getData($algorithm);
            $ai_button_combinations[$algorithm] = $aiButton->combinations;
            unset($aiButton);
        } else {
            $data                      = boedb_get_dealership_data($dealership, date('Y-m-d'));
            $aibutton_data[$algorithm] = calculate_option_score($data, $buttons);
        }
    }

    return ['combinations' => $ai_button_combinations, 'algorithm' => $ai_button_algorithm, 'data' => $aibutton_data];
}

function calculate_option_score($data, $button_config)
{
    $retval = [];

    foreach ($button_config as $button => $config) {
        $button_data = isset($data[$button]) ? $data[$button] : [];

        // Filter locations
        foreach ($config['locations'] as $location => $details) {
            $retval[$button]['locations'][$location] = isset($button_data['location'][$location]) ? calculate_score($button_data['location'][$location]) : calculate_score();
        }

        // Sizes
        foreach ($config['sizes'] as $size => $details) {
            $retval[$button]['sizes'][$size] = isset($button_data['size'][$size]) ? calculate_score($button_data['size'][$size]) : calculate_score();
        }

        // Styles
        foreach ($config['styles'] as $style => $details) {
            $retval[$button]['styles'][$style] = isset($button_data['style'][$style]) ? calculate_score($button_data['style'][$style]) : calculate_score();
        }

        // Texts
        foreach ($config['texts'] as $text_key => $details) {
            foreach ($details['values'] as $text) {
                $retval[$button]['texts'][$text_key][$text] = isset($button_data["text_{$text_key}"][$text]) ? calculate_score($button_data["text_{$text_key}"][$text]) : calculate_score();
            }
        }
    }

    return $retval;
}

function calculate_score($option_data = null)
{
    if (!$option_data || $option_data['viewed'] <= 0) {
        return 1;
    }

    $retval = (1.0 * $option_data['clicked'] + 10.0 * $option_data['fillup']) / $option_data['viewed'];

    if ($retval == 0) {
        $retval = 0.0001 * max([1, (5000 - $option_data['viewed'])]);
    } // So that we don't get rid of it all together

    return $retval;
}