<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/utils.php";

/* EXECUTE THE SCRIPT */
$file   = "{$base_dir}/services/tradesmart_test.php";
$script = 'php ' . escapeshellarg($file) . ' ' . ' > /dev/null &';
exec($script);