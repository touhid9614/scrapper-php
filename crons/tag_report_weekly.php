<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

global $redis, $redis_config;

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/db-config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/utils.php";

use Predis\Client as RedisClient;

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

$weekly_mail_redis_key  = 'ACTIVE_DEALER_TAG_FAIL_WEEKLY_REPORT';
$weekly_mail_redis_data = $redis->get($weekly_mail_redis_key);

if ($weekly_mail_redis_data) {
    $weekly_mail_redis_data = unserialize($weekly_mail_redis_data);

    $email_text = <<<KCS
    Dear concern,
    These active dealers have experienced tag issues in the last 7 days.<br><br>

   	<body>
		<div>
			<table class='customers'>
				<thead>
					<tr>
						<th> # </th>
						<th> Dealership </th>
						<th> Tag Page </th>
						<th> Issue Reported at </th>
					</tr>
				</thead>

				<tbody>
KCS;

    $i = 1;

    foreach ($weekly_mail_redis_data as $cron => $value) {
        $tag_page_url = "https://tools.smedia.ca/dashboard/tag.php?dealership={$cron}";

        $loop = "<tr>
			<td>{$i}</td>
			<td>{$cron}</td>
			<td><span style='color:blue'><i>{$tag_page_url}</i></span></td>
			<td>{$value}</td>
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

    $email_subject = "Weekly Tag Report :: " . date('d-M-Y', time());
    $from          = "support@smedia.ca";
    $active_to     = ['zaber.mahbub@smedia.ca', 'tanvir@smedia.ca', 'support@smedia.ca'];

    SendEmail($active_to, $from, $email_subject, $email_text);

    $redis->del($weekly_mail_redis_key);
}