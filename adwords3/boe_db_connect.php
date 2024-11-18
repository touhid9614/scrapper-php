<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/tag_db_connect.php';

function debug_log($obj) {
    $str  = $obj ? print_r($obj, true): '';
    $file = 'my_debug_log.txt';
    file_put_contents($file, $str . "\n", FILE_APPEND | LOCK_EX);
}

function boedb_check_existing($dealership, $option, $user_id, $button_name, $option_group, $stock_type, $form, $dt_day) {
    $where_data = [
        'dealership'   => $dealership,
        'option1'      => $option,
        'button'       => $button_name,
        'option_group' => $option_group,
        'stock_type'   => $stock_type,
        'form'         => $form,
        'date'         => $dt_day
	];

    $prep_where = DbConnect::get_instance()->prepare_query_params($where_data, DbConnect::PREPARE_WHERE);
	$query      = "SELECT id FROM `tbl_btn_opt_ext` WHERE {$prep_where}";
	$result     = DbConnect::get_instance()->query($query);

    if ($result) {
		$row = mysqli_fetch_array($result);

        if ($row) {
			return $row;
		}
	}

    return false;
}

function boedb_record_increase_count($dealership, $option, $user_id, $button_name, $option_group, $stock_type, $form, $dt_day, $op = 'viewed') {
    $row = boedb_check_existing($dealership, $option, $user_id, $button_name, $option_group, $stock_type, $form, $dt_day);

	if ($row) {
        $id = $row['id'];
        $update_data = [
            'dealership'   => $dealership,
            'option1'      => $option,
            'option_group' => $option_group,
            'user_id'      => $user_id,
            'stock_type'   => $stock_type,
            'form'         => $form,
            'date'         => $dt_day
		];

        $prep_where  = DbConnect::get_instance()->prepare_query_params($update_data, DbConnect::PREPARE_EQUAL);
        $viewed 	 = ($op == 'viewed') ? ",viewed = viewed + 1" : ",viewed = viewed";
        $clicked 	 = ($op == 'clicked') ? ",clicked = clicked + 1" : ",clicked=clicked";
        $fillup 	 = ($op == 'fillup') ? ",fillup=fillup + 1" : ",fillup=fillup";
        $form_viewed = ($op == 'form_viewed') ? ",form_viewed=form_viewed + 1" : ",form_viewed=form_viewed";
        $query 		 = "UPDATE `tbl_btn_opt_ext` SET $prep_where $viewed $clicked $fillup $form_viewed  WHERE id = '$id'";
        DbConnect::get_instance()->query($query);
    } else {
        $insert_data = [
            'dealership'   => $dealership,
            'option1'      => $option,
            'button'       => $button_name,
            'option_group' => $option_group,
            'user_id'      => $user_id,
            'viewed'       => ($op == 'viewed') ? 1     : 0,
            'clicked'      => ($op == 'clicked') ? 1    : 0,
            'fillup'       => ($op == 'fillup') ? 1     : 0,
            'form_viewed'  => ($op == 'form_viewed') ? 1: 0,
            'stock_type'   => $stock_type,
            'form'         => $form,
            'date'         => $dt_day
		];

        $prep_insert = DbConnect::get_instance()->prepare_query_params($insert_data, DbConnect::PREPARE_PARENTHESES);
        $query 		 = "INSERT INTO `tbl_btn_opt_ext` $prep_insert";
        DbConnect::get_instance()->query($query);
    }
}

function get_query_result($query) {
	$result = tagdb_query($query);

    if (!$result) {
        return false;
	}

	$retval = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $retval[] = $row;
    }
    mysqli_free_result($result);
    return $retval;
}

function boedb_get_dealership_data($dealership, $dt_day, $days = 30) {
    $dt_start_date = date('Y-m-d', strtotime($dt_day) - ($days * 24 * 60 * 60));
    $query = "SELECT `button`, `option1`, `option_group`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup FROM `tbl_btn_opt_ext` "
            . "WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "' AND (`date` between '" . tagdb_real_escape_string($dt_start_date) . "' and '" . tagdb_real_escape_string($dt_day) . "') group by `option1`, `option_group`, `button`";

    //echo "\n//$query\n";

	$result = tagdb_query($query);

    if (!$result) {
        return false;
    }

	$retval = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $row['option1'] = trim($row['option1']);
        if (isset($retval[$row['button']][$row['option_group']][$row['option1']])) {
            $retval[$row['button']][$row['option_group']][$row['option1']]['viewed'] += $row['total_viewed'];
            $retval[$row['button']][$row['option_group']][$row['option1']]['clicked'] += $row['total_clicked'];
            $retval[$row['button']][$row['option_group']][$row['option1']]['fillup'] += $row['total_fillup'];
        } else {
            $retval[$row['button']][$row['option_group']][$row['option1']] = [
                'viewed' => $row['total_viewed'],
                'clicked' => $row['total_clicked'],
                'fillup' => $row['total_fillup']
            ];
        }
	}

    mysqli_free_result($result);
    return $retval;
}

function boedb_get_rows($dealership, $available_options, $button_name, $option_group, $stock_type, $dt_day, $count = 1000) {
    $options = implode("', '", $available_options);

	$query = "SELECT `dealership`, `option1`, `option_group`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup, `stock_type` FROM `tbl_btn_opt_ext` "
            . " WHERE"
            . " `option1` IN ('" . $options . "') "
            . " AND `dealership`='" . tagdb_real_escape_string($dealership) . "' "
            . " AND `button`='" . tagdb_real_escape_string($button_name) . "' "
            . " AND `option_group`='" . tagdb_real_escape_string($option_group) . "' "
            . " AND (`stock_type`='" . tagdb_real_escape_string($stock_type) . "' "
            . " OR `stock_type`='" . tagdb_real_escape_string('any') . "') "
            . " AND DATEDIFF('" . tagdb_real_escape_string($dt_day) . "', `date`) >= 0"
            . " AND DATEDIFF('" . tagdb_real_escape_string($dt_day) . "', `date`) <= 15"
            . " GROUP BY `option1` "
            . " LIMIT 0, " . $count . ";";

    $cache_directory = __DIR__ . "/caches/button-data/";
	$cache_file = $cache_directory . md5($query) . ".dat";

    if (($data = get_data_cache($cache_file, 6))) {
        return $data;
	}

	$result = tagdb_query($query);

    if (!$result) {
        return false;
	}

	$retval = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $retval[] = $row;
	}

    mysqli_free_result($result);
	store_data_cache($cache_file, $retval);

    return $retval;
}

// button optimization status page

function boedb_get_customers() {
    $query = "SELECT DISTINCT `dealership` FROM `tbl_btn_opt_ext` ORDER BY dealership ASC;";
	$result = tagdb_query($query);

    if (!$result) {
        return false;
	}

	$retval = [];

    while ($row = mysqli_fetch_array($result)) {
        $retval[] = $row[0];
	}

	mysqli_free_result($result);

    return $retval;
}

function boedb_get_options_data($dealership = '', $date_range, $start_date, $end_date) {
    $query = "SELECT `option1`, `option_group`, `stock_type`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup, SUM(`form_viewed`) AS total_form_viewed FROM `tbl_btn_opt_ext` ";

    if (empty($dealership)) {
        $cancel_dealerships = "('jump')";
        $query .= " WHERE dealership NOT IN $cancel_dealerships";
    } else {
        $query .= " WHERE dealership='" . tagdb_real_escape_string($dealership) . "' ";
    }

    $query .= ($date_range == 'all_time') ? "" : " AND `date` BETWEEN '" . tagdb_real_escape_string($start_date) . "' and '" . tagdb_real_escape_string($end_date) . "'";

    $query .= " GROUP BY `option1`, `option_group`, `stock_type` "
            . " ORDER BY `option_group`";
    return get_query_result($query);
}

function boedb_get_ui_data($sel_customer, $sel_rank_field, $sel_order, $stock_type, $sel_date_range, $dt_start, $dt_end) {
    if ($sel_customer == '') {
		return false;
	}

    $query = "SELECT `option1`, `option_group`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup FROM `tbl_btn_opt_ext` "
			. " WHERE dealership='" . tagdb_real_escape_string($sel_customer) . "' ";

    if ($stock_type != '') {
        $query .= " AND stock_type='" . tagdb_real_escape_string($stock_type) . "' ";
    }

    if ($sel_date_range != 'all_time') {
        $query .= " AND `date` BETWEEN '" . tagdb_real_escape_string($dt_start) . "' and '" . tagdb_real_escape_string($dt_end) . "'";
    }

    $query .= " GROUP BY `option1` "
            . " ORDER BY `option_group`, `" . tagdb_real_escape_string($sel_rank_field) . "` "
            . " " . tagdb_real_escape_string($sel_order) . " ;";

    return get_query_result($query);
}

function boedb_get_chart_main_data($sel_customer, $sel_date_range, $dt_start, $dt_end) {
    if ($sel_customer == '')
        return false;
    $query = "SELECT `date`, `option1`, `option_group`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup FROM `tbl_btn_opt_ext` "
            . " WHERE dealership='" . tagdb_real_escape_string($sel_customer) . "' ";

    if ($sel_date_range != 'all_time') {
        $query .= " AND `date` BETWEEN '" . tagdb_real_escape_string($dt_start) . "' and '" . tagdb_real_escape_string($dt_end) . "'";
    }

    $query .= " GROUP BY `option1`, `date` "
            . " ORDER BY `option_group`, `date`;";
    return get_query_result($query);
}

function boedb_clear_dealership($dealership) {
    $query = "UPDATE `tbl_btn_opt_ext` SET `viewed`=0, `clicked`=0 WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "';";
    tagdb_query($query);
}

function boedb_bs_check_existing($dealership) {
    $query = "SELECT * FROM `tbl_btn_status` "
            . " WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "';";
    $result = tagdb_query($query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        mysqli_free_result($result);
        if ($row)
            return $row;
    }
    return false;
}

function boedb_bs_get_status($dealership) {
    $row = boedb_bs_check_existing($dealership);
    return $row ? $row['status'] : false;
}

function boedb_bs_set_status($dealership, $status) {
    $row = boedb_bs_check_existing($dealership);
    if ($row) {
        $query = "UPDATE `tbl_btn_status` SET "
                . "`status` = '" . tagdb_real_escape_string($status) . "' "
                . "`launch_date` = NOW()"
                . " WHERE dealership = '" . tagdb_real_escape_string($dealership) . "';";
        tagdb_query($query);
    } else {
        $query = "INSERT INTO `tbl_btn_status`(`id`, `dealership`, `status`, `launch_date`) VALUES (NULL, '"
                . tagdb_real_escape_string($dealership) . "', '"
                . tagdb_real_escape_string($status) . "', "
                . "NOW());";
        tagdb_query($query);
    }
}

function boedb_bs_get_last_viewed($dealership) {
    $row = boedb_bs_check_existing($dealership);
    return $row ? $row['last_viewed'] : false;
}

function boedb_bs_set_last_viewed($dealership) {
    $row = boedb_bs_check_existing($dealership);
    if ($row) {
        $query = "UPDATE `tbl_btn_status` SET "
                . "`last_viewed` = NOW() "
                . " WHERE dealership = '" . tagdb_real_escape_string($dealership) . "';";
        tagdb_query($query);
    } else {
        $query = "INSERT INTO `tbl_btn_status`(`id`, `dealership`, `last_viewed`) VALUES (NULL, '"
                . tagdb_real_escape_string($dealership) . "', NOW());";
        tagdb_query($query);
    }
}

function boedb_bs_set_launch_date($dealership, $date) {
    $row = boedb_bs_check_existing($dealership);
    if ($row) {
        $query = "UPDATE `tbl_btn_status` SET "
                . "`launch_date` = '"
                . tagdb_real_escape_string($date) . "' "
                . " WHERE dealership = '" . tagdb_real_escape_string($dealership) . "';";
        tagdb_query($query);
    }
}

function boedb_bs_get_rows() {
    $query = "SELECT `dealership`, `last_viewed`, `status`, `launch_date` FROM `tbl_btn_status` ORDER BY `dealership`;";
    $result = tagdb_query($query);
    $retval = [];
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $retval[$row['dealership']] = array(
                'last_viewed' => $row['last_viewed'],
                'is_launched' => $row['status'],
                'launch_date' => $row['launch_date']
            );
        }
        mysqli_free_result($result);
    }
    return $retval;
}

/*
 * * tbl_btn_comb_stat table functions
 */
function boedb_tbcs_check_existing($dealership, $button, $combination, $stock_type, $form, $dt_day) {
    $query = "SELECT * FROM `tbl_btn_comb_stat` "
            . " WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "'"
            . " AND `button`='" . tagdb_real_escape_string($button) . "' "
            . " AND `combination`='" . tagdb_real_escape_string($combination) . "' "
            . " AND `stock_type`='" . tagdb_real_escape_string($stock_type) . "' "
            . " AND `form`='" . tagdb_real_escape_string($form) . "' "
            . " AND `date`='" . tagdb_real_escape_string($dt_day) . "';";


    $result = tagdb_query($query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        mysqli_free_result($result);
        if ($row)
            return $row;
    }
    return false;
}

// function boedb_tbcs_record_increase_count($dealership, $button, $combination, $stock_type, $dt_day, $op='clicked')
function boedb_tbcs_record_increase_count($dealership, $button, $combination, $stock_type, $form, $dt_day, $op = 'clicked') {
    $row = boedb_tbcs_check_existing($dealership, $button, $combination, $stock_type, $form, $dt_day);
    if ($row) {
        $id = $row['id'];
        $cond_viewed = ($op == 'viewed') ? ' viewed=viewed+1 ' : ' viewed=viewed ';
        $cond_clicked = ($op == 'clicked') ? ' clicked=clicked+1 ' : ' clicked=clicked ';
        $cond_fillup = ($op == 'fillup') ? ' fillup=fillup+1 ' : ' fillup=fillup ';
        $cond_form_viewed = ($op == 'form_viewed') ? ' form_viewed=form_viewed+1 ' : ' form_viewed=form_viewed ';

        $query = "UPDATE `tbl_btn_comb_stat` SET "
                . "`dealership` = '" . tagdb_real_escape_string($dealership) . "', "
                . "`button` = '" . tagdb_real_escape_string($button) . "', "
                . "`combination` = '" . tagdb_real_escape_string($combination) . "', "
                . $cond_viewed . ", "
                . $cond_clicked . ", "
                . $cond_fillup . ", "
                . $cond_form_viewed . ", "
                . "`stock_type` = '" . tagdb_real_escape_string($stock_type) . "', "
                . "`form` = '" . tagdb_real_escape_string($form) . "', "
                . "`date` = '" . tagdb_real_escape_string($dt_day) . "' "
                . " WHERE id = '" . tagdb_real_escape_string($id) . "';";
        tagdb_query($query);
    } else {
        $viewed = ($op == 'viewed') ? 1 : 0;
        $clicked = ($op == 'clicked') ? 1 : 0;
        $fillup = ($op == 'fillup') ? 1 : 0;
        $form_viewed = ($op == 'form_viewed') ? 1 : 0;

        $query = "INSERT INTO `tbl_btn_comb_stat` (`id`, `dealership`, `button`, `combination`, `clicked`, `viewed`, `fillup`,`form_viewed`, `stock_type`, `form`, `date`) VALUES (NULL, '"
                . tagdb_real_escape_string($dealership) . "', '"
                . tagdb_real_escape_string($button) . "', '"
                . tagdb_real_escape_string($combination) . "', '"
                . tagdb_real_escape_string($clicked) . "', '"
                . tagdb_real_escape_string($viewed) . "', '"
                . tagdb_real_escape_string($fillup) . "', '"
                . tagdb_real_escape_string($form_viewed) . "', '"
                . tagdb_real_escape_string($stock_type) . "', '"
                . tagdb_real_escape_string($form) . "', '"
                . tagdb_real_escape_string($dt_day) . "');";
        tagdb_query($query);
    }
}

// button optimization status page

function boedb_tbcs_get_stock_types() {
    $query = "SELECT DISTINCT(`stock_type`) FROM `tbl_btn_opt_ext`"
            . " WHERE `stock_type` <> '' "
            . " ORDER BY stock_type ASC;";

    $result = tagdb_query($query);
    $retval = [];
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $retval[] = $row['stock_type'];
        }
        mysqli_free_result($result);
    }
    return $retval;
}

function boedb_tbcs_clear_dealership($dealership) {
    $query = "UPDATE `tbl_btn_comb_stat` SET `viewed`=0, `clicked`=0 WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "';";
    tagdb_query($query);
}

function boedb_tbcs_get_rows($dealership, $stock_type, $sel_date_range, $dt_start, $dt_end) {

    $query = "SELECT `dealership`, `button`, `combination`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup,SUM(`form_viewed`) AS total_form_viewed FROM `tbl_btn_comb_stat`"
            . " WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "'";

    if ($stock_type != '') {
        $query .= " AND stock_type='" . tagdb_real_escape_string($stock_type) . "' ";
    }
    if ($sel_date_range == 'all_time') {

    } else {
        $query .= " AND `date` between '" . tagdb_real_escape_string($dt_start) . "' and '" . tagdb_real_escape_string($dt_end) . "'";
    }

    $query .= " GROUP BY button, combination;";
    $result = tagdb_query($query);

    $retval = [];
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $retval[] = $row;
        }
        mysqli_free_result($result);
    }

    return $retval;
}

function boedb_tbcs_get_ui_report($dealership, $stock_type, $sel_date_range, $dt_start, $dt_end) {
    $rows = boedb_tbcs_get_rows($dealership, $stock_type, $sel_date_range, $dt_start, $dt_end);
    $retval = [];
    foreach ($rows as $row) {

        if (!isset($retval[$row['button']])) {
            $retval[$row['button']]['baseline'] = 0;
            $retval[$row['button']]['baseline_view'] = 0;
            $retval[$row['button']]['baseline_clicks'] = 0;
            $retval[$row['button']]['baseline_fillups'] = 0;
            $retval[$row['button']]['baseline_cr1'] = 0;
            $retval[$row['button']]['baseline_cr2'] = 0;
            $retval[$row['button']]['endline'] = 0;
            $retval[$row['button']]['endline_view'] = 0;
            $retval[$row['button']]['endline_clicks'] = 0;
            $retval[$row['button']]['endline_fillups'] = 0;
            $retval[$row['button']]['endline_cr1'] = 0;
            $retval[$row['button']]['endline_cr2'] = 0;
        }

        if ($row['combination'] == 'baseline') {
            $retval[$row['button']]['baseline'] = $row['total_viewed'] ? round($row['total_clicked'] / ($row['total_viewed'] ? $row['total_viewed'] : 1), 4) * 100 : 0.00;
            $retval[$row['button']]['baseline_view'] = $row['total_viewed'];
            $retval[$row['button']]['baseline_clicks'] = $row['total_clicked'];
            $retval[$row['button']]['baseline_fillups'] = $row['total_fillup'];
            $retval[$row['button']]['baseline_cr1'] = $row['total_viewed'] ? round($row['total_clicked'] / ($row['total_viewed'] ? $row['total_viewed'] : 1), 4) * 100 : 0.00;
            $retval[$row['button']]['baseline_cr2'] = $row['total_form_viewed'] ? round($row['total_fillup'] / ($row['total_form_viewed'] ? $row['total_form_viewed'] : 1) , 4) * 100 : 0.00;
        } else if ($row['combination'] == 'endline') {
            $retval[$row['button']]['endline'] = $row['total_viewed'] ? round($row['total_clicked'] / ($row['total_viewed'] ? $row['total_viewed'] : 1), 4) * 100 : 0.00;
            $retval[$row['button']]['endline_view'] = $row['total_viewed'];
            $retval[$row['button']]['endline_clicks'] = $row['total_clicked'];
            $retval[$row['button']]['endline_fillups'] = $row['total_fillup'];
            $retval[$row['button']]['endline_cr1'] = $row['total_viewed'] ? round($row['total_clicked'] / ($row['total_viewed'] ? $row['total_viewed'] : 1), 4) * 100 : 0.00;
            $retval[$row['button']]['endline_cr2'] = $row['total_form_viewed'] ? round($row['total_fillup'] / ($row['total_form_viewed'] ? $row['total_form_viewed'] : 1), 4) * 100 : 0.00;
        }
    }
    return $retval;
}

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
}

function boedb_tbcs_get_page_data($dealership, $stock_type, $sel_date_range, $dt_start, $dt_end) {
    if ($sel_date_range == 'all_time') {
        $cond_date = '';
    } else {
        $cond_date = " AND `date` between '" . tagdb_real_escape_string($dt_start) . "' and  '" . tagdb_real_escape_string($dt_end) . "'";
    }

    if ($stock_type != '')
        $cond_stock = " AND stock_type='" . tagdb_real_escape_string($stock_type) . "' ";
    else
        $cond_stock = '';

    $page_data = array(
        'vdp' => array(
            'baseline' => array(
                'view' => 0,
                'fillup' => 0,
                'click' => 0,
                'form_viewed' => 0,
            ),
            'endline' => array(
                'view' => 0,
                'fillup' => 0,
                'click' => 0,
                'form_viewed' => 0,
            ),
        ),
        'srp' => array(
            'baseline' => array(
                'view' => 0,
                'fillup' => 0,
                'click' => 0,
                'form_viewed' => 0,
            ),
            'endline' => array(
                'view' => 0,
                'fillup' => 0,
                'click' => 0,
                'form_viewed' => 0,
            ),
        )
    );

    $arrPage = array('vdp', 'srp');
    $arrLine = array('baseline', 'endline');

    foreach ($arrPage as $page) {
        foreach ($arrLine as $line) {

            $click = 0;
            $fillup = 0;
            $view = 0;
            $total_form_viewed = 0;

            if ($page == 'vdp') {
                $cond_button = " AND `button` NOT LIKE 'Listing %' ";
            } else {
                $cond_button = " AND `button` LIKE 'Listing %' ";
            }

            $query = "SELECT `button`, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup "
                    . " FROM `tbl_btn_comb_stat` "
                    . " WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "'"
                    . " AND `combination`='" . tagdb_real_escape_string($line) . "'"
                    . $cond_button
                    . $cond_date
                    . $cond_stock;
            $result = tagdb_query($query);
            if ($result && ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) && $row['button'] != '') {
                mysqli_free_result($result);
                $click = $row['total_clicked'];
                $fillup = $row['total_fillup'];

                $query = "SELECT SUM(`viewed`) AS total_viewed, SUM(`form_viewed`) AS total_form_viewed "
                        . " FROM `tbl_btn_comb_stat` "
                        . " WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "'"
                        . " AND `combination`='" . tagdb_real_escape_string($line) . "'"
                        . " AND `button`='" . tagdb_real_escape_string($row['button']) . "'"
                        . $cond_button
                        . $cond_date
                        . $cond_stock;
                $result = tagdb_query($query);
                if ($result && ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))) {
                    mysqli_free_result($result);
                    $view = $row['total_viewed'];
                    $total_form_viewed = $row['total_form_viewed'];
                }
            }

            if ($view > 0) {
                $page_data[$page][$line]['click'] = round($click / $view, 4) * 100;
                $page_data[$page][$line]['fillup'] = round($fillup / $view, 4) * 100;
                $page_data[$page][$line]['view'] = $view;
                $page_data[$page][$line]['form_view'] = $total_form_viewed;
            }
        }
    }
    return $page_data;
}

function get_day_interval($dt_start, $dt_end) {
    $datetime1 = new DateTime($dt_start);
    $datetime2 = new DateTime($dt_end);
    $interval = $datetime1->diff($datetime2);
    $dayCount = ($interval->m * 30) + $interval->d;
    return $dayCount;
}

/**
 * Function to get data for button-details and button-overview page chart
 */
function boedb_get_chartdata($dt_start, $dt_end, $date_range = '', $page_type = '', $dealership = '') {
    if ($date_range == 'all_time') {
        $dt_start = date('Y-m-d', time() - (365 * 24 * 60 * 60));
        $dt_end = date('Y-m-d');
        $mindate_query = tagdb_query("SELECT min(date) as min_date FROM tbl_btn_comb_stat WHERE (date BETWEEN '$dt_start' AND '$dt_end')");
        $mindate_row = mysqli_fetch_assoc($mindate_query);
        if ($mindate_row['min_date']) {
            $dt_start = $mindate_row['min_date'];
        }
    }

    $dayCount = get_day_interval($dt_start, $dt_end);

    $combination_where = " WHERE combination IN ('baseline', 'endline')";
    $dealership_where = !empty($dealership) ? " AND `dealership`='" . tagdb_real_escape_string($dealership) . "' " : '';
    $date_where = " AND (`date` BETWEEN '$dt_start' AND '$dt_end')";
    $pagetype_where = ($page_type == 'vdp') ? " AND `button` NOT LIKE 'Listing %'" : (($page_type == 'srp') ? " AND `button` LIKE 'Listing %'" : '');

    $query = "SELECT date, `dealership`, `button`, `combination`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup, SUM(`form_viewed`) AS total_form_viewed "
            . " FROM `tbl_btn_comb_stat` " . $combination_where
            . "$pagetype_where  $dealership_where  $date_where GROUP BY combination, date";

    $result = tagdb_query($query);

    $result_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['combination'] == 'baseline') {
            $result_data[$row['date']]['baseline_viewed'] = $row['total_viewed'];
            $result_data[$row['date']]['baseline_cr1'] = $row['total_viewed'] ? round($row['total_clicked'] / $row['total_viewed'], 4) * 100 : 0;
            $result_data[$row['date']]['baseline_cr2'] = $row['total_form_viewed'] ? round($row['total_fillup'] / $row['total_form_viewed'], 4) * 100 : 0;
        } else {
            $result_data[$row['date']]['endline_viewed'] = $row['total_viewed'];
            $result_data[$row['date']]['endline_cr1'] = $row['total_viewed'] ? round($row['total_clicked'] / $row['total_viewed'], 4) * 100 : 0;
            $result_data[$row['date']]['endline_cr2'] = $row['total_form_viewed'] ? round($row['total_fillup'] / $row['total_form_viewed'], 4) * 100 : 0;
        }
    }

    $baselineViewed = [];
    $endlineViewed = [];
    $baselineCR1 = [];
    $endlineCR1 = [];
    $baselineCR2 = [];
    $endlineCR2 = [];

    for ($day = $dayCount; $day >= 0; $day--) {
        $cur_date = strtotime("-" . ($day) . " day", strtotime($dt_end));
        $label = date("m-d", $cur_date);
        $date_val = date("Y-m-d", $cur_date);

        $baselineViewed[$date_val] = array("label" => $label, "y" => isset($result_data[$date_val]['baseline_viewed']) ? $result_data[$date_val]['baseline_viewed'] : 0);
        $baselineCR1[$date_val] = array("label" => $label, "y" => isset($result_data[$date_val]['baseline_cr1']) ? $result_data[$date_val]['baseline_cr1'] : 0);
        $baselineCR2[$date_val] = array("label" => $label, "y" => isset($result_data[$date_val]['baseline_cr2']) ? $result_data[$date_val]['baseline_cr2'] : 0);
        $endlineViewed[$date_val] = array("label" => $label, "y" => isset($result_data[$date_val]['endline_viewed']) ? $result_data[$date_val]['endline_viewed'] : 0);
        $endlineCR1[$date_val] = array("label" => $label, "y" => isset($result_data[$date_val]['endline_cr1']) ? $result_data[$date_val]['endline_cr1'] : 0);
        $endlineCR2[$date_val] = array("label" => $label, "y" => isset($result_data[$date_val]['endline_cr2']) ? $result_data[$date_val]['endline_cr2'] : 0);
    }

    return array($baselineViewed,
        $endlineViewed,
        $baselineCR1,
        $endlineCR1,
        $baselineCR2,
        $endlineCR2);
}

function boedb_get_ui_overview_data() {
    $query = "SELECT `dealership`, `combination`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, SUM(`fillup`) AS total_fillup, SUM(`form_viewed`) AS total_form_viewed FROM `tbl_btn_comb_stat` "
            . " WHERE `combination`='baseline'"
            . " OR `combination`='endline'"
            . " GROUP BY dealership, combination"
            . " ORDER BY dealership ASC, combination ASC;";

    $result = tagdb_query($query);

    $data = [];
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $dealership = $row['dealership'];
            $total_viewed = $row['total_viewed'];
            $total_form_viewed = $row['total_form_viewed'];
            $total_clicked = $row['total_clicked'];
            $total_fillup = $row['total_fillup'];
            $combination = $row['combination'];


            // dealership, baseline_views, baseline_cr1, baseline_cr2, endline_views, endline_cr1, endline_cr2
            if (!isset($data[$dealership])) {
                $data[$dealership] = array(
                    "baseline_views" => 0,
                    "baseline_cr1" => 0,
                    "baseline_cr2" => 0,
                    "endline_views" => 0,
                    "endline_cr1" => 0,
                    "endline_cr2" => 0
                );
            }

            if ($combination == 'baseline') {
                $data[$dealership]['baseline_views'] = $total_viewed;
                $cr1 = $total_viewed > 0 ? $total_clicked / $total_viewed * 100 : 0;
                $data[$dealership]['baseline_cr1'] = $cr1;
                $cr2 = $total_form_viewed > 0 ? $total_fillup / $total_form_viewed * 100 : 0;
                $data[$dealership]['baseline_cr2'] = $cr2;
            } else if ($combination == 'endline') {
                $data[$dealership]['endline_views'] = $total_viewed;
                $cr1 = $total_viewed > 0 ? $total_clicked / $total_viewed * 100 : 0;
                $data[$dealership]['endline_cr1'] = $cr1;
                $cr2 = $total_form_viewed > 0 ? $total_fillup / $total_form_viewed * 100 : 0;
                $data[$dealership]['endline_cr2'] = $cr2;
            }
        }
        mysqli_free_result($result);
    }

    return $data;
}

/*
 * * Merge data from status to stat
 */

function boe_db_merge_opt_comb() {
    $query = "SELECT `dealership`, `option1`, SUM(`viewed`) AS total_viewed, SUM(`clicked`) AS total_clicked, `stock_type`, `date`
                FROM `tbl_btn_opt_ext`
                WHERE option1>0
                GROUP BY dealership, date
                ORDER BY `option_group`, `option1`  desc ;";

    $result = tagdb_query($query);
    if (!$result) {
        return false;
    }

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        //Array ( [id] => 2136 [dealership] => bridgesgm [option1] => 100 [user_id] => [viewed] => 1 [clicked] => 0 [option_group] => size [stock_type] => any [date] => 2018-01-02 )
        $dealership = $row['dealership'];
        $viewed = $row['total_viewed'];
        $clicked = $row['total_clicked'];
        $stock_type = $row['stock_type'];
        $date = $row['date'];

        $que_button = "SELECT DISTINCT(`button`) FROM `tbl_btn_comb_stat` WHERE `dealership`='"
                . tagdb_real_escape_string($dealership) . "'";
        $res_button = tagdb_query($que_button);
        if (!$res_button)
            continue;
        $row_button = mysqli_fetch_array($res_button, MYSQLI_ASSOC);
        if (!$row_button)
            continue;
        mysqli_free_result($res_button);
        $button = $row_button['button'];

        $que_insert = "INSERT INTO `tbl_btn_comb_stat`(`id`, `dealership`, `button`, `combination`, `viewed`, `clicked`, `stock_type`, `date`) VALUES (NULL, '"
                . tagdb_real_escape_string($dealership) . "', '"
                . tagdb_real_escape_string($button) . "', '"
                . tagdb_real_escape_string('endline') . "', '"
                . tagdb_real_escape_string($viewed) . "', '"
                . tagdb_real_escape_string($clicked) . "', '"
                . tagdb_real_escape_string($stock_type) . "', '"
                . tagdb_real_escape_string($date) . "');";

        tagdb_query($que_insert);
    }

    mysqli_free_result($result);
    return "ok";
}

function boedb_get_start_date($dealership) {
    $query = "SELECT `dealership`, `date` FROM `tbl_btn_comb_stat` "
            . " WHERE `dealership`='" . tagdb_real_escape_string($dealership) . "'"
            // . " AND combination='endline'"
            . " ORDER BY `date` ASC"
            . " LIMIT 1;";
    $result = tagdb_query($query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        mysqli_free_result($result);
        if ($row)
            return $row['date'];
    }

    return false;
}

function get_button_statistics_data($dealership, $start_date, $end_date) {
    $query_str = "SELECT title, stock_number, button_name, url, SUM(clicks) AS clicks, SUM(fillups) AS fillups FROM dealerships_button_tracker WHERE (day BETWEEN '$start_date' AND '$end_date') AND dealership='$dealership' GROUP BY stock_number, button_name";
    $result = tagdb_query($query_str);
    return $result;
}

function get_viewsdata_dealership($dt_start, $dt_end) {
    $query = "SELECT `dealership`, `combination`, SUM(`viewed`) AS total_viewed, SUM(clicked) AS clicks, SUM(fillup) AS fillups FROM `tbl_btn_comb_stat` ";
    if (!empty($dt_start) && !empty($dt_end)) {
        $query .= " WHERE (`date` BETWEEN '$dt_start' AND '$dt_end')";
    }
    $query .= " GROUP BY dealership, combination ORDER BY dealership;";
    $result = tagdb_query($query);

    $result_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dealership = $row['dealership'];
        if (!isset($result_data[$dealership])) {
            $result_data[$dealership] = [
                'baseline_view' => 0,
                'endline_view' => 0,
                'baseline_fillups' => 0,
                'endline_fillups' => 0,
                'baseline_clicks' => 0,
                'endline_clicks' => 0
            ];
        }

        if ($row['combination'] == 'baseline') {
            $result_data[$dealership]['baseline_view'] += $row['total_viewed'];
            $result_data[$dealership]['baseline_fillups'] += $row['fillups'];
            $result_data[$dealership]['baseline_clicks'] += $row['clicks'];
        }
        if ($row['combination'] == 'endline') {
            $result_data[$dealership]['endline_view'] += $row['total_viewed'];
            $result_data[$dealership]['endline_fillups'] += $row['fillups'];
            $result_data[$dealership]['endline_clicks'] += $row['clicks'];
        }
    }
    return $result_data;
}
