<?php

session_start();
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once 'bolts/header.php';

ob_start();
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'cron_misc.php';
require_once ADSYNCPATH . 'carlist-loader.php';

$select = 'vs_configuration';
require_once 'bolts/sidebar.php';

global $user;

$cron_name = $user['cron_name'];

add_script('vs_config', 'app/js/vs_config.js');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'save-vs-config')) {
	$min_price          = filter_input(INPUT_POST, 'min_price');
	$max_price          = filter_input(INPUT_POST, 'max_price');
	$page_type          = $_POST['page_type'];
	$page_type_heading  = $_POST['page_type_heading'];
	$required_param     = $_POST['required_param'];
	$vs_config_query    = DbConnect::get_instance()->query("SELECT * FROM vs_config where dealership = '$cron_name'");
	$vs_config_status   = mysqli_num_rows($vs_config_query);

	if ($vs_config_status) {
		$vs_config      = DbConnect::get_instance()->query("UPDATE vs_config SET min_price='$min_price', max_price ='$max_price' WHERE dealership = '$cron_name'");
	} else {
		$vs_config      = DbConnect::get_instance()->query("INSERT INTO vs_config (dealership, min_price, max_price)  VALUES ('$cron_name', '$min_price', '$max_price')");
	}

	$vs_page_delete_query = DbConnect::get_instance()->query("DELETE FROM vs_page_type where dealership = '$cron_name'");

	if ($vs_page_delete_query) {
		for ($i = 0, $page_Count = sizeof($page_type); $i < $page_Count; $i++) {
			$vs_page_insert = DbConnect::get_instance()->query("INSERT INTO vs_page_type (dealership, page_type, page_type_heading, required_param)  VALUES ('$cron_name', '$page_type[$i]', '$page_type_heading[$i]', '$required_param[$i]')");
		}
	}
}

$vs_config_query    = DbConnect::get_instance()->query("SELECT * FROM vs_config where dealership = '$cron_name'");
$vs_config_data     = $vs_config_query->fetch_assoc();
$vs_page_query      = DbConnect::get_instance()->query("SELECT * FROM vs_page_type where dealership = '$cron_name'");
$vs_page_status     = mysqli_num_rows($vs_page_query);
?>

<div class="inner-wrapper">
	<section role="main" class="content-body">
		<header class="page-header"></header>

		<div class="row">
			<div class="col-lg-10">
				<?php
				if (isset($vs_config)) {
					if ($vs_config) {
				?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								<i class="fas fa-times"></i>
							</button>
							<p class="text-tertiary"><strong>Thank You!</strong> You configuration data is successfully updated for <strong><i><?= $cron_name; ?></i></strong>!.</p>
						</div>
					<?php

					} else {
					?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<p class="text-danger"><strong> Error! </strong> You configuration data is not updated for <?= $cron_name; ?>!.</p>
						</div>
				<?php
					}
				}
				?>

				<section class="panel panel-info">
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
									foreach ($cron_names as $c_name) {
										$selected = ($cron_name == $c_name) ? ' selected' : '';
								?>
										<option value="<?= $c_name ?>" <?= $selected ?>><?= $c_name ?></option>
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
				</section>
			</div>


			<div class="col-md-10">
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>
						<h2 class="panel-title"> Visual Scraper Configuration Panel for &nbsp;<strong><i><?= $cron_name ?></i></strong></h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form method="POST" class="form-bordered" action="?dealership=<?= $cron_name ?>">
									<div class="row form-group-row padding-zero-fifteen">
										<div class="col-sm-4">
											<div class="form-group">
												<label class="control-label"><strong> Min Price (in USD) </strong></label>
												<input type="number" class="form-control" name="min_price" value="<?= isset($vs_config_data['min_price']) ? $vs_config_data['min_price'] : '1000'; ?>" placeholder="1000" required />
											</div>
										</div>

										<div class=" col-sm-4">
											<div class="form-group">
												<label class="control-label"><strong> Max Price (in USD) </strong></label>
												<input type="number" class="form-control" name="max_price" value="<?= isset($vs_config_data['max_price']) ? $vs_config_data['max_price'] : '1000000'; ?>" placeholder="1000000" required />
											</div>
										</div>
									</div>

									<div class="row form-group-row">
										<div class="col-lg-12">
											<table id="myTable" class="table table-bordered table-hover table-striped centered-text">
												<thead>
													<tr>
														<th class="col-sm-4 centered-text"> Page Type </th>
														<th class="col-sm-4 centered-text"> Page Type Heading </th>
														<th class="col-sm-3 centered-text"> Required Parameter </th>
														<th class="col-sm-1 centered-text">
															<button id="addrow" type="button" class="btn btn-md btn-success">
																<i class="fa fa-plus"></i> Add
															</button>
														</th>
													</tr>
												</thead>

												<tbody>
													<?php
													if ($vs_page_status) {
														foreach ($vs_page_query as $key => $value) {
													?>
															<tr class="padding-zero-fifteen">
																<td class="col-sm-4">
																	<input type="text" required name="page_type[]" class="form-control" value="<?= isset($value['page_type']) ? $value['page_type'] : ''; ?>" />
																</td>
																<td class="col-sm-4">
																	<input type="text" required name="page_type_heading[]" class="form-control" value="<?= isset($value['page_type_heading']) ? $value['page_type_heading'] : ''; ?>" />
																</td>
																<td class="col-sm-3">
																	<input type="text" name="required_param[]" class="form-control" value="<?= isset($value['required_param']) ? $value['required_param'] : ''; ?>" />
																</td>
																<td class="col-sm-1">
																	<input type="button" class="ibtnDel btn btn-md btn-danger " value="Delete">
																</td>
															</tr>

														<?php
														}
													} else {
														?>

														<tr class="padding-zero-fifteen">
															<td class="col-sm-4">
																<input type="text" name="page_type[]" class="form-control" required />
															</td>
															<td class="col-sm-4">
																<input type="text" name="page_type_heading[]" class="form-control" required />
															</td>
															<td class="col-sm-3">
																<input type="text" name="required_param[]" class="form-control" />
															</td>
															<td class="col-sm-1">
																<input type="button" class="ibtnDel btn btn-md btn-danger " value="Delete">
															</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>

									<br>

									<div class="row form-group-row">
										<div class=" col-sm-offset-9  col-md-3">
											<div class="form-group">
												<button name="btn" value="save-vs-config" class="btn btn-block btn-primary "> Save Changes </button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>


<style type="text/css">
	.padding-zero-fifteen {
		padding: 0 0 15px 15px;
	}

	.centered-text {
		text-align: center;
	}
</style>


<script type="text/javascript">

</script>


<?php
include 'bolts/footer.php'
?>
