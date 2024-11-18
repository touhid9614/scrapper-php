<?php

$db_config = array(
    'db_host_name' => 'smedia-prod.cluster-chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri',
    'db_pass' => 'c5ZCpG1!D14s$155*7',
    'db_name' => 'spidri_ads'
);

$db_config_read = array(
    'db_host_name' => 'smedia-prod.cluster-ro-chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri_r',
    'db_pass' => 'N8d&TZDme9#wbACc-9',
    'db_name' => 'spidri_ads'
);

$db_config_write = array(
    'db_host_name' => 'smedia-prod.cluster-chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri',
    'db_pass' => 'c5ZCpG1!D14s$155*7',
    'db_name' => 'spidri_ads'
);

//Redshift
$event_db_config =
[
    'host' => 'prod.cpmgzgbet5ws.us-east-1.redshift.amazonaws.com',
    'port' => '5439',
    'user' => 'spidri',
    'pass' => 'tFjvGfYivt5eJQ2pEs',
    'dbname' => 'eventdata'
];

//Configure Redis
$redis_config =
[
    "scheme" => "tcp",
    "host" => "smedia.wrucez.clustercfg.use1.cache.amazonaws.com",
    "port" => 6379
];