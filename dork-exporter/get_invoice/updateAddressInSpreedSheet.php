<?php

    $update_dealership_name     = $_POST['update_dealership_name']; 
    $update_website_url         = $_POST['update_website_url']; 
    $update_billing_address     = $_POST['update_billing_address'];
    $update_city_name           = $_POST['update_city_name'];
    $update_country             = $_POST['update_country'];
    $update_sub_division_code   = $_POST['update_sub_division_code'];
    $update_postal_code         = $_POST['update_postal_code'];
    $update_billing_email       = $_POST['update_billing_email'];

    require  __DIR__ . '../../vendor/autoload.php';

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
    ServiceRequestFactory::setInstance(
        new DefaultServiceRequest($accessToken)
    );

    $spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Invoice Spread Sheet');

    $invoiceWorkSheet = $spreadsheet->getWorksheetByTitle('Invoice');
    $listFeed = $invoiceWorkSheet->getListFeed();
    $foundItBaby = false;
    $lastEntryUrl = null;

    foreach ($listFeed->getEntries() as $entry) 
    {
        $representative = $entry->getValues();
        if ($foundItBaby == true)
        {
            if ($representative['websiteurl'] != $update_website_url)
            {
                break;
            }
        }

        if ($representative['websiteurl'] == $update_website_url)
        {
            $lastEntryUrl= $update_website_url;
            $foundItBaby = true;
            $entry->update(array_merge($representative, ['billaddrline1' => $update_billing_address, 'billaddrcity' => $update_city_name, 'billaddrcountry' => $update_country, 'billaddrsubdivisioncode' => $update_sub_division_code, 'billaddrpostalcode' => $update_postal_code, 'billemaill' => $update_billing_email]));
        }
        /*else
        {
            $lastEntryUrl = $representative['websiteurl'];
        }*/
    }

    echo "Address update in spreedsheet successful!";