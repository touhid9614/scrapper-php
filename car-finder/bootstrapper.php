<?php

global $argv;

$argv = [];

#special scrappers
if (!defined('ABSPATH')) {
    define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
}

if (!defined('ADSYNCPATH')) {
    define('ADSYNCPATH', dirname(ABSPATH) . '/adwords3');
}

if (!defined('CACHEDIR')) {
    define('CACHEDIR', ABSPATH . 'cache/');
}

require_once ADSYNCPATH . '/config.php';
require_once ADSYNCPATH . '/utils.php';
require_once ADSYNCPATH . '/db_connect.php';
require_once ADSYNCPATH . '/Google/Util.php';

function json_echo($value)
{
    echo json_encode($value);
}

require_once 'includes/ajax_inc.php';

$max_year       = get_field('max_year');
$min_year       = get_field('min_year');
$model          = get_field('model');
$make           = get_field('make');
$range          = get_field('range');
$post_code      = get_field('post_code');
$color          = get_field('color');
$transmission   = get_field('transmission');
$max_price      = get_field('max_price');
$min_price      = get_field('min_price');
$max_kilometers = get_field('max_kilometers');
$min_kilometers = get_field('min_kilometers');
$search_new     = get_field('search_new', 'on', 'check');
$search_used    = get_field('search_used', 'on', 'check');
$search_private = get_field('search_private', 'on', 'check');
$search_dealer  = get_field('search_dealer', 'on', 'check');
$page           = get_field('page', 1);

function get_field($name, $default = '', $type = 'text')
{
    switch ($type) {
        case 'text':
            return isset($_GET[$name]) ? $_GET[$name] : $default;
        case 'check':
            return isset($_GET[$name]) ? $_GET[$name] == $default : false;
    }
}
