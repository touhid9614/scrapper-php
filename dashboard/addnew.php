<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $nlp_api, $default_tag_config;

require_once 'tracking-config/defeault_tag_config.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;

add_script('addnew', 'app/js/addnew.js');

$db_connect          = new DbConnect('');
$dealer_groups       = [];
$fetch_dealer_groups = $db_connect->query("SELECT DISTINCT(group_name) FROM dealerships WHERE group_name != '' AND group_name IS NOT NULL ORDER BY group_name ASC");
$admins              = $db_connect->getAdmins();

while ($row = mysqli_fetch_assoc($fetch_dealer_groups)) {
	$dealer_groups[] = $row['group_name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$company_name = trim(filter_input(INPUT_POST, 'company_name'));
	$domain_name  = trim(filter_input(INPUT_POST, 'domain_name'));
	$domain_part  = parse_url($domain_name);
	$hostpart     = isset($domain_part['host']) ? $domain_part['host']    : $domain_part['path'];
	$scheme       = isset($domain_part['scheme']) ? $domain_part['scheme'] : 'https';
	$hostarr      = explode('.', $hostpart);
	$hostname     = "";
    $custom_cron  = trim(filter_input(INPUT_POST, 'custom_cron_name'));

	$scrapper_type = trim(filter_input(INPUT_POST, 'scrapper_type'));

	if (!$scrapper_type || $scrapper_type == "") {
		$scrapper_type = "RegEx";
	}

	for ($i = 0, $hostLen = count($hostarr); $i < $hostLen; $i++) {
		if ($hostarr[$i] == 'www') {
			continue;
		}

		$hostname .= $hostarr[$i];
	}

	$hostname = strtolower(str_replace('-', '_', $hostname));
	$date     = date('Y-m-d H: i: s');

    if (!empty($custom_cron)) {
        $hostname = $custom_cron;
    }

	//  s3 bucket create
	$bucket_name = "smedia-config";
	$s3_config   = ["region" => "us-east-1", 'version' => '2006-03-01'];
	$s3_client   = new S3Client($s3_config);

	$all_config_file      = dirname(__DIR__) . '/adwords3/caches/configs.php';
	$target_file          = "config/{$hostname}.php";
	$scrapper_target_file = "scrapper-config/{$hostname}.php";

	$temp_file          = tempnam(sys_get_temp_dir(), 'config-file');
	$scrapper_temp_file = tempnam(sys_get_temp_dir(), 'scrapper-config-file');

	try {
		$result = $s3_client->doesObjectExist($bucket_name, $target_file);

		if (!$result) {
			$config_file_content = '<?php' . "\n" . 'global $CronConfigs;' . "\n"
				. '$CronConfigs["' . $hostname . '"] = array( ' . "\n"
				. "\t" . '"name"  => "' . $hostname . '",' . "\n"
				. "\t" . '"email" => "regan@smedia.ca",' . "\n"
				. "\t" . '"password" => "' . $hostname . '",' . "\n"
				. "\t" . '"no_adv" => true,' . "\n"
				. "\t" . '"log" => false,' . "\n"
				. "\t" . '"combined_feed_mode" => true,' . "\n"
				. ');';

			$cleaned_code = trim(str_replace(
				'global $scrapper_configs;', '', str_replace(
					'global $CronConfigs;', '', str_replace(
						'?>', '', str_replace('<?php', '', $config_file_content)
					)
				)
			));

			file_put_contents($all_config_file, $cleaned_code . "\n\n", FILE_APPEND);
			file_put_contents($temp_file, $config_file_content . "\n\n", FILE_APPEND);

			$uploader = new MultipartUploader($s3_client, $temp_file, [
				'bucket' => $bucket_name,
				'key' => $target_file
			]);

			try {
				$result = $uploader->upload();
			} catch (MultipartUploadException $e) {
				$message = "Can't Create File ........" . $e->getMessage();
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
	} catch (S3Exception $e) {
		$message = "S3 Setting error ........" . $e->getMessage();
		echo "<script type='text/javascript'>alert('$message');</script>";
	}

	try {
		$result = $s3_client->doesObjectExist($bucket_name, $scrapper_target_file);

		if (!$result) {
			$sconfig_file_content = '<?php' . "\n"
				. 'global $scrapper_configs;' . "\n"
				. '$scrapper_configs["' . $hostname . '"] = array( ' . "\n"
				. "\t" . '"entry_points" => [],' . "\n"
				. "\t" . '"no_scrap" => true' . "\n"
				. ');';

			if ($scrapper_type == "NLP") {
				$api_end_part = "vehicles/{$hostpart}/";
				$entry = $nlp_api . "vehicles/{$hostpart}/";

				$sconfig_file_content = '<?php' . "\n"
					. 'global $scrapper_configs, $nlp_api;' . "\n"
					. '$scrapper_configs["' . $hostname . '"] = array( ' . "\n"
					. "\t" . '"entry_points" => array(' . "\n"
					. "\t\t" . '"new" => $nlp_api"' . $api_end_part . '",' . "\n"
					. "\t" . '),' . "\n"
					. "\t" . '"use-proxy" => true,' . "\n"
					. "\t" . '"content-type" => "application/json",' . "\n"
					. "\t" . '"custom_data_capture" => function ($url, $data) {' . "\n"
					. "\t\t" . 'return nlp_crawler($url, $data, true);' . "\n"
					. "\t" . '}' . "\n"
					. ');';
			}

			$cleaned_code = trim(str_replace(
				'global $scrapper_configs, $nlp_api;',
				'',
				str_replace(
					'global $scrapper_configs;',
					'',
					str_replace(
						'global $CronConfigs;',
						'',
						str_replace(
							'?>',
							'',
							str_replace('<?php', '', $sconfig_file_content)
						)
					)
				)
			));

			file_put_contents($all_config_file, $cleaned_code . "\n\n", FILE_APPEND);
			file_put_contents($scrapper_temp_file, $sconfig_file_content . "\n\n", FILE_APPEND);

			$uploader = new MultipartUploader($s3_client, $scrapper_temp_file, [
				'bucket' => $bucket_name,
				'key' => $scrapper_target_file
			]);

			try {
				$result = $uploader->upload();
			} catch (MultipartUploadException $e) {
				$message = "Can't Create File ........" . $e->getMessage();
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
	} catch (S3Exception $e) {
		$message = "S3 Setting error ........" . $e->getMessage();
		echo "<script type='text/javascript'>alert('$message');</script>";
	}

	$check_dealer = $db_connect->query("SELECT id FROM dealerships WHERE dealership = '$hostname'");

	if (!mysqli_num_rows($check_dealer)) {
		$group = trim(filter_input(INPUT_POST, 'group_name'));
		$company_rep_email = trim(filter_input(INPUT_POST, 'company_rep_email', FILTER_VALIDATE_EMAIL));

		$dealership_data = [
			'dealership'   => $hostname,
			'company_name' => $company_name,
			'websites'     => $domain_name,
			'status'       => 'trial',
			'start_date'   => strtotime(filter_input(INPUT_POST, 'start_date')),
			'end_date'     => strtotime(filter_input(INPUT_POST, 'end_date')),

			'company_rep' => [
				'name'  => trim(filter_input(INPUT_POST, 'company_rep_name')),
				'email' => $company_rep_email,
				'phone' => filter_input(INPUT_POST, 'company_rep_phone')
			],

			'assigned_to'  => filter_input(INPUT_POST, 'assigned_to'),
			'address'      => trim(filter_input(INPUT_POST, 'address')),
			'city'         => trim(filter_input(INPUT_POST, 'city')),
			'state'        => trim(filter_input(INPUT_POST, 'state')),
			'post_code'    => filter_input(INPUT_POST, 'post_code'),
			'country_name' => filter_input(INPUT_POST, 'country_name'),

			'website_rep' => [
				'name'  => trim(filter_input(INPUT_POST, 'website_rep_name')),
				'email' => trim(filter_input(INPUT_POST, 'website_rep_email', FILTER_VALIDATE_EMAIL)),
				'phone' => filter_input(INPUT_POST, 'website_rep_phone')
			],

			'saler_type'   => filter_input(INPUT_POST, 'saler_type'),
			'group_name'   => $group,
			'scrapper_type' => $scrapper_type,
			'crm'          => filter_input(INPUT_POST, 'crm')
		];

		$pwd = randomString(10, true);

		$user_data = [
			'name'         => $hostname,
			'email'        => $company_rep_email,
			'role'         => filter_input(INPUT_POST, 'saler_type'),
			'user_type'    => isset($group) ? 'g' : 'u',
			'dealer_group' => $group,
			'dealership'   => $hostname,
			'designation'  => 'Dealer Group',
			'pass_hash'    => password_hash($pwd, PASSWORD_DEFAULT),
			'website'      => $domain_name,
			'phone_number' => filter_input(INPUT_POST, 'company_rep_phone')
		];

		$query_prep = $db_connect->prepare_query_params($dealership_data, DbConnect::PREPARE_PARENTHESES);
		$db_connect->query("INSERT INTO dealerships $query_prep");
		$db_connect->update_meta('dealer_domain', GetDomain($domain_name), $hostname);
		$user_prep = $db_connect->prepare_query_params($user_data, DbConnect::PREPARE_PARENTHESES);
		$db_connect->query("INSERT INTO users $user_prep");

		// Add default tag config
		$db_connect->update_meta('tag_configs', "{$hostname}_tag_configs", $default_tag_config);

		DbConnect::store_log($user_id, $user['type'], 'Add New Dealership', 'Add Dealership where Dealership Name- ' . $hostname . ' and company Name- ' . $company_name . ' and website- ' . $domain_name, $hostname);
		$db_connect2 = new DbConnect($hostname);
		$db_connect2->VarifyTables();
		$db_connect->close_connection();

		/* SEND A WELCOME EMAIL TO CLIENT */
		$from    = 'sMedia Support <support@smedia.ca>';
		$subject = 'Welcome To sMedia';
		$message = file_get_contents('./mail_template/welcome_email.html');
		$message = str_replace('Dealer#123', $pwd, $message);
		// SendEmail($company_rep_email, $from, $subject, $message);

		/* Handle NLP */
		if ($scrapper_type == 'NLP') {
			$nlp_add_api = $nlp_api . "domains/add/";

			$postData = [
				"id"       => null,
				"hostname" => $hostpart,
				"scheme"   => $scheme,
				"status"   => "",
				"enabled"  => true
			];

			$out_cookies  		= '';
			$in_cookies   		= '';
			$content_type 		= 'application/json';
			$additional_headers = [];

			$res = HttpPost($nlp_add_api, json_encode($postData), $in_cookies, $out_cookies, false, false, $content_type, $additional_headers);

			if (!$res) {
				// show error
			}
		}
	}

	header('location: details.php?dealership=' . $hostname);
}

include 'bolts/header.php';
?>
<div class="inner-wrapper">

	<?php
	$select = 'crm-addnew';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2 class="panel-title"> Register New Dealership </h2>
		</header>

		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="row">
						<div class="col-xs-12">
							<section class="panel form-wizard" id="w4">
								<header class="panel-heading">
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>

									<h2 class="panel-title"> Dealership Information </h2>
								</header>

								<form method="POST" class="form-horizontal form-bordered" novalidate="novalidate">
									<div class="panel-body">
										<div class="wizard-progress wizard-progress-lg">
											<div class="steps-progress">
												<div class="progress-indicator"></div>
											</div>
											<ul class="wizard-steps">
												<li class="active">
													<a href="#w4-account" data-toggle="tab">
                                                        <span> 1 </span> Dealership
                                                    </a>
												</li>

												<li>
													<a href="#w4-profile" data-toggle="tab">
                                                        <span> 2 </span> Company Info
                                                    </a>
												</li>

												<li>
													<a href="#w4-billing" data-toggle="tab">
                                                        <span> 3 </span> Billing Info
                                                    </a>
												</li>

												<li>
													<a href="#w4-confirm" data-toggle="tab">
                                                        <span> 4 </span> Submit
													</a>
												</li>
											</ul>
										</div>

										<div class="tab-content">
											<div id="w4-account" class="tab-pane active">
												<div class="row form-group-row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label"> Company Name </label>
															<div class="col-sm-9">
																<input name="company_name" class="form-control" type="text" value="" placeholder="Name of the Company" data-current_value='' required="" />
															</div>
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label"> Domain URL </label>
															<div class="col-sm-9">
																<input type="hidden" name="hostname" id="hostname" value="">
																<input name="domain_name" id="domain_name" class="form-control italic-placeholder" type="text" value="" placeholder="https://www.sMedia.ca/" data-current_value='' required="" />
															</div>
														</div>
													</div>
												</div>

                                                <div class="row form-group-row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label"> Is Custom Dealership? </label>

                                                            <div class="col-sm-9">
                                                                <select onchange="customDealerShowHide(this)" id="showCustomDealer" class="form-control" name="is_custom_dealer" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                                                                    <option value="NO">No</option>
                                                                    <option value="YES">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group hideMe" id="hidden_custom_dealer">
                                                            <label class="col-sm-3 control-label"> Custom Cron Name </label>
                                                            <div class="col-sm-9">
                                                                <input name="custom_cron_name" class="form-control" type="text" value="" placeholder="Custom cron name" data-current_value=''/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
											</div>

											<div id="w4-profile" class="tab-pane">
												<div class="row form-group-row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label"> Start Date </label>
															<div class="col-md-9">
																<div class="input-group">
																	<span class="input-group-addon">
																		<i class="fa fa-calendar"></i>
																	</span>
																	<input type="date" class="form-control" name="start_date" required="" value="<?= date("Y-m-d") ?>">
																</div>
															</div>
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label"> End Date </label>
															<div class="col-md-9">
																<div class="input-group">
																	<span class="input-group-addon">
																		<i class="fa fa-calendar"></i>
																	</span>
																	<input type="date" class="form-control" name="end_date" />
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row form-group-row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label"> Company Representative </label>

															<div class="col-sm-9">
																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="company_rep_name" class="form-control" type="text" value="<?= $dealership['company_rep']['name'] ?>" placeholder="Name" data-current="<?= $dealership['company_rep']['name'] ?>" />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="company_rep_email" class="form-control" type="email" value="<?= $dealership['company_rep']['email'] ?>" placeholder="Email" data-current="<?= $dealership['company_rep']['email'] ?>" required />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="company_rep_phone" class="form-control" type="text" value="<?= $dealership['company_rep']['phone'] ?>" placeholder="Phone" data-current="<?= $dealership['company_rep']['phone'] ?>" />
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label"> CSM </label>
															<div class="col-md-9">
																<select class="form-control" name="assigned_to">
																	<option value="" <?= (!$dealership['assigned_to']) ? 'selected=""' : '' ?>>
																		Unassigned
																	</option>
																	<?php foreach ($admins as $email => $admin) : ?>
																		<option value="<?= $email ?>" <?= $dealership['assigned_to'] == $email ? 'selected=""' : '' ?>> <?= $admin['name'] ?> </option>
																	<?php endforeach; ?>
																</select>
															</div>
														</div>
													</div>
												</div>

												<div class="row form-group-row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label"> Company Address </label>

															<div class="col-sm-9">
																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="address" class="form-control" type="text" value="<?= $dealership['address'] ?>" placeholder="Address" data-current="<?= $dealership['address'] ?>" maxlength="512" />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="city" class="form-control" type="text" value="<?= $dealership['city'] ?>" placeholder="City" data-current="<?= $dealership['city'] ?>" maxlength="64" />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="state" class="form-control" type="text" value="<?= $dealership['state'] ?>" placeholder="State" data-current="<?= $dealership['state'] ?>" maxlength="64" />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-6">
																		<input name="post_code" class="form-control" type="text" value="<?= $dealership['post_code'] ?>" placeholder="Post Code" data-current="<?= $dealership['post_code'] ?>" maxlength="16" />
																	</div>

																	<div class="col-sm-6">
																		<select class="form-control" name="country_name">
																			<option value=""> --Select Country--
																			</option>
																			<option value="Canada" <?= $dealership['country_name'] == 'Canada' ? 'selected=""' : '' ?>>
																				Canada
																			</option>
																			<option value="USA" <?= $dealership['country_name'] == 'USA' ? 'selected=""' : '' ?>>
																				USA
																			</option>
																			<option value="New Zealand" <?= $dealership['country_name'] == 'New Zealand' ? 'selected=""' : '' ?>>
																				New Zealand
																			</option>
																			<option value="Australia" <?= $dealership['country_name'] == 'Australia' ? 'selected=""' : '' ?>>
																				Australia
																			</option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div id="w4-billing" class="tab-pane">
												<div class="row form-group-row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label"> Website Representative </label>

															<div class="col-sm-9">
																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="website_rep_name" class="form-control" type="text" value="<?= $dealership['website_rep']['name'] ?>" placeholder="Name" data-current="<?= $dealership['website_rep']['name'] ?>" />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="website_rep_email" class="form-control" type="email" value="<?= $dealership['website_rep']['email'] ?>" placeholder="Email" data-current="<?= $dealership['website_rep']['email'] ?>" />
																	</div>
																</div>

																<div class="row mb-lg">
																	<div class="col-sm-12">
																		<input name="website_rep_phone" class="form-control" type="text" value="<?= $dealership['website_rep']['phone'] ?>" placeholder="Phone" data-current="<?= $dealership['website_rep']['phone'] ?>" />
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label"> Dealership Group </label>

															<div class="col-sm-9">
																<select onchange="groupNameShowHide(this)" id="showDealershipGroup" class="form-control" name="saler_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
																	<option value="Local" <?= $dealership['saler_type'] == 'Local' ? 'selected=""' : '' ?>>
																		No
																	</option>
																	<option value="Dealership" id="unHide" <?= $dealership['saler_type'] == 'Dealership' ? 'selected=""' : '' ?>>
																		Yes
																	</option>
																</select>
															</div>
														</div>

														<div class="form-group hideMe" id="hidden_group">
															<label class="col-sm-3 control-label"> Group
																Name </label>
															<div class="col-sm-9">
																<select id="group_name" name="group_name" title="Please select dealership group if it is a part of group" class="form-control populate sMedia_dropdown" style="width : 75%;">
																	<option value="">Choose a Group</option>
																	<?php
																	foreach ($dealer_groups as $key => $value) {
																	?>
																		<option value="<?= $value ?>" <?= $dealership['group_name'] == $value ? 'selected=""' : '' ?>><?= $value ?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div id="w4-confirm" class="tab-pane">
												<!-- Scraper Type & CRM -->
												<div class="row form-group-row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label"> Scraper
																Type </label>
															<div class="col-md-9">
																<select class="form-control" name="scrapper_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
																	<option value="RegEx"> Regular Expression
																	</option>
																	<option value="VS"> Visual Scraper
																	</option>
																	<option value="CSV"> CSV File Data
																	</option>
																	<option value="NLP"> Natural Language Processing
																	</option>
																</select>
															</div>
														</div>
													</div>

													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label"> CRM </label>

															<div class="col-md-9">
																<input name="crm" class="form-control" type="text" placeholder="Enter dealership CRM here" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter dealership CRM here" />
															</div>
														</div>
													</div>
												</div>
												<!-- End Scraper Type & CRM -->

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<div class="col-sm-3"></div>

															<div class="col-sm-9">
																<div class="checkbox-custom">
																	<input type="checkbox" name="terms" id="w4-terms" required>
																	<label for="w4-terms"> I agree to the terms of
																		service </label>
																</div>
															</div>
														</div>

														<div class="form-group">
															<button name="btn" value="save-dealer" onclick="return validateForm()" class="btn btn-primary pull-right"> Submit
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="panel-footer">
										<ul class="pager">
											<li class="previous disabled">
												<a><i class="fa fa-angle-left"></i> Previous</a>
											</li>

											<li class="finish hidden pull-right">
												<a> Finish </a>
											</li>

											<li class="next">
												<a> Next <i class="fa fa-angle-right"></i></a>
											</li>
										</ul>
									</div>
								</form>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
include 'bolts/footer.php';
