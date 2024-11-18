<?php

require_once dirname(__DIR__) . '/dashboard/config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $CronConfigs;

echo "<---------------------Cron Job Start----------------->";
echo "<br>";

$dealers     = DbConnect::get_connection_read()->query("SELECT dealership FROM dealerships WHERE status = 'active';");
$dealerships = [];

while ($dealer = mysqli_fetch_assoc($dealers)) {
    $dealership = $dealer['dealership'];

    if (array_key_exists('lead', $CronConfigs[$dealership])) {
        $lead_arr = $CronConfigs[$dealership]['lead'];

        if (isset($lead_arr['live']) && $lead_arr['live']) {
            $dealerships[] = $dealership;
        }
    }
}

foreach ($dealerships as $dealership) {
    $smartOfferShowedInLastTwoDays = smartOfferShowedInLastTwoDays($dealership);

    if (!smartOfferShowedInLastTwoDays($dealership)) {
        smartOfferViewReportEmail($dealership);
    }
}

echo "<---------------------Cron Job End----------------->";

function smartOfferShowedInLastTwoDays($dealership)
{
    $query  = "SELECT SUM(count) as total_viewed FROM smart_offer_customer_views WHERE dealership = '$dealership' " . "AND DATE(`last_shown`) BETWEEN DATE(NOW() - INTERVAL 2 DAY) AND DATE(NOW())";
    $result = DbConnect::get_connection_read()->query($query);
    $data   = [];

    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data = $row;
        }
        mysqli_free_result($result);
    }

    return $data['total_viewed'] > 0 ? true : false;
}

function smartOfferViewReportEmail($dealership)
{
    $msg = "<div style='font-size: 16px;'>
                Dear sir,<br>
                <br>
                Smart offer may not be working properly for: <b>$dealership</b>. <br>
                Thank you.<br>

                <br>
                Best regards,<br>
                sMedia <br>
                <br>
                ______________________________<wbr>____________________<br>
                <a style='text-decoration: none; font-size: 16px; font-weight: bold; color: #007bff; '  href='https://smedia.ca' target='_blank'><img src='https://smedia.ca/wp-content/themes/%40Smedia/images/logo.png'/></a>
                <div>";

    $from    = 'Smart Offer - sMedia <offers@smedia.ca>';
    $to      = ['tanvir@smedia.ca', 'support@smedia.ca'];
    $subject = "Check Smart Offer for $dealership";

    // SendEmail($to, $from, $subject, $msg);
}