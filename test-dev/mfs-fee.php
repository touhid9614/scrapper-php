<?php
$data_load = [
	'UCB' => [
		'percentage' => '1.15%',
		'min' => '',
		'remark' => 'Charges 34.50 bdt each time you pay credit card bill from MFS'
	],
	'City Visa' => [
		'percentage' => '1.15%',
		'min' => '',
		'remark' => 'Charges 40.25 bdt each time you pay credit card bill from MFS'
	],
	'City Amex' => [
		'percentage' => '2.30%',
		'min' => '115 BDT',
		'remark' => ''
	],
	'LBFL' => [
		'percentage' => '1.725%',
		'min' => '',
		'remark' => ''
	],
	'SCB' => [
		'percentage' => '1.15%',
		'min' => '',
		'remark' => ''
	],
	'PREMIER' => [
		'percentage' => '1.725%',
		'min' => '57.50 BDT',
		'remark' => ''
	],
	'SEBL' => [
		'percentage' => '2.30%',
		'min' => '',
		'remark' => 'Charges 2.3% on nexuspay too even though not an MFS. Charges 34.50 bdt each time you pay credit card bill from MFS'
	],
	'BANK ASIA' => [
		'percentage' => '1.725%',
		'min' => '',
		'remark' => ''
	],
	'SONALI' => [
		'percentage' => '11.50 BDT',
		'min' => '11.50 BDT',
		'remark' => 'Charges 11.50 in debit and prepaid card too! Allows max 3000 bdt per transaction.'
	],
	'DHAKA' => [
		'percentage' => '1.725%',
		'min' => '172.50 BDT',
		'remark' => ''
	],
	'SBAC' => [
		'percentage' => '1.15%',
		'min' => '115 BDT',
		'remark' => ''
	],
	'MERCANTILE' => [
		'percentage' => '1.15%',
		'min' => '',
		'remark' => ''
	],
	'STANDARD' => [
		'percentage' => '57.50 BDT',
		'min' => '57.50 BDT',
		'remark' => 'Charges 57.50 bdt each time you add money. Also charges 57.50 bdt if you pay credit card bill from MFS.'
	],
	'NRB' => [
		'percentage' => '1.4375%',
		'min' => '',
		'remark' => ''
	],
	'BRAC' => [
		'percentage' => '1.15%',
		'min' => '',
		'remark' => 'Charges on nexuspay too even though not an MFS'
	],
	'MTB' => [
		'percentage' => '1.15%',
		'min' => '',
		'remark' => ''
	],
];
ksort($data_load);
?>
<head>
	<title>Horrible Credit Cards</title>
	<link rel="icon" href="https://image.shutterstock.com/image-vector/stop-bullying-symbol-vector-avoid-260nw-1488276428.jpg">
</head>

<body>
	<div>
		<h1>
			<img src="https://image.shutterstock.com/image-vector/stop-bullying-symbol-vector-avoid-260nw-1488276428.jpg" height="30">
			User unfriendly credit cards (Horrible)
		</h1>
	</div>
	<div>
		<table>
			<thead>
				<tr>
					<th> # </th>
					<th> Bank Name </th>
					<th> Charge </th>
					<th> Minimum Charge </th>
					<th> Remark </th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i = 1;
			foreach ($data_load as $fraud => $charges) {
			?>
				<tr>
					<td><?= $i++ ?></td>
					<td><?= $fraud ?></td>
					<td><?= $charges['percentage'] ?></td>
					<td><?= $charges['min'] ?></td>
					<td><?= $charges['remark'] ?></td>
				</tr>
			<?php
			}
			?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5"><i>* DBBL doesn't charge on add money but if you pay visa credit card bill from MFS, they charge 92 BDT each time.</i></td>
				</tr>
			</tfoot>
		</table>
	</div>

	<style>
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #000000;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}

		i {
			color:  blue;
		}
	</style>
</body>