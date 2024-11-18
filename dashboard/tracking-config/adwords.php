<?php

global $cron_name;

$account_id 		= get_account_id($cron_name, 'adwords');
$config_unserialize = unserialize($account_id->config);
?>

<div class="row">
	<div class="col-md-12">

		<section class="panel panel-featured panel-featured-success">
			<header class="panel-heading">
				<h2 class="panel-title">Adwords Conversion</h2>
			</header>
			<div class="panel-body">
				<?php

				if ($update_con && $type == 'adwords') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> Adwords Conversion Update
					</div>
					<?php
				} else if ($save_new && $type == 'google') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> Adwords Conversion Added.
					</div>
					<?php
				}
				?>
				<form class="form-horizontal" method="post">
					<div class="form-group">
						<label class="col-md-2 control-label" for="adw_acc_id">Adwords Account ID</label>
						<div class="col-md-8">
							<input type="text" id="adw_acc_id" name="adw_acc_id"
							class="form-control"
							placeholder="123456789" value="<?= $adw_acc_id ?>"
							data-current="<?= $adw_acc_id ?>"
							maxlength="20" data-toggle="popover" data-placement="bottom"
							data-trigger="hover"
							data-content="Enter adwords account id.">
						</div>
					</div>

					<input type="hidden" name="db_id" value="<?= count($account_id) ? $account_id->id : false ?>">
					<strong>VDP</strong>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Id</label>
						<div class="col-md-8">
							<input name="vdp_adwords_conversion_id" class="form-control" type="text"
								   value="<?= $config_unserialize['vdp']['adwords_conversion_id'] ?>"
								   placeholder="Conversion ID"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Label</label>
						<div class="col-md-8">
							<input name="vdp_adwords_conversion_label" class="form-control" type="text"
								   value="<?= $config_unserialize['vdp']['adwords_conversion_label'] ?>"
								   placeholder="Conversion Label"/>
						</div>
					</div>

					<hr>
					<strong>SRP</strong>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Id</label>
						<div class="col-md-8">
							<input name="srp_adwords_conversion_id" class="form-control" type="text"
								   value="<?= $config_unserialize['srp']['adwords_conversion_id'] ?>"
								   placeholder="Conversion ID"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Label</label>
						<div class="col-md-8">
							<input name="srp_adwords_conversion_label" class="form-control" type="text" value="<?= $config_unserialize['srp']['adwords_conversion_label'] ?>" placeholder="Conversion Label"/>
						</div>
					</div>

					<hr>
					<strong>Thank You Page</strong>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Id</label>
						<div class="col-md-8">
							<input name="ty_adwords_conversion_id" class="form-control" type="text"
								   value="<?= $config_unserialize['ty']['adwords_conversion_id'] ?>"
								   placeholder="Conversion ID"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Label</label>
						<div class="col-md-8">
							<input name="ty_adwords_conversion_label" class="form-control" type="text"
								   value="<?= $config_unserialize['ty']['adwords_conversion_label'] ?>"
								   placeholder="Conversion Label"/>
						</div>
					</div>

					<hr>
					<strong>Other Pages</strong>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Id</label>
						<div class="col-md-8">
							<input name="other_adwords_conversion_id" class="form-control" type="text"
								   value="<?= $config_unserialize['other']['adwords_conversion_id'] ?>"
								   placeholder="Conversion ID"/>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Adwords Conversion Label</label>
						<div class="col-md-8">
							<input name="other_adwords_conversion_label" class="form-control" type="text" value="<?= $config_unserialize['other']['adwords_conversion_label'] ?>" placeholder="Conversion Label"/>
						</div>
					</div>

					<hr>
					<div class="form-group">
						<label class="col-md-2 control-label"></label>
						<div class="col-md-6">
							<button class="btn btn-primary pull-left" name="btn" value="adwords_conversion">Update Adwords Conversion</button>
						</div>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>