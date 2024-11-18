<?php

    require  __DIR__ . '../../vendor/autoload.php';
    
    $update_client_name = $_POST['update_client_name'];
    $update_website_url = $_POST['update_website_url'];

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

    $spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Trial Clients');

    $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
    //$trialClientWorkSheet = $spreadsheet->getWorksheetByTitle('Invoice');
    $trialClientWorkSheet = $worksheets[0];
    $listFeed = $trialClientWorkSheet->getListFeed();

    foreach ($listFeed->getEntries() as $entry) 
    {
        $representative = $entry->getValues();
        if ($representative['websiteurl'] == $update_website_url)
        {
            $entry->update(array_merge($representative, ['clientname' => $update_client_name]));
        }
    }

    echo "Trial Client update successful";