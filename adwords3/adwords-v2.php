<?php

/* $exec_str = "ps aux | grep -i php | grep adwords-v2.php | grep hondasbynelson | grep -v grep | awk '{print $2, $13}'";
$adwords_worker  = array_filter(explode(" ", exec($exec_str)));
if (count($adwords_worker)) {
    var_dump($adwords_worker);
    exit();
}  */
$hostname = $_SERVER['HTTP_HOST'];
$root_dir = dirname(__DIR__);

if ($hostname != 'tools.smedia.ca' && $hostname != 'localhost' && $hostname != 'tm-dev.smedia.ca') {
	header("Location: https://tools.smedia.ca" . $_SERVER['REQUEST_URI']);
	exit;
}

ob_start();
require_once('config.php');
require_once('carlist-loader.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('utils.php');
?>

<!doctype html>
<html class="fixed">

<head>
	<!-- Basic -->
	<meta charset="UTF-8">
	<title>Control Panel</title>
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<script src="../dashboard/assets/vendor/jquery/jquery.js"></script>
	<!-- Web Fonts  -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
	<!-- Vendor CSS -->
	<link rel="stylesheet" href="../dashboard/assets/vendor/bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" />
	<link rel="stylesheet" href="../dashboard/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
	<link rel="stylesheet" href="../dashboard/assets/vendor/select2/css/select2.css" />
	<link rel="stylesheet" href="../dashboard/assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
	<!-- Fav Icon -->
	<link rel="shortcut icon" href="../dashboard/assets/images/cropped-ICON-SMEDIA-32x32.png" type="png" sizes="32x32" alt="Smedia logo">
</head>

<body>
	<div class="container">
		<div class="col-lg-12">
			<section class="body">
				<div class="inner-wrapper">
					<section role="main" class="content-body">
						<header class="page-header" style="margin: 40px 0;">
							<h1 class="panel-title" style="font-size: 20px; color: #7EC0EE; font-weight: bold"> Adwords Control Panel </h1>
						</header>

						<div class="row">
							<div class="col-lg-12">
								<?php
								$php_binary = 'php';

								/*  Data collected via serverInfo.sh    */
								if ($_SERVER['REQUEST_METHOD'] == 'POST') {
									if (isset($_POST['killme'])) {
										$pid = preg_replace('/[^0-9]/', '', $_POST['killme']);

										if (`ps aux |grep -v grep | grep $pid | grep adwords-v2.php | wc -l ` == 1) {
											`kill $pid`;
										}
									} else if (isset($_POST['killall'])) {
										if ($_POST['killall']) {
											exec("ps aux |  grep -i php | grep adwords-v2.php | grep -v grep | awk '{print $2}' | xargs kill");
										}
									} else if (isset($_POST['start_one'])) {
										$command = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['start_one_command']);
										if (empty($command)) {
											$command = 'sync-manual';
										}
										$dealership = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['start_one']);

										if (($command != '') && ($dealership != '')) {
											$launch_str = $php_binary . ' '
												. escapeshellarg($root_dir . '/services/adwords-v2.php') . ' '
												. escapeshellarg($dealership) . ' '
												. escapeshellarg($command)
												. ' > /dev/null 2>/dev/null &';
											//. ' > /home/arif/error.txt 2>/home/arif/error2.txt &';

											exec($launch_str, $outputr);
										}
									}
									header("Location: " . $_SERVER['PHP_SELF']);
								}

								$worker_list = explode("\n", `ps aux |  grep -i php | grep adwords-v2.php | grep -v grep | awk '{print $2, $13, $14, $3, $10, $8}'`);
								echo '<br>';
								echo "<form class='form-horizontal form-bordered' action='{$_SERVER['PHP_SELF']}' method='POST'>";
								echo '<div class="form-group">';
								echo '<div class="col-md-2">';
								echo '<p style="font-size: 20px; color: #7EC0EE; font-weight: bold;">Start Worker:</p>';
								echo '</div>';
								echo '<div class="col-md-4">';
								echo "<select data-live-search='true' data-live-search-style='startsWith' class='form-control selectpicker' name='start_one'><option value='-----'>-- Select Dealership --</option>";

								foreach ($scrapper_configs as $cron_name => $project_config) {
									if (!isset($CronConfigs[$cron_name])) {
										continue;
									}

									echo "<option value='" .  htmlspecialchars($cron_name)
										. "'>" . htmlspecialchars($cron_name) . '</option>';
								}

								echo '</select>';
								echo '</div>';
								echo '  ';
								echo '  ';
								echo '<div class="col-sm-3"><input type="text" class="form-control" name="start_one_command" value="" placeholder="Command"></div>';
								echo '  ';
								echo '<div class="col-sm-3"><input type="submit" class="btn btn-primary pull-right" value="Start Worker"></div></form>';
								echo '</div>';
								echo '<div><table class="table table-responsive table-bordered table-striped table-hover" style="border-top-left-radius: 15px; border-top-right-radius: 15px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; text-align: center;">';
								echo '<thead><tr><th>#</th><th>PID</th><th>Cron Name</th><th>Command</th><th>CPU(%)</th><th>RAM(%)</th><th>Status</th><th>Stop</th></tr></thead>';

								$i = 0;

								foreach ($worker_list as $worker_data) {
									if (trim($worker_data) == '') {
										continue;
									}

									$i++;
									echo "<tr>";
									echo "<td style='border-right:none; padding:none'>$i</td>";
									$xp = explode(' ', $worker_data);
									$top = "top -b -n 1 -p {$xp[0]} | grep -i php | awk '{print $9, $10}'";
									$cm = explode(' ', `$top`);
									$xp[3] = $cm[0];
									$xp[4] = $cm[1];

									foreach ($xp as $column) {
										echo "<td style='border-right:none; padding:none'>$column</td>";
									}

									echo <<<Kumar
                                        <td><form action="{$_SERVER['PHP_SELF']}" method="POST">
                                        <input type="hidden" name="killme" value="{$xp[0]}">
                                        <input type="submit" name="killer" value="Stop worker">
                                        </form></td>
Kumar;
									echo "</tr>";
								}

								echo '</table>';
								echo '</div>';

								echo <<<Sangakkara
                                    <form action="{$_SERVER['PHP_SELF']}" method="POST">
                                    <input type="hidden" name="killall" value="true">
                                    <input type="submit" class="btn btn-primary pull-right" value="End All Workers">
                                    </form>
Sangakkara;
								echo '<br>';

								echo '</div>';
								echo '</div>';
								?>
							</div>
						</div>
					</section>
				</div>
			</section>
		</div>
	</div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

</html>
