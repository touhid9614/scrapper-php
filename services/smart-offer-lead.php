<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$adwords_dir = dirname(__DIR__) . "/adwords3/";

global $CronConfigs, $single_config;
$single_config = filter_input(INPUT_POST, 'dealership');
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'uuid.php';
require_once dirname(__DIR__) . '/dynamic-resources/popup/popup.php';
require_once __DIR__ . '/email-templates.php';

$debug            = filter_input(INPUT_GET, 'debug') == 'true';
$lead_debug       = filter_input(INPUT_GET, 'lead_debug') == 'true';

// HIDDEN FIELDS
$action           = filter_input(INPUT_POST, 'act');
$cron_name        = filter_input(INPUT_POST, 'dealership');
$stock_type       = filter_input(INPUT_POST, 'stock_type');
$year             = filter_input(INPUT_POST, 'year');
$make             = filter_input(INPUT_POST, 'make');
$model            = filter_input(INPUT_POST, 'model');
$trim             = filter_input(INPUT_POST, 'trim');
$title            = filter_input(INPUT_POST, 'title');
$url              = filter_input(INPUT_POST, 'url');
$stock_no         = filter_input(INPUT_POST, 'stock_number');
$vin              = filter_input(INPUT_POST, 'vin');
$svin             = filter_input(INPUT_POST, 'svin');
$odometer         = filter_input(INPUT_POST, 'odometer');
$kilometres       = filter_input(INPUT_POST, 'kilometres');
$transmission     = filter_input(INPUT_POST, 'transmission');
$body_style       = filter_input(INPUT_POST, 'body_style');
$doors            = filter_input(INPUT_POST, 'doors');
$user_unique_id   = filter_input(INPUT_POST, 'smedia_smart_lead_uuid');
$referrer         = filter_input(INPUT_POST, 'referrer', FILTER_SANITIZE_URL);
$session_id       = filter_input(INPUT_POST, 'session_id');
$mongo_dealer_id  = filter_input(INPUT_POST, 'mongo_dealer_id');

// INPUT FIELDS
$customer_name    = trim(filter_input(INPUT_POST, 'name'));
$customer_email   = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
$customer_phone   = trim(filter_input(INPUT_POST, 'phone'));
$customer_fourth  = trim(filter_input(INPUT_POST, 'fourth'));
$customer_fifth   = trim(filter_input(INPUT_POST, 'fifth'));

// OBSOLUTE
$nearest_location = filter_input(INPUT_POST, 'nearest_location');



$cron_config      = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;
$domain           = GetDomain($url);
$dealer_info      = get_company_name($cron_name);
$company_name     = $dealer_info['company_name'];
$group_name       = $dealer_info['group_name'];


// Identifyable uuid
if (!$user_unique_id || strlen($user_unique_id) < 64) {
    $user_unique_id = UUID::v4();
}

if (strtolower($customer_name) == 'test user') {
    $debug = true;
}

if (strtolower($customer_name) == 'test lead') {
    $lead_debug = true;
}

$dir       = $adwords_dir . "templates/{$cron_name}/";
$file_set  = populate_popup_files(strtolower($stock_type), $year, strtolower($make), strtolower($model));
$file_name = '';

if (check_popup_file($dir, $file_set, $file_name)) {
    $bg_file_url = "https://tm.smedia.ca/adwords3/templates/{$cron_name}/{$file_name}";
}

$alead_config = isset($cron_config['lead'][$stock_type]) ? $cron_config['lead'][$stock_type] : (isset($cron_config['lead']) ? $cron_config['lead'] : []);

$nearest_template = "";

if ($nearest_location) {
    $nearest_template = "<li><span style='color: #6f6f6f; font-family: sans-serif;'>Nearest Location:</span><span style='color: #6f6f6f; font-family: sans-serif; font-weight: bold;'> [nearest_location]</span></li>";
}

$default = array(
    'live'                   => false,
    'lead_type_'             => false,
    'lead_type_new'          => false,
    'lead_type_used'         => false,
    'bg_color'               => "#EFEFEF",
    'text_color'             => "#404450",
    'border_color'           => "#E5E5E5",
    'button_color'           => ["#000000", "#000000"],
    'button_color_hover'     => ["#222222", "#222222"],
    'button_color_active'    => ["#222222", "#222222"],
    'button_text_color'      => "#FFFFFF",
    'sent_client_email'      => true,
    'forward_email_subject'  => "#[monthly_count] Smedia Coupon Lead.",
    'forward_email'          => "<div style='width: 640px; margin: 0 auto; height: 100px; padding: 0 50px;  background-color: #fff'>
    <div><img style='float: left; max-width: 250px; margin-top: 18px;' src='https://smedia.ca/wp-content/themes/%40Smedia/images/logo.png'></div>
    </div>
    <div style='width: 640px; line-height: 35.68px; margin: 0 auto; background: #f8a853;
                background: -moz-linear-gradient(top, #f8a853 1%, #f49847 100%, #7db9e8 100%);
                background: -webkit-linear-gradient(top, #f8a853 1%,#f49847 100%,#7db9e8 100%);
                background: linear-gradient(to bottom, #f8a853 1%,#f49847 100%,#7db9e8 100%);'>
        <h1 style='padding: 50px 0px; text-align: center; margin: 0px; color: #fff; font-family: sans-serif; font-size: 35px'>Someone is <strong>interested in your offer!</strong></h1>
    </div>
    <div style='width: 600px; background-color: #f9f9f9; margin: 0 auto; padding: 20px;'>
        <div style='background-color: #fff;padding: 20px;'>
            <div style='margin-bottom: 40px;'>
                <h3 style='margin-bottom: 50px; color: #6f6f6f; font-family: sans-serif; background-color: #fff;'>Congrats! Below is a smart offer form fill out from your website.  Contact them right away!</h3>
                <h2 style='color: #557fbd; font-family: sans-serif; margin-bottom: 20px;'>Customer Information</h2>
                <ul style='list-style: none; font-size: 14px; padding: 0; margin: 0;'>
                    <li style='margin-bottom: 5px;'><span style='color: #6f6f6f; font-family: sans-serif;'>Name:</span><span style='color: #6f6f6f; font-family: sans-serif; font-weight: bold;'> [name]</span></li>
                    <li style='margin-bottom: 5px;'><span style='color: #6f6f6f; font-family: sans-serif;'>Email:</span><span style='color: #6f6f6f; font-family: sans-serif; font-weight: bold;'> [email]</span></li>
                    <li style='margin-bottom: 5px;'><span style='color: #6f6f6f; font-family: sans-serif;'>Phone:</span><span style='color: #557fbd; font-family: sans-serif; font-weight: bold;'> [phone]</span></li>
                    <li style='margin-bottom: 5px;'><span style='color: #6f6f6f; font-family: sans-serif;'>Dealership Name:</span><span style='color: #6f6f6f; font-family: sans-serif; font-weight: bold;'> [dealership]</span></li>
                    <li><span style='color: #6f6f6f; font-family: sans-serif;'>Interested In:</span><span style='color: #6f6f6f; font-family: sans-serif; font-weight: bold;'> [url]</span></li>
                    <li><span style='color: #6f6f6f; font-family: sans-serif;'>Referrer:</span><span style='color: #6f6f6f; font-family: sans-serif; font-weight: bold;'> [referrer]</span></li>
                    {$nearest_template}
                </ul>
            </div>
        </div>
    </div>",
    'response_email_subject' => "Your offer from [dealership]",
    'response_email'         => "Hello [name],<p>Please print the following coupon and bring it in for the offer</p><img src=\"[image]\"/><p><br/>Auto Team",
    'forward_to'             => array("marshal@smedia.ca"),
    'respond_from'           => "offers@smedia.ca",
    'respond_smtp'           => array(
        'host'         => 'smtp.mailgun.org',
        'port'         => 587,
        'auth_enabled' => true,
        'auth_user'    => 'postmaster@mail.smedia.ca',
        'auth_pass'    => '84374ef8832d9c8e906f05efc15e4e6b',
        'smtp_secure'  => 'tls',
    ),
    'forward_from'           => "offers@smedia.ca",
    'forward_smtp'           => array(
        'host'         => 'smtp.mailgun.org',
        'port'         => 587,
        'auth_enabled' => true,
        'auth_user'    => 'postmaster@mail.smedia.ca',
        'auth_pass'    => '84374ef8832d9c8e906f05efc15e4e6b',
        'smtp_secure'  => 'tls',
    ),
    'forward_type'           => null,
    'special_from'           => "offers@smedia.ca",
    'special_smtp'           => array(
        'host'         => 'smtp.mailgun.org',
        'port'         => 587,
        'auth_enabled' => true,
        'auth_user'    => 'postmaster@mail.smedia.ca',
        'auth_pass'    => '84374ef8832d9c8e906f05efc15e4e6b',
        'smtp_secure'  => 'tls',
    ),
    'special_type'           => 'text/plain',
    'special_to'             => [],
    'special_email_subject'  => "#[monthly_count] Smedia Coupon Lead.",
    'special_email'          => '',
    'thank_you'              => "<h1 style=\"margin: 100px 27px; text-align: center;\">Thank you</h1>",
    'required_resp'          => "Please provide name, email and phone number",
);

$lead_config = array_merge($default, $alead_config);

// Fix all lead source shall be sMedia
if ($lead_config['special_to']) {
    $lead_config['special_email'] = $email_templates['smart-offer']['ADF'];
}

if (!is_array($lead_config['forward_to'])) {
    $lead_config['forward_to'] = array($lead_config['forward_to']);
}

// if found nearest location dropdown, then add resepective email into forward_to
if ($nearest_location) {
    $nearest_email = array_search($nearest_location, $lead_config['dropdown_values']);

    if (filter_var($nearest_email, FILTER_VALIDATE_EMAIL)) {
        if (isset($alead_config['special_email'])) {
            array_push($lead_config['special_to'], $nearest_email);
        } else {
            array_push($lead_config['forward_to'], $nearest_email);
        }
    }
}

$meta_name = 'monthly_offer_lead_count';
create_meta_table($meta_name);
$client_ip = DbConnect::get_instance()->get_client_ip();	// GET AS PARAMETER FROM FRONT END

$post_url = 'https://api.smedia.ca/v1';
$date     = date('Ymd');

switch ($action) {
    case 'visited':
        update_user_visit($user_unique_id, $cron_name);
        echo json_encode(['response' => true]);
        break;
    case 'shown':
        try {
			if ($mongo_dealer_id && strlen($mongo_dealer_id) == 24) {
                $myObj            = [];
                $myObj['date']    = $date;
                $myObj['action']  = "view";
                $myObj['service'] = "smart-offer";
                $myObj['uuid']    = $user_unique_id;
                $myObj['session'] = $session_id;
                $myObj['url']     = $url;
				$myObj['svin']     = $svin;
                $myObj['ip']      = $client_ip;

                if ($debug || $lead_debug) {
                    $myObj['debug'] = true;
                }

                $post_data          = json_encode($myObj);
                $post_url_data_push = "{$post_url}/smart-offer/{$mongo_dealer_id}";
                HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');
            }

            // View count
            $meta_key      = "{$cron_name}_view_" . date('mY');
            $monthly_count = get_meta('monthly_offer_lead_count', $meta_key);

            if ($monthly_count) {
                $monthly_count++;
            } else {
                $monthly_count = 1;
            }

            update_meta($meta_name, $meta_key, $monthly_count);

            if ($user_unique_id) {
                customer_add_view($user_unique_id, $cron_name);
                echo json_encode(['response' => "Smart offer view is recorded for '{$user_unique_id}'", "error" => false]);
            } else {
                echo json_encode(['response' => false, "error" => "Invalid user unique ID '{$user_unique_id}'"]);
            }
        } catch (Exception $ex) {
            echo json_encode(['response' => false, "error" => $ex->getMessage()]);
        }
        break;
    case 'submit':
        if (!$customer_name || !$customer_email || !$customer_phone) {
            echo json_encode(array("response" => false, "error" => processTextTemplate($lead_config['required_resp'], $vars)));
            break;
        }

        // Check valid name
        if (!preg_match('/^[a-zA-Z\s.-]{1,40}$/', $customer_name) || strpos($customer_name, 'www') !== false) {
            // Only english chars and  space,dot(.),-
            // longer than or equals 1 chars
            // less than 40 chars
            // don't contain "www"
            // don't support special characters
            echo json_encode(array("response" => false, "error" => "Name is not valid."));
            break;
        }

		if ($mongo_dealer_id && strlen($mongo_dealer_id) == 24) {
            $myObj            = [];
            $myObj['date']    = $date;
            $myObj['action']  = "submit";
            $myObj['service'] = "smart-offer";
            $myObj['uuid']    = $user_unique_id;
            $myObj['session'] = $session_id;
            $myObj['url']     = $url;
			$myObj['svin']     = $svin;
            $myObj['ip']      = $client_ip;
            $myObj['name']    = $customer_name;
            $myObj['email']   = $customer_email;
            $myObj['phone']   = $customer_phone;

            if ($debug || $lead_debug) {
                $myObj['debug'] = true;
            }

            $post_data          = json_encode($myObj);
            $post_url_data_push = "{$post_url}/smart-offer/{$mongo_dealer_id}";
            HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');
        }

        // Fillup count
        $meta_key      = "{$cron_name}_" . date('mY');
        $meta_key_all  = "{$cron_name}_all";
        $monthly_count = get_meta($meta_name, $meta_key);
        $total_count   = get_meta($meta_name, $meta_key_all);

        if ($monthly_count) {
            $monthly_count++;
        } else {
            $monthly_count = 1;
        }

        if ($total_count) {
            $total_count++;
        } else {
            $total_count = 1;
        }

        if (!$debug && !$lead_debug) {
            update_meta($meta_name, $meta_key, $monthly_count);
            update_meta($meta_name, $meta_key_all, $total_count);
        }

        $now  = time();
        $vars = [
            'dealership'       => $cron_name,
            'company_name'     => $company_name,
            'group_name'       => $group_name,
            'domain'           => $domain,
            'name'             => $customer_name,
            'email'            => $customer_email,
            'phone'            => $customer_phone,
            'nearest_location' => $nearest_location,
            'stock_type'       => $stock_type,
            'image'            => $bg_file_url,
            'Y'                => date('Y'), # A full numeric representation of a year, 4 digits
            'y'                => date('y'), # A two digit representation of a year
            'n'                => date('n'), # Numeric representation of a month without leading zeros
            'm'                => date('m'), # Numeric representation of a month with leading zeros
            'j'                => date('j'), # Day of the month without leading zeros
            'd'                => date('d'), # Day of the month, 2 digits with leading zeros
            'h'                => date('h'), # 12-hour format of an hour with leading zeros
            'H'                => date('H'), # 24-hour format of an hour with leading zeros
            'i'                => date('i'), # Minutes with leading zeros
            's'                => date('s'), # Seconds, with leading zeros
            'fdt'              => date('c'), # ISO Date string
            'now'              => $now . '',
            'monthly_count'    => $monthly_count . '',
            'total_count'      => $total_count . '',
            'url'              => $url,
            'dealer_email'     => $lead_config['respond_from'],
            'year'             => $year,
            'make'             => $make,
            'model'            => $model,
            'stock_number'     => $stock_no,
            'vin'              => !empty($vin) ? $vin : "",
            'odometer'         => (string) $odometer,
            'transmission'     => (string) $transmission,
            'body_style'       => (string) $body_style,
            'doors'            => (string) $doors,
            'trim'             => (string) $trim,
            'odometer'         => $stock_type == "new" || empty($odometer) ? 0 : (string) $odometer,
            'odo_status'       => $stock_type == "new" ? "original" : "unknown",
            'title'            => $title,
            'referrer'         => $referrer,
            'provider_name'    => $lead_config['provider_name'] ? $lead_config['provider_name'] : 'sMedia',
            'source'           => $lead_config['source'] ? $lead_config['source'] : 'sMedia smartoffer',
        ];

        if ($user_unique_id) {
            customer_add_fillup($user_unique_id, $cron_name); // record fillup
            update_customer($user_unique_id, $customer_name, $customer_email, $customer_phone); // update details

            create_smart_offer_customers_fillups_data($user_unique_id, $cron_name, $url, $referrer, $nearest_location, $client_ip); # insert url in DB by Rabbi
        }

        // To customer
        if ($lead_config['sent_client_email'] || $debug) {
            $client_subject = processTextTemplate($lead_config['response_email_subject'], $vars);
            $client_body    = processTextTemplate($lead_config['response_email'], $vars);
            $stat           = SendEmail($customer_email, 'offers@smedia.ca', $client_subject, $client_body);
        } else {
            $stat = true;
        }

        if (!in_array('arif@smedia.ca', $lead_config['forward_to'])) {
            $lead_config['forward_to'][] = "arif@smedia.ca";
        }

        if (!in_array('tanvir@smedia.ca', $lead_config['forward_to'])) {
            $lead_config['forward_to'][] = "tanvir@smedia.ca";
        }

        if (!in_array('marshal@smedia.ca', $lead_config['forward_to'])) {
            $lead_config['forward_to'][] = "marshal@smedia.ca";
        }

        if (!in_array('tracy@smedia.ca', $lead_config['forward_to'])) {
            $lead_config['forward_to'][] = "tracy@smedia.ca";
        }

        if (!in_array('adf_to@smedia.ca', $lead_config['special_to'])) {
            $lead_config['special_to'][] = "adf_to@smedia.ca";
        }

        // Use custom lead function
        if (isset($cron_config) && isset($cron_config['lead_config_function'])) {
            $lead_config = $cron_config['lead_config_function']($lead_config);
        }

        if ($debug) {
            if (!in_array('regan@smedia.ca', $lead_config['forward_to'])) {
                $lead_config['forward_to'][] = "regan@smedia.ca";
            }

            if ($lead_config['special_to']) {
                if (!in_array('arif@smedia.com', $lead_config['special_to'])) {
                    $lead_config['special_to'][] = "arif@smedia.com";
                }
            }
        }

        $forward_subject = processTextTemplate($lead_config['forward_email_subject'], $vars);
        $forward_body    = processTextTemplate($lead_config['forward_email'], $vars);

        // To dealership
        $fstat = SendEmail($lead_config['forward_to'], 'offers@smedia.ca', $forward_subject, $forward_body);

        // To special (adf+xml or any other formate)
        $special_subject = processTextTemplate($lead_config['special_email_subject'], $vars);
        $special_body    = processTextTemplate($lead_config['special_email'], $vars);
        $sstat           = SendEmail($lead_config['special_to'], 'offers@smedia.ca', $special_subject, $special_body, $lead_config['special_type']);

        echo json_encode(array("response" => processTextTemplate($lead_config['thank_you'], $vars), "error" => false, "data" => [
            [$client_subject, $client_body, $customer_email, $stat],
            [$forward_subject, $forward_body, $lead_config['forward_to'], $fstat],
            [$special_subject, $special_body, $lead_config['special_to'], $sstat],
        ], 'vars' => $vars));
        break;
    case 'closed':
        $session_msg = "Closed session id {$session_id}";
        try {
			if ($mongo_dealer_id && strlen($mongo_dealer_id) == 24) {
                $myObj            = [];
                $myObj['date']    = $date;
                $myObj['action']  = "close";
                $myObj['service'] = "smart-offer";
                $myObj['uuid']    = $user_unique_id;
                $myObj['session'] = $session_id;
                $myObj['url']     = $url;
				$myObj['svin']    = $svin;
                $myObj['ip']      = $client_ip;

                if ($debug || $lead_debug) {
                    $myObj['debug'] = true;
                }

                $post_data          = json_encode($myObj);
                $post_url_data_push = "{$post_url}/smart-offer/{$mongo_dealer_id}";
                HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json');
            }

            if ($session_id) {
                customer_add_session($session_id, $cron_name, $user_unique_id);
                echo json_encode(['response' => "Smart offer session recorded for '$user_unique_id' Session ID '$session_id'", "error" => false]);
            } else {
                echo json_encode(['response' => false, "error" => "Invalid Session ID '$session_id'"]);
            }
        } catch (Exception $ex) {
            echo json_encode(['response' => false, "error" => $ex->getMessage()]);
        }
        break;
}
