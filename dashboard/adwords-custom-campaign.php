<?php

// header('Content-Type: application/json');

use Illuminate\Database\Capsule\Manager as DB;
use sMedia\AdSync\Utils;

use function Aws\filter;

error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once '../includes/init-db.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


$db_connect = new DbConnect('');

global $user;
$all_dealerships = $db_connect->get_all_dealers(1);
$dealership = $user['cron_name'];

function do_the_wired_reload()
{
	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
	$stock_type = filter_input(INPUT_POST, 'stock_type');
	$make = filter_input(INPUT_POST, 'make');
	$model = filter_input(INPUT_POST, 'model');
	$year = filter_input(INPUT_POST, 'year');
	$trim = filter_input(INPUT_POST, 'trim');
	switch ($_POST['action']) {
		case 'add-new':
			$bing = isset($_POST['bing']) ? 1 : 0;
			$adwords = isset($_POST['adwords']) ? 1 : 0;
			DB::table('tbl_ad_custom_campaigns')->insert([
				'stock_type' => $stock_type,
				'make' => $make,
				'model' => $model,
				'year' => $year,
				'trim' => $trim,
				'dealership' => $dealership,
				'bing' => $bing,
				'adwords' => $adwords
			]);
			do_the_wired_reload();
			break;
		case 'remove':
			DB::table('tbl_ad_custom_campaigns')->where([
				['stock_type', '=', $stock_type],
				['make', '=', $make],
				['model', '=', $model],
				['year', '=', $year],
				['trim', '=', $trim],
				['dealership', '=', $dealership]
			])->delete();
			do_the_wired_reload();
			break;
		case 'update':
			if (
				isset($_POST['data']) &&
				is_array($_POST['data']) &&
				!empty($_POST['data'])
			) {
				foreach ($_POST['data'] as $key => $services) {
					[$make, $model, $year, $trim] = explode('_', $key);
					DB::table('tbl_ad_custom_campaigns')
						->where([
							['stock_type', '=', $stock_type],
							['make', '=', $make],
							['model', '=', $model],
							['year', '=', $year],
							['trim', '=', $trim],
							['dealership', '=', $dealership]
						])
						->update([
							'bing' => isset($services['bing']) ? 1 : 0,
							'adwords' => isset($services['adwords']) ? 1 : 0
						]);
				}
			}
			break;
	}
}

$custom_campaigns = DB::table('tbl_ad_custom_campaigns')->where('dealership', $dealership)->get();

$make_model_year_trim_data = Utils::loadMakeModelYearTrim($dealership);

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'custom-campaign';
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
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" onchange="(function(e){e.target.closest('form').submit()})(event)" data-plugin-selectTwo>
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
						</form>
					</div>

				</section>
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title">Custom campaigns</h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="col-md-10" style="margin-left: -15px">
									<div class="table-responsive">
										<?php if ($custom_campaigns->count() > 0) { ?>
											<form action="<?= $current_url ?>" method="POST">
												<input type="hidden" name="action" value="update">
												<table class="table table-borderd" style="max-width: 600px!important;">
													<thead>
														<tr>
															<td>Stock Type</td>
															<td>Make</td>
															<td>Model</td>
															<td>Year</td>
															<td>Trim</td>
															<td>Adwords</td>
															<td>Bing</td>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($custom_campaigns as $campaign) { ?>
															<tr>
																<td>
																	<strong><?= !empty($campaign->stock_type) ? $campaign->stock_type : 'All' ?></strong>
																</td>
																<td>
																	<strong><?= $campaign->make ?></strong>
																</td>
																<td>
																	<strong><?= $campaign->model ?></strong>
																</td>
																<td>
																	<strong><?= $campaign->year ?></strong>
																</td>
																<td>
																	<strong><?= $campaign->trim ?></strong>
																</td>
																<td>
																	<input type="checkbox" name='data[<?= "{$campaign->stock_type}_{$campaign->make}_{$campaign->model}_{$campaign->year}_{$campaign->trim}" ?>][adwords]' <?= $campaign->adwords ? "checked='checked'" : '' ?> value="1" />
																</td>
																<td>
																	<input type="checkbox" name='data[<?= "{$campaign->stock_type}_{$campaign->make}_{$campaign->model}_{$campaign->year}_{$campaign->trim}" ?>][bing]' <?= $campaign->bing ? "checked='checked'" : '' ?> value="1" />
																</td>
																<td class="text-right">
																	<button class="btn btn-warning remove-campaign" data-stock_type="<?= $campaign->stock_type ?>" data-make="<?= $campaign->make ?>" data-model="<?= $campaign->model ?>" data-year="<?= $campaign->year ?>" data-trim="<?= $campaign->trim ?>" type="button"><i class="fa fa-minus"></i></button>
																</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
												<button class="btn btn-success" type="submit">Update</button>
												<a class="btn btn-primary" href="#" id="add-new-btn" data-toggle="modal" data-target="#newModal">Add New</a>
											</form>
										<?php } else { ?>
											<div>No custom campaign found</div>
											<a class="btn btn-primary" href="#" data-toggle="modal" data-target="#newModal">Add New</a>
										<?php } ?>
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

<!-- Modal -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Create custom campaign</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= $current_url ?>" method="POST">
					<input type="hidden" name="action" value="add-new">
					<div class="form-group">
						<label>Stock Type</label>
						<select name="stock_type" class="form-control select-2" style="width: 100%;">
							<option value="">All</option>
							<option value="new">New</option>
							<option value="used">Used</option>
						</select>
					</div>
					<div class="form-group">
						<label>Select a make</label>
						<select name="make" class="form-control select-2" style="width: 100%;"></select>
					</div>
					<div class="form-group">
						<label>Select a model</label>
						<select name="model" class="form-control select-2" style="width: 100%;"></select>
					</div>
					<div class="form-group">
						<label>Select a year</label>
						<select name="year" class="form-control select-2" style="width: 100%;"></select>
					</div>
					<div class="form-group">
						<label>Select a trim</label>
						<select name="trim" class="form-control select-2" style="width: 100%;"></select>
					</div>
					<div class="form-group">
						<label for="en_adwords">Enable for adwords</label>
						<input id="en_adwords" type="checkbox" name="adwords" checked value="true">
					</div>
					<div class="form-group">
						<label for="en_bing">Enable for bing</label>
						<input id="en_bing" type="checkbox" name="bing" value="true">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>
<form id="remove-form" action="<?= $current_url ?>" method="POST">
	<input type="hidden" name="stock_type" value="">
	<input type="hidden" name="make" value="">
	<input type="hidden" name="model" value="">
	<input type="hidden" name="year" value="">
	<input type="hidden" name="trim" value="">
	<input type="hidden" name="action" value="remove">
</form>

<script>
	var makes_models_years_trims = <?= json_encode($make_model_year_trim_data) ?>;

	var cars = {
		make: {},
		model: {},
		year: {},
		trim: {},
	};
	var allKeys = [
		'___',
		'make___',
		'_model__',
		'__year_',
		'___trim',
		'make_model__',
		'make__year_',
		'make___trim',
		'_model_year_',
		'_model__trim',
		'__year_trim',
		'make_model_year_',
		'make_model__trim',
		'make__year_trim',
		'_model_year_trim',
		'make_model_year_trim',
	];

	function pushIn(key, car) {
		for (let n in allKeys) {
			let subkey = allKeys[n];
			subkey = subkey
				.replace('make', car.make)
				.replace('model', car.model)
				.replace('year', car.year)
				.replace('trim', car.trim);

			cars[key][subkey] = cars[key][subkey] || [];
			if (!cars[key][subkey].includes(car[key])) {
				cars[key][subkey].push(car[key])
			}
		}
	}

	for (var n in makes_models_years_trims) {
		for (var k in cars) {
			pushIn(k, makes_models_years_trims[n]);
		}
	}

	var makes_models_years_trims = {};
	var makes_models_years = {};
	var makes_models = {};
	var makes = {};
	var models = {};
	var years = {};
	var trims = {};
	var selected = {
		make: '',
		model: '',
		year: '',
		trim: '',
	}

	var curKey = function() {
		return Object.values(selected).join('_');
	}

	$(function() {
		var modal = $("#newModal");
		var selectStockType = $("select[name='stock_type']", modal);
		var select = {
			make: $("select[name='make']", modal),
			model: $("select[name='model']", modal),
			year: $("select[name='year']", modal),
			trim: $("select[name='trim']", modal),
		}
		var saveBtn = $('button.btn-primary', modal)
		var defalut_option = '<option value="">---</option>';

		$('.select-2').each(function() {
			$(this).select2({
				dropdownParent: $(this).parent()
			});
		});

		let updateSelect = (whichOne, key) => {
			select[whichOne].html(defalut_option + cars[whichOne][key].map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
		}

		select.make.on('change', function() {
			selected = {
				make: $(this).val(),
				model: '',
				year: '',
				trim: ''
			};
			var key = curKey();
			['model', 'year', 'trim'].forEach(function(v) {
				updateSelect(v, key);
			});
		});

		select.model.on('change', function() {
			selected = {
				make: selected.make,
				model: $(this).val(),
				year: '',
				trim: ''
			};
			var key = curKey();
			['year', 'trim'].forEach(function(v) {
				updateSelect(v, key);
			});
		});

		select.year.on('change', function() {
			selected = {
				make: selected.make,
				model: selected.model,
				year: $(this).val(),
				trim: ''
			};
			var key = curKey();
			['trim'].forEach(function(v) {
				updateSelect(v, key);
			});
		});

		select.trim.on('change', function() {
			selected.trim = $(this).val();
		});

		/* selectModel.on('change', function() {
			var make = selectMake.val();
			var model = $(this).val();
			if (!!make) {
				var sYears = (makes_models_years[make] || {})[model] || [];
			} else {
				try {
					var sYears = Object.values(makes_models_years).filter(function(v) {
						return !!v[model] ? true : false;
					})[0][model];
				} catch (e) {
					var sYears = [];
				}
			}
			selectYear.html(defalut_option + sYears.map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
		});

		selectYear.on('change', function() {
			var make = selectMake.val();
			var model = selectModel.val();
			var year = $(this).val();
			if (!!make && !!model) {
				var sTrims = ((makes_models_years_trims[make] || {})[model])[year] || [];
			} else {
				try {
					var sTrims = Object.values(makes_models_years).filter(function(v) {
						return !!v[model] ? true : false;
					})[0][model];
				} catch (e) {
					var sTrims = [];
				}
			}
			selectTrim.html(defalut_option + sTrims.map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
		}); */

		modal.on('show.bs.modal', function() {
			select.make.html(defalut_option + cars.make.___.map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
			select.model.html(defalut_option + cars.model.___.map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
			select.year.html(defalut_option + cars.year.___.map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
			select.trim.html(defalut_option + cars.trim.___.map(function(v) {
				return '<option value="' + v + '">' + v + '</option>';
			}).join());
		});

		saveBtn.on('click', function() {
			var stockType = selectStockType.val();
			if (!(selected.make == '---' &&
					selected.model == '---' &&
					selected.year == '---' &&
					selected.trim == '---')) {
				$('form', modal).submit();
			}
		})

		$('.remove-campaign').on('click', function(e) {
			e.preventDefault();
			var form = $('#remove-form');
			var stockType = $(this).attr('data-stock_type');
			var make = $(this).attr('data-make');
			var model = $(this).attr('data-model');
			var year = $(this).attr('data-year');
			var trim = $(this).attr('data-trim');
			$('input[name="stock_type"]', form).val(stockType);
			$('input[name="make"]', form).val(make);
			$('input[name="model"]', form).val(model);
			$('input[name="year"]', form).val(year);
			$('input[name="trim"]', form).val(trim);
			form.submit();
		});
	})
</script>
<?php
include 'bolts/footer.php';
