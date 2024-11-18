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

use Predis\Client as RedisClient;

if (!$redis) {
    $redis = new RedisClient($redis_config);
}

$db_connect  = new DbConnect('');
$query       = "SELECT dealership, websites, company_name, tag_status, status, assigned_to FROM dealerships WHERE tag_needed = 'yes' AND status IN ('active', 'trial');";
$res         = $db_connect->query($query);
$dealer_data = [];

while ($row = mysqli_fetch_assoc($res)) {
    $dealer_data[$row['dealership']] = [
        'tag_status'   => $row['tag_status'],
        'websites'     => $row['websites'],
        'status'       => $row['status'],
        'assigned_to'  => $row['assigned_to'],
        'company_name' => $row['company_name'],
    ];
}

$now_time         = time();
$report           = [];
$update_db        = [];
$weekly_mail_list = [];
$email_issued     = [];
$email_issued_key = 'TICKET_HAS_BEEN_ISSUED_RECENTLY_ALREADY';
$email_issued_val = $redis->get($email_issued_key);

if ($email_issued_val) {
    $email_issued = unserialize($email_issued_val);

    // Remove the entries older than 15 days
    $fifteen_days = 15 * 24 * 60 * 60;

    foreach ($email_issued as $key => $value) {
        if (($now_time - $key) > $fifteen_days) {
            unset($email_issued[$key]);
        }
    }
}

foreach ($dealer_data as $cron_name => $cron_info) {
    $tag_loaded      = null;
    $tag_text        = 'not_installed';
    $severity        = 'MEDIUM';
    $tag_flag        = true;
    $cron_tag_status = $cron_info['tag_status'];
    $tag_state_key   = 'tag_state_' . $cron_name . '_any';
    $tag_last_loaded = (int) ($redis->get($tag_state_key));

    if ($tag_last_loaded) {
        $tag_loaded = time() - $tag_last_loaded;

        if ($tag_loaded <= 6 * 3600) {
            $tag_text = 'working';
            $tag_flag = false;
        } else if ($tag_loaded < 24 * 3600) {
            $tag_text = 'warning';
        }

        if ($tag_loaded > 72 * 3600) {
            $severity = 'IMPORTANT';
        }
    }

    if ($tag_flag && ($tag_text != $cron_tag_status) && !in_array($cron_name, $email_issued)) {
        $report[$cron_name] = [
            'tag_text'       => $tag_text,
            'last_worked_at' => date('D, d-M-Y H:i:s', $tag_last_loaded),
        ];
    }

    if ($tag_text != $cron_tag_status) {
        $update_db[$cron_name] = $tag_text;
    }
}

foreach ($update_db as $cron_name => $curr_tag_state) {
    $db_connect->query("UPDATE dealerships SET tag_status = '{$curr_tag_state}' WHERE dealership = '{$cron_name}';");
}

$tag_manual = "https://smedia-ca.atlassian.net/wiki/spaces/PD/pages/913506396/How+to+check+sMedia+tag";
$tag_instal = "https://smedia-ca.atlassian.net/wiki/spaces/PD/pages/940572673/How+to+Install+sMedia+Tag";

foreach ($report as $cron_name => $cron_report) {
    $details_page  = "https://tools.smedia.ca/dashboard/details.php?dealership={$cron_name}";
    $tag_page      = "https://tools.smedia.ca/dashboard/tag.php?dealership={$cron_name}";
    $company_name  = ucwords($dealer_data[$cron_name]['company_name']);
    $tag_text      = ucwords(str_replace("_", " ", $cron_report['tag_text']));
    $website       = $dealer_data[$cron_name]['websites'];
    $tag_color     = ($tag_text == 'Warning') ? '#FFD633' : '#F61D07';
    $tag_hour      = ($tag_text == 'Warning') ? 6 : 24;
    $dealer_status = strtoupper($dealer_data[$cron_name]['status']);
    $now_time      = date('D, d-M-Y H:i:s', time());
    $cap_cron      = strtoupper($cron_name);

    if ($dealer_status == 'ACTIVE') {
        $weekly_mail_list[$cron_name] = $now_time;
    }

    $email_text = <<<EMAIL
    Severity: {$severity}<br>**********<br>
    <br>
    <strong>Client:</strong><br>
    <i><strong>{$company_name}: </strong></i><span style="color:blue"><i>{$details_page}</i></span><br>
    <i><strong>Tag Page: </strong></i><span style="color:blue"><i>{$tag_page}</i></span><br>
    <strong>Dealership: <i>{$cap_cron}</i></strong><br>
    Website: <span style="color:blue"><i>{$website}</i></span></a><br>
    sMedia Account Representative: <i>{$dealer_data[$cron_name]['assigned_to']}</i><br>
    Dealer Status: <strong>{$dealer_status}</strong><br>
    Email Generated At: {$now_time}<br>
    <br>
    <strong>Support Request:</strong><br>
    sMedia tag is not performing as expected for at least {$tag_hour} hours for this dealership.
    Please check the following instructions on how to check if the tag is available in the website
    and also how to install sMedia tag in website.<br><br>
    How to check sMedia tag: <span style="color:blue"><i>{$tag_manual}</i></span><br>
    How to install sMedia Tag: <span style="color:blue"><i>{$tag_instal}</i></span><br><br>
    Tag Status: <span style="color:{$tag_color}">{$tag_text}</span><br>
    Last Worked At: <strong>{$cron_report['last_worked_at']}</strong> time.
EMAIL;

    $email_subject = "Tag Missing: {$company_name}";
    $from          = "support@smedia.ca";
    $active_to     = ['tanvir@smedia.ca', 'support@smedia.ca', 'zaber.mahbub@smedia.ca'];
    $trial_to      = [];

    if ($tag_text != 'Warning') {
        if ($dealer_status == 'ACTIVE') {
            SendEmail($active_to, $from, $email_subject, $email_text);
            $email_issued[$now_time] = $cron_name;
        } else {
            // SendEmail($trial_to, $from, $email_subject, $email_text);
        }
    }
}

$weekly_mail_redis_data = [];
$weekly_mail_redis_key  = 'ACTIVE_DEALER_TAG_FAIL_WEEKLY_REPORT';
$weekly_mail_redis_data = $redis->get($weekly_mail_redis_key);

if ($weekly_mail_redis_data) {
    $weekly_mail_redis_data = unserialize($weekly_mail_redis_data);
}

$weekly_mail_redis_data = array_merge($weekly_mail_redis_data, $weekly_mail_list);
$redis->set($weekly_mail_redis_key, serialize($weekly_mail_redis_data));
$redis->expire($weekly_mail_redis_key, 8 * 24 * 60 * 60); // Keep data for 8 days