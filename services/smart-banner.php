<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'cron_misc.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'uuid.php';

global $CronConfigs, $scrapper_configs;

$db_connect = new DbConnect('');

$action     = filter_input(INPUT_POST, 'act');
$dealership = filter_input(INPUT_POST, 'sb_dealership');
$uuid       = filter_input(INPUT_POST, 'sb_uuid');
$make       = filter_input(INPUT_POST, 'sb_make');
$model      = filter_input(INPUT_POST, 'sb_model');
$year       = filter_input(INPUT_POST, 'sb_year');
$vdp        = filter_input(INPUT_POST, 'sb_vdp');

switch ($action) {
    case 'check_active_last_vdp':
        $scrapper_table  = $dealership . '_scrapped_data';
        $active_vdp      = $db_connect->query("SELECT * FROM {$scrapper_table} WHERE url = '{$vdp}' AND deleted = false;");
        $active_vdp_rows = mysqli_num_rows($active_vdp);
        $status          = false;

        if ($active_vdp_rows) {
            $status = true;
        }

        echo json_encode(['message' => 'Last active vdp status.', 'success' => $status]);
        break;

    case 'save':
        if (empty($uuid) || is_null($uuid) || $uuid == 'null') {
            $uuid     = UUID::v4();
            $num_rows = 0;
        } else {
            $user_engagement = $db_connect->query("SELECT * FROM user_engagement WHERE dealership = '$dealership' AND uuid = '$uuid'");
            $num_rows        = mysqli_num_rows($user_engagement);
        }

        if ($num_rows) {
            $datetime  = date('Y-m-d H:i:s');
            $query_str = "UPDATE user_engagement SET make = '$make', model = '$model', year = '$year',last_engaged_vdp = '$vdp', datetime = '$datetime' WHERE dealership = '$dealership' AND uuid = '$uuid'";
        } else {
            $table_data = [
                'dealership'       => $dealership,
                'uuid'             => $uuid,
                'make'             => $make,
                'model'            => $model,
                'year'             => $year,
                'last_engaged_vdp' => $vdp,
                'datetime'         => date('Y-m-d H:i:s'),
            ];

            $query_prep = $db_connect->prepare_query_params($table_data, DbConnect::PREPARE_PARENTHESES);
            $query_str  = "INSERT INTO user_engagement $query_prep";
        }

        $db_connect->query($query_str);

        $day = date('Y-m-d');
        $hid = hash('sha256', $dealership . $vdp . $day);

        $engaged_vdp_data = [
            'hid'        => $hid,
            'dealership' => $dealership,
            'vdp_url'    => $vdp,
            'year'       => $year,
            'make'       => $make,
            'model'      => $model,
            'count'      => 1,
            'day'        => $day,
        ];

        $query_prep = $db_connect->prepare_query_params($engaged_vdp_data, DbConnect::PREPARE_PARENTHESES);
        $query_str  = "INSERT INTO engaged_vdp {$query_prep} ON DUPLICATE KEY UPDATE `count` = `count` + 1;";
        $db_connect->query($query_str);

        $scrapper_table  = $dealership . '_scrapped_data';
        $deleted_status  = $db_connect->query("SELECT * FROM $scrapper_table WHERE url = '$vdp' AND deleted = 0;");
        $deleted_numrows = mysqli_num_rows($deleted_status);

        if ($deleted_numrows) {
            $row       = mysqli_fetch_assoc($deleted_status);
            $car_image = explode("|", $row['all_images']);

            $table_data = [
                'dealership' => $dealership,
                'make'       => $row['make'],
                'model'      => $row['model'],
                'year'       => $row['year'],
                'car_image'  => $car_image[0],
            ];

            $status = true;
        } else {
            $table_data = [];
            $status     = false;
        }

        echo json_encode(['data' => $table_data, 'message' => 'User engaged data save successfully.', 'success' => $status]);
        break;

    case 'engage_data':
        if (empty($uuid) || is_null($uuid) || $uuid == 'null') {
            $uuid     = UUID::v4();
            $num_rows = 0;
        } else {
            $user_engagement = $db_connect->query("SELECT * FROM user_engagement WHERE dealership='$dealership' AND uuid = '$uuid'");
            $num_rows        = mysqli_num_rows($user_engagement);
        }

        $scrapper_table  = $dealership . '_scrapped_data';
        $deleted_status  = $db_connect->query("SELECT * FROM $scrapper_table WHERE url='$vdp' AND deleted=(0)");
        $deleted_numrows = mysqli_num_rows($deleted_status);

        if ($num_rows && $deleted_numrows) {
            $row        = mysqli_fetch_assoc($user_engagement);
            $table_data = [
                'make'             => $row['make'],
                'model'            => $row['model'],
                'year'             => $row['year'],
                'last_engaged_vdp' => $row['last_engaged_vdp'],
            ];

            $status = true;
        } else {
            $table_data = [];
            $status     = false;
        }

        echo json_encode(['data' => $table_data, 'success' => $status]);
        break;

    default:
        echo json_encode(['message' => 'Smart Banner No Such Action', 'success' => false]);
        break;
}

$db_connect->close_connection();