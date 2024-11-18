<?php
//ini_set('max_execution_time', 0);
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//error_reporting(0);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

//require_once ADSYNCPATH . 'config.php';
//require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$post_url = 'https://app.asana.com/api/1.0/';
$additional_headers['Authorization'] = 'Bearer 1/1200568371540166:c736edfaf01555dbddfb4665239b29e8';


//echo '<pre>';


//$get_all_projects = $post_url . "projects";
//$res = HttpGet($get_all_projects, false, false, '', $nothing, 'application/json', $additional_headers);
//$project_data = json_decode($res);
//$projects = $project_data->data;
//print_r($projects);

$projects = [
	[
		"gid" => "1116316622272921",
		"name" => "Support Tickets",
	],
	[
		"gid" => "1189536797182305",
		"name" => "Google Ads Issues",
	],
	[
		"gid" => "1145853562025778",
		"name" => "Issues",
	],
	[
		"gid" => "1146097137026248",
		"name" => "Scraper Issues",
	],
];

$project_id = isset($_GET['pid']) ? $_GET['pid'] : 1116316622272921;
$task_offset_id = isset($_GET['toid']) ? $_GET['toid'] : false;
$get_all_tasks = $post_url . "tasks?opt_pretty=true&opt_fields=name,assignee,notes,followers,followers.name,followers.email,assignee.name,assignee.email,permalink_url,completed,completed_at,created_at,due_at,modified_at&project=$project_id&limit=100";
if ($task_offset_id) {
	$get_all_tasks .= "&offset=$task_offset_id";
}
$res = HttpGet($get_all_tasks, false, false, '', $nothing, 'application/json', $additional_headers);

//echo $get_all_tasks;
$task_data = json_decode($res);
$tasks = $task_data->data;
$task_offset = $task_data->next_page ? $task_data->next_page->offset : '';

//print_r($tasks);
//exit;
?>
<style>
	.ac {
		color: green;
	}

	.de {
		color: red;
	}
</style>
<title>Get Asana task | sMedia</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
	  integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<body>
<div class="card" style="margin: 10px 20px;">
	<h5 class="card-header bg-info">Get Asana task | sMedia</h5>
	<div class="card-body">
		<h3> Select Project
			<div class="btn-group">
				<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
						aria-expanded="false">
					<?php
					foreach ($projects as $project) {
						if ($project['gid'] == $project_id) {
							echo $project['name'];
						}
					}
					?>
				</button>
				<div class="dropdown-menu">
					<?php
					foreach ($projects as $project) {
						echo "<a class='dropdown-item' href='?pid=" . $project['gid'] . "'>" . $project['name'] . "</a>";
					}
					?>


				</div>
			</div>
		</h3>
		<div class="table-responsive">
			<table id="myTable" class="table table-striped table-bordered cell-border">
				<thead class="text-center">
				<tr>
					<th>No</th>
					<th>Task Name</th>
					<th>Assignee</th>
					<th>Completed</th>
					<th>created_at</th>
					<th>modified_at</th>
					<th>due_at</th>
					<th>permalink_url</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$co = 1;

				$yes = "<p class='ac'>Yes</p>";
				$no = "<p class='de'>No</p>";

				foreach ($tasks as $task) {
					$c_at = $task->created_at;
					$created_at_timestamp = strtotime($c_at);
					$created_at = date('Y-m-d H:i:s', $created_at_timestamp);

					$m_at = $task->modified_at;
					$modified_at_timestamp = strtotime($c_at);
					$modified_at = $c_at ? date('Y-m-d H:i:s', $modified_at_timestamp) : '';

					$d_at = $task->due_at;
					$due_at_timestamp = strtotime($d_at);
					$due_at = $d_at ? date('Y-m-d H:i:s', $due_at_timestamp) : '';
					$follower = "";

					if (count($task->followers)) {
						foreach ($task->followers as $fo) {
							$follower .= $fo->name . ', ';
						}
					}
					$details = htmlentities($task->notes);
					?>
					<tr scope="row">
						<td><?= $co++ ?></td>
						<td><?= $task->name ?></td>
						<td><?= $task->assignee ? $task->assignee->name : '' ?></td>
						<td><?= $task->completed ? $yes : $no ?></td>
						<td><?= $created_at ?></td>
						<td><?= $modified_at ?></td>
						<td><?= $due_at ?></td>
						<td>
							<button type="button" class="open-pause btn btn-primary" data-toggle="modal"
									data-id="<?= $task->gid ?>"
									data-name="<?= $task->name ?>"
									data-details="<?= $details ?>"
									data-follower="<?= $follower ?>"
									data-target="#modalPause"
									title="Task Details">
								<i class="bi bi-info-square"></i>
							</button>
							<a href="<?= $task->permalink_url ?>" class="btn btn-info" target="blank" title="Task Link">
								<i class="bi bi-link-45deg"></i> </a>
						</td>
					</tr>
					<?php
				}

				?>
				</tbody>
			</table>
		</div>
		<?php
		$url = '?';
		if ($project_id) {
			$url .= 'pid=' . $project_id . '&';
		}
		if ($task_offset) {
			$url .= 'toid=' . $task_offset;
			echo '<a class="btn btn-primary" href="' . $url . '"> Next Page</a>';
		}
		?>
	</div>
</div>


<div id="modalPause" class="modal fade " role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content ">
			<div class="modal-header">
				<!--				<button type="button" class="close" data-dismiss="modal">&times;</button>-->
				<h3 class="modal-title text-danger" id="myModalLabel"><b>Task Info!!! </b></h3>
			</div>
			<form method="post" class="form-horizontal">
				<div class="modal-body">
					<input class="form-control" type="hidden" id="task_id"/>
					<div class="form-group">
						<label for="task_name">Task Name</label>
						<input type="text" class="form-control" id="task_name">
					</div>
					<div class="form-group">
						<label for="task_follower">Followers</label>
						<textarea class="form-control" id="task_follower" rows="2"></textarea>
					</div>
					<div class="form-group">
						<label for="task_description">Description</label>
						<textarea class="form-control" id="task_description" rows="5"></textarea>
					</div>


				</div>
				<div class="modal-footer">
					<!--					<button class="btn btn-danger" name="btn" value="PAUSED">PAUSED</button>-->
					<button class="btn btn-danger" data-dismiss="modal">Close
					</button>
				</div>
			</form>
		</div>
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
			responsive: true,
			paging: false,
			dom: 'lBfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
			]
		});
	});

	$(document).on("click", ".open-pause", function () {
		let task_id = $(this).data('id');
		let task_name = $(this).data('name');
		let task_description = $(this).data('details');
		let task_follower = $(this).data('follower');

		// $('#task_id').html(task_id);
		// $('#task_name').html(task_name);
		$('#task_description').html(task_description);
		$('#task_follower').html(task_follower);
		document.getElementById("task_id").value = task_id;
		document.getElementById("task_name").value = task_name;
	});

</script>
