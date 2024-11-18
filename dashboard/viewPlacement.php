<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $user, $CronConfigs;

$dealership = $user['cron_name'];
$cron_config = $CronConfigs[$dealership];
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);

$query = 'SELECT * FROM ' . $dealership . '_scrapped_data where deleted=0';
$result = DbConnect::get_instance()->query($query);
$allPlacement = [];

while ($car = mysqli_fetch_assoc($result)) {
	$search_strings = array(
		"{$car['year']} {$car['make']} {$car['model']} Review"
	);

	if (isset($cron_config['city'])) {
		$search_strings[] = "{$car['year']} {$car['make']} {$car['model']} {$cron_config['city']}";
	}

	foreach ($search_strings as $search_query) {
		$allPlacement[$search_query]['car'][$car['stock_number']]['url'] = $car['url'];
		$query = "SELECT id, last_attempt, results FROM posible_placement_criterias WHERE criteria = '$search_query'";
		$res = DbConnect::get_instance()->query($query);
		$row = mysqli_fetch_array($res);
		$allPlacement[$search_query]['placement_id'] = $row['id'];
		$allPlacement[$search_query]['last_attempt'] = $row['last_attempt'];
		$allPlacement[$search_query]['num_of_placement'] = $row['results'];
		$query_id = $row['id'];
		if (!empty($query_id)) {
			$query2 = "SELECT id,url FROM posible_placement_urls WHERE criteria_id =$query_id ";
			$urlRes = DbConnect::get_instance()->query($query2);
			while ($data = mysqli_fetch_assoc($urlRes)) {
				$allPlacement[$search_query]['placement_url'][$data['id']] = $data['url'];
			}
		}
	}
}
?>


<?php include 'bolts/header.php' ?>

<div class="inner-wrapper">
	<?php
	$select = 'view-placement';
	include 'bolts/sidebar.php';
	$i = 1;
	?>

	<section role="main" class="content-body">
		<header class="page-header">
		</header>

		<div class="row">
			<div class="col-md-12">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					</div>
					<h2 class="panel-title"> Configuration Panel </h2>
				</header>

				<div class="panel-body">
					<form method="GET" class="
                        form-inline">
						<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
						&nbsp; &nbsp;
						<select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership" data-plugin-selectTwo>
							<?php
							if ($user['type'] == 'a') {
								foreach ($all_dealerships as $dealer) {
									$selected = ($dealership == $dealer['dealership']) ? ' selected' : '';
							?>
									<option value="<?= $dealer['dealership'] ?>" <?= $selected ?>><?= $dealer['dealership'] ?></option>
								<?php

								}
							} else {
								?>
								<option value="<?= $user['cron_name'] ?>" <?= ' selected' ?>><?= $user['cron_name'] ?> </option>
							<?php
							}
							?>
						</select>
						&nbsp; &nbsp;
						<button class="btn btn-primary ml-md"> Submit</button>
					</form>
				</div>
				<br>
				<section class="panel panel-info">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>

						<h2 class="panel-title"> Criteria and number of Placement URL <span> ( Only active car )</span> </h2>
					</header>

					<div class="panel-body">
						<?php
						//                            echo '<pre>';
						//                            print_r($allPlacement);
						?>
						<?php if (count($allPlacement)) { ?>
							<table class="table table-bordered mb-none table-advanced">
								<thead>
									<tr>
										<th> #</th>
										<th> Criteria (Year Make Model)</th>
										<th> Last Attempt</th>
										<th> Number of URL in Placement</th>
										<th> Number of Car</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($allPlacement as $name => $info) : ?>
										<tr>
											<td><?= $i++; ?></td>
											<td><?= $name ?></td>
											<td><?= $info['last_attempt'] ?></td>
											<td><?= $info['num_of_placement'] ?></td>
											<td><?= count($info['car']) ?></td>

										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php } ?>

					</div>
				</section>

			</div>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';
