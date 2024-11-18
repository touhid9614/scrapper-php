<?php
$bill = isset($_GET['bill']) ? $_GET['bill'] : 50000;
$ratio = isset($_GET['ratio']) ? $_GET['ratio'] : 5;
$minimal_due = isset($_GET['minimal_due']) ? $_GET['minimal_due'] : 500;
$interest = isset($_GET['interest']) ? $_GET['interest'] : 20;
$start = $bill;
$paidSoFar = 0;
$list = [
	0 => [
		'monthly_due' => '',
		'paid_so_far' => '',
		'current_due' => ''
	]
];

while ($bill) {
	$thisDue = getMinDue($bill, $ratio, $minimal_due);
	$bill -= $thisDue;
	$paidSoFar += $thisDue;
	$bill = updatedBill($bill, $interest);

	$list[] = [
		'monthly_due' => $thisDue,
		'paid_so_far' => $paidSoFar,
		'current_due' => $bill
	];

	if ($bill >= -0.005 && $bill <= 0.005) {
		break;
	}
}

$len = count($list);
$one_third = (int)($len / 3);
$two_third = $one_third << 1;
$diff = $len - $one_third * 3;

// print_r(['one_third' => $one_third, 'two_third' => $two_third, 'len' => $len, 'diff' => $diff]);

function getMinDue($bill, $ratio, $minimal_due) {
	if ($bill < $minimal_due) {
		return round($bill, 2);
	}

	$temp = round($bill * $ratio / 100, 2);

	return ($temp > $minimal_due) ? $temp : $minimal_due;
}

function updatedBill($oldBill, $interest) {
	return round($oldBill*(1 + $interest/1200), 2);
}

// exit();
?>

<head>
	<title>Min Due Trap</title>
	<link rel="icon" href="https://lh3.googleusercontent.com/-p2xeWs0OHUI/UkKQfXVzLzI/AAAAAAAAOy4/yL-FelpPBxQ/s640/Credit%2520Card.jpg">
</head>

<body>
	<div>
		<h1>
			<img src="https://lh3.googleusercontent.com/-p2xeWs0OHUI/UkKQfXVzLzI/AAAAAAAAOy4/yL-FelpPBxQ/s640/Credit%2520Card.jpg" height="30">
			Minimum Due Trap
		</h1>
	</div>
	<div>
		<form>
			<label for="bill">Initial Bill:</label>
			<input type="number" min="0" id="bill" name="bill" value="<?=$start?>"><br>
			<label for="ratio">Min due ratio (in perchantage):</label>
			<input type="number" min="0" id="ratio" name="ratio" value="<?=$ratio?>"><br>
			<label for="minimal_due">Minimal Due (Lowest payable amount):</label>
			<input type="number" min="0" id="minimal_due" name="minimal_due" value="<?=$minimal_due?>"><br>
			<label for="interest">Interest:</label>
			<input type="number" min="0" id="interest" name="interest" value="<?=$interest?>"><br>
			<br>
			<input type="submit" value="Submit">
		</form>

		<table>
			<thead>
				<tr>
					<th> Month No</th>
					<th> This months Due </th>
					<th> Paid So Far </th>
					<th> Current Due (After Interest) </th>
					<th> Month No</th>
					<th> This months Due </th>
					<th> Paid So Far </th>
					<th> Current Due (After Interest) </th>
					<th> Month No</th>
					<th> This months Due </th>
					<th> Paid So Far </th>
					<th> Current Due (After Interest) </th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i=1; $i <= $one_third; $i++) {
					$j = $i;
					$k = $i;
					$l = $i;
				?>
				<tr>
					<td> <?= $j ?> </td>
					<td> <?= $list[$j]['monthly_due'] ?> </td>
					<td> <?= $list[$j]['paid_so_far'] ?> </td>
					<td> <?= $list[$j]['current_due'] ?> </td>
					<td> <?= $one_third + $k ?> </td>
					<td> <?= $list[$one_third + $k]['monthly_due'] ?> </td>
					<td> <?= $list[$one_third + $k]['paid_so_far'] ?> </td>
					<td> <?= $list[$one_third + $k]['current_due'] ?> </td>
					<td> <?= $two_third + $l ?> </td>
					<td> <?= isset($list[$two_third + $l]) ? $list[$two_third + $l]['monthly_due'] : '' ?> </td>
					<td> <?= isset($list[$two_third + $l]) ? $list[$two_third + $l]['paid_so_far'] : '' ?> </td>
					<td> <?= isset($list[$two_third + $l]) ? $list[$two_third + $l]['current_due'] : '' ?> </td>
				</tr>
				<?php
				}
				?>
			</tbody>
			<tfoot>
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