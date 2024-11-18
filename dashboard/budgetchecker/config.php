<?php

$tmp_path       = dirname(__FILE__) . '/';
$abs_path       = str_replace('\\', '/', $tmp_path);
$abs_path       = dirname($abs_path);
$path           = dirname($abs_path) . '/adwords3/';
$dashboard_path = dirname($abs_path) . '/dashboard/';

if (!defined('ABSPATH')) {
    define('ABSPATH', $abs_path);
}

if (!defined('ADSYNCPATH')) {
    define('ADSYNCPATH', $path);
}

if (!defined('CACHEDIR')) {
    define('CACHEDIR', $dashboard_path . 'cache/');
}

if (!defined('INSDIR')) {
    define('INSDIR', 'dashboard');
}

//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS']       = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes

$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
if (defined('INSDIR')) {
    $url .= '/' . INSDIR;
}

if (!defined('ABSURL')) {
    define('ABSURL', $url . '/');
}
