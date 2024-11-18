<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'db_connect.php';
global $user;
$cron_name = filter_input(INPUT_GET, 'dealership');
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);
?>
<?php include 'bolts/header.php' ?>
<div class="inner-wrapper">
	<?php $select = 'sold-vs-engaged';
	include 'bolts/sidebar.php'
	?>
	<script>
		var sold_vs_engaged = true;
	</script>
	<section role="main" class="content-body">
		<header class="page-header"> </header>
		<!-- start: page -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel-body">
					<form method="GET" class="
                        form-inline">
						<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
						&nbsp; &nbsp;
						<select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership" data-plugin-selectTwo>
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
							}
							?>
						</select>
						&nbsp; &nbsp;
						<button class="btn btn-primary ml-md"> Submit </button>
					</form>
				</div>
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>
						<h2 class="panel-title">Ratio of Engaged Users</h2>
						<p class="panel-subtitle">Number of Engaged users for each vehicle sold in the week.</p>
					</header>
					<div class="panel-body">
						<div class="chart chart-md" id="engaged-user-chart"></div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>
<?php include 'bolts/footer.php';
