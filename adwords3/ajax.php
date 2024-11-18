<?php

header('Content-Type: application/json');
define('dont_print', true);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/ajax-misc.php';
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/carlist-loader.php';
require_once __DIR__ . '/scrapper.php';

global $connection;

$acts = array(
    'add-carlist'      => 'ajax_add_carlist',
    'get-carlist'      => 'ajax_get_carlist',
    'get-unmatched'    => 'ajax_get_unmatched',
    'del-unmatched'    => 'ajax_del_unmatched',
    'get-dealerships'  => 'ajax_get_dealerships',
    'check-dealership' => 'ajax_check_dealership',
);

if (!isset($_GET['act']) || !isset($acts[$_GET['act']])) {
    die(json_encode(array('error' => 'Undefined action')));
}

$func = $acts[$_GET['act']];

if (!function_exists($func)) {
    die(json_encode(array('error' => 'Action not found')));
}

$db_connect = new DbConnect('murraywin');
$response   = call_user_func_array($func, array($db_connect));
echo json_encode($response);
$db_connect->close_connection();

function ajax_add_carlist(DbConnect $db_connect)
{
    if (!isset($_GET['year']) || !isset($_GET['make']) || !isset($_GET['model'])) {
        return array('error' => 'Year, Make and Model are required for this action');
    }

    $year  = $_GET['year'];
    $make  = $_GET['make'];
    $model = $_GET['model'];

    global $carlist;

    loadCarList();

    if (!(isset($carlist[$year]) && isset($carlist[$year][$make]) && isset($carlist[$year][$make][$model]))) {
        global $carlistdb_path;

        $fh         = fopen($carlistdb_path, 'a') or die(json_encode(array('error' => 'Unable to open carlist file')));
        $stringData = $year . ',"' . $make . '","' . $model . '", "", ""' . "\n";
        fwrite($fh, $stringData);
        fclose($fh);
    }

    $yearRegx  = '/\b' . strtolower($year) . '\b/';
    $makeRegx  = '/\b' . strtolower($make) . '\b/';
    $modelRegx = '/\b' . strtolower($model) . '\b/';
    $unmatched = $db_connect->get_unmatched_titles();
    $to_return = [];

    foreach ($unmatched as $car) {
        $car['title'] = strtolower($car['title']);
        if (preg_match($yearRegx, $car['title']) && preg_match($makeRegx, $car['title']) && preg_match($modelRegx, $car['title'])) {
            $id          = $car['id'];
            $to_return[] = $id;
            $db_connect->remove_unmatched_title($id);
        }
    }

    return $to_return;
}

function ajax_get_carlist(DbConnect $db_connect)
{
    global $carlist;
    $db_connect = null; //just to avoid warning
    loadCarList();
    return $carlist;
}

function ajax_get_unmatched(DbConnect $db_connect)
{
    return $db_connect->get_unmatched_titles();
}

function ajax_del_unmatched(DbConnect $db_connect)
{
    if (!isset($_GET['id'])) {
        return array('error' => 'Id is required for this action');
    }

    $count = 0;
    $ids   = $_GET['id'];

    if (!is_array($ids)) {
        $ids = array($ids);
    }

    foreach ($ids as $id) {
        $id = intval($id);

        if ($id > 0) {
            $db_connect->remove_unmatched_title($id);
            $count++;
        }
    }

    $message = $count . ' unmatched title has been resolved';

    if ($count == 0) {
        $message = 'No unmatched title has been resolved';
    } elseif ($count > 1) {
        $message = $count . ' unmatched titles have been resolved';
    }

    return array('message' => $message);
}

function ajax_get_dealerships(DbConnect $db_connect)
{
    global $CronConfigs, $scrapper_configs;
    $to_return = [];

    foreach ($scrapper_configs as $config_name => $scrapper_config) {
        if (!isset($CronConfigs[$config_name])) {
            continue;
        }

        $db_connect   = new DbConnect($config_name);
        $entry_points = get_domain_unique_entry_urls($db_connect, $scrapper_config, true);
        $to_return[]  = array(
            'name' => $config_name,
            'urls' => $entry_points,
        );
    }

    return $to_return;
}

function ajax_check_dealership(DbConnect $db_connect)
{
    global $CronConfigs, $scrapper_configs;

    if (!isset($_GET['name'])) {
        return array('error' => 'Dealership name is required');
    }

    $config_name = $_GET['name'];

    if (!isset($CronConfigs[$config_name]) || !isset($scrapper_configs[$config_name])) {
        return array('error' => 'Configuration does not exist for the dealership');
    }

    $db_connect = new DbConnect($config_name);
    $urls       = get_domain_unique_entry_urls($db_connect, $scrapper_configs[$config_name]);

    $result = array(
        'name' => $config_name,
    );

    set_time_limit(0);

    foreach ($urls as $url) {
        $domain                  = GetDomain($url);
        $result['urls'][$domain] = check_url_tag($config_name, $url);
    }

    return $result;
}
