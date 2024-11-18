<?php

global $CronConfigs, $scrapper_configs, $user, $single_config;

if (isset($_GET['dealership']) && !empty($_GET['dealership'])) {
	$single_config = $_GET['dealership'];
}

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;

require_once 'client-management/configUpdater.php';
require_once 's3-update.php';


global $CronConfigs;

$db_connect = new DbConnect('');
$dealership = isset($_GET['dealership']) ? filter_input(INPUT_GET, 'dealership') : 'smedia';

$default = [
	'button_status' 		=> false,
	'button_debug'  		=> false,
	'dealership_id' 		=> '',
	'VINN_SIGNING_SECRET' 	=> 'adslfkjasldfjk',
	'button_position' 		=> 'afterend',
	'button_container' 		=> '',
	'button_code' 			=> '',
	'button_text'           => 'CHECKOUT'
];

$cron_config = $CronConfigs[$dealership];
$vinnauto = (isset($cron_config['vinnauto']) && is_array($cron_config['vinnauto'])) ? $cron_config['vinnauto'] : $default;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$btn = filter_input(INPUT_POST, 'save_vinnauto');

	if ($btn == 'save_vinnauto') {
		$update_vinnauto = [
			'button_status' 		=> isset($_POST['vinnauto_button_status']) ? true : false,
			'button_debug'  		=> isset($_POST['vinnauto_button_debug']) ? true : false,
			'dealership_id' 		=> filter_input(INPUT_POST, 'vinnauto_dealership_id'),
			'VINN_SIGNING_SECRET' 	=> filter_input(INPUT_POST, 'vinnauto_signing_secret'),
			'button_position' 		=> filter_input(INPUT_POST, 'vinnauto_button_position'),
			'button_container' 		=> filter_input(INPUT_POST, 'vinnauto_button_container'),
			'button_code' 			=> filter_input(INPUT_POST, 'vinnauto_button_code'),
			'button_text'           => filter_input(INPUT_POST, 'vinnauto_button_text')
		];

		$configFile = s3DealerConfig($dealership);
		$parser   	= (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

		try {
			$ast = $parser->parse($configFile);
		} catch (Error $error) {
			echo 'Error Parse';
			print_r($error->getMessage());
			return;
		}

		$traverser = new NodeTraverser();

		if (isset($cron_config['vinnauto'])) {
			$traverser->addVisitor(new configUpdater([
				'key'   => ['vinnauto'],
				'value' => $update_vinnauto
			]));
		} else {
			$traverser->addVisitor(new configCreator('vinnauto', $update_vinnauto));
		}

		$cron_config['vinnauto'] = $update_vinnauto;

		configsUpdate($cron_config, $dealership, false);

		try {
			$ast = $traverser->traverse($ast);
			$prettyPrinter = new ePrinter();
			$config_file_content = $prettyPrinter->prettyPrintFile($ast);
		} catch (Error $error) {
			echo 'Error in traverse';
		}

		s3Update($config_file_content, $dealership, false);

		DbConnect::store_log($user_id, $user['type'], "Vinnauto status", 'Vinnauto has been updated for ' . $dealership, $dealership);
	}

	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">

	<?php
	$select = 'vinnauto';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<form id="filter-form" method="POST" class="form-horizontal form-bordered">
				<div class="col-lg-12">
					<section class="panel panel-info">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="panel-action"></a>
							</div>
							<h2 class="panel-title"> VINNAUTO </h2>
						</header>

						<div class="panel-body">
							<div class="row form-group-row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_dealership_id"> Dealership ID: </label>
										<div class="col-md-9">
											<input type="text" id="vinnauto_dealership_id" name="vinnauto_dealership_id" class="form-control" placeholder="xxx-xxx-xxxx" value='<?= $vinnauto['dealership_id'] ?>' data-current='<?= $vinnauto['dealership_id'] ?>' maxlength="255" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter your vinnauto account id">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_signing_secret"> Signing Secret: </label>
										<div class="col-md-9">
											<input type="text" id="vinnauto_signing_secret" name="vinnauto_signing_secret" class="form-control" placeholder="xxx-xxx-xxxx" value='<?= $vinnauto['VINN_SIGNING_SECRET'] ?>' data-current='<?= $vinnauto['VINN_SIGNING_SECRET'] ?>' maxlength="255" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter your vinnauto signing secret">
										</div>
									</div>
								</div>
							</div>

							<div class="row form-group-row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_button_text"> Button Text: </label>
										<div class="col-md-9">
											<input type="text" id="vinnauto_button_text" name="vinnauto_button_text" class="form-control" placeholder="checkout" value='<?= $vinnauto['button_text'] ?>' data-current='<?= $vinnauto['button_text'] ?>' maxlength="255" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter your vinnauto button text. Default value is 'checkout'">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_button_position"> Button Position: </label>
										<div class="col-md-9">
											<select class="form-control" id="vinnauto_button_position" name="vinnauto_button_position" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }'>
												<option value="afterend" <?= $vinnauto['button_position'] == 'afterend' ? 'selected=""' : '' ?>>
													Append
												</option>
												<option value="beforebegin" <?= $vinnauto['button_position'] == 'beforebegin' ? 'selected=""' : '' ?>>
													Prepend
												</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row form-group-row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_button_container"> Button Container: </label>
										<div class="col-md-9">
											<input type="text" id="vinnauto_button_container" name="vinnauto_button_container" class="form-control" placeholder="xxx-xxx-xxxx" value='<?= $vinnauto['button_container'] ?>' data-current='<?= $vinnauto['button_container'] ?>' maxlength="255" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter your vinnauto button container code">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_button_code"> Button Code: </label>
										<div class="col-md-9">
											<input type="text" id="vinnauto_button_code" name="vinnauto_button_code" class="form-control" placeholder="xxx-xxx-xxxx" value='<?= $vinnauto['button_code'] ?>' data-current='<?= $vinnauto['button_code'] ?>' maxlength="255" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="Enter your vinnauto button code">
										</div>
									</div>
								</div>
							</div>

							<div class="row form-group-row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_button_status"> Button Status: </label>
										<div class="col-sm-9">
											<label class="ios7-switch">
												<input type="checkbox" id="vinnauto_button_status" name="vinnauto_button_status" data-plugin-ios-switch value='<?= $vinnauto['button_status'] ?>' <?= $vinnauto['button_status'] ? 'checked="checked"' : ''; ?> />
											</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="vinnauto_button_debug"> Debug: </label>
										<div class="col-sm-9">
											<label class="ios7-switch">
												<input type="checkbox" id="vinnauto_button_debug" name="vinnauto_button_debug" data-plugin-ios-switch value="<?= $vinnauto['button_debug'] ?>" <?= $vinnauto['button_debug'] ? 'checked="checked"' : ''; ?> />
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>

						<footer class="panel-footer">
							<div class="row">
								<div class="col-md-12 text-right">
									<button id="save_vinnauto" name="save_vinnauto" type="submit" value="save_vinnauto" class="btn btn-primary"> Save Vinnauto </button>
								</div>
							</div>
						</footer>
					</section>
				</div>
			</form>
		</div>
	</section>

<?php
include 'bolts/footer.php';
