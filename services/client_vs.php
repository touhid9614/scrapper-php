<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

// global $scrapper_configs;

$URL          = isset($_POST['url']) ? urldecode(filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)) : null;
$URL          = removeParams($URL);
$dealership   = getDomainDealer(GetDomain($URL), $URL);
$table        = $dealership . '_scrapped_data';
$old_data_age = 43200; // 12*60*60
$db_connect   = new DbConnect('');
$result       = $db_connect->query("SELECT arrival_date, updated_at, all_images FROM {$table} WHERE url='$URL' AND deleted = 0");
$fetch_result = $result ? mysqli_fetch_assoc($result) : null;

if ($fetch_result) {
    if ($fetch_result['all_images'] == null || $fetch_result['all_images']) {
        echo json_encode(['decision' => 'INSERT']);
    } else {
        $now = time();

        if (($fetch_result['updated_at'] == 0 && ($now - $fetch_result['arrived_at']) > $old_data_age) || (($now - $fetch_result['updated_at']) > $old_data_age)) {
            echo json_encode(['decision' => 'UPDATE']);
        } else {
            echo json_encode(['decision' => 'IGNORE']);
        }
    }
} else {
    echo json_encode(['decision' => 'INSERT']);
}
