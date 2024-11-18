<?php

include_once dirname(__DIR__) . '/adwords3/db-config.php';
include_once dirname(__DIR__) . '/adwords3/config.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$db = new Capsule();

$db->addConnection([
    'read'      => [
        'host' => $db_config_read['db_host_name'],
    ],
    'write'     => [
        'host' => $db_config_write['db_host_name'],
    ],
    'driver'    => 'mysql',
    'database'  => $db_config['db_name'],
    'username'  => $db_config['db_user'],
    'password'  => $db_config['db_pass'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
    'strict'    => false,
]);

$db->setAsGlobal();
$db->bootEloquent();
