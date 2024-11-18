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

// Customize for this page because we want to show default all times data here
$date_range = filter_input_default(INPUT_GET, 'date_range');
$status = filter_input(INPUT_GET, 'status');

if (!$date_range) {
	$start_date = '2010-01-01';
	$end_date = date("Y-m-d");
	$date_range = 'all_time';
}

if (!$status) {
	$status = 'all';
}

$total = 0;

$query = "SELECT dealership, SUM(COUNT) AS total FROM engaged_vdp WHERE (`day` BETWEEN '{$start_date}' AND '{$end_date}') GROUP BY dealership ORDER BY dealership;";
$epmFetch = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($epmFetch)) {
	$EPM[$row['dealership']] = ['total' => $row['total']];
	$total += $row['total'];
}

$fetchStatus = $db_connect->query("SELECT dealership, company_name, status, websites FROM dealerships ORDER BY dealership;");

while ($rowe = mysqli_fetch_assoc($fetchStatus)) {
	if (isset($EPM[$rowe['dealership']])) {
		if ($status == 'all') {
			$EPM[$rowe['dealership']]['status'] = $rowe['status'];
			$EPM[$rowe['dealership']]['company_name'] = $rowe['company_name'];
			$EPM[$rowe['dealership']]['url'] = $rowe['websites'];
		} elseif (strtolower($rowe['status']) == strtolower($status)) {
			$EPM[$rowe['dealership']]['status'] = $rowe['status'];
			$EPM[$rowe['dealership']]['company_name'] = $rowe['company_name'];
			$EPM[$rowe['dealership']]['url'] = $rowe['websites'];
		} else {
			unset($EPM[$rowe['dealership']]);
		}
	}
}

// echo("<script type='text/javascript'> location.href = location.href; </script>");


include 'bolts/header.php'
?>

<div class="inner-wrapper">
	<?php
	$select = 'epm-monthly';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>

		<div class="col-lg-12">
			<section class="panel panel-info">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					</div>
					<h2 class="panel-title">Filters</h2>
				</header>
				<div class="panel-body">
					<form method="GET" class="form-inline">
						<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Current Status</label>
						<select class="form-control mb-2 mr-sm-2 mb-sm-0" name="status" data-plugin-multiselect data-plugin-options='{ "maxHeight": 300 }'>
							<option value="all" <?= $status == 'all' ? 'selected' : '' ?>> All</option>
							<option value="active" <?= $status == 'active' ? 'selected' : '' ?>> Active
							</option>
							<option value="trial" <?= $status == 'trial' ? 'selected' : '' ?>> Trial
							</option>
							<option value="trial-setup" <?= $status == 'trial-setup' ? 'selected' : '' ?>>
								Trial Setup
							</option>
							<option value="inactive" <?= $status == 'inactive' ? 'selected' : '' ?>>
								Inactive
							</option>
							<option value="unsure" <?= $status == 'unsure' ? 'selected' : '' ?>> Unsure
							</option>
							<option value="free" <?= $status == 'free' ? 'selected' : '' ?>> Free</option>
						</select>

						<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Date Range</label>
						<select class="form-control mb-2 mr-sm-2 mb-sm-0" name="date_range" id="date_range">
							<?php
							foreach (($date_ranges = date_range_data()) as $key => $val) {
								$selected = $date_range == $key ? ' selected' : '';
							?>
								<option value="<?= $key ?>" <?= $selected ?>><?= $val ?></option>
							<?php
							}
							?>
						</select>

						<div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom') : ?>display:none<?php endif; ?>">
							<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
							<input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?= $start_date ?>" required="" />

							<label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
							<input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?= $end_date ?>" required="" />
						</div>

						<button class="btn btn-primary ml-md"> Apply Filter</button>
					</form>
				</div>
			</section>
		</div>

		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">

					</div>
					<h2 class="panel-title"> Engagement Between :: <?= $start_date . ' to ' . $end_date . ' and Dealer Status :: ' . $status ?></h2>
				</header>

				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 conflict-table">
							<table class="table table-bordered table-striped mb-none table-advanced">
								<thead>
									<tr>
										<th> Dealership Name</th>
										<th> Company Name</th>
										<th> Website URL</th>
										<th> Current Status</th>
										<th> Total Engagement</th>
									</tr>
								</thead>

								<tbody>
									<?php
									foreach ($EPM as $dealer => $data) {
									?>
										<tr>
											<td> <?= $dealer ?> </td>
											<td> <?= ucwords($data['company_name']) ?> </td>
											<td>
												<a href="<?= $data['url'] ?>" target="_blank">
													<i><?= $data['url'] ?></i>
												</a>
											</td>
											<td> <?= ucwords($data['status']) ?> </td>
											<td><strong><?= $data['total'] ?></strong></td>
										</tr>
									<?php
									}
									?>
								</tbody>

								<tfoot>
									<th colspan="3"></th>
									<th style="text-align: center;"> Total</th>
									<th style="text-align: center;"> <?= $total ?> </th>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</section>
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


	$("#export").click(function() {
		$('table#export-table').csvExport({
			title: 'engaged_user_car'
		});
	});
</script>
