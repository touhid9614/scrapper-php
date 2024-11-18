<?php
header('Content-type: text/javascript; charset=UTF-8');
/*
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
*/
header("Cache-Control: max-age=" . (60 * 60 * 6));
$offset = strtotime('+6 hours'); // same as time() + 42 * 60 * 60
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", $offset) . " GMT";
header($ExpStr);

$input_type  = INPUT_GET;
$button_dir  = __DIR__;
$base_dir    = dirname(dirname($button_dir));
$adwords_dir = "$base_dir/adwords3/";
$ext_dir     = "$base_dir/extensions/";

require_once $adwords_dir . 'utils.php';

$dealership      = filter_input($input_type, 'dealership', FILTER_SANITIZE_STRING);
$url             = filter_input($input_type, 'ref', FILTER_SANITIZE_URL);
$cache_reset     = stripos($url, 'cache_reset = true') > 0;
$cache_directory = "$adwords_dir/caches/button-data/";
$cache_file      = "{$cache_directory}{$dealership}.dat";

if (!$cache_reset && ($js = get_data_cache($cache_file, 24))) {
	$ft = filemtime($cache_file);
	echo "//!###Cached since " . date('l jS \of F Y h:i:s A', $ft) . "\n";
	echo $js;
	exit;
}

ob_start();

global $single_config, $CronConfigs;
$single_config = $dealership;
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'stopwatch.php';
require_once $adwords_dir . 'uuid.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'db_connect.php';
require_once $ext_dir . 'buttons/init.php';
require_once $button_dir . '/form-actions.php';

use sMedia\AiButton\AiButtonCombination;

$stopwatch = new Stopwatch();
$cron_config = isset($CronConfigs[$dealership]) ? $CronConfigs[$dealership] : null;

if (!$cron_config) {
	die("/* No Such Dealership */");
}

if (!isset($cron_config['buttons']) || !is_array($cron_config['buttons'])) {
	die("/* No sMart Button Dealership */");
}

// DB fetch
$db_connect         = new DbConnect('');
$adf_user           = $db_connect->getADF($dealership);
$config_button_mode = isset($adf_user) ? $adf_user['buttons_live']                            : false;
$button_mode        = apply_filters('filter_button_is_live', $config_button_mode, $dealership);
$form_mode          = isset($adf_user) ? $adf_user['form_live']                               : false;
$poweredby_mode     = isset($cron_config['powered_by_live']) ? $cron_config['powered_by_live']: false;
$disclaimer         = isset($cron_config['form_disclaimer']) ? $cron_config['form_disclaimer']: '';
$page_title         = isset($_GET['page_title']) ? filter_input(INPUT_GET, 'page_title') 	  : '';


if (isset($cron_config['button_algorithm'])) {
	$ai_button_algorithm = explode('|', $cron_config['button_algorithm']);
} else {
	$ai_button_algorithm = ['default'];
}

echo "\n//Initial init by : " . $stopwatch->elapsed() . "\n";
$button_config  = $cron_config['buttons'];
$data = boedb_get_dealership_data($dealership, date('Y-m-d'));
echo "\n//Data loaded by : " . $stopwatch->elapsed() . "\n";
unset($adf_user);
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);
?>

//Base style for windowing
/*
var base_style = document.createElement('link');
base_style.setAttribute("href", "//tm.smedia.ca/dynamic-resources/buttons/window.css");
base_style.setAttribute("rel", "stylesheet");
base_style.setAttribute("type", "text/css");
document.getElementsByTagName('head')[0].appendChild(base_style);
*/


//Base script for windowing
<?php
// echo file_get_contents(__DIR__ . '/window.js');
// echo "\n//Window initialized : " . $stopwatch->elapsed() . "\n";
echo file_get_contents(__DIR__ . '/buttons.js');
echo "\n// Button initialized : " . $stopwatch->elapsed() . "\n";

if (in_array('thompson_sampling', $ai_button_algorithm)) {
	echo file_get_contents(__DIR__ . '/beta.js');
	echo "\n// Beta sample loaded : " . $stopwatch->elapsed() . "\n";
}


$ai_button_combinations = [];

foreach ($ai_button_algorithm as $algorithm) {
	if ($algorithm != 'default') {
		$aiButton = new AiButtonCombination($dealership, $CronConfigs[$dealership]['buttons'], DbConnect::get_connection_read(), $algorithm);
		$aiButton->generateCombination()->saveCombination(DbConnect::get_connection_read(), DbConnect::get_connection_write());
		$aibutton_data[$algorithm] = $aiButton->getData($algorithm);
		$ai_button_combinations[$algorithm] = $aiButton->combinations;
		unset($aiButton);
	} else {
		$aibutton_data[$algorithm] = calculate_option_score($data, $button_config);
	}
}

$randomLoad = mt_rand(0, 1000);
$checking_data = [];

if ($randomLoad < 100 && $button_mode) {
	$buttons = isset($cron_config['buttons']) ? $cron_config['buttons'] : [];

	if (count($buttons)) {
		foreach ($buttons as $button_name => $button_data) {
			$checking_data[$button_name]['url_match'] = $button_data['url-match'];
			$checking_data[$button_name]['action_target'] = $button_data['action-target'];
			$checking_data[$button_name]['css_class'] = $button_data['action-target'];
		}
	}
}
?>

window.confirmjQueryLoaded(function($)
{
	<?php

	echo "var sm_button_data = {};\n";

	foreach ($aibutton_data as $algo => $algo_data) {
		echo "// sm_button_data-{$algo}\n";
		$json_algo_data = json_encode($algo_data);
		echo "sm_button_data['{$algo}'] = {$json_algo_data}\n";
		echo "// --sm_button_data-{$algo}\n";
	}

	json_dump('sm_button_confs', $button_config);
	echo "// --sm_button_confs\n";

	if (isset($cron_config['button_algorithm'])) {
		json_dump('sm_button_combinations', $ai_button_combinations);
		echo "// --sm_button_combinations\n";
	}

	if ($_SERVER['SERVER_NAME'] == 'smedia-inventory.test') {
		$tracker_url = "https://smedia-inventory.test/services/sm-ai-buttons.php";
	} else {
		$tracker_url = "https://tm.smedia.ca/services/sm-ai-buttons.php";
	}
	?>

	sMedia_prepare_button($);
	sMedia.Button.init(sm_button_data, sm_button_confs, {
		dealership : '<?= $dealership ?>',
		button_live : <?= $button_mode      ? 'true' : 'false' ?>,
		form_live : <?= $form_mode        ? 'true' : 'false' ?>,
		poweredby_live : <?= $poweredby_mode   ? 'true' : 'false' ?>,
		poweredby_conf : {},
		<?= (isset($cron_config['button_algorithm'])) ? "combinations : sm_button_combinations,\n" : "" ?>
		algorithm : <?= json_encode($ai_button_algorithm) ?>,
		disclaimer : '<?= $disclaimer ?>',
		tracker_url: '<?= $tracker_url ?>'
	});

	sMedia.Button.show();


	// This part is only for inifinite scroll page, when scroll down to bottom and changed page then call button again
	var initial_url = window.location.href;

	window.addEventListener('scroll', function(e)
	{
		var current_url = window.location.href;

		if (initial_url != current_url) {
			sMedia_prepare_button($);

			sMedia.Button.init(sm_button_data, sm_button_confs, {
				dealership : '<?= $dealership ?>',
				button_live : <?= $button_mode      ? 'true' : 'false' ?>,
				form_live : <?= $form_mode        ? 'true' : 'false' ?>,
				poweredby_live : <?= $poweredby_mode   ? 'true' : 'false' ?>,
				poweredby_conf : {},
				disclaimer : '<?= $disclaimer ?>'
			});

			sMedia.Button.show();
			console.log("URL changed");
		}

		initial_url = current_url;
	});


	// call a javascript function from here to check button status based on random number
	<?php
	if (count($checking_data)) {
	?>
		sMedia.Button.checking_button('<?= json_encode($checking_data) ?>', '<?= $dealership ?>');
	<?php
	}
	?>
});

<?php

echo "\n//To complete : " . $stopwatch->total() . "\n";
$js = ob_get_clean();
store_data_cache($cache_file, $js);
echo $js;


function json_dump($veriable_name, $data)
{
	echo "var $veriable_name = " . json_encode($data) . ";\n";
}


function calculate_option_score($data, $button_config)
{
	$retval = [];

	//echo "\n//Data: " . json_encode($data) . "\n";

	foreach ($button_config as $button => $config) {
		$button_data = isset($data[$button]) ? $data[$button] : [];

		//echo "\n//Button data: " . json_encode($button_data) . "\n";

		//Filter locations
		foreach ($config['locations'] as $location => $details) {
			$retval[$button]['locations'][$location] = isset($button_data['location'][$location]) ? calculate_score($button_data['location'][$location]) : calculate_score();
		}

		//Sizes
		foreach ($config['sizes'] as $size => $details) {
			$retval[$button]['sizes'][$size] = isset($button_data['size'][$size]) ? calculate_score($button_data['size'][$size]) : calculate_score();
		}

		//Styles
		foreach ($config['styles'] as $style => $details) {
			$retval[$button]['styles'][$style] = isset($button_data['style'][$style]) ? calculate_score($button_data['style'][$style]) : calculate_score();
		}

		//Texts
		foreach ($config['texts'] as $text_key => $details) {
			foreach ($details['values'] as $text) {
				$retval[$button]['texts'][$text_key][$text] = isset($button_data["text_{$text_key}"][$text]) ? calculate_score($button_data["text_{$text_key}"][$text]) : calculate_score();
			}
		}
	}

	return $retval;
}


function calculate_score($option_data = null)
{
	if (!$option_data || $option_data['viewed'] <= 0) {
		return 1;
	}

	//echo "\n//Option data: " . json_encode($option_data) . "\n";

	$retval = (1.0 * $option_data['clicked'] + 10.0 * $option_data['fillup']) / $option_data['viewed'];

	if ($retval == 0) {
		$retval = 0.0001 * max([1, (5000 - $option_data['viewed'])]);
	}  //So that we don't get rid of it all together

	return $retval;
}
