<?php
//header('Content-type: text/javascript; charset=UTF-8');
require_once 'config.php';
require_once 'boe_db_connect.php';

$cron_name      = 'toyotabountiful';
$cron_config    = $CronConfigs[$cron_name];

$button_config  = $cron_config['buttons'];

$data = boedb_get_dealership_data($cron_name, date('Y-m-d'));


//json_dump('sm_button_data', calculate_option_score($data, $button_config));
dump($data);
//json_dump('sm_button_confs', $button_config);

function dump($data) {
    echo '<pre>';
    echo json_encode($data, JSON_PRETTY_PRINT);
    echo '</pre>';
}

function json_dump($veriable_name, $data) {
    echo "var $veriable_name = " . json_encode($data) . ";\n";
}

function calculate_option_score($data, $button_config) {
    $retval = [];
    
    foreach($button_config as $button => $config) {
        
        $button_data = isset($data[$button])?$data[$button]:[];
        
        //Filter locations
        foreach ($config['locations'] as $location => $details) {
            $retval[$button]['locations'][$location] = isset($button_data['location'][$location])?calculate_score($button_data['location'][$location]):calculate_score();
        }
        
        //Sizes
        foreach ($config['sizes'] as $size => $details) {
            $retval[$button]['sizes'][$size] = isset($button_data['size'][$size])?calculate_score($button_data['size'][$size]):calculate_score();
        }
        
        //Styles
        foreach ($config['styles'] as $style => $details) {
            $retval[$button]['styles'][$style] = isset($button_data['style'][$style])?calculate_score($button_data['style'][$style]):calculate_score();
        }
        
        //Texts
        foreach ($config['texts'] as $text_key => $details) {
            foreach($details['values'] as $text) {
                $retval[$button]['texts'][$text_key][$text] = isset($button_data["text_{$text_key}"][$text])?calculate_score($button_data["text_{$text_key}"][$text]):calculate_score();
            }
        }
    }
    
    return $retval;
}

function calculate_score($option_data = null) {
    if(!$option_data) { return 1; }
    
    $retval = (1.0 * $option_data['clicked'] + 100.0 * $option_data['fillup'])/$option_data['viewed'];
    
    if($retval == 0) { $retval = 0.00000001 * max([1, (5000 - $option_data['viewed'])]); }  //So that we don't get ride of it all together
    
    return $retval;
}