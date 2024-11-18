<?php

/* INCLUDE REQUIRED FILES */
session_start();
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once 'bolts/header.php';

ob_start();
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'cron_misc.php';
require_once ADSYNCPATH . 'carlist-loader.php';

/* USE FACEBOOK WEBDRIVER */

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeDriverService;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Facebook\WebDriver\WebDriverCapabilities;
use Facebook\WebDriver\WebDriverPlatform;

$select = 'vs_scraper_dashboard';
require_once 'bolts/sidebar.php';
$selenium_host_addr = "https://selenium.smedia.ca/wd/hub";
?>


<div class="inner-wrapper">
	<section role="main" class="content-body">
		<header class="page-header"></header>

		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="fa fa-caret-down"></a>
						</div>
						<h2 class="panel-title"> Visual Scraper Control Panel </h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<?php
								$php_binary = 'php';

								if ($_SERVER['REQUEST_METHOD'] == 'POST') {
									if (isset($_POST['killme'])) {
										$pid = preg_replace('/[^0-9]/', '', $_POST['killme']);

										if (`ps aux |grep -v grep | grep $pid | grep vs_selenium.php | wc -l ` == 1) {
											`kill $pid`;
										}

										$dealership         = $_POST['dealership'];
										$base_dir           = dirname(__DIR__);
										$running_file_name  = "$base_dir/adwords3/caches/VS/selenium_log/running.txt";
										$sessions           = file_get_contents($running_file_name);
										$sessions           = json_decode($sessions, true);
										$driverBySession    = RemoteWebDriver::createBySessionID($sessions[$dealership], $selenium_host_addr);
										$driverBySession->quit();

										unset($sessions[$dealership]);
										$sessions = json_encode($sessions, JSON_PRETTY_PRINT);
										file_put_contents($running_file_name, $sessions);
									} else if (isset($_POST['killall'])) {
										if ($_POST['killall']) {
											exec("ps aux |  grep -i php | grep vs_selenium.php | grep -v grep | awk '{print $2}' | xargs kill");
										}
									} else if (isset($_POST['start_one'])) {
										$customer   = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['start_one_customer']);
										$dealership = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['start_one']);

										if (($customer != '') && ($dealership != '')) {
											$launch_str = $php_binary . ' '
												. escapeshellarg(dirname(__DIR__) . '/services/vs_selenium.php') . ' '
												. escapeshellarg($dealership) . ' '
												. escapeshellarg($customer)
												. ' > /dev/null 2>/dev/null &';

											$sts = exec($launch_str, $outputr);
										}
									} else {
										foreach ($scrapper_configs as $cron_name => $project_config) {
											if (!array_key_exists('subm_' . $cron_name, $_POST)) {
												continue;
											}

											$execstring = $php_binary . ' '
												. escapeshellarg(dirname(__DIR__) . '/services/vs_selenium.php') . ' '
												. escapeshellarg($cron_name) . ' '
												. escapeshellarg(preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['custn_' . $cron_name]))
												. ' > /dev/null 2>/dev/null &';
											$sts = exec($execstring, $outputr);
										}
									}

									echo ("<script type='text/javascript'> location.href = location.href; </script>");
								}

								$worker_list = explode("\n", `ps aux |  grep -i php | grep vs_selenium.php | grep -v grep | awk '{print $2, $13, $3, $10, $8}'`);
								echo '<p class="text-info medium-font"><i>List does not automatically refresh for now, please refresh page to get updates.</i></p>';
								echo '<br>';
								echo "<form class='form-horizontal form-bordered' action='{$_SERVER['PHP_SELF']}' method='POST'>";
								echo '<div class="form-group">';
								echo '<div class="col-md-2">';
								echo '<p class="run_selenium_for"> Run Selenium Server For :</p>';
								echo '</div>';
								echo '<div class="col-md-4">';
								echo "<select data-live-search='true' data-live-search-style='startsWith' class='form-control selectpicker' name='start_one'><option value='-----'>-- Select Dealership --</option>";

								foreach ($scrapper_configs as $cron_name => $project_config) {
									if (!isset($CronConfigs[$cron_name])) {
										continue;
									}

									echo "<option value='" . htmlspecialchars($cron_name) . "'>" . htmlspecialchars($cron_name) . '</option>';
								}

								echo '</select>';
								echo '</div>';
								echo '  ';
								echo '  ';
								echo '<div class="col-sm-3"><input type="text" class="form-control" name="start_one_customer" value="" placeholder="Customer Name"></div>';
								echo '  ';
								echo '<div class="col-sm-3"><input type="submit" class="btn btn-primary pull-right right-button" value="Run"></div></form></div><br>';
								echo '<div><table class="table table-responsive table-bordered table-striped table-hover table-design">';
								echo '<thead><tr><th class="mid">#</th><th class="mid">PID</th><th class="mid">Cron Name</th><th class="mid">CPU(%)</th><th class="mid">RAM(%)</th><th class="mid">Status</th><th class="mid">Stop</th></tr></thead>';

								$i = 0;

								foreach ($worker_list as $worker_data) {
									if (trim($worker_data) == '') {
										continue;
									}

									$i++;
									echo "<tr>";
									echo "<td style='border-right:none; padding:none'>$i</td>";
									$xp     = explode(' ', $worker_data);
									$top    = "top -b -n 1 -p {$xp[0]} | grep -i php | awk '{print $9, $10}'";
									$cm     = explode(' ', `$top`);
									$xp[2]  = $cm[0];
									$xp[3]  = $cm[1];

									foreach ($xp as $column) {
										echo "<td style='border-right:none; padding:none'>$column</td>";
									}

									echo <<<Kumar
                                        <td><form action="{$_SERVER['PHP_SELF']}" method="POST">
                                        <input type="hidden" name="killme" value="{$xp[0]}">
                                        <input type="hidden" name="dealership" value="{$xp[1]}">
                                        <input type="submit" class="btn-success right-button" name="killer" value="Stop worker">
                                        </form></td>
Kumar;
									echo "</tr>";
								}

								echo '</table>';
								echo '</div>';

								echo <<<Sangakkara
                                    <form action="{$_SERVER['PHP_SELF']}" method="POST">
                                    <input type="hidden" name="killall" value="true">
                                    <button type="button" class="btn btn-primary pull-left left-button" onclick="visitSeleniumServer()"> Visit Selenium Server </button>
                                    <input type="submit" class="btn btn-primary pull-right right-button" value="End All Workers">
                                    </form>
Sangakkara;
								echo '<br>';

								echo '</div>';
								echo '</div>';
								?>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>


<style type="text/css">
	.right-button {
		padding: 10px 20px;
		border-radius: 10px;
	}

	.left-button {
		padding: 10px 20px;
		border-radius: 10px;
		margin-top: 10px;
	}

	.mid {
		text-align: center;
	}

	.run_selenium_for {
		font-size: 20px;
		color: #7EC0EE;
		font-weight: bold;
	}

	.table-design {
		border-top-left-radius: 15px;
		border-top-right-radius: 15px;
		border-bottom-left-radius: 15px;
		border-bottom-right-radius: 15px;
		text-align: center;
	}

	.medium-font {
		font-size: medium;
	}
</style>


<script type="text/javascript">
	function visitSeleniumServer() {
		window.open('https://selenium.smedia.ca/wd/hub', '_blank');
	}
</script>

<?php
include 'bolts/footer.php'
?>
