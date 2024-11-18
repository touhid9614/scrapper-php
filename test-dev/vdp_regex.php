<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";
$log_path    = "{$adwords_dir}/caches/marketcheck-test/marketcheck_v2.log";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

global $scrapper_configs;

$out = [];

foreach ($scrapper_configs as $key => $value) {
    if ($value['vdp_url_regex']) {
        $out[$key] = $value['vdp_url_regex'];
    }
}

echo json_encode($out);