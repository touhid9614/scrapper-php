<?php

global $cron_name;

$account_ids = get_account_id($cron_name, 'analytics');
$link        = "?dealership={$cron_name}&type=analytics&id=";
$firstKey    = array_key_first($account_ids);

if ($type == 'analytics') {
    $data_id = (empty($id) && count($account_ids)) ? $account_ids[$firstKey]->account_id : $id;
} else {
    $data_id = count($account_ids) ? $account_ids[$firstKey]->account_id : '';
}

$selected_account_config = $account_ids[$data_id];
$config_unserialize      = unserialize($selected_account_config->config);

$all_gaccs   = get_analytics_accounts();
$ga_infos    = get_analytics_account_info($cron_name);
$ga_acc      = $ga_infos['analytics_account'];
$profile_id  = $ga_infos['profile_id'];
$ana_acc_id  = $ga_infos['ana_acc_id'];
$ana_view_id = $ga_infos['ana_view_id'];
?>

<div class="row">
	<div class="col-md-8">
		<section class="panel panel-featured panel-featured-success">
			<header class="panel-heading">
				<h2 class="panel-title">Analytics Config</h2>
			</header>
			<div class="panel-body">

				<?php
				if (count($account_ids)) {
					if ($update_con && $type == 'analytics') {
						?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<strong>Success!!</strong> Update Analytics web property setting.
						</div>
						<?php
					}
					?>
					<form class="form-horizontal" method="post">
						<input type="hidden" name="type" value="analytics">
						<input type="hidden" name="id" value="<?= $data_id ?>">
						<input type="hidden" name="db_id" value="<?= $selected_account_config->id ?>">
						<div class="form-group">
							<label class="col-md-3 control-label" for="analytics_account">Analytics Account</label>
							<div class="col-md-6">
								<select id="analytics_account" name="analytics_account"
                                        title="Please select dealership analytics account"
                                        class="form-control populate sMedia_dropdown">
                                    <option value="">Choose Account</option>
                                    <?php
                                    foreach ($all_gaccs as $my_gac) {
                                        ?>
                                        <option value="<?= $my_gac ?>" <?= $ga_acc == $my_gac ? 'selected=""' : '' ?>><?= $my_gac ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ana_acc_id">Analytics Account ID</label>
							<div class="col-md-6">
								<input type="text" id="ana_acc_id" name="ana_acc_id"
								class="form-control"
								placeholder="123456789" value="<?= $ana_acc_id ?>"
								data-current="<?= $ana_acc_id ?>"
								maxlength="20" data-toggle="popover" data-placement="bottom"
								data-trigger="hover"
								data-content="Enter analytics account id.">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ana_view_id">Analytics View ID</label>
							<div class="col-md-6">
								<input type="text" id="ana_view_id" name="ana_view_id"
								class="form-control"
								placeholder="123456789" value="<?= $ana_view_id ?>"
								data-current="<?= $ana_view_id ?>"
								maxlength="20" data-toggle="popover" data-placement="bottom"
								data-trigger="hover"
								data-content="Enter analytics view id.">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="profile_id">Profile ID</label>
							<div class="col-md-6">
								<input type="text" id="profile_id" name="profile_id"
								class="form-control"
								placeholder="123456789" value="<?= $profile_id ?>"
								data-current="<?= $profile_id ?>"
								maxlength="20" data-toggle="popover" data-placement="bottom"
								data-trigger="hover"
								data-content="Enter analytics profile id.">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Analytics ID</label>
							<div class="col-md-6">
								<div class="btn-group">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-default dropdown-toggle"
										data-toggle="dropdown">
										<?= $data_id ?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<?php
										foreach ($account_ids as $key => $account_id) {
											$acc_id = $account_id->account_id;
											$class = (($key == $data_id && $type == 'analytics') ? 'active' : '');
											?>
											<li class="<?= ($data_id && $type == 'analytics') ? $class : '' ?>"><a
													href="<?= $link . $key ?>"><?= $key ?></a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="install_analytics">Install Analytics</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-success">
									<input name="install_tag" type="checkbox" value="true"
										   id="install_analytics" <?= $selected_account_config->active ? 'checked' : '' ?> >
									<label for="install_analytics"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>VDP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_install_analytics">Install Analytics</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_install_analytics" value="true" type="checkbox" id="vdp_install_analytics" <?= $config_unserialize['vdp']['install_analytics'] ? 'checked' : '' ?>>
									<label for="vdp_install_analytics"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Analytics Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_ga[]" value="pageview" type="checkbox"
										   id="vdp_pageview" <?= in_array('pageview', $config_unserialize['vdp']['ga']) ? 'checked' : '' ?> >
									<label for="vdp_pageview">Page View</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_profitable_engagement">Profitable Engagement</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_profitable_engagement" value="true" type="checkbox"
										   id="vdp_profitable_engagement" <?= $config_unserialize['vdp']['profitable_engagement'] ? 'checked' : '' ?> >
									<label for="vdp_profitable_engagement"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_scroll_depth">Scroll Depth</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_scroll_depth" value="true" type="checkbox"
										   id="vdp_scroll_depth" <?= $config_unserialize['vdp']['scroll_depth'] ? 'checked' : '' ?> >
									<label for="vdp_scroll_depth"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>SRP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="srp_install_analytics">Install Analytics</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_install_analytics" value="true" type="checkbox"
										   id="srp_install_analytics" <?= $config_unserialize['srp']['install_analytics'] ? 'checked' : '' ?> >
									<label for="srp_install_analytics"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Analytics Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_ga[]" value="pageview" type="checkbox"
										   id="srp_pageview" <?= in_array('pageview', $config_unserialize['srp']['ga']) ? 'checked' : '' ?> >
									<label for="srp_pageview">Page View</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="srp_scroll_depth">Scroll Depth</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_scroll_depth" value="true" type="checkbox"
										   id="srp_scroll_depth" <?= $config_unserialize['srp']['scroll_depth'] ? 'checked' : '' ?> >
									<label for="srp_scroll_depth"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>Thank You Page</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ty_install_analytics">Install Analytics</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_install_analytics" value="true" type="checkbox"
										   id="ty_install_analytics" <?= $config_unserialize['ty']['install_analytics'] ? 'checked' : '' ?> >
									<label for="ty_install_analytics"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Analytics Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_ga[]" value="pageview" type="checkbox"
										   id="ty_pageview" <?= in_array('pageview', $config_unserialize['ty']['ga']) ? 'checked' : '' ?> >
									<label for="ty_pageview">Page View</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ty_scroll_depth">Scroll Depth</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_scroll_depth" value="true" type="checkbox"
										   id="ty_scroll_depth" <?= $config_unserialize['ty']['scroll_depth'] ? 'checked' : '' ?> >
									<label for="ty_scroll_depth"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>Other Pages</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="other_install_analytics">Install
								Analytics</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_install_analytics" value="true" type="checkbox"
										   id="other_install_analytics" <?= $config_unserialize['other']['install_analytics'] ? 'checked' : '' ?> >
									<label for="other_install_analytics"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Analytics Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_ga[]" value="pageview" type="checkbox"
										   id="other_pageview" <?= in_array('pageview', $config_unserialize['other']['ga']) ? 'checked' : '' ?> >
									<label for="other_pageview">Page View</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="other_scroll_depth">Scroll Depth</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_scroll_depth" value="true" type="checkbox"
										   id="other_scroll_depth" <?= $config_unserialize['other']['scroll_depth'] ? 'checked' : '' ?> >
									<label for="other_scroll_depth"></label>
								</div>
							</div>
						</div>


						<hr>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<button class="btn btn-primary pull-left" name="btn" value="update-config">Update Analytics Config</button>
							</div>
						</div>
					</form>
					<?php
				} else {
					echo "<h3> No Analytics Id Found. Please Add the Analytics id first.</h3>";
				}
				?>
			</div>
		</section>
	</div>

	<div class="col-md-4">
		<section class="panel panel-featured panel-featured-primary">
			<header class="panel-heading">
				<h2 class="panel-title">Analytics Ids</h2>
			</header>
			<div class="panel-body">
				<?php
				if ($save_new && $type == 'analytics') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> New Analytics web property id save.
					</div>
					<?php
				} else if ($delete_con && $type == 'analytics') {
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
						foreach ($account_ids as $key =>$account_id) {

							$style = (($key == $data_id) ? 'background: #d6f5ff;' : '');
							?>
							<tr style="<?= $style ?>">
								<td><?= $account_id->account_id ?></td>
								<td><?= $account_id->active ? 'Active' : 'Inactive' ?></td>
								<td> <button class="open-homeEvents btn btn-danger" data-id="<?= $account_id->id ?>" data-acc_id="<?= $account_id->account_id ?>"  data-type="Analytics" data-toggle="modal" data-target="#modalDelete" ><i class="fas fa-trash-alt"></i></button>
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
					<a class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#modalAnalytics"><i class="fas fa-plus"></i> Add New</a>

					<div class="modal fade " id="modalAnalytics" tabindex="-1" role="dialog"
						 aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Add New Analytics Web Property ID</h4>
								</div>
								<form method="post" class="form-horizontal">
									<div class="modal-body">
										<div class="form-group mt-lg">
											<div class="col-sm-8  col-sm-offset-2">
												<input type="hidden" name="type" value="analytics">
												<input type="text" name="new_id" class="form-control"
													   placeholder="Type Analytics Id..." required/>
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