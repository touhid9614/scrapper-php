<?php

define('noprint', true);

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'includes/search-inventory.php';
require_once 'includes/bounce-rate.php';
require_once 'includes/ajax_inc.php';
require_once 'dashboard_home/get_dashboard_file_data.php';

header('Content-Type: application/json');

global $user, $set_path, $connection;

$result        = [];
$action        = isset($_GET['act']) ? trim($_GET['act']) : null;
$Configs       = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];
$mutex         = Mutex::create();

switch ($action) {
    case 'bouncerate':
        $result = get_avg_bounce_rate($connection, $mutex);
        break;
    case 'summary':
        if ($user['cron_config']) {
            $result = get_summary_data($user['cron_name']);
        } else {
            $result['error'] = array(
                'code'    => 404,
                'message' => 'No dealership selected',
            );
        }
        break;
    case 'monthly':
        if ($user['cron_config']) {$result = get_monthly_data($user['cron_name']);} else {
            $result['error'] = array(
                'code'    => 404,
                'message' => 'No dealership selected',
            );}
        break;
    case 'yearly':
        if ($user['cron_config']) {$result = get_yearly_data($user['cron_name']);} else {
            $result['error'] = array(
                'code'    => 404,
                'message' => 'No dealership selected',
            );}
        break;
    case 'save_scrubber':
        $result = save_scrubber($mutex);
        break;
    case 'save_closer':
        $result = save_closer($mutex);
        break;
    case 'save_designer':
        $result = save_designer($mutex);
        break;
    case 'get_dealership':
        if (isset($_GET['id'])) {$result = get_dealership($_GET['id'], $mutex);} else {
            $result['error'] = array(
                'code'    => 400,
                'message' => 'Dealership id must be specified',
            );}
        break;
    case 'save_note':
        $result = save_note($mutex);
        break;
    case 'push_lead':
        $result = push_lead($mutex);
        break;
    case 'get_similar':
        $db_connect   = new DbConnect($user['cron_name']);
        $search       = new InventorySearch($db_connect);
        $stock_number = isset($_GET['stock_number']) ? $_GET['stock_number'] : null;
        if ($stock_number) {
            $car        = $search->get_car_by_stock($stock_number);
            $page_count = 0;
            $page       = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $distance   = isset($_GET['distance']) ? $_GET['distance'] : 25;
            $similars   = $search->get_paged_similar_cars($car, $distance, $page, $page_count);

            $result = array(
                'car'         => $car,
                'page'        => $page,
                'total_pages' => $page_count,
                'similars'    => $similars,
            );
        } else {
            $result['error'] = array(
                'code'    => 400,
                'message' => 'Bad request: Missing required parameters',
            );
        }
        break;

    case 'get_dir':
        $path = isset($_GET['path']) ? trim($_GET['path']) : null;
        if ($path) {
            $result = getAllDirectoris($path);
        } else {
            $result['error'] = array(
                'code'    => 400,
                'message' => 'Path is null',
            );
        }
        break;

    case 'monthlyFillUpView':
        $dealership = $_GET['dealership'];
        $query      = "SELECT * FROM monthly_offer_lead_count_meta_data where meta_key LIKE '%$dealership%'";
        $result     = DbConnect::get_instance()->query($query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $key   = explode("_", $row['meta_key']);
                $value = explode(":", $row['meta_value']);
                $type  = in_array("view", $key) ? 'view' : 'fillUp';

                $date = end($key);

                if (is_numeric($date)) {
                    $monthNum = substr($date, 0, 2);
                    $year     = substr($date, 2);

                    $monthText = substr(date('F', mktime(0, 0, 0, $monthNum, 10)), 0, 3);

                    $smart_offer["$monthText-$year"][$type] = (int) trim(end($value), ";");
                }
            }
            uksort($smart_offer, function ($a1, $a2) {
                $time1 = strtotime($a1);
                $time2 = strtotime($a2);

                return $time1 - $time2;
            });
            $new_smart_offer = [];
            array_walk($smart_offer, function (&$value, $key) use (&$new_smart_offer) {
                $new_key                   = substr($key, 0, 3) . "," . substr($key, 6, 2);
                $new_smart_offer[$new_key] = $value;
            });
            { $result = $new_smart_offer;}
        } else {
            $result['error'] = array(
                'code'    => 400,
                'message' => 'No data found in database',
            );
        }
        break;

    default:
        $result['error'] = array(
            'code'    => 400,
            'message' => 'Bad request: Missing required parameters',
        );
        break;
}

Mutex::destroy($mutex);
mysqli_close($connection);
echo json_encode($result, JSON_PRETTY_PRINT);
