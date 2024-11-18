<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $user, $connection;

if (empty($user['accounts'])) {
	$user['accounts'][] = $user['cron_name'];
}

$db_connect = new DbConnect('');
$meta_name = 'monthly_offer_lead_count';
$db_connect->create_meta_table($meta_name);
$result = array();

$url_query = "SELECT dealership, websites FROM dealerships";
$url_result = DbConnect::get_instance()->query($url_query);
$url = [];

while ($row = mysqli_fetch_assoc($url_result)) {
	$dealership = $row['dealership'];
	$url[$dealership] = $row['websites'];
}

foreach ($CronConfigs as $c_name => $c_config) {
	if (!in_array($c_name, $user['accounts'])) {
		continue;
	}

	if (isset($c_config['lead'])) {
		$last_month = strtotime("first day of previous month");
		$view_key = "{$c_name}_view_" . date('mY');
		$fillup_key = "{$c_name}_" . date('mY');
		$lview_key = "{$c_name}_view_" . date('mY', $last_month);
		$lfillup_key = "{$c_name}_" . date('mY', $last_month);

		$viewed = $db_connect->get_meta($meta_name, $view_key);
		$fillups = $db_connect->get_meta($meta_name, $fillup_key);
		$lviewed = $db_connect->get_meta($meta_name, $lview_key);
		$lfillups = $db_connect->get_meta($meta_name, $lfillup_key);

		$result[$c_name] = array(
			'views' => $viewed ? $viewed : 2,
			'submits' => $fillups ? $fillups : 0,
			'last_views' => $lviewed ? $lviewed : 0,
			'last_submits' => $lfillups ? $lfillups : 0,
			'live' => $c_config['lead']['live'] ? 'Yes' : ($c_config['lead']['new']['live'] ? 'Yes' : ($c_config['lead']['used']['live'] ? 'Yes' : ($c_config['lead']['service']['live'] ? 'Yes' : 'no')))
		);
	}
}

$db_connect->close_connection();
?>

<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
	<?php
	$select = 'Offer Stats';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">
		</header>

		<div class="row">
			<div class="col-md-12">
				<section class="panel panel-info">
					<header class="panel-heading">
						<h2 class="panel-title"> Smart Offer Statistics </h2>
						<p class="panel-subtitle"> Monthly Offer Views And Fill Ups </p>
					</header>

					<div class="panel-body">
						<table class="table table-bordered mb-none table-advanced">
							<thead>
								<tr>
									<th> Dealership </th>
									<th> Website URL </th>
									<th> Monthly Views </th>
									<th> Monthly Fill Ups </th>
									<th> Monthly Conversion rate</th>
									<th> Last Months Views </th>
									<th> Last Months Fill Ups </th>
									<th> Last Months Conversion rate </th>
									<th> Live </th>
									<th> Action </th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($result as $c_name => $res) : ?>
									<tr>
										<td><?= $c_name ?></td>
										<td><i><?= $url[$c_name] ?></i></td>
										<td><?= $res['views'] ?></td>
										<td><?= $res['submits'] ?></td>
										<td><?= $res['submits'] / $res['views'] >= 0 ? (($res['submits'] * 100) / $res['views']) . "%" : 0 ?></td>
										<td><?= $res['last_views'] ?></td>
										<td><?= $res['last_submits'] ?></td>
										<td><?= $res['last_submits'] / $res['last_views'] >= 0 ? (($res['last_submits'] * 100) / $res['last_views']) . "%" : 0 ?></td>
										<td><?= $res['live'] ?></td>
										<td>
											<a class="btn btn-sm btn-success" href="export-so-lead.php?dealership=<?php echo $c_name ?>"> Export </a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';
