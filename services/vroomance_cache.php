<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "$base_dir/adwords3/";
$visited_urls = $adwords_dir . "caches/vroomance/visited_urls.txt";

/* INCLUDE REQUIRED FILES */
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';

$urls = json_decode($_POST['urls'], true);
file_put_contents($visited_urls, print_r($urls, true), FILE_APPEND);
