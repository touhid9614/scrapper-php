<?php

global $cron_name;

$account_id 		= get_account_id($cron_name, 'additional');
$config_unserialize = unserialize($account_id->config);
?>

<div class="row">
	<div class="col-md-12">
		<section class="panel panel-featured panel-featured-success">
			<header class="panel-heading">
				<h2 class="panel-title">Additional Script</h2>
			</header>
			<div class="panel-body">
				<?php
				if ($update_con && $type == 'additional') {
					?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> Additional Script Update.
					</div>
				<?php
				} else if ($save_new && $type == 'additional') {
				?>
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>Success!!</strong> Additional Script Added.
					</div>
				<?php
				}
				?>
				<form class="form-horizontal" method="post">
					<input type="hidden" name="db_id" value="<?= count($account_id) ? $account_id->id : false ?>">
					<strong>VDP</strong>

					<div class="form-group">
						<label class="col-md-2 control-label" for="vdp_additional_scripts">Script Files</label>
						<div class="col-md-8">
							<textarea name="vdp_additional_scripts" class="form-control" rows="5"
									  placeholder="One per line"><?= implode("\n", $config_unserialize['vdp']['additional_scripts']) ?></textarea>
							<p><i>* One sccript url per line without comma</i></p>
						</div>
					</div>

					<hr>
					<strong>SRP</strong>

					<div class="form-group">
						<label class="col-md-2 control-label" for="srp_additional_scripts">Script Files</label>
						<div class="col-md-8">
							<textarea name="srp_additional_scripts" class="form-control" rows="5"
									  placeholder="One per line"><?= implode("\n", $config_unserialize['srp']['additional_scripts']) ?></textarea>
							<p><i>* One sccript url per line without comma</i></p>
						</div>
					</div>

					<hr>
					<strong>Thank You Page</strong>

					<div class="form-group">
						<label class="col-md-2 control-label" for="ty_additional_scripts">Script Files</label>
						<div class="col-md-8">
							<textarea name="ty_additional_scripts" class="form-control" rows="5"
									  placeholder="One per line"><?= implode("\n", $config_unserialize['ty']['additional_scripts']) ?></textarea>
							<p><i>* One sccript url per line without comma</i></p>
						</div>
					</div>

					<hr>
					<strong>Other Pages</strong>

					<div class="form-group">
						<label class="col-md-2 control-label" for="other_additional_scripts">Script Files</label>
						<div class="col-md-8">
							<textarea name="other_additional_scripts" class="form-control" rows="5"
									  placeholder="One per line"><?= implode("\n", $config_unserialize['other']['additional_scripts']) ?></textarea>
							<p><i>* One sccript url per line without comma</i></p>
						</div>
					</div>

					<hr>
					<div class="form-group">
						<label class="col-md-2 control-label"></label>
						<div class="col-md-6">
							<button class="btn btn-primary pull-left" name="btn" value="additional_scripts">Update Additional scripts</button>
						</div>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>