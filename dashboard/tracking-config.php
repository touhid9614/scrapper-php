<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once 'tracking-config/function.php';

global $user;

$cron_name       = $user['cron_name'];
$all_dealerships = DbConnect::get_instance()->get_all_dealers(1);

$id   = isset($_GET['id']) ? $_GET['id'] : false;
$type = isset($_GET['type']) ? $_GET['type'] : 'analytics';

$save_new   = false;
$update_con = false;
$delete_con = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['btn'] == 'new') {
        $new_id = $_POST['new_id'];
        $type   = $_POST['type'];
        post_id($cron_name, $type, $new_id);
        $id       = $new_id;
        $save_new = true;
    } else if ($_POST['btn'] == 'update-config') {
        $type        = $_POST['type'];
        $id          = $_POST['id'];
        $db_id       = $_POST['db_id'];
        $dealername  = $_GET['dealership'];
        $install_tag = ($_POST['install_tag'] === 'true') ? 1 : 0;

        $keys  = [];
        $pages = ['vdp', 'srp', 'ty', 'other'];

        if ($type == 'analytics') {
            $keys = [
                'install_analytics'     => 'checkbox',
                'ga'                    => 'array',
                'profitable_engagement' => 'checkbox|vdp',
                'scroll_depth'          => 'checkbox'
            ];

            $params = [
			    'analytics_account' => $_POST['analytics_account'],
			    'ana_acc_id'        => $_POST['ana_acc_id'],
			    'ana_view_id'       => $_POST['ana_view_id'],
			    'ana_profile_id'    => $_POST['profile_id']
			];
            update_dealer_info($dealername, $params);
        } else if ($type == 'adwords') {
            $keys = [
                'adwords_conversion_id'    => 'text',
                'adwords_conversion_label' => 'text'
            ];

            $params = [
			    'adw_acc_id' => $_POST['adw_acc_id']
			];
            update_dealer_info($dealername, $params);
        } else if ($type == 'bing') {
            $keys = [
                'install_bing' => 'checkbox',
                'bing_events'  => 'array'
            ];
        } else if ($type == 'snapchat') {
            $keys = [
                'install_snapchat' => 'checkbox',
                'snapchat_events'  => 'array'
            ];
        } else if ($type == 'facebook') {
            $keys = [
                'install_fbq' 		=> 'checkbox',
                'fbq'         		=> 'array',
                'viewcontent' 		=> 'array|vdp'
            ];

            $params = [
			    'fb_account_id' 		 => $_POST['fb_acc_id'],
			    'pixel_content_id_field' => $_POST['pixel_content_id_field'],
			];

            update_dealer_info($dealername, $params);
        }

        $config = [];

        foreach ($pages as $page) {
            foreach ($keys as $key => $data_types) {
                $name      = $page . '_' . $key;
                $data_type = explode("|", $data_types);
                $post_type = $data_type[0];
                $yes       = true;

                if (count($data_type) > 1) {
                    if (!in_array($page, $data_type)) {
                        $yes = false;
                    }
                }

                if ($post_type == 'checkbox' && $yes) {
                    $config[$page][$key] = ($_POST[$name] === 'true') ? 1 : 0;
                } else if ($post_type == 'array' && $yes) {
                    $config[$page][$key] = isset($_POST[$name]) && is_array($_POST[$name]) ? $_POST[$name] : [];
                } else if ($yes) {
                    $config[$page][$key] = $_POST[$name];
                }
            }
        }

        if ($type == 'facebook') {
        	$config['vdp']['fbq_selectors'] = [
            	'lead'                 => $_POST['vdp_lead_selector'],
            	'addtowishlist'        => $_POST['vdp_addtowishlist_selector'],
            	'scheduletestdrive'    => $_POST['vdp_scheduletestdrive_selector'],
            	'contactus'            => $_POST['vdp_contactus_selector'],
            	'findlocation'         => $_POST['vdp_findlocation_selector'],
            	'addtocart'            => $_POST['vdp_addtocart_selector'],
            	'customizevehicle'     => $_POST['vdp_customizevehicle_selector'],
            	'completeregistration' => $_POST['vdp_completeregistration_selector'],
            	'initiatecheckout'     => $_POST['vdp_initiatecheckout_selector'],
            	'addedpaymentinfo'     => $_POST['vdp_addedpaymentinfo_selector'],
            	'purchase'             => $_POST['vdp_purchase_selector']
            ];

            $config['srp']['fbq_selectors'] = [
            	'search'            => $_POST['srp_search_selector'],
            	'lead'              => $_POST['srp_lead_selector'],
            	'addtowishlist'     => $_POST['srp_addtowishlist_selector'],
            	'scheduletestdrive' => $_POST['srp_scheduletestdrive_selector'],
            	'contactus'         => $_POST['srp_contactus_selector'],
            	'findlocation'      => $_POST['srp_findlocation_selector']
            ];

            $config['ty']['fbq_selectors'] = [
            	'lead'  => $_POST['ty_lead_selector']
            ];

            $config['other']['fbq_selectors'] = [
            	'lead' 				=> $_POST['other_lead_selector'],
            	'scheduletestdrive' => $_POST['other_scheduletestdrive_selector'],
            	'contactus'    		=> $_POST['other_contactus_selector'],
            	'findlocation' 		=> $_POST['other_findlocation_selector']
            ];
        }

        update_config($db_id, $install_tag, $config, $dealername);
        $update_con = true;
    } else if ($_POST['btn'] == 'additional_scripts') {
        $type       = 'additional';
        $db_id      = $_POST['db_id'];
        $dealername = $_GET['dealership'];

        $config['vdp']['additional_scripts']   = explode("\n", trim($_POST['vdp_additional_scripts']));
        $config['srp']['additional_scripts']   = explode("\n", trim($_POST['srp_additional_scripts']));
        $config['ty']['additional_scripts']    = explode("\n", trim($_POST['ty_additional_scripts']));
        $config['other']['additional_scripts'] = explode("\n", trim($_POST['other_additional_scripts']));

        if ($db_id) {
            update_config($db_id, 1, $config, $dealername);
            $update_con = true;
        } else {
            post_additional_script($cron_name, $type, $config);
            $save_new = true;
        }
    } else if ($_POST['btn'] == 'adwords_conversion') {
        $type       = 'adwords';
        $db_id      = $_POST['db_id'];
        $adw_acc_id = $_POST['adw_acc_id'];
        $pages      = ['vdp', 'srp', 'ty', 'other'];
        $dealername = $_GET['dealership'];

        foreach ($pages as $page) {
            $id_name    = $page . '_adwords_conversion_id';
            $label_name = $page . '_adwords_conversion_label';

            $config[$page]['adwords_conversion_id']    = $_POST[$id_name];
            $config[$page]['adwords_conversion_label'] = $_POST[$label_name];
        }

        if ($db_id) {
            update_config($db_id, 1, $config, $dealername, $adw_acc_id);
            $update_con = true;
        } else {
            post_additional_script($cron_name, $type, $config);
            $save_new = true;
        }
    } else if ($_POST['btn'] == 'delete') {
        $delete_id = $_POST['delete_id'];
        account_tag_config_delete($delete_id);
        $delete_con = true;
        $id         = '';
    }

    echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">

<?php
$select = 'tracking-config';
include 'bolts/sidebar.php';
?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<div class="col-md-12">
				<section class="panel panel-info">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title"> Configuration Panel </h2>
					</header>

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
											value="<?=$dealer['dealership']?>"<?=$selected?>><?=$dealer['dealership']?></option>
								<?php
									}
								} else {
								?>
									<option
										value="<?=$user['cron_name']?>"<?=' selected'?>><?=$user['cron_name']?> </option>
								<?php
								}
								?>
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
				<div class="tabs">
					<ul class="nav nav-tabs">
						<li class="<?=$type == 'analytics' ? 'active' : ''?>">
							<a href="#analytics" data-toggle="tab" class="text-center">
								<i class="glyphicon glyphicon-signal"></i> Analytics
							</a>
						</li>

						<li class="<?=$type == 'facebook' ? 'active' : ''?>">
							<a href="#facebook" data-toggle="tab" class="text-center">
								<i class="fab fa-facebook-f"></i> Facebook
							</a>
						</li>

						<li class="<?=$type == 'bing' ? 'active' : ''?>">
							<a href="#bing" data-toggle="tab" class="text-center">
								<img class="image-icon" src="assets/images/bing_logo.svg"> Bing
							</a>
						</li>

						<li class="<?=$type == 'adwords' ? 'active' : ''?>">
							<a href="#adwords" data-toggle="tab" class="text-center">
								<i class="fab fa-google"></i> Adwords
							</a>
						</li>

						<li class="<?=$type == 'snapchat' ? 'active' : ''?>">
							<a href="#snapchat" data-toggle="tab" class="text-center">
								<i class="fab fa-snapchat" aria-hidden="true"></i> Snapchat
							</a>
						</li>

						<li class="<?=$type == 'additional' ? 'active' : ''?>">
							<a href="#additional-script" data-toggle="tab" class="text-center">
								<i class="fa fa-book"></i> Additional Script
							</a>
						</li>
					</ul>

					<div class="tab-content" style="background: #ecedf0;">
						<div id="analytics" class="tab-pane <?=$type == 'analytics' ? 'active' : ''?>">
							<?php require_once 'tracking-config/analytics.php';?>
						</div>

						<div id="facebook" class="tab-pane <?=$type == 'facebook' ? 'active' : ''?>">
							<?php require_once 'tracking-config/facebook.php';?>
						</div>

						<div id="bing" class="tab-pane <?=$type == 'bing' ? 'active' : ''?>">
							<?php require_once 'tracking-config/bing.php';?>
						</div>

						<div id="adwords" class="tab-pane <?=$type == 'adwords' ? 'active' : ''?>">
							<?php require_once 'tracking-config/adwords.php';?>
						</div>

						<div id="snapchat" class="tab-pane <?=$type == 'snapchat' ? 'active' : ''?>">
							<?php require_once 'tracking-config/snapchat.php';?>
						</div>

						<div id="additional-script" class="tab-pane <?=$type == 'additional' ? 'active' : ''?>">
							<?php require_once 'tracking-config/additional.php';?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div id="modalDelete" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="height:50px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title text-danger" id="myModalLabel"><b>DELETE !!! </b></h3>
				</div>
				<form method="post" class="form-horizontal">
				<div class="modal-body">
					<input type="hidden" name="delete_id" id="delete_id"/>
					<h4 id="acc_id"></h4>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger" name="btn" value="delete">Delete</button>
					<button class="btn btn-default" data-dismiss="modal">Close
					</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$(document).on("click", ".open-homeEvents", function () {
			let delete_id = $(this).data('id');
			let acc_id    = $(this).data('acc_id');
			let type      = $(this).data('type');
			let text 	  = `Do You Want to Delete the <i>${type}</i> Id:: <b>${acc_id}</b> ?`;

			$('#delete_id').html(delete_id);
			$('#acc_id').html(text);
			document.getElementById("delete_id").value = delete_id;
		});
	</script>

<?php
include 'bolts/footer.php';
