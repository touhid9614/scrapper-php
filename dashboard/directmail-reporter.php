<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $CronConfigs;

$base_dir = dirname(__DIR__);

$directmail_clients = [];
$php_file 			= $base_dir . '/match-leads.php';
$run_all_file 		= $base_dir . '/crons/generate-directmail-report.php';
$csv_dir            = $base_dir . '/reports/directmail/';

foreach ($CronConfigs as $cron => $config) {
    if (isset($config['mail_retargeting']) && $config['mail_retargeting']['enabled']) {
    	$direct_file = $csv_dir . $cron . '.csv';

        $directmail_clients[$cron] = [
        	'client_id'    => $config['mail_retargeting']['client_id'],
        	'csv_file'     => file_exists($direct_file) ? fileNameChange($direct_file) : '',
        	'last_updated' => filemtime($direct_file) ? date('d-M-Y H: i: s', filemtime($direct_file)): 'N/A'
    	];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// FILES UPLOADED
	if (filter_input(INPUT_POST, 'btn') == 'save-directmail-files') {
		$csvs = array_keys($directmail_clients);

		foreach ($csvs as $key => $dealer) {
			$file      = $dealer . '_diretmail_csv';
            $file_name = isset($_FILES[$file]) ? $_FILES[$file] : '';

            if (isset($file_name['tmp_name']) && !empty($file_name['tmp_name'])) {
				$type       = $file_name['type'];
                $temp_dir   = $file_name['tmp_name'];
                $target_dir = $csv_dir . $dealer . '.csv';
                $csv_mimes  = [
				    'text/csv',
				    'text/tsv',
				    'text/plain',
				    'application/csv',
				    'text/comma-separated-values',
				    'application/excel',
				    'application/vnd.ms-excel',
				    'application/vnd.msexcel',
				    'text/anytext',
				    'application/octet-stream',
				    'application/txt'
				];

                if (in_array($type, $csv_mimes)) {
                    move_uploaded_file($temp_dir, $target_dir);
                }
            }
		}

		echo("<script type='text/javascript'> location.href = location.href; </script>");
	}

	// GENERATE REPORTS
	if (filter_input(INPUT_POST, 'btn') == 'run-all-reports') {
		$outputr   = [];
        $return    = null;

        $launch_str = 'php '
        . escapeshellarg($run_all_file)
        . ' > /dev/null 2>/dev/null &';

        $sts = exec($launch_str, $outputr, $return);
		echo("<script type='text/javascript'> location.href = location.href; </script>");
	}

	// GENERATE SINGLE REPORT
	$run_cron = filter_input(INPUT_POST, 'run_cron');

	if (!empty($run_cron)) {
		$client_id = $CronConfigs[$run_cron]['mail_retargeting']['client_id'];
        $outputr   = [];
        $return    = null;
        $csv_file  = $csv_dir . $run_cron . '.csv';

        $launch_str = 'php '
        . escapeshellarg($php_file) . ' '
        . escapeshellarg($csv_file) . ' '
        . escapeshellarg($client_id)
        . ' > /dev/null 2>/dev/null &';

        $sts = exec($launch_str, $outputr, $return);
	}
}

function fileNameChange($file) {
	return str_replace('/var/www/html/tm.smedia.ca', '', $file);
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">

	<?php
	$select = 'directmail-reporter';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel panel-info">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action"></a>
						</div>
						<h2 class="panel-title"> DIRECTMAIL REPORTER </h2>
					</header>

					<div class="panel-body">
					    <p class="alert alert-info">
					        You can upload csv files directly in <i>smedia-inventory/reports/directmail/</i> folder via FTP too.
					    </p>
					</div>

					<form method="POST" class="form-bordered" enctype="multipart/form-data">
						<div class="panel-body">
							<div class="row form-group-row">
								<div class="col-md-12">
									<table class="table table-bordered table-striped mb-none table-advanced">
										<thead>
											<tr>
												<th> # </th>
												<th> Dealership </th>
												<th> Client ID </th>
												<th> CSV File </th>
												<th> CSV Last Updated </th>
												<th> Create Report </th>
												<th> Upload CSV </th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i = 1;

											foreach ($directmail_clients as $cron => $value) {
											?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= $cron ?></td>
												<td><?= $value['client_id'] ?></td>
												<td><?= $value['csv_file'] ?></td>
												<td><?= $value['last_updated'] ?></td>
												<td>
													<button type="submit" data-value="<?= $cron ?>" class="create-report btn btn-success">Run</button>
												</td>
												<td><input type="file" name="<?= $cron ?>_diretmail_csv" class="form-control" accept=".csv"></td>
											</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<footer class="panel-footer">
							<div class="form-group">
								<button name="btn" type="submit" value="run-all-reports" class="btn btn-success pull-left"> Run All Reports </button>
								<button name="btn" type="submit" value="save-directmail-files" class="btn btn-primary pull-right"> Upload Files </button>
							</div>
						</footer>
					</form>
				</section>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
	$('.create-report').click(function (event) {
		event.preventDefault();
		let run_cron = $(this).data('value');

		$.ajax({
			method: "POST",
			cache: false,
			data: { 'run_cron': run_cron }
		});
	});
</script>

<?php
include 'bolts/footer.php';