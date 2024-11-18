<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'includes/button.php';

$start_date = $start_date . ' 0:0:0';
$end_date = $end_date . ' 23:59:59';
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);

$dealership_input = filter_input(INPUT_GET, 'dealership');
if (!$dealership_input) {
	$cron_name = '';
}

if ($dealership_input == 'all') {
	$log_query = DbConnect::get_instance()->query("SELECT * FROM log_data WHERE (date_time BETWEEN '$start_date' AND '$end_date')");
} else {
	$log_query = DbConnect::get_instance()->query("SELECT * FROM log_data WHERE dealership = '$cron_name' AND (date_time BETWEEN '$start_date' AND '$end_date')");
}

$log_data = [];
$i = 0;

while ($record = mysqli_fetch_assoc($log_query)) {
	$i++;
	$log_data[$i]['user_id'] = $record['user_id'];
	$log_data[$i]['dealership'] = $record['dealership'];
	$log_data[$i]['action'] = $record['action'];
	$log_data[$i]['details'] = $record['details'];
	$log_data[$i]['ip'] = $record['ip'];
	$log_data[$i]['date_time'] = date('F j, Y, g:i a', strtotime($record['date_time']));
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">
	<?php
	$select = 'view-log';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<div class="col-lg-12">
				<?php if (filter_input(INPUT_GET, 'dealership') != $cron_name) { ?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
						<strong><?= filter_input(INPUT_GET, 'dealership') ?></strong> is either Inactive or doesn't have Buttons configured.
					</div>
				<?php
				} ?>

				<section class="panel panel-info">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">Details Log for : <?= $cron_name ?></h2>
					</header>
					<div class="panel-body">
						<form method="GET" class="form-inline">
							<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
								<?php

								?>
								<option value="all" <?= $dealership_input == 'all' ? ' selected' : '' ?>> -- All-- </option>
								<option value="" <?= $dealership_input == '' ? ' selected' : '' ?>> -- All others -- </option>
								<?php
								if ($user['type'] == 'a') {
									foreach ($all_dealerships as $dealership) {
										$selected = ($cron_name == $dealership['dealership']) ? ' selected' : '';
								?>
										<option value="<?= $dealership['dealership'] ?>" <?= $selected ?>><?= $dealership['dealership'] ?></option>
									<?php

									}
								} else {
									?>
									<option value="<?= $user['cron_name'] ?>" <?= ' selected' ?>><?= $user['cron_name'] ?> </option>
								<?php
								} ?>
							</select>

							<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Date Range</label>
							<select class="form-control mb-2 mr-sm-2 mb-sm-0" name="date_range" id="date_range">
								<?php
								foreach (($date_ranges = date_range_data()) as $key => $val) {
									$selected = $date_range == $key ? ' selected' : '';
								?>
									<option value="<?= $key ?>" <?= $selected ?>><?= $val ?></option>
								<?php
								} ?>
							</select>

							<div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom') : ?>display:none<?php endif; ?>">
								<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
								<input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" />

								<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
								<input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" />
							</div>
							<button class="btn btn-primary ml-md"> Apply Filter </button>
							<!-- <button type="button" class="btn btn-gplus ml-md" id="export"> Export </button> -->
						</form>
					</div>
				</section>
			</div>

			<div class="col-lg-12">
				<section class="panel">

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-striped mb-none table-advanced">
									<thead>
										<tr>
											<th> User ID </th>
											<?php
											if ($dealership_input == 'all') {
												echo '<th> Dealership </th>';
											}
											?>
											<th> Action </th>
											<th> Details </th>
											<th> IP </th>
											<th> Date & Time </th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($log_data as $key => $value) : ?>
											<tr>
												<td> <?= $log_data[$key]['user_id'] ?> </td>
												<?php
												if ($dealership_input == 'all') {
													echo '<td>' . $log_data[$key]['dealership'] . '</td>';
												}
												?>
												<td> <?= $log_data[$key]['action'] ?> </td>
												<td> <?= $log_data[$key]['details'] ?> </td>
												<td> <?= $log_data[$key]['ip'] ?> </td>
												<td> <?= $log_data[$key]['date_time'] ?> </td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';
?>

<script>
	$("#date_range").change(function() {
		if (this.value == "custom") {
			$("#custom_date_range").show();
		} else {
			$("#custom_date_range").hide();
		}
	});
</script>
