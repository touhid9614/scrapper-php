<?php

if (isset($_GET['show_error']) && $_GET['show_error'] == 'show') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

global $CronConfigs, $scrapper_configs, $user, $single_config;

if (isset($_GET['dealership']) && !empty($_GET['dealership'])) {
    $single_config = $_GET['dealership'];
}

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once 'includes/default-values.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'includes/email_verification.php';
require_once 's3-update.php';

use Aws\S3\S3Client;

$bucket_name     = "smedia-config";
$s3_config       = ["region" => "us-east-1", 'version' => '2006-03-01'];
$s3_client       = new S3Client($s3_config);
$temp_file       = tempnam(sys_get_temp_dir(), 'temp-config');
$all_config_file = dirname(__DIR__) . '/adwords3/caches/configs.php';
$cron_name       = $user['cron_name'];
$tag_state_dir   = dirname(ABSPATH) . '/tag-state/';

if (!file_exists($tag_state_dir)) {
    if (!mkdir($tag_state_dir)) {
        echo "\n// Unable to create tag state directory.\n";
    }
}

$db_connect       = new DbConnect($cron_name);
$cron_config      = $CronConfigs[$cron_name];
$admins           = $db_connect->getAdmins();
$dealer_groups    = $db_connect->getGroupNames();
$website_provider = $db_connect->getWebProviders();

$carchat_provider = ['gubagoo', 'carchat24', 'livechat', 'liveadmins', 'liveguidechat', 'ngagelive', 'livehelpnow', 'chaport', 'livechatagent', 'livepersonautomotive', 'userlike', 'saleschat', 'carcasm', 'vee24', 'revechat'];
$fetch_carchat_provider = $db_connect->query("SELECT DISTINCT(carchat_provider) FROM dealerships WHERE carchat_provider IS NOT NULL AND carchat_provider != '' AND carchat_provider != 'N/A' ORDER BY carchat_provider ASC;");

while ($row = mysqli_fetch_assoc($fetch_carchat_provider)) {
    $carchat_provider[] = $row['website_provider'];
}

$carchat_provider = array_unique(array_filter($carchat_provider));
natcasesort($carchat_provider);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_input(INPUT_GET, 'dealership') === $cron_name) {
    $btn = filter_input(INPUT_POST, 'btn');

    switch ($btn) {
        case 'save-general':
            $dealership = $db_connect->get_dealer_details($cron_name);

            if (!$dealership) {
                $dealership = $default_dealership;
            }

            $new_values             = clear_unwanted(filter_input_array(INPUT_POST), array_keys($dealership));
            $salesman_numbers       = $_POST['salesman_numbers'];
            $calldrip_start_times   = $_POST['calldrip_start_times'];
            $calldrip_end_times     = $_POST['calldrip_end_times'];
            $combined_salesman_info = [];

            for ($i = 0, $numbers = count($salesman_numbers); $i < $numbers; $i++) {
                array_push($combined_salesman_info, [
					'number'     => $salesman_numbers[$i],
					'start_time' => $calldrip_start_times[$i],
					'end_time'   => $calldrip_end_times[$i]
				]);
            }

            if ($dealership['status'] == 'trial' && $new_values['status'] == 'active') {
                $new_values['tag_needed'] = 'yes';
            }

            if (isset($new_values['snapchat_feed_export']) && $new_values['snapchat_feed_export']) {
                $new_values['snapchat_feed_export'] = 1;
            } else {
                $new_values['snapchat_feed_export'] = 0;
            }

            if (isset($new_values['external_domain_vdp']) && $new_values['external_domain_vdp']) {
                $new_values['external_domain_vdp'] = 1;
            } else {
                $new_values['external_domain_vdp'] = 0;
            }

            // TAG CONTROLS
            if (isset($new_values['tag_controls']['event_tracker']) && $new_values['tag_controls']['event_tracker']) {
                $new_values['tag_controls']['event_tracker'] = 1;
            } else {
                $new_values['tag_controls']['event_tracker'] = 0;
            }

            $new_details = array_merge($dealership, $new_values);

            if ($new_details['start_date']) {
                $new_details['start_date'] = strtotime($new_details['start_date']);
            }

            if ($new_details['end_date']) {
                $new_details['end_date'] = strtotime($new_details['end_date']);
            }

            /* CRM */
            $new_details['crm'] = strtoupper($new_details['crm']);

            /* Call Drip */
            if ($new_details['calldrip']) {
                $new_details['salesman_numbers'] = serialize($combined_salesman_info);
            } else {
                $new_details['salesman_numbers'] = null;
            }

            $cancelledStatusCompare = ['inactive', 'completed-trial'];
            $activeStatusCompare    = ['active', 'trial'];

            $key = "config/{$cron_name}.php";

            // $new_details ==> new values, $dealership ==> old values
            if ($new_details['status'] != $dealership['status']) {
                // ACTIVE to INACTIVE
                $activeToInactive = (in_array($dealership['status'], $activeStatusCompare) && in_array($new_details['status'], $cancelledStatusCompare)) ? true :  false;

                // INACTIVE to ACTIVE
                $inactiveToInactive = (in_array($dealership['status'], $cancelledStatusCompare) &&  in_array($new_details['status'], $activeStatusCompare)) ? true :  false;

                // Do nothing if within same category such as trial to active
                if ($activeToInactive) {
                    $s3_client->copyObject([
                        'Bucket'     => $bucket_name,
                        'Key'        => $key . '.cancelled',
                        'CopySource' => "{$bucket_name}/{$key}"
                    ]);

                    $result = $s3_client->deleteObject([
						'Bucket' => $bucket_name,
						'Key'    => $key
					]);

                    change_config_status($cron_name, CONFIG_TYPE_CANCELLED);
                    $db_connect->query("UPDATE users SET account_disabled = true WHERE dealership = '$cron_name';");
                } else if ($inactiveToInactive) {
                    $s3_client->copyObject([
                        'Bucket'     => $bucket_name,
                        'Key'        => $key,
                        'CopySource' => "{$bucket_name}/{$key}.cancelled"
                    ]);

                    $result = $s3_client->deleteObject([
                        'Bucket' => $bucket_name,
                        'Key'    => $key . '.cancelled'
                    ]);

                    change_config_status($cron_name, CONFIG_TYPE_ENABLED);
                    $db_connect->query("UPDATE users SET account_disabled = false WHERE dealership = '$cron_name';");
                }

                $db_connect->query("UPDATE tag_config SET status = '" . $new_details['status'] . "' WHERE dealership = '" . $cron_name . "';");
            }

            $db_connect->store_dealer_details($cron_name, $new_details);
            DbConnect::store_log($user_id, $user['type'], 'Dealer general details', 'Dealer general details change where dealer name- ' . $cron_name . ' and status is- ' . $new_details['status'], $cron_name);
            break;

        case 'save-followup':
            $note_type = filter_input(INPUT_POST, 'note_type');
            $happiness = filter_input(INPUT_POST, 'happiness');
            $at        = strtotime(filter_input(INPUT_POST, 'at'));
            $note      = filter_input(INPUT_POST, 'note');

            if (!$at) {
                $at = time();
            }

            $db_connect->store_note($cron_name, $happiness, $note, $at, $note_type, $user['id']);
            DbConnect::store_log($user_id, $user['type'], 'Dealer follow up details', 'Dealer follow up details change where dealer name- ' . $cron_name, $cron_name);
            break;

        case 'client-setupform':
            $dealer_jsondata   = filter_input(INPUT_POST, 'dealer_jsondata');
            $update_dealership = filter_input(INPUT_POST, 'update_dealership');
            $dealer_decode     = json_decode($dealer_jsondata, true);

            $db_connect->store_dealer_details($update_dealership, $dealer_decode);
            DbConnect::store_log($user_id, $user['type'], 'Dealer details client setup form', 'Dealer details client setup form change where dealer name- ' . $cron_name, $cron_name);
            break;
    }

    echo("<script type='text/javascript'> location.href = location.href; </script>");
}

$dealership = $db_connect->get_dealer_details($cron_name);
$notes      = $db_connect->get_notes($cron_name);

if (!$dealership) {
    $dealership = $default_dealership;
}

$button_configured = isset($cron_config['buttons']);
$form_configured   = false;

if ($button_configured) {
    foreach ($cron_config['buttons'] as $button_config) {
        $form_configured |= isset($button_config['button_action']);
    }
}

if (!isset($dealership['fb_page_id']) || $dealership['fb_page_id'] == '') {
    $fb_page_id = 251738238196252;  // set to sMedia page
} else {
    $fb_page_id = $dealership['fb_page_id'];
}

// Enable storing snapchat_feed_export
if (!isset($dealership['snapchat_feed_export'])) {
    $dealership['snapchat_feed_export'] = 0;
}

if (empty($dealership['tag_controls'])) {
    $dealership['tag_controls'] = $default_tag_controls;
}

function clear_unwanted($values, $keys)
{
    $_keys = array_keys($values);

    foreach ($_keys as $key) {
        if (!in_array($key, $keys)) {
            unset($values[$key]);
        }
    }

    return $values;
}

include 'bolts/header.php';
?>
    <div class="inner-wrapper">
        <?php
        $select = 'crm-details';
        include 'bolts/sidebar.php';
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2 class="panel-title"> <?= "Details for {$dealership['company_name']} ($cron_name)" ?></h2>
            </header>

            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <?php
                    if (filter_input(INPUT_GET, 'dealership') != $cron_name || empty($cron_config)) {
                    ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong><?= filter_input(INPUT_GET, 'dealership') ?></strong> is either inactive or missing.
                        </div>
                    <?php
                    }
                    ?>
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <?php
                            if ($user['type'] == 'a') {
                                ?>
                                <li class="active">
                                    <a href="#general" data-toggle="tab" class="text-center">
                                        <i class="fa fa-book"></i> General
                                    </a>
                                </li>

                                <li>
                                    <a href="#scrapper-setting" data-toggle="tab" class="text-center">
                                        <i class="fa fa-cogs"></i> Scrapper Setting
                                    </a>
                                </li>

                                <li>
                                    <a href="#client-setupform" data-toggle="tab" class="text-center">
                                        <i class="fa fa-server"></i> Client Setup
                                    </a>
                                </li>

                                <li>
                                    <a href="#budget" data-toggle="tab" class="text-center">
                                        <i class="fa fa-dollar"></i> Budget
                                    </a>
                                </li>

                                <?php
                                if ($button_configured) {
                                    ?>
                                    <li>
                                        <a href="#aibuttons" data-toggle="tab" class="text-center">
                                            <i class="fa fa-line-chart"></i> AI Button</a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>

                            <li>
                                <a href="#smartoffer" data-toggle="tab" class="text-center">
                                    <i class="fa fa-picture-o"></i> Smart Offer
                                </a>
                            </li>

                            <li>
                                <a href="#smartmemo" data-toggle="tab" class="text-center">
                                    <i class="fab fa-wpforms"></i> Smart Memo
                                </a>
                            </li>

                            <li>
                                <a href="#mailRetargeting" data-toggle="tab" class="text-center">
                                    <i class="fa fa-envelope-open"></i> Mail Retargeting
                                </a>
                            </li>

                            <li>
                                <a href="#smartBanner" data-toggle="tab" class="text-center">
                                    <i class="far fa-image"></i> Smart Banner
                                </a>
                            </li>

                            <li>
                                <a href="#google" data-toggle="tab" class="text-center">
                                    <i class="fab fa-google"></i> AdWords Budget
                                </a>
                            </li>

                            <li>
                                <a href="#ad_preview" data-toggle="tab" class="text-center">
                                    <i class="fa fa-bar-chart"></i> Ad Preview
                                </a>
                            </li>

                            <li>
                                <a href="#fb_ad_feed_preview" data-toggle="tab" class="text-center">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="general"
                                 class="tab-pane <?php if ($user['type'] != 'u') : ?> active <?php endif; ?>">
                                <form method="POST" class="form-horizontal form-bordered"
                                      action="?dealership=<?= $cron_name ?>">

                                    <!-- HAPPINESS -->
                                    <div class="row form-group-row">
                                        <div class="col-md-9">
                                            <h3>Last Contacted
                                                On: <?= $dealership['last_contacted'] ? date('m/d/Y', $dealership['last_contacted']) : "Unknown" ?></h3>
                                            <?php
                                            if (count($dealership['brands'])) {
                                                ?>
                                                <p class="lead"> Brands: <?= implode(', ', $dealership['brands']) ?></p>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-sm">
                                                <input class="happiness-value" data-emo="#current-emo-container" type="hidden" value="<?= $dealership['happiness'] ?>"/>
                                                <p><i id="current-emo-container" class="emo pull-right"  style="font-size: 90px;"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END HAPPINESS -->


                                    <!-- GENERAL -->
                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Comapny Name </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="company_name" class="form-control"
                                                           value="<?= $dealership['company_name'] ?>"
                                                           data-current="<?= $dealership['company_name'] ?>"
                                                           maxlength="256">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Group Name </label>
                                                <div class="col-sm-9">
                                                    <select id="group_name" name="group_name"
                                                            title="Please select dealership group if it is a part of group"
                                                            class="form-control populate sMedia_dropdown">
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

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Phone </label>
                                                <div class="col-sm-9">
                                                    <input name="phone" class="form-control" type="text"value="<?= $dealership['phone'] ?>"
                                                           data-current="<?= $dealership['phone'] ?>" maxlength="256" data-toggle="popover" data-placement="bottom"
                                                                   data-trigger="hover"
                                                                   data-content="Enter phone no in form +1-306-664-6411 or 1-306-664-6411 or 1306-664-6411 or 306-664-6411"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Website </label>
                                                <div class="col-sm-9">
                                                    <input name="websites" class="form-control italic-placeholder"
                                                           type="text"
                                                           value="<?= $dealership['websites'] ?>"
                                                           data-current="<?= $dealership['websites'] ?>"
                                                           maxlength="256"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <label class="col-md-3 control-label"> Status </label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="status" data-plugin-multiselect
                                                        data-plugin-options='{ "maxHeight": 200 }'>
                                                    <option value="active" <?= $dealership['status'] == 'active' ? 'selected=""' : '' ?>>
                                                        Active
                                                    </option>
                                                    <option value="trial" <?= $dealership['status'] == 'trial' ? 'selected=""' : '' ?>>
                                                        Trial
                                                    </option>
                                                    <!-- <option value="trial-setup" <?= $dealership['status'] == 'trial-setup' ? 'selected' : '' ?>>
                                                        Trial Setup
                                                    </option> -->
                                                    <option value="completed-trial" <?= $dealership['status'] == 'completed-trial' ? 'selected=""' : '' ?>>
                                                        Completed Trial
                                                    </option>
                                                    <!-- <option value="failed-trial" <?= $dealership['status'] == 'failed-trial' ? 'selected=""' : '' ?>>
                                                        Failed Trial
                                                    </option> -->
                                                    <option value="inactive" <?= $dealership['status'] == 'inactive' ? 'selected=""' : '' ?>>
                                                        Inactive
                                                    </option>
                                                    <!-- <option value="unsure" <?= $dealership['status'] == 'unsure' ? 'selected=""' : '' ?>>
                                                        Unsure
                                                    </option>
                                                    <option value="free" <?= $dealership['status'] == 'free' ? 'selected=""' : '' ?>>
                                                        Free
                                                    </option> -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-3 control-label"> Client Type </label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="saler_type" data-plugin-multiselect
                                                        data-plugin-options='{ "maxHeight": 200 }'>
                                                    <option value="Dealership" <?= $dealership['saler_type'] == 'Dealership' ? 'selected=""' : '' ?>>
                                                        Dealership
                                                    </option>
                                                    <option value="Local" <?= $dealership['saler_type'] == 'Local' ? 'selected=""' : '' ?>>
                                                        Local
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END GENERAL -->

                                    <!-- ADDRESS -->
                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Address </label>
                                                <div class="col-sm-9">
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="address" class="form-control" type="text"
                                                                   value="<?= $dealership['address'] ?>"
                                                                   placeholder="Address"
                                                                   data-current="<?= $dealership['address'] ?>"
                                                                   maxlength="512"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="city" class="form-control" type="text"
                                                                   value="<?= $dealership['city'] ?>" placeholder="City"
                                                                   data-current="<?= $dealership['city'] ?>"
                                                                   maxlength="64"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-6">
                                                            <input name="state" class="form-control" type="text"
                                                                   value="<?= $dealership['state'] ?>"
                                                                   placeholder="State"
                                                                   data-current="<?= $dealership['state'] ?>"
                                                                   maxlength="64"/>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <select class="form-control" name="currency">
                                                                <option value="">-Select Currency-</option>
                                                                <option value="USD" <?= $dealership['currency'] == 'USD' ? 'selected=""' : '' ?>> USD </option>
                                                                <option value="CAD" <?= $dealership['currency'] == 'CAD' ? 'selected=""' : '' ?>> CAD </option>
                                                                <option value="NZD" <?= $dealership['currency'] == 'NZD' ? 'selected=""' : '' ?>> NZD </option>
                                                                <option value="AUD" <?= $dealership['currency'] == 'AUD' ? 'selected=""' : '' ?>> AUD </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-6">
                                                            <input name="post_code" class="form-control" type="text"
                                                                   value="<?= $dealership['post_code'] ?>"
                                                                   placeholder="Post Code"
                                                                   data-current="<?= $dealership['post_code'] ?>"
                                                                   maxlength="16"/>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <select class="form-control" name="country_name">
                                                                <option value="">-Select Country-</option>
                                                                <option value="USA" <?= $dealership['country_name'] == 'USA' ? 'selected=""' : '' ?>> USA </option>
                                                                <option value="Canada" <?= $dealership['country_name'] == 'Canada' ? 'selected=""' : '' ?>> Canada </option>
                                                                <option value="New Zealand" <?= $dealership['country_name'] == 'New Zealand' ? 'selected=""' : '' ?>> New Zealand </option>
                                                                <option value="Australia" <?= $dealership['country_name'] == 'Australia' ? 'selected=""' : '' ?>> Australia </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Website Rep </label>
                                                <div class="col-sm-9">
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="website_rep[name]" class="form-control"
                                                                   type="text"
                                                                   value="<?= $dealership['website_rep']['name'] ?>"
                                                                   placeholder="Name"
                                                                   data-current="<?= $dealership['website_rep']['name'] ?>"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="website_rep[email]" class="form-control"
                                                                   type="email"
                                                                   value="<?= $dealership['website_rep']['email'] ?>"
                                                                   placeholder="Email"
                                                                   data-current="<?= $dealership['website_rep']['email'] ?>"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="website_rep[phone]" class="form-control"
                                                                   type="text"
                                                                   value="<?= $dealership['website_rep']['phone'] ?>"
                                                                   placeholder="Phone"
                                                                   data-current="<?= $dealership['website_rep']['phone'] ?>"
                                                                   data-trigger="hover"
                                                                   data-content="Enter phone no in form +1-306-664-6411 or 1-306-664-6411 or 1306-664-6411 or 306-664-6411"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> FB Page ID </label>
                                                <div class="col-sm-9">
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-9">
                                                            <input id="fb_page_id" name="fb_page_id"
                                                                   class="form-control" type="text"
                                                                   value="<?= $dealership['fb_page_id'] ?>"
                                                                   placeholder="Write your 15 digtit facebook page id"
                                                                   data-current="<?= $dealership['fb_page_id'] ?>"
                                                                   data-toggle="popover" data-placement="bottom"
                                                                   data-trigger="hover"
                                                                   data-content="Enter your 15 digtit facebook page id"
                                                                   onmouseout="getPage(this.value)"/>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <img src="https://graph.facebook.com/<?= $fb_page_id ?>/picture?app_id=1624969190861580"
                                                                 alt="dealership fb page logo" height="64" width="64"
                                                                 id="fb_page_image" data-toggle="popover"
                                                                 data-placement="bottom" data-trigger="hover"
                                                                 data-content="Click to visit <?= $cron_name ?> FB page.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Billing Address </label>

                                                <div class="col-sm-9">
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="billing_address" class="form-control"
                                                                   type="text"
                                                                   value="<?= $dealership['billing_address'] ?>"
                                                                   placeholder="Address"
                                                                   data-current="<?= $dealership['billing_address'] ?>"
                                                                   maxlength="512"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="billing_city" class="form-control" type="text"
                                                                   value="<?= $dealership['billing_city'] ?>"
                                                                   placeholder="City"
                                                                   data-current="<?= $dealership['billing_city'] ?>"
                                                                   maxlength="64"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="billing_state" class="form-control" type="text"
                                                                   value="<?= $dealership['billing_state'] ?>"
                                                                   placeholder="State"
                                                                   data-current="<?= $dealership['billing_state'] ?>"
                                                                   maxlength="64"/>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-lg">
                                                        <div class="col-sm-6">
                                                            <input name="billing_post_code" class="form-control"
                                                                   type="text"
                                                                   value="<?= $dealership['billing_post_code'] ?>"
                                                                   placeholder="Post Code"
                                                                   data-current="<?= $dealership['billing_post_code'] ?>"
                                                                   maxlength="16">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Company Rep </label>
                                                <div class="col-sm-9">
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="company_rep[name]" class="form-control"
                                                                   type="text"
                                                                   value="<?= $dealership['company_rep']['name'] ?>"
                                                                   placeholder="Name"
                                                                   data-current="<?= $dealership['company_rep']['name'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="company_rep[email]" class="form-control"
                                                                   type="email"
                                                                   value="<?= $dealership['company_rep']['email'] ?>"
                                                                   placeholder="Email"
                                                                   data-current="<?= $dealership['company_rep']['email'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="company_rep[phone]" class="form-control"
                                                                   type="text"
                                                                   value="<?= $dealership['company_rep']['phone'] ?>"
                                                                   placeholder="Phone"
                                                                   data-current="<?= $dealership['company_rep']['phone'] ?>"
                                                                   data-trigger="hover"
                                                                   data-content="Enter phone no in form +1-306-664-6411 or 1-306-664-6411 or 1306-664-6411 or 306-664-6411">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Privacy Policy </label>
                                                <div class="col-sm-9">
                                                    <div class="row mb-lg">
                                                        <div class="col-sm-12">
                                                            <input name="privacy_policy_url"
                                                                   class="form-control italic-placeholder"
                                                                   type="text"
                                                                   value="<?= $dealership['privacy_policy_url'] ?>"
                                                                   placeholder="https://example.com/privacy-policy/"
                                                                   data-current="<?= $dealership['privacy_policy_url'] ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END ADDRESS -->

                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Scraper Type </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="scrapper_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                                                        <option value="RegEx" <?= $dealership['scrapper_type'] == 'RegEx' ? 'selected=""' : '' ?>> Regular Expression </option>
                                                        <option value="VS" <?= $dealership['scrapper_type'] == 'VS' ? 'selected=""' : '' ?>> Visual Scraper </option>
                                                        <option value="CSV" <?= $dealership['scrapper_type'] == 'CSV' ? 'selected' : '' ?>> CSV File Data </option>
                                                        <option value="NLP" <?= $dealership['scrapper_type'] == 'NLP' ? 'selected=""' : '' ?>> Natural Language Processing </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Dealership Type </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="dealer_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
                                                        <option value="vehicle" <?= $dealership['dealer_type'] == 'vehicle' ? 'selected=""' : '' ?>> Vehicle </option>
                                                        <option value="rv" <?= $dealership['dealer_type'] == 'rv' ? 'selected=""' : '' ?>> RV </option>
                                                        <option value="equipment" <?= $dealership['dealer_type'] == 'equipment' ? 'selected' : '' ?>> Equipment </option>
                                                        <option value="electronics" <?= $dealership['dealer_type'] == 'electronics' ? 'selected=""' : '' ?>> Electronics </option>
                                                        <option value="realestate" <?= $dealership['dealer_type'] == 'realestate' ? 'selected=""' : '' ?>> Real Estate </option>
														<option value="food" <?= $dealership['dealer_type'] == 'food' ? 'selected=""' : '' ?>> Food </option>
														<option value="other" <?= $dealership['dealer_type'] == 'other' ? 'selected=""' : '' ?>> Other </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
									</div>

                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Close IO ID </label>

                                                <div class="col-md-9">
                                                    <input name="close_io_id" class="form-control" type="text" value="<?= $dealership['close_io_id'] ?>" placeholder="987654321"
                                                       data-current="<?= $dealership['close_io_id'] ?>" data-toggle="popover" data-placement="bottom"
                                                       data-trigger="hover"
                                                       data-content="Enter dealership close io id here"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Close IO Lead ID </label>

                                                <div class="col-md-9">
                                                    <input name="close_io_lead_id" class="form-control" type="text" value="<?= $dealership['close_io_lead_id'] ?>" placeholder="zxcvbnrtyuiop"
                                                       data-current="<?= $dealership['close_io_lead_id'] ?>" data-toggle="popover" data-placement="bottom"
                                                       data-trigger="hover"
                                                       data-content="Enter dealership close io lead id here"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

									<div class="row form-group-row">
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> CRM </label>

                                                <div class="col-md-9">
                                                    <input name="crm" class="form-control"
                                                           type="text"
                                                           value="<?= $dealership['crm'] ?>"
                                                           placeholder="Enter dealership CRM here"
                                                           data-current="<?= $dealership['crm'] ?>"
                                                           data-toggle="popover" data-placement="bottom"
                                                           data-trigger="hover"
                                                           data-content="Enter dealership CRM here"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Website Provider </label>
                                                <div class="col-sm-9">
                                                    <select id="website_provider" name="website_provider"
                                                            title="Please select website provider of this dealership"
                                                            class="form-control populate sMedia_dropdown">
                                                        <option value="">Choose a website provider</option>
                                                        <?php
                                                        foreach ($website_provider as $key => $value) {
                                                            ?>
                                                            <option value="<?= $value ?>" <?= $dealership['website_provider'] == $value ? 'selected=""' : '' ?>><?= $value ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
									</div>

                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Inventory Provider </label>

                                                <div class="col-md-9">
                                                    <input name="data_provider" class="form-control"
                                                           type="text"
                                                           value="<?= $dealership['data_provider'] ?>"
                                                           placeholder="Enter dealership data provider name here"
                                                           data-current="<?= $dealership['data_provider'] ?>"
                                                           data-toggle="popover" data-placement="bottom"
                                                           data-trigger="hover"
                                                           data-content="Enter dealership data provider name here"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Car Chat Provider </label>
                                                <div class="col-sm-9">
                                                    <select id="carchat_provider" name="carchat_provider"
                                                            title="Please select carchat provider of this dealership"
                                                            class="form-control populate sMedia_dropdown">
                                                        <option value="">Choose a carchat provider</option>
                                                        <?php
                                                        foreach ($carchat_provider as $key => $value) {
                                                            ?>
                                                            <option value="<?= $value ?>" <?= $dealership['carchat_provider'] == $value ? 'selected=""' : '' ?>><?= $value ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Scraper Type, Dealership Type, CRM & website provider -->

                                    <!-- Call Drip -->
                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Calldrip </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="calldrip"
                                                            onchange="showHideCallDrip()">
                                                        <option value="1" <?= $dealership['calldrip'] == 1 ? 'selected=""' : '' ?>>
                                                            Yes
                                                        </option>
                                                        <option value="0" <?= $dealership['calldrip'] == 0 ? 'selected=""' : '' ?>>
                                                            No
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group-row">
                                        <div class="col-md-12">
                                            <div class="form-group" id="calldrip_area">
                                                <label class="col-md-2 control-label"> Salesman Numbers </label>
                                                <div class="col-md-10">
                                                    <?php
                                                    $i = 0;


                                                    if (isset($dealership['salesman_numbers']) && count($dealership['salesman_numbers']) > 0) {
                                                        foreach ($dealership['salesman_numbers'] as $salesman_number) {
                                                            ?>

                                                            <div class="col-md-12" style="margin-bottom: 10px">
                                                                <div class="col-md-3">
                                                                    <input name="salesman_numbers[]"
                                                                           value="<?= $salesman_number['number'] ?>"
                                                                           onmouseout="validatePhoneNumber(this)"
                                                                           class="form-control" type="text"
                                                                           placeholder="XXX-XXX-XXXX or +1XXX-XXX-XXXX"
                                                                           data-current="<?= $salesman_number['number'] ?>"
                                                                           required
                                                                           data-trigger="hover"
                                                                        data-content="Enter phone no in form +1-306-664-6411 or 1-306-664-6411 or 1306-664-6411 or 306-664-6411"/>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <input name="calldrip_start_times[]"
                                                                           value="<?= $salesman_number['start_time'] ?>"
                                                                           class="form-control timepicker"
                                                                           placeholder="Start Time"
                                                                           data-current="<?= $salesman_number['start_time'] ?>"
                                                                           required/>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <input name="calldrip_end_times[]"
                                                                           value="<?= $salesman_number['end_time'] ?>"
                                                                           class="form-control timepicker"
                                                                           placeholder="End Time"
                                                                           data-current="<?= $salesman_number['end_time'] ?>"
                                                                           required/>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <button class="btn" type="button"
                                                                            onclick="addNewColumn(this)"><i
                                                                                class="fa fa-plus"></i></button>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <?php
                                                                    if ($i) {
                                                                        ?>
                                                                        <button class="btn" onclick="deleteColumn(this)"
                                                                                type="button"><i
                                                                                    class="fa fa-trash"></i>
                                                                        </button>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <div class="col-md-12" style="margin-bottom: 10px">
                                                            <div class="col-md-3">
                                                                <input name="salesman_numbers[]" class="form-control"
                                                                       onmouseout="validatePhoneNumber(this)"
                                                                       type="text"
                                                                       placeholder="XXX-XXX-XXXX or +1XXX-XXX-XXXX"
                                                                       required
                                                                       data-trigger="hover"
                                                                   data-content="Enter phone no in form +1-306-664-6411 or 1-306-664-6411 or 1306-664-6411 or 306-664-6411"/>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <input name="calldrip_start_times[]"
                                                                       value="00:00"
                                                                       class="form-control timepicker"
                                                                       placeholder="Start Time" required/>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <input name="calldrip_end_times[]"
                                                                       value="23:59"
                                                                       class="form-control timepicker"
                                                                       placeholder="End Time" required/>
                                                            </div>

                                                            <div class="col-md-1">
                                                                <button class="btn" type="button"
                                                                        onclick="addNewColumn(this)">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Call Drip -->


                                    <!-- CAMPAIGNS -->
                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Inventories </label>

                                                <input value="" type="hidden" name="inventories[]"/>

                                                <div class="col-sm-9">
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="new_inventory" value="new" type="checkbox"
                                                               name="inventories[]" <?= in_array('new', $dealership['inventories']) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                                                        <label for="new_inventory"> New </label>
                                                    </div>

                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="used_inventory" value="used" type="checkbox"
                                                               name="inventories[]" <?= in_array('used', $dealership['inventories']) ? 'data-current="checked" checked' : 'data-current=""'; ?>/>
                                                        <label for="used_inventory"> Used </label>
                                                    </div>

                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="certified_inventory" value="certified"
                                                               type="checkbox"
                                                               name="inventories[]" <?= in_array('certified', $dealership['inventories']) ? 'data-current="checked" checked' : 'data-current=""'; ?>/>
                                                        <label for="certified_inventory"> Certified </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> OEM </label>

                                                <input value="" type="hidden" name="oem[]"/>

                                                <div class="col-sm-9">
                                                    <?php
                                                    foreach ($all_oems as $oem) {
                                                        ?>
                                                        <div class="checkbox-custom chekbox-primary">
                                                            <input id="oem_campaigns_<?= preg_replace('/\s\n/', '-', trim(strtolower($oem))) ?>"
                                                                   value="<?= $oem ?>" type="checkbox"
                                                                   name="oem[]" <?= in_array($oem, $dealership['oem']) ? 'data-current="checked" checked' : 'data-current=""'; ?> />
                                                            <label for="oem_campaigns_<?= preg_replace('/\s\n/', '-', trim(strtolower($oem))) ?>"><?= $oem ?></label>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Snapchat Feed Export </label>
                                                <div class="col-lg-9" style="padding-top:14px">
                                                    <label class="ios7-switch" style="font-size: 24px;">
                                                        <input type="checkbox"
                                                               name="snapchat_feed_export" <?= $dealership['snapchat_feed_export'] ? 'checked="checked"' : ''; ?> />
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Allow External Domain VDP </label>
                                                <div class="col-lg-9" style="padding-top:14px">
                                                    <label class="ios7-switch" style="font-size: 24px;">
                                                        <input type="checkbox"
                                                               name="external_domain_vdp" <?= $dealership['external_domain_vdp'] ? 'checked="checked"' : ''; ?> />
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> Campaign Types </label>
                                                <?php
                                                $campaign_types = [
                                                    'smedia_inventory' => 'smedia Inventory',
                                                    'dynamic_social_retargeting' => 'Dynamic Social Retargeting',
                                                    'facebook_marketplace' => 'Facebook Marketplace',
                                                    'smart_offer' => 'Smart Offer',
                                                    'clean_click' => 'Clean Click',
                                                    'social_lead_ads' => 'Social Lead Ads',
                                                    'generic_social_ads' => 'Social Lead Ads',
                                                    'generic_adwords_campaign' => 'Generic Adwords Campaign',
                                                    'youtube-campaign' => 'YouTube Campaign',
                                                    'bing-ads' => 'Bing Ads',
                                                    'ai-buttons' => 'AI Buttons',
                                                    'ai-buttons-trial' => 'AI Buttons Trial',
                                                    'custom' => 'Custom',
                                                    'smart-banner' => 'smart-banner',
                                                ]
                                                ?>
                                                <input value="" type="hidden" name="campaign_types[]"/>

                                                <div class="col-sm-9">
                                                    <?php foreach ($campaign_types as $campaign_id => $campaign_type): ?>
                                                        <div class="checkbox-custom chekbox-primary">
                                                            <input id="<?= $campaign_id ?>"
                                                                   value="<?= $campaign_type ?>" type="checkbox"
                                                                   name="campaign_types[]" <?= in_array($campaign_type, $dealership['campaign_types']) ? 'data-current="checked" checked' : 'data-current=""'; ?>/>
                                                            <label for="<?= $campaign_id ?>"> <?= ucwords(str_replace('-', ' ', $campaign_type)) ?> </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END CAMPAIGNS -->

                                    <!-- DATES -->
                                    <div class="row form-group-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Start Date </label>

                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>

                                                        <input type="date" class="form-control" name="start_date"
                                                               value="<?= $dealership['start_date'] ? date('Y-m-d', $dealership['start_date']) : "" ?>"/>
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

                                                        <input type="date" class="form-control" name="end_date"
                                                               value="<?= $dealership['end_date'] ? date('Y-m-d', $dealership['end_date']) : "" ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END DATES -->

                                    <div class="row form-group-row clearfix">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> CSM </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="assigned_to">
                                                        <option value="" <?= (!$dealership['assigned_to']) ? 'selected=""' : '' ?>>
                                                            Not Assigned
                                                        </option>
                                                        <?php
                                                        foreach ($admins as $email => $admin) {
                                                            ?>
                                                            <option value="<?= $email ?>" <?= $dealership['assigned_to'] == $email ? 'selected=""' : '' ?>><?= $admin['name'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Google AD OPS </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="gadops">
                                                        <option value="" <?= (!$dealership['gadops']) ? 'selected=""' : '' ?>>
                                                            Not Assigned
                                                        </option>
                                                        <?php
                                                        foreach ($admins as $email => $admin) {
                                                        ?>
                                                            <option value="<?= $email ?>" <?= $dealership['gadops'] == $email ? 'selected=""' : '' ?>><?= $admin['name'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group-row clearfix">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> Tag Needed </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="tag_needed">
                                                        <option value="yes" <?= $dealership['tag_needed'] == 'yes' ? 'selected=""' : '' ?>>
                                                            Yes
                                                        </option>
                                                        <option value="no" <?= $dealership['tag_needed'] == 'no' ? 'selected=""' : '' ?>>
                                                            No
                                                        </option>
                                                        <option value="pending" <?= $dealership['tag_needed'] == 'pending' ? 'selected=""' : '' ?>>
                                                            Pending
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label"> FB AD OPS </label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="fadops">
                                                        <option value="" <?= (!$dealership['fadops']) ? 'selected=""' : '' ?>>
                                                            Not Assigned
                                                        </option>
                                                        <?php
                                                        foreach ($admins as $email => $admin) {
                                                        ?>
                                                            <option value="<?= $email ?>" <?= $dealership['fadops'] == $email ? 'selected=""' : '' ?>><?= $admin['name'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group-row clearfix">
                                        <div class="col-md-6 mt-md">
                                            <h4> Tag Controls </h4>
                                        </div>
                                    </div>


                                    <div class="row form-group-row clearfix">
                                        <label class="col-sm-3 control-label"> Event Tracker  On</label>
                                        <div class="col-sm-9">
                                            <label class="ios7-switch">
                                                <input type="checkbox" name="tag_controls[event_tracker]" value="1" data-plugin-ios-switch <?= $dealership['tag_controls']['event_tracker'] ? 'checked' : '' ?>/>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button id="details_submit_btn" name="btn" value="save-general" class="btn btn-primary pull-right"> Save Changes </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="scrapper-setting" class="tab-pane">
                                <?php require_once 'client-management/scrapper-setting.php'; ?>
                            </div>

                            <div id="client-setupform" class="tab-pane">
                                <form method="POST" class="form-horizontal form-bordered"
                                      action="?dealership=<?= $cron_name ?>">
                                    <div class="row form-group-row clearfix">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label"> Client Setup Data </label>

                                                <div class="col-md-10">
                                                    <textarea class="form-control" cols="35" rows="20" name="dealer_jsondata"><?= json_encode($dealership, JSON_PRETTY_PRINT); ?></textarea>
                                                    <input type="hidden" name="update_dealership" value="<?= $dealership['dealership'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group-row clearfix">
                                        <div class="col-md-12">
                                            <button name="btn" value="client-setupform" class="btn btn-primary pull-right"> Save Changes </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div id="budget" class="tab-pane">
                                <?php require_once 'client-management/details-budget.php'; ?>
                            </div>

                            <?php if ($button_configured) { ?>
                                <div id="aibuttons" class="tab-pane">
                                    <?php require_once 'client-management/details-aibuttons.php'; ?>
                                </div>
                            <?php } ?>

                            <div id="smartoffer" class="tab-pane">
                                <?php require_once 'client-management/details-smart-offer.php'; ?>
                            </div>

                            <div id="smartmemo" class="tab-pane">
                                <?php require_once 'client-management/details-smart-memo.php'; ?>
                            </div>

                            <div id="mailRetargeting" class="tab-pane">
                                <?php require_once 'client-management/details-mail-retargeting.php'; ?>
                            </div>

                            <div id="smartBanner" class="tab-pane">
                                <?php require_once 'client-management/smart-banner.php'; ?>
                            </div>

                            <div id="google" class="tab-pane">
                                <?php require_once 'client-management/details-adwords.php'; ?>
                            </div>

                            <div id="ad_preview" class="tab-pane">
                                <?php if ($_SERVER['HTTP_HOST'] != 'localhost') {
                                    require_once 'client-management/add-preview.php';
                                } ?>
                            </div>

                            <div id="ban_preview" class="tab-pane">
                                <?php require_once 'client-management/details-banner-preview.php'; ?>
                            </div>

                            <div id="fb_ad_feed_preview" class="tab-pane">
                                <?php if ($_SERVER['HTTP_HOST'] != 'localhost') {
                                    require_once 'client-management/fb-ad-feed-preview.php';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
	include 'bolts/footer.php';
