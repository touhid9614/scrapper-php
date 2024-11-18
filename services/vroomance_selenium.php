<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "$base_dir/adwords3/";
$selenium_dir = $adwords_dir . '/caches/selenium_proxy/';
$proxy_dir    = $adwords_dir . 'data/';
$log_path     = $adwords_dir . "caches/vroomance/simulation.txt";
$multi_log    = $adwords_dir . "caches/vroomance/multisession.txt";
$running      = $adwords_dir . "caches/vroomance/running.txt";
$screenshots  = $adwords_dir . 'caches/vroomance/screenshots/';
$post_code    = $adwords_dir . "data/regina_post_code.txt";

/* INCLUDE REQUIRED FILES */
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';

/* ARRAY_PUSH FUNCTION TAKE A LOT OF MEMMORY. PHP MAY HAVE MEMORY LEAK. */
ini_set('memory_limit', '4096M');

/* SELENIUM HOST ADDRESS */
//$selenium_host_addr = "http://localhost:4444/wd/hub";
//$selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
$selenium_host_addr = "http://selenium.smedia.ca:4444/wd/hub";

/* GET THE URL PARAMETERS */
$proxy_area = filter_input(INPUT_GET, 'proxy_area'); // 'FL'  or 'CA'

/* GET RANDOM PROXY AND SEPARATE INTO PARTS */
$proxy_list = $proxy_dir . 'proxy-list.txt';

if ($proxy_area === 'FL') {
    $proxy_list = $proxy_dir . 'fl-proxy-list.txt';
} else if ($proxy_area === 'CA') {
    $proxy_list = $proxy_dir . 'ca-proxy-list.txt';
}

$rand_proxy = getRandomProxy($proxy_list);
$proxy_part = explode(':', $rand_proxy);
$proxy_host = $proxy_part[0];
$proxy_port = $proxy_part[1];
$proxy_user = $proxy_part[2];
$proxy_pass = $proxy_part[3];
$PROXY      = $proxy_host . ':' . $proxy_port;

/* CREATE CHROME EXTENSION FOR PROXY AUTHENTICATION */
$pluginForProxyLogin = $selenium_dir . 'selenium_proxy.zip';
$zip                 = new ZipArchive();
$res                 = $zip->open($pluginForProxyLogin, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zip->addFile($selenium_dir . 'manifest.json', 'manifest.json');
$background = file_get_contents($selenium_dir . 'background.js');
$background = str_replace(['%proxy_host', '%proxy_port', '%proxy_user', '%proxy_pass'], [$proxy_host, intval($proxy_port), $proxy_user, $proxy_pass], $background);
$zip->addFromString('background.js', $background);
$popup = file_get_contents($selenium_dir . 'popup.html');
$popup = str_replace('192.168.0.1', $PROXY, $popup);
$zip->addFromString('popup.html', $popup);
$zip->addFile($selenium_dir . 'popup.js', 'popup.js');
$zip->addFile($selenium_dir . 'icon.png', 'icon.png');
$zip->close();

/* SET SELENIUM SESSION AND ADD CHROME EXTENSION */
$options = new ChromeOptions();
$options->addExtensions([$pluginForProxyLogin]);
$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36";
$arguments = ['--user-agent=' . $userAgent];
$options->addArguments($arguments);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver         = RemoteWebDriver::create($selenium_host_addr, $caps);
$currentSession = $driver->getSessionID();
writeLog($log_path, "Chosen proxy : {$rand_proxy} for session : {$currentSession}.");
writeRunningDriver($currentSession);
sleep(2);

/* HIT DOMAIN URL TWICE TO START SELENIUM SESSION RUNNING */
$driver->get('https://www.vroomance.com/');
sleep(2);
$driver->get('https://www.vroomance.com/');
sleep(1);

/* USE SEARCH SELECTIONS ON VROOMANCE HOME PAGE */
/* SEARCH PARAMETERS */
$searchPanel       = '#root > div > div.home-page > div.searchPanel';
$searchFilterView  = $searchPanel . ' > div.searchFilterView';
$distanceShow      = $searchFilterView . ' > div > div:nth-child(1) > div > div';
$searchFilterGroup = '#root > div > div.home-page > div.searchPanel > div.searchFilterGroup';
$searchSelector    = $searchFilterView . ' > div > div.searchButton > span';

/* GET DISTANCE */
$test = $driver->findElement(WebDriverBy::cssSelector($distanceShow))->click();
$item = $driver->findElements(WebDriverBy::className('option-list-item'));
$item[2]->click(); // 20km
//$item[6]->click();  // 500km

/* GET POST CODE */
// 75% times choses 'S4V 0A7' other times randomly choses one among 7313 regina post codes.
$postCode = rand75() ? 'S4V 0A7' : getRandomReginaPostCode();
//$postCode = 'S4V 0A7';
$test = $driver->findElement(WebDriverBy::className('searchZipcodeInput'))->sendKeys($postCode);

/* SHOW MAKE DROPDOWN */
$makeButton = $searchPanel . ' > div.searchFilterGroup > div:nth-child(4)';
$driver->findElement(WebDriverBy::cssSelector($makeButton))->click();
sleep(1);

// Need to keep clicking until there's no more `loadMore`
$loadMoreXPath = '//*[@id="root"]/div/div[2]/div[3]/div[2]/div[4]/div[1]/div[2]';

while (true) {
    if ($driver->findElements(WebDriverBy::xpath($loadMoreXPath)) != null) {
        $loadMore = $driver->findElement(WebDriverBy::className('loadMore'))->click();
        sleep(1);
    } else {
        break;
    }
}

/* CHOOSE A MAKE */
$makes = $driver->findElements(WebDriverBy::cssSelector('div.makeList div'));
$makes[mt_rand(0, count($makes) - 1)]->click();
$driver->findElement(WebDriverBy::cssSelector($searchSelector))->click();

/* QUIT SESSION IF NOTHING IS FOUND */
$noResult = '//*[@id="root"]/div/div[2]/div[2]/div/h1/strong/i';

/*if ($driver->findElements(WebDriverBy::xpath($noResult)) != null)
{
writeLog($log_path, "Nothing found for {$currentSession} using {$PROXY} in {$postCode}.");
removeDriver($currentSession);
$driver->quit();
}*/

if (!count($driver->findElements(WebDriverBy::className('result-item-name')))) {
    writeLog($log_path, "Nothing found for {$currentSession} using {$PROXY} in {$postCode}.");
    removeDriver($currentSession);
    $driver->quit();
}

/* VROOMANCE SEARCH RESULT SRP */
sleep(7); // let the page load.
//$driver->getKeyboard()->pressKey(WebDriverKeys::PAGE_DOWN);
//$driver->getKeyboard()->sendKeys(WebDriverKeys::CONTROL + WebDriverKeys::TAB);

// Load 7 more times bringing maximum 42 more cars making total max car number to 48.
for ($i = 0; $i < 3; $i++) {
    $driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');
    sleep(5);
}

$srps    = $driver->findElements(WebDriverBy::className('result-item-name'));
$counter = count($srps);
writeLog($log_path, "{$counter} vehicles are being visited by session : {$currentSession} using proxy : {$PROXY}");

foreach ($srps as $srp) {
    $srp->click();
    sleep(1);
}

/*$pagination = $driver->findElements(WebDriverBy::className('pagination-button'));
$lastPage = end($pagination);
$lastPage->click();
sleep(5);
$url = $driver->getCurrentURL();*/

//$pageRegex = '/.*show-results.*\&page=(?<page>[^&]+).*/';
//preg_match($pageRegex, $url, $page);

/*if ($page['page'])
{
$sessions = intval($page['page']);
$currURL = $url;
echo "Multi session test on " . $sessions . " urls";

for ($i = 2; $i <= $sessions; $i++)
{
$currURL = str_replace('&page=' + $sessions, '&page=' + $i, $url);
$file = $base_dir . '/services/vroomance_multisession.php';

$launch_str = $php_binary . ' '
. escapeshellarg($file) . ' '
. escapeshellarg(urlencode($currURL))
. ' > /dev/null 2>/dev/null &';

$sts = exec($launch_str, $outputr);
file_put_contents($multi_log, $outputr);
}
}*/

/* VISIT THE NEXT PAGES */
/*$nextPage = '//*[@id="root"]/div/div[2]/div[2]/div/div[2]/div/div[7]';
//$limit = 9;
while (true)
{
if ($driver->findElements(WebDriverBy::xpath($nextPage)) != null)
{
$driver->findElement(WebDriverBy::xpath($nextPage))->click();
sleep(5);   // let the page load.

$Newsrps = $driver->findElements(WebDriverBy::className('result-item-name'));

foreach ($Newsrps as $cursrp)
{
$cursrp->click();
sleep(1);
}

//$limit--;
}
else
{
break;
}
}*/

//$driver->action()->keyDown(WebDriverKeys::CONTROL)->sendKeys(WebDriverKeys::TAB)->keyUp(WebDriverKeys::CONTROL)->perform();
//$driver->getKeyboard()->sendKeys(WebDriverKeys::CONTROL + WebDriverKeys::TAB);

/* SCROLL TO BOTTOM OF PAGE AND RETURN BACK TO TOP AND SLEEP AND EXIT */
$driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');
sleep(mt_rand(2, 5));
$driver->executeScript('window.scrollTo(document.body.scrollHeight, 0);');
sleep(mt_rand(30, 60));
unlink($pluginForProxyLogin);
$driver->quit();
removeDriver($currentSession);

/**
 * Writes a running driver.
 *
 * @param      <type>  $session_id  The session identifier
 */
function writeRunningDriver($session_id)
{
    $base_dir          = dirname(__DIR__);
    $adwords_dir       = "$base_dir/adwords3/";
    $running           = fopen($adwords_dir . "caches/vroomance/running.txt", "w+");
    $running_file_name = $adwords_dir . "caches/vroomance/running.txt";
    $sessions          = file_get_contents($running_file_name);

    if (!empty($sessions)) {
        $sessions = json_decode($sessions, true);
    } else {
        $sessions = [];
    }

    array_push($sessions, $session_id);
    $sessions = json_encode($sessions, JSON_PRETTY_PRINT);
    file_put_contents($running_file_name, $sessions);
    fclose($running);
}

/**
 * Removes a driver.
 *
 * @param      <type>  $session_id  The session identifier
 */
function removeDriver($session_id)
{
    $base_dir          = dirname(__DIR__);
    $adwords_dir       = "$base_dir/adwords3/";
    $running           = fopen($adwords_dir . "caches/vroomance/running.txt", "w+");
    $running_file_name = $adwords_dir . "caches/vroomance/running.txt";

    $sessions = json_decode(file_get_contents($running_file_name), true);
    unset($sessions[array_search($session_id, $sessions)]);
    $sessions = json_encode($sessions, JSON_PRETTY_PRINT);
    file_put_contents($running_file_name, $sessions);
    fclose($running);
}

function sendShortCut(RemoteWebDriver $driver)
{
    /*Actions action = new Actions($driver);
    action.sendKeys(Keys.chord(Keys.CONTROL, "T")).build().perform();*/
    //$driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
    //$action = $driver->action();
    //$action->moveToElement($element_you_want)->perform();
    //$action->keyDown(WebDriverKeys::CONTROL)->sendKeys(WebDriverKeys::TAB)->keyUp(WebDriverKeys::CONTROL)->perform();
    //Actions act = new Actions(driver);
    //act.keyDown(Keys.CONTROL).sendKeys("t").keyUp(Keys.CONTROL).build().perform();
}

/*public static void switchToWindowByTitle(WebDriver driver, String title) {
Set<String> Handles = driver.getWindowHandles();
for (String handle : Handles) {
driver.switchTo().window(handle);
String drivertitle = driver.getTitle().trim();
if (drivertitle.equals(title)) {
break;
}
}
}

//Index is 0 based
public static void switchToWindowByIndex(WebDriver driver, int index) {
Set<String> handles = driver.getWindowHandles();
if (handles.size() > index) {
String handle = handles.toArray()[index].toString();
driver.switchTo().window(handle);
}
}*/

function rand50()
{
    return rand() & 1;
}

function rand75()
{
    return rand50() | rand50();
}

function create_vroomance_search($car_type = 'used%2Cnew%2Ccertified', $make = null, $model = null, $zipcode = '', $page = 1, $q = '', $range = 0, $sort = 0, $color = null)
{
    $base_url = 'https://www.vroomance.com/show-results?';
    $url      = $base_url . 'car_type=' . $car_type;

    if ($make) {
        $url .= '&make=' . $make;

        if ($model) {
            $url .= '&model=' . $model;
        }
    }

    $url .= '&page=' . $page;
    $url .= '&q=' . $q;
    $url .= '&range=' . $range;
    $url .= '&zipcode=' . $zipcode;

    if ($color) {
        $url .= '&color=' . $color;
    }
}
