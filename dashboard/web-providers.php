<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$db_connect    = new DbConnect('');
$web_provider  = $db_connect->getWebProviders();
$query 		   = "SELECT dealership, websites, website_provider, status FROM dealerships ORDER BY dealership ASC;";
$provider_name = isset($_GET['provider_name']) ? filter_input(INPUT_GET, 'provider_name') : null;

if ($provider_name) {
    $query = "SELECT dealership, websites, website_provider, status FROM dealerships WHERE website_provider = '{$provider_name}' ORDER BY dealership ASC;";
}

$fetch = $db_connect->query($query);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'web-providers';
	include 'bolts/sidebar.php';
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<form id="filter-form" method="GET" class="form-horizontal form-bordered">
				<div class="col-lg-12">
					<section class="panel panel-info">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="panel-action"></a>
							</div>
							<h2 class="panel-title"> WEBSITE PROVIDERS </h2>
						</header>

						<div class="panel-body">
		                    <div class="row">
		                        <div class="col-md-6">
		                            <div class="form-group">
		                                <label class="col-md-3 control-label"> Website Provider </label>
		                                <div class="col-md-9">
		                                    <select data-plugin-selectTwo class="form-control populate" name="provider_name" style="width: 50%">
		                                        <option value="">-- Select --</option>
		                                        <?php foreach ($web_provider as $value) { ?>
		                                        <option value="<?= $value ?>" <?= $provider_name == $value ? 'selected' : '' ?>><?= $value ?></option>
		                                        <?php } ?>
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="row">
		                        <div class="col-md-6 col-sm-12"> </div>
		                        <div class="col-md-6 col-sm-12">
		                            <div class="form-group">
		                                <label class="col-sm-4 control-label"></label>
		                                <div class="col-sm-8 clearfix">
		                                    <button id="btn-filter" type="submit" class="btn btn-info mr-xs pull-right ml-xs">Apply Filter</button>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>

						<div class="panel-body">
							<div class="row form-group-row">
								<div class="col-md-12">
									<table class="table table-bordered table-striped mb-none table-advanced">
										<thead>
											<tr>
												<th> # </th>
												<th> Dealership </th>
												<th> Website URL </th>
												<th> Website Provider </th>
												<th> Status </th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i = 1;

											while ($value = mysqli_fetch_assoc($fetch)) {
											?>
											<tr>
												<td><?= $i++ ?></td>
												<td>
													<a href="details.php?dealership=<?= $value['dealership'] ?>" target="_blank">
														<?= $value['dealership'] ?>
													</a>
												</td>
												<td>
													<a href="<?= $value['websites'] ?>" target="_blank">
														<i><?= $value['websites'] ?></i>
													</a>
												</td>
												<td><?= $value['website_provider'] ?></td>
												<td><?= $value['status'] ?></td>
											<?php
											}
											?>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<footer class="panel-footer">
							<div class="form-group">

							</div>
						</footer>
					</section>
				</div>
			</form>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';