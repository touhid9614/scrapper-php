<?php
ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
global $CronConfigs, $developer_token, $set_path, $single_config, $worker_logfile;

if (!isset($argv[1])) die("Nothing to do, need dealerships arguments");
$single_config = $cron_name = $argv[1];
$command = isset($argv[2]) ? $argv[2] : '';
$dry = false;

use sMedia\AdSync\Controller\AdwordsController;
use sMedia\AdSync\Service\AdwordAdService;
use sMedia\Logger\Logger;
// use Illuminate\Database\Capsule\Manager as DB;

$root_dir = dirname(__DIR__);

require_once "{$root_dir}/adwords3/config.php";
require_once "{$root_dir}/includes/init-db.php";
require_once "{$root_dir}/adwords3/utils.php";
require_once "{$root_dir}/adwords3/Google/Consts.php";
require_once "{$root_dir}/adwords3/Google/Util.php";
require_once "{$root_dir}/adwords3/Google/Adwords.php";

$Configs = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];

// $worker_logfile = $log_path = "{$root_dir}/adwords3/ng_logs/cleaner.log";
$worker_log_dir = $root_dir . '/adwords3/ng_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $single_config);
$log_path = $worker_logfile =  $worker_log_dir . "/adwords-$command-" . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

$logger = Logger::getByPath($log_path) ? Logger::getByPath($log_path) : Logger::add($single_config, $log_path);

function logme($text)
{
	global $worker_logfile, $cron_config;

	if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
		file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
	}
}

function clear_log_file($search)
{
	$files = array_map(function ($f) {
		return [$f, filemtime($f)];
	}, glob($search));

	usort($files, function ($a, $b) {
		return $a[1] < $b[1];
	});

	$files = array_slice($files, 3);

	foreach ($files as $f) {
		unlink($f[0]);
	}
}

/* function get_dealership_with_custom_campaign_or_settings()
{

	$custom_details = DB::table('ad_details')->select('dealership')->where(function ($q) {
		return $q->where('make', '>', '')->orWhere('model', '>', '')->orWhere('year', '>', '');
	})->distinct(true)->pluck('dealership');

	$custom_campaign = DB::table('tbl_ad_custom_campaigns')->select('dealership')->where(function ($q) {
		return $q->where('make', '>', '')->orWhere('model', '>', '')->orWhere('year', '>', '');
	})->where('adwords', 1)->distinct(true)->pluck('dealership');

	return $custom_campaign->merge($custom_details)->unique();
} */

if (isset($CronConfigs[$cron_name]['customer_id']) && !empty($CronConfigs[$cron_name]['customer_id'])) {
	$logger->info("Cron name $cron_name");
	$logger->info("Customer Id {$CronConfigs[$cron_name]['customer_id']}");

	$logger->info('Initialing andword controller');
	// $custom = get_dealership_with_custom_campaign_or_settings();

	$test_dealers = [];

	// if (in_array($cron_name, $test_dealers)) {
	// $adwordsController = new AdwordsControllerTest($cron_name);
	// } else {
	$adwordsController = new AdwordsController($cron_name);
	// }

	$adwordsController
		->setLogger($logger)
		->useCronConfig($CronConfigs[$cron_name])
		->setDry($dry)
		->setAdwordService(new AdwordAdService(
			Consts::ServiceNamespace,
			$CurrentConfig,
			$developer_token,
			$CronConfigs[$cron_name]['customer_id'],
			$logger
		));

	$logger->info('Initialized andword controller');

	if ($command == 'clear') {
		$logger->info('CLearing all ads');
		$adwordsController->clearAllAds();
	} else if ($command == 'sold' && !in_array($cron_name, $test_dealers)) {
		clear_log_file($worker_log_dir . '/adwords-sold*');
		$logger->info('Processing disapproved ads');
		$adwordsController->removeDisapprovedAds();
	} else {
		foreach (AdwordsController::TAGS as $k => $tag) {
			$logger->info("Processing used stock type for $tag");
			$adwordsController->setTag($tag);
			$adwordsController->preSync();
			// Soon we are gooing to move to v3 so we are not creating
			// any new option to disable esa
			if ($cron_name == "juliojonesmazda") {
				$adwordsController->setAdTypes(['rsa']);
			} else {
				$adwordsController->setAdTypes(['esa', 'rsa']);
			}
			$adwordsController
				->setType('used')
				->loadCars()
				->generateCampaigns()
				->publishCampaign();

			$logger->info("Processing new stock type for $tag");
			$adwordsController
				->setType('new')
				->loadCars()
				->generateCampaigns()
				->publishCampaign();
		}
	}
	$logger->info('All complete');
} else {
	echo "CustomerId not found";
}
