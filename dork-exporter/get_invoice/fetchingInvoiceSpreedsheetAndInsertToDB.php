<?php

    $adsync_dir = dirname(dirname(__DIR__)). '/adwords3/';

    require_once $adsync_dir . 'config.php';
    require_once $adsync_dir . 'db-config.php';
    require_once $adsync_dir . 'db_connect.php';
    require_once $adsync_dir . 'tag_db_connect.php';
    require_once $adsync_dir . 'utils.php';

    use Google\Spreadsheet\DefaultServiceRequest;
    use Google\Spreadsheet\ServiceRequestFactory;

    $db_connect = new DbConnect('');
    ini_set( "display_errors", 0);

    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/client_secret.json');
    $client     = new Google_Client;
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
       ->getByTitle('Invoice Spread Sheet');

    $invoiceWorkSheet       = $spreadsheet->getWorksheetByTitle('Invoice');
    /*$invoiceWorksheets    = $spreadsheet->getWorksheetFeed()->getEntries();
    $invoiceWorkSheet       = $invoiceWorksheets[1];*/
    $listFeed               = $invoiceWorkSheet->getListFeed();

    $db_connect->query("TRUNCATE TABLE dealerships_invoice_data");
    $db_connect->query("TRUNCATE TABLE dealerships_billing");

    $lastEntry  = null;
    foreach ($listFeed->getEntries() as $entry)
    {
        $representative                 =  $entry->getValues();
        $url                            =  $representative['websiteurl'];
        $dealership                     =  getDomainDealer(GetDomain($url), $url);

        $insert_invoice                 =
        [
            'dealership'                => $dealership,
            'url'                       => $url,
            'customer'                  => $representative['customer'],
            'linedescription'           => $representative['linedescription'],
            'budget'                    => $representative['budget'],
            'lineamount'                => $representative['lineamount']
        ];

        $query_prep                     = $db_connect->prepare_query_params($insert_invoice, DbConnect::PREPARE_PARENTHESES);
        $query_str                      = "INSERT INTO dealerships_invoice_data $query_prep";
        $db_connect->query($query_str);

        if ($lastEntry['websiteurl']    == $representative['websiteurl'])
        {
            continue;
        }

        $insert_billing                 =
        [
            'dealership'                => $dealership,
            'url'                       => $url,
            'customer'                  => $representative['customer'],
            'billaddrline1'             => $representative['billaddrline1'],
            'billaddrcity'              => $representative['billaddrcity'],
            'billaddrcountry'           => $representative['billaddrcountry'],
            'billaddrsubdivisioncode'   => $representative['billaddrsubdivisioncode'],
            'billaddrpostalcode'        => $representative['billaddrpostalcode'],
            'billemaill'                => $representative['billemaill']
        ];

        $query_prep                     =  $db_connect->prepare_query_params($insert_billing, DbConnect::PREPARE_PARENTHESES);
        $query_str                      =  "INSERT INTO dealerships_billing $query_prep";
        $db_connect->query($query_str);
        $lastEntry                      =  $representative;
    }

/*
    $cellFeed = $worksheet->getCellFeed();
    $topLeftCornerCell = $cellFeed->getCell(4, 9);
    echo $topLeftCornerCell->getContent();
    $rows = $cellFeed->toArray();
*/
?>
