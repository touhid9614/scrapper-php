<?php

$base_path = dirname(__DIR__);
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'utils.php';


$post_url = 'https://api.smedia.ca/v1';

if (isset($_GET['api'])) {
	if ($_GET['api'] == 'dev') {
		$post_url = 'https://api-dev.smedia.ca/v1';
	} else if ($_GET['api'] == 'local') {
		$post_url = 'http://localhost:3000/v1';
	}
}

$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

$get_all_dealer_id = $post_url . "/get-all-dealer-info-id-new/0/2000";

$nothing = '';
$res = HttpGet($get_all_dealer_id, false, false, $nothing, $nothing, 'application/json', $additional_headers);
$all_dealer = json_decode($res);

$defaultAnaDataArr = [
	'type' => '',
	'dsActive' => '',
	'accountEmail' => '',
	'propertyId' => '',
	'accountName' => '',
	'propertyName' => '',
	'profileId' => '',
	'viewId' => '',
	'ep' => '',
	'soDisplayed' => '',
	'soLead' => ''	
];
$defaultAnaData = (object) $defaultAnaDataArr;

$defaultAdDataArr = [
	'accountName' => '',
	'propertyId' => ''
];
$defaultAdData = (object) $defaultAdDataArr;

$defaultFbDataArr = [
	'accountName' => '',
	'propertyId' => ''
];
$defaultFbData = (object) $defaultFbDataArr;

$defaultBingDataArr = [
	'accountName' => '',
	'propertyId' => '',
	'uaId' => ''
];
$defaultBingData = (object) $defaultBingDataArr;
?>

<style>
	.ac {
		color: green;
	}
	.de {
		color: red;
	}
	.active {
		background: gold !important;
	}
</style>

<title>All dealer list with Ids</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<body>
<div class="card" style="margin: 10px 20px;">
	<h5 class="card-header bg-info">All dealer list with Ids From MongoDB</h5>
	<div class="card-body">
		<table id="myTable" class="table table-striped table-bordered cell-border display nowrap" style="width:100%">
			<thead class="text-center">
			<tr>
				<th rowspan="2">No</th>
				<th colspan="6">Dealer Info</th>
				<th colspan="3">Dealer group</th>
				<th colspan="11">Analytics</th>
				<th colspan="2">Adwords</th>
				<th colspan="4">Facebook</th>
				<th colspan="3">Bing</th>
			</tr>
			<tr>
				<th>DealerId</th>
				<th>GUID</th>
				<th>Name</th>
				<th>Cron</th>
				<th>Domain</th>
				<th>Status</th>

				<th>Id</th>
				<th>Name</th>
				<th>Status</th>

				<th>Type</th>
				<th>Data Sherpa</th>
				<th>Account Email</th>
				<th>Account Id</th>
				<th>Account Name</th>
				<th>Property Name</th>
				<th>Profile ID</th>
				<th>View ID</th>
				<th>EP Conversion Goal</th>
				<th>SO View Goal</th>
				<th>SO Lead Goal</th>

				<th>Name</th>
				<th>Id</th>

				<th>Ad Account Name</th>
				<th>Ad Account Id</th>
				<th>Page Id</th>
				<th>Pixel Id</th>

				<th>Name</th>
				<th>Id</th>
				<th>Add Account</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$co = 1;
			$active = "<p class='ac'>Active</p>";
			$deactive = "<p class='de'>Inactive</p>";
			$yes = "<p class='ac'>Yes</p>";
			$no = "<p class='ac'>No</p>";

			if (count($all_dealer)) {
				foreach ($all_dealer as $dealer) {
					$rowspan = $dealer->maxLength;
			?>
					<tr scope="row">
						<td><?= $co++ ?></td>

						<td><?= $dealer->dealershipId ?></td>
						<td><?= isset($dealer->guid) ? $dealer->guid : "" ?></td>
						<td><?= $dealer->dealerName ?></td>
						<td><?= $dealer->cron ?></td>
						<td><?= $dealer->domain ?></td>
						<td><?= $dealer->status ? $active : $deactive ?></td>

						<td><?= isset($dealer->groupId) ?></td>
						<td><?= isset($dealer->group) ?></td>
						<td><?= isset($dealer->groupStatus) ? $active : $deactive ?></td>

						<?php 
						if (count($dealer->analytics) > 0) {
							$anaData = $dealer->analytics[0];
						} else {
							$anaData = $defaultAnaData;
						}
						?>
						<td><?= $anaData->type ?></td>
						<td><?= isset($anaData->dsActive) && $anaData->dsActive ? $active : $deactive ?></td>
						<td><?= isset($anaData->accountEmail) ? $anaData->accountEmail : '' ?></td>
						<td><?= isset($anaData->propertyId) ? $anaData->propertyId : '' ?></td>
						<td><?= isset($anaData->accountName) ? $anaData->accountName : '' ?></td>
						<td><?= isset($anaData->propertyName) ? $anaData->propertyName : '' ?></td>
						<td><?= isset($anaData->profileId) ? $anaData->profileId : '' ?></td>
						<td><?= isset($anaData->viewId) ? $anaData->viewId : '' ?></td>
						<td><?= isset($anaData->ep) ? $anaData->ep : '' ?></td>
						<td><?= isset($anaData->soDisplayed) ? $anaData->soDisplayed : '' ?></td>
						<td><?= isset($anaData->soLead) ? $anaData->soLead : '' ?></td>

						<?php 
						if (count($dealer->adwords) > 0) {
							$adData = $dealer->adwords[0];
						} else {
							$adData = $defaultAdData;
						}
						?>
						<td><?= isset($adData->accountName) ? $adData->accountName : '' ?></td>
						<td><?= isset($adData->propertyId) ? $adData->propertyId  : '' ?></td>

						<?php 
						if (count($dealer->facebook) > 0) {
							$fbData = $dealer->facebook[0];
						} else {
							$fbData = $defaultFbData;
						}
						?>
						<td><?= isset($fbData->accountName) ? $fbData->accountName : '' ?></td>
						<td><?= isset($fbData->propertyId) ? $fbData->propertyId : '' ?></td>
						<td><?= (count($dealer->facebookPage) > 0 && isset($dealer->facebookPage[0]->propertyId)) ? $dealer->facebookPage[0]->propertyId : '' ?></td>
						<td><?= (count($dealer->facebookPixel) > 0 && isset($dealer->facebookPixel[0]->propertyId)) ? $dealer->facebookPixel[0]->propertyId : '' ?></td>

						<?php 
						if (count($dealer->microsoftAd) > 0) {
							$bingData = $dealer->microsoftAd[0];
						} else {
							$bingData = $defaultBingData;
						}
						?>
						<td><?= isset($bingData->accountName) ? $bingData->accountName : '' ?></td>
						<td><?= isset($bingData->propertyId) ? $bingData->propertyId : ''?></td>
						<td><?= isset($bingData->uaId) ? $bingData->uaId : '' ?></td>
					</tr>

					<?php
					if ($rowspan > 1) {
						for ($i=1; $i<$rowspan; $i++) {
					?>
					<tr>
						<td><?= $co++ ?></td>
						<td><?= $dealer->dealershipId ?></td>
						<td><?= isset($dealer->guid) ? $dealer->guid : "" ?></td>
						<td><?= $dealer->dealerName ?></td>
						<td><?= $dealer->cron ?></td>
						<td><?= $dealer->domain ?></td>
						<td><?= $dealer->status ? $active : $deactive ?></td>

						<td><?= isset($dealer->groupId) ?></td>
						<td><?= isset($dealer->group) ?></td>
						<td><?= isset($dealer->groupStatus) ? $active : $deactive ?></td>

						<?php 
						if (count($dealer->analytics) > $i) {
							$anaData = $dealer->analytics[$i];
						} else {
							$anaData = $defaultAnaData;
						}
						?>
						<td><?= $anaData->type ?></td>
						<td><?= isset($anaData->dsActive) && $anaData->dsActive ? $active : $deactive ?></td>
						<td><?= isset($anaData->accountEmail) ? $anaData->accountEmail : '' ?></td>
						<td><?= isset($anaData->propertyId) ? $anaData->propertyId : '' ?></td>
						<td><?= isset($anaData->accountName) ? $anaData->accountName : '' ?></td>
						<td><?= isset($anaData->propertyName) ? $anaData->propertyName : '' ?></td>
						<td><?= isset($anaData->profileId) ? $anaData->profileId : '' ?></td>
						<td><?= isset($anaData->viewId) ? $anaData->viewId : '' ?></td>
						<td><?= isset($anaData->ep) ? $anaData->ep : '' ?></td>
						<td><?= isset($anaData->soDisplayed) ? $anaData->soDisplayed : '' ?></td>
						<td><?= isset($anaData->soLead) ? $anaData->soLead : '' ?></td>

						<?php 
						if (count($dealer->adwords) > $i) {
							$adData = $dealer->adwords[$i];
						} else {
							$adData = $defaultAdData;
						}
						?>
						<td><?= isset($adData->accountName) ? $adData->accountName : '' ?></td>
						<td><?= isset($adData->propertyId) ? $adData->propertyId  : '' ?></td>

						<?php 
						if (count($dealer->facebook) > $i) {
							$fbData = $dealer->facebook[$i];
						} else {
							$fbData = $defaultFbData;
						}
						?>
						<td><?= isset($fbData->accountName) ? $fbData->accountName : '' ?></td>
						<td><?= isset($fbData->propertyId) ? $fbData->propertyId : '' ?></td>
						<td><?= (count($dealer->facebookPage) > 0 && isset($dealer->facebookPage[0]->propertyId)) ? $dealer->facebookPage[0]->propertyId : '' ?></td>
						<td><?= (count($dealer->facebookPixel) > 0 && isset($dealer->facebookPixel[0]->propertyId)) ? $dealer->facebookPixel[0]->propertyId : '' ?></td>

						<?php 
						if (count($dealer->microsoftAd) > $i) {
							$bingData = $dealer->microsoftAd[$i];
						} else {
							$bingData = $defaultBingData;
						}
						?>
						<td><?= isset($bingData->accountName) ? $bingData->accountName : '' ?></td>
						<td><?= isset($bingData->propertyId) ? $bingData->propertyId : ''?></td>
						<td><?= isset($bingData->uaId) ? $bingData->uaId : '' ?></td>
					</tr>
					<?php
						}
					}
					?>
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
			pageLength: 50,
			lengthMenu: [
				[50, 100, 200, 300, -1],
				[50, 100, 200, 300, "All"]
			],
			dom: 'lBfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5'
			]
		});
		$("tbody tr").on("click", function() {
			$(this).find("td").each(function(i) {
				$(this).toggleClass('active');
			});
		});
	});
</script>