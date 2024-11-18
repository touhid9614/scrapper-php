<?php

// Force redirect for dashboard and tools.
$hostname = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

if (!defined("NO_REDIRECT") && $hostname != '' && $hostname != 'tools.smedia.ca' && $hostname != 'localhost' && $hostname != 'tm-dev.smedia.ca' && $hostname != 'smedia-inventory.test') {
    header("Location: https://tools.smedia.ca" . $_SERVER['REQUEST_URI']);
    exit;
}

$tmp_path      = dirname(__FILE__) . '/';
$abs_path      = str_replace('\\', '/', $tmp_path);
$path          = dirname($abs_path) . '/adwords3/';
$debugger_path = dirname($abs_path) . '/debugger/';

if (!defined('ABSPATH')) {
    define('ABSPATH', $abs_path);
}

if (!defined('ADSYNCPATH')) {
    define('ADSYNCPATH', $path);
}

if (!defined('CACHEDIR')) {
    define('CACHEDIR', ABSPATH . 'cache/');
}

if (!defined('DEALER_DATA_CACHE')) {
    define('DEALER_DATA_CACHE', ADSYNCPATH . "dealer_cache/dealer_data/");
}

if (!defined('DEBUGGER_PATH')) {
    define('DEBUGGER_PATH', $debugger_path);
}

if (!defined('IMGCACHEDIR')) {
    define('IMGCACHEDIR', ABSPATH . 'img-cache/');
}

if (!defined('INSDIR')) {
    define('INSDIR', 'dashboard');
}

if (!defined('DATA_DIR')) {
    define('DATA_DIR', ADSYNCPATH . 'data/');
}

if (!defined('ENCRYPTION_KEY')) {
    define('ENCRYPTION_KEY', 'ubwaFUhBxa09/wLCnYsVXT+Hc75u81d/nUJRQCKJRtA=');
}

if (!defined('DASHBOARD_URL')) {
    define('DASHBOARD_URL', "https://tools.smedia.ca/dashboard");
}

if (!defined('DATA_DIR_URL') && isset($_SERVER['HTTP_HOST'])) {
    define('DATA_DIR_URL', "https://{$_SERVER['HTTP_HOST']}/adwords3/data/");
}

$url = 'https://';
$url .= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'tm.smedia.ca';

if (defined('INSDIR')) {
    $url .= '/' . INSDIR;
}

if (!defined('ABSURL')) {
    define('ABSURL', $url . '/');
}
