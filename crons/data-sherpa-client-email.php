<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

global $redis, $redis_config;

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/db-config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/utils.php";

// GET DS CLIENTS
$sp_con_url = "https://api.smedia.ca/v1/dealership/ds-client-list/";
$cookie = '';
$content_type = 'application/x-www-form-urlencoded';
$additional_headers = [
    'masterToken' => '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b'
];
$sp_con_res = HttpGet($sp_con_url, false, false, $cookie, $cookie, $content_type, $additional_headers);
if ($sp_con_res) {
    $json_resp = json_decode($sp_con_res, true);
    $ds_list = $json_resp['data'];
}

foreach ($ds_list as $cronName => $cronData) {
	generateDataSherpaVinAlert($cronName, $cronData["dealershipId"], $cronData["name"], $cronData["domain"], $cronData["customerType"]);
}

function generateDataSherpaVinAlert($cronName, $dealershipId, $dealerName, $domain, $customerType) {
    // check db
    $my_db_connect = new DbConnect($cronName);
    $ds_query = "SELECT url, stock_number, vin FROM {$cronName}_scrapped_data WHERE deleted = 0 AND ((vin = '' OR vin IS NULL OR LENGTH(vin) != 17) OR (stock_number = '' OR stock_number IS NULL OR LENGTH(stock_number) = 32));";
    $fetch_ds = $my_db_connect->query($ds_query);
    $car_list = [];

    while ($row = mysqli_fetch_assoc($fetch_ds)) {
        $car_list[$row['url']] = [
            'vin'          => $row['vin'],
            'stock_number' => $row['stock_number'],
        ];
    }

    // send email
    $cdash_page   = "https://dashboard.smedia.ca/dealerships/{$dealershipId}";
    $details_page = "https://tools.smedia.ca/dashboard/details.php?dealership={$cronName}";
    $company_name = ucwords($dealerName);
    $now_time     = date('D, d-M-Y H:i:s', time());
    $cap_cron     = strtoupper($cronName);

    if (count($car_list) > 0) {
        $tbody = '';

        foreach ($car_list as $car_url => $car_attr) {
            $tbody .= "<tr>
            	<td style=\"border: 1px solid #ddd; width: 25%\"> {$car_url} </td>
            	<td style=\"border: 1px solid #ddd; width: 25%\"> {$car_attr['vin']} </td>
            	<td style=\"border: 1px solid #ddd; width: 25%\"> {$car_attr['stock_number']} </td>
            </tr>";
        }


        $email_text = <<<EMAIL
        <html>
        <strong>Client:</strong><br>
        <i><strong>{$company_name}: </strong></i><span style="color:blue"><i>{$cdash_page}</i></span><br>
        <i><strong>Old Dashboard: </strong></i><span style="color:blue"><i>{$details_page}</i></span><br>
        Dealership: <strong><i>{$cap_cron}</i></strong><br>
        Website: <span style="color:blue"><i>{$domain}</i></span></a><br>
        Customer Type: <strong><i>{$customerType}</i></strong><br>
        Email Generated At: {$now_time}<br>
        <br>
        <strong>Vin Missing:</strong><br>
        The following vehicles doesn't have proper VIN or STOCK NUMBER.

        <table style="border:1px solid #333; font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; text-align: left; background-color: #04AA6D; color: white; width: 25%"> URL </th>
                    <th style="border: 1px solid #ddd; text-align: left; background-color: #04AA6D; color: white; width: 25%"> VIN </th>
                    <th style="border: 1px solid #ddd; text-align: left; background-color: #04AA6D; color: white; width: 25%"> Stock Number </th>
                </tr>
            </thead>
            <tbody>
                {$tbody}
            </tbody>
        </table>
        <html>
EMAIL;

        $email_subject = "Vin/Stk Missing for DS Client : {$company_name}";
        $from          = "support@smedia.ca";
        $active_to     = ['toufiq@smedia.ca', 'jarrett@smedia.ca'];

        SendEmail($active_to, $from, $email_subject, $email_text);
    }
}