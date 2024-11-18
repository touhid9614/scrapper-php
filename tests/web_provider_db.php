<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect = new DbConnect('');
$URL        = isset($_POST['url']) ? urldecode(filter_input(INPUT_POST, 'url')) : null;
