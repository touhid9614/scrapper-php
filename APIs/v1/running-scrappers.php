<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

/* SMEDIA DIRECTORY MAPPING */
$base_dir = dirname(dirname(__DIR__));
require_once $base_dir . '/vendor/autoload.php';

$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

/*
 * $1: USER
 * $2: PID
 * $3: %CPU
 * $4: %MEM
 * $5: VSZ
 * $6: RSS
 * $7: TTY
 * $8: STAT
 * $9: START
 * $10: TIME
 * $11: COMMAND
 */

$worker_list = explode("\n", `ps aux |  grep -i php | grep ng_worker.php | grep -v grep | awk '{print $2, $3, $4, $8, $9, $10, $13}'`);

$payload = [];

foreach ($worker_list as $worker_data) {
    $parts = explode(' ', $worker_data);

    $payload[] = [
        'pid'      => $parts[0],
        'cpu'      => $parts[1],
        'ram'      => $parts[2],
        'status'   => $parts[3],
        'start'    => $parts[4],
        'time'     => $parts[5],
        'cronName' => $parts[6]
    ];
}

echo json_encode($payload);