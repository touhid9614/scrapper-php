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
	$update_user_res = 0;
	$new_user_res    = 0;

	if (isset($_POST['form_type'])) {
		if ($_POST['form_type'] == 'edit_user') {
			$updated_name   = filter_input(INPUT_POST, 'edit_name', FILTER_SANITIZE_STRING);
			$updated_role   = filter_input(INPUT_POST, 'edit_role');
			$updated_pass   = filter_input(INPUT_POST, 'edit_password');
			$updated_email  = filter_input(INPUT_POST, 'edit_email', FILTER_SANITIZE_EMAIL);

			$user_update    = [
				'name'      => $updated_name,
				'email'     => $updated_email,
				'pass_hash' => password_hash($updated_pass, PASSWORD_DEFAULT),
				'role'      => $updated_role
			];

			if (filter_input(INPUT_POST, 'deactivate') == 'deactivate') {
				$user_update["account_disabled"] = true;
			}

			$query_prep = $db_connect->prepare_query_params($user_update, DbConnect::PREPARE_EQUAL);
			$db_connect->query("UPDATE users SET {$query_prep} WHERE email = '{$updated_email}';");

			$update_user_res = 1;
		} else if ($_POST['form_type'] == 'new_user') {
			$new_name       = filter_input(INPUT_POST, 'new_name');
			$new_role       = filter_input(INPUT_POST, 'new_role');
			$new_pass       = filter_input(INPUT_POST, 'new_password');
			$new_email      = filter_input(INPUT_POST, 'new_email');

			$user_insert    = [
				'name'      => $new_name,
				'email'     => $new_email,
				'pass_hash' => password_hash($new_pass, PASSWORD_DEFAULT),
				'role'      => $new_role,
				'user_type' => 'a'
			];

			$query_prep = $db_connect->prepare_query_params($user_insert, DbConnect::PREPARE_PARENTHESES);
			$db_connect->query("INSERT INTO users {$query_prep};");
			$new_user_res = 1;
		}
	}

	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

$db_admins = [];
$admin_fetch = $db_connect->query("SELECT name, email, role, designation, thumbnail_url FROM users WHERE user_type = 'a' AND account_disabled = 0 ORDER BY name ASC;");

while ($row = mysqli_fetch_assoc($admin_fetch)) {
	$db_admins[$row['email']] = [
		'name'          => $row['name'],
		'role'          => $row['role'],
		'designation'   => $row['designation'],
		'thumbnail_url' => $row['thumbnail_url']
	];
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'crm-users';
	include 'bolts/sidebar.php'
	?>
	<section role="main" class="content-body">
		<header class="page-header"></header>

		<?php
		if ($update_user_res === 1) {
			echo '<h3 class="text-success">Successfully updated user: ' . $updated_email . '</h3>';
		} else if ($update_user_res === 2) {
			echo '<h3 class="text-danger">Failed to update user: ' . $updated_email . '</h3>';
		}

		if ($new_user_res === 1) {
			echo '<h3 class="text-success">Successfully added user: ' . $new_email . '</h3>';
		} else if ($new_user_res === 2) {
			echo '<h3 class="text-danger">Failed to add new user: ' . $new_email . '. User already exists.</h3>';
		} else if ($new_user_res === 3) {
			echo '<h3 class="text-danger">Email can not be empty.</h3>';
		}
		?>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<button class="btn btn-primary" onclick="showNewUserModal()">Add New Admin User</button>
						</div>
						<h2 class="panel-title"> Admin Users </h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-striped mb-none table-advanced">
									<thead>
										<tr>
											<th> # </th>
											<th> Full Name </th>
											<th> Email </th>
											<th> Role </th>
											<th> Action </th>
										</tr>
									</thead>

									<tbody>
										<?php
										$id = 0;

										foreach ($db_admins as $email => $admin_data) {
											$id++;
										?>
											<tr>
												<td><?= $id ?></td>
												<td><?= $admin_data['name'] ?></td>
												<td style="color: #0a6aa1"><i><?= $email ?></i></td>
												<td><?= $admin_data['role'] ?></td>
												<td>
													<a href="javascript:void(0)" onclick="showEditModal('<?= $email ?>', '<?= $admin_data['name'] ?>', '<?= $admin_data['role'] ?>')">
														<i class="fas fa-edit"></i>
													</a>
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

					<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
						<form method="POST" action="users.php" id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">
							<input type="hidden" name="form_type" value="edit_user" />
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title" id="modal_title"></h2>
								</header>

								<div class="panel-body">
									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Full Name </label>
										<div class="col-sm-9">
											<input type="text" name="edit_name" id="edit_name" class="form-control" required>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Email </label>
										<div class="col-sm-9">
											<input type="email" name="edit_email" id="edit_email" class="form-control" required readonly="readonly" />
										</div>
									</div>


									<div class="form-group">
										<label class="col-sm-3 control-label">Role</label>
										<div class="col-sm-9 modal-select">
											<select data-plugin-selectTwo name="edit_role" class="form-control populate js-example-responsive" style="width: 100%;">
												<option value="none">None</option>
												<option value="scrubber">Scrubber</option>
												<option value="closer">Closer</option>
												<option value="adwords">Adwords</option>
												<option value="designer">Designer</option>
												<option value="closed">Closed</option>
											</select>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label">Password</label>
										<div class="col-sm-9">
											<input type="password" name="edit_password" id="edit_password" class="form-control" required />
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Deactivate </label>
										<div class="col-sm-9">
											<label class="ios7-switch">
												<input type="checkbox" name="deactivate" data-plugin-ios-switch value="deactivate" />
											</label>
										</div>
									</div>
								</div>

								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button class="btn btn-success modal-dismiss">Cancel</button>
											<button type="submit" value="edit_user" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</footer>
							</section>
						</form>
					</div>

					<div id="newModalForm" class="modal-block modal-block-primary mfp-hide">
						<form method="POST" action="users.php" id="form" class="form-horizontal mb-lg" novalidate="novalidate">
							<input type="hidden" name="form_type" value="new_user" />
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title" id="modal_title"> Create New User </h2>
								</header>

								<div class="panel-body">
									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Full Name * </label>
										<div class="col-sm-9">
											<input type="text" name="new_name" id="new_name" class="form-control" required />
											<p id="username_error_msg" class="text-danger"></p>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Email * </label>
										<div class="col-sm-9">
											<input type="email" name="new_email" id="new_email" class="form-control" required />
											<p id="email_error_msg" class="text-danger"></p>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label"> Role </label>
										<div class="col-sm-9 modal-select">
											<select data-plugin-selectTwo name="new_role" class="form-control populate js-example-responsive" style="width: 100%;">
												<option value="none">None</option>
												<option value="scrubber">Scrubber</option>
												<option value="closer">Closer</option>
												<option value="adwords">Adwords</option>
												<option value="designer">Designer</option>
												<option value="closed">Closed</option>
											</select>
										</div>
									</div>

									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label"> Password * </label>
										<div class="col-sm-9">
											<input type="password" name="new_password" id="new_password" class="form-control" required />
											<p id="pass_error_msg" class="text-danger"></p>
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

<?php
include 'bolts/footer.php';