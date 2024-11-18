<?php

require_once 'config.php';

global $db_config, $offers, $offers_checked, $connection;

if (!$connection) {
    if (!$connection = mysqli_connect($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name'])) {
        die("Database is required in this context. Failed to establish database connection. " . mysqli_connect_error());
    }
}

function reportdb_real_escape_string($escapestr)
{
    global $connection;
    return mysqli_real_escape_string($connection, $escapestr);
}

function reportdb_query($query)
{
    global $connection;
    return mysqli_query($connection, $query);
}

function reportdb_get_popup_urls()
{

    $query = "SELECT `trpu_id`, `trpu_url` FROM `tbl_report_popup_urls`;";

    $result = reportdb_query($query);

    if (!$result) {return false;}

    $retval = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $retval[] = $row['trpu_url'];
    }

    mysqli_free_result($result);

    return $retval;
}

///

function reportdb_store_adwords_session($profile_id, $smedia_id, $rows)
{
    foreach ($rows as $row) {
        if (reportdb_check_existing_session($smedia_id)) {
            $query = "UPDATE `tbl_report_session` SET"
            . "`trs_profileid` = '" . reportdb_real_escape_string($profile_id) . "', "
            . "`trs_ga_sessions` = '" . reportdb_real_escape_string($row[0]) . "', "
            . "`trs_ga_bounces` = '" . reportdb_real_escape_string($row[1]) . "', "
            . "`trs_ga_bounce_rate` = '" . reportdb_real_escape_string($row[2]) . "', "
            . "`trs_ga_session_duration` = '" . reportdb_real_escape_string($row[3]) . "', "
            . "`trs_ga_avg_session_duration` = '" . reportdb_real_escape_string($row[4]) . "', "
            . "`trs_ga_hits` = '" . reportdb_real_escape_string($row[5]) . "', "
            . "`trs_ga_pageviews` = '" . reportdb_real_escape_string($row[6]) . "', "
            . "`trs_ga_avg_time_on_page` = '" . reportdb_real_escape_string($row[7]) . "', "
            . "`trs_timestamp` = NOW() "
            . " WHERE trs_smediaid = '" . reportdb_real_escape_string($smedia_id) . "';";
            reportdb_query($query);

        } else {
            $query = "INSERT INTO `tbl_report_session`(`trs_id`, `trs_smediaid`, `trs_profileid`, `trs_ga_sessions`, `trs_ga_bounces`, `trs_ga_bounce_rate`, `trs_ga_session_duration`, `trs_ga_avg_session_duration`, `trs_ga_hits`, `trs_ga_pageviews`, `trs_ga_avg_time_on_page`, `trs_timestamp`) VALUES (NULL, '"
            . reportdb_real_escape_string($smedia_id) . "', '"
            . reportdb_real_escape_string($profile_id) . "', '"
            . reportdb_real_escape_string($row[0]) . "', '"
            . reportdb_real_escape_string($row[1]) . "', '"
            . reportdb_real_escape_string($row[2]) . "', '"
            . reportdb_real_escape_string($row[3]) . "', '"
            . reportdb_real_escape_string($row[4]) . "', '"
            . reportdb_real_escape_string($row[5]) . "', '"
            . reportdb_real_escape_string($row[6]) . "', '"
            . reportdb_real_escape_string($row[7]) . "', "
                . "NOW());";
            reportdb_query($query);
        }
    }
}

function reportdb_check_existing_session($smedia_id)
{
    $query = "SELECT * FROM `tbl_report_session` "
    . " WHERE trs_smediaid = '" . reportdb_real_escape_string($smedia_id) . "';";

    $result = reportdb_query($query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            return true;
        }

    }

    return false;
}

////

function reportdb_store_adwords_event_tracking($profile_id, $smedia_id, $rows)
{
    foreach ($rows as $row) {
        if (reportdb_check_existing_event_tracking($smedia_id)) {

            $query = "UPDATE `tbl_report_event_tracking` SET"
            . "`tret_profileid` = '" . reportdb_real_escape_string($profile_id) . "', "
            . "`tret_ga_total_events` = '" . reportdb_real_escape_string($row[0]) . "', "
            . "`tret_ga_unique_events` = '" . reportdb_real_escape_string($row[1]) . "', "
            . "`tret_ga_event_value` = '" . reportdb_real_escape_string($row[2]) . "', "
            . "`tret_ga_avg_event_value` = '" . reportdb_real_escape_string($row[3]) . "', "
            . "`tret_ga_sessions_with_event` = '" . reportdb_real_escape_string($row[4]) . "', "
            . "`tret_ga_events_per_session_with_event` = '" . reportdb_real_escape_string($row[5]) . "', "
            . "`tret_timestamp` = NOW() "
            . " WHERE tret_smediaid = '" . reportdb_real_escape_string($smedia_id) . "';";
            reportdb_query($query);

        } else {

            $query = "INSERT INTO `tbl_report_event_tracking`(`tret_id`, `tret_smediaid`, `tret_profileid`, `tret_ga_total_events`, `tret_ga_unique_events`, `tret_ga_event_value`, `tret_ga_avg_event_value`, `tret_ga_sessions_with_event`, `tret_ga_events_per_session_with_event`, `tret_timestamp`) VALUES (NULL, '"
            . reportdb_real_escape_string($smedia_id) . "', '"
            . reportdb_real_escape_string($profile_id) . "', '"
            . reportdb_real_escape_string($row[0]) . "', '"
            . reportdb_real_escape_string($row[1]) . "', '"
            . reportdb_real_escape_string($row[2]) . "', '"
            . reportdb_real_escape_string($row[3]) . "', '"
            . reportdb_real_escape_string($row[4]) . "', '"
            . reportdb_real_escape_string($row[5]) . "', "
                . "NOW());";
            reportdb_query($query);
        }
    }
}

function reportdb_check_existing_event_tracking($smedia_id)
{
    $query = "SELECT * FROM `tbl_report_event_tracking` "
    . " WHERE tret_smediaid = '" . reportdb_real_escape_string($smedia_id) . "';";

    $result = reportdb_query($query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            return true;
        }

    }

    return false;
}
