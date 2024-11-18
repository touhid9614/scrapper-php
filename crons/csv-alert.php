<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/utils.php";

global $CronConfigs, $scrapper_configs;

$csvDealers = [];

foreach ($scrapper_configs as $cron => $sc) {
    $entry_points = isset($sc['entry_points']) ? $sc['entry_points'] : [];
    $temp         = '';

    foreach ($entry_points as $stk_type => $url) {
        if (is_array($url)) {
            continue;
        }

        if (endsWith($url, '.csv')) {
            $temp = $url;
        }
    }

    if (!empty($temp) && isset($CronConfigs[$cron])) {
        $csvDealers[$cron] = $temp;
    }
}

$csvDataApi  = json_decode(HttpGet('https://tm.smedia.ca/APIs/dashboard/clientDataTime.php'), true);
$csvFileTime = $csvDataApi['files'];

$warning = [];

foreach ($csvDealers as $cron => $csvFile) {
    if (isset($csvFileTime[$csvFile])) {
        if ((time() - strtotime($csvFileTime[$csvFile])) > 24 * 3600) {
            $warning[$cron][$csvFile] = $csvFileTime[$csvFile];
        }
    } else {
        $warning[$cron][$csvFile] = "N/A";
    }
}

$email_text = "The following dealerships csv files haven't been updated for at least 24 hours. <br><br>";

$email_text .= "<body>
	<div>
		<table class='customers'>
			<thead>
				<tr>
					<th> # </th>
					<th> Dealership </th>
					<th> CSV URL </th>
					<th> Lat Updated At </th>
				</tr>
			</thead>

			<tbody>";

$i = 1;

foreach ($warning as $cron => $value) {
    $csv_url     = '';
    $csv_updated = '';

    foreach ($value as $cs_url => $time) {
        $csv_url     = $cs_url;
        $csv_updated = $time;
    }

    $loop = "<tr>
		<td>{$i}</td>
		<td>{$cron}</td>
		<td>{$csv_url}</td>
		<td>{$csv_updated}</td>
	</tr>";
    $i++;
    $email_text .= $loop;
}

$email_text .= "</tbody>
		</table>
	</div>

	<style type='text/css'>
			.customers {
				font-family: Arial, Helvetica, sans-serif;
				border-collapse: collapse;
				width: 100%;
			}

			.customers td, .customers th {
				border: 1px solid #ddd;
				padding: 8px;
			}

			.customers tr:nth-child(even) {
				background-color: #f2f2f2;
			}

			.customers tr:hover {
				background-color: #ddd;
			}

			.customers th {
				padding-top: 12px;
				padding-bottom: 12px;
				text-align: left;
				background-color: #4CAF50;
				color: white;
			}
		</style>
</body>";

$email_subject = "CSV Not Updated For 24 Hours";
$from          = "support@smedia.ca";
$active_to     = ['zaber.mahbub@smedia.ca', 'tanvir@smedia.ca', 'toufiq@smedia.ca'];

SendEmail($active_to, $from, $email_subject, $email_text);