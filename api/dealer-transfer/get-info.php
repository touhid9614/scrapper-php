<?php

require_once dirname(dirname(__DIR__)) . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'tag_db_connect.php';

$db_connect  = new DbConnect();
$status 	 = isset($_GET['status']) ? $_GET['status'] : 'active';
$dealer_list = $db_connect->get_all_dealers("status = '$status'");

global $CronConfigs;
?>

<h2>List of dealers where status :: <?=$status?></h2>
<style>
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>
<table style="width:100%">
	<tr>
		<th>#</th>
		<th>Dealer Name</th>
		<th>Cron</th>
		<th>Domain</th>
		<th>Analytics ID</th>
		<th>Adwords ID</th>
		<th>Bing ID</th>
		<th>Fb Pixel</th>
	</tr>
<?php
$i = 1;

foreach ($dealer_list as $dealer) {
    $dealer_name = trim($dealer['company_name']);
    $cron        = $dealer['dealership'];
    $website     = $dealer['websites'];

    if (!preg_match('#^http(s)?://#', $website)) {
        $website = 'http://' . $website;
    }

    $domain = parse_url($website, PHP_URL_HOST);

    if (array_key_exists($cron, $CronConfigs)) {
        $cron_config         = $CronConfigs[$cron];
        $adwords_tracking_id = isset($cron_config['customer_id']) ? $cron_config['customer_id'] : '';
        $bing_account_id     = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';
    }

    $analytics_tracking_id = get_meta('tracking_ids', "{$cron}_analytics_tracking_id");
    $facebook_pixel_id     = get_meta('tracking_ids', "{$cron}_facebook_pixel_id");
    ?>
		<tr>
			<td><?=$i++?></td>
			<td><?=$dealer_name?></td>
			<td><?=$cron?></td>
			<td><?=$domain?></td>
			<td><?=$analytics_tracking_id?></td>
			<td><?=$adwords_tracking_id?></td>
			<td><?=$bing_account_id?></td>
			<td><?=$facebook_pixel_id?></td>
		</tr>
<?php
}
?>
</table>