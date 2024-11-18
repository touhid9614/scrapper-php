<?php

namespace Microsoft\BingAds\Samples\V13;

require_once dirname(dirname(dirname(__DIR__)))  .  '/vendor/autoload.php';

require_once __DIR__ . "/CustomerManagementExampleHelper.php";

// Specify the Microsoft\BingAds\Auth classes that will be used.

use Microsoft\BingAds\Auth\OAuthDesktopMobileAuthCodeGrant;
use Microsoft\BingAds\Auth\OAuthWebAuthCodeGrant;
use Microsoft\BingAds\Auth\AuthorizationData;
use Microsoft\BingAds\Auth\OAuthTokenRequestException;
use Microsoft\BingAds\Auth\ApiEnvironment;
use Microsoft\BingAds\Auth\ServiceClient;
use Microsoft\BingAds\Auth\ServiceClientType;

// Specify the Microsoft\BingAds\Samples\V13 classes that will be used.
use Microsoft\BingAds\Samples\V13\CustomerManagementExampleHelper;

// Specify the Microsoft\BingAds\V13\CampaignManagement classes that will be used.
use Microsoft\BingAds\V13\CampaignManagement\AdGroupCriterionType;
use Microsoft\BingAds\V13\CampaignManagement\CampaignCriterionType;
use Microsoft\BingAds\V13\CampaignManagement\CampaignType;

// Specify the Microsoft\BingAds\V13\CustomerManagement classes that will be used.

use Microsoft\BingAds\V13\CustomerManagement\GetUserRequest;
use Microsoft\BingAds\V13\CustomerManagement\SearchAccountsRequest;
use Microsoft\BingAds\V13\CustomerManagement\Paging;
use Microsoft\BingAds\V13\CustomerManagement\Predicate;
use Microsoft\BingAds\V13\CustomerManagement\PredicateOperator;

use Exception;

/**
 * Defines global settings that you can use for testing your application.
 * Your production implementation may vary, and you should always store sensitive information securely.
 */
final class AuthHelper {

    const DeveloperToken = '1250S68J89142410';  //Multiple Account
    //const DeveloperToken = '125QHPPR6F919335';  //Single Account
    //const DeveloperToken = 'BBD37VB98';  // For sandbox use BBD37VB98
    const ApiEnvironment = ApiEnvironment::Production;
    const OAuthRefreshTokenPath =  '/var/www/html/tm.smedia.ca/adwords3/data/refresh.txt';
//    const OAuthRefreshTokenPath =  'refresh.txt';
    const ClientId = '99bfe435-bd6a-4dc2-9b3e-9b4f4d14f00a';

    const CampaignTypes =
        CampaignType::Audience . ' ' .
        CampaignType::Search . ' ' .
        CampaignType::Shopping . ' ' .
        CampaignType::DynamicSearchAds;

    const AllTargetCampaignCriterionTypes =
        CampaignCriterionType::Age . ' ' .
        CampaignCriterionType::DayTime . ' ' .
        CampaignCriterionType::Device . ' ' .
        CampaignCriterionType::Gender . ' ' .
        CampaignCriterionType::Location . ' ' .
        CampaignCriterionType::LocationIntent . ' ' .
        CampaignCriterionType::Radius;

    const AllTargetAdGroupCriterionTypes =
        AdGroupCriterionType::Age . ' ' .
        AdGroupCriterionType::DayTime . ' ' .
        AdGroupCriterionType::Device . ' ' .
        AdGroupCriterionType::Gender . ' ' .
        AdGroupCriterionType::Location . ' ' .
        AdGroupCriterionType::LocationIntent . ' ' .
        AdGroupCriterionType::Radius;

    static function Authenticate($account_id = null , $log_file_path = null)
    {
        writeLog($log_file_path, "*****  Bing V13 Call" );
        // Disable WSDL caching.
        ini_set("soap.wsdl_cache_enabled", "0");
        ini_set("soap.wsdl_cache_ttl", "0");

        // Authenticate with a Microsoft Account.
        AuthHelper::AuthenticateWithOAuth($log_file_path);

        writeLog($log_file_path, "*****  Authenticate With OAuth" );

        $GLOBALS['CustomerManagementProxy'] = new ServiceClient(
            ServiceClientType::CustomerManagementVersion13,
            $GLOBALS['AuthorizationData'],
            AuthHelper::GetApiEnvironment()
        );

        // Set to an empty user identifier to get the current authenticated user,
        // and then search for accounts the user can access.
        $user = CustomerManagementExampleHelper::GetUser(
            null,
            true
        )->User;

        // To retrieve more than 100 accounts, increase the page size up to 1,000.
        // To retrieve more than 1,000 accounts you'll need to implement paging.
        $accounts = AuthHelper::SearchAccountsByUserId(
            $user->Id,
            0,
            100
        )->Accounts;

        if(!is_null($account_id)) {
            foreach ($accounts->AdvertiserAccount as  $key => $value) {
                if($value->Id == $account_id) {
                    $GLOBALS['AuthorizationData']->AccountId  = $value->Id;
                    $GLOBALS['AuthorizationData']->CustomerId = $value->ParentCustomerId;
                    break;
                }
            }
        } else {
            // We'll use the first account by default for the examples.
            $GLOBALS['AuthorizationData']->AccountId = $accounts->AdvertiserAccount[0]->Id;
            $GLOBALS['AuthorizationData']->CustomerId = $accounts->AdvertiserAccount[0]->ParentCustomerId;
        }
        // We'll use the first account by default for the examples.

        $GLOBALS['AdInsightProxy'] = new ServiceClient(
            ServiceClientType::AdInsightVersion13,
            $GLOBALS['AuthorizationData'],
            AuthHelper::GetApiEnvironment()
        );

        $GLOBALS['BulkProxy'] = new ServiceClient(
            ServiceClientType::BulkVersion13,
            $GLOBALS['AuthorizationData'],
            AuthHelper::GetApiEnvironment()
        );

        $GLOBALS['CampaignManagementProxy'] = new ServiceClient(
            ServiceClientType::CampaignManagementVersion13,
            $GLOBALS['AuthorizationData'],
            AuthHelper::GetApiEnvironment()
        );

        $GLOBALS['CustomerManagementProxy'] = new ServiceClient(
            ServiceClientType::CustomerManagementVersion13,
            $GLOBALS['AuthorizationData'],
            AuthHelper::GetApiEnvironment()
        );

        $GLOBALS['ReportingProxy'] = new ServiceClient(
            ServiceClientType::ReportingVersion13,
            $GLOBALS['AuthorizationData'],
            AuthHelper::GetApiEnvironment()
        );
    }

    static function SearchAccountsByUserId($userId, $pageIndex, $pageSize)
    {
        $GLOBALS['Proxy'] = $GLOBALS['CustomerManagementProxy'];

        // Specify the page index and number of account results per page.

        $pageInfo = new Paging();
        $pageInfo->Index = $pageIndex;
        $pageInfo->Size = $pageSize;

        $predicate = new Predicate();
        $predicate->Field = "UserId";
        $predicate->Operator = PredicateOperator::Equals;
        $predicate->Value = $userId;

        $request = new SearchAccountsRequest();
        $request->Ordering = null;
        $request->PageInfo = $pageInfo;
        $request->Predicates = array($predicate);

        return $GLOBALS['Proxy']->GetService()->SearchAccounts($request);
    }

    // Sets the global authorization data instance with OAuthDesktopMobileAuthCodeGrant.

    static function AuthenticateWithOAuth($log_file_path = null)
    {
		writeLog($log_file_path, "*****  GO for RefreshToken" );
        $authentication = (new OAuthDesktopMobileAuthCodeGrant())
            ->withEnvironment(AuthHelper::ApiEnvironment)
            ->withClientId(AuthHelper::ClientId);

        $GLOBALS['AuthorizationData'] = (new AuthorizationData())
            ->withAuthentication($authentication)
            ->withDeveloperToken(AuthHelper::DeveloperToken);

        try
        {
            $refreshToken = AuthHelper::ReadOAuthRefreshToken($log_file_path);
			writeLog($log_file_path, "***** RefreshToken".$refreshToken);
            if($refreshToken != null)
            {
                $GLOBALS['AuthorizationData']->Authentication->RequestOAuthTokensByRefreshToken($refreshToken);
                AuthHelper::WriteOAuthRefreshToken(
                    $GLOBALS['AuthorizationData']->Authentication->OAuthTokens->RefreshToken
                );
            }
            else
            {
                AuthHelper::RequestUserConsent();
            }
        }
        catch(OAuthTokenRequestException $e)
        {
            printf("Error: %s\n", $e->Error);
            printf("Description: %s\n", $e->Description);

            AuthHelper::RequestUserConsent();
        }
    }

    static function RequestUserConsent()
    {
        print "You need to provide consent for the application to access your Microsoft Advertising accounts. " .
              "Copy and paste this authorization endpoint into a web browser and sign in with a Microsoft account " .
              "with access to a Microsoft Advertising account: \n\n" . $GLOBALS['AuthorizationData']->Authentication->GetAuthorizationEndpoint() .
              "\n\nAfter you have granted consent in the web browser for the application to access your Microsoft Advertising accounts, " .
              "please enter the response URI that includes the authorization 'code' parameter: \n\n";

        $responseUri = fgets(STDIN);
        print "\n";

        $GLOBALS['AuthorizationData']->Authentication->RequestOAuthTokensByResponseUri(trim($responseUri));
        AuthHelper::WriteOAuthRefreshToken($GLOBALS['AuthorizationData']->Authentication->OAuthTokens->RefreshToken);
    }

    static function GetApiEnvironment()
    {
        return AuthHelper::ApiEnvironment;
    }

    static function ReadOAuthRefreshToken($log_file_path = null)
    {
        $refreshToken = null;
		writeLog($log_file_path, "***** Refresh Token Reading " );
		writeLog($log_file_path, "***** Refresh Token path " .AuthHelper::OAuthRefreshTokenPath );
        if (file_exists(AuthHelper::OAuthRefreshTokenPath) && filesize(AuthHelper::OAuthRefreshTokenPath) > 0)
        {
            $refreshTokenfile = @\fopen(AuthHelper::OAuthRefreshTokenPath,"r");
			writeLog($log_file_path, "***** RefreshTokenPath". $refreshTokenfile);
            $refreshToken = fread($refreshTokenfile, filesize(AuthHelper::OAuthRefreshTokenPath));
            fclose($refreshTokenfile);
        }

        return $refreshToken;
    }

    static function WriteOAuthRefreshToken($refreshToken)
    {
        $refreshTokenfile = @\fopen(AuthHelper::OAuthRefreshTokenPath,"wb");
        if (file_exists(AuthHelper::OAuthRefreshTokenPath))
        {
            fwrite($refreshTokenfile, $refreshToken);
            fclose($refreshTokenfile);
        }

        return;
    }
}
