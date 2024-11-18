<?php

define('adlang', 'en');

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/Google/Util.php';
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/Facebook/Fb.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use FacebookAds\Api;
use FacebookAds\Object\AdAccountUser;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\TargetingSearch;
use FacebookAds\Object\Search\TargetingSearchTypes;

// Init PHP Sessions
session_start();

$fb = new Facebook([
    'app_id' => '1624969190861580',
    'app_secret' => 'ff8bee697d0d4dde38e7f15461700258',
]);

$helper = $fb->getRedirectLoginHelper();

if (!isset($_SESSION['facebook_access_token'])) {
  $_SESSION['facebook_access_token'] = null;
}

if (!$_SESSION['facebook_access_token']) {
    
    $helper = $fb->getRedirectLoginHelper();
    
    try {
        $_SESSION['facebook_access_token'] = (string) $helper->getAccessToken();
    } catch(FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
}

if ($_SESSION['facebook_access_token']) {
    echo "You are logged in!<br/>";
    
    $fb = new Fb('1624969190861580', // App ID
        'ff8bee697d0d4dde38e7f15461700258',
        $_SESSION['facebook_access_token'], '1404490926255533' /* Account Id */, '288924967912308' /* Page Id */, '457794264564320' /* Pixel Id */,
        '303901506711149' /* dataset */, '1857779634543326' /* Form Id */, null);
    
    
    Api::init(
        '1624969190861580', // App ID
        'ff8bee697d0d4dde38e7f15461700258',
        $_SESSION['facebook_access_token'] // Your user access token
    );
    
    echo "Initialized Ads Api<br/>";
    
    $me = new AdAccountUser('me');
    
    echo "Me is initialized<br/>";
    
    $my_adaccount = $me->getAdAccounts([AdAccountFields::ACCOUNT_ID, AdAccountFields::NAME, AdAccountFields::BALANCE, AdAccountFields::AGE], []);

    echo "Got my accounts<br/>";
    
    while($my_adaccount->current()) {
        echo "<pre>";
        print_r($my_adaccount->current()->getData());
        echo "</pre>";
        $my_adaccount->next();
    }
    
    $account = new AdAccount('act_538410469543708');
    
    $maccount = $account->getSelf([AdAccountFields::ACCOUNT_ID, AdAccountFields::NAME]);
    
    echo "My acocunt is loaded<br/>";
    
    echo "<pre>";
    print_r($account->getCampaigns([CampaignFields::NAME, CampaignFields::EFFECTIVE_STATUS, CampaignFields::OBJECTIVE])->current()->getData());
    echo "</pre>";
    die();
} 

else {
    $permissions = ['ads_management'];
    $loginUrl = $helper->getLoginUrl('https://tm.smedia.ca/adwords3/budget-manager.php', $permissions);
    echo '<a href="' . $loginUrl . '">Log in with Facebook</a>';
}

?>