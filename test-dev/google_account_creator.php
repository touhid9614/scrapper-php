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
    $chrome_version     = '86.0.4140.22';
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

/* HIT THE DOMAIN URL TWICE TO GET THE SELENIUM SESSION RUNNING */
sleep(1);

/* DATA PART */
$email         = "analytics.h-o@smedia.ca";
$pass          = "smedia1055";
$analytics_url = "https://analytics.google.com/analytics/web/#/a159081726w226420412p214146233/admin/account/create";
$root_domain   = "https://analytics.google.com/";
$create_start  = 'https://analytics.google.com/analytics/web/#/a159081726w226420412p214146233/admin/account/create';

/* POPULATE THIS ARRAY WITH REAL DATA */
$input_data_set = [
    'test_account_selenium' => [
        'account_name'  => 'Hunky Punky',
        'scheme'        => 'https',
        'url'           => 'www.hunkypunky.com',
        'country'       => 'usa',
        'currency'      => 'usd',
        'business_size' => 2,
        'usage'         => [1, 3, 4, 7],
    ]
];

try {
    seleniumGet($driver, $root_domain);
    sleep(1);
    seleniumGet($driver, $root_domain);
} catch (Exception $e) {
    $msg = 'SITE:' . $root_domain . '<br> ERROR MESSAGE: ' . $e;
    echo "ERROR REPORT:<br>{$msg}";
}

sleep(3);

/* ELEMENT LOCATORS */
$email_iput_id      = "identifierId";
$email_next_btn_cls = "VfPpkd-dgl2Hf-ppHlrf-sM5MNb";
$pass_input_cls     = "whsOnd";
$pass_next_btn_cls  = "VfPpkd-RLmnJb";
$admin_button_xpath = '//*[@id = "bottom-section-admin"]/div/div/ga-nav-link/div/report-link/a/div';
$create_account_sel = '#admin-account-column > h2 > div.column-title > button > span';
$account_name_xpath = '//*[@id="cdk-step-content-0-0"]/div/create-firebase-account/form/div[1]/div[2]/div/div/div[3]/input';
$account_next_xpath = '//*[@id="cdk-step-content-0-0"]/div/button';
$view_next_xpath    = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[2]/div/div[2]/div[2]/button[1]';
$account_name_xpath = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[1]/div/new-property-settings/div/form/div[1]/div[1]/div[2]/input';
$scheme_select_btn  = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[1]/div/new-property-settings/div/form/div[1]/div[2]/div[2]/ga-url-selector/ga-select-dropdown/ga-dropdown/button';
$scheme_https_btn   = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[1]/div/new-property-settings/div/form/div[1]/div[2]/div[2]/ga-url-selector/ga-select-dropdown/ga-dropdown/div/ga-select-menu/div/ul/li[2]/div';
$website_url_xpath  = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[1]/div/new-property-settings/div/form/div[1]/div[2]/div[2]/ga-url-selector/input';
$industry_btn_xpath = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[1]/div/new-property-settings/div/form/div[2]/div[2]/ga-industry-selector/ga-select-dropdown/ga-dropdown/button';
$automotive_select  = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[1]/div/new-property-settings/div/form/div[2]/div[2]/ga-industry-selector/ga-select-dropdown/ga-dropdown/div/ga-select-menu/div/ul/li[3]/div';
$crate_btn_xpath    = '//*[@id="admin-content-column"]/section/ui-view/div/ga-wizard/div/div[1]/div[1]/div/ga-wizard-step[3]/div/div[2]/div[2]/button[1]';
$iframe_selector    = 'body > iframe.ga-dialog-bg';
$div_selector       = 'body > div.large.ga-dialog.dialog-scrollable';
$accept_1_xpath     = '/html/body/div[8]/section[3]/div/md-checkbox/div[1]/div[2]';
$accept_2_xpath     = '/html/body/div[8]/section[4]/div[3]/md-checkbox/div[1]/div[2]';
$accept_3_xpath     = '/html/body/div[8]/section[5]/button[1]';

try {
    $element = $driver->findElement(WebDriverBy::id($email_iput_id));
    $element->click();
} catch (Exception $e) {
    echo "ERROR: Couldn't find email input field. " . $e;
    exit();
}

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
$driver->findElement(WebDriverBy::xpath($admin_button_xpath))->click();
sleep(10);
$driver->findElement(WebDriverBy::cssSelector($create_account_sel))->click();
sleep(2);

foreach ($input_data_set as $account_name => $account_data) {
    seleniumGet($driver, $create_start);
    sleep(15);
    $driver->findElement(WebDriverBy::xpath($account_name_xpath))->click();
    sleep(1);
    $driver->getKeyboard()->sendKeys($account_name);
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($account_next_xpath))->click();
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($view_next_xpath))->click();
    sleep(2);
    $driver->findElement(WebDriverBy::xpath($account_name_xpath))->click();
    sleep(1);
    $driver->getKeyboard()->sendKeys($account_data['account_name']);
    sleep(1);

    if (strtolower($account_data['scheme']) == 'https') {
        $driver->findElement(WebDriverBy::xpath($scheme_select_btn))->click();
        sleep(1);
        $driver->findElement(WebDriverBy::xpath($scheme_https_btn))->click();
        sleep(1);
    }

    $driver->findElement(WebDriverBy::xpath($website_url_xpath))->click();
    sleep(1);
    $driver->getKeyboard()->sendKeys($account_data['url']);
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($industry_btn_xpath))->click();
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($automotive_select))->click();
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($crate_btn_xpath))->click();
    sleep(2);

    /* $iframe = $driver->findElement(WebDriverBy::cssSelector($iframe_selector));
    $driver->switchTo()->frame($iframe);
    sleep(1); */

    $modal = $driver->findElement(WebDriverBy::cssSelector($div_selector));
    $driver->switchTo()->frame($modal);
    sleep(1);

    // genjam
    $driver->findElement(WebDriverBy::xpath($accept_1_xpath))->click();
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($accept_2_xpath))->click();
    sleep(1);
    $driver->findElement(WebDriverBy::xpath($accept_3_xpath))->click();
    sleep(3);
}

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
