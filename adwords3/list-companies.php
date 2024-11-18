<?php

require_once 'config.php';

global $scrapper_configs, $CronConfigs;

echo "<pre>\n";

foreach ($scrapper_configs as $cron_name => $project_config) {
	if (isset($CronConfigs[$cron_name])) {
		if (isset($project_config['entry_points']['used']) && !isset($project_config['entry_points']['new'])) {
			echo $cron_name . "\n";
		}
	}
}

echo "</pre>";
