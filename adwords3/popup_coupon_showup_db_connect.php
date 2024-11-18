<?php

require_once('config.php');

global $db_config, $offers, $offers_checked, $connection;

if(!$connection) {
    if (!$connection = mysqli_connect($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name'])) {
        die("Database is required in this context. Failed to establish database connection. " . mysqli_connect_error());
    }
}

function pcsdb_real_escape_string($escapestr) {
    global $connection;
    return mysqli_real_escape_string($connection, $escapestr);
}

function pcsdb_query($query) {
    global $connection;
    return mysqli_query($connection, $query);
}

///
function pcsdb_store_record($smedia_id, $url, $car, $last_shown, $from_retargetting)
{
    foreach ($rows as $row) {
        if (pcsdb_check_existing($smedia_id)) {

            $query = "UPDATE `tbl_popup_coupon_showup` SET "
                . "`tpcs_url` = '" . pcsdb_real_escape_string($url) . "', "
                . "`tpcs_car` = '" . pcsdb_real_escape_string($car) . "', "
                . "`tpcs_last_shown` = '" . pcsdb_real_escape_string($last_shown) . "', "
                . "`tpcs_from_retargetting` = '" . pcsdb_real_escape_string($from_retargetting) . "', "
                // . "`tpcs_delay` = '" . pcsdb_real_escape_string($tpcs_delay) . "', "
                // . "`tpcs_fillup` = '" . pcsdb_real_escape_string($tpcs_fillup) . "', "
                . "`tpcs_timestamp` = NOW() "
                . " WHERE tpcs_smediaid = '" . pcsdb_real_escape_string($smedia_id) . "';";
            
            pcsdb_query($query);
            
        } else {
            $query = "INSERT INTO `tbl_popup_coupon_showup`(`tpcs_id`, `tpcs_smediaid`, `tpcs_url`, `tpcs_car`, `tpcs_last_shown`, `tpcs_from_retargetting`, `tpcs_delay`, `tpcs_fillup`, `tpcs_timestamp`) VALUES (NULL, '"
                . pcsdb_real_escape_string($smedia_id) . "', '"
                . pcsdb_real_escape_string($url) . "', '"
                . pcsdb_real_escape_string($car) . "', '"
                . pcsdb_real_escape_string($last_shown) . "', '"
                . pcsdb_real_escape_string($tpcs_from_retargetting) . "', '"
                . pcsdb_real_escape_string(30) . "', '"
                . pcsdb_real_escape_string(false) . "', "
                . "NOW());";
            pcsdb_query($query);
        }
    }
}

function pcsdb_check_existing($smedia_id) {
    $query = "SELECT * FROM `tbl_popup_coupon_showup` "
            . " WHERE tpcs_smediaid = '" . pcsdb_real_escape_string($smedia_id) . "';";

    $result = pcsdb_query($query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row) 
            return true;
    }
    
    return false;
}

function pcsdb_set_fillup($smedia_id) {
    $query = "UPDATE `tbl_popup_coupon_showup` SET "
        . "`tpcs_fillup` = '" . pcsdb_real_escape_string(true) . "', "
        . "`tpcs_timestamp` = NOW() "
        . " WHERE tpcs_smediaid = '" . pcsdb_real_escape_string($smedia_id) . "';";
    
    pcsdb_query($query);
}

function pcs_report_data_for_train($count=10000)
{
    $query = "SELECT * FROM `tbl_popup_coupon_showup` LEFT JOIN `tbl_report_session` ON trs_smediaid = tpcs_smediaid LEFT JOIN tbl_report_event_tracking ON tpcs_smediaid = tret_smediaid ORDER BY tpcs_timestamp DESC"
        . " LIMIT 0, " . $count . ";";
    
    $result = pcsdb_query($query);
    
    if(!$result) { return false; }
    
    $retval = [];
    
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $retval[] = $row;
    }
    
    mysqli_free_result($result);
    
    return $retval;
}
