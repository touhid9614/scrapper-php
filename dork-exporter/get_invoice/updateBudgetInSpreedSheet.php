<?php
    
    $dealership_data        = $_POST['dealership_data'];
    $dealership_data        = json_decode($dealership_data, true);
    $len                    = sizeof($dealership_data);
    $urlMatch               = $dealership_data[0]['url'];

    require  '../../vendor/autoload.php';

    use Google\Spreadsheet\DefaultServiceRequest;
    use Google\Spreadsheet\ServiceRequestFactory;
    ini_set( "display_errors", 0);

    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/client_secret.json');
    $client             = new Google_Client;
    $client->useApplicationDefaultCredentials();
    $client->setApplicationName("Advertising Cost Calculator");
    $client->setScopes(['https://www.googleapis.com/auth/drive', 'https://spreadsheets.google.com/feeds']);
    
    if ($client->isAccessTokenExpired())
    {
        $client->refreshTokenWithAssertion();
    }
     
    $accessToken        = $client->fetchAccessTokenWithAssertion()["access_token"];
    ServiceRequestFactory::setInstance(
        new DefaultServiceRequest($accessToken)
    );

    $spreadsheet        = (new Google\Spreadsheet\SpreadsheetService)
       ->getSpreadsheetFeed()
       ->getByTitle('Invoice Spread Sheet');

    $invoiceWorkSheet   = $spreadsheet->getWorksheetByTitle('Invoice');
    $listFeed           = $invoiceWorkSheet->getListFeed();
    $foundItBaby        = false;
    $lastEntryUrl       = null;

    foreach ($listFeed->getEntries() as $entry) 
    {
        $representative = $entry->getValues();

        if ($foundItBaby == true)
        {
            if ($representative['websiteurl'] != $urlMatch)
            {
                break;
            }
        }
        
        if ($representative['websiteurl'] == $urlMatch)
        {
            $lastEntryUrl= $urlMatch;
            $foundItBaby = true;

            for ($i=0; $i<$len; $i++)
            {
                $linedescription    = $dealership_data[$i]['linedescription'];
                $budget             = $dealership_data[$i]['budget'];
                $lineamount         = $dealership_data[$i]['lineamount'];
                
                if ($representative['linedescription'] == $linedescription)
                {
                    $entry->update(array_merge($representative, ['budget' => $update_budget, 'lineamount' => $update_line_amount]));
                    break;
                }
            }
        }
        /*else
        {
            $lastEntryUrl = $representative['websiteurl'];
        }*/
    }

    echo "Budget update in spreedsheet successful!";