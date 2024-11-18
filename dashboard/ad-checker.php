<?php
ini_set('default_socket_timeout', 6000);
ini_set('max_execution_time', 6000);
//@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
for ($i = 0; $i < ob_get_level(); $i++) {
	ob_end_flush();
}
ob_implicit_flush(1);
global $CronConfigs, $scrapper_configs, $developer_token, $set_path, $single_config, $worker_logfile;


function logme($text)
{
	global $worker_logfile, $cron_config;

	if ((!$cron_config) || (isset($cron_config['log']) && $cron_config['log'])) {
		file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
	}
}

$single_config = $currentDealership = isset($_GET['dealership']) && !empty($_GET['dealership']) ? filter_input(INPUT_GET, 'dealership', FILTER_SANITIZE_STRING) : '';

if (empty($single_config)) {
	echo json_encode((object) ['success' => false, 'errors' => ['No dealership found']]);
	die();
}

use Illuminate\Database\Capsule\Manager as DB;
use sMedia\AdSync\Controller\AdwordsController;
use sMedia\AdSync\Model\AdModel;
use sMedia\AdSync\Utils;
use sMedia\Logger\Logger;

require_once '../adwords3/config.php';
require_once '../includes/init-db.php';
require_once '../adwords3/utils.php';
require_once '../adwords3/Google/Consts.php';
require_once '../adwords3/Google/Util.php';
require_once '../adwords3/Google/Adwords.php';
require_once 'config.php';
require_once 'includes/loader.php';

$enabled_dealers = DB::table('ad_url_pattern')->select('dealership')->groupBy('dealership')->pluck('dealership')->toArray();
$companyQuery = DB::table('dealerships')->select(['dealership', 'company_name'])->orderBy('company_name', 'asc');

$companyQueryResult = $companyQuery->get()->toArray();
$dealerships = [];

foreach ($companyQueryResult as $company) {
	if (!in_array($company->dealership, $enabled_dealers)) continue;
	$company_name = trim($company->company_name);

	if ($company_name == '') {
		$company_name = trim($company->dealership);
	}
	$dealerships[$company->dealership] = ucfirst($company_name);
}

natcasesort($dealerships);
require_once 'includes/crm-defaults.php';

session_start();

$Configs = LoadConfig($set_path);
$CurrentConfig = $Configs->AccessTokens['marshal'];

$worker_logfile = __DIR__ . '/adwords3/ng_logs/adwords.log';

$logger = Logger::getByPath($worker_logfile) ? Logger::getByPath($worker_logfile) : Logger::add('adwords-test', $worker_logfile);

$adwordsController = new AdwordsController($single_config);



$all_cars = DB::table("{$single_config}_scrapped_data")->where('deleted', '=', 0)->get();
$total_new_cars = count($all_cars->where('stock_type', '=', 'new')->all());
$total_used_cars = count($all_cars->where('stock_type', '=', 'used')->all());

$url_data = DB::table('ad_url_pattern')->where('dealership', '=', $single_config)->where('adwords', '=', '1')->get()->toArray();
$make_model_year_query = DB::table("{$single_config}_scrapped_data")->select([DB::raw("CAST(make as BINARY) AS make_b"), DB::raw("CAST(model as BINARY) AS model_b"), DB::raw("CAST(year as BINARY) AS year_b")])->groupBy(['make_b', 'model_b', 'year_b']);
$make_model_year = $make_model_year_query->get()->toArray();
$urls = [];
// $makes = [];
// $models = [];
// $years = [];
$ad_groups = [
	'make' => [],
	'make_model' => [],
	'make_model_year' => [],
];

if (is_array($url_data) && !empty($url_data)) {
	foreach ($url_data as $url) {
		$urls[str_replace('smedia_', "smedia_{$single_config}_", $url->campaign)] = $url->urlPattern;
	}
}

foreach ($make_model_year as $data) {
	$m = $data->make_b;
	$d = $data->model_b;
	$y = $data->year_b;
	$ad_groups['make'][$m] = $m;
	$ad_groups['make_model']["$m $d"] = "$m||$d";
	$ad_groups['make_model_year']["$m $d $y"] = "$m||$d||$y";
}

function resolve_adgroup_name($group_name, $ad_groups)
{
	$name = implode(' ', array_slice(explode(' ', $group_name), 0, -1));
	foreach ($ad_groups as $key => $groups) {
		if (isset($groups[$name])) {
			$keys = explode('_', $key);
			$values = explode('||', $groups[$name]);
			return array_combine($keys, $values);
		}
	}
}

/* header('Content-Type: application/json');
echo json_encode($ad_groups);
exit(); */
// resolve_adgroup_name('Ram ProMaster Cargo Van #v4', $ad_groups);
// exit();

$adwordsController
	->setLogger($logger)
	->useCronConfig($CronConfigs[$single_config])
	->setAdwordService(new AdwordsService(
		Consts::ServiceNamespace,
		$CurrentConfig,
		$developer_token,
		$CronConfigs[$single_config]['customer_id']
	));

$adwordsAd = new AdModel();
$all_ads_in_db = [];
$all_ads = $adwordsAd->setTable($adwordsController->tableName)->where('dealership', '=', $single_config)->get()->toArray();
if (is_array($all_ads) && !empty($all_ads)) {
	foreach ($all_ads as $ad) {
		$all_ads_in_db[$ad['adword_id']] = $ad;
	}
}

if (isset($_GET['test'])) {
	$campaign_groups = unserialize(file_get_contents('campaign_groups'));
} else {
	$campaign_groups = $adwordsController->getAdGroupsFromCampaigns();
}
if (isset($_GET['cache'])) {
	file_put_contents('campaign_groups', serialize($campaign_groups));
}
$result = [];
$adword_ads = [];
$ads_list = [];
$group_list = [];
foreach ($campaign_groups as $campaign_name => $groups) {
	if (isset($_GET['test'])) {
		$ads = unserialize(file_get_contents($campaign_name));
	} else {
		$ads = $adwordsController->adwordService->GetAdsFromAdGroups(array_keys($groups));
	}
	if (isset($_GET['cache'])) {
		file_put_contents($campaign_name, serialize($ads));
	}
	if ($ads) {
		$adword_ads[$campaign_name] = $ads;
	}
	$group_list = $group_list + $groups;
}


foreach ($adword_ads as $campaign_name => $ads) {
	if (is_array($ads) && !empty($ads)) {
		foreach ($ads as $ad) {
			$the_ad = [
				'id' => $ad->ad->id,
				'headlinePart1' => $ad->ad->headlinePart1,
				'headlinePart2' => $ad->ad->headlinePart2,
				'headlinePart3' => $ad->ad->headlinePart3,
				'description' => $ad->ad->description,
				'description2' => $ad->ad->description2,
				'url' => $ad->ad->finalUrls[0],
				'adgroup' => $group_list[$ad->adGroupId],
				'campaign' => $campaign_name,
			];

			if (isset($all_ads_in_db[$ad->ad->id])) {
				$db_ad = $all_ads_in_db[$ad->ad->id];
				$the_ad['hash'] = $db_ad['hash'];
				$the_ad['db_url'] = $db_ad['url'];
				$the_ad['stock_type'] = $db_ad['stock_type'];
				$the_ad['created_at'] = $db_ad['created_at'];
			}

			$the_ad['terms'] = resolve_adgroup_name($group_list[$ad->adGroupId]->name, $ad_groups);
			$car_query = $all_cars->where('stock_type', '=', $the_ad['stock_type']);
			foreach ($the_ad['terms'] as $term => $val) {
				$car_query = $car_query->where($term, '=', $val);
			}
			$ad_cars = [];
			if (!empty($the_ad['terms']) && !empty($all_cars)) {
				$ad_cars = $car_query->all();
			}
			$car_data = [];
			if (!empty($ad_cars)) {
				foreach ($ad_cars as $car) {
					$car_data[] = [
						'svin'	=> $car->svin,
						'stock_number'	=> $car->stock_number,
						'url'	=> $car->url,
					];
				}
			}
			$the_ad['cars'] = $car_data;
			$the_ad['deleted'] = false;
			preg_match($scrapper_configs[$single_config]['vdp_url_regex'], $the_ad['url'], $match);
			$the_ad['is_vdp'] = empty($match) ? false : true;
			$the_ad['reg'] = $scrapper_configs[$single_config]['vdp_url_regex'];
			$the_ad['url_match'] = false;

			switch (count($car_data)) {
				case 0:
					$the_ad['deleted'] = true;
					break;
				case 1:
					$the_ad['url_match'] = $car_data[0]['url'];
					break;
				default:
					$values = [];
					foreach ($the_ad['terms'] as $k => $v) {
						$values[$k]	= str_replace(' ', '%20', $v);
					}
					$url = Utils::processTemplate($urls[$campaign_name], $values);
					$the_ad['url_match'] = $url;
					break;
			}

			$ads_list[$ad->ad->id] = $the_ad;
		}
	}
}

$campaign_ads = [];
foreach ($ads_list as $ad) {
	$campaign_ads[$ad['campaign']][] = $ad;
}
ksort($campaign_ads);

/* header('Content-Type: application/json');
echo json_encode($ads_list);
exit(); */
require_once 'bolts/header.php';
?>
<div class="inner-wrapper">
	<?php
	$select = 'ad-checker';
	require_once 'bolts/sidebar.php';
	?>
	<section role="main" class="content-body">
		<header class="page-header"></header>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<div class="panel-body">

						<form method="GET" class="form-inline">
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
						</form>
					</div>
				</section>
				<div>Total new car found: <?= $total_new_cars ?></div>
				<div>Total used car found: <?= $total_used_cars ?></div>
				<?php
				foreach ($campaign_ads as $c => $list) {
					$total = 0;
				?>
					<section class="panel">
						<h5>
							Campaign name: <?= $c ?>
						</h5>
						<div>Total ads: <?= count($list) ?></div>
						<table class="table table-bordered table-striped mb-none table-advanced">
							<thead>
								<tr>
									<th>AdGroup</th>
									<th>Title</th>
									<th>Created At</th>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th>Car Count</th>
									<th>Url Type</th>
									<th>Correct Type?</th>
									<th>Url Status</th>
									<th>Url</th>
									<th>Url Match</th>
									<th>Hash</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list as $id => $ad) {
									$total += count($ad['cars']); ?>
									<tr id="<?= $id ?>">
										<td><?= $ad['adgroup']->name ?></td>
										<td><?= $ad['headlinePart1'] ?></td>
										<td><?= $ad['created_at'] ?></td>
										<td><?= isset($ad['terms']['make']) ? $ad['terms']['make'] : '' ?></td>
										<td><?= isset($ad['terms']['model']) ? $ad['terms']['model'] : '' ?></td>
										<td><?= isset($ad['terms']['year']) ? $ad['terms']['year'] : '' ?></td>
										<td><?= count($ad['cars']) ?></td>
										<td><?= $ad['is_vdp'] ? 'VDP' : 'SRP' ?> </td>
										<td><?= !$ad['is_vdp'] || ($ad['is_vdp'] && count($ad['cars']) == 1) ? 'YES' : 'NO' ?> </td>
										<td class='url-status'>Checking...</td>
										<td title="<?= $ad['url'] ?>"><a href="<?= $ad['url'] ?>" class="url"><?= $ad['url'] ?></a></td>
										<td><?= $ad['url_match'] == $ad['url'] ? 'Yes' : '<a href="' . $ad['url_match'] . '">NO</a>' ?></td>
										<td class="hash"><?= isset($ad['hash']) ? $ad['hash'] : '' ?></td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th><?= $total ?></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tfoot>
						</table>
					</section>
				<?php } ?>
			</div>
		</div>
	</section>
	<style>
		.url {
			max-width: 500px;
			min-width: 200px;
			display: inline-block;
			word-break: break-all;
		}

		.hash {
			word-break: break-all;
		}
	</style>
	<script>
		var urls = Array.from(document.querySelectorAll(".url"));
		var stack = 0;

		var processRow = function() {
			if (urls.length > 0 && stack < 20) {
				stack += 1;
				var url = urls.shift();
				var urlText = url.innerText;
				var tr = url.parentElement.parentElement;
				var id = tr.getAttribute('id');
				var statusTd = tr.querySelector('.url-status');
				var statusUrl = "https://tm.smedia.ca/url_status.php?url=" + encodeURI(urlText);
				fetch(statusUrl)
					.then(response => response.json())
					.then(data => {
						statusTd.innerText = data.status;
						console.log(data.status);
						stack -= 1;
						processRow();
					});

			}
		};
		for (let i = 0; i < 20; i++) {
			setTimeout(processRow, 100);
		}
	</script>
	<?php
	require_once 'bolts/footer.php';
