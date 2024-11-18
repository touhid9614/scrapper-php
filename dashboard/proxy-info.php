<?php

error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $admins, $user;

$db_connect = new DbConnect('');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($_POST['form_type'] == 'add_proxy_purchase') {
		$new_order_id	  = filter_input(INPUT_POST, 'new_order_id');
		$new_due_date 	  = filter_input(INPUT_POST, 'new_due_date');
		$new_quantity 	  = filter_input(INPUT_POST, 'new_quantity');
		$new_price    	  = filter_input(INPUT_POST, 'new_price');
		$new_description  = filter_input(INPUT_POST, 'new_description');
		$proxy_auto_renew = filter_input(INPUT_POST, 'proxy_auto_renew') ? true : false;

		$proxy_insert    = [
			'order_id'    => $new_order_id,
			'due_date'    => strtotime($new_due_date),
			'quantity'    => $new_quantity,
			'price'       => $new_price,
			'description' => $new_description,
			'auto_renew'  => $proxy_auto_renew
		];

		$query_prep = $db_connect->prepare_query_params($proxy_insert, DbConnect::PREPARE_PARENTHESES);
		$db_connect->query("INSERT INTO proxy_info {$query_prep};");
	} else if ($_POST['btn'] == 'delete') {
		$delete_id = filter_input(INPUT_POST, 'delete_id');;
		$db_connect->query("UPDATE proxy_info SET active = false WHERE order_id = '{$delete_id}';");
	}

	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

$db_proxies = [];
$proxy_fetch = $db_connect->query("SELECT * FROM proxy_info WHERE active = true;");

while ($row = mysqli_fetch_assoc($proxy_fetch)) {
    $db_proxies[$row['order_id']] = [
        'quantity'    => $row['quantity'],
        'price'       => $row['price'],
        'description' => $row['description'],
        'due_date'    => date('D, d-M-Y', $row['due_date']),
        'auto_renew'  => $row['auto_renew'] ? "YES" : "NO",
        'active'      => $row['active'] ? "YES" : "NO"
    ];
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'proxy-info';
	include 'bolts/sidebar.php'
	?>
	<section role="main" class="content-body">
		<header class="page-header"></header>

		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<button class="btn btn-primary" onclick="addProxyInfo()">Add Proxy Purchase Info</button>
						</div>
						<h2 class="panel-title"> Proxy Info </h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-striped mb-none table-advanced">
									<thead>
										<tr>
											<th> # </th>
											<th> Order ID </th>
											<th> Proxy Quantity </th>
											<th> Cost </th>
											<th> Due Date </th>
											<th> Description </th>
											<th> Auto Renew </th>
											<th> Active </th>
											<th> Action </th>
										</tr>
									</thead>

									<tbody>
										<?php
										$id = 1;

										foreach ($db_proxies as $orderId => $data) {
										?>
											<tr>
												<td><?= $id++ ?></td>
												<td><?= $orderId ?></td>
												<td><?= $data['quantity'] ?></td>
												<td><?= $data['price'] ?></td>
												<td><?= $data['due_date'] ?></td>
												<td><?= $data['description'] ?></td>
												<td><?= $data['auto_renew'] ?></td>
												<td><?= $data['active'] ?></td>
												<td> <button class="open-homeEvents btn btn-danger" data-id="<?= $orderId ?>" data-toggle="modal" data-target="#modalDelete">Deactivate <i class="fas fa-trash-alt"></i></button>
												</td>
											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div id="proxyAddForm" class="modal-block modal-block-primary mfp-hide">
						<form method="POST" action="proxy-info.php" id="form" class="form-horizontal mb-lg" novalidate="novalidate">
							<input type="hidden" name="form_type" value="add_proxy_purchase" />
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title" id="proxy_modal_title"> Add Proxy Purchase Info </h2>
								</header>

								<div class="panel-body">
									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Order Id * </label>
										<div class="col-sm-9">
											<input type="text" name="new_order_id" id="new_order_id" class="form-control" required />
											<p id="order_id_error_msg" class="text-danger"></p>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Due Date * </label>
										<div class="col-sm-9">
											<input type="date" name="new_due_date" id="new_due_date" class="form-control" required />
											<p id="due_date_error_msg" class="text-danger"></p>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Quantity * </label>
										<div class="col-sm-9">
											<input type="number" name="new_quantity" id="new_quantity" class="form-control" min="1" required />
											<p id="quantity_error_msg" class="text-danger"></p>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Price * </label>
										<div class="col-sm-9">
											<input type="number" min="1" name="new_price" id="new_price" class="form-control" required />
											<p id="price_error_msg" class="text-danger"></p>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Description </label>
										<div class="col-sm-9">
											<input type="text" name="new_description" id="new_description" class="form-control"/>
										</div>
									</div>


									<div class="form-group">
										<label class="col-md-3 control-label" for="proxy_auto_renew"> Auto Renew </label>
										<div class="col-sm-9">
											<label class="ios7-switch">
												<input type="checkbox" id="proxy_auto_renew" name="proxy_auto_renew" data-plugin-ios-switch/>
											</label>
										</div>
									</div>
								</div>

								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button id="new_user_submit_btn" type="submit" value="new_user" class="btn btn-primary"> Submit </button>
											<button class="btn btn-default modal-dismiss"> Cancel </button>
										</div>
									</div>
								</footer>
							</section>
						</form>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>

<div id="modalDelete" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="height:50px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-danger" id="myModalLabel"><strong>Deactivate!!! </strong></h3>
			</div>
			<form method="post" class="form-horizontal">
			<div class="modal-body">
				<input type="hidden" name="delete_id" id="delete_id"/>
				<h4 id="acc_id"></h4>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" name="btn" value="delete">Deactivate</button>
				<button class="btn btn-default" data-dismiss="modal">Close
				</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="app/js/proxy.js" defer></script>

<?php
include 'bolts/footer.php';
