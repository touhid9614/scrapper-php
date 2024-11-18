<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$base_dir    = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";
$ext_dir     = "$base_dir/extensions/";
$tag_dir     = "$base_dir/tracking-tags/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'cron_misc.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'uuid.php';
require_once $tag_dir . 'script-helper.php';
require_once $ext_dir . 'buttons/init.php';
require_once __DIR__ . '/email-templates.php';

global $CronConfigs, $scrapper_configs;

$input_type = INPUT_POST;

$action     = filter_input(INPUT_POST, 'act');
$dealership = filter_input(INPUT_GET, 'dealership');
if (empty($dealership)) {
	$dealership = filter_input(INPUT_POST, 'dealership');
}
$user_id    = filter_input(INPUT_POST, 'smedia_uuid');

$cron_config = isset($CronConfigs[$dealership]) ? $CronConfigs[$dealership] : null;

if (!$cron_config) {
	die(json_encode(['message' => 'No such dealership', 'success' => false]));
}

$ref_url = mild_url_encode(filter_input($input_type, 'url', FILTER_SANITIZE_URL));
$url     = $ref_url;
$url     = removeParams($url);
$car     = resolve_car_from_url($dealership, isset($scrapper_configs[$dealership]) ? $scrapper_configs[$dealership] : null, $url, $ref_url);

$button_name = filter_input(INPUT_POST, 'button_name');
$text_key    = filter_input(INPUT_POST, 'text_key');
$text_value  = filter_input(INPUT_POST, 'text_value');
$location    = filter_input(INPUT_POST, 'location');
$style       = filter_input(INPUT_POST, 'style');
$size        = filter_input(INPUT_POST, 'size');
$combination = filter_input(INPUT_POST, 'combination');
$stock_type  = $car ? $car['stock_type'] : 'any';

switch ($action) {
	case 'button_viewed':
		if ($combination != 'baseline') {
			do_action('smart_button_viewed', $dealership, $location, $user_id, $button_name, 'location', $stock_type);
			do_action('smart_button_viewed', $dealership, $style, $user_id, $button_name, 'style', $stock_type);
			do_action('smart_button_viewed', $dealership, $size, $user_id, $button_name, 'size', $stock_type);
			do_action('smart_button_viewed', $dealership, $text_value, $user_id, $button_name, "text_{$text_key}", $stock_type);
		}

		do_action("smart_button_combination_viewed", $dealership, $button_name, $combination === 'baseline' ? 'baseline' : 'endline', $stock_type);
		echo json_encode(['message' => 'Button View Recorded', 'success' => true]);
		break;

	case 'form_viewed':
		if ($combination != 'baseline') {
			do_action('smart_form_viewed', $dealership, $location, $user_id, $button_name, 'location', $stock_type);
			do_action('smart_form_viewed', $dealership, $style, $user_id, $button_name, 'style', $stock_type);
			do_action('smart_form_viewed', $dealership, $size, $user_id, $button_name, 'size', $stock_type);
			do_action('smart_form_viewed', $dealership, $text_value, $user_id, $button_name, "text_{$text_key}", $stock_type);
		}

		do_action("smart_form_combination_viewed", $dealership, $button_name, $combination === 'baseline' ? 'baseline' : 'endline', $stock_type);
		echo json_encode(['message' => 'Form View Recorded', 'success' => true]);
		break;

	case 'clicked':
		if ($combination != 'baseline') {
			do_action('smart_button_clicked', $dealership, $location, $user_id, $button_name, 'location', $stock_type);
			do_action('smart_button_clicked', $dealership, $style, $user_id, $button_name, 'style', $stock_type);
			do_action('smart_button_clicked', $dealership, $size, $user_id, $button_name, 'size', $stock_type);
			do_action('smart_button_clicked', $dealership, $text_value, $user_id, $button_name, "text_{$text_key}", $stock_type);
		}

		do_action("smart_button_combination_clicked", $dealership, $button_name, $combination === 'baseline' ? 'baseline' : 'endline', $stock_type);

		//boedb_comb_record_increase_count($dealership, $button_name, $combination);

		//Track click for each car
		if ($car) {
			$db_connect = new DbConnect('');
			//Check by dealership, stock_number, url, button_name, day if a click count exist or not
			$stock_number = $car['stock_number'];
			$url          = $car['url'];
			$day          = date('Y-m-d');
			$query_str    = "SELECT id, clicks FROM dealerships_button_tracker WHERE dealership='$dealership' "
				. "AND stock_number='$stock_number' AND url='$url' AND day='$day'";
			$result = $db_connect->query($query_str);

			if (mysqli_num_rows($result)) {
				$rowdata    = mysqli_fetch_array($result);
				$id         = $rowdata[0];
				$clicks     = $rowdata[1] + 1;
				$update_str = "UPDATE dealerships_button_tracker SET clicks='$clicks' WHERE id='$id'";
				$db_connect->query($update_str);
			} else {
				//For insert
				$insert_data =
					[
						'dealership'   => $dealership,
						'stock_number' => $car['stock_number'],
						'url'          => $car['url'],
						'title'        => empty($car['title']) ? ($car['year'] . " " . $car['make'] . " " . $car['model']) : $car['title'],
						'button_name'  => $button_name,
						'clicks'       => 1,
						'day'          => $day,
					];

				$query_prep = $db_connect->prepare_query_params($insert_data, DbConnect::PREPARE_PARENTHESES);
				$query_str  = "INSERT INTO dealerships_button_tracker $query_prep";
				$db_connect->query($query_str);
			}

			$db_connect->close_connection();
		}

		echo json_encode(['message' => 'Click Recorded', 'success' => true]);
		break;

	case 'fillup':
		$db_connect = new DbConnect('');
		$adf_db     = $db_connect->getADF($dealership);

		$form          = filter_input($input_type, 'form', FILTER_SANITIZE_STRING);
		$button_config = isset($cron_config['buttons'][$button_name]) ? $cron_config['buttons'][$button_name] : null;

		if (!$button_config) {
			die(json_encode(['message' => 'No such button', 'success' => false]));
		}

		if (!isset($email_templates[$form])) {
			die(json_encode(['message' => 'No such form', 'success' => false]));
		}

		//If a text value isn't present in selected button and text key, reject it
		if (!in_array($text_value, $button_config['texts'][$text_key]['values'])) {
			die(json_encode(['message' => 'No such text', 'success' => false]));
		}

		if ($combination != 'baseline') {
			do_action('smart_button_fillup', $dealership, $location, $user_id, $button_name, 'location', $stock_type, $form);
			do_action('smart_button_fillup', $dealership, $style, $user_id, $button_name, 'style', $stock_type, $form);
			do_action('smart_button_fillup', $dealership, $size, $user_id, $button_name, 'size', $stock_type, $form);
			do_action('smart_button_fillup', $dealership, $text_value, $user_id, $button_name, "text_{$text_key}", $stock_type, $form);
		}

		do_action("smart_button_combination_fillup", $dealership, $button_name, $combination === 'baseline' ? 'baseline' : 'endline', $stock_type, $form);

		$template_params = [
				'lead_from'           => (isset($adf_db['lead_from']) && count($adf_db['lead_from']) > 0) ? $adf_db['lead_from'] : 'offers@smedia.ca',
				'lead_to'             => (isset($adf_db['lead_to']) && count($adf_db['lead_to']) > 0) ? $adf_db['lead_to'] : ['leads_to@smedia.ca', 'aileads@smedia.ca'],
				'adf_to'              => (isset($adf_db['adf_to']) && count($adf_db['adf_to']) > 0) ? $adf_db['adf_to'] : ['adf_to@smedia.ca'],
				'star_to'             => (isset($adf_db['star_to']) && count($adf_db['star_to']) > 0) ? $adf_db['star_to'] : ['star_to@smedia.ca'],
				'company_name'        => isset($cron_config['company_name']) ? $cron_config['company_name'] : $dealership,
				'company_email'       => isset($cron_config['company_email']) ? $cron_config['company_name'] : 'regan@smedia.ca',
				'stock_type'          => $stock_type,
				'stock_number'        => $car ? $car['stock_number'] : '',
				'year'                => $car ? $car['year'] : '',
				'make'                => $car ? $car['make'] : '',
				'model'               => $car ? $car['model'] : '',
				'price'               => $car ? $car['price'] : '',
				'total_count'         => '1',
				'fdt'                 => date('Y-m-dTG:i:s'),
				'first_name'          => filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING),
				'last_name'           => filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING),
				'email'               => filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL),
				'phone'               => filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING),
				'comments'            => filter_input(INPUT_POST, 'questions', FILTER_SANITIZE_STRING),
				'address'             => filter_input(INPUT_POST, 'address_line_1', FILTER_SANITIZE_STRING),
				'dob_month'           => filter_input(INPUT_POST, 'dob_month', FILTER_SANITIZE_STRING),
				'dob_day'             => filter_input(INPUT_POST, 'dob_day', FILTER_SANITIZE_STRING),
				'dob_year'            => filter_input(INPUT_POST, 'dob_year', FILTER_SANITIZE_STRING),
				'vehicle_use'         => filter_input(INPUT_POST, 'vehicle_use', FILTER_SANITIZE_STRING),
				'living'              => filter_input(INPUT_POST, 'living', FILTER_SANITIZE_STRING),
				'living_since'        => filter_input(INPUT_POST, 'living_since', FILTER_SANITIZE_STRING),
				'mortgage_payment'    => filter_input(INPUT_POST, 'mortgage_rent_payment', FILTER_SANITIZE_STRING),
				'marital_status'      => filter_input(INPUT_POST, 'marital_status', FILTER_SANITIZE_STRING),
				'appointment_date'    => filter_input(INPUT_POST, 'appointment_date', FILTER_SANITIZE_STRING),
				'trade_year'          => filter_input(INPUT_POST, 'car_year', FILTER_SANITIZE_STRING),
				'trade_make'          => filter_input(INPUT_POST, 'car_make', FILTER_SANITIZE_STRING),
				'trade_model'         => filter_input(INPUT_POST, 'car_model', FILTER_SANITIZE_STRING),
				'considering-tradein' => (filter_input(INPUT_POST, 'considering-tradein') === 'Yes') ? "Yes" : "No",
				'qualify-gm-pricing'  => (filter_input(INPUT_POST, 'qualify-gm-pricing') === 'Yes') ? "Yes" : "No",
				'url'                 => $ref_url,
				'button_text'         => $text_value,
				'button_name'         => $button_name,
				'no-marketing'        => (filter_input(INPUT_POST, 'no-marketing') === 'Yes') ? "Yes" : "No",
				'marketing-consent'   => (filter_input(INPUT_POST, 'no-marketing') === 'Yes') ? "No" : "Yes",
				'referrer'            => filter_input(INPUT_POST, 'referrer', FILTER_SANITIZE_URL),
				'client_ip'           => DbConnect::get_instance()->get_client_ip(),
			];

		if (!in_array('aileads@smedia.ca', $template_params['lead_to'], true)) {
			$template_params['lead_to'][] = 'aileads@smedia.ca';
		}

		if (!in_array('leads_to@smedia.ca', $template_params['lead_to'], true)) {
			$template_params['lead_to'][] = 'leads_to@smedia.ca';
		}

		// CONFIGURE FOR NEW & USED
		if (isset($adf_db['lead_to_new']) && count($adf_db['lead_to_new']) > 0 && $stock_type == 'new') {
			$template_params['lead_to_new'] = $adf_db['lead_to_new'];
		}

		if (isset($adf_db['adf_to_new']) && count($adf_db['adf_to_new']) > 0 && $stock_type == 'new') {
			$template_params['adf_to_new'] = $adf_db['adf_to_new'];
		}

		if (isset($adf_db['lead_to_used']) && count($adf_db['lead_to_used']) > 0 && $stock_type == 'used') {
			$template_params['lead_to_used'] = $adf_db['lead_to_used'];
		}

		if (isset($adf_db['adf_to_used']) && count($adf_db['adf_to_used']) > 0 && $stock_type == 'used') {
			$template_params['adf_to_used'] = $adf_db['adf_to_used'];
		}

		//update_customer($user_id, "{$template_params} {}", $email, $phone);  #update details
		$leads_ai_params = [
			'uuid'       => $user_id,
			'dealership' => isset($cron_config['company_name']) ? $cron_config['company_name'] : $dealership,
			'month'      => date('mY'),
			'leads_type' => ($combination === 'baseline') ? 'baseline' : 'endline',
			'params'     => $template_params,
		];

		$query_prep = $db_connect->submit_ai_buttons($leads_ai_params);

		$subject = processTextTemplate($email_templates[$form]['subject'], $template_params);
		$email   = processTextTemplate($email_templates[$form]['email'], $template_params);
		$adf     = processTextTemplate($email_templates[$form]['ADF'], $template_params);

		SendEmail($template_params['lead_to'], $template_params['lead_from'], $subject, $email);
		SendEmail($template_params['adf_to'], $template_params['lead_from'], $subject, $adf, 'text/plain');

		$status = 'init';

		if (isset($template_params['lead_to_new']) && count($template_params['lead_to_new']) > 0 && $stock_type == 'new') {
			$status = SendEmail($template_params['lead_to_new'], $template_params['lead_from'], $subject, $email);
		}

		if (isset($template_params['adf_to_new']) && count($template_params['adf_to_new']) > 0 && $stock_type == 'new') {
			SendEmail($template_params['adf_to_new'], $template_params['lead_from'], $subject, $email, 'text/plain');
		}

		if (isset($template_params['lead_to_used']) && count($template_params['lead_to_used']) > 0 && $stock_type == 'used') {
			SendEmail($template_params['lead_to_used'], $template_params['lead_from'], $subject, $email);
		}

		if (isset($template_params['adf_to_used']) && count($template_params['adf_to_used']) > 0 && $stock_type == 'used') {
			SendEmail($template_params['adf_to_used'], $template_params['lead_from'], $subject, $email, 'text/plain');
		}

		$button_auto_reply = isset($cron_config['button_auto_reply']) ? $cron_config['button_auto_reply'] : false;

		if ($button_auto_reply) {
			$button_auto_reply_text = isset($cron_config['button_auto_reply_text']) ? $cron_config['button_auto_reply_text'] : "Hello [first_name], We received your inquiry and will be in touch very soon.";
			$subject                = "Response from: " . $template_params['company_name'];
			$email                  = processTextTemplate($button_auto_reply_text, $template_params);
			SendEmail($template_params['email'], $template_params['lead_from'], $subject, $email);
		}

		//Track click for each car
		if ($car) {
			//Check by dealership, stock_number, url, button_name, day if a click count exist or not
			$stock_number = $car['stock_number'];
			$url          = $car['url'];
			$day          = date('Y-m-d');
			$query_str    = "SELECT id, fillups FROM dealerships_button_tracker WHERE dealership='$dealership' "
				. "AND stock_number='$stock_number' AND url='$url' AND day='$day'";
			$result = $db_connect->query($query_str);

			if (mysqli_num_rows($result)) {
				$rowdata    = mysqli_fetch_array($result);
				$id         = $rowdata[0];
				$fillups    = $rowdata[1] + 1;
				$update_str = "UPDATE dealerships_button_tracker SET fillups='$fillups' WHERE id='$id'";
				$db_connect->query($update_str);
			} else {
				//For insert
				$insert_data =
					[
						'dealership'   => $dealership,
						'stock_number' => $car['stock_number'],
						'url'          => $car['url'],
						'title'        => empty($car['title']) ? ($car['year'] . " " . $car['make'] . " " . $car['model']) : $car['title'],
						'button_name'  => $button_name,
						'fillups'      => 1,
						'day'          => $day,
					];

				$query_prep = $db_connect->prepare_query_params($insert_data, DbConnect::PREPARE_PARENTHESES);
				$query_str  = "INSERT INTO dealerships_button_tracker $query_prep";
				$db_connect->query($query_str);
			}
		}

		unset($adf_db);
		$db_connect->close_connection();

		echo json_encode(['message' => 'Submitted', 'success' => true]);
		break;

	case 'save_log':
		$error_message = 'Date: ' . date('Y-m-d H:i:s') . ' <br> ' . filter_input(INPUT_POST, 'error_message');
		file_put_contents($adwords_dir . "caches/ai-button-log/" . $dealership . ".txt", $error_message);
		echo json_encode(['message' => 'Error log save successfully', 'success' => true]);
		break;

	default:
		echo json_encode(['message' => 'No such action', 'success' => false]);
		break;
}
