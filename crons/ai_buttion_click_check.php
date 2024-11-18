<?php

require_once dirname(__DIR__) . '/dashboard/config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $CronConfigs;

echo "<---------------------Cron Job Start----------------->";
echo "<br>";
$dealers     = DbConnect::get_connection_read()->query("SELECT dealership FROM dealerships WHERE (status='active' AND buttons_live = true) ORDER BY dealership;");
$dealerships = [];

while ($dealer = mysqli_fetch_assoc($dealers)) {
    $dealership = $dealer['dealership'];
    if (array_key_exists('buttons', $CronConfigs[$dealership])) {
        $dealerships[] = $dealership;
    }
}

foreach ($dealerships as $dealership) {
    if (!checkButtonViewedOrClickedInTwoDays($dealership)) {
        buttonViewReportEmail($dealership);
    }
}

echo "<---------------------Cron Job End----------------->";

function checkButtonViewedOrClickedInTwoDays($dealership)
{
    $buttonSummary = getButtonSummary($dealership);
    return ($buttonSummary['total_viewed'] > 0 || $buttonSummary['total_clicked'] > 0) ? true : false;
}

function getButtonSummary($dealership)
{
    $query = "SELECT `dealership`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup, SUM(`form_viewed`) AS total_form_viewed FROM `tbl_btn_comb_stat`"
        . " WHERE `dealership` = '$dealership'"
        . " AND (`combination`='baseline' OR `combination`='endline' )"
        . " AND (`date` BETWEEN DATE(NOW() - INTERVAL 2 DAY) AND DATE(NOW()));";

    $result = DbConnect::get_connection_read()->query($query);
    $data   = [];

    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data = $row;
        }
        mysqli_free_result($result);
    }

    return $data;
}

function buttonViewReportEmail($dealership)
{
    $msg = "<div style='font-size: 16px;'>
                Dear sir,<br>
                <br>
                AI Button might not be working properly for: <strong>$dealership</strong>. <br>
                Thank you.<br>

                <br>
                Best regards,<br>
                sMedia <br>
                <br>
                ______________________________<wbr>____________________<br>
                <a style='text-decoration: none; font-size: 16px; font-weight: bold; color: #007bff; '  href='https://smedia.ca' target='_blank' ><img src='https://smedia.ca/wp-content/themes/%40Smedia/images/logo.png'/></a>
                <div>";

    $from    = 'AI Button - sMedia <offers@smedia.ca>';
    $to      = ['tanvir@smedia.ca', 'support@smedia.ca'];
    $subject = "Check AI Button for $dealership";

    SendEmail($to, $from, $subject, $msg);
}