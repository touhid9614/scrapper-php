<?php

    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'db_connect.php';
    
    global $user, $connection;

    if ($user['type'] != 'a') do_redirect ();
    if (!isset($_POST['cron_name'])) do_redirect ();
    
    $budget = array();
    
    if (isset($_POST['max_cost']))
    {
        $budget['max_cost'] = floatval($_POST['max_cost']);
    }
    
    if (isset($_POST['cost_distribution']))
    {
        foreach($_POST['cost_distribution'] as $name => $value)
        {
            $budget['cost_distribution'][$name] = floatval($value);
        }
    }
    
    $loc_mutex = Mutex::create();
    $loc_db_connect = new DbConnect('murraywin');
    $loc_db_connect->update_meta('budget', $_POST['cron_name'], $budget);
    
    Mutex::destroy($loc_mutex);
    
    do_redirect();
    
    function do_redirect()
    {
        if(isset($_SERVER['HTTP_REFERER'])) header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
?>
