<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "{$base_dir}/adwords3";
$selenium_dir = "{$adwords_dir}/caches/selenium_proxy";
$proxy_dir    = "{$adwords_dir}/data";
$log_dir      = "{$adwords_dir}/caches/VS/selenium_log";
$one_day      = 43200; // 12 hours

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/tag_db_connect.php";
require_once "{$adwords_dir}/utils.php";
require_once "{$base_dir}/visual-scraper/regex_generator.php";

global $scrapper_configs;

// $mode = 'LOCAL';
// $mode = 'DEVELOPMENT';
$mode = 'PRODUCTION';

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

$get_dealer = strtolower(filter_input(INPUT_GET, 'dealership'));
$age        = isset($_POST['age']) ? filter_input(INPUT_GET, 'age') : $one_day;
$log_path   = "{$log_dir}/{$dealership}.log";

/* CHECK FOR ARRAY OF ARGUMENTS PASSED TO SCRIPT */
/*
$arg[0] = file to run
$arg[1] = dealership
$arg[2] = customer name (could be empty or marshal or anything. Not used)
 */
if (isset($argv)) {
    writeLog($log_path, "Write argv: {$argv[0]} - {$argv[1]} - {$argv[2]}");
    $get_dealer = $argv[1];
} else {
    writeLog($log_path, "No argv");
}

if ($get_dealer) {
    $scraper_config = isset($scrapper_configs) ? $scrapper_configs[$get_dealer] : false;
}

$use_proxy  = true;
$proxy_area = false;

/*if ($scraper_config) {
$use_proxy  = isset($scraper_config['use-proxy']) ? $scraper_config['use-proxy'] : true;
$proxy_area = isset($scraper_config['proxy_area']) ? $scraper_config['proxy_area'] : false;    // 'FL'  or 'CA'
}*/

/* START SELENIUM PROCESS */
writeLogByDealer("\n\n\n\n\n Start Running VS Selenium Script File", $get_dealer);

$db_connect = new DbConnect('');

if ($get_dealer) {
    $allactive_dealers = $db_connect->get_all_dealers("`dealership` = '$get_dealer'");
} else {
    $allactive_dealers = $db_connect->get_all_dealers("(`status` = 'active' OR `status` = 'trial' OR `status` = 'trial-setup') AND `scrapper_type` = 'VS'");
}

foreach ($allactive_dealers as $dealership => $dealer_data) {
    $options = new ChromeOptions();

    if ($use_proxy) {
        /* GET RANDOM PROXY AND SEPARATE INTO PARTS */
        $proxy_list = "{$proxy_dir}/proxy-list.txt";

        if ($proxy_area) {
            if ($proxy_area === 'FL') {
                $proxy_list = "{$proxy_dir}/fl-proxy-list.txt";
            } else if ($proxy_area === 'CA') {
                $proxy_list = "{$proxy_dir}/ca-proxy-list.txt";
            }
        }

        $rand_proxy = getRandomProxy($proxy_list);
        $proxy_part = explode(':', $rand_proxy);
        $proxy_host = $proxy_part[0];
        $proxy_port = $proxy_part[1];
        $proxy_user = $proxy_part[2];
        $proxy_pass = $proxy_part[3];
        $PROXY      = $proxy_host . ':' . $proxy_port;
        writeLogByDealer("Chosen proxy : {$rand_proxy}", $dealership);

        /* CREATE CHROME EXTENSION FOR PROXY AUTHENTICATION */
        $pluginForProxyLogin = "{$selenium_dir}/selenium_proxy.zip";
        $zip                 = new ZipArchive();
        $res                 = $zip->open($pluginForProxyLogin, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile("{$selenium_dir}/manifest.json", 'manifest.json');
        $background = file_get_contents("{$selenium_dir}/background.js");
        $background = str_replace(['%proxy_host', '%proxy_port', '%proxy_user', '%proxy_pass'], [$proxy_host, intval($proxy_port), $proxy_user, $proxy_pass], $background);
        $zip->addFromString('background.js', $background);
        $popup = file_get_contents("{$selenium_dir}/popup.html");
        $popup = str_replace('192.168.0.1', $proxy_host, $popup);
        $zip->addFromString('popup.html', $popup);
        $zip->addFile("{$selenium_dir}/popup.js", 'popup.js');
        $zip->addFile("{$selenium_dir}/icon.png", 'icon.png');
        $zip->close();

        /* UPLOAD THE EXTENSION */
        $options->addExtensions([$pluginForProxyLogin]);
    }

    $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/$chrome_version Safari/537.36";
    $arguments = ['--user-agent=' . $userAgent];
    $options->addArguments($arguments);
    $caps = DesiredCapabilities::chrome();
    $caps->setCapability(ChromeOptions::CAPABILITY, $options);
    $driver = RemoteWebDriver::create($selenium_host_addr, $caps);

    /* HIT THE DOMAIN URL TWICE TO GET THE SELENIUM SESSION RUNNING */
    sleep(1);

    try {
        seleniumGet($driver, trim($dealer_data['websites']));
        sleep(2);
        seleniumGet($driver, trim($dealer_data['websites']));
    } catch (Exception $e) {
        $msg = 'SITE:' . trim($dealer_data['websites']) . '<br> ERROR MESSAGE:' . $e;
        writeLogByDealer($msg, $dealership, true);
        echo "ERROR REPORT:<br>$msg";
        continue;
    }

    writeRunningDriver($dealership, $driver->getSessionID());

    $onedayago_time = time() - $age;
    $query_str      = "SELECT id, url FROM vs_scraped_pages WHERE dealership = '$dealership' and last_updated < $onedayago_time AND deleted = FALSE ORDER BY last_updated ASC;";
    $result         = $db_connect->query($query_str);

    /* GENERATE VDP REGEX AND SRP REGEX */
    $knownVDP   = [];
    $knownSRP   = [];
    $regexQuery = $db_connect->query("SELECT url, page_type FROM vs_config_pages WHERE dealership = '$dealership' AND (page_type = 'vdp' OR page_type = 'listing');");

    while ($vdp = mysqli_fetch_assoc($regexQuery)) {
        if ($vdp['page_type'] == 'vdp') {
            $knownVDP[] = $vdp['url'];
        } else {
            $knownSRP[] = $vdp['url'];
        }
    }

    $vdp_regex = generate_regex($knownVDP);
    $srp_regex = generate_regex($knownSRP);

    $result2       = $db_connect->query("SELECT vdp_regex, srp_regex FROM vs_config WHERE dealership = '$dealership';");
    $fetch_result2 = mysqli_fetch_assoc($result2);

    if ($fetch_result2['vdp_regex'] != null && $fetch_result2['vdp_regex'] != '') {
        $vdp_regex = $fetch_result2['vdp_regex'];
    }

    if ($fetch_result2['srp_regex'] != null && $fetch_result2['srp_regex'] != '') {
        $srp_regex = $fetch_result2['srp_regex'];
    }

    if (mysqli_num_rows($result)) {
        /* START SRP TRAVERSER HERE */
        // code
        /* END SRP TRAVERSER HERE */
        $url_list = [];

        while ($fetch_result = mysqli_fetch_assoc($result)) {
            $current_time = time();
            $id           = $fetch_result['id'];
            $db_connect->query("UPDATE vs_scraped_pages SET last_updated = '$current_time' WHERE id = '$id';");
            $url_list[] = $fetch_result['url'];
        }

        shuffle($url_list);

        foreach ($url_list as $cur_url) {
            if (filter_var($cur_url, FILTER_VALIDATE_URL) !== false) {
                writeLogByDealer($cur_url, $dealership);

                try {
                    if (validate_by_generated_regex($cur_url, $vdp_regex) || validate_by_generated_regex($cur_url, $srp_regex)) {
                        seleniumInjector($driver, trim($cur_url));
                    }
                } catch (Exception $e) {
                    $msg = $cur_url . '     ' . $e;
                    writeLogByDealer($msg, $dealership, true);
                    continue;
                }
            }
        }
    } else {
        $config_pages_query = $db_connect->query("SELECT url FROM vs_config_pages WHERE dealership = '$dealership';");

        if (mysqli_num_rows($config_pages_query)) {
            while ($get_row = mysqli_fetch_assoc($config_pages_query)) {
                if (filter_var($get_row['url'], FILTER_VALIDATE_URL) !== false) {
                    writeLogByDealer($get_row['url'], $dealership);

                    try {
                        seleniumInjector($driver, trim($get_row['url']));
                    } catch (Exception $e) {
                        $msg = $url . '     ' . $e;
                        writeLogByDealer($msg, $dealership, true);
                        continue;
                    }
                }
            }

            //Check again vs_scraped page table
            $query_str = "SELECT id, url FROM vs_scraped_pages WHERE dealership = '$dealership' order by last_updated ASC;";
            $result    = $db_connect->query($query_str);

            if (mysqli_num_rows($result)) {
                while ($fetch_result = mysqli_fetch_assoc($result)) {
                    $current_time = time();
                    $id           = $fetch_result['id'];
                    $db_connect->query("UPDATE vs_scraped_pages SET last_updated = '$current_time' WHERE id = '$id';");

                    if (filter_var($fetch_result['url'], FILTER_VALIDATE_URL) !== false) {
                        writeLogByDealer($fetch_result['url'], $dealership);

                        try {
                            seleniumInjector($driver, trim($fetch_result['url']));
                        } catch (Exception $e) {
                            $msg = $url . '     ' . $e;
                            writeLogByDealer($msg, $dealership, true);
                            continue;
                        }
                    }
                }
            } else {
                writeLogByDealer("No valid url found for " . $dealership . " dealership, Please check your configuration data.", $dealership);
            }
        } else {
            writeLogByDealer("No valid url found for " . $dealership . " dealership", $dealership);
        }
    }

    if ($use_proxy == true) {
        unlink($pluginForProxyLogin);
    }

    $driver->quit();
    writeLogByDealer("Stop Running VS Selenium Script File\n\n\n\n\n", $dealership, true);
}

$db_connect->close_connection();

/**
 * Writes a running driver.
 *
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $session_id  The session identifier
 */
function writeRunningDriver($dealership, $session_id)
{
    $base_dir          = dirname(__DIR__);
    $running           = fopen("{$base_dir}/adwords3/caches/VS/selenium_log/running.log", "w+");
    $running_file_name = "{$base_dir}/adwords3/caches/VS/selenium_log/running.log";
    $sessions          = file_get_contents($running_file_name);

    if (!empty($sessions)) {
        $sessions = json_decode($sessions, true);
    } else {
        $sessions = [];
    }

    $sessions[$dealership] = $session_id;
    $sessions              = json_encode($sessions, JSON_PRETTY_PRINT);
    file_put_contents($running_file_name, $sessions);
    fclose($running);
}

/**
 * Writes a log by dealer.
 *
 * @param      <type>  $message     The message
 * @param      string  $dealership  The dealership
 */
function writeLogByDealer($message, $dealership, $close = false)
{
    $base_dir    = dirname(__DIR__);
    $adwords_dir = "{$base_dir}/adwords3";
    $log_file    = fopen("{$adwords_dir}/caches/VS/selenium_log/{$dealership}.log", "a+");
    chmod("{$adwords_dir}/caches/VS/selenium_log/{$dealership}.log", 0755);
    fwrite($log_file, date('Y-m-d H:i:s T') . ": " . $message . "\n");

    if ($close) {
        fclose($log_file);
    }
}

/**
 * { function_description }
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver      The driver
 * @param      string                                      $url         The url
 */
function seleniumInjector(RemoteWebDriver $driver, string $url)
{
    seleniumGet($driver, $url);

    sleep(4);
    injectVisualScraper($driver);
    sleep(4);
}

/**
 * { function_description }
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver  The driver
 * @param      string                                      $url     The url
 */
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

/**
 * Determines if my script is loaded.
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver  The driver
 * @param      <type>                                      $url     The url
 *
 * @return     boolean                                     True if my script loaded, False otherwise.
 */
function isMyScriptLoaded(RemoteWebDriver $driver, $url)
{
    $script =<<<'Kumar'
                var scripts = document.getElementsByTagName('script');

                for (var i = scripts.length; i--; )
                {
                    if (scripts[i].src == url)
                    {
                        return true;
                    }
                }

                return false;
Kumar;

    $driver->executeScript($script);
}

/**
 * { function_description }
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver  The driver
 */
function injectVisualScraper(RemoteWebDriver $driver)
{
    $script =<<< 'Chokshanada'
            console.log('Visual Scraper Script Injected Start');
            var script_visual_scraper = "https://tm.smedia.ca/visual-scraper/visual_scraper.js";
            var visualScraperScript = document.createElement('script');
            visualScraperScript.setAttribute('src', script_visual_scraper);
            document.body.appendChild(visualScraperScript);
            console.log('Visual Scraper Script Injection Completed');
Chokshanada;

    $driver->executeScript($script);
}
