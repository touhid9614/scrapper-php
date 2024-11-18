<?php

define('noprint', true);
require_once 'bootstrapper.php';
global $connection;
header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : null;

if (!$action) {
    json_echo(['error' => 'No action specified']);
    die();
}

$db_connect = new DbConnect('all_imported');
$value = apply_filters("process_ajax_{$action}", [], $db_connect);
$db_connect->close_connection();
json_echo($value);