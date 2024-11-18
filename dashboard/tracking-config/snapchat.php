<?php

global $cron_name;

$account_ids = get_account_id($cron_name, 'snapchat');
$link 		 = "?dealership=$cron_name&type=snapchat&id=";
$firstKey 	 = array_key_first($account_ids);

if ($type == 'snapchat') {
	$data_id = (empty($id) && count($account_ids)) ? $account_ids[$firstKey]->account_id : $id;
} else {
	$data_id = count($account_ids) ? $account_ids[$firstKey]->account_id : '';
}

$selected_account_config = $account_ids[$data_id];
$config_unserialize 	 = unserialize($selected_account_config->config);
?>

<div class="row">
	<div class="col-md-8">
		<section class="panel panel-featured panel-featured-success">
			<header class="panel-heading">
				<h2 class="panel-title">SnapChat Config</h2>
			</header>
			<div class="panel-body">

				<?php
				if (count($account_ids)) {
					if ($update_con && $type == 'snapchat') {
						?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<strong>Success!!</strong> Update Snapchat Pixel setting.
						</div>
						<?php
					}
					?>
					<form class="form-horizontal" method="post">
						<input type="hidden" name="type" value="snapchat">
						<input type="hidden" name="id" value="<?= $data_id ?>">
						<input type="hidden" name="db_id" value="<?= $selected_account_config->id ?>">
						<div class="form-group">
							<label class="col-md-3 control-label">SnapChat Pixel ID</label>
							<div class="col-md-6">
								<div class="btn-group">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-default dropdown-toggle"
											data-toggle="dropdown"><?= $data_id ?> <span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu">
										<?php
										foreach ($account_ids as $account_id) {
											$acc_id = $account_id->account_id;
											$class = (($acc_id == $data_id && $type == 'snapchat') ? 'active' : '');
											?>
											<li class="<?= ($data_id && $type == 'snapchat') ? $class : '' ?>">
												<a href="<?= $link . $acc_id ?>"><?= $acc_id ?></a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="install_snapchat">Install Snapchat Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-success">
									<input name="install_tag" value="true" type="checkbox"
										   id="install_snapchat" <?= $selected_account_config->active ? 'checked' : '' ?> >
									<label for="install_snapchat"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>VDP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_install_snapchat">Install Snapchat Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_install_snapchat" value="true" type="checkbox"
									id="vdp_install_snapchat" <?= $config_unserialize['vdp']['install_snapchat'] ? 'checked' : '' ?> >
									<label for="vdp_install_snapchat"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="pageview" type="checkbox" id="vdp_pageview" <?= in_array('pageview', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="viewcontent" type="checkbox" id="vdp_viewcontent" <?= in_array('viewcontent', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_viewcontent">View Content</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="purchase" type="checkbox" id="vdp_purchase" <?= in_array('purchase', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_purchase">Purchase</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="save" type="checkbox" id="vdp_save" <?= in_array('save', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_save">Save</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="startcheckout" type="checkbox" id="vdp_startcheckout" <?= in_array('startcheckout', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_startcheckout">Start Checkout</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="addcart" type="checkbox" id="vdp_addcart" <?= in_array('addcart', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_addcart">Add To Cart</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="openapp" type="checkbox" id="vdp_openapp" <?= in_array('openapp', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_openapp">Open App</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="addbilling" type="checkbox" id="vdp_addbilling" <?= in_array('addbilling', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?>>
									<label for="vdp_addbilling">Add Billing</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="signup" type="checkbox" id="vdp_signup" <?= in_array('signup', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_signup">Sign Up</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="subscribe" type="checkbox" id="vdp_subscribe" <?= in_array('subscribe', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_subscribe">Subscribe</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="adclick" type="checkbox" id="vdp_adclick" <?= in_array('adclick', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_adclick">Ad Click</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="adview" type="checkbox" id="vdp_adview" <?= in_array('adview', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_adview">Ad View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="completetutorial" type="checkbox" id="vdp_completetutorial" <?= in_array('completetutorial', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_completetutorial">Complete Tutorial</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="invite" type="checkbox" id="vdp_invite" <?= in_array('invite', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_invite">Invite</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="login" type="checkbox" id="vdp_login" <?= in_array('login', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_login">login</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="share" type="checkbox" id="vdp_share" <?= in_array('share', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_share">Share</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="reserve" type="checkbox" id="vdp_reserve" <?= in_array('reserve', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_reserve">Reserve</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="achievementunlocked" type="checkbox" id="vdp_achievementunlocked" <?= in_array('achievementunlocked', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_achievementunlocked">Achievement Unlocked</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="addtowishist" type="checkbox" id="vdp_addtowishist" <?= in_array('addtowishist', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_addtowishist">Add To Wishist</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="spentcredits" type="checkbox" id="vdp_spentcredits" <?= in_array('spentcredits', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_spentcredits">Spent Credits</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="rate" type="checkbox" id="vdp_rate" <?= in_array('rate', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_rate">Rate</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="starttrial" type="checkbox" id="vdp_starttrial" <?= in_array('starttrial', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_starttrial">Start Trial</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="vdp_snapchat_events[]" value="listview" type="checkbox" id="vdp_listview" <?= in_array('listview', $config_unserialize['vdp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="vdp_listview">List View</label>
								</div>
							</div>
						</div>

						<hr>
						<strong>SRP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="srp_install_snapchat">Install Snapchat Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_install_snapchat" value="true" type="checkbox"
										   id="srp_install_snapchat" <?= $config_unserialize['srp']['install_snapchat'] ? 'checked' : '' ?> >
									<label for="srp_install_snapchat"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_snapchat_events[]" value="pageview" type="checkbox" id="srp_pageview" <?= in_array('pageview', $config_unserialize['srp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="srp_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="srp_snapchat_events[]" value="search" type="checkbox" id="srp_search" <?= in_array('search', $config_unserialize['srp']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="srp_search">Search</label>
								</div>
							</div>
						</div>

						<hr>
						<strong>Thank You Page</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ty_install_snapchat">Install Snapchat Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_install_snapchat" value="true" type="checkbox"
										   id="ty_install_snapchat" <?= $config_unserialize['ty']['install_snapchat'] ? 'checked' : '' ?> >
									<label for="ty_install_snapchat"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_snapchat_events[]" value="pageview" type="checkbox" id="ty_pageview" <?= in_array('pageview', $config_unserialize['ty']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="ty_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="ty_snapchat_events[]" value="viewcontent" type="checkbox" id="ty_viewcontent" <?= in_array('viewcontent', $config_unserialize['ty']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="ty_viewcontent">View Content</label>
								</div>
							</div>
						</div>

						<hr>
						<strong>Other Pages</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="other_install_snapchat">Install Snapchat Pixel</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_install_snapchat" value="true" type="checkbox"
										   id="other_install_snapchat" <?= $config_unserialize['other']['install_snapchat'] ? 'checked' : '' ?> >
									<label for="other_install_snapchat"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_snapchat_events[]" value="pageview" type="checkbox" id="other_pageview" <?= in_array('pageview', $config_unserialize['other']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="other_pageview">Page View</label>
								</div>

								<div class="checkbox-custom checkbox-default">
									<input name="other_snapchat_events[]" value="viewcontent" type="checkbox" id="other_viewcontent" <?= in_array('viewcontent', $config_unserialize['other']['snapchat_events']) ? 'checked' : '' ?> >
									<label for="other_viewcontent">View Content</label>
								</div>
							</div>
						</div>

						<hr>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<button class="btn btn-primary" name="btn" value="update-config">Update Snapchat Config</button>
							</div>
						</div>

					</form>
					<?php
				} else {
					echo "<h3> No Snapchat Id Found. Please Add the Snapchat id first.</h3>";
				}
				?>
			</div>
		</section>

	</div>
	<div class="col-md-4">
		<section class="panel panel-featured panel-featured-primary">
			<header class="panel-heading">
				<h2 class="panel-title">Snapchat Ids</h2>
			</header>
			<div class="panel-body">
				<?php
				if ($save_new && $type == 'snapchat') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> New Snapchat id save.
					</div>
					<?php
				}  else if ($delete_con && $type == 'snapchat') {
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
							<th></th>
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
									<button class="open-homeEvents btn btn-danger" data-id="<?= $account_id->id ?>" data-acc_id="<?= $account_id->account_id ?>"  data-type="SnapChat Pixel" data-toggle="modal" data-target="#modalDelete" >
										<i class="fas fa-trash-alt"></i>
									</button>
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
					<a class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#modalsnapchat">
						<i class="fas fa-plus"></i> Add New</a>

					<div class="modal fade " id="modalsnapchat" tabindex="-1" role="dialog"
						 aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Add New Snapchat Pixel ID</h4>
								</div>
								<form method="post" class="form-horizontal">
									<div class="modal-body">

										<div class="form-group mt-lg">
											<div class="col-sm-8  col-sm-offset-2">
												<input type="hidden" name="type" value="snapchat">
												<input type="text" name="new_id" class="form-control"
													   placeholder="Type snapchat Pixel ID..." required/>
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
	</div>
</div>
