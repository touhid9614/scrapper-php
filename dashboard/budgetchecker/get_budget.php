<?php
//define('noprint', true);
//include_once 'config.php';

$tmp_path = dirname(__FILE__) . '/';
$abs_path = str_replace('\\', '/', $tmp_path);
$abs_path = dirname($abs_path);
$path = dirname($abs_path) . '/adwords3/';
$dashboard_path = dirname($abs_path) . '/dashboard/';

if (!defined('ABSPATH'))
    define('ABSPATH', $abs_path);
if (!defined('ADSYNCPATH'))
    define('ADSYNCPATH', $path);
if (!defined('CACHEDIR'))
    define('CACHEDIR', $dashboard_path . 'cache/');
if (!defined('INSDIR'))
    define('INSDIR', 'dashboard');

//emulate web variables for command line usage
//at the moment needed in an image generation function
$_SERVER['HTTPS'] = 'off';
$_SERVER['SERVER_NAME'] = 'tm.smedia.ca';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/adwords3/somerandomphp.php?param=value'; //this should work just fine for our purposes


$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
if (defined('INSDIR'))
    $url .= '/' . INSDIR;

if (!defined('ABSURL'))
    define('ABSURL', $url . '/');

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Adwords.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once $dashboard_path . 'includes/functions.php';
require_once $dashboard_path . 'includes/ajax_inc.php';
require_once $dashboard_path . 'budgetchecker/includes/ajax_inc.php';

global $set_path, $connection;
$total_result = [];

$Configs = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];
$mutex = Mutex::create();
$dealerships = get_dealerships();
// $dealerships = array("barbermotors", "murraywin", "pgmotors");
$count = 0;

$myfile = fopen(ADSYNCPATH . "caches/budgetchecker/budgetchecker_log.txt", "a");
fwrite($myfile, "\n");
fwrite($myfile, "\n");

foreach ($dealerships as $key => $value) {
    $count++;
    $result = eval_dealership($CurrentConfig, $value, $mutex);
    // $total_result[] = $result;
    $time_dealer = date('Y-m-d H:i:s') . ": " .  $value;
    fwrite($myfile, $time_dealer);
    fwrite($myfile, "\n");

    $encodedString = json_encode($result, JSON_PRETTY_PRINT);
    file_put_contents(ADSYNCPATH . "caches/budgetchecker/" . $value . "_data.txt", $encodedString);


    //if ($count == 30)
    //    break;
}


//$encodedString = json_encode($total_result);
//Save the JSON string to a text file.
//file_put_contents(ADSYNCPATH . "caches/budgetchecker/budgetchecker_data.txt", $encodedString);


//Retrieve the data from our text file.
/*
  foreach ($dealerships as $key => $value)
  {
  //$db_connect = new DbConnect('');
  //Get data for dealership
  // echo $value;
  $result = eval_dealership($CurrentConfig, $value, $mutex);
  $db_connect = new DbConnect('');
  $insert_data = [
  'dealership_id' => null,
  'dealership_name' => $result['display_name'],
  'budget' => $result['budget'],
  'fb_budget' => $result['fb_budget'],
  'fb_projected' => $result['fb_projected'],
  'spent' => $result['spent'],
  'projected' => $result['projected'],
  'offset' => $result['offset'],
  'adjustment' => $result['adjustment'],
  'status' => $result['status'],
  'on15' => $result['on15'],
  'ranged' => $result['ranged'],
  'customer_id' => $result['customer_id'],
  'profile_id' => $result['profile_id'],
  'y_adb' => $result['y_adb'],
  'yesterday_spent' => $result['yesterday_spent'],
  'today_spent' => $result['today_spent'],
  'daily_average' => $result['daily_average'],
  'clicks' => $result['clicks'],
  'impressions' => $result['impressions'],
  'projected_clicks' => $result['projected_clicks'],
  'projected_impressions' => $result['projected_impressions'],
  'total_clicks' => $result['total_clicks'],
  'bounce_rate' => $result['bounce_rate'],
  'bounce_rate_pp' => $result['bounce_rate_pp'],
  'advert_type' => $result['advert_type'],
  'custom' => $result['custom'],
  'cost_per_engaged_user' => $result['cost_per_engaged_user'],
  'cost_per_engaged_user_pp' => $result['cost_per_engaged_user_pp'],
  ];
  $dealership = $result['display_name'];
  $query_prep = $db_connect->prepare_query_params($insert_data, DbConnect::PREPARE_PARENTHESES);
  $query_str = "INSERT INTO budget_checker_master $query_prep";
  $db_connect->query($query_str);


  $qr = "SELECT max(dealership_id) FROM budget_checker_master ";
  $data = $db_connect->query($qr);
  $dealership_id = mysqli_fetch_array($data);

  //var_dump($result['campaigns']);

  foreach ($result['campaigns'] as $key => $value) {

  $insert_budget_checker_details = [
  'dealership_id' => $dealership_id['max(dealership_id)'],
  'search_type' => $key,
  'campaign_id' => $value['campaign_id'],
  'impressions' => $value['impressions'],
  'clicks' => $value['clicks'],
  'daily_budget' => $value['daily_budget'],
  'budget_id' => $value['budget_id'],
  'spent' => $value['spent'],
  'spent_yesterday' => $value['spent_yesterday'],
  'spent_today' => $value['spent_today'],
  'bounce_rate' => $value['bounce_rate'],
  'bounce_rate_pp' => $value['bounce_rate_pp'],
  'cost_per_engaged_user' => $value['cost_per_engaged_user'],
  'cost_per_engaged_user_pp' => $value['cost_per_engaged_user_pp'],
  ];

  $query_prep = $db_connect->prepare_query_params($insert_budget_checker_details, DbConnect::PREPARE_PARENTHESES);
  $query_str = "INSERT INTO budget_checker_details $query_prep";
  $db_connect->query($query_str);
  }



  if($count>3){
  echo ($dealership_id['max(dealership_id)']);
  $db_connect->close_connection();
  exit;
  }

  $count++;

  }
 */
Mutex::destroy($mutex);
?>
