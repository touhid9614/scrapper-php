<?php

$tmp_path       = dirname(__FILE__) . '/';
$abs_path       = str_replace('\\', '/', $tmp_path);
$path           = dirname($abs_path) . '/adwords3/';
$dashboard_path = dirname($abs_path) . '/dashboard/';

// ABSPATH is root
if (!defined('ABSPATH')) {
    define('ABSPATH', $abs_path);
}

// ADSYNCPATH is adwords3
if (!defined('ADSYNCPATH')) {
    define('ADSYNCPATH', $path);
}

if (!defined('CACHEDIR')) {
    define('CACHEDIR', $dashboard_path . 'cache/');
}

if (!defined('INSDIR')) {
    define('INSDIR', 'dashboard');
}

$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];

if (defined('INSDIR')) {
    $url .= '/' . INSDIR;
}

if (!defined('ABSURL')) {
    define('ABSURL', $url . '/');
}
