<?php

global $admins, $scripts, $account_groups;

define('none', 0);
define('scrubber', 1);
define('closer', 2);
define('adwords', 4);
define('designer', 8);
define('closed', 16);

$admins_directory = ABSPATH . 'special/';
$admins           = [];
$account_groups   = [];

if (is_dir($admins_directory)) {
    foreach (array_filter(glob($admins_directory . '/*.php'), 'is_file') as $file) {
        require_once $file;
    }
}

$scripts = [];

/**
 * Adds a script.
 *
 * @param      <type>  $name   The name
 * @param      <type>  $path   The path
 */
function add_script($name, $path)
{
    global $scripts;

    $scripts[$name] = $path;
}

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ABSPATH . 'includes/functions.php';

# Don't initiate user session if 'NO_USER_SESSION' is defined
if (!defined('NO_USER_SESSION')) {
    require_once ABSPATH . 'includes/session-manager.php';
}
