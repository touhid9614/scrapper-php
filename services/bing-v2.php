<?php
ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);
global $CronConfigs, $developer_token, $set_path, $single_config, $worker_logfile;

if (!isset($argv[1])) {
	die("Nothing to do, need dealerships arguments");
}

$single_config = $cron_name = $argv[1];
$command       = isset($argv[2]) ? $argv[2] : '';
$dry           = false;

use sMedia\AdSync\Controller\BingAdController;
use sMedia\AdSync\Service\BingAdService;
use sMedia\Logger\Logger;

$root_dir = dirname(__DIR__);

require_once "{$root_dir}/adwords3/config.php";
require_once "{$root_dir}/includes/init-db.php";
require_once "{$root_dir}/adwords3/utils.php";
require_once "{$root_dir}/adwords3/bing/V13/AuthHelper.php";
require_once "{$root_dir}/adwords3/bing/V13/CampaignManagementExampleHelper.php";

// $worker_logfile = $log_path = "{$root_dir}/adwords3/ng_logs/cleaner.log";
$worker_log_dir = $root_dir . '/adwords3/ng_logs/' . preg_replace('/[^a-zA-Z0-9\_\-]/', '', $single_config);
$log_path       = $worker_logfile       = $worker_log_dir . "/bing-$command-" . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '.log';
ini_set("error_log", $worker_logfile);

$logger = Logger::getByPath($log_path) ? Logger::getByPath($log_path) : Logger::add($single_config, $log_path);

function logme($text)
{
	global $worker_logfile, $cron_config;

	if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
		file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
	}
}

if (isset($CronConfigs[$cron_name]['bing_account_id']) && !empty($CronConfigs[$cron_name]['bing_account_id'])) {
	$logger->info("Cron name $cron_name");
	$logger->info("Customer Id {$CronConfigs[$cron_name]['bing_account_id']}");
	$logger->info('Initialing bing ad controller');
	$bingController = new BingAdController($cron_name);

	$bingController
		->setLogger($logger)
		->useCronConfig($CronConfigs[$cron_name])
		->setDry($dry)
		->setBingAdService(new BingAdService(
			$CronConfigs[$cron_name]['bing_account_id'],
			$logger
		));

	$logger->info('Initialized bing ad controller');

	if ($command == 'clear') {
		$logger->info('CLearing all ads');
		$bingController->clearAds();
	} else if ($command == 'sold') {
		// $logger->info('Processing disapproved ads');
		// $bingController->removeDisapprovedAds();
	} else {
		foreach (BingAdController::TAGS as $k => $tag) {
			$logger->info("Processing used stock type for $tag");
			$bingController->setTag($tag);
			$bingController->preSync();
			$bingController->setAdTypes(['esa', 'rsa']);
			$bingController
				->setType('used')
				->loadCars()
				->generateCampaigns()
				->publishCampaign();

			$logger->info("Processing new stock type for $tag");
			$bingController
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
