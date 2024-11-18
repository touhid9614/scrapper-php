<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

use Predis\Client as RedisClient;

global $CronConfigs, $scrapper_configs, $connection, $redis, $redis_config;

$db_connect  = new DbConnect($cron_name);
$cron_names  = $db_connect->getGroupNames();

$status      = filter_input(INPUT_GET, 'status');
$client_type = filter_input(INPUT_GET, 'client_type');

if (!$status) {
	$status = 'all';
}

// Subscription Type
$subscription_type = filter_input(INPUT_GET, 'subscription_type');
$inventory         = filter_input(INPUT_GET, 'inventory');

// Happiness
$happiness_operator = filter_input(INPUT_GET, 'happiness_operator');
$happiness          = filter_input(INPUT_GET, 'happiness');

// Dealership Type
$dealership_type = filter_input(INPUT_GET, 'dealership_type');
$country_name    = filter_input(INPUT_GET, 'country_name');
$state           = filter_input(INPUT_GET, 'state');

$subscriptions = [];
$brands        = [];
$oems          = [];

if (!$happiness) {
	$happiness = 0;
}

$export = filter_input(INPUT_GET, 'export', FILTER_VALIDATE_BOOLEAN);
$where  = "1";

if ($happiness_operator) {
	$where = '';
}

if ($status && $status != 'all') {
	$where = "status = '" . $db_connect->real_escape_string_read($status) . "'";
}

if ($client_type) {
	if ($where) {
		$where .= " AND ";
	}

	$where .= "saler_type = '" . $db_connect->real_escape_string_read($client_type) . "'";
}

if ($happiness_operator) {
	if ($where) {
		$where .= " AND ";
	}

	if ($happiness_operator == 'better') {
		$where .= 'happiness >=' . $db_connect->real_escape_string_read($happiness);
	} else {
		$where .= 'happiness <=' . $db_connect->real_escape_string_read($happiness);
	}
}

$user_email = $user['id'];

if (!empty($dealership_type)) {
	$where .= empty($where) ? 'assigned_to =' . "'$dealership_type'" : ' AND assigned_to =' . "'$dealership_type'";
}

if (!empty($country_name)) {
	$where .= empty($where) ? 'country_name =' . "'$country_name'" : ' AND country_name =' . "'$country_name'";
}

if (!empty($state)) {
	$where .= empty($where) ? 'state =' . "'$state'" : ' AND state =' . "'$state'";
}

$state_result_query = "SELECT DISTINCT(state) AS state FROM dealerships WHERE CHAR_LENGTH(state) > 0;";
$state_result       = $db_connect->query($state_result_query);
$state_data         = [];

while ($row = mysqli_fetch_assoc($state_result)) {
	$state_data[] = $row['state'];
}

$all_dealers = $db_connect->get_all_dealers($where);
$admin_fetch = $db_connect->query("SELECT name, email, role, designation, thumbnail_url FROM users WHERE user_type = 'a' AND account_disabled = 0;");

while ($row = mysqli_fetch_assoc($admin_fetch)) {
	$db_admins[$row['email']] = [
		'name'          => $row['name'],
		'role'          => $row['role'],
		'designation'   => $row['designation'],
		'thumbnail_url' => $row['thumbnail_url']
	];
}

// Manual Filters
if ($subscription_type) {
	$vars          = filter_input_array(INPUT_GET);
	$subscriptions = isset($vars['subscriptions']) ? $vars['subscriptions'] : [];
	$brands        = isset($vars['brands']) ? json_decode($vars['brands']) : [];
	$oems          = isset($vars['oems']) ? $vars['oems'] : [];
	$dealers       = [];

	foreach ($all_dealers as $d_name => $dealer) {
		$pass = true;

		if (count($brands) > 0 && count(array_intersect(array_map('strtolower', $brands), array_map('strtolower', $dealer['brands']))) == 0) {
			$pass = false;
		}

		if (count($oems) > 0 && count(array_intersect($oems, $dealer['oem'])) == 0) {
			$pass = false;
		}

		if ($subscription_type == 'subscriber') {
			foreach ($subscriptions as $subscription) {
				if (!in_array($subscription, $dealer['campaign_types'])) {
					$pass = false;
				}
			}
		} else {
			foreach ($subscriptions as $subscription) {
				if (in_array($subscription, $dealer['campaign_types'])) {
					$pass = false;
				}
			}
		}

		if ($inventory && !in_array($inventory, $dealer['inventories'])) {
			$pass = false;
		}

		if ($pass) {
			$dealers[$d_name] = $dealer;
		}
	}

	$cron_names = array_keys($dealers);
} else {
	$dealers = [];

	foreach ($all_dealers as $d_name => $dealer) {
		$dealers[$d_name] = $dealer;
	}

	$cron_names = array_keys($dealers);
}

$all_brands = $db_connect->get_meta('general_config', 'brands');
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

if ($export) {
	function csv_export($data)
	{
		array_walk($data, function (&$value, $index) {
			if (stripos($value, ',') !== false) {
				$value = "\"$value\"";
			}
		});

		echo implode(",", $data) . "\n";
	}

	// Start export here
	header('Content-Description: File Transfer');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename=dealers.csv');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	$header = [
		'Company Name',
		'Group',
		'Phone',
		'Website',
		'Company Rep Name',
		'Company Rep Phone',
		'Company Rep Email',
		'Website Rep Name',
		'Website Rep Phone',
		'Website Rep Email',
		'Campaigns',
		'Last Contacted',
		'Happiness',
		'Tag Installed',
		'View Content Working',
		'Address',
		'City',
		'State',
		'Postal Code',
		'Country',
		'Status',
		'Start date',
		'End date',
		'Account representative'
	];

	csv_export($header);

	foreach ($cron_names as $cron_name) {
		$cron_config     = $CronConfigs[$cron_name];
		$tag_state_key   = 'tag_state_' . $cron_name . '_any';
		$tag_last_loaded = (int)($redis->get($tag_state_key));
		$tag_loaded      = null;
		$tag_text        = 'Not Installed';

		if ($tag_last_loaded) {
			$tag_loaded = time() - $tag_last_loaded;

			if ($tag_loaded < 24 * 3600 && $tag_loaded > 6 * 3600) {
				$tag_text = 'Warning';
			} else if ($tag_loaded <= 6 * 3600) {
				$tag_text = 'Installed';
			}
		}

		$tag_state_viewcontent_key = 'tag_state_' . $cron_name . '_vc';
		$vc_last_loaded = (int)($redis->get($tag_state_viewcontent_key));

		$vc_loaded = null;
		$vc_text   = 'Not Working';

		if ($vc_last_loaded) {
			$vc_loaded = time() - $vc_last_loaded;

			if ($vc_loaded < 24 * 3600 && $vc_loaded > 6 * 3600) {
				$vc_text = 'Warning';
			} else if ($vc_loaded <= 6 * 3600) {
				$vc_text = 'Working';
			}
		}

		$dealership = isset($dealers[$cron_name]) ? $dealers[$cron_name] : $default_dealership;

		csv_export([
			$dealership['company_name'],
			$dealership['group_name'],
			$dealership['phone'],
			$dealership['websites'],
			count($dealership['company_rep']) ? $dealership['company_rep']['name'] : '',
			count($dealership['company_rep']) ? $dealership['company_rep']['phone'] : '',
			count($dealership['company_rep']) ? $dealership['company_rep']['email'] : '',
			count($dealership['website_rep']) ? $dealership['website_rep']['name'] : '',
			count($dealership['website_rep']) ? $dealership['website_rep']['phone'] : '',
			count($dealership['website_rep']) ? $dealership['website_rep']['email'] : '',
			implode(", ", $dealership['campaign_types']),
			$dealership['last_contacted'] ? date('m/d/Y', $dealership['last_contacted']) : "",
			$dealership['happiness'],
			$tag_text,
			$vc_text,
			$dealership['address'],
			$dealership['city'],
			$dealership['state'],
			$dealership['post_code'],
			$dealership['country_name'],
			$dealership['status'],
			$dealership['start_date'] ? date('Y-m-d', $dealership['start_date']) : "",
			$dealership['end_date'] ? date('Y-m-d', $dealership['end_date']) : "",
			isset($admins[$dealership['assigned_to']]) ? $admins[$dealership['assigned_to']]['name'] : ''
		]);
	}

	exit();
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'crm-overview';
	include 'bolts/sidebar.php';
	?>

	<section role="main" class="content-body">
		<header class="page-header">
		</header>

		<div class="row">
			<form id="filter-form" method="GET" class="form-horizontal form-bordered">
				<div class="col-lg-12">
					<section class="panel panel-info panel-collapsed">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
							</div>
							<h2 class="panel-title">Filters</h2>
						</header>

						<div class="panel-body">
							<div class="row mb-md">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label">Customers</label>
										<div class="col-sm-8">
											<select class="form-control" name="status" data-plugin-multiselect data-plugin-options='{ "maxHeight": 300 }'>
												<option value="all" <?= $status == 'all' ? 'selected' : '' ?>>All</option>
												<option value="active" <?= $status == 'active' ? 'selected' : '' ?>>Active</option>
												<option value="trial" <?= $status == 'trial' ? 'selected' : '' ?>>Trial</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label">Inventory</label>
										<div class="col-sm-8">
											<select class="form-control" name="inventory" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
												<option value="" <?= !$inventory ? 'selected' : '' ?>>Any</option>
												<option value="new" <?= $inventory == 'new' ? 'selected' : '' ?>>New</option>
												<option value="used" <?= $inventory == 'used' ? 'selected' : '' ?>>Used</option>
												<option value="-" <?= $inventory == '-' ? 'selected' : '' ?>>None</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row mb-md">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label">Services</label>

										<div class="col-sm-8">
											<select class="form-control" name="subscription_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
												<option value="subscriber" <?= $subscription_type == 'subscriber' ? 'selected' : '' ?>>Subscribe</option>
												<option value="not-subscribers" <?= $subscription_type == 'not-subscribers' ? 'selected' : '' ?>>Don't Subscribe</option>
											</select>

											<div class="row">
												<div class="col-md-6 col-sm-12">
													<div class="checkbox-custom chekbox-primary mt-sm">
														<input id="smedia-inventory" value="sMedia Inventory" type="checkbox" name="subscriptions[]" <?= in_array('sMedia Inventory', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="smedia-inventory">sMedia Inventory</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="generic-adwords-campaign" value="Generic Adwords Campaign" type="checkbox" name="subscriptions[]" <?= in_array('Generic Adwords Campaign', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="generic-adwords-campaign">Generic Adwords Campaign</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="youtube-campaign" value="YouTube Campaign" type="checkbox" name="subscriptions[]" <?= in_array('YouTube Campaign', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="youtube-campaign">YouTube Campaign</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="clean-click" value="Clean Click" type="checkbox" name="subscriptions[]" <?= in_array('Clean Click', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="clean-click">Clean Click</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="ai-buttons" value="AI Buttons" type="checkbox" name="subscriptions[]" <?= in_array('AI Buttons', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="ai-buttons">AI Buttons</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="ai-buttons-trial" value="AI Buttons Trial" type="checkbox" name="subscriptions[]" <?= in_array('AI Buttons Trial', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="ai-buttons">AI Buttons Trial</label>
													</div>
												</div>

												<div class="col-md-6 col-sm-12">
													<div class="checkbox-custom chekbox-primary">
														<input id="dynamic-social-retargetting" value="Dynamic Social Retargeting" type="checkbox" name="subscriptions[]" <?= in_array('Dynamic Social Retargeting', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="dynamic-social-retargetting">Dynamic Social Retargeting</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="social-lead-ads" value="Social Lead Ads" type="checkbox" name="subscriptions[]" <?= in_array('Social Lead Ads', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="social-lead-ads">Social Lead Ads</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="generic-social-ads" value="Generic Social Ads" type="checkbox" name="subscriptions[]" <?= in_array('Generic Social Ads', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="generic-social-ads">Generic Social Ads</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="smart-offer" value="Smart Offer" type="checkbox" name="subscriptions[]" <?= in_array('Smart Offer', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="smart-offer">Smart Offer</label>
													</div>

													<div class="checkbox-custom chekbox-primary">
														<input id="custom" value="Custom" type="checkbox" name="subscriptions[]" <?= in_array('Custom', $subscriptions) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
														<label for="custom">Custom</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-md-4 control-label">Client Type</label>
										<div class="col-md-8">
											<select class="form-control" name="client_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
												<option value="" <?= !$client_type ? 'selected=""' : '' ?>>Any</option>
												<option value="Dealership" <?= $client_type == 'Dealership' ? 'selected=""' : '' ?>>Dealership</option>
												<option value="Local" <?= $client_type == 'Local' ? 'selected=""' : '' ?>>Local</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-4 control-label">Happiness
											<p><i id="emo-container" class="emo " style="font-size: 48px; margin-top:10px;"></i></p>
										</label>

										<div class="col-sm-8">
											<div class="mb-sm">
												<select class="form-control" name="happiness_operator" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
													<option value="better" <?= $happiness_operator == 'better' ? 'selected' : '' ?>>Better</option>
													<option value="worse" <?= $happiness_operator == 'worse' ? 'selected' : '' ?>>Worse</option>
												</select>
												<span class="ml-sm">than</span>
											</div>
											<div>
												<div class="mt-lg mb-lg slider-primary" data-plugin-slider data-plugin-options='{ "value": <?= "$happiness" ?>, "range": "min", "max": 100 }' data-plugin-slider-output="#happiness">
													<input id="happiness" name="happiness" class="happiness-value" data-emo="#emo-container" type="hidden" value="<?= "$happiness" ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row mb-md">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label">Brands</label>
										<div class="col-sm-8">
											<textarea id="brands" name="brands" rows="1"></textarea>
											<script type="text/javascript">
												$(document).ready(function() {
													$('#brands').textext({
														plugins: 'autocomplete suggestions tags filter',
														suggestions: <?= json_encode($all_brands); ?>
													});
													$('#brands').bind('setFormData', function(e, data, isEmpty) {
														$('.text-wrap, #brands').css('width', '100%');
													});
													$('#brands').textext()[0].tags().addTags(<?= count($brands) ? json_encode($brands) : '[]'; ?>);
													$('.text-wrap, #brands').css('width', '100%');
												});
											</script>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label">OEM</label>
										<div class="col-sm-8">
											<?php
											foreach ($all_oems as $oem) {
											?>
												<div class="checkbox-custom chekbox-primary">
													<input id="oem-<?= preg_replace('/\s*\n*/', '-', trim(strtolower($oem))) ?>" value="<?= $oem ?>" type="checkbox" name="oems[]" <?= in_array($oem, $oems) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
													<label for="oem-<?= preg_replace('/\s*\n*/', '-', trim(strtolower($oem))) ?>"><?= $oem ?></label>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>


							<div class="row mb-md">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label">Assign To</label>

										<div class="col-sm-8">
											<select class="form-control" name="dealership_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
												<option value="" <?= !$dealership_type ? 'selected' : '' ?>>Any One</option>
												<?php
												foreach ($db_admins as $email => $admin) {
												?>
													<option value="<?= $email ?>" <?= $email == $dealership_type ? 'selected=""' : '' ?>>
														<?php
														if ($user_email == $email) {
															echo $admin['name'] . ' (MySelf)';
														} else {
															echo $admin['name'];
														}
														?>
													</option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-3 col-sm-6">
									<div class="form-group">
										<label class="col-sm-4 control-label">Country</label>
										<div class="col-sm-8">
											<select class="form-control" name="country_name">
												<option value=""> -Select Country- </option>
												<option value="USA" <?= $country_name == 'USA' ? 'selected=""' : '' ?>>USA</option>
												<option value="Canada" <?= $country_name == 'Canada' ? 'selected=""' : '' ?>>Canada</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-3 col-sm-6">
									<div class="form-group">
										<label class="col-sm-4 control-label">State</label>
										<div class="col-sm-8">
											<select class="form-control" name="state">
												<option value=""> -Select State- </option>
												<?php
												foreach ($state_data as $key => $val) {
												?>
													<option value='<?= $val ?>' <?= ($state == $val) ? 'selected' : '' ?>> <?= $val ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row mb-md">
								<div class="col-md-6 col-sm-12"> </div>
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label class="col-sm-4 control-label"></label>
										<div class="col-sm-8 clearfix">
											<button id="btn-filter" type="submit" class="btn btn-info mr-xs pull-right ml-xs">Apply Filter</button>
											<a href="overview.php" class="btn btn-default pull-right">Clear</a>
										</div>
									</div>
								</div>
							</div>
					</section>
				</div>

				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							<div class="panel-actions">

							</div>
							<h2 class="panel-title">Dealership Overview</h2>
						</header>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<table class="table table-bordered table-striped mb-none" id="datatable-default">
										<thead>
											<tr>
												<th class="export">Company Name</th>
												<th class="export">Dealership</th>
												<th class="export">Group Name</th>
												<th class="export">Website URL</th>
												<th class="export">Country</th>
												<th class="no-sort export">Reps</th>
												<th class="export">Start Date</th>
												<th class="export">Tag</th>
												<th class="export">VC</th>
												<th class="export">Ac Rep.</th>
												<th class="no-sort"> Engaged User </th>
											</tr>
										</thead>

										<tbody>
											<?php
											foreach ($cron_names as $cron_name) {
												$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

												$dealership = isset($dealers[$cron_name]) ? $dealers[$cron_name] : [
													'dealership'     => $cron_name,
													'company_name'   => $cron_name,
													'group_name'     => '',
													'phone'          => '',
													'websites'       => '',
													'country'        => '',
													'website_rep'    => [],
													'company_rep'    => [],
													'campaign_types' => [],
													'start_date'     => 0,
													'end_date'       => 0,
													'last_contacted' => 0,
													'happiness'      => 76,
													'status'         => 'active',
												];

												$tag_state_key   = 'tag_state_' . $cron_name . '_any';
												$tag_last_loaded = (int)($redis->get($tag_state_key));
												$tag_loaded     = null;
												$tag_text       = '<span class="text-danger">Not Installed</span>';

												if ($tag_last_loaded) {
													$tag_loaded = time() - $tag_last_loaded;

													if ($tag_loaded < 24 * 3600 && $tag_loaded > 6 * 3600) {
														$tag_text = '<span class="text-warning">Warning</span>';
													} else if ($tag_loaded <= 6 * 3600) {
														$tag_text = '<span class="text-success">Installed</span>';
													}
												}

												$tag_state_viewcontent_key = 'tag_state_' . $cron_name . '_vc';
												$vc_last_loaded = (int)($redis->get($tag_state_viewcontent_key));
												$vc_loaded = null;
												$vc_text   = '<span class="text-danger">Not Working</span>';

												if ($vc_last_loaded) {
													$vc_loaded = time() - $vc_last_loaded;
													if ($vc_loaded < 24 * 3600 && $vc_loaded > 6 * 3600) {
														$vc_text = '<span class="text-warning">Warning</span>';
													} else if ($vc_loaded <= 6 * 3600) {
														$vc_text = '<span class="text-success">Working</span>';
													}
												}

												$rep_text = '';

												if (count($dealership['company_rep']) && ($dealership['company_rep']['name'] || $dealership['company_rep']['email'] || $dealership['company_rep']['phone'])) {
													$rep_text .= '<b>Company Rep</b><br/>';
													if ($dealership['company_rep']['name']) {
														$rep_text .= "Name: {$dealership['company_rep']['name']}<br>";
													}
													if ($dealership['company_rep']['phone']) {
														$rep_text .= "Phone: {$dealership['company_rep']['phone']}<br>";
													}
													if ($dealership['company_rep']['email']) {
														$rep_text .= "Email: <i>{$dealership['company_rep']['email']}</i><br>";
													}
												}

												if (count($dealership['website_rep']) && ($dealership['website_rep']['name'] || $dealership['website_rep']['email'] || $dealership['website_rep']['phone'])) {
													if ($rep_text) {
														$rep_text .= '<br/>';
													}

													$rep_text .= '<b>Website Rep</b><br>';

													if ($dealership['website_rep']['name']) {
														$rep_text .= "Name: {$dealership['website_rep']['name']}<br>";
													}

													if ($dealership['website_rep']['phone']) {
														$rep_text .= "Phone: {$dealership['website_rep']['phone']}<br>";
													}

													if ($dealership['website_rep']['email']) {
														$rep_text .= "Email: <i> {$dealership['website_rep']['email']} </i> <br>";
													}
												}
											?>
												<tr>
													<td>
														<a href="details.php?dealership=<?= $cron_name ?>" target="_blank">
															<?= $dealership['company_name'] ?>
														</a>
													</td>
													<td><?= $dealership['dealership'] ?></td>
													<td>
														<a href="dealer-groups.php?group_name=<?= $dealership['group_name'] ?>" target="_blank">
															<?= $dealership['group_name'] ?>
														</a>
													</td>
													<?php
													if (!empty($dealership['websites'])) {
														if (preg_match("/http\b/i", $dealership['websites'], $match) || preg_match("/https\b/i", $dealership['websites'], $match)) {
															echo '<td><a href="' . $dealership['websites'] . '" target="_blank"><i>' . $dealership['websites'] . '</i></a></td>';
														} else {
															echo '<td><a href="http://' . $dealership['websites'] . '" target="_blank"><i>http://' . $dealership['websites'] . '</i></a></td>';
														}
													} else {
														echo '<td><i>N/A</i></td>';
													}

													?>
													<td><?= $dealership['country_name'] ?></td>
													<td><?= $rep_text ?></td>
													<td><?= $dealership['start_date'] ? date('Y-m-d', $dealership['start_date']) : "" ?></td>
													<td><?= $tag_text ?></td>
													<td><?= $vc_text ?></td>
													<td><?= isset($admins[$dealership['assigned_to']]) ? $admins[$dealership['assigned_to']]['name'] : '' ?></td>
													<td>
														<a target="_blank" href="engaged-user.php?dealership=<?= $cron_name ?>">
															<i class="fas fa-external-link-alt"></i>
														</a>
													</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</section>
				</div>
			</form>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';