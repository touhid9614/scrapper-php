<?php

    $adsync_dir = dirname(dirname(__DIR__)). '/adwords3/';

    require_once $adsync_dir . 'config.php';
    require_once $adsync_dir . 'db-config.php';
    require_once $adsync_dir . 'db_connect.php';
    require_once $adsync_dir . 'tag_db_connect.php';
    require_once $adsync_dir . 'utils.php';

    $db_connect = new DbConnect();

    use Google\Spreadsheet\DefaultServiceRequest;
    use Google\Spreadsheet\ServiceRequestFactory;

    ini_set( "display_errors", 0);
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/client_secret.json');

    $client = new Google_Client;
    $client->useApplicationDefaultCredentials();
    $client->setApplicationName("Advertising Cost Calculator");
    $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);
     
    if ($client->isAccessTokenExpired()) 
    {
        $client->refreshTokenWithAssertion();
    }
     
    $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
    ServiceRequestFactory::setInstance(new DefaultServiceRequest($accessToken));

    $trialSpreadsheet = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Trial Clients');
     
    $trialClientWorksheet = $trialSpreadsheet->getWorksheetByTitle('Sheet1');
    /*$trialWorksheets = $trialSpreadsheet->getWorksheetFeed()->getEntries();
    $trialClientWorkSheet = $trialWorksheets[0];*/
    $trialClientFeed = $trialClientWorksheet->getListFeed();
    $trialClientAIWorksheet = $trialSpreadsheet->getWorksheetByTitle('AI');
    /*$trialAIWorksheets = $trialSpreadsheet->getWorksheetFeed()->getEntries();
    $trialClientAIWorkSheet = $trialAIWorksheets[1];*/
    $trialClientAIFeed = $trialClientAIWorksheet->getListFeed();

    $invoiceSpreadsheet = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Invoice Spread Sheet');
     
    $invoiceWorkSheet = $invoiceSpreadsheet->getWorksheetByTitle('Invoice');
    /*$invoiceWorksheets = $invoiceSpreadsheet->getWorksheetFeed()->getEntries();
    $invoiceWorkSheet = $invoiceWorksheets[1];*/
    $invoiceFeed = $invoiceWorkSheet->getListFeed();
    $invoiceURL = [];

    foreach ($invoiceFeed->getEntries() as $invoiceEntry)
    {
        $invoiceData = $invoiceEntry->getValues();
        array_push($invoiceURL,$invoiceData['websiteurl']);
    }

    $AI_URL_mapped = [];
    $AI_URL = [];

    foreach ($trialClientAIFeed->getEntries() as $AI_Entry)
    {
        $AI_Data = $AI_Entry->getValues();
        array_push($AI_URL,$AI_Data['url']);
        $AI_URL_mapped[$AI_Data['url']] = $AI_Data['clientname'];
    }

    $ignoreThese = array_intersect($AI_URL,$invoiceURL);
    sort($ignoreThese);
    $db_connect->query("TRUNCATE TABLE dealerships_trial_clients");

    foreach ($trialClientFeed->getEntries() as $trialEntry) 
    {
        $representative = $trialEntry->getValues();

        $insert_Trial_Client = 
        [
            'company_name'  => $representative['clientname'],
            'url'           => $representative['url'],
            'status'        => $representative['status'],
            'product'       => $representative['product']
        ];

        if (($key = array_search($insert_Trial_Client['url'], $ignoreThese)) !== false)
        {
            unset($ignoreThese[$key]);
            continue;
        } 
        else 
        {
            $query_prep = $db_connect->prepare_query_params($insert_Trial_Client, DbConnect::PREPARE_PARENTHESES);
            $query_str  = "INSERT INTO dealerships_trial_clients $query_prep";
            $db_connect->query($query_str);
        }
    }

    foreach ($AI_URL_mapped as $key => $value) 
    {
        $insert_ai_client   = 
        [
            'status'        => 'trial',
            'url'           => $key,
            'company_name'  => $value
        ];

        if (in_array($key,$ignoreThese))
        {
            //echo "inserting " . $key . "<br>";
            $query_prep = $db_connect->prepare_query_params($insert_ai_client, DbConnect::PREPARE_PARENTHESES);
            $query_str  = "INSERT INTO dealerships_trial_clients $query_prep";
            $db_connect->query($query_str);
        }
    }

/*Array
(
    [clientname] => Bonita Springs Mitsubishi
    [url] => https://www.bonitaspringsmitsubishi.com
    [status] => Trial
    [product] = Facebook
)*/