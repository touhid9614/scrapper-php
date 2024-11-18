<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$all_brands = $db_connect->get_meta('general_config', 'brands');
print_r($all_brands);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

