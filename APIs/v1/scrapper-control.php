<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

/* SMEDIA DIRECTORY MAPPING */
$base_dir = dirname(dirname(__DIR__));
require_once $base_dir . '/vendor/autoload.php';

$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

$action          = filter_input(INPUT_POST, 'action');
$allowed_actions = ['stop_scrapper', 'stop_all_scrappers', 'start_scrapper', 'start_scrapper_domain', 'force_kill'];

if (!$action || !in_array($action, $allowed_actions)) {
    echo json_encode(['message' => 'No Such Action', 'success' => false, 'action' => $action]);

    return;
}

switch ($action) {
	case 'force_kill':
    	$pid = preg_replace('/[^0-9]/', '', filter_input(INPUT_POST, 'pid'));
		$resp = `kill $pid`;
    	echo json_encode(['message' => "Process with pid - {$pid} has been stopped", 'success' => true, 'action' => $action, 'command_response' => $resp], JSON_PRETTY_PRINT);
    	break;

    case 'stop_scrapper':
    	$pid = preg_replace('/[^0-9]/', '', filter_input(INPUT_POST, 'pid'));

		if (`ps aux |grep -v grep | grep $pid | grep ng_worker.php | wc -l` == 1) {
			$resp = `kill $pid`;
    		echo json_encode(['message' => "Process with pid - {$pid} has been stopped", 'success' => true, 'action' => $action, 'command_response' => $resp], JSON_PRETTY_PRINT);
    	} else {
    		echo json_encode(['message' => "Failed to terminate process with pid - {$pid}.", 'success' => false, 'action' => $action], JSON_PRETTY_PRINT);
    	}
        break;

    case 'stop_all_scrappers':
    	$resp = exec("ps aux |  grep -i php | grep ng_worker.php | grep -v grep | awk '{print $2}' | xargs kill");
    	echo json_encode(['message' => "All scrappers have been stopped", 'success' => true, 'action' => $action, 'command_response' => $resp], JSON_PRETTY_PRINT);
        break;

    case 'start_scrapper':
    	$dealership = preg_replace('/[^a-zA-Z0-9_]/', '', filter_input(INPUT_POST, 'dealership'));

    	if ($dealership != '') {
			$launch_str = 'php '
			. escapeshellarg($adwords_dir . '/ng_worker.php') . ' '
			. escapeshellarg($dealership) . ' '
			. escapeshellarg('marshal')
			. ' > /dev/null 2>/dev/null &';

			$resp = exec($launch_str, $outputr);
	    	echo json_encode(['message' => "Scrapper with dealership name - '{$dealership}' have been started", 'success' => true, 'action' => $action, 'command_response' => $resp], JSON_PRETTY_PRINT);
	    } else {
	    	echo json_encode(['message' => "Dealership name is empty.", 'success' => false, 'action' => $action], JSON_PRETTY_PRINT);
	    }
        break;

    case 'start_scrapper_domain':
    	$domain = filter_input(INPUT_POST, 'domain');

    	// domain to dealership
    	$dealership = get_meta('dealer_domain', GetDomain($domain));

    	if ($dealership != '') {
			$launch_str = 'php '
			. escapeshellarg($adwords_dir . '/ng_worker.php') . ' '
			. escapeshellarg($dealership) . ' '
			. escapeshellarg('marshal')
			. ' > /dev/null 2>/dev/null &';

			$resp = exec($launch_str, $outputr);
	    	echo json_encode(['message' => "Scrapper with domain - '{$domain}' and dealership name - '{$dealership}' have been started", 'success' => true, 'action' => $action, 'command_response' => $resp], JSON_PRETTY_PRINT);
	    } else {
	    	echo json_encode(['message' => "Dealership name is empty.", 'success' => false, 'action' => $action], JSON_PRETTY_PRINT);
	    }
        break;

    default:
    	echo json_encode(['message' => "Failure", 'success' => false, 'action' => 'default'], JSON_PRETTY_PRINT);
    	break;
}