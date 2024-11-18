<?php

error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;
use sMedia\AdSync\Controller\AdwordsController;
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


$dealership = $user['cron_name'];
$selectedTag = isset($_GET['tag']) ? $_GET['tag'] : '';
// $adwordsController = new AdwordsController($dealership);
// $adwordsController->setStockType('new');

// $specialCampaigns = array_map(function ($c) {
// return $c['name'];
// }, $adwordsController->loadSpecialCampaigns());

// $adwordsController->setStockType('used');
// $specialCampaigns = array_merge($specialCampaigns, array_map(function ($c) {
// return $c['name'];
// }, $adwordsController->loadSpecialCampaigns()));

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
$campaign = isset($_GET['campaign']) ? $_GET['campaign'] : 'smedia_used_make';
$campType = count(explode('_', $campaign)) - 2;

$selectedMake = isset($_GET['make']) ? $_GET['make'] : '';
$selectedModel = isset($_GET['model']) ? $_GET['model'] : '';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : '';
$selectedTrim = isset($_GET['trim']) ? $_GET['trim'] : '';

$selectedValues = [
	'campaign' => $campaign,
	'dealership' => $dealership,
	'tag' => $selectedTag,
	'make' => $selectedMake,
	'model' => $selectedModel,
	'year' => $selectedYear,
	'trim' => $selectedTrim,
	'ad_type' => 'esa',
];

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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["update_setting"]) {
	$values = array_merge((array)$_POST['headings'], (array)$_POST['descriptions']);
	if (!empty($dealership)) {
		// $db_connect->query("DELETE FROM ad_details WHERE campaign = '$campaign' AND  dealership='$dealership' AND make='$selectedMake' AND model='$selectedModel' AND year='$selectedYear' AND trim='$selectedTrim'");
		$delete_query = DB::table('ad_details');
		foreach ($selectedValues as $k => $v) {
			$delete_query->where($k, '=', $v);
		}
		$delete_query->delete();

		$insert_query = DB::table('ad_details');
		$rows = [];
		foreach ($values as $val) {
			$rows[] = array_merge($selectedValues, ['value' => $val['text'], 'entryType' => $val['position']]);
		}

		$insert_query->insert($rows);
	}
	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}
// Default Value for dealer
$setting = [
	'headings' => [],
	'descriptions' => []
];
if (empty($selectedMake) && empty($selectedModel) && empty($selectedYear) && empty($selectedTrim)) {
	$setting['headings'] = [
		["text" => "[year] [make] [model] [price]", "position" => "h1"],
		["text" => "Book a Test Drive", "position" => "h2"],
		["text" => "View Prices, Deals and Offers", "position" => "h3"],
	];

	$setting['descriptions'] = [
		["text" => "[year] [make] [model]", "position" => "d1"],
		["text" => "See Inventory, Specs & Get a Quote. Call Today & Schedule A Test Drive!", "position" => "d2"],
	];
}

$select_query = DB::table('ad_details');
foreach ($selectedValues as $k => $v) {
	$select_query->where($k, '=', $v);
}

$result = $select_query->orderBy('id')->get();

if ($result->isNotEmpty()) {
	$setting =  $result->mapToGroups(function ($v) {
		return [($v->entryType[0] == "h" ? 'headings' : 'descriptions') => [
			'text' => $v->value,
			'position' => $v->entryType
		]];
	});
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'esa-ad-setting';
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
						<form method="GET" class="form-inline">
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
							&nbsp; &nbsp;
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
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Campaign </label>
							&nbsp; &nbsp;
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="campaign" data-plugin-selectTwo>
								<?php
								foreach ($campaignTypes as $campaignType) {
								?>
									<option value="<?= $campaignType ?>" <?= $campaignType == $campaign ? 'selected' : ' ' ?>><?= $campaignType ?> </option>
								<?php
								} ?>
								&nbsp; &nbsp;</select>
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Tag </label>
							&nbsp; &nbsp;
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="tag" data-plugin-selectTwo onchange="(function(e){e.target.closest('form').submit()})(event)">
								<?php
								foreach (AdwordsController::TAGS as $key => $tag) {
								?>
									<option value="<?= $tag ?>" <?= $selectedTag == $tag ? 'selected' : ' ' ?>><?= $tag ?></option>
								<?php
								} ?>
								&nbsp; &nbsp;
							</select>
							<?php if (!in_array($campaign, $no_custom)) { ?>
								<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select make </label>
								&nbsp; &nbsp;
								<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="make" data-plugin-selectTwo>
									<option value="">All</option>
									<?php foreach ($all_makes as $make) { ?>
										<option value="<?= $make ?>" <?= $make == $selectedMake ? 'selected' : ' ' ?>><?= $make ?> </option>
									<?php } ?>
									&nbsp; &nbsp;
								</select>
								<?php if ($campType >= 2) { ?>
									<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select model </label>
									&nbsp; &nbsp;
									<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="model" data-plugin-selectTwo>
										<option value="">All</option>
										&nbsp; &nbsp;
										<?php foreach ($all_models as $model) { ?>
											<option value="<?= $model ?>" <?= $model == $selectedModel ? 'selected' : ' ' ?>><?= $model ?> </option>
										<?php } ?>
									</select>
								<?php } ?>
								<?php if ($campType >= 3) { ?>
									<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select year </label>
									&nbsp; &nbsp;
									<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="year" data-plugin-selectTwo>
										<option value="">All</option>
										&nbsp; &nbsp;
										<?php foreach ($all_years as $year) { ?>
											<option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : ' ' ?>><?= $year ?> </option>
										<?php } ?>
									</select>
								<?php } ?>
								<?php if ($campType >= 4) { ?>
									<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select trim </label>
									&nbsp; &nbsp;
									<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate filter" name="trim" data-plugin-selectTwo>
										<option value="">All</option>
										&nbsp; &nbsp;
										<?php foreach ($all_trims as $trim) { ?>
											<option value="<?= $trim ?>" <?= $trim == $selectedTrim ? 'selected' : ' ' ?>><?= $trim ?> </option>
										<?php } ?>
									</select>
								<?php } ?>
							<?php } ?>
							<!--button class="btn btn-primary ml-md"> Submit</button-->
						</form>
					</div>

				</section>
				<section id="ad-setting" class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">Google AdWords <?php $listOfCam = explode('_', $campaign);
																foreach ($listOfCam as $item) {
																	echo ucfirst($item) . ' ';
																} ?> Setting</h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form method="post">
									<div class="col-md-10" style="margin-left: -15px">
										<div class="table-responsive">
											<table id="h1-table" class="table table-condensed">
												<thead>
													<tr>
														<th class="col-md-10">Headings</th>
														<th class="col-md-2">
															<button class="btn" id='add-h1-row' type="button"><i class="fa fa-plus"></i></button>
														</th>
													</tr>
												</thead>
												<tbody id="h1-body">
													<?php foreach ($setting['headings'] as $i => $heading) { ?>
														<tr id="row-<?= $i ?>">
															<td>
																<div class="row">
																	<div class="col-md-9">
																		<input name='headings[<?= $i ?>][text]' value='<?= $heading['text'] ?>' type='text' class='form-control' />
																	</div>
																	<div class="col-md-3">
																		<select class="form-control" name='headings[<?= $i ?>][position]'>
																			<?= implode('', option_maker(['h1' => "Heading 1", 'h2' => "Heading 2", 'h3' => "Heading 3"], $heading['position'])) ?>
																		</select>
																	</div>
																</div>
															</td>
															<td>
																<button class="delete-row btn" type="button"><i class="fa fa-trash"></i></button>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>

											<br />
											<br />

											<table id="d-table" class="table table-condensed">
												<thead>
													<tr>
														<th class="col-md-10">Descriptions</th>
														<th class="col-md-2">
															<button class="btn" id='add-d1-row' type="button"><i class="fa fa-plus"></i></button>
														</th>
													</tr>
												</thead>
												<tbody id="d1-body">
													<?php foreach ($setting['descriptions'] as $i => $description) { ?>
														<tr id="row-<?= $i ?>">
															<td>
																<div class="row">
																	<div class="col-md-9">
																		<input name='descriptions[<?= $i ?>][text]' value='<?= $description['text'] ?>' type='text' class='form-control' />
																	</div>
																	<div class="col-md-3">
																		<select class="form-control" name='descriptions[<?= $i ?>][position]'>
																			<?= implode('', option_maker(['d1' => "Description 1", 'd2' => "Description 2"], $description['position'])) ?>
																		</select>
																	</div>
																</div>
															</td>

															<td>
																<button class="delete-row btn" type="button"><i class="fa fa-trash"></i></button>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>

											<input name="update_setting" type="submit" value="Update" class=" btn btn-info">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
</div>
<script>
	var headingRow = `<tr id="row-{{id}}">
						<td>
							<div class="row">
								<div class="col-md-9">
									<input name='headings[{{id}}][text]' value='' type='text' class='form-control' />
								</div>
								<div class="col-md-3">
									<select class="form-control" name='headings[{{id}}][position]'>
										<?= implode('', option_maker(['h1' => "Heading 1", 'h2' => "Heading 2", 'h3' => "Heading 3"], 'h1')) ?>
									</select>
								</div>
							</div>
						</td>
						<td>
							<button class="delete-row btn" type="button"><i class="fa fa-trash"></i></button>
						</td>
					</tr>`;

	var descriptionRow = `<tr id="row-{{id}}">
							<td>
								<div class="row">
									<div class="col-md-9">
										<input name='descriptions[{{id}}][text]' value='' type='text' class='form-control' />
									</div>
									<div class="col-md-3">
										<select class="form-control" name='descriptions[{{id}}][position]'>
											<?= implode('', option_maker(['d1' => "Description 1", 'd2' => "Description 2"], 'd1')) ?>
										</select>
									</div>
								</div>
							</td>
							<td>
								<button class="delete-row btn" type="button"><i class="fa fa-trash"></i></button>
							</td>
						</tr>`;
	// Add row

	$(document).on("click", "#add-h1-row", function() {
		var b = $('#h1-body');
		var lr = b.find('tr').last();
		var id = lr.length ? parseInt(lr.attr('id').replace('row-', '')) + 1 : 0;
		b.append(headingRow.replaceAll('{{id}}', id));
		return false;
	});

	// Remove criterion
	$(document).on("click", ".delete-row", function() {
		$(this).closest('tr').remove();
		return false;
	});

	$(document).on("click", "#add-d1-row", function() {
		var b = $('#d1-body');
		var lr = b.find('tr').last();
		var id = lr.length ? parseInt(lr.attr('id').replace('row-', '')) + 1 : 0;
		b.append(descriptionRow.replaceAll('{{id}}', id));
		return false;
	});

	$(function() {
		$('select.filter').on('change', function(e) {
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
			el.closest('form').submit();
		});
	});
</script>
<?php
include 'bolts/footer.php';
