<?php

define('noprint', true);
header('Content-Type: application/json');

require_once '../adwords3/config.php';
require_once '../adwords3/db_connect.php';
require_once '../adwords3/utils.php';

global $connection;

$db_connect = new DbConnect('');

$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : null;
$url     = isset($_REQUEST['url']) ? $_REQUEST['url'] : null;
$path    = isset($_REQUEST['path']) ? $_REQUEST['path'] : null;
$onclick = isset($_REQUEST['onclick']) ? $_REQUEST['onclick'] : null;

$db_connect->create_meta_table('goal_tracker');

$domain   = GetDomain($url);
$trackers = $db_connect->get_meta('goal_tracker', $domain);

switch ($action) {
    case 'get':
        $result = isset($trackers[$path]) ? array('code' => 200, 'has_tracker' => true, 'tracker' => $trackers[$path]) : array('code' => 200, 'has_tracker' => false);
        break;
    case 'save':
        if (!$path) {
            $result = array('code' => 200, 'message' => 'Please select a button to add code');
            break;
        }
        if ($onclick) {
            $trackers[$path] = $onclick;
        } else {
            if (isset($trackers[$path])) {
                unset($trackers[$path]);
            }
        }
        $db_connect->update_meta('goal_tracker', $domain, $trackers);
        $result = array('code' => 200, 'message' => 'Goal Tracker updated');
        break;
    default:
        $result['error'] = array(
            'code'    => 400,
            'message' => 'Bad request: Missing required parameters',
        );
        break;
}

$db_connect->close_connection();

echo json_encode($result);
