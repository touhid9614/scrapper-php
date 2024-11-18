<?php

$tmp_path = dirname(__FILE__);
$abs_path = str_replace('\\', '/', $tmp_path);
$core_path = dirname($abs_path) . '/adwords3';

if(!defined('CORE_DIR')) {
    define('CORE_DIR', $core_path);
}

$data_dir = "$core_path/data";

if(!defined('DATA_DIR')) {
    define('DATA_DIR', $data_dir);
}

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once CORE_DIR . '/utils.php';
require_once dirname(__DIR__) . '/smedia-scripts/config.php';

/***************************************************************************
 * Begin: Session File Related Functions
 */

function getSessionDir($url, $time = 0) {
    if(!$time) { $time = time(); }
    $domain = GetDomain($url);
    $year = date('Y', $time);
    $month = date('F', $time);
    
    return DATA_DIR . "/session/$domain/$year/$month";
}

function getSessionFileByTime($event_timestamp = 0) {
    if(!$event_timestamp) { $event_timestamp = time(); }
    return date('d') . '.json';
}

function getSessionFilePath($url, $time = 0) {
    $dir = getSessionDir($url, $time);
    
    if(createDir($dir)) {
        $file = getSessionFileByTime($time);
        return "$dir/$file";
    }
    
    return null;
}

/**
 * End: Session Files
 ***************************************************************************/

/***************************************************************************
 * Begin: User File Related Functions
 */

function getUserDir() {
    return DATA_DIR . "/users";
}

function getUserFileById($user_id) {
    return substr($user_id, 0, 2) . '.json';
}

function getUserFilePath($user_id) {
    $dir = getUserDir();
    
    if(createDir($dir)) {
        $file = getUserFileById($user_id);
        return "{$dir}/{$file}";
    }
    
    return null;
}

/**
 * End: User Files
 ***************************************************************************/

function createDir($dir) {
    if(file_exists($dir)) { return true; }
    return mkdir($dir, 0777, true);
}
