<?php

require_once 'bootstrapper.php';

$entry_urls = array(
    'https://wwwb.autotrader.ca/dealer/dealerfinder/dealerfinder.aspx?prbr=SK&rctry=true&rcs=0&prv=Saskatchewan&r=12&rprv=True&st=11'
);

function csv_write($csv_file, $data)
{
    $count = 0;
    $txt = "";
    foreach ($data as $value) {
        if ($count > 0) {
            $txt .= ",";
        }
        $txt .= "\"$value\"";
        $count++;
    }
    $txt .= "\n";

    file_put_contents($csv_file, $txt, FILE_APPEND);
}

$csv_file = 'data/autotrader_SK.csv';

if (!file_exists($csv_file)) {
    unlink($csv_file);
}

csv_write($csv_file, [
    'Dealer Name',
    'Address',
    'City',
    'State',
    'Postal Code',
    'Phone',
    'Website',
    'Autotrader Inventory',
    'Inventory Count',
    'Available in Autotrader'
]);

foreach ($entry_urls as $entry_url) {
    $url = $entry_url;

    while ($url) {
        slecho("Scrapping from $url");
        $list = scrap_url($url);

        if ($list) {
            if (isset($list->dealerships)) {
                foreach ($list->dealerships as $dealership) {

                    if (!isset($dealership->company_name)) {
                        continue;
                    }

                    csv_write($csv_file, [
                        $dealership->company_name,
                        $dealership->address_line1,
                        $dealership->city,
                        $dealership->state,
                        $dealership->zip,
                        $dealership->phone,
                        $dealership->dealer_website,
                        $dealership->dealer_inventory,
                        $dealership->inventory_count,
                        $dealership->dealer_inventory ? 'Yes' : 'No'
                    ]);
                }
            }

            $url = isset($list->next_page_url) ? $list->next_page_url : null;
            usleep(2000000 + rand(0, 5000000));
        } else {
            $url = null;
        }
    }
}

slecho('************************************ THE END ************************************');
