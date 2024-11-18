<?php

/**
 * Gets the summary.
 *
 * @param      <type>  $CurrentConfig  The current configuration
 * @param      <type>  $cron_config    The cron configuration
 * @param      <type>  $cron_name      The cron name
 *
 * @return     array   The summary.
 */
function get_summary($CurrentConfig, $cron_config, $cron_name)
{
    global $developer_token;

    $service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);
    $on15    = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $during  = '';

    if ($on15) {
        $day = date('j');

        if ($day > 15) {
            $to     = time() + (86400);
            $during = date('Ym') . '16,' . date('Ymd', $to);
        } else {
            $to = time() + (86400);

            $month = date('n') - 1 == 0 ? 12 : date('n') - 1;
            $year  = $month == 12 ? date('Y') - 1 : date('Y');

            $from = mktime(0, 0, 0, $month, 16, $year);

            $during = date('Ymd', $from) . ',' . date('Ymd', $to);
        }
    } else {
        $to     = time() + (86400);
        $during = date('Ym') . '01,' . date('Ymd', $to);
    }

    $report = $service->GetRangedReport($during);

    $calced = report2cic($cron_name, $report);

    $cost        = $calced['cost'];
    $impressions = $calced['impressions'];
    $clicks      = $calced['clicks'];

    $ctr = $impressions > 0 ? ($clicks / $impressions) * 100 : 0;

    $budget = isset($cron_config['max_cost']) && $cron_config['max_cost'] ? ($cost / ($cron_config['max_cost'])) * 100 : 0;

    $budget_modifier = isset($cron_config['budget_modifier']) ? $cron_config['budget_modifier'] : 1;

    $result = array(
        'impression' => $impressions,
        'clicks'     => $clicks,
        'ctr'        => number_format($ctr, 2, '.', ','),
        'budget'     => round($budget, 2),
        'cost'       => number_format(($cost * $budget_modifier), 2, '.', ','),
    );

    return $result;
}

/**
 * Gets the monthly.
 *
 * @param      <type>  $CurrentConfig  The current configuration
 * @param      <type>  $cron_config    The cron configuration
 * @param      <type>  $cron_name      The cron name
 * @param      <type>  $mutex          The mutex
 *
 * @return     array   The monthly.
 */
function get_monthly($CurrentConfig, $cron_config, $cron_name, $mutex)
{
    $on15 = isset($cron_config['on15']) ? $cron_config['on15'] : false;

    $cday   = date('j');
    $cmonth = date('n');
    $cyear  = date('Y');

    $for_days = intval($cday);

    if ($on15) {
        if ($cday > 15) {
            $for_days = $cday - 15;
        } else {
            $lmonth   = $cmonth - 1 == 0 ? 12 : $cmonth - 1;
            $lyear    = $cmonth - 1 == 0 ? $cyear - 1 : $cyear;
            $for_days = (cal_days_in_month(CAL_GREGORIAN, $lmonth, $lyear) - 15) + $cday;
        }
    }

    $result = array();

    for ($i = 1; $i <= $for_days; $i++) {
        $is_current = false;

        if ($i == $for_days) {
            $is_current = true;
        }

        $from_time = time() - (86400 * ($for_days - $i));
        $to_time   = time() - (86400 * ($for_days - ($i + 1)));
        $during    = date('Ymd', $from_time) . ',' . date('Ymd', $to_time);

        $report = get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], $during, $is_current, $mutex);

        $calced = report2cic($cron_name, $report);

        $impressions = $calced['impressions'];
        $clicks      = $calced['clicks'];

        $ctr = $impressions > 0 ? ($clicks / $impressions) * 100 : 0;

        $day = date('M, d', $from_time);

        $result[$day] = array(
            'clicks'      => $clicks,
            'impressiosn' => $impressions,
            'ctr'         => round($ctr, 2),
        );
    }

    return $result;
}

/**
 * Gets the yearly.
 *
 * @param      <type>  $CurrentConfig  The current configuration
 * @param      <type>  $cron_config    The cron configuration
 * @param      <type>  $cron_name      The cron name
 * @param      <type>  $mutex          The mutex
 *
 * @return     array   The yearly.
 */
function get_yearly($CurrentConfig, $cron_config, $cron_name, $mutex)
{
    $result = array();

    for ($i = 0; $i < 12; $i++) {
        $this_month = date('n');
        $this_year  = date('Y');

        $month = $this_month - (11 - $i);
        $year  = $month < 1 ? $this_year - 1 : $this_year;

        if ($month < 1) {
            $month = 12 + $month;
        }

        $during = $year . str_pad($month, 2, '0', STR_PAD_LEFT) . '01,';

        $is_current = false;

        if ($month == $this_month) {
            $during .= date('Ymd');
            $is_current = true;
        } else {
            $to_month = $month + 1;
            $to_year  = $to_month > 12 ? $year + 1 : $year;

            if ($to_month > 12) {
                $to_month -= 12;
            }

            $during .= $to_year . str_pad($to_month, 2, '0', STR_PAD_LEFT) . '01';
        }

        $report = get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], $during, $is_current, $mutex);

        $calced = report2cic($cron_name, $report);

        $impressions = $calced['impressions'];
        $clicks      = $calced['clicks'];

        $ctr = $impressions > 0 ? ($clicks / $impressions) * 100 : 0;

        $time = mktime(0, 0, 0, $month, 1, $year);

        $m = date('M, y', $time);

        $result[$m] = array(
            'clicks'      => $clicks,
            'impressiosn' => $impressions,
            'ctr'         => round($ctr, 2),
        );
    }

    return $result;
}

/**
 * Reports a 2 cic.
 *
 * @param      string  $cron_name  The cron name
 * @param      <type>  $report     The report
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function report2cic($cron_name, $report)
{
    $cost                = 0;
    $impressions         = 0;
    $clicks              = 0;
    $youtube_cost        = 0;
    $youtube_impressions = 0;
    $youtube_clicks      = 0;

    $total             = array();
    $campaigns         = array();
    $youtube_campaigns = array();

    for ($i = 0; $i < count($report); $i++) {
        if ($report[$i]['Campaign ID'] == 'Total') {
            $total = array(
                'cost'        => round(intval($report[$i]['Cost']) / 1000000, 2),
                'impressions' => intval($report[$i]['Impressions']),
                'clicks'      => intval($report[$i]['Clicks']),
            );
            continue;
        }

        if (stripos($report[$i]['Campaign'], 'youtube') !== false) {
            $youtube_cost += intval($report[$i]['Cost']);
            $youtube_impressions += intval($report[$i]['Impressions']);
            $youtube_clicks += intval($report[$i]['Clicks']);

            $youtube_campaigns[$report[$i]['Campaign']] = array(
                'campaign_id'  => $report[$i]['Campaign ID'],
                'cost'         => round(intval($report[$i]['Cost']) / 1000000, 2),
                'impressions'  => intval($report[$i]['Impressions']),
                'clicks'       => intval($report[$i]['Clicks']),
                'daily_budget' => round(intval($report[$i]['Budget']) / 1000000, 2),
                'budget_id'    => $report[$i]['Budget ID'],
            );
        } elseif (stripos($report[$i]['Campaign'], $cron_name . '_') === 0 ||
            stripos($report[$i]['Campaign'], 'smedia_' . $cron_name . '_') === 0) {
            $cost += intval($report[$i]['Cost']);
            $impressions += intval($report[$i]['Impressions']);
            $clicks += intval($report[$i]['Clicks']);

            $campaigns[$report[$i]['Campaign']] = array(
                'campaign_id'  => $report[$i]['Campaign ID'],
                'cost'         => round(intval($report[$i]['Cost']) / 1000000, 2),
                'impressions'  => intval($report[$i]['Impressions']),
                'clicks'       => intval($report[$i]['Clicks']),
                'daily_budget' => round(intval($report[$i]['Budget']) / 1000000, 2),
                'budget_id'    => $report[$i]['Budget ID'],
            );
        }
    }

    return array(
        'cost'                => round($cost / 1000000, 2),
        'impressions'         => $impressions,
        'clicks'              => $clicks,
        'campaigns'           => $campaigns,
        'youtube_cost'        => round($youtube_cost / 1000000, 2),
        'youtube_impressions' => $youtube_impressions,
        'youtube_clicks'      => $youtube_clicks,
        'youtube_campaigns'   => $youtube_campaigns,
        'total'               => $total,
    );
}

/**
 * Gets the ranged report.
 *
 * @param      <type>                    $CurrentConfig  The current configuration
 * @param      string                    $cron_name      The cron name
 * @param      <type>                    $customer_id    The customer identifier
 * @param      <type>                    $during         During
 * @param      boolean                   $is_current     Indicates if current
 * @param      <type>                    $mutex          The mutex
 *
 * @return     AdwordsService|DbConnect  The ranged report.
 */
function get_ranged_report($CurrentConfig, $cron_name, $customer_id, $during, $is_current, $mutex)
{
    global $developer_token, $connection;

    $service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $customer_id);

    $db_connect = new DbConnect($cron_name);

    $meta_name = 'report_cache';
    $meta_key  = $cron_name . '_' . $during;

    $db_connect->create_meta_table($meta_name);

    if (!$is_current) {
        $report = $db_connect->get_meta($meta_name, $meta_key);

        if (is_null($report)) {
            $report = $service->GetRangedReport($during);
            $db_connect->update_meta($meta_name, $meta_key, $report);
        }

        return $report;
    } else {
        $cache_name = md5("report_cache_{$cron_name}_{$during}_v1");

        $report = get_object_cache($cache_name, 0.008);

        if (!$report) {
            $report = $service->GetRangedReport($during);
            store_object_cache($cache_name, $report);
        }

        return $report;
    }
}

/**
 * Saves a scrubber.
 *
 * @param      <type>  $mutex  The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function save_scrubber($mutex)
{
    global $user;

    $id              = isset($_POST['id']) ? $_POST['id'] : null;
    $job_title       = isset($_POST['job_title']) ? $_POST['job_title'] : '';
    $contact_name    = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
    $email           = isset($_POST['email']) ? $_POST['email'] : '';
    $phone           = isset($_POST['phone']) ? $_POST['phone'] : null;
    $website         = isset($_POST['website']) ? $_POST['website'] : null;
    $dealership_name = isset($_POST['dealership_name']) ? $_POST['dealership_name'] : null;
    $status          = isset($_POST['status']) ? $_POST['status'] : null;

    if (!$phone || !$website || !$dealership_name || !$status) {
        return array(
            'error' => array(
                'code'    => 400,
                'message' => 'Unable to save, All fields are required'
            )
        );
    }

    $dealership = $id ? array('id' => $id) : array('created_by' => $user['id']);

    $dealership['job_title']       = $job_title;
    $dealership['contact_name']    = $contact_name;
    $dealership['email']           = $email;
    $dealership['phone']           = $phone;
    $dealership['website']         = $website;
    $dealership['dealership_name'] = $dealership_name;
    $dealership['status']          = $status;

    global $connection;

    $db_connect = new DbConnect('');
    $sid = $db_connect->store_dealership($dealership);

    return $db_connect->get_dealership_by_id($sid);
}

/**
 * Saves a closer.
 *
 * @param      <type>  $mutex  The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function save_closer($mutex)
{
    global $user, $connection;

    $id                 = isset($_POST['id']) ? $_POST['id'] : null;
    $job_title          = isset($_POST['job_title']) ? $_POST['job_title'] : '';
    $contact_name       = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
    $email              = isset($_POST['email']) ? $_POST['email'] : '';
    $phone              = isset($_POST['phone']) ? $_POST['phone'] : null;
    $website            = isset($_POST['website']) ? $_POST['website'] : null;
    $dealership_name    = isset($_POST['dealership_name']) ? $_POST['dealership_name'] : null;
    $dealership_id      = isset($_POST['dealership_id']) ? $_POST['dealership_id'] : null;
    $status             = isset($_POST['status']) ? $_POST['status'] : 'Open';
    $accountid          = isset($_POST['accountid']) ? $_POST['accountid'] : null;
    $geographic_targets = isset($_POST['geographic_targets']) ? $_POST['geographic_targets'] : '';
    $promotions         = isset($_POST['promotions']) ? $_POST['promotions'] : '';
    $new_campaigns      = isset($_POST['new_campaigns']) && $_POST['new_campaigns'] == 'true' ? 1 : 0;
    $used_campaigns     = isset($_POST['used_campaigns']) && $_POST['used_campaigns'] == 'true' ? 1 : 0;
    $start_type         = isset($_POST['start_type']) ? $_POST['start_type'] : '1st';
    $budget             = isset($_POST['budget']) ? doubleval($_POST['budget']) : 0.00;

    if (!$phone || !$website || !$dealership_name || !$accountid) {
        return array(
            'error' => array(
                'code'    => 400,
                'message' => 'Unable to save, Missing required fields'
            )
        );
    }

    if ($dealership_id !== null && !$dealership_id) {
        return array(
            'error' => array(
                'code'    => 400,
                'message' => 'Dealership id is required'
            )
        );
    }

    $dealership = $id ? array('id' => $id) : array('created_by' => $user['id']);

    $dealership['job_title']       = $job_title;
    $dealership['contact_name']    = $contact_name;
    $dealership['email']           = $email;
    $dealership['phone']           = $phone;
    $dealership['website']         = $website;
    $dealership['dealership_name'] = $dealership_name;

    if ($dealership_id !== null) {
        $dealership['dealership_id'] = $dealership_id;
    }

    $dealership['status']             = $status;
    $dealership['accountid']          = $accountid;
    $dealership['geographic_targets'] = $geographic_targets;
    $dealership['promotions']         = $promotions;
    $dealership['new_campaigns']      = $new_campaigns;
    $dealership['used_campaigns']     = $used_campaigns;
    $dealership['start_type']         = $start_type;
    $dealership['budget']             = $budget;

    $db_connect = new DbConnect('');
    $sid = $db_connect->store_dealership($dealership);

    return $db_connect->get_dealership_by_id($sid);
}

/**
 * Saves a designer.
 *
 * @param      <type>  $mutex  The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function save_designer($mutex)
{
    global $user, $connection;

    $id           = isset($_POST['id']) ? $_POST['id'] : null;
    $border_color = isset($_POST['border_color']) ? $_POST['border_color'] : '';
    $text_color   = isset($_POST['text_color']) ? $_POST['text_color'] : '';
    $dealership   = $id ? array('id' => $id) : array('created_by' => $user['id']);

    $dealership['border_color'] = $border_color;
    $dealership['text_color']   = $text_color;

    $db_connect = new DbConnect('');
    $sid = $db_connect->store_dealership($dealership);

    return $db_connect->get_dealership_by_id($sid);
}

function get_dealership($id, $mutex)
{
    global $connection;

    $db_connect = new DbConnect('');
    $dealership = $db_connect->get_dealership_by_id($id);

    if ($dealership) {
        return $dealership;
    } else {
        return array(
            'error' => array(
                'code'    => 404,
                'message' => 'The dealership is either deleted or never existed'
            )
        );
    }
}

/**
 * Saves a note.
 *
 * @param      <type>  $mutex  The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function save_note($mutex)
{
    global $user;

    $id            = isset($_POST['id']) ? $_POST['id'] : null;
    $note          = isset($_POST['note']) ? $_POST['note'] : null;
    $dealership_id = isset($_POST['dealership_id']) ? $_POST['dealership_id'] : null;
	$happiness 	   = isset($_POST['happiness']) ? $_POST['happiness'] : 76;
	$created_by	   = isset($_POST['created_by']) ? $_POST['created_by'] : 'admin';
	$note_type     = isset($_POST['note_type']) ? $_POST['note_type'] : 'message';

    if ($note) {
        $note = trim($note);
    }

    if (!$dealership_id) {
        return array(
            'error' => array(
                'code'    => 400,
				'message' => 'Dealership id is missing'
			)
        );
    }

    if (!$note) {
        return array(
            'error' => array(
                'code'    => 400,
                'message' => 'Note isrequired and can not be empty'
            )
        );
    }

    $n = $id ? array('id' => $id) : array('created_by' => $user['id']);

    $n['note']          = $note;
	$n['dealership_id'] = $dealership_id;
	$at = time();

    $db_connect = new DbConnect('');
	$sid = $db_connect->store_note($dealership_id, $happiness, $note, $at, $note_type, $created_by);

	// return $db_connect->get_note_by_id($sid);
	return $sid;
}

/**
 * Pushes a lead.
 *
 * @param      <type>  $mutex  The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function push_lead($mutex)
{
    global $user;

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$id) {
        return array(
            'error' => array(
                'code'    => 400,
                'message' => 'Id is required to push lead'
            )
        );
    }

    $db_connect = new DbConnect('');
    $dealership = $db_connect->get_dealership_by_id($id);

    if (!$dealership) {
        return array(
            'error' => array(
                'code'    => 400,
                'message' => 'The lead you wanted to push, no longer exists in database'
            )
        );
    }

    $dealership['current_editor'] = $user['role'] * 2;
    $sid = $db_connect->store_dealership($dealership);

    return $db_connect->get_dealership_by_id($sid);
}
