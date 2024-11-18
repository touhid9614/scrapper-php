<?php

$bill = isset($_GET['bill']) ? $_GET['bill'] : 60000;
$emi  = isset($_GET['emi']) ? $_GET['emi'] : 6;

$start 	  = $bill;
$emi_size = (int) ($bill / $emi);
$extra    = $bill - $emi * $emi_size;
$first    = round($emi_size + $extra, 2);
$rest     = round($bill - $first, 2);
$cash_fee = round($rest * 0.008, 2);
$toal_cst = $cash_fee;
?>
<head>
	<title>Self EMI</title>
</head>

<body>
	<div>
		<p>
			<i>Insert your bill amount and EMI tenure in months to see how much it costs for self emi.</i>
		</p>
	</div>
	<div>
		<form>
			<label for="bill">Total Bill:</label><br>
			<input type="number" min="0" id="bill" name="bill" value="<?=$bill?>"><br>
			<label for="emi">EMI Tenure (in months):</label><br>
			<input type="number" min="0" id="emi" name="emi" value="<?=$emi?>"><br><br>
			<input type="submit" value="Submit">
		</form>

		<table>
			<thead>
				<tr>
					<th>Month No</th>
					<th>Starting Bill</th>
					<th>Paid This month</th>
					<th>Pending Bill</th>
					<th>Cost For UPAY Out</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> 1 </td>
					<td><?= $bill ?>Tk</td>
					<td><?= $first ?>Tk</td>
					<td><?= $rest ?>Tk</td>
					<td><?= $cash_fee ?>Tk</td>
				</tr>
			<?php
			$i = 2;
			while ($rest) {
				$bill = $rest;
				$rest -= $emi_size;
				$cashout_fee = round($rest * 0.008, 2);
				$toal_cst += $cashout_fee;
			?>
				<tr>
					<td><?= $i++ ?></td>
					<td><?= $bill ?>Tk</td>
					<td><?= $emi_size ?>Tk</td>
					<td><?= $rest ?>Tk</td>
					<td><?= $cashout_fee ?>Tk</td>
				</tr>
			<?php
			}

			$ratio = round($toal_cst * 100 / $start, 2);
			?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">Total Cost</td>
					<td><?= $toal_cst ?>Tk</td>
				</tr>
				<tr>
					<td colspan="4">Remark</td>
					<td><?= $ratio ?>% extra charge only</td>
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
	</style>
</body>