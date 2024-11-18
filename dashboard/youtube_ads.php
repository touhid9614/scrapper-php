<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs, $scrapper_configs, $user, $admins;

include 'bolts/header.php';
?>

<div class="inner-wrapper">
	<?php
	$select = 'youtube_ads';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">
			<h2> Youtube Advertisements </h2>
		</header>

		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						<h2 class="panel-title"> Youtube </h2>
					</header>

					<div class="panel-body">
						<div class="row form-group-row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-sm-5 control-label" for="bing_ad_id"> Youtube Advertisement ID : </label>
									<div class="col-sm-7">
										<input type="text" id="bing_ad_id" name="bing_ad_id" class="form-control" value="" data-current="" maxlength="255">
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>


<?php
include 'bolts/footer.php';
