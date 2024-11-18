<?php

error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;
use sMedia\AdSync\Utils;

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once '../includes/init-db.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

function option_maker($options, $selected = null)
{
	array_walk($options, function (&$v, $k) use ($selected) {
		$v = '<option value="' . $k . '" ' . ($k == $selected ? "selected" : "") . '>' . $v . '</option>';
	});

	return $options;
}

$used_special = Utils::getSpecialCampaigns('used');
$new_special = Utils::getSpecialCampaigns('new');
$no_custom = array_merge($used_special, $new_special);

$campaignTypes =
	array_merge(
		[
			'smedia_used_make',
			'smedia_used_make_model',
			'smedia_used_make_model_year',
			'smedia_used_make_model_year_trim',
		],
		$used_special,
		[
			'smedia_new_make',
			'smedia_new_make_model',
			'smedia_new_make_model_year',
			'smedia_new_make_model_year_trim',
		],
		$new_special
	);

$db_connect = new DbConnect('');
global $user;
$all_dealerships = $db_connect->get_all_dealers(1);
$dealership = $user['cron_name'];
$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : 'smedia_used_make';
$campType = count(explode('_', $campaign)) - 2;

$selectedMake = isset($_GET['make']) ? $_GET['make'] : '';
$selectedModel = isset($_GET['model']) ? $_GET['model'] : '';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : '';
$selectedTrim = isset($_GET['trim']) ? $_GET['trim'] : '';

$selectedValues = [
	'dealership' => $dealership,
	'campaign' => $campaign,
	'make' => $selectedMake,
	'model' => $selectedModel,
	'year' => $selectedYear,
	'trim' => $selectedTrim,
	'service' => 'adwords',
];

$select_query = DB::table('ad_cpc');
foreach ($selectedValues as $k => $v) {
	$select_query->where($k, '=', $v);
}
$current_setting = $select_query->first();

$make_model_year_trim_data = Utils::loadMakeModelYearTrim($dealership);

$grouped_by_make = $make_model_year_trim_data->groupBy('make')->sortKeys(SORT_STRING, false);
$all_makes = $grouped_by_make->keys();
/** @var Illuminate\Support\Collection $grouped_by_model  */
$grouped_by_model = (empty($selectedMake) ? $make_model_year_trim_data : $grouped_by_make[$selectedMake])->groupBy('model')->sortKeys(SORT_STRING, false);
$all_models = $grouped_by_model->keys();
/** @var Illuminate\Support\Collection $grouped_by_year  */
$grouped_by_year = (empty($selectedModel) ? $make_model_year_trim_data : $grouped_by_model[$selectedModel])->groupBy('year')->sortKeys(SORT_NUMERIC, true);
$all_years = $grouped_by_year->keys();

/** @var Illuminate\Support\Collection $grouped_by_trim  */
$grouped_by_trim = (empty($selectedYear) ? $make_model_year_trim_data : $grouped_by_year[$selectedYear])->groupBy('trim')->sortKeys(SORT_STRING, false);
$all_trims = $grouped_by_trim->keys();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["update_setting"])) {
	$amount = floatval($_POST['cpc']);
	if (!empty($dealership)) {
		$delete_query = DB::table('ad_cpc');
		foreach ($selectedValues as $k => $v) {
			$delete_query->where($k, '=', $v);
		}
		$delete_query->delete();
		if (!empty($amount)) {
			$insert_query = DB::table('ad_cpc');
			$row = array_merge($selectedValues, ['amount' => $amount]);
			$insert_query->insert($row);
		}
	}
	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}
// Default Value for dealer

$select_query = DB::table('ad_cpc')
	->where('dealership', $selectedValues['dealership'])
	->where('service', $selectedValues['service']);

$settings = $select_query->orderBy('campaign')->get();

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'adwords-cpc';
	include 'bolts/sidebar.php'
	?>
	<section role="main" class="content-body">
		<header class="page-header"></header>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title"> Configuration Panel </h2>
					</header>
					<div class="panel-body">
						<form method="POST" class="form-inline">
							<div class="row mb-sm">
								<div class="col-md-2">
									<label class="col-3 mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
								</div>
								<div class="col-md-10">
									<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="dealership" id="dealership" data-plugin-selectTwo>
										<?php
										if ($user['type'] == 'a') {
											foreach ($all_dealerships as $dealer) {
												$selected = ($dealership == $dealer['dealership']) ? ' selected' : '';
										?>
												<option value="<?= $dealer['dealership'] ?>" <?= $selected ?>><?= $dealer['dealership'] ?></option>
											<?php

											}
										} else {
											?>
											<option value="<?= $user['cron_name'] ?>" <?= ' selected' ?>><?= $user['cron_name'] ?> </option>
										<?php
										} ?>
									</select>
								</div>
							</div>
							<div class="row mb-sm">
								<div class="col-md-2">
									<label class="mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Campaign </label>
								</div>
								<div class="col-md-10">
									<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="campaign" data-plugin-selectTwo>
										<?php
										foreach ($campaignTypes as $campaignType) {
										?>
											<option value="<?= $campaignType ?>" <?= $campaignType == $campaign ? 'selected' : ' ' ?>><?= $campaignType ?> </option>
										<?php
										} ?>
									</select>
								</div>
							</div>
							<?php if (!in_array($campaign, $no_custom)) { ?>
								<div class="row mb-sm">
									<div class="col-md-2">
										<label class="mb-2 mr-sm-2 mb-sm-0 ml-md"> Select make </label>
									</div>
									<div class="col-md-10">
										<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="make" data-plugin-selectTwo>
											<option value="">All</option>
											<?php foreach ($all_makes as $make) { ?>
												<option value="<?= $make ?>" <?= $make == $selectedMake ? 'selected' : ' ' ?>><?= $make ?> </option>
											<?php } ?>
											&nbsp; &nbsp;
										</select>
									</div>
								</div>
								<?php if ($campType >= 2) { ?>
									<div class="row mb-sm">
										<div class="col-md-2">
											<label class="mb-2 mr-sm-2 mb-sm-0 ml-md"> Select model </label>
										</div>
										<div class="col-md-10">
											<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="model" data-plugin-selectTwo>
												<option value="">All</option>
												&nbsp; &nbsp;
												<?php foreach ($all_models as $model) { ?>
													<option value="<?= $model ?>" <?= $model == $selectedModel ? 'selected' : ' ' ?>><?= $model ?> </option>
												<?php } ?>
											</select>
										</div>
									</div>
								<?php } ?>
								<?php if ($campType >= 3) { ?>
									<div class="row mb-sm">
										<div class="col-md-2">
											<label class="mb-2 mr-sm-2 mb-sm-0 ml-md"> Select year </label>
										</div>
										<div class="col-md-10">
											<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="year" data-plugin-selectTwo>
												<option value="">All</option>
												&nbsp; &nbsp;
												<?php foreach ($all_years as $year) { ?>
													<option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : ' ' ?>><?= $year ?> </option>
												<?php } ?>
											</select>
										</div>
									</div>
								<?php } ?>
								<?php if ($campType >= 4) { ?>
									<div class="row mb-sm">
										<div class="col-md-2">
											<label class="mb-2 mr-sm-2 mb-sm-0 ml-md"> Select trim </label>
										</div>
										<div class="col-md-10">
											<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="trim" data-plugin-selectTwo>
												<option value="">All</option>
												&nbsp; &nbsp;
												<?php foreach ($all_trims as $trim) { ?>
													<option value="<?= $trim ?>" <?= $trim == $selectedTrim ? 'selected' : ' ' ?>><?= $trim ?> </option>
												<?php } ?>
											</select>
										</div>
									</div>
								<?php } ?>
							<?php } ?>
							<div class="row mb-sm">
								<div class="col-md-2">
									<label class="mb-2 mr-sm-2 mb-sm-0 ml-md"> CPC </label>
								</div>
								<div class="col-md-10">
									<input type="text" class="form-control" name="cpc" value="<?= $current_setting ? $current_setting->amount : "" ?>" />
								</div>
							</div>
							<button name="update_setting" class="btn btn-primary ml-md"> Submit</button>
						</form>
					</div>

				</section>
				<section id="ad-setting" class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">CPC Settings</h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-md-10" style="margin-left: -15px">
									<div class="table-responsive">
										<table id="d-table" class="table table-condensed">
											<thead>
												<tr>
													<th>Campaign</th>
													<th>Make</th>
													<th>Model</th>
													<th>Year</th>
													<th>Trim</th>
													<th>CPC</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($settings as $s) { ?>
													<tr>
														<td><?= $s->campaign ?></td>
														<td><?= $s->make ?></td>
														<td><?= $s->model ?></td>
														<td><?= $s->year ?></td>
														<td><?= $s->trim ?></td>
														<td><?= $s->amount ?></td>
														<td><a href="<?= $_SERVER['PHP_SELF'] ?>?dealership=<?= $s->dealership ?>&campaign=<?= $s->campaign ?>&make=<?= $s->make ?>&model=<?= $s->model ?>&year=<?= $s->year ?>&trim=<?= $s->trim ?>">Edit</a></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>
<script>
	$(function() {
		$('select.filter').on('change', function(e) {
			$('input[name="cpc"]').removeAttr('name');
			$('#ad-setting').html('')
			var el = $(this);
			var make = $('select[name="make"]');
			var model = $('select[name="model"]');
			var year = $('select[name="year"]');
			var trim = $('select[name="trim"]');
			var name = el.attr('name');
			if (name == 'campaign') {
				make.val('');
				model.val('');
				year.val('');
				trim.val('');
			} else if (name == 'make') {
				model.val('');
				year.val('');
				trim.val('');
			} else if (name == 'model') {
				year.val('');
				trim.val('');
			} else if (name == 'year') {
				trim.val('');
			}
			var f = el.closest('form');
			f.attr('method', 'GET');
			el.closest('form').submit();
		});
	});
</script>
<?php
include 'bolts/footer.php';
