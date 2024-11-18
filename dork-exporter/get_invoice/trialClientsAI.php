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
    $client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);
     
    if ($client->isAccessTokenExpired()) 
    {
        $client->refreshTokenWithAssertion();
    }
     
    $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
    ServiceRequestFactory::setInstance(new DefaultServiceRequest($accessToken));
    
    $trialSpreadsheet = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Trial Clients');
     
    $trialWorksheets = $trialSpreadsheet->getWorksheetFeed()->getEntries();
    $trialClientWorkSheet = $trialSpreadsheet->getWorksheetByTitle('AI');
    //$trialClientWorkSheet = $trialWorksheets[1];
    $trialClientFeed = $trialClientWorkSheet->getListFeed();

    $invoiceSpreadsheet = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Invoice Spread Sheet');
     
    $invoiceWorksheets = $invoiceSpreadsheet->getWorksheetFeed()->getEntries();
    $invoiceWorkSheet = $invoiceSpreadsheet->getWorksheetByTitle('Invoice');
    //$invoiceWorkSheet = $invoiceWorksheets[1];
    $invoiceFeed = $invoiceWorkSheet->getListFeed();


    $db_connect->query("TRUNCATE TABLE dealerships_trial_clients_AI");
    foreach ($trialClientFeed->getEntries() as $entry) 
    {
        $representative = $entry->getValues();

        /*echo "<pre>";
        print_r($representative);*/

        $insert_Trial_Clients   = 
        [
            'company_name'      => $representative['clientname'],
            'url'               => $representative['url'],
            'ai_status'         => $representative['aistatusonly'],
        ];

        $query_prep             = $db_connect->prepare_query_params($insert_Trial_Clients, DbConnect::PREPARE_PARENTHESES);
        $query_str              = "INSERT INTO dealerships_trial_clients_AI $query_prep";
        $db_connect->query($query_str);
    }