<?php

// require_once('config.php');
require_once 'Util.php';
require_once 'Types.php';

global $google_config, $set_path, $google_config_new;

$Configs  = LoadConfig($set_path);
$customer = '';

/**
 * Gets the current google customer.
 *
 * @return     <type>  The current google customer.
 */
if (!function_exists("get_current_google_customer")) {
    function get_current_google_customer()
    {
        return isset($_GET['customer']) ? $_GET['customer'] : 'marshal';
    }
}

if (!isset($_GET['customer'])) {
    if (!isset($_SESSION['customer'])) {
        die("Please specify a customer identifier using 'customer' query string like cron.php?customer=barbermotors");
    } else {
        $customer = $_SESSION['customer'];
    }
} else {
    $customer = $_GET['customer'];
}

$token_helper = new TokenHelper();

if (!isset($Configs->AccessTokens[$customer])) {
    $_SESSION['customer'] = $customer;

    if (!defined('smedia_tag')) {
        echo "<script>window.location.href=\"" . $token_helper->GetRequestURL($google_config_new[$customer]) . "\"</script>";
    }
} else {
    $CurrentConfig = $Configs->AccessTokens[$customer];

    if (!$token_helper->CheckAccessToken($CurrentConfig)) {
        $access_token = $token_helper->RefreshAccessToken($google_config_new[$customer], $CurrentConfig);

        if ($access_token) {
            $CurrentConfig                    = $access_token;
            $Configs->AccessTokens[$customer] = $CurrentConfig;
            SaveConfig($Configs, $set_path);
        }
    } else {
        $access_token = $CurrentConfig;
    }
}

$CurrentConfig = $Configs->AccessTokens[$customer];
