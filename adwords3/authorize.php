<?php session_start();

require_once 'config.php';
require_once 'Google/Types.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/Util.php';

$Configs  = LoadConfig($set_path);
$customer = $_SESSION['customer'];
$helper   = new TokenHelper();
$global_logfile = __DIR__ . '/ng_logs/global_log.txt';

try {
	$access_token = $helper->GetAccessToken($google_config_new[$customer], true, $global_logfile);
	file_put_contents($global_logfile, time() . " $customer : Token create successfully \n", FILE_APPEND);
} catch (Exception $ex) {
	file_put_contents($global_logfile, time() . " $customer : Their is a error when token create\n", FILE_APPEND);
}

if ($access_token) {
	$CurrentConfig                    = $access_token;
	$Configs->AccessTokens[$customer] = $CurrentConfig;
	SaveConfig($Configs, $set_path);
	$msg = "Access token updated for {$customer} and stored.";
	echo $msg;
	file_put_contents($global_logfile, time() . " $msg\n", FILE_APPEND);
} else {
	$msg = "Unable to update access token for {$customer}.";
	echo $msg;
	file_put_contents($global_logfile, time() . " $msg\n", FILE_APPEND);
}
