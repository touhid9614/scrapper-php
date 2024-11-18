<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs;

$cron_name = isset($_GET['dealership']) ? filter_input(INPUT_GET, 'dealership') : '';
$cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;


include 'bolts/header.php';
?>

<div class="inner-wrapper">
	<?php
	$select = 'feeds';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2> Advertisement Feeds </h2>
		</header>

		<div class="row">
			<div class="col-lg-12">
				<form id="show_Ad_feed" method="post">
					<section class="panel">
						<header class="panel-heading">
							<h2 class="panel-title"> Feeds </h2>
						</header>

						<div class="panel-body">
							<div class="row form-group-row">
								<div class="col-md-4">
									<label class="col-md-3 control-label"> Feed Name </label>
									<div class="col-md-9">
										<select class="form-control" id="feed_name" name="feed_name" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
											<option value="facebook">
												Facebook Feed
											</option>
											<option value="marketplace">
												Marketplace Feed
											</option>
										</select>
									</div>
								</div>

								<div class="col-md-4">
									<!-- <label class="col-md-3 control-label"> Feed Name </label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="feed_name" name="feed_name" data-plugin-multiselect
                                                    data-plugin-options='{ "maxHeight": 200 }'>
                                                <option value="facebook">
                                                    Facebook Feed
                                                </option>
                                                <option value="marketplace">
                                                    Marketplace Feed
                                                </option>
                                            </select>
                                        </div> -->
								</div>

								<div class="col-md-4">
									<!-- <label class="col-md-3 control-label"> Feed Name </label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="feed_name" name="feed_name" data-plugin-multiselect
                                                    data-plugin-options='{ "maxHeight": 200 }'>
                                                <option value="facebook">
                                                    Facebook Feed
                                                </option>
                                                <option value="marketplace">
                                                    Marketplace Feed
                                                </option>
                                            </select>
                                        </div> -->
								</div>
							</div>
						</div>

						<div class="panel-footer">
							<div class="row">
								<div class="col-md-12">
									<button type="button" id="show_feed" name="show_feed" value="show_feed" class="btn btn-primary pull-right"> Show Feed
									</button>
								</div>
							</div>
						</div>
					</section>
				</form>
			</div>
		</div>
	</section>
</div>

<?php
include 'bolts/footer.php';
