<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
// header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir = dirname(dirname(__DIR__));

require_once $base_dir . '/adwords3/config.php';
require_once $base_dir . '/adwords3/utils.php';
require_once $base_dir . '/includes/init-db.php';
require_once "./dealerDataFunction.php";

use Illuminate\Database\Capsule\Manager as DB;
use sMedia\AbTest\AbTestController;

global $CronConfigs;

$action     = filter_input(INPUT_POST, 'action');
$dealership = filter_input(INPUT_POST, 'dealership');
$url        = removeParams(smediaUrlDecrypt(filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)));
$ab_test    = new AbTestController($dealership, $url, $base_dir . "/ab-test");

if (!$action || !$dealership || !$url) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.'], JSON_PRETTY_PRINT);
    exit();
}

switch ($action) {
    case 'get_js_code':
        $code = $ab_test->generateJavascript($CronConfigs[$dealership]);
        echo json_encode(['success' => true, 'message' => 'JS generated successfully.', 'code' => $code], JSON_PRETTY_PRINT);
        break;

    case 'save_view':
        $table  = 'tbl_ab_test_' . filter_input(INPUT_POST, 'table_name');
        $option = filter_input(INPUT_POST, 'option');

        $val = DB::table($table)
            ->where('dealership', '=', $dealership)
            ->where('url', '=', $url)
            ->where('option', '=', $option)
            ->get();

        if (count($val) == 0) {
            $case = "Inserted view for ab test option: '{$option}'";
            DB::table($table)->insert([
                'dealership'   => $dealership,
                'url'          => $url,
                'option'       => $option,
                'engage_count' => 0,
                'view_count'   => 1
            ]);
        } else {
            $case = 'Updated to view count : ' . ($val[0]->view_count + 1) . " for ab test option: '{$option}'";
            DB::table($table)
                ->where('dealership', '=', $dealership)
                ->where('url', '=', $url)
                ->where('option', '=', $option)
                ->increment('view_count');
        }

        echo json_encode(['success' => true, 'message' => 'View stored successfully.', 'case' => $case], JSON_PRETTY_PRINT);
        break;

    case 'save_epm':
        $table  = 'tbl_ab_test_' . filter_input(INPUT_POST, 'table_name');
        $option = filter_input(INPUT_POST, 'option');

        $val = DB::table($table)
            ->where('dealership', '=', $dealership)
            ->where('url', '=', $url)
            ->where('option', '=', $option)
            ->get();

        if (count($val) == 0) {
            $case = "Inserted EPM for ab test option " . $option;
            DB::table($table)->insert([
                'dealership' => $dealership,
                'url'        => $url,
                'option'     => $option,
            ]);
        } else {
            $case = 'Updated to EPM count : ' . ($val[0]->engage_count + 1) . " for ab test option " . $option;
            DB::table($table)
                ->where('dealership', '=', $dealership)
                ->where('url', '=', $url)
                ->where('option', '=', $option)
                ->increment('engage_count');
        }

        echo json_encode(['success' => true, 'message' => 'EPM stored successfully.', 'case' => $case], JSON_PRETTY_PRINT);
        break;
}