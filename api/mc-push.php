<?php

$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';


$post_url = (isset($_GET['api']) && $_GET['api'] == 'api-dev') ? 'https://api-dev.smedia.ca/v1' : 'https://api.smedia.ca/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';


$get_all_dealer_id = $post_url . "/dealer";
$res = HttpGet($get_all_dealer_id, false, false, '', $nothing, 'application/json', $additional_headers);
$all_dealer = json_decode($res);

$db_connect = new DbConnect();
$allDealerDomain = [];

for ($i = 0; $i < count($all_dealer); $i++) {
	$dealer_info = array();

	$dealer_info['id'] = $id = $all_dealer[$i]->id;
	$dealer_info['dealerName'] = $all_dealer[$i]->dealerName;
	$dealer_info['domain'] = $domain = $all_dealer[$i]->domain;
	$dealer_info['active'] = $all_dealer[$i]->active;
	$dealer_info['guid'] = isset($all_dealer[$i]->guid) ? $all_dealer[$i]->guid : "No GUID";
	$dealer_info['cron'] = $all_dealer[$i]->cronName ? $all_dealer[$i]->cronName : "No CRON";
	$dealer_info['mc_id'] = $all_dealer[$i]->marketCheck->dealer_id ? $all_dealer[$i]->marketCheck->dealer_id : "";
	$dealer_info['db_company_name'] = '';
	$dealer_info['db_cron'] = '';
	$dealer_info['mc_id_found'] = false;
	$dealer_info['db_mc_id'] = '';

	$dealerInfo = $db_connect->checkDealerExist($domain);
	while ($details = mysqli_fetch_array($dealerInfo, MYSQLI_ASSOC)) {
		if (isset($details['dealership'])) {
			$dealer_info['db_company_name'] = $details['company_name'];
			$dealer_info['db_cron'] = $details['dealership'];
		}
	}


	$res = $db_connect->query("SELECT * from marketcheck_dealers_v2 WHERE inventory_url like '%{$domain}%';");

	if (mysqli_num_rows($res)) {
		$dealer_info['mc_id_found'] = true;
		$mc_data = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$dealer_info['db_mc_id'] = $mc_data['dealer_id'];

		if(empty($dealer_info['mc_id']) && !empty($mc_data['dealer_id'])) {
			echo "Dealer: ". $dealer_info['dealerName'].'<br>';
			echo "Dealer Id: ". $dealer_info['id'].'<br>';
			echo "MC Id: ". $dealer_info['mc_id'].'<br>';
			echo "MC Id in DB: ". $mc_data['dealer_id'].'<br>';
			$finalObject = [];
			if (!empty($dealer_info['db_cron'])) {
				$finalObject['cronName'] = $dealer_info['db_cron'];
			}
			$finalObject['marketCheck'] = array(
				"dealer_id" => $mc_data['dealer_id'],
				"status" => $mc_data['status'],
				"street" => $mc_data['street'],
				"city" => $mc_data['city'],
				"state" => $mc_data['state'],
				"country" => $mc_data['country'],
				"zip" => $mc_data['zip'],
				"latitude" => $mc_data['latitude'],
				"longitude" => $mc_data['longitude'],
				"seller_phone" => $mc_data['seller_phone']
			);

			$post_data = json_encode($finalObject);

			$post_url_dealer_info = $post_url . '/dealership/' . $id;
			$res = HttpPost($post_url_dealer_info, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
			$dealerRes = json_decode($res);
			if($dealerRes->success){
				echo "Update successfully";
			} else {
				echo "Update Not successfully";
			}
			echo "<br>-----------------------<br><br>";
		}
	}
	$allDealerDomain[$domain] = $dealer_info;

}

?>


<style>
	.ac {
		color: green;
	}

	.de {
		color: red;
	}
</style>

<title>All dealer list with Ids</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
	  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<body>

<div class="card" style="margin: 10px 20px;">
	<h5 class="card-header bg-info">All dealer list with Ids In MongoDB</h5>
	<div class="card-body">
		<table id="myTable" class="table table-striped table-bordered cell-border  display nowrap" style="width:100%">
			<thead class="text-center">
			<tr>
				<th>SL</th>
				<th>Id</th>
				<th>GUID</th>
				<th>Name</th>
				<th>DB Name</th>
				<th>Domain</th>
				<th>Status</th>
				<th>Cron</th>
				<th>DB Cron</th>
				<th>MC ID Mongo</th>
				<th>MC Found in DB</th>
				<th>MC ID in DB</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$co = 1;
			$active = "<p class='ac'>Active</p>";
			$deactive = "<p class='de'>Inactivte</p>";
			$yes = "<p class='ac'>Yes</p>";
			$no = "<p class='ac'>No</p>";

			if (count($allDealerDomain)) {
				foreach ($allDealerDomain as $index => $dealer) {

					?>
					<tr scope="row">
						<td><?= $co++ ?></td>
						<td><?= $dealer['id'] ?></td>
						<td><?= $dealer['guid'] ?></td>
						<td><?= $dealer['dealerName'] ?></td>
						<td><?= $dealer['db_company_name'] ?></td>
						<td><?= $dealer['domain'] ?></td>
						<td><?= $dealer['active'] ? $active : $deactive ?></td>
						<td><?= $dealer['cron'] ?></td>
						<td><?= $dealer['db_cron'] ?></td>
						<td><?= $dealer['mc_id'] ?></td>
						<td><?= $dealer['mc_id_found'] ? $yes : $no ?></td>
						<td><?= $dealer['db_mc_id'] ?></td>


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
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
		crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
		integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
		crossorigin="anonymous"></script>

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
	$(document).ready(function () {
		$('#myTable').DataTable({
			scrollX: true,
			responsive: true,
			scrollCollapse: true,
			pageLength: 100,
			// fixedColumns: {
			// 	leftColumns: 4,
			// },
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
