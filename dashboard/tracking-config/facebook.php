<?php

global $cron_name;

$account_ids = get_account_id($cron_name, 'facebook');
$link        = "?dealership=$cron_name&type=facebook&id=";
$firstKey    = array_key_first($account_ids);

if ($type == 'facebook') {
    $data_id = (empty($id) && count($account_ids)) ? $account_ids[$firstKey]->account_id : $id;
} else {
    $data_id = count($account_ids) ? $account_ids[$firstKey]->account_id : '';
}

$selected_account_config = $account_ids[$data_id];
$config_unserialize      = unserialize($selected_account_config->config);

$fb_infos  = get_facebook_account_info($cron_name);
$fb_acc_id = $fb_infos['fb_account_id'];
$cid_field = $fb_infos['pixel_content_id_field'];

$pixel_content_id_fields = ['stock_number', 'vin', 'vehicle_id', 'svin', 'url', 'custom'];
?>

<div class="row">
	<div class="col-md-9">
		<section class="panel panel-featured panel-featured-success">
			<header class="panel-heading">
				<h2 class="panel-title">Facebook Config</h2>
			</header>
			<div class="panel-body">
				<?php
				if (count($account_ids)) {
					if ($update_con && $type == 'facebook') {
						?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<strong>Success!!</strong> Update Facebook Pixel Settings
						</div>
						<?php
					}
					?>
					<form class="form-horizontal" method="post">
						<input type="hidden" name="type" value="facebook">
						<input type="hidden" name="id" value="<?= $data_id ?>">
						<input type="hidden" name="db_id" value="<?= $selected_account_config->id ?>">

						<div class="form-group">
							<label class="col-md-3 control-label" for="fb_acc_id">Facebook Account ID</label>
							<div class="col-md-6">
								<input type="text" id="fb_acc_id" name="fb_acc_id"
								class="form-control"
								placeholder="123456789" value="<?= $fb_acc_id ?>"
								data-current="<?= $fb_acc_id ?>"
								maxlength="20" data-toggle="popover" data-placement="bottom"
								data-trigger="hover"
								data-content="Enter facebook account id.">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Facebook Pixel ID</label>
							<div class="col-md-6">
								<div class="btn-group">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-default dropdown-toggle" data-toggle="dropdown"><?= $data_id ?> <span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu">
										<?php
										foreach ($account_ids as $account_id) {
											$acc_id = $account_id->account_id;
											$class = (($acc_id == $data_id && $type == 'facebook') ? 'active' : '');
											?>
											<li class="<?= ($data_id && $type == 'facebook') ? $class : '' ?>"><a
													href="<?= $link . $acc_id ?>"><?= $acc_id ?></a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>

						<!-- SHOW CONTENT ID FIELD -->
						<div class="form-group">
                            <label class="col-md-3 control-label"> Pixel Content ID Field </label>
                            <div class="col-md-6">
                                <select class="form-control" name="pixel_content_id_field" data-plugin-multiselect
                                        data-plugin-options='{ "maxHeight": 200 }'>
                                    <?php
                                    foreach ($pixel_content_id_fields as $field_name) {
                                    ?>
                                    <option value="<?= $field_name ?>" <?= $cid_field == $field_name ? 'selected=""' : '' ?>>
                                        <?= ucwords(str_replace("_", " ", $field_name)) ?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="install_facebook">Install Facebook Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-success">
									<input name="install_tag" value="true" type="checkbox"
										   id="install_facebook" <?= $selected_account_config->active ? 'checked' : '' ?> >
									<label for="install_facebook"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>VDP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_install_fbq">Install facebook Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_install_fbq" value="true" type="checkbox"
										   id="vdp_install_fbq" <?= $config_unserialize['vdp']['install_fbq'] ? 'checked' : '' ?> >
									<label for="vdp_install_fbq"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Facebook Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="pageview" type="checkbox"
										   id="vdp_pageview" <?= in_array('pageview', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_pageview">Page View <span style="color: red;">*</span></label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="viewcontent" type="checkbox"
										   id="vdp_viewcontent" <?= in_array('viewcontent', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_viewcontent">View Content<span style="color: red;">*</span></</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="epm" type="checkbox"
										   id="vdp_epm" <?= in_array('epm', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_viewcontent">Profitable Engagement<span style="color: red;">*</span></label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="smedialead" type="checkbox"
										   id="vdp_smedialead" <?= in_array('smedialead', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_smedialead">Smedia Lead <span style="color: red;">*</span></</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="lead" type="checkbox"
										   id="vdp_lead" <?= in_array('lead', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_lead">Lead (FORMs) <span style="color: red;">*</span></</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="scheduletestdrive" type="checkbox" id="vdp_scheduletestdrive" <?= in_array('scheduletestdrive', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_scheduletestdrive">Schedule Test Drive</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="contactus" type="checkbox"
										   id="vdp_contactus" <?= in_array('contactus', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_contactus">Contact Us</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="findlocation" type="checkbox"
										   id="vdp_findlocation" <?= in_array('findlocation', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_findlocation">Find Location</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="addtowishlist" type="checkbox"
										   id="vdp_addtowishlist" <?= in_array('addtowishlist', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_viewcontent">Add To Wishlist</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="addtocart" type="checkbox"
										   id="vdp_addtocart" <?= in_array('addtocart', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_addtocart">Add To Cart</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="customizevehicle" type="checkbox"
										   id="vdp_customizevehicle" <?= in_array('customizevehicle', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_customizevehicle">Customize Vehicle</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="completeregistration" type="checkbox" id="vdp_completeregistration" <?= in_array('completeregistration', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_completeregistration">Complete Registration</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="initiatecheckout" type="checkbox"
										   id="vdp_initiatecheckout" <?= in_array('initiatecheckout', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_initiatecheckout">Initiate Checkout</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="addpaymentinfo" type="checkbox"
										   id="vdp_addpaymentinfo" <?= in_array('addpaymentinfo', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_addpaymentinfo">Added Payment Info</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_fbq[]" value="purchase" type="checkbox"
										   id="vdp_purchase" <?= in_array('purchase', $config_unserialize['vdp']['fbq']) ? 'checked' : '' ?> >
									<label for="vdp_purchase">Purchase</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Content Type</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_viewcontent[]" value="product" type="checkbox"
										   id="vdp_product" <?= in_array('product', $config_unserialize['vdp']['viewcontent']) ? 'checked' : '' ?> >
									<label for="vdp_product">Product</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_viewcontent[]" value="vehicle" type="checkbox"
										   id="vdp_vehicle" <?= in_array('vehicle', $config_unserialize['vdp']['viewcontent']) ? 'checked' : '' ?> >
									<label for="vdp_vehicle">Vehicle</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for FORMs (Lead)</label>
							<div class="col-md-6">
								<input name="vdp_lead_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['lead'] ?>" type="text" id="vdp_lead_selector" class="form-control">
							</div>
							<span class="alert alert-info">This selector is optional.</span>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Schedule Test Drive"</label>
							<div class="col-md-6">
								<input name="vdp_scheduletestdrive_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['scheduletestdrive'] ?>" type="text" id="vdp_scheduletestdrive_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Contact Us"</label>
							<div class="col-md-6">
								<input name="vdp_contactus_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['contactus'] ?>" type="text" id="vdp_contactus_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Find Location"</label>
							<div class="col-md-6">
								<input name="vdp_findlocation_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['findlocation'] ?>" type="text" id="vdp_findlocation_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Add To Wishlist"</label>
							<div class="col-md-6">
								<input name="vdp_addtowishlist_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['addtowishlist'] ?>" type="text" id="vdp_addtowishlist_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Add To Cart"</label>
							<div class="col-md-6">
								<input name="vdp_addtocart_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['addtocart'] ?>" type="text" id="vdp_addtocart_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Customize Vehicle"</label>
							<div class="col-md-6">
								<input name="vdp_customizevehicle_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['customizevehicle'] ?>" type="text" id="vdp_customizevehicle_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Complete Registration"</label>
							<div class="col-md-6">
								<input name="vdp_completeregistration_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['completeregistration'] ?>" type="text" id="vdp_completeregistration_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Initiate Checkout"</label>
							<div class="col-md-6">
								<input name="vdp_initiatecheckout_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['initiatecheckout'] ?>" type="text" id="vdp_initiatecheckout_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Added Payment Info"</label>
							<div class="col-md-6">
								<input name="vdp_addedpaymentinfo_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['addedpaymentinfo'] ?>" type="text" id="vdp_addedpaymentinfo_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Purchase"</label>
							<div class="col-md-6">
								<input name="vdp_purchase_selector" value="<?= $config_unserialize['vdp']['fbq_selectors']['purchase'] ?>" type="text" id="vdp_purchase_selector" class="form-control">
							</div>
						</div>

						<hr>
						<strong>SRP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="srp_install_fbq">Install facebook Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_install_fbq" value="true" type="checkbox"
										   id="srp_install_fbq" <?= $config_unserialize['srp']['install_fbq'] ? 'checked' : '' ?> >
									<label for="srp_install_fbq"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Facebook Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="pageview" type="checkbox"
										   id="srp_pageview" <?= in_array('pageview', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="smedialead" type="checkbox"
										   id="srp_smedialead" <?= in_array('smedialead', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_smedialead">Smedia Lead</span></</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="lead" type="checkbox"
										   id="srp_lead" <?= in_array('lead', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_lead">Lead (FORMs)</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="search" type="checkbox"
										   id="srp_search" <?= in_array('search', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_search">Search</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="scheduletestdrive" type="checkbox" id="srp_scheduletestdrive" <?= in_array('scheduletestdrive', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_scheduletestdrive">Schedule Test Drive</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="addtowishlist" type="checkbox"
										   id="srp_addtowishlist" <?= in_array('addtowishlist', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_addtowishlist">Add To Wishlist</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="contactus" type="checkbox"
										   id="srp_contactus" <?= in_array('contactus', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_contactus">Contact Us</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_fbq[]" value="findlocation" type="checkbox"
										   id="srp_findlocation" <?= in_array('findlocation', $config_unserialize['srp']['fbq']) ? 'checked' : '' ?> >
									<label for="srp_findlocation">Find Location</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for FORMs (Lead)</label>
							<div class="col-md-6">
								<input name="srp_lead_selector" value="<?= $config_unserialize['srp']['fbq_selectors']['lead'] ?>" type="text" id="srp_lead_selector" class="form-control">
							</div>
							<span class="alert alert-info">This selector is optional.</span>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Search"</label>
							<div class="col-md-6">
								<input name="srp_search_selector" value="<?= $config_unserialize['srp']['fbq_selectors']['search'] ?>" type="text" id="srp_search_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Add To Wishlist"</label>
							<div class="col-md-6">
								<input name="srp_addtowishlist_selector" value="<?= $config_unserialize['srp']['fbq_selectors']['addtowishlist'] ?>" type="text" id="srp_search_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Schedule Test Drive"</label>
							<div class="col-md-6">
								<input name="srp_scheduletestdrive_selector" value="<?= $config_unserialize['srp']['fbq_selectors']['scheduletestdrive'] ?>" type="text" id="srp_scheduletestdrive_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Contact Us"</label>
							<div class="col-md-6">
								<input name="srp_contactus_selector" value="<?= $config_unserialize['srp']['fbq_selectors']['contactus'] ?>" type="text" id="srp_contactus_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Find Location"</label>
							<div class="col-md-6">
								<input name="srp_findlocation_selector" value="<?= $config_unserialize['srp']['fbq_selectors']['findlocation'] ?>" type="text" id="srp_findlocation_selector" class="form-control">
							</div>
						</div>

						<hr>
						<strong>Thank You Page</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ty_install_fbq">Install facebook Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_install_fbq" value="true" type="checkbox"
										   id="ty_install_fbq" <?= $config_unserialize['ty']['install_fbq'] ? 'checked' : '' ?> >
									<label for="ty_install_fbq"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Facebook Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_fbq[]" value="pageview" type="checkbox"
										   id="ty_pageview" <?= in_array('pageview', $config_unserialize['ty']['fbq']) ? 'checked' : '' ?> >
									<label for="ty_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="ty_fbq[]" value="smedialead" type="checkbox"
										   id="srp_smedialead" <?= in_array('smedialead', $config_unserialize['typ']['fbq']) ? 'checked' : '' ?> >
									<label for="ty_smedialead">Smedia Lead</span></</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="ty_fbq[]" value="lead" type="checkbox"
										   id="ty_lead" <?= in_array('lead', $config_unserialize['ty']['fbq']) ? 'checked' : '' ?> >
									<label for="ty_lead">Lead (FORMs)</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for FORMs (Lead)</label>
							<div class="col-md-6">
								<input name="ty_lead_selector" value="<?= $config_unserialize['ty']['fbq_selectors']['lead'] ?>" type="text" id="ty_lead_selector" class="form-control">
							</div>
							<span class="alert alert-info">This selector is optional.</span>
						</div>

						<hr>
						<strong>Other Pages</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="other_install_fbq">Install facebook Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_install_fbq" value="true" type="checkbox"
										   id="other_install_fbq" <?= $config_unserialize['other']['install_fbq'] ? 'checked' : '' ?> >
									<label for="other_install_fbq"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Facebook Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_fbq[]" value="pageview" type="checkbox"
										   id="other_pageview" <?= in_array('pageview', $config_unserialize['other']['fbq']) ? 'checked' : '' ?> >
									<label for="other_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="other_fbq[]" value="smedialead" type="checkbox"
										   id="other_smedialead" <?= in_array('smedialead', $config_unserialize['other']['fbq']) ? 'checked' : '' ?> >
									<label for="other_smedialead">Smedia Lead</span></</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="other_fbq[]" value="lead" type="checkbox"
										   id="other_lead" <?= in_array('lead', $config_unserialize['other']['fbq']) ? 'checked' : '' ?> >
									<label for="other_lead">Lead (FORMs)</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="other_fbq[]" value="scheduletestdrive" type="checkbox" id="other_scheduletestdrive" <?= in_array('scheduletestdrive', $config_unserialize['other']['fbq']) ? 'checked' : '' ?> >
									<label for="other_scheduletestdrive">Schedule Test Drive</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="other_fbq[]" value="contactus" type="checkbox"
										   id="other_contactus" <?= in_array('contactus', $config_unserialize['other']['fbq']) ? 'checked' : '' ?> >
									<label for="other_contactus">Contact Us</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="other_fbq[]" value="findlocation" type="checkbox"
										   id="other_findlocation" <?= in_array('findlocation', $config_unserialize['other']['fbq']) ? 'checked' : '' ?> >
									<label for="other_findlocation">Find Location</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for FORMs (Lead)</label>
							<div class="col-md-6">
								<input name="other_lead_selector" value="<?= $config_unserialize['other']['fbq_selectors']['lead'] ?>" type="text" id="other_lead_selector" class="form-control">
							</div>
							<span class="alert alert-info">This selector is optional.</span>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Schedule Test Drive"</label>
							<div class="col-md-6">
								<input name="other_scheduletestdrive_selector" value="<?= $config_unserialize['other']['fbq_selectors']['scheduletestdrive'] ?>" type="text" id="other_scheduletestdrive_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Contact Us"</label>
							<div class="col-md-6">
								<input name="other_contactus_selector" value="<?= $config_unserialize['other']['fbq_selectors']['contactus'] ?>" type="text" id="other_contactus_selector" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Query selector for "Find Location"</label>
							<div class="col-md-6">
								<input name="other_findlocation_selector" value="<?= $config_unserialize['other']['fbq_selectors']['findlocation'] ?>" type="text" id="other_findlocation_selector" class="form-control">
							</div>
						</div>

						<hr>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<button class="btn btn-primary pull-left" name="btn" value="update-config">Update Facebook Config</button>
							</div>
						</div>

					</form>
					<?php
				} else {
					echo "<h3> No facebook Id Found. Please Add the Facebook id first.</h3>";
				}
				?>

			</div>
		</section>
	</div>
	<div class="col-md-3">
		<section class="panel panel-featured panel-featured-primary">
			<header class="panel-heading">
				<h2 class="panel-title">facebook Ids</h2>
			</header>
			<div class="panel-body">
				<?php
				if ($save_new && $type == 'facebook') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> New Facebook Pixel Id save.
					</div>
					<?php
				} else if ($delete_con && $type == 'facebook') {
					?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> Config Delete Successfully.
					</div>
					<?php
				}

				if (count($account_ids)) {
					?>
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>Id</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($account_ids as $account_id) {
							?>
							<tr>
								<td><?= $account_id->account_id ?></td>
								<td><?= $account_id->active ? 'Active' : 'Inactive' ?></td>
								<td>
									<button class="open-homeEvents btn btn-danger" data-id="<?= $account_id->id ?>" data-acc_id="<?= $account_id->account_id ?>"  data-type="Facebook Pixel" data-toggle="modal" data-target="#modalDelete" ><i
											class="fas fa-trash-alt"></i></button>

								</td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
					<?php
				}
				?>

				<div style="margin-top: 30px">
					<a class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#modalfacebook"><i
							class="fas fa-plus"></i> Add New</a>

					<div class="modal fade " id="modalfacebook" tabindex="-1" role="dialog"
						 aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Add New Facebook Pixel ID</h4>
								</div>
								<form method="post" class="form-horizontal">
									<div class="modal-body">

										<div class="form-group mt-lg">
											<div class="col-sm-8  col-sm-offset-2">
												<input type="hidden" name="type" value="facebook">
												<input type="text" name="new_id" class="form-control"
													   placeholder="Type Facebook Pixel ID..." required/>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button class="btn btn-primary" name="btn" value="new">Submit</button>
										<button class="btn btn-default" data-dismiss="modal">Close
										</button>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="panel panel-featured panel-featured-primary">
			<header class="panel-heading">
				<h2 class="panel-title">Lead Event (FORMs Submission)</h2>
			</header>
			<div class="panel-body">
				<p class="alert alert-info">Lead Event (FORMs Submission): Include this event to track lower funnel actions or hard leads (where contact info is submitted) such as: Brochure requests, Test drive requests, (or other types of appointment requests), Personalized finance or part exchange quotes, Dealer inventory inquiries. This event should track all form submissions which include users email or phone no or both.</p>
			</div>
		</section>
	</div>
</div>