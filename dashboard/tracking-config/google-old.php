<?php

global $cron_name;

$account_ids = get_account_id($cron_name, 'google');

$link = "?dealership=$cron_name&type=google&id=";
$firstKey = array_key_first($account_ids);
if ($type == 'google') {
	$data_id = (empty($id) && count($account_ids)) ? $account_ids[$firstKey]->account_id : $id;
} else {
	$data_id = count($account_ids) ? $account_ids[$firstKey]->account_id : '';
}

$selected_account_config = $account_ids[$data_id];
$config_unserialize = unserialize($selected_account_config->config);
?>

<div class="row">
	<div class="col-md-8">

		<section class="panel panel-featured panel-featured-success">
			<header class="panel-heading">
				<h2 class="panel-title">Google\Adwords Config</h2>
			</header>
			<div class="panel-body">

				<?php
				if (count($account_ids)) {
					if ($update_con && $type == 'google') {
						?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<strong>Success!!</strong> Update Adwords Config setting.
						</div>
						<?php
					}
					?>
					<form class="form-horizontal" method="post">
						<input type="hidden" name="type" value="google">
						<input type="hidden" name="id" value="<?= $data_id ?>">
						<input type="hidden" name="db_id" value="<?= $selected_account_config->id ?>">
						<div class="form-group">
							<label class="col-md-3 control-label">Adwords Tracking ID</label>
							<div class="col-md-6">
								<div class="btn-group">
									<button type="button" class="mb-xs mt-xs mr-xs btn btn-default dropdown-toggle"
											data-toggle="dropdown"><?= $data_id ?> <span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu">
										<?php
										foreach ($account_ids as $account_id) {
											$acc_id = $account_id->account_id;
											$class = (($acc_id == $data_id && $type == 'google') ? 'active' : '');
											?>
											<li class="<?= ($data_id && $type == 'google') ? $class : '' ?>"><a
													href="<?= $link . $acc_id ?>"><?= $acc_id ?></a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="install_adwords">Install Adwords Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-success">
									<input name="install_tag" value="true" type="checkbox"
										   id="install_adwords" <?= $selected_account_config->active ? 'checked' : '' ?> >
									<label for="install_adwords"></label>
								</div>
							</div>
						</div>

						<?php
						//	echo "<pre>";
						//	print_r($selected_account_config);
						//	$config_un= unserialize($selected_account_config->config);
						//	print_r($config_un);
						//	echo "</pre>";
						?>

						<hr>
						<b>VDP</b>

						<div class="form-group">
							<label class="col-md-3 control-label" for="vdp_install_adwords">Install Adwords Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="vdp_install_adwords" value="true" type="checkbox"
										   id="vdp_install_adwords" <?= $config_unserialize['vdp']['install_adwords'] ? 'checked' : '' ?> >
									<label for="vdp_install_adwords"></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Id</label>
							<div class="col-md-6">
								<input name="vdp_adwords_conversion_id" class="form-control" type="text"
									   value="<?php echo $config_unserialize['vdp']['adwords_conversion_id'] ?>"
									   placeholder="Conversion ID"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Label</label>
							<div class="col-md-6">
								<input name="vdp_adwords_conversion_label" class="form-control" type="text"
									   value="<?php echo $config_unserialize['vdp']['adwords_conversion_label'] ?>"
									   placeholder="Conversion Label"/>
							</div>
						</div>


						<hr>
						<b>Thank You Page</b>

						<div class="form-group">
							<label class="col-md-3 control-label" for="ty_install_adwords">Install Adwords Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="ty_install_adwords" value="true" type="checkbox"
										   id="ty_install_adwords" <?= $config_unserialize['ty']['install_adwords'] ? 'checked' : '' ?> >
									<label for="ty_install_adwords"></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Id</label>
							<div class="col-md-6">
								<input name="ty_adwords_conversion_id" class="form-control" type="text"
									   value="<?php echo $config_unserialize['ty']['adwords_conversion_id'] ?>"
									   placeholder="Conversion ID"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Label</label>
							<div class="col-md-6">
								<input name="ty_adwords_conversion_label" class="form-control" type="text"
									   value="<?php echo $config_unserialize['ty']['adwords_conversion_label'] ?>"
									   placeholder="Conversion Label"/>
							</div>
						</div>

						<hr>
						<b>Other Pages</b>

						<div class="form-group">
							<label class="col-md-3 control-label" for="other_install_adwords">Install Adwords Tracking</label>
							<div class="col-md-6">
								<div class="checkbox-custom checkbox-default">
									<input name="other_install_adwords" value="true" type="checkbox"
										   id="other_install_adwords" <?= $config_unserialize['other']['install_adwords'] ? 'checked' : '' ?> >
									<label for="other_install_adwords"></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Id</label>
							<div class="col-md-6">
								<input name="other_adwords_conversion_id" class="form-control" type="text"
									   value="<?php echo $config_unserialize['other']['adwords_conversion_id'] ?>"
									   placeholder="Conversion ID"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Label</label>
							<div class="col-md-6">
								<input name="other_adwords_conversion_label" class="form-control" type="text"
									   value="<?php echo $config_unserialize['other']['adwords_conversion_label'] ?>"
									   placeholder="Conversion Label"/>
							</div>
						</div>


						<hr>
						<div class="form-group">
							<label class="col-md-3 control-label"></label>
							<div class="col-md-6">
								<button class="btn btn-primary" name="btn" value="update-config">Update Config</button>
							</div>
						</div>

					</form>
					<?php
				} else {
					echo "<h3> No Adwords Id Found. Please Add the Adwords id first.</h3>";
				}
				?>

			</div>
		</section>

	</div>
	<div class="col-md-4">
		<section class="panel panel-featured panel-featured-primary">
			<header class="panel-heading">
				<h2 class="panel-title">Google Ids</h2>
			</header>
			<div class="panel-body">
				<?php
				if ($save_new && $type == 'google') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> New Adwords id save.
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
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($account_ids as $account_id) {
							?>
							<tr>
								<td><?= $account_id->account_id ?></td>
								<td><?= $account_id->active ? 'Active' : 'Inactive' ?></td>
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
					<a class="mb-xs mt-xs mr-xs btn btn-primary" data-toggle="modal" data-target="#modalAdwords"><i
							class="fas fa-plus"></i> Add New</a>

					<div class="modal fade " id="modalAdwords" tabindex="-1" role="dialog"
						 aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Add New Adwords Tracking ID</h4>
								</div>
								<form method="post" class="form-horizontal">
									<div class="modal-body">

										<div class="form-group mt-lg">
											<div class="col-sm-8  col-sm-offset-2">
												<input type="hidden" name="type" value="google">
												<input type="text" name="new_id" class="form-control"
													   placeholder="Type Adwords Tracking ID..." required/>
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



