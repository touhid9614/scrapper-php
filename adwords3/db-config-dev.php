<?php

$db_config = array(
    'db_host_name' => 'smedia-dev.chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri',
    'db_pass' => 'c5ZCpG1!D14s$155*7',
    'db_name' => 'spidri_ads'
);

$db_config_read = array(
    'db_host_name' => 'dev.cluster-ro-chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri_r',
    'db_pass' => 'keub-pZ.%!M.h8aiF)',
    'db_name' => 'spidri_ads'
);

$db_config_write = array(
    'db_host_name' => 'dev.cluster-chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri',
    'db_pass' => 'c5ZCpG1!D14s$155*7',
    'db_name' => 'spidri_ads'
);

//Redshift
$event_db_config =
[
    'host' => 'smedia-dev.cpmgzgbet5ws.us-east-1.redshift.amazonaws.com',
    'port' => '5439',
    'user' => 'root',
    'pass' => 'MFUbmA8VxbSnysR2zG',
    'dbname' => 'smedia_tickdata'
];

//Configure Redis
$redis_config =
[
    "scheme" => "tcp",
    "host" => "smedia.wrucez.clustercfg.use1.cache.amazonaws.com",
    "port" => 6379
];