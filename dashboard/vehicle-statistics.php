<?php
require_once 'config.php';
require_once 'includes/loader.php';
session_start();
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'boe_db_connect.php';
require_once 'includes/button.php';

global $CronConfigs, $scrapper_configs, $connection;

$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));
$db_connect = new DbConnect($cron_name);
$data_result = get_button_statistics_data($cron_name, $start_date, $end_date);
$scrapper_table = $cron_name . '_scrapped_data';
$engaged_query = DbConnect::get_instance()->query("SELECT SUM(engaged_vdp.count) AS count, vdp_url  FROM engaged_vdp LEFT JOIN $scrapper_table ON engaged_vdp.vdp_url=$scrapper_table.url WHERE (day BETWEEN '$start_date' AND '$end_date') AND dealership = '$cron_name'  GROUP BY vdp_url");
$engaged_data = [];

while ($record = mysqli_fetch_assoc($engaged_query)) {
	$engaged_data[$record['vdp_url']] = $record['count'];
}

$vehicle_stats = [];
while ($row = mysqli_fetch_assoc($data_result)) {
	$stock_number = $row['stock_number'];
	$button_name = $row['button_name'];
	$title = $row['title'];
	$clicks = $row['clicks'];
	$fillups = $row['fillups'];
	$url = $row['url'];

	if (isset($vehicle_stats[$stock_number])) {
		$vehicle_stats[$stock_number]['clicks'] += $clicks;
		$vehicle_stats[$stock_number]['fillups'] += $fillups;
		$vehicle_stats[$stock_number]['buttons'][$button_name] = [
			'clicks' => $clicks,
			'fillups' => $fillups
		];
	} else {
		$engaged_user_count = (isset($engaged_data[$url])) ? $engaged_data[$url] : 0;
		$check_query = $db_connect->query("SELECT deleted FROM {$cron_name}_scrapped_data WHERE stock_number='$stock_number'");
		$is_sold = "Available";
		
		if (!mysqli_num_rows($check_query) || mysqli_fetch_assoc($check_query)['deleted']) {
			$is_sold = "Sold Out";
		}

		$vehicle_stats[$stock_number] = [
			'title' => $title,
			'clicks' => $clicks,
			'fillups' => $fillups,
			'is_sold' => $is_sold,
			'url' => $url,
			'engaged_user_count' => $engaged_user_count,
			'buttons' => [
				$button_name => [
					'clicks' => $clicks,
					'fillups' => $fillups
				]
			]
		];
	}
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">
	<?php
	$select = 'ai-button-statistics';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel panel-info">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">Button Details for :: <?= $cron_name ?></h2>
					</header>
					<div class="panel-body">
						<form method="GET" class="form-inline">
							<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
							<select class="form-control mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership">
								<?php
								foreach ($cron_names as $c_name) {
									$selected = ($cron_name == $c_name) ? ' selected' : '';
								?>
									<option value="<?= $c_name ?>" <?= $selected ?>><?= $c_name ?></option>
								<?php } ?>
							</select>

							<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Date Range</label>
							<select class="form-control mb-2 mr-sm-2 mb-sm-0" name="date_range" id="date_range">
								<?php
								foreach (($date_ranges = date_range_data()) as $key => $val) {
									$selected = $date_range == $key ? ' selected' : '';
								?>
									<option value="<?= $key ?>" <?= $selected ?>><?= $val ?></option>
								<?php } ?>
							</select>

							<div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom') : ?>display:none<?php endif; ?>">
								<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
								<input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" required="" />

								<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
								<input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" required="" />
							</div>
							<button class="btn btn-primary ml-md">Apply Filter</button>
						</form>
					</div>
				</section>
			</div>
			<div class="col-lg-12">
				<!-- Button Statistics Table -->
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
							<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
						</div>
						<h2 class="panel-title"> Button Statistics </h2>
					</header>
					<div class="panel-body">
						<table class="table table-bordered table-striped mb-none" id="button-statistics">
							<thead>
								<tr>
									<th>Title</th>
									<th> Stock Number </th>
									<th>Clicks</th>
									<th>Fillups</th>
									<th>Engaged User</th>
									<th> Is Sold </th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($vehicle_stats as $stock_number => $state) { ?>
									<tr data-details='<?= json_encode($state['buttons']) ?>'>
										<td> <a href="<?= $state['url'] ?>" target="_blank"> <?= $state['title'] ?> </a></td>
										<td><?= $stock_number ?></td>
										<td><?= $state['clicks'] ?></td>
										<td><?= $state['fillups'] ?></td>
										<td><?= $state['engaged_user_count'] ?></td>
										<td><?= $state['is_sold'] ?></td>
									<?php } ?>
									</tr>
							</tbody>
						</table>
					</div>
				</section>
				<!-- End Button Statistics Table -->
			</div>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';
?>

<script src="app/js/button-statistics-script.js"></script>
