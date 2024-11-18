<?php

use sMedia\AdSync\Controller\AdSyncBase;
use sMedia\AdSync\Controller\AdwordsController;

error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once '../includes/init-db.php';
require_once 'includes/loader.php';
$companyQuery = "SELECT dealership, company_name FROM dealerships ORDER BY company_name ASC";
$companyQueryResult = $db_connect->query($companyQuery);
$dealerships = [];

while ($companyFetch = mysqli_fetch_assoc($companyQueryResult)) {
	$company = trim($companyFetch['company_name']);

	if ($company == '') {
		$company = $companyFetch['dealership'];
	}
	$dealerships[$companyFetch['dealership']] = ucfirst($company);
}

natcasesort($dealerships);
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$db_connect = new DbConnect('');

if (isset($_POST['clear-custom']) && !empty($_POST['clear-custom'])) {
	$ds = $db_connect->real_escape_string($_POST['clear-custom']);
	if ($ds == 'all') {
		$condition = "!='global'";
	} else {
		$condition = "='$ds'";
	}
	$db_connect->query("DELETE FROM ad_keywords WHERE dealership{$condition}");
}

$currentDealership = isset($_GET['dealership']) ? $_GET['dealership'] : 'global';
$currentTag = isset($_GET['tag']) ? $_GET['tag'] : '';

$campaignTypes = [
	'smedia_used_make',
	'smedia_used_make_model',
	'smedia_used_make_model_year',
	'smedia_used_make_model_year_trim',
	'smedia_used_make_bodystyle',
	'smedia_new_make',
	'smedia_new_make_model',
	'smedia_new_make_model_year',
	'smedia_new_make_model_year_trim',
	'smedia_new_make_bodystyle',
	// 'smedia_aged_used_make',
	// 'smedia_aged_used_make_model',
	// 'smedia_aged_used_make_model_year',
	// 'smedia_aged_new_make',
	// 'smedia_aged_new_make_model',
	// 'smedia_aged_new_make_model_year'
];

if ($currentDealership != 'global') {
	$adwordsController = new AdwordsController($currentDealership);
	$campaignTypes = array_map(
		function ($v) use ($currentDealership) {
			return str_replace("_$currentDealership", '', $v);
		},
		array_merge(
			$adwordsController->setType('used')->setTag($currentTag)->generateValidCampaignNames()->validCampaigns,
			$adwordsController->setType('new')->setTag($currentTag)->generateValidCampaignNames()->validCampaigns
		)
	);
}

$campaign = isset($_GET['campaign'])
	? (in_array($_GET['campaign'], $campaignTypes) ? $_GET['campaign'] : $campaignTypes[0])
	: $campaignTypes[0];

$companyQuery = "SELECT dealership, company_name FROM dealerships ORDER BY company_name ASC";
$companyQueryResult = $db_connect->query($companyQuery);
$dealerships = [];

while ($companyFetch = mysqli_fetch_assoc($companyQueryResult)) {
	$company = trim($companyFetch['company_name']);

	if ($company == '') {
		$company = $companyFetch['dealership'];
	}
	$dealerships[$companyFetch['dealership']] = ucfirst($company);
}

natcasesort($dealerships);

$dealership_count_result = $db_connect->query("SELECT dealership, COUNT(dealership) as count FROM  ad_keywords WHERE dealership <> 'global' group by dealership ");
$custom_count = [];

while ($count = mysqli_fetch_assoc($dealership_count_result)) {
	$dealership = trim($count['dealership']);

	if (isset($dealerships[$dealership])) {
		// $dealerships[$dealership]   .= " (custom {$count['count']})";
		$custom_count[$dealership] = $count['count'];
	}
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["update_keyword"]) {
	$keywod = $_POST["keyword"];
	$typ = $_POST["type"];
	$adwords_enabled = $_POST["adwords"];
	$bing_enabled = $_POST["bing"];
	$db_connect->query("DELETE FROM ad_keywords WHERE keyWordType = 'POSITIVE' AND  campaign = '$campaign' AND dealership='$currentDealership' AND tag='$currentTag' ");
	for ($i = 0; $i < count($keywod); $i++) {
		if (!empty($keywod[$i])) {
			$keywod_text = $db_connect::get_connection_write()->real_escape_string($keywod[$i]);
			$query = "INSERT INTO ad_keywords (campaign,tag,keyWordType,pattern,matchType,adwords, bing, dealership) VALUES ('$campaign', '$currentTag','POSITIVE','$keywod_text','$typ[$i]', $adwords_enabled[$i], $bing_enabled[$i], '$currentDealership') ";
			// echo $keywod_text;
			// echo $query;
			// exit();
			$db_connect->query($query);
		}
	}
	echo ("<script type='text/javascript'> location.href = location.href; </script>");
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["update_neg_keyword"]) {
	$negKeywod = $_POST["negKeyword"];
	$negTyp = $_POST["negType"];
	$adwords_enabled = $_POST["adwords"];
	$bing_enabled = $_POST["bing"];
	$db_connect->query("DELETE FROM ad_keywords WHERE keyWordType = 'NEGATIVE' AND  campaign = '$campaign'  AND dealership='$currentDealership' AND tag='$currentTag' ");
	for ($i = 0; $i < count($negKeywod); $i++) {
		if (!empty($negKeywod[$i])) {
			$neg_keywod_text = $db_connect::get_connection_write()->real_escape_string($negKeywod[$i]);
			$db_connect->query("INSERT INTO ad_keywords (campaign,tag,keyWordType,pattern,matchType,adwords, bing, dealership) VALUES ('$campaign','$currentTag','NEGATIVE','$neg_keywod_text','$negTyp[$i]' , $adwords_enabled[$i], $bing_enabled[$i], '$currentDealership') ");
		}
	}
	echo ("<script type='text/javascript'> location.href = location.href; </script>");
}



$id = 0;
$negId = 0;
$result = $db_connect->query("SELECT * FROM ad_keywords WHERE campaign = '$campaign' AND dealership='$currentDealership' AND tag='$currentTag'");
while ($row = mysqli_fetch_array($result)) {
	if ($row['keyWordType'] == 'POSITIVE') {
		$keywords[$id]['pattern'] = $row['pattern'];
		$keywords[$id]['matchType'] = $row['matchType'];
		$keywords[$id]['adwords'] = $row['adwords'];
		$keywords[$id]['bing'] = $row['bing'];
		$id++;
	} else {
		$negKeywords[$negId]['pattern'] = $row['pattern'];
		$negKeywords[$negId]['matchType'] = $row['matchType'];
		$negKeywords[$negId]['adwords'] = $row['adwords'];
		$negKeywords[$negId]['bing'] = $row['bing'];
		$negId++;
	}
}

$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

	<?php
	$select = 'keyword';
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
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Campaign </label>
							&nbsp; &nbsp;
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="campaign" data-plugin-selectTwo onchange="(function(e){e.target.closest('form').submit()})(event)">
								<?php
								foreach ($campaignTypes as $campaignType) {
								?>
									<option value="<?= $campaignType ?>" <?= $campaignType == $campaign ? 'selected' : ' ' ?>><?= $campaignType ?> </option>
								<?php
								} ?>
								&nbsp; &nbsp;
							</select>
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Dealership </label>
							&nbsp; &nbsp;
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" data-plugin-selectTwo onchange="(function(e){e.target.closest('form').submit()})(event)">
								<option value="global">Global</option>
								<?php
								foreach ($dealerships as $slug => $name) {
								?>
									<option value="<?= $slug ?>" <?= $currentDealership == $slug ? 'selected' : ' ' ?>><?= $name ?><?= isset($custom_count[$slug]) ? ' (custom ' . $custom_count[$slug] . ')' : '' ?> </option>
								<?php
								} ?>
								&nbsp; &nbsp;
							</select>
							<label class="  mb-2 mr-sm-2 mb-sm-0 ml-md"> Select Tag </label>
							<select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="tag" data-plugin-selectTwo onchange="(function(e){e.target.closest('form').submit()})(event)">
								<?php
								foreach (AdSyncBase::TAGS as $key => $tag) {
								?>
									<option value="<?= $tag ?>" <?= $currentTag == $tag ? 'selected' : ' ' ?>><?= $tag ?></option>
								<?php
								} ?>
								&nbsp; &nbsp;
							</select>
						</form>
					</div>

				</section>
				<section class="panel">
					<div class="panel-body">
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="return confirm('Are you sure? It can not be undone.');" style="display:inline-block">
							<input type="hidden" name="clear-custom" value="all" />
							<button class="btn btn-danger" href="#">Clear all dealership specific keywords</button>
						</form>
						<?php if (isset($custom_count[$currentDealership])) { ?>
							<form action="" method="POST" onsubmit="return confirm('Are you sure? It can not be undone.');" style="display:inline-block">
								<input type="hidden" name="clear-custom" value="<?= $currentDealership ?>" />
								<button class="btn btn-danger" href="#">Clear all <?= $dealerships[$currentDealership] ?> specific keywords</button>
							</form>
						<?php } ?>
					</div>
				</section>
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title"> Google keywords </h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form method="post">
									<div class="col-md-10" style="margin-left: -15px">
										<div class="table-responsive">
											<table id="test-table" class="table table-condensed">
												<thead>
													<tr>
														<th>Keyword</th>
														<th>Type</th>
														<th>Adword</th>
														<th>Bing</th>
														<th>
															<button class="btn" id='add-row' type="button"><i class="fa fa-plus"></i></button>
														</th>
													</tr>
												</thead>
												<tbody id="test-body">
													<?php
													for ($i = 0; $i < $id; $i++) {
													?>
														<tr id="row<?= $i ?>">
															<td>
																<input name='keyword[]' value="<?= htmlspecialchars($keywords[$i]['pattern']) ?>" type='text' class='form-control' />
															</td>
															<td>
																<select name="type[]" class='form-control input-md'>
																	<option value="BROAD" <?= ($keywords[$i]['matchType'] == "BROAD") ? 'selected' : ' ' ?>>
																		BROAD
																	</option>
																	<option value="PHRASE" <?= ($keywords[$i]['matchType'] == "PHRASE") ? 'selected' : ' ' ?>>
																		PHRASE
																	</option>
																	<option value="EXACT" <?= ($keywords[$i]['matchType'] == "EXACT") ? 'selected' : ' ' ?>>
																		EXACT
																	</option>
																</select>
															</td>
															<td>
																<input data-bind="adwords" type="checkbox" <?= 1 == $keywords[$i]['adwords'] ? 'checked' : '' ?> value="1" />
																<input class="adwords" hidden name="adwords[]" value=<?= $keywords[$i]['adwords'] ?>>
															</td>
															<td>
																<input data-bind="bing" type="checkbox" <?= 1 == $keywords[$i]['bing'] ? 'checked' : '' ?> value="1" />
																<input class="bing" hidden name="bing[]" value=<?= $keywords[$i]['bing'] ?>>
															</td>
															<td>
																<button class="delete-row btn" type="button"><i class="fa fa-trash"></i></button>
															</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<input name="update_keyword" type="submit" value="Update Positive Keywords" class=" btn btn-info">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>


				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>
						<h2 class="panel-title"> Google Negative keywords </h2>
					</header>

					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form method="post">
									<div class="col-md-10" style="margin-left: -15px">
										<div class="table-responsive">
											<table id="test-table" class="table table-condensed">
												<thead>
													<tr>
														<th>Keyword</th>
														<th>Type</th>
														<th>Adword</th>
														<th>Bing</th>
														<th>
															<button class="btn" id='add-row-neg' type="button"><i class="fa fa-plus"></i></button>
														</th>
													</tr>
												</thead>
												<tbody id="neg-test-body">
													<?php
													for ($i = 0; $i < $negId; $i++) {
													?>
														<tr id="row<?= $negId ?>">
															<td>
																<input name='negKeyword[]' value="<?= htmlspecialchars($negKeywords[$i]['pattern']) ?>" type='text' class='form-control' />
															</td>
															<td>
																<select name="negType[]" class='form-control input-md'>
																	<option value="BROAD" <?= ($negKeywords[$i]['matchType'] == "BROAD") ? 'selected' : ' ' ?>>
																		BROAD
																	</option>
																	<option value="PHRASE" <?= ($negKeywords[$i]['matchType'] == "PHRASE") ? 'selected' : ' ' ?>>
																		PHRASE
																	</option>
																	<option value="EXACT" <?= ($negKeywords[$i]['matchType'] == "EXACT") ? 'selected' : ' ' ?>>
																		EXACT
																	</option>
																</select>
															</td>
															<td>
																<input data-bind="adwords" type="checkbox" <?= 1 == $negKeywords[$i]['adwords'] ? 'checked' : '' ?> value="1" />
																<input class="adwords" hidden name="adwords[]" value=<?= $negKeywords[$i]['adwords'] ?>>
															</td>
															<td>
																<input data-bind="bing" type="checkbox" <?= 1 == $negKeywords[$i]['bing'] ? 'checked' : '' ?> value="1" />
																<input class="bing" hidden name="bing[]" value=<?= $negKeywords[$i]['bing'] ?>>
															</td>
															<td>
																<button class="neg-delete-row btn" type="button"><i class="fa fa-trash"></i></button>
															</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
											<input name="update_neg_keyword" type="submit" value="Update Negative Keywords" class=" btn btn-info">
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
	// Add row
	var row = <?php echo $id ?>;
	$(document).on("click", "#add-row", function() {
		var new_row = '<tr id="row' + row + '"><td><input name="keyword[]" type="text" class="form-control" /></td><td><select name="type[]" class=\'form-control input-md\'><option value="BROAD" >BROAD</option><option value="PHRASE">PHRASE</option><option value="EXACT" >EXACT</option></select></td> <td> <input data-bind="adwords" type="checkbox" checked value="1" /> <input class="adwords" hidden name="adwords[]" value="1"> </td> <td> <input data-bind="bing" type="checkbox" checked value="1" /> <input class="bing" hidden name="bing[]" value="1"> </td> <td><button class="delete-row btn"  type="button"><i class="fa fa-trash"></i></button></td></tr>';
		// alert(new_row);
		$('#test-body').append(new_row);
		bindValue();
		row++;
		return false;
	});

	// Remove criterion
	$(document).on("click", ".delete-row", function() {
		//  alert("deleting row#"+row);
		if (row > 1) {
			$(this).closest('tr').remove();
			row--;
		}
		return false;
	});

	var negrow = <?php echo $negId ?>;
	$(document).on("click", "#add-row-neg", function() {
		var new_neg_row = '<tr id="negrow' + negrow + '"><td><input name="negKeyword[]" type="text" class="form-control" /></td><td><select name="negType[]" class=\'form-control input-md\'><option value="BROAD" >BROAD</option><option value="PHRASE">PHRASE</option><option value="EXACT" >EXACT</option> <td> <input data-bind="adwords" type="checkbox" checked value="1" /> <input class="adwords" hidden name="adwords[]" value="1"> </td> <td> <input data-bind="bing" type="checkbox" checked value="1" /> <input class="bing" hidden name="bing[]" value="1"> </td> </select></td><td><button class="delete-row btn"  type="button"><i class="fa fa-trash"></i></button></td></tr>';
		// alert(new_row);
		$('#neg-test-body').append(new_neg_row);
		bindValue();
		row++;
		return false;
	});

	// Remove criterion
	$(document).on("click", ".neg-delete-row", function() {
		//  alert("deleting row#"+row);
		if (negrow > 1) {
			$(this).closest('tr').remove();
			negrow--;
		}
		return false;
	});

	function bindValue() {
		$('input[type="checkbox"][data-bind]').unbind('change').change(function(e) {
			var el = $(this);
			var checked = el.is(":checked");
			var bindWith = el.attr('data-bind');
			var field = el.parent().find('input.' + bindWith);
			field.val(checked ? 1 : 0);
			console.log(field, field.val())
		});
	}
	bindValue();
</script>
<?php
include 'bolts/footer.php';
