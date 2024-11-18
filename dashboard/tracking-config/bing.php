<?php

global $cron_name;

$account_ids = get_account_id($cron_name, 'bing');
$link 		 = "?dealership=$cron_name&type=bing&id=";
$firstKey 	 = array_key_first($account_ids);

if ($type == 'bing') {
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
				<h2 class="panel-title">Bing Config</h2>
			</header>
			<div class="panel-body">

				<?php
				if (count($account_ids)) {
					if ($update_con && $type == 'bing') {
						?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<strong>Success!!</strong> Update Bing Config setting.
						</div>
						<?php
					}
					?>
					<form class="form-horizontal" method="post">
						<input type="hidden" name="type" value="bing">
						<input type="hidden" name="id" value="<?= $data_id ?>">
						<input type="hidden" name="db_id" value="<?= $selected_account_config->id ?>">
						<div class="form-group">
							<label class="col-md-3 control-label">Bing Tracking ID</label>
							<div class="col-md-6">
								<div class="btn-group">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-default dropdown-toggle" data-toggle="dropdown"><?= $data_id ?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<?php
										foreach ($account_ids as $account_id) {
											$acc_id = $account_id->account_id;
											$class = (($acc_id == $data_id && $type == 'bing') ? 'active' : '');
											?>
											<li class="<?= ($data_id && $type == 'bing') ? $class : '' ?>">
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
							<label class="col-md-3 control-label" for="install_bing">Install Bing Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-success">
									<input name="install_tag" value="true" type="checkbox"
										   id="install_bing" <?= $selected_account_config->active ? 'checked' : '' ?> >
									<label for="install_bing"></label>
								</div>
							</div>
						</div>

						<hr>
						<strong>VDP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_install_bing">Install Bing Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_install_bing" value="true" type="checkbox"
										   id="vdp_install_bing" <?= $config_unserialize['vdp']['install_bing'] ? 'checked' : '' ?> >
									<label for="vdp_install_bing"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_bing_events[]" value="bing_profitable_engagement" type="checkbox"
										   id="vdp_bing_events" <?= in_array('bing_profitable_engagement', $config_unserialize['vdp']['bing_events']) ? 'checked' : '' ?> >
									<label for="vdp_bing_events">Profitable Engagement</label>
								</div>
							</div>
						</div>

						<hr>
						<strong>SRP</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="srp_install_bing">Install Bing Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_install_bing" value="true" type="checkbox"
										   id="srp_install_bing" <?= $config_unserialize['srp']['install_bing'] ? 'checked' : '' ?> >
									<label for="srp_install_bing"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="srp_bing_events[]" value="bing_profitable_engagement" type="checkbox"
										   id="srp_bing_events" <?= in_array('bing_profitable_engagement', $config_unserialize['srp']['bing_events']) ? 'checked' : '' ?> >
									<label for="srp_bing_events">Profitable Engagement</label>
								</div>
							</div>
						</div>

						<hr>
						<strong>Thank You Page</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ty_install_bing">Install Bing Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_install_bing" value="true" type="checkbox"
										   id="ty_install_bing" <?= $config_unserialize['ty']['install_bing'] ? 'checked' : '' ?> >
									<label for="ty_install_bing"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_bing_events[]" value="bing_profitable_engagement" type="checkbox"
										   id="ty_bing_events" <?= in_array('bing_profitable_engagement', $config_unserialize['ty']['bing_events']) ? 'checked' : '' ?> >
									<label for="ty_bing_events">Profitable Engagement</label>
								</div>
							</div>
						</div>

						<hr>
						<strong>Other Pages</strong>

						<div class="form-group">
							<label class="col-md-3 control-label" for="other_install_bing">Install Bing Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_install_bing" value="true" type="checkbox"
										   id="other_install_bing" <?= $config_unserialize['other']['install_bing'] ? 'checked' : '' ?> >
									<label for="other_install_bing"></label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Event Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_bing_events[]" value="bing_profitable_engagement" type="checkbox"
										   id="other_bing_events" <?= in_array('bing_profitable_engagement', $config_unserialize['other']['bing_events']) ? 'checked' : '' ?> >
									<label for="other_bing_events">Profitable Engagement</label>
								</div>
							</div>
						</div>

						<hr>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<button class="btn btn-primary pull-left" name="btn" value="update-config">Update Bing Config</button>
							</div>
						</div>
					</form>
					<?php
				} else {
					echo "<h3> No Bing Id Found. Please Add the Bing id first.</h3>";
				}
				?>
			</div>
		</section>
	</div>

	<div class="col-md-4">
		<section class="panel panel-featured panel-featured-primary">
			<header class="panel-heading">
				<h2 class="panel-title">bing Ids</h2>
			</header>
			<div class="panel-body">
				<?php
				if ($save_new && $type == 'bing') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> New Bing id save.
					</div>
					<?php
				} else if ($delete_con && $type == 'bing') {
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
									<button class="open-homeEvents btn btn-danger" data-id="<?= $account_id->id ?>" data-acc_id="<?= $account_id->account_id ?>"  data-type="Bing Tracking" data-toggle="modal" data-target="#modalDelete" ><i class="fas fa-trash-alt"></i></button>
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
					<a class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#modalbing"><i
							class="fas fa-plus"></i> Add New</a>

					<div class="modal fade " id="modalbing" tabindex="-1" role="dialog"
						 aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Add New Bing Tracking ID</h4>
								</div>
								<form method="post" class="form-horizontal">
									<div class="modal-body">

										<div class="form-group mt-lg">
											<div class="col-sm-8  col-sm-offset-2">
												<input type="hidden" name="type" value="bing">
												<input type="text" name="new_id" class="form-control"
													   placeholder="Type bing Tracking ID..." required/>
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