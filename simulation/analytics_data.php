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
$log_file     = "{$adwords_dir}/caches/google_account_creator.log";

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

$mode = 'LOCAL';
// $mode = 'DEVELOPMENT';
// $mode = 'PRODUCTION';

if ($mode == 'LOCAL') {
    $chrome_version     = '87.0.4280.88';
    $selenium_host_addr = "http://localhost:4444/wd/hub";
} else if ($mode == 'PRODUCTION') {
    $chrome_version     = '74.0.3729.6';
    $selenium_host_addr = "https://selenium.smedia.ca/wd/hub";
} else if ($mode == 'DEVELOPMENT') {
    $chrome_version     = '74.0.3729.6';
    $selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
}

$options   = new ChromeOptions();
$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/{$chrome_version} Safari/537.36";
$arguments = ['--user-agent=' . $userAgent];
$options->addArguments($arguments);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($selenium_host_addr, $caps);

// HIT THE DOMAIN URL TWICE TO GET THE SELENIUM SESSION RUNNING
sleep(1);

// EXTERNAL INPUT
$input = [
    'ga_id'      => 'UA-42553815-27',
    'start_date' => 'Nov 1, 2020',
    'end_date'   => 'Nov 30, 2020'
];

// DATA PART
$email       = "reporting@smedia.ca";
$pass        = "smedia1055";
$root_domain = "https://analytics.google.com/";

// ELEMENT LOCATORS
$email_iput_id      = "identifierId";
$email_next_btn_cls = "VfPpkd-dgl2Hf-ppHlrf-sM5MNb";
$pass_input_cls     = "whsOnd";
$pass_next_btn_cls  = "VfPpkd-RLmnJb";

// PAGE VIEW
$acquisition_xpath   = '//*[@id="reporting"]/div/div/div/ga-nav-link[3]/div[1]/a/div';
$all_traffic_xpath   = '//*[@id="reporting"]/div/div/div/ga-nav-link[3]/div[2]/div/div/ga-nav-link[2]/div[1]/a/div';
$source_medium_xpath = '//*[@id="reporting"]/div/div/div/ga-nav-link[3]/div[2]/div/div/ga-nav-link[2]/div[2]/div/div/ga-nav-link[3]/div/report-link/a/div/span/span';

// ACCOUNT SELECTORS
$all_accounts_xpath   = '//*[@id="suite-top-nav"]/suite-header/div/md-toolbar/div/suite-universal-picker/button';
$account_search_xpath = '/html/body/div[7]/div[2]/div/md-toolbar/form/input';
$first_account_xpath  = '/html/body/div[7]/div[2]/div/div/div/div/suite-detailed-entity-list/div/a';

// GUIDE MODAL
$guide_modal_xpath       = '//*[@id="inproduct-guide-modal"]';
$guide_modal_close_xpath = '//*[@id="inproduct-guide-modal"]/div[1]/a';

// TIME FRAME SELECTOR
$calender_xpath   = '//*[@id="ID-reportHeader-dateControl"]/div[1]';
$start_date_xpath = '//*[@id="ID-reportHeader-dateControl"]/div[2]/table/tbody/tr/td[2]/div/div[2]/input[1]';
$end_date_xpath   = '//*[@id="ID-reportHeader-dateControl"]/div[2]/table/tbody/tr/td[2]/div/div[2]/input[2]';
$apply_date_xpath = '//*[@id="ID-reportHeader-dateControl"]/div[2]/table/tbody/tr/td[2]/div/input';

// IFRAME
$iframe_xpath = '//*[@id="galaxyIframe"]';

// TABLE
$row_button_xpath = '//*[@id="ID-explorer-table"]/div[3]/div[1]/div/span[1]/span[1]/select';
$max_row_xpath    = '//*[@id="ID-explorer-table"]/div[3]/div[1]/div/span[1]/span[1]/select/option[9]';

// DATA LOCATORS
$users_xpath           = '//*[@id="ID-rowTable"]/thead/tr[4]/td[3]/div[1]/div/div';
$new_users_xpath       = '//*[@id="ID-rowTable"]/thead/tr[4]/td[4]/div[1]/div/div';
$sessions_xpath        = '//*[@id="ID-rowTable"]/thead/tr[4]/td[5]/div[1]/div/div';
$bounce_rate_xpath     = '//*[@id="ID-rowTable"]/thead/tr[4]/td[6]/div[1]/div/div';
$pages_sessions_xpath  = '//*[@id="ID-rowTable"]/thead/tr[4]/td[7]/div[1]/div/div';
$avg_session_xpath     = '//*[@id="ID-rowTable"]/thead/tr[4]/td[8]/div[1]/div/div';
$goal_conversion_xpath = '//*[@id="ID-rowTable"]/thead/tr[4]/td[9]/div[1]/div/div';
$goal_completion_xpath = '//*[@id="ID-rowTable"]/thead/tr[4]/td[10]/div[1]/div/div';
$goal_value_xpath      = '//*[@id="ID-rowTable"]/thead/tr[4]/td[11]/div[1]/div/div';

try {
    seleniumGet($driver, $root_domain);
    sleep(1);
    seleniumGet($driver, $root_domain);
} catch (Exception $e) {
    $msg = 'SITE:' . $root_domain . '<br> ERROR MESSAGE: ' . $e;
    echo "ERROR REPORT:<br>{$msg}";
}

try {
    $element = $driver->findElement(WebDriverBy::id($email_iput_id));
    $element->click();
} catch (Exception $e) {
    echo "ERROR: Couldn't find email input field. " . $e;
    exit();
}

// LOGIN
$driver->getKeyboard()->sendKeys($email);
sleep(1);
$driver->findElement(WebDriverBy::className($email_next_btn_cls))->click();
sleep(2);
$driver->findElement(WebDriverBy::className($pass_input_cls))->click();
sleep(1);
$driver->getKeyboard()->sendKeys($pass);
sleep(1);
$driver->findElement(WebDriverBy::className($pass_next_btn_cls))->click();
sleep(20);

// GO TO REQUIRED TABS
$driver->findElement(WebDriverBy::xpath($acquisition_xpath))->click();
sleep(1);
$driver->findElement(WebDriverBy::xpath($all_traffic_xpath))->click();
sleep(1);
$driver->findElement(WebDriverBy::xpath($source_medium_xpath))->click();
sleep(20);

// PREVENT GUIDE MODAL
try {
    if ($driver->findElement(WebDriverBy::xpath($guide_modal_xpath))) {
        $driver->findElement(WebDriverBy::xpath($guide_modal_close_xpath))->click();
        sleep(3);
    }
} catch (Exception $e) {}

// SELECT PROPER CLIENT
$driver->findElement(WebDriverBy::xpath($all_accounts_xpath))->click();
sleep(4);
$driver->findElement(WebDriverBy::xpath($account_search_xpath))->click()->sendKeys($input['ga_id']);
sleep(3);
$driver->findElement(WebDriverBy::xpath($first_account_xpath))->click();
sleep(10);

// SELECT TIME FRAME
$driver->findElement(WebDriverBy::xpath($calender_xpath))->click();
sleep(1);
$driver->findElement(WebDriverBy::xpath($start_date_xpath))->click()->sendKeys($input['start_date']);
sleep(1);
$driver->findElement(WebDriverBy::xpath($end_date_xpath))->click()->sendKeys($input['end_date']);
sleep(1);
$driver->findElement(WebDriverBy::xpath($apply_date_xpath))->click();
sleep(5);

// CHANGE FOCUS
$iframe = $driver->findElement(WebDriverBy::xpath($iframe_xpath));
$driver->switchTo()->frame($iframe);
sleep(1);

// LOAD ALL ROWS
try {
    $driver->findElement(WebDriverBy::xpath($row_button_xpath))->click();
    sleep(3);
    $driver->findElement(WebDriverBy::xpath($max_row_xpath))->click();
    sleep(10);
} catch (Exception $e) {}

// GET DATA
$data['users']           = $driver->findElement(WebDriverBy::xpath($users_xpath))->getText();
$data['new_users']       = $driver->findElement(WebDriverBy::xpath($new_users_xpath))->getText();
$data['sessions']        = $driver->findElement(WebDriverBy::xpath($sessions_xpath))->getText();
$data['bounce_rate']     = $driver->findElement(WebDriverBy::xpath($bounce_rate_xpath))->getText();
$data['pages_sessions']  = $driver->findElement(WebDriverBy::xpath($pages_sessions_xpath))->getText();
$data['avg_session']     = $driver->findElement(WebDriverBy::xpath($avg_session_xpath))->getText();
$data['goal_conversion'] = $driver->findElement(WebDriverBy::xpath($goal_conversion_xpath))->getText();
$data['goal_completion'] = $driver->findElement(WebDriverBy::xpath($goal_completion_xpath))->getText();
$data['goal_value']      = $driver->findElement(WebDriverBy::xpath($goal_value_xpath))->getText();

print_r($data);

function seleniumGet(RemoteWebDriver $driver, string $url)
{
    $driver->get($url)->wait(10, 1000)->until(
        function () use ($driver) {
            $title = $driver->getTitle();

            if (strpos($title, 'ERROR') === false) {
                return true;
            } else {
                return false;
            }
        },
        'Error'
    );
}