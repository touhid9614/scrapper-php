<?php


require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once 'tracking-config/function.php';
require_once 'facebook/fb-data.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Predis\Client as RedisClient;

global $user, $redis, $redis_config;

$cron_name = $user['cron_name'];


$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);
$id = isset($_GET['id']) ? $_GET['id'] : false;
$type = isset($_GET['type']) ? $_GET['type'] : 'analytics';
include 'bolts/header.php';
$save_new = false;
$update_con = false;
$delete_con = false;

$query = "select * from dealer_facebook_campaign where dealership = '$cron_name'";
$result = DbConnect::get_instance()->query($query);
$data = array();
while ($details = mysqli_fetch_assoc($result)) {
	$row = array();
	$row['name'] = $details['name'];
	array_push($data, $row);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($cron_name == 'titanauto') {
		if ($_POST['btn'] == 'PAUSED') {
			$campaign_id = $_POST['pause_camp_id'];
			updateFBCampaign($campaign_id, 'PAUSED');
//			echo "<script>alert('PAUSED Success')</script>";
		} else if ($_POST['btn'] == 'ACTIVE') {
			$campaign_id = $_POST['active_camp_id'];
			updateFBCampaign($campaign_id, 'ACTIVE');
//			echo "<script>alert('ACTIVE Success')</script>";
		} else if($_POST['btn'] == 'edit-camp'){
			$campaign_id = $_POST['campId'];
			$status = $_POST['campStatus'];
			$budgetType = $_POST['campBudgetTypeKey'];
			$budgetAmount = $_POST['campBudget']*100;
			$bid_strategy = $_POST['campBidStrategy'];

//			echo $campaign_id.'<br>';
//			echo $status.'<br>';
//			echo $budgetType.'<br>';
//			echo $budgetAmount.'<br>';
//			echo $bid_strategy.'<br>';

			updateFBCampaign($campaign_id, $status, $bid_strategy , $budgetType, $budgetAmount);
		}
		echo("<script type='text/javascript'> location.href = location.href; </script>");
	} else {
		echo "<script>alert('For the time being this service only active for titanauto test ad account.')</script>";
	}
}
$fb_account_id = false;
$all_fb_campaign = [];

$use_redis = false;

if ($use_redis) {

	if (!$redis) {
		$redis = new RedisClient($redis_config);
	}
	$data_key = 'facebook_campaign_list_' . $cron_name;
	$account_key = 'facebook_account_id' . $cron_name;

	if (isset($redis)) {
		if ($fb_acc_id = $redis->get($account_key)) {
			$fb_account_id = $fb_acc_id;
		}
		if ($fb_campaign_data_str = $redis->get($data_key)) {
			$all_fb_campaign = unserialize($fb_campaign_data_str);
		}
	}
	if (!$fb_account_id) {
		$account_ids = get_account_id($cron_name, 'facebook');
		if (count($account_ids)) {
			$acc_id = array_key_first($account_ids);
			if ($cron_name == 'titanauto') {
				$fb_account_id = 'act_999138520297362';
			} else {
				$fb_account_id = getAccountId($acc_id);
			}

			if ($fb_account_id && isset($redis)) {
				$redis->set($account_key, $fb_account_id);
				$redis->expire($account_key, 10 * 60 * 60);
			}
		}

	}

	if ($fb_account_id) {
		$all_fb_campaign = getAllCampaigns($fb_account_id);
		if (count($all_fb_campaign) && isset($redis)) {
			$redis->set($data_key, serialize($all_fb_campaign));
			$redis->expire($data_key, 10 * 60);
		}
	}
} else {
	$account_ids = get_account_id($cron_name, 'facebook');
	if (count($account_ids)) {
		$acc_id = array_key_first($account_ids);
		if ($cron_name == 'titanauto') {
			$fb_account_id = 'act_999138520297362';
		} else {
			$fb_account_id = getAccountId($acc_id);
		}
	}

	if ($fb_account_id) {
		$all_fb_campaign = getAllCampaigns($fb_account_id);
	}
}


?>
<style>
	.error {
		color: red;
		display: none;
	}

	.success {
		display: none;
	}

	.mt-1 {
		margin-top: 10px !important;
	}

	.m-1 {
		margin: 10px !important;
	}

	.mt-0 {
		margin-top: 0px !important;
	}

	.hide {
		display: none;
	}
</style>

<div class="inner-wrapper">

	<?php
	$select = 'facebook-campaign';
	include 'bolts/sidebar.php';
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<div class="col-md-12">
				<section class="panel panel-info">
					<div class="panel-body">
						<form method="GET" class="form-inline">
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
							&nbsp; &nbsp;
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership"
									data-plugin-selectTwo>
								<?php
								if ($user['type'] == 'a') {
									foreach ($all_dealerships as $dealer) {
										$selected = ($cron_name == $dealer['dealership']) ? ' selected' : '';
										?>
										<option
											value="<?= $dealer['dealership'] ?>"<?= $selected ?>><?= $dealer['dealership'] ?></option>
										<?php

									}
								} else {
									?>
									<option
										value="<?= $user['cron_name'] ?>"<?= ' selected' ?>><?= $user['cron_name'] ?> </option>
									<?php
								} ?>
							</select>
							&nbsp; &nbsp;
							<button class="btn btn-primary ml-md"> Submit</button>
						</form>
					</div>
				</section>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<section class="panel panel-info">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title"> Facebook Campaign Configuration Panel </h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<form id="fb-campaign" method="post">
								<div class="row m-1">
									<input type="hidden" value="<?= $cron_name ?>" name="dealer" id="dealer">
									<div class="col-md-4">
										<div class="form-group">
											<label for="prefix">Prefix</label>
											<input class="form-control" type="text" value="sMedia" name="prefix"
												   id="prefix"
												   placeholder="Prefix">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="utmprefix">UTM Prefix</label>
											<input class="form-control" type="text" value="sMedia" name="utmprefix"
												   id="utmprefix"
												   placeholder="UTM Prefix">
										</div>
									</div>
								</div>

								<div class="row m-1">
									<div class="col-md-4">
										<div class="form-group">
											<label for="objectives">Objectives</label>
											<select name="objectives" id="objectives" class="form-control">
												<option value="0">Select One</option>
												<option value="Lead">Dynamic/Lead Generation</option>
												<option value="Catalogue">Dynamic/Catalog Sales</option>
												<option value="Web Clicks">Web Clicks</option>
												<option value="Lead Ad">Lead Generation</option>
											</select>
											<p id="objectiveserror" class="error">*Please Select One</p>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="audience">Audience</label>
											<select name="audience" id="audience" class="form-control">
												<option value="0">Select One</option>
												<option value="Lookalike">Lookalike</option>
												<option value="Retargeting">Retargeting</option>
												<option style='display:none;' id="generalaudience"
														value="General Audience">General Audience
												</option>
												<option style='display:none;' id="customeraudience"
														value="Customer Audience">Customer Audience
												</option>
											</select>
											<p id="audienceerror" class="error">*Please Select One</p>
										</div>

									</div>


									<div class="col-md-2">
										<div class="form-group">
											<label for="adformats">Ad Formats</label>
											<select name="adformats" id="adformats" class="form-control">
												<option value="0">Select One</option>
												<option value="Carousel">Carousel</option>
												<option value="Carousel SS">Carousel SS</option>
												<option value="Collections">Collections</option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label for="inventory">Inventory</label>
											<select name="inventory" id="inventory" class="form-control">
												<option value="0">All</option>
												<option value="NEW">NEW</option>
												<option value="USED">USED</option>
											</select>
										</div>
									</div>

								</div>
								<div class="row m-1">

									<div class="col-md-2">
										<div class="form-group">
											<label for="aged">Aged</label>
											<select name="aged" id="aged" class="form-control">
												<option value="0">No</option>
												<option value="Aged">Yes</option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label for="customfeed">CustomFeed/Branding</label>
											<select name="customfeed" id="customfeed" class="form-control">
												<option value="0"> No</option>
												<option value="CustomFeed/Branding">YES</option>
											</select>
										</div>
									</div>

									<div class="col-md-4" style='display:none;' id="showpostfix">
										<div class="form-group">
											<label for="postfix">Postfix</label>
											<input class="form-control" type="text" name="postfix" id="postfix"
												   placeholder="Postfix">
										</div>
									</div>

									<div class="col-md-4" style='display:none;' id="showutmpostfix">
										<div class="form-group">
											<label for="utmpostfix">UTM Postfix</label>
											<input class="form-control" type="text" name="utmpostfix" id="utmpostfix"
												   placeholder="UTM Postfix">
										</div>
									</div>
								</div>
								<hr>
								<div class="row m-1">
									<div class="col-md-3">
										<div class="form-group">
											<label for="special_ad_category">Special Ad Category </label>
											<label> </label>
											<select multiple data-plugin-selectTwo name="special_ad_category"
													id="special_ad_category" class="form-control populate"
													multiple="multiple">
												<!--												<option value="[]" selected>NONE</option>-->
												<option value="EMPLOYMENT">EMPLOYMENT</option>
												<option value="HOUSING">HOUSING</option>
												<option value="CREDIT">CREDIT</option>
												<option value="ISSUES_ELECTIONS_POLITICS">
													ISSUES_ELECTIONS_POLITICS
												</option>
											</select>
											<p>( Leave it blank if NONE )</p>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label for="budgetType">Budget</label>
											<select name="budgetType" id="budgetType" class="form-control">
												<option value="daily_budget"> Daily Budget</option>
												<option value="lifetime_budget">Life Time Budget</option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label for="budgetAmount">Budget Amount</label>
											<input class="form-control" type="number" value="3.5"
												   name="budgetAmount"
												   id="budgetAmount">
											<!--											<p>( 350 = $3.5 )</p>-->
										</div>
									</div>


									<div class="col-md-2">
										<div class="form-group">
											<label for="bid_strategy">Bid Strategy</label>
											<select name="bid_strategy" id="bid_strategy" class="form-control">
												<option value="LOWEST_COST_WITHOUT_CAP">Lowest cost</option>
												<option value="COST_CAP">Cost cap</option>
												<option value="LOWEST_COST_WITH_BID_CAP">Bid cap</option>
											</select>
										</div>
									</div>

								</div>

								<div class="row m-1">
									<div class="col-md-2">
										<input class="form-control" type="hidden" name="fb_acc_id" id="fb_acc_id"
											   value="<?= $fb_account_id ?>">

										<input type="submit" value="Add"
											   name="submit"
											   class="fb-campaign btn btn-lg btn-primary mt-0 btn-block">
									</div>
									<div class="col-md-6 success" id="successMessage">
										<div class="alert alert-success">
											<strong>Successful!! </strong> Data Added SuccessFully</a>.
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12">

				<section class="mt-md panel panel-featured panel-featured-primary" style="display: none">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">List of existing campaigns </h2>
					</header>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table mb-none table-advanced-new">
								<thead>
								<tr>
									<th>Campaign Name</th>
									<th>Status</th>
									<th>Pause Button</th>
									<th>Total Ads</th>
								</tr>
								</thead>
								<tbody>
								<?php
								foreach ($data as $value) {
									?>
									<tr>
										<td><?= $value['name'] ?></td>
										<td></td>
										<td><a class="btn btn-danger" href="">Pause</a></td>
										<td></td>
									</tr>
									<?php
								}
								?>
								</tbody>
							</table>
						</div>

					</div>
				</section>

				<section class="mt-md panel panel-featured panel-featured-primary">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">List of existing campaigns in Facebook</h2>
					</header>
					<div class="panel-body">
						<?php
						if ($fb_account_id) {
							?>
							<div class="table-responsive">
								<table class="table mb-none fb-table" id="view-data">
									<thead>
									<tr>
										<th>Campaign Name</th>
										<th>Status</th>
										<th>Budget Type</th>
										<th>Budget</th>
										<th>Budget Remaining</th>
										<th>Last Update</th>
										<th style="width: 10%"></th>
										<!--									<th>Pause Button</th>-->
									</tr>
									</thead>
									<tbody>
									<?php
									$row_count=0;
									foreach ($all_fb_campaign as $camp) {
										?>
										<tr>
											<td><?= $camp['name'] ?></td>
											<td><?= $camp['status'] ?></td>

											<?php
											if (isset($camp['lifetime_budget'])) {
												echo "<td>Life Time</td>";
												echo "<td>$" . ($camp['lifetime_budget'] / 100) . "</td>";
											} else {
												echo "<td>Daily</td>";
												echo "<td>$" . ($camp['daily_budget'] / 100) . "</td>";
											}
											?>
											<td>$<?= ($camp['budget_remaining'] / 100) ?></td>
											<td><?= $camp['updated_time']->format('Y-m-d H:i:s'); ?></td>
											<td style='white-space: nowrap'>
												<button class="open-edit btn btn-info"
														data-id="<?= $row_count ?>"
														data-toggle="modal"
														data-target="#modalEdit" title="Edit the setting"><i
														class="fas fa-edit"></i>
												</button>
												<?php
												if ($camp['status'] == 'PAUSED') {
													?>
													<button class="open-active btn  btn-success"
															data-id="<?= $camp['id'] ?>"
															data-type="<?= $camp['name'] ?>" data-toggle="modal"
															data-target="#modalActive"
															title="Do you want to active the campaign?"><i
															class="far fa-play-circle"></i>
													</button>

													<?php
												} else if ($camp['status'] == 'ACTIVE') {
													?>
													<button class="open-pause btn  btn-danger"
															data-id="<?= $camp['id'] ?>"
															data-type="<?= $camp['name'] ?>" data-toggle="modal"
															data-target="#modalPause"
															title="Do you want to pause the campaign?"><i
															class="far fa-pause-circle"></i>
													</button>

													<?php
												}
												?>
											</td>

										</tr>
										<?php
										$row_count++;
									}
									?>
									</tbody>
								</table>
							</div>

							<?php
						} else {
							echo "<h2>No Account Found under the Pixel id.</h2>";
						}
						//						echo $acc_id . '<br>';
						//						echo $fb_account_id . '<br>';
						//						echo '<pre>';
						//						print_r($all_fb_campaign);
						//						echo '</pre>';
						//						?>
					</div>
				</section>
			</div>
		</div>


	</section>

	<div id="modalPause" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="height:50px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title text-danger" id="myModalLabel"><b>PAUSED !!! </b></h3>
				</div>
				<form method="post" class="form-horizontal">
					<div class="modal-body">
						<input type="hidden" name="pause_camp_id" id="pause_camp_id"/>
						<p id="pause_text"></p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger" name="btn" value="PAUSED">PAUSED</button>
						<button class="btn btn-default" data-dismiss="modal">Close
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalActive" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="height:50px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title text-success" id="myModalLabel"><b>ACTIVE !!! </b></h3>
				</div>
				<form method="post" class="form-horizontal">
					<div class="modal-body">
						<input type="hidden" name="active_camp_id" id="active_camp_id"/>
						<p id="active_text"></p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" name="btn" value="ACTIVE">ACTIVE</button>
						<button class="btn btn-default" data-dismiss="modal">Close
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalEdit" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="height:50px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title text-info" id="myModalLabel"><b>Edit the Campaign</b></h3>
				</div>
				<form method="post" class="form-horizontal">
					<div class="modal-body">

						<input type="hidden" class="form-control" id="campId" name="campId">
						<div class="form-group row">
							<label class="col-lg-3 control-label text-lg-right pt-2" for="campName">Name</label>
							<div class="col-lg-8">
								<textarea type="text" class="form-control" id="campName" rows="2" disabled ></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 control-label text-lg-right pt-2" for="campObjective">Objective</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="campObjective" disabled>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-lg-3 control-label text-lg-right pt-2" for="campSpecialAdCategory">Special Ad Category</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="campSpecialAdCategory" disabled>
<!--								<select multiple data-plugin-selectTwo name="campSpecialAdCategory"-->
<!--										id="campSpecialAdCategory" class="form-control populate"-->
<!--										multiple="multiple">-->
<!--									<option value="EMPLOYMENT">EMPLOYMENT</option>-->
<!--									<option value="HOUSING">HOUSING</option>-->
<!--									<option value="CREDIT">CREDIT</option>-->
<!--									<option value="ISSUES_ELECTIONS_POLITICS">-->
<!--										ISSUES_ELECTIONS_POLITICS-->
<!--									</option>-->
<!--								</select>-->
							</div>
						</div>

						<hr>

						<div class="form-group row">
							<label class="col-lg-3 control-label text-lg-right pt-2" for="campStatus">Status</label>
							<div class="col-lg-8">
								<select name="campStatus" id="campStatus" class="form-control">
									<option value="ACTIVE">ACTIVE</option>
									<option value="PAUSED">PAUSED</option>
								</select>
							</div>
						</div>

						<input type="hidden" class="form-control" id="campBudgetTypeKey" name="campBudgetTypeKey" >

						<div class="form-group row">
							<label class="col-lg-3 control-label text-lg-right pt-2" for="campBudget" id="campBudgetType"></label>
							<div class="col-lg-8">
								<input type="number" class="form-control" id="campBudget" name="campBudget" >
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 control-label text-lg-right pt-2" for="campBidStrategy">Bid Strategy</label>
							<div class="col-lg-8">
								<select name="campBidStrategy" id="campBidStrategy" class="form-control">
									<option value="LOWEST_COST_WITHOUT_CAP">Lowest cost</option>
									<option value="COST_CAP">Cost cap</option>
									<option value="LOWEST_COST_WITH_BID_CAP">Bid cap</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-info" name="btn" value="edit-camp">Update</button>
						<button class="btn btn-default" data-dismiss="modal">Close
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php include 'bolts/footer.php';
	?>
	<script>

		const all_campaign_list = <?php echo json_encode($all_fb_campaign); ?>;

		$(document).ready(function () {

			$('#customfeed').on('change', function () {
				// console.log("custom feed call. " + this.value);
				if (this.value == 'CustomFeed/Branding') {
					// console.log("match");
					$("#showpostfix").show();
					$("#showutmpostfix").show();
					$("#generalaudience").show();
					$("#customeraudience").show();
				} else {
					// console.log("Not match");
					$("#showpostfix").hide();
					$("#showutmpostfix").hide();
					$("#generalaudience").hide();
					$("#customeraudience").hide();
				}
			});

			$(".fb-campaign").click(function (e) {
				console.log('submit');
				e.preventDefault();

				let fbAccountElement = document.getElementById("fb_acc_id");
				let fbAccountId = fbAccountElement.value;

				let dealerElement = document.getElementById("dealer");
				let dealer = dealerElement.value;

				let prefixElement = document.getElementById("prefix");
				let prefix = prefixElement.value;
				prefix.trim();

				let utmprefixElement = document.getElementById("utmprefix");
				let utmprefix = utmprefixElement.value;
				utmprefix.trim();

				let postfixElement = document.getElementById("postfix");
				let postfix = postfixElement.value;
				postfix.trim();

				let utmpostfixElement = document.getElementById("utmpostfix");
				let utmpostfix = utmpostfixElement.value;
				utmpostfix.trim();

				let objectivesElement = document.getElementById("objectives");
				let objectives = objectivesElement.value;
				let objectiveserror = document.getElementById("objectiveserror");

				let audienceElement = document.getElementById("audience");
				let audience = audienceElement.value;
				let audienceerror = document.getElementById("audienceerror");

				let adformatsElement = document.getElementById("adformats");
				let adformats = adformatsElement.value;

				let agedElement = document.getElementById("aged");
				let aged = agedElement.value;

				let inventoryElement = document.getElementById("inventory");
				let inventory = inventoryElement.value;

				let customfeedElement = document.getElementById("customfeed");
				let customfeed = customfeedElement.value;

				let special_ad_categoryElement = $('#special_ad_category').val();
				// let special_ad_category = $('#special_ad_category').val();
				if (special_ad_categoryElement.length) {
					for (let i = 0; i < special_ad_categoryElement.length; i++) {
						if (i == 0) {
							special_ad_category = special_ad_categoryElement[i];
						} else {
							special_ad_category += ',' + special_ad_categoryElement[i];
						}
					}
				} else {
					special_ad_category = 'NONE';
				}

				let budgetTypeElement = document.getElementById("budgetType");
				let budgetType = budgetTypeElement.value;

				let budgetAmountElement = document.getElementById("budgetAmount");
				let budgetAmount = budgetAmountElement.value;

				budgetAmount = parseInt(budgetAmount) * 100;

				let bid_strategyElement = document.getElementById("bid_strategy");
				let bid_strategy = bid_strategyElement.value;

				// console.log(prefix);
				// console.log(objectives);
				// console.log(audience);
				// console.log(adformats);
				// console.log(aged);
				// console.log(inventory);
				// console.log(postfix);
				// console.log(customfeed);
				// console.log(customfeed);


				let name = '';
				let fbObjective = '';
				if (objectives == 'Catalogue') {
					fbObjective = 'PRODUCT_CATALOG_SALES';
					// sMedia Dynamic Retargeting-DealerName_Vehicle_ALL SEGMENTS_Carousel_Aged_USED
					// name = prefix + ' Dynamic ' + audience + '-' + dealer + '_Vehicle_ALL SEGMENTS';
					name = prefix + ' Dynamic ';
					if (audience == 'Lookalike' || audience == 'Retargeting') {
						name += audience + '-';
					}
					name += dealer + '_Vehicle_ALL SEGMENTS';

				} else if (objectives == 'Web Clicks') {
					fbObjective = 'LINK_CLICKS';
					// sMedia Web Clicks-DealerName_CampaignType
					name = prefix + ' Web Clicks-' + dealer + '_CampaignType';
				} else if (objectives == 'Lead Ad') {
					fbObjective = 'LEAD_GENERATION';
					// sMedia Lead Ad-DealerName_CampaignType
					name = prefix + ' Lead Ad-' + dealer + '_CampaignType';
				} else {
					fbObjective = 'LEAD_GENERATION';
					// sMedia Dynamic Lead Retargeting-DealerName_Vehicle_ALL SEGMENTS_USED
					// name = prefix + ' Dynamic Lead ' + audience + '-' + dealer + '_Vehicle_ALL SEGMENTS';
					name = prefix + ' Dynamic Lead ';
					if (audience == 'Lookalike' || audience == 'Retargeting') {
						name += audience + '-';
					}
					name += dealer + '_Vehicle_ALL SEGMENTS';
				}

				if (adformats != 0) {
					name += '_' + adformats
				}
				if (aged != 0) {
					name += '_' + aged
				}
				if (customfeed != 0) {
					name += '_' + customfeed
				}
				if (inventory != 0) {
					name += '_' + inventory
				}
				if (postfix.length) {
					name += '_' + postfix
				}

				console.log(name);

				let allOK = true;

				if (objectives == 0) {
					objectiveserror.style.display = "block";
					allOK = false;
				} else {
					objectiveserror.style.display = "none";
				}

				if (objectives != 'Web Clicks' && objectives != 'Lead Ad') {
					if (audience == 0) {
						audienceerror.style.display = "block";
						allOK = false;
					} else {
						audienceerror.style.display = "none";
					}
				}

				if (customfeed == 0) {
					if (audience == 'General Audience') {
						alert("You can't select General Audience without CustomFeed/Branding");
						allOK = false;
					} else if (audience == 'Customer Audience') {
						alert("You can't select Customer Audience without CustomFeed/Branding");
						allOK = false;
					}
				}

				if (allOK) {
					let datahave = false;


					for (let item in all_campaign_list) {
						let checkname = all_campaign_list[item].name;
						// let checkprefix = all_campaign_list[item].prefix;
						// let checkobjectives = all_campaign_list[item].objectives;
						// let checkaudience = all_campaign_list[item].audience;
						// let checkadformats = all_campaign_list[item].adformats;
						// let checkaged = all_campaign_list[item].aged;
						// let checkinventory = all_campaign_list[item].inventory;
						// let checkpostfix = all_campaign_list[item].postfix;


						// if (prefix == checkprefix && objectives == checkobjectives && audience == checkaudience && adformats == checkadformats
						// 	&& audience == checkaudience && aged == checkaged && inventory == checkinventory && postfix == checkpostfix) {
						// 	datahave = true;
						// }

						if (name == checkname) {
							datahave = true;
						}
					}
					// console.log(all_campaign_list);
					console.log("all ok");
					// console.log(fbObjective);
					// console.log(special_ad_category);
					// console.log(budgetType);
					// console.log(budgetAmount);
					// console.log(bid_strategy);

					if (datahave) {
						alert('This combination already create.');
					} else {

						let successMessage = document.getElementById("successMessage");
						// const length = all_campaign_list.length + 1;
						const length = 1;

						var table = document.getElementById("view-data");
						var row = table.insertRow(length);
						var cell1 = row.insertCell(0);
						cell1.innerHTML = name;

						$.ajax({
							type: 'post',
							url: 'facebook-campaign-save.php',
							data: 'accid=' + fbAccountId + '&dealer=' + dealer + '&prefix=' + prefix + '&objectives=' + objectives + '&audience=' + audience +
								'&adformats=' + adformats + '&aged=' + aged + '&inventory=' + inventory +
								'&postfix=' + postfix + '&name=' + name + '&utmprefix=' + utmprefix + '&customfeed=' + customfeed + '&utmpostfix=' + utmpostfix +
								'&fbObjective=' + fbObjective + '&special_ad_category=' + special_ad_category + '&budgetType=' + budgetType +
								'&budgetAmount=' + budgetAmount + '&bid_strategy=' + bid_strategy,
							success: function () {
								successMessage.style.display = "block";
								document.getElementById("fb-campaign").reset();
								// alert('Campaign Save Successfully.');
								location.reload();
							}
						});
					}


				} else {
					console.log("all not ok")
				}


			});

		});

		$(document).on("click", ".open-pause", function () {
			let pause_camp_id = $(this).data('id');
			let name = $(this).data('type');
			let text = `Do you want to PAUSED the campaign named <br><b>${name}</b> ?`;

			$('#pause_camp_id').html(pause_camp_id);
			$('#pause_text').html(text);
			document.getElementById("pause_camp_id").value = pause_camp_id;
		});

		$(document).on("click", ".open-active", function () {
			let active_camp_id = $(this).data('id');
			let name = $(this).data('type');
			let text = `Do you want to ACTIVE the campaign named <br><b>${name}</b> ?`;

			$('#active_camp_id').html(active_camp_id);
			$('#active_text').html(text);
			document.getElementById("active_camp_id").value = active_camp_id;
		});

		$(document).on("click", ".open-edit", function () {
			let active_camp_index = $(this).data('id');
			let edit_campaign = all_campaign_list[active_camp_index];
			// console.log(edit_campaign);

			document.getElementById("campId").value = edit_campaign['id'];
			document.getElementById("campName").value = edit_campaign['name'];
			document.getElementById("campObjective").value = edit_campaign['objective'];
			document.getElementById("campSpecialAdCategory").value = edit_campaign['special_ad_categories'];


			// var special_ad_categoriesValue = edit_campaign['special_ad_categories']
			// $('#campSpecialAdCategory').val(special_ad_categoriesValue);

			var campStatusValue = edit_campaign['status']
			$('#campStatus').val(campStatusValue);

			if("lifetime_budget" in edit_campaign){
				var campBudgetType = "Life Time Budget";
					$('#campBudgetType').html(campBudgetType);

				document.getElementById("campBudgetTypeKey").value = "lifetime_budget";
				document.getElementById("campBudget").value = edit_campaign['lifetime_budget']/100;
			} else if("daily_budget" in edit_campaign){
				var campBudgetType = "Daily Budget";
				$('#campBudgetType').html(campBudgetType);
				document.getElementById("campBudgetTypeKey").value = "daily_budget";
				document.getElementById("campBudget").value = edit_campaign['daily_budget']/100;
			}

			var campBidStrategyValue = edit_campaign['bid_strategy']
			$('#campBidStrategy').val(campBidStrategyValue);

		});

	</script>
