<?php

function update_cache()
{
    $campaign_ids = $_REQUEST['campaign_ids'];
    // $new_amounts = $_REQUEST['new_amounts'];
    $dealership = $_REQUEST['dealership'];

    $data_file = ADSYNCPATH . "caches/budgetchecker/" . $dealership . "_data.txt";

    $data  = [];
    $data1 = [];
    foreach ($_REQUEST['campaign_ids'] as $key => $value) {
        $data[] = $value;
    }
    foreach ($_REQUEST['new_amounts'] as $key => $value) {
        $data1[] = $value;
    }
    $c            = array_combine($data, $data1);
    $fileContents = file_get_contents($data_file);
    $decoded      = json_decode($fileContents, true);

    foreach ($c as $key => $value) {
        //  foreach ($decoded as $key0 => $value0) {
        foreach ($decoded as $key1 => $value1) {
            if ($key1 == "campaigns") {
                foreach ($value1 as $key2 => $value2) {

                    if ($value2['campaign_id'] == $key) {
                        //echo $value2['daily_budget'];
                        $decoded[$key1][$key2]['daily_budget'] = $value;
                    }
                }
            }

            if ($key1 == "youtube") {
                foreach ($value1 as $key2 => $value2) {
                    if ($key2 == "campaigns") {
                        foreach ($value2 as $key3 => $value3) {

                            if ($value3['campaign_id'] == $key) {

                                $decoded[$key1][$key2][$key3]['daily_budget'] = $value;
                            }
                        }
                    }
                }
            }
        }
        //  }
    }
    $encodedString = json_encode($decoded, JSON_PRETTY_PRINT);
    file_put_contents($data_file, $encodedString);
}
