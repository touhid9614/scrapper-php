<?php

$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'utils.php';


$jerret = [];
$jerret_cron = [];

$file = fopen('dir.csv', 'r');
$count = 1;

while (($line = fgetcsv($file)) !== FALSE) {

	if ($count > 1) {
		$dealer_info = array();
		$dealer_info['guid'] = $line[0];
		$dealer_info['name'] = $line[1];
		$dealer_info['domain'] = $line[34];
		$dealer_info['cron'] = $cron = $line[15];
		$dealer_info['id'] = $line[2];
		$dealer_info['email'] = $email = $line[7];
		$dealer_info['aid'] = $line[16];
		$dealer_info['epid'] = $line[5];
		$dealer_info['viewId'] = $line[9];
		$dealer_info['fbId'] = (string)$line[10];
		$dealer_info['fbpixel'] = (string)$line[17];
		$dealer_info['google'] = $line[3];
		$dealer_info['bing'] = $line[13];
		$dealer_info['bingad'] = $line[12];
		$dealer_info['csm'] = $line[24];
		$dealer_info['googleAdOps'] = $line[25];
		$dealer_info['fbAdsOps'] = $line[26];

		$dealer_info['account'] = str_replace("@gmail.com", "", $email);

		if ($cron) {
			array_push($jerret, $dealer_info);
			$jerret_cron[$cron] = $dealer_info;
		}
	}

	$count++;
}

fclose($file);




?>
<title>Jerret List</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<body>

<div class="card" style="margin: 10px 20px;">
	<h5 class="card-header bg-info">Final List</h5>
	<div class="card-body">
		<table id="myTable" class="table table-striped table-bordered cell-border display nowrap" style="width:100%">
			<thead class="text-center">
			<tr>
				<th>SL</th>
				<th>Id</th>
				<th>GUId</th>
				<th>Dealer Name</th>
				<th>Domain</th>
				<th>Cron</th>
				<th>Analytics account</th>
				<th>Analytics Id</th>
				<th>EP Id</th>
				<th>View Id</th>
				<th>Facebook Ad Id</th>
				<th>Facebook Pixel</th>
				<th>Google Ad Id</th>
				<th>Bing Ad Id</th>
				<th>Bing Account Id</th>
				<th>CSM</th>
				<th>Google Ads Ops</th>
				<th>Fb Ads Ops</th>

			</tr>
			</thead>
			<tbody>
			<?php
			$co = 1;
			if (count($jerret)) {
				foreach ($jerret as $dealer) {
					?>
					<tr scope="row">
						<td><?= $co++ ?></td>
						<td><?= $dealer['id'] ?></td>
						<td><?= $dealer['guid'] ?></td>
						<td><?= $dealer['name'] ?></td>
						<td><?= $dealer['domain'] ?></td>
						<td><?= $dealer['cron'] ?></td>
						<td><?= $dealer['account'] ?></td>
						<td><?= $dealer['aid'] ?></td>
						<td><?= $dealer['epid'] ?></td>
						<td><?= $dealer['viewId'] ?></td>
						<td><?= $dealer['fbId'] ?></td>
						<td><?= $dealer['fbpixel'] ?></td>
						<td><?= $dealer['google'] ?></td>
						<td><?= $dealer['bing'] ?></td>
						<td><?= $dealer['bingad'] ?></td>
						<td><?= $dealer['csm'] ?></td>
						<td><?= $dealer['googleAdOps'] ?></td>
						<td><?= $dealer['fbAdsOps'] ?></td>

					</tr>
					<?php
				}
			}
			?>
			</tbody>

		</table>
	</div>
</div>



</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

<script>
	$(document).ready(function() {
		$('#myTable').DataTable({
			scrollX: true,
			responsive: true,
			scrollCollapse: true,
			pageLength: 100,
			fixedColumns: {
				leftColumns: 3,
			},
			"pageLength": 50,
			"lengthMenu": [
				[50, 100, 200, 300, -1],
				[50, 100, 200, 300, "All"]
			],
			dom: 'lBfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				// 'pdfHtml5',
				// 'print'
			]
		});
	});
</script>
