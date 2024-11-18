<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "{$base_dir}/adwords3";
$selenium_dir = "{$adwords_dir}/caches/selenium_proxy";
$proxy_dir    = "{$adwords_dir}/data";
$log_file     = "{$adwords_dir}/caches/tradesmart_test.log";

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";

// $mode = 'LOCAL';
// $mode = 'DEVELOPMENT';
$mode = 'PRODUCTION';

$input_api  = 'https://api.smedia.ca/v1/test-strade-all';
$submit_api = 'https://api.smedia.ca/v1/report-test-strade';

$input_api_data = json_decode(HttpGet($input_api));
$final_data     = $input_api_data->data;
$useable_data   = [];
$stade_result   = [];

foreach ($final_data as $key => $value) {
    $stade_result[$value->dealerId] = testThisUrls($value->url, $mode, $value->dealerId);
}

file_put_contents($log_file, print_r($stade_result, true));
// sendReportInEmail(json_encode($stade_result));

function testThisUrls($urls, $mode, $dealer_id)
{
    $search = [
        '2019 Ford F-150 LARIAT' => [
            'engine' => '#contact_form > div > section > div.option-groups > div.option-group-0 > div > button:nth-child(2)', // 3.5L V6
            'km'     => '5000',
            'year'   => '2019',
            'make'   => ' Ford',
            'model'  => ' F-150',
            'trim'   => ' LARIAT',
        ],
    ];

    $user = [
        'name'  => 'sMedia Tradesmart Routine Test',
        'email' => 'support@smedia.ca',
        'phone' => '3067750062',
    ];

    $output = [];

    if ($mode == 'LOCAL') {
        $chrome_version     = '84.0.4147.89';
        $selenium_host_addr = "http://localhost:4444/wd/hub";
    } else if ($mode == 'PRODUCTION') {
        $chrome_version     = '74.0.3729.6';
        $selenium_host_addr = "https://selenium.smedia.ca/wd/hub";
    } else if ($mode == 'DEVELOPMENT') {
        $chrome_version     = '74.0.3729.6';
        $selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
    }

    $input_id            = "smatp-vehicle-typeahead";
    $loading             = "trade-loading";
    $search_css_selector = "body > div.autocomplete > div";
    $user_submit_button  = "smatp_detail_report";
    $smedia_tag_url      = "tm.smedia.ca/analytics/script.js";

    $options   = new ChromeOptions();
    $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/$chrome_version Safari/537.36 Curl/7.58.0";
    $arguments = ['--user-agent=' . $userAgent];
    $options->addArguments($arguments);
    $caps = DesiredCapabilities::chrome();
    $caps->setCapability(ChromeOptions::CAPABILITY, $options);
    $driver = RemoteWebDriver::create($selenium_host_addr, $caps);

    foreach ($urls as $url) {
        $out = [
            'smedia_tag' => 'sMedia Tag not found',
            'tradesmart' => 'failed',
            'car_input'  => 'failed',
            'name'       => 'failed',
            'email'      => 'failed',
            'phone'      => 'failed',
            'submit'     => 'failed',
        ];

        $pass         = true;
        $fail_message = "";

        try {
            $driver->get($url);
            sleep(2);
            $driver->get($url);
            sleep(7);
        } catch (Exception $e) {
            $post_data = [
                'dealerId'    => $dealer_id,
                'url'         => $url,
                'pass'        => false,
                'details'     => "Could not access the URL.",
                'detailsInfo' => $out,
            ];
            postToMongo(json_encode($post_data));

            $out['dealerId'] = $dealer_id;
            $out['pass']     = false;
            $out['details']  = "Could not access the URL.";
            $output[$url]    = $out;
            continue;
        }

        // Check for smedia tag
        $pageSource = $driver->getPageSource();
        $tag        = stripos($pageSource, $smedia_tag_url);
        if ($tag !== false) {
            $out['smedia_tag'] = 'sMedia Tag Found';
        }

        try {
            $element = $driver->findElement(WebDriverBy::id($input_id));
        } catch (Exception $e) {
            $post_data = [
                'dealerId'    => $dealer_id,
                'url'         => $url,
                'pass'        => false,
                'details'     => "Tradesmart UI is not loaded.",
                'detailsInfo' => $out,
            ];
            postToMongo(json_encode($post_data));

            $out['dealerId'] = $dealer_id;
            $out['pass']     = false;
            $out['details']  = "Tradesmart UI is not loaded.";
            $output[$url]    = $out;
            continue;
        }

        if ($element) {
            $out['tradesmart'] = 'success';
        } else {
            $pass = false;
            $fail_message .= "Tradesmart UI is not loaded. ";
        }

        # input some text
        $element->click();
        // $car_input = array_key_first($search);
        foreach ($search as $key => $value) {
            $car_input = $key;
            break;
        }

        try {
            $driver->getKeyboard()->sendKeys($search[$car_input]['year']);
            sleep(1);
            $driver->getKeyboard()->sendKeys($search[$car_input]['make']);
            sleep(1);
            $driver->getKeyboard()->sendKeys($search[$car_input]['model']);
            sleep(1);
            $driver->getKeyboard()->sendKeys($search[$car_input]['trim']);
            sleep(2);
            $driver->findElement(WebDriverBy::cssSelector($search_css_selector))->click();
            $out['car_input'] = 'success';
            sleep(3);
        } catch (Exception $e) {
            $post_data = [
                'dealerId'    => $dealer_id,
                'url'         => $url,
                'pass'        => false,
                'details'     => "Could not use tradesmart input modal. Probably due to other modal in UI.",
                'detailsInfo' => $out,
            ];
            postToMongo(json_encode($post_data));

            $out['dealerId'] = $dealer_id;
            $out['pass']     = false;
            $out['details']  = "Could not use tradesmart input modal. Probably due to other modal in UI.";
            $output[$url]    = $out;
            continue;
        }

        try {
            $frame = $driver->findElement(WebDriverBy::id("modalIframe"));
            $driver->switchTo()->frame($frame);

            $name_input = $driver->findElement(WebDriverBy::id('name'));
            if ($name_input) {
                $out['name'] = 'success';
            } else {
                $pass = false;
                $fail_message .= "User details (name) not working.";
            }
            /* $name_input->click();
            $driver->getKeyboard()->sendKeys($user['name']); */

            $email_input = $driver->findElement(WebDriverBy::id('email'));
            if ($email_input) {
                $out['email'] = 'success';
            } else {
                $pass = false;
                $fail_message .= "User details (email) not working.";
            }
            /* $email_input->click();
            $driver->getKeyboard()->sendKeys($user['email']); */

            $phone_input = $driver->findElement(WebDriverBy::id('phone'));
            if ($phone_input) {
                $out['phone'] = 'success';
            } else {
                $pass = false;
                $fail_message .= "User details (phone) not working.";
            }
            /* $phone_input->click();
            $driver->getKeyboard()->sendKeys($user['phone']); */

            $user_sub_btn = $driver->findElement(WebDriverBy::id($user_submit_button));

            if ($user_sub_btn) {
                $out['submit'] = 'success';
            } else {
                $pass = false;
                $fail_message .= "User details (submit) not working.";
            }

            $post_data = [
                'dealerId'    => $dealer_id,
                'url'         => $url,
                'pass'        => $pass,
                'details'     => $pass ? "All Tests Are Successfull" : $fail_message,
                'detailsInfo' => $out,
            ];
            postToMongo(json_encode($post_data));

            $out['dealerId'] = $dealer_id;
            $out['pass']     = $pass;
            $out['details']  = $pass ? "All Tests Are Successfull" : $fail_message;
            $output[$url]    = $out;
        } catch (Exception $e) {
            $post_data = [
                'dealerId'    => $dealer_id,
                'url'         => $url,
                'pass'        => false,
                'details'     => "Could not use tradesmart user details modal. Probably due to other modal in UI.",
                'detailsInfo' => $out,
            ];
            postToMongo(json_encode($post_data));

            $out['dealerId'] = $dealer_id;
            $out['pass']     = false;
            $out['details']  = "Could not use tradesmart user details modal. Probably due to other modal in UI.";
            $output[$url]    = $out;
            continue;
        }
    }

    $driver->quit();

    return $output;
}

function sendReportInEmail($report)
{
    $email_recepients = ['john@smedia.ca', 'tanvir@smedia.ca', 'zaber.mahbub@smedia.ca', 'rabbi@smedia.ca'];
    $from             = 'report@smedia.ca';
    $subject          = 'Tradesmart Daily Test Report';
    SendEmail($email_recepients, $from, $subject, $report);
}

function postToMongo($post_data)
{
    $post_url     = 'https://api.smedia.ca/v1/report-test-strade';
    $in_cookies   = '';
    $out_cookies  = '';
    $content_type = 'application/json';
    $resp         = HttpPost($post_url, $post_data, $in_cookies, $out_cookies, true, true, $content_type);
}
