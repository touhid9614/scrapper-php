<?php

$tmp_path = dirname(__FILE__);
$abs_path = str_replace('\\', '/', $tmp_path);
$core_path = dirname($abs_path) . '/adwords3';

if(!defined('CORE_DIR')) {
    define('CORE_DIR', $core_path);
}

require_once dirname(__DIR__) . '/adwords3/config.php';
require_once dirname(__DIR__) . '/adwords3/utils.php';
require_once dirname(__DIR__) . '/adwords3/cron_misc.php';
require_once dirname(__DIR__) . '/adwords3/Google/Util.php';
require_once dirname(__DIR__) . '/adwords3/db_connect.php';

header('Content-type: application/json; charset=UTF-8');
header("Accept: application/json,application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Request-Headers: X-PINGOTHER, Content-Type");

global $CronConfigs, $scrapper_configs;

use Predis\Client as RedisClient;

$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

$cron_name  = filter_input(INPUT_GET, 'dealership');
$act        = filter_input(INPUT_GET, 'act');

if(!in_array($cron_name, $cron_names)) {
    write_response('Dealership not found', false);
}

$scrapper_config = $scrapper_configs[$cron_name];

if(!isset($scrapper_config['vdp_url_regex']) || !isset($scrapper_config['client_scrapping'])) {
    write_response("Configuration isn\'t present for $cron_name", false);
}

$client_configuration = $scrapper_config['client_scrapping'];

if(!isset($client_configuration['enabled']) || !isset($client_configuration['idx']) || !isset($client_configuration['data'])) {
    write_response("Invalid client configuration for $cron_name", false);
}

if(!$client_configuration['enabled']) {
    write_response("Client scrapping is turned off for $cron_name", false);
}

switch($act) {
    case "config":
        array_walk($client_configuration['idx'], function (&$value) {
            $value = filter_regex($value);
        });
        array_walk($client_configuration['data'], function (&$value) {
            $value = filter_regex($value);
        });
        $client_configuration['vdp_url_regex'] = filter_regex($scrapper_config['vdp_url_regex']);
        write_response($client_configuration);
        break;
    case "update":
        try {

            $data = json_decode(file_get_contents('php://input'), true);

            # Check redis cache for status
            $redis = new RedisClient($redis_config);

            $car_status_key = "vehicle_status_" . implode('_', array_values($data['idx']));

            if($redis->exists($car_status_key)) {
                write_response("Record was recently updated.");
            }

            $db_connect = DbConnect::get_instance($cron_name);

            #Update
            $query = "SELECT * FROM {$cron_name}_scrapped_data WHERE " . $db_connect->prepare_query_params($data['idx'], DbConnect::PREPARE_WHERE) . " LIMIT 1";

            $resp = $db_connect->query($query);

            if($resp) {
                if(mysqli_num_rows($resp) <= 0) {
                    $redis->set($car_status_key, time());  //Was checked and recheck in 6 hours
                    $redis->expire($car_status_key, 6 * 60 * 60);

                    write_response("No record found to update", false);
                }

                if(isset($data['data']['url'])) {
                    $data['data']['url'] = mild_url_encode($data['data']['url'], isset($scrapper_config['required_params']) ? $scrapper_config['required_params'] : []);
                }

                $car_data = mysqli_fetch_array($resp);

                $has_change = false;

                foreach ($data['data'] as $key => $value) {
                    $data['data'][$key] = apply_filters("filter_{$cron_name}_field_{$key}", $value, $car_data);

                    if($data['data'][$key] != $car_data[$key]) {
                        $has_change = true;
                    }
                }

                $redis->set($car_status_key, time());  //Updated, check in 24 hours
                $redis->expire($car_status_key, 24 * 60 * 60);

                if($has_change) {
                    $car_data = array_merge($car_data, $data['data']);

                    $db_connect->store_car_data($car_data);

                    write_response("Record updated successfully");
                } else {
                    write_response("Record is up to date");
                }
            } else {
                $redis->set($car_status_key, time());  //Was checked and recheck in 6 hours
                $redis->expire($car_status_key, 6 * 60 * 60);

                write_response("No match found to update", false);
            }
        } catch(Exception $ex) {
            write_response($ex->getMessage(), false);
        }
        break;
    default:
        write_response('Action not found', false);
        break;
}

function write_response($response, $success = true) {
    if($success) {
        echo json_encode(['success' => $success, 'result' => $response]);
    } else {
        echo json_encode(['success' => $success, 'error' => $response]);
    }
    exit;
}

function filter_regex($regex) {
    $teemp = substr($regex, 0, strripos($regex, '/'));
    return trim($teemp, "/");
}