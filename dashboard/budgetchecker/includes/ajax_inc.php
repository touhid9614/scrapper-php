<?php

/**
 * Gets the current google customer.
 *
 * @return     <type>  The current google customer.
 */
if (!function_exists("get_current_google_customer")) {
    function get_current_google_customer()
    {
        return isset($_GET['customer']) ? $_GET['customer'] : 'marshal';
    }
}

/**
 * Gets the dealerships.
 *
 * @return     <type>  The dealerships.
 */
function get_dealerships()
{
    global $CronConfigs, $custom_dealerships;

    $dealer_ships = array_keys($CronConfigs);

    foreach ($custom_dealerships as $key => $config) {
        if (isset($config['range']) && (strtotime($config['range']['end']) + 86400) < time()) {
            continue;
        }

        $dealer_ships[] = $key;
    }

    return $dealer_ships;
}

/**
 * { function_description }
 *
 * @param      <type>  $CurrentConfig  The current configuration
 * @param      <type>  $cron_name      The cron name
 * @param      <type>  $mutex          The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function eval_dealership($CurrentConfig, $cron_name, $mutex)
{
    global $CronConfigs, $connection, $custom_dealerships;

    $custom      = false;
    $cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : false;

    if (!isset($cron_config['customer_id'])) {
        $cron_config['customer_id'] = false;
    }

    if (isset($cron_config['no_adv']) && $cron_config['no_adv']) {
        $custom = true;
    }

    if ((!$cron_config || !isset($cron_config['max_cost'])) && isset($custom_dealerships[$cron_name])) {
        $custom      = true;
        $cron_config = $custom_dealerships[$cron_name];
    }

    if (!$cron_config) {
        return array('error' => array('code' => 404, 'message' => 'Dealership is not present'));
    }

    $on15  = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $range = isset($cron_config['range']) ? $cron_config['range'] : false;

    $days_past      = 0;
    $days_remaining = 0;
    $during         = '';

    $db_connect = new DbConnect($cron_name);
    $analytics     = new Analytics(get_current_google_customer());
    // $analytics     = new Analytics($CurrentConfig);
    $domain        = getDealerDomain($cron_name);
    $profileId_key = "{$cron_name}_profileId";
    $profileId     = $db_connect->get_meta('dealer_domain', $profileId_key);

    if (!$profileId) {
        $profileId = retrive_best_profileId($analytics, $domain);

        if ($profileId) {
            $db_connect->update_meta('dealer_domain', $profileId_key, $profileId);
        }
    }

    if ($range) {
        $from = strtotime($range['start']);
        $end  = strtotime($range['end']) + 86400; // 24 * 60 * 60 = 86400
        $to   = min(array(time(), $end));

        $during = date('Ymd', $from) . ',' . date('Ymd', $to);

        $days_past      = floor(($to - $from) / (86400));
        $days_remaining = floor(($end - $to) / (86400));
    } elseif ($on15) {
        $day = date('j');

        if ($day > 15) {
            $to     = time() + (86400);
            $during = date('Ym') . '16,' . date('Ymd', $to);

            $from = mktime(0, 0, 0, date('n'), 16, date('Y'));

            $days_past      = $day - 15;
            $days_remaining = 15 + cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')) - date('d');
        } else {
            $to = time() + (86400);

            $month = date('n') - 1 == 0 ? 12 : date('n') - 1;
            $year  = $month == 12 ? date('Y') - 1 : date('Y');

            $from = mktime(0, 0, 0, $month, 16, $year);

            $during = date('Ymd', $from) . ',' . date('Ymd', $to);

            $days_past      = cal_days_in_month(CAL_GREGORIAN, $month, $year) - 15 + date('d');
            $days_remaining = 15 - date('d');
        }
    } else {
        $from   = mktime(0, 0, 0, date('n'), 1, date('Y'));
        $to     = time() + (86400);
        $during = date('Ym') . '01,' . date('Ymd', $to);

        $days_past      = date('d');
        $days_remaining = cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y')) - date('d');
    }

    $to_l     = last_month($to);
    $from_l   = last_month($from);
    $during_l = date('Ymd', $from_l) . ',' . date('Ymd', $to_l);

    $analyticsStartDate   = date('Y-m-d', $from);
    $analyticsEndDate     = date('Y-m-d', $to);
    $analyticsStartDate_l = date('Y-m-d', $from_l);
    $analyticsEndDate_l   = date('Y-m-d', $to_l);
    $bounceRate           = null;
    $bounceRate_l         = null;

    $total_days      = $days_past + $days_remaining;
    $today_remaining = (tomorrow() - time()) / (86400);

    $days_past -= $today_remaining;
    $days_remaining += $today_remaining;

    $report    = $cron_config['customer_id'] ? (get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], $during, true, $mutex)) : [];
    $report_l  = $cron_config['customer_id'] ? (get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], $during_l, true, $mutex)) : [];
    $budget    = isset($cron_config['max_cost']) ? $cron_config['max_cost'] : 0;
    $distrib   = isset($cron_config['cost_distribution']) ? $cron_config['cost_distribution'] : [];
    $fb_budget = isset($cron_config['max_fb_cost']) ? $cron_config['max_fb_cost'] : 0;
    $youtube   = isset($distrib['youtube']) ? $distrib['youtube'] : false;

    if ($youtube) {
        $total = 0;
        foreach ($distrib as $key => $val) {
            $key = $key;
            $total += $val;
        }

        $youtube_budget = ($budget / $total) * $youtube;
        $budget -= $youtube_budget;
    }

    $calced   = report2cic($cron_name, $report, $custom);
    $calced_l = report2cic($cron_name, $report_l, $custom);

    $campaign_names = isset($calced['campaigns']) ? array_keys($calced['campaigns']) : null;

    if (!$campaign_names) {
        $profileId = null;
    }

    $analyticsReport   = null;
    $analyticsReport_l = null;

    if ($profileId) {
        for ($i = 0, $cmp_len = count($campaign_names); $i < $cmp_len; $i++) {
            $campaign_names[$i] = "ga:campaign=={$campaign_names[$i]}";
        }

        $filters = implode(',', $campaign_names);

        $analyticsReport = get_analytics_report($analytics, $profileId, $analyticsStartDate, $analyticsEndDate, $metrics = array('ga:avgTimeOnPage', 'ga:bounceRate'), array('ga:campaign'), $filters);

        if ($analyticsReport) {
            $bounceRate = $analyticsReport->totalsForAllResults->{'ga:bounceRate'} / 100;
        }

        $analyticsReport_l = get_analytics_report($analytics, $profileId, $analyticsStartDate_l, $analyticsEndDate_l, $metrics = array('ga:avgTimeOnPage', 'ga:bounceRate'), array('ga:campaign'), $filters, 8766); // 1 year = 365 days 6 hours = 365*24 + 6= 8766

        if ($analyticsReport_l) {
            $bounceRate_l = $analyticsReport_l->totalsForAllResults->{'ga:bounceRate'} / 100;
        }
    }

    $spent   = $calced['cost'];
    $spent_l = $calced_l['cost'];

    $to_return = create_eval_report($cron_name, $total_days, $days_past, $days_remaining, $budget, $spent, $on15, $range, $fb_budget);

    // calculate yesterday and today spent
    date_default_timezone_set("America/Regina");
    $report_y        = $cron_config['customer_id'] ? get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], ' YESTERDAY', true, $mutex) : [];
    $calced_y        = report2cic($cron_name, $report_y, $custom);
    $yesterday_spent = $calced_y['cost'];

    $report_t    = $cron_config['customer_id'] ? get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], 'TODAY', true, $mutex) : [];
    $calced_t    = report2cic($cron_name, $report_t, $custom);
    $today_spent = $calced_t['cost'];

    $report_w       = $cron_config['customer_id'] ? get_ranged_report($CurrentConfig, $cron_name, $cron_config['customer_id'], 'LAST_7_DAYS', true, $mutex) : [];
    $calced_w       = report2cic($cron_name, $report_w, $custom);
    $weekly_average = round($calced_w['cost'] / 7, 2);

    $to_return['customer_id']     = $cron_config['customer_id'];
    $to_return['profile_id']      = $profileId;
    $to_return['y_adb']           = round($yesterday_spent - $to_return['adjustment'], 2);
    $to_return['yesterday_spent'] = round($yesterday_spent, 2);
    $to_return['today_spent']     = round($today_spent, 2);
    $to_return['daily_average']   = round($weekly_average, 2);
    $to_return['clicks']          = $calced['clicks'] - $calced_l['clicks'];
    $to_return['impressions']     = $calced['impressions'] - $calced_l['impressions'];

    $projected_clicks      = 0;
    $projected_impressions = 0;

    if ($to_return['spent'] > 0 && $calced['clicks'] > 0) {
        $projected_clicks = intval($to_return['projected'] / ($to_return['spent'] / $calced['clicks']));
    }

    if ($to_return['spent'] > 0 && $calced['impressions'] > 0) {
        $projected_impressions = intval($to_return['projected'] / ($to_return['spent'] / $calced['impressions']));
    }

    $to_return['projected_clicks']         = $projected_clicks;
    $to_return['projected_impressions']    = $projected_impressions;
    $to_return['total_clicks']             = $calced['clicks'];
    $to_return['bounce_rate']              = $bounceRate;
    $to_return['bounce_rate_pp']           = $bounceRate_l;
    $to_return['advert_type']              = 'regular';
    $to_return['custom']                   = $custom;
    $to_return['cost_per_engaged_user']    = $bounceRate !== null ? ($calced['clicks'] > 0 ? ($calced['clicks'] - ($calced['clicks'] * $bounceRate) > 0 ? (round($spent / ($calced['clicks'] - ($calced['clicks'] * $bounceRate)), 2)) : 'INF') : 0) : 'N/A';
    $to_return['cost_per_engaged_user_pp'] = $bounceRate_l !== null ? ($calced_l['clicks'] > 0 ? ($calced_l['clicks'] - ($calced_l['clicks'] * $bounceRate_l) > 0 ? (round($spent_l / ($calced_l['clicks'] - ($calced_l['clicks'] * $bounceRate_l)), 2)) : 'INF') : 0) : 'N/A';
    $to_return['campaigns']                = compile_campaigns($analyticsReport, $analyticsReport_l, $calced['campaigns'], $calced_l['campaigns'], $calced_y['campaigns'], $calced_t['campaigns']);

    if ($youtube) {
        $youtube_spent        = $calced['youtube_cost'];
        $to_return['youtube'] = create_eval_report($cron_name, $total_days, $days_past, $days_remaining, $youtube_budget, $youtube_spent, $on15, $range);

        $youtube_today     = $calced_t['youtube_cost'];
        $youtube_yesterday = $calced_y['youtube_cost'];

        $youtube_daily = round($calced_w['youtube_cost'] / 7, 2);

        $youtube_clicks      = $calced['youtube_clicks'];
        $youtube_impressions = $calced['youtube_impressions'];

        $to_return['youtube']['y_adb']           = $youtube_yesterday - $to_return['youtube']['adjustment'];
        $to_return['youtube']['yesterday_spent'] = $youtube_yesterday;
        $to_return['youtube']['today_spent']     = $youtube_today;
        $to_return['youtube']['daily_average']   = $youtube_daily;
        $to_return['youtube']['clicks']          = $calced['youtube_clicks'] - $calced_l['youtube_clicks'];
        $to_return['youtube']['impressions']     = $calced['youtube_impressions'] - $calced_l['youtube_impressions'];
        $to_return['youtube']['customer_id']     = $cron_config['customer_id'];

        $youtube_projected_clicks      = 0;
        $youtube_projected_impressions = 0;

        if ($to_return['youtube']['spent'] > 0 && $youtube_clicks > 0) {
            $youtube_projected_clicks = intval($to_return['youtube']['projected'] / ($to_return['youtube']['spent'] / $youtube_clicks));
        }
        if ($to_return['youtube']['spent'] > 0 && $youtube_impressions > 0) {
            $youtube_projected_impressions = intval($to_return['youtube']['projected'] / ($to_return['youtube']['spent'] / $youtube_impressions));
        }
        $to_return['youtube']['projected_clicks']      = $youtube_projected_clicks;
        $to_return['youtube']['projected_impressions'] = $youtube_projected_impressions;
        $to_return['youtube']['advert_type']           = 'youtube';
        $to_return['youtube']['custom']                = $custom;
        $to_return['youtube']['campaigns']             = compile_campaigns($analyticsReport, $analyticsReport_l, $calced['youtube_campaigns'], $calced_l['youtube_campaigns'], $calced_y['youtube_campaigns'], $calced_t['youtube_campaigns']);
    }

    return $to_return;
}

/**
 * { function_description }
 *
 * @param      <type>  $CurrentConfig  The current configuration
 * @param      <type>  $cron_name      The cron name
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function update_budget($CurrentConfig, $cron_name)
{
    global $CronConfigs, $custom_dealerships, $developer_token;

    $custom = false;

    $cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : false;

    if (!$cron_config && isset($custom_dealerships[$cron_name])) {
        $custom      = true;
        $cron_config = $custom_dealerships[$cron_name];
    }

    if (!$cron_config) {
        return array('error' => array('code' => 404, 'message' => 'Dealership is not present'));
    }

    $campaign_ids    = $_REQUEST['campaign_ids'];
    $budget_ids      = $_REQUEST['budget_ids'];
    $current_amounts = $_REQUEST['current_amounts'];
    $new_amounts     = $_REQUEST['new_amounts'];

    $changed_budgets = get_changed_budgets($campaign_ids, $budget_ids, $current_amounts, $new_amounts);

    if (count($changed_budgets) == 0) {
        return array('code' => 200, 'message' => 'Nothing to modify');
    }

    $service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);

    for ($i = 0, $cng_bud = count($changed_budgets); $i < $cng_bud; $i++) {
        $retval                         = $service->SetBudget($changed_budgets[$i]['budget_id'], $changed_budgets[$i]['amount']);
        $changed_budgets[$i]['success'] = $retval !== false;
    }

    return array('code' => 202, 'message' => 'Following budgets has been modified', 'changed' => $changed_budgets);
}

/**
 * Gets the changed budgets.
 *
 * @param      <type>  $campaign_ids     The campaign identifiers
 * @param      <type>  $budget_ids       The budget identifiers
 * @param      <type>  $current_amounts  The current amounts
 * @param      <type>  $new_amounts      The new amounts
 *
 * @return     array   The changed budgets.
 */
function get_changed_budgets($campaign_ids, $budget_ids, $current_amounts, $new_amounts)
{
    $campaign_names = array_keys($campaign_ids);
    $retval         = [];

    foreach ($campaign_names as $campaign_name) {
        if ($current_amounts[$campaign_name] != $new_amounts[$campaign_name]) {
            $retval[] = array(
                'campaign_name' => $campaign_name,
                'campaign_id'   => $campaign_ids[$campaign_name],
                'budget_id'     => $budget_ids[$campaign_name],
                'old_amount'    => floatval($current_amounts[$campaign_name]),
                'amount'        => floatval($new_amounts[$campaign_name]),
            );
        }
    }

    return $retval;
}

/**
 * { function_description }
 *
 * @param      <type>  $CurrentConfig  The current configuration
 * @param      <type>  $cron_name      The cron name
 * @param      <type>  $mutex          The mutex
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function monthly_dealership($CurrentConfig, $cron_name, $mutex)
{
    global $CronConfigs, $connection, $custom_dealerships, $developer_token;

    $custom      = false;
    $cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : false;

    if (!$cron_config && isset($custom_dealerships[$cron_name])) {
        $custom      = true;
        $cron_config = $custom_dealerships[$cron_name];
    }

    if (!$cron_config) {
        return array('error' => array('code' => 404, 'message' => 'Dealership is not present'));
    }

    $on15  = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $range = isset($cron_config['range']) ? $cron_config['range'] : false;

    $service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);

    return $service->GetAccountCost($on15, $range);
}

/**
 * { function_description }
 *
 * @param      <type>  $time   The time
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function last_month($time)
{
    return strtotime(date('Y-m-d H:i:s', $time) . ' -1 month');
}

/**
 * Creates an eval report.
 *
 * @param      <type>           $cron_name       The cron name
 * @param      integer          $total_days      The total days
 * @param      integer          $days_past       The days past
 * @param      integer          $days_remaining  The days remaining
 * @param      integer          $budget          The budget
 * @param      integer          $spent           The spent
 * @param      <type>           $on15            On 15
 * @param      <type>           $ranged          The ranged
 * @param      boolean|integer  $fb_budget       The fb budget
 *
 * @return     array            ( description_of_the_return_value )
 */
function create_eval_report($cron_name, $total_days, $days_past, $days_remaining, $budget, $spent, $on15, $ranged, $fb_budget = 0)
{
    $projected    = round(($budget / $total_days) * $days_past, 2);
    $fb_projected = round(($fb_budget / $total_days) * $days_past, 2);
    $range        = $projected / 10;
    $offset       = 0;

    if ($spent > $projected + $range) {
        $offset = $spent - $projected;
        $status = 'over';
    } elseif ($spent < $projected - $range) {
        $offset = abs($spent - $projected);
        $status = 'below';
    } else {
        $offset = abs($spent - $projected);
        $status = 'ok';
    }

    if ($days_remaining <= 0) {
        $adjustment = round($budget - $spent, 2);
    } else {
        $adjustment = round(($budget - $spent) / $days_remaining, 2);
    }

    if ($adjustment > ($budget - $spent)) {
        $adjustment = round($budget - $spent, 2);
    }

    if ($adjustment < 0) {
        $adjustment = 0;
    }

    $name = $cron_name;

    if ($ranged) {
        $name .= ' (' . date('d M', strtotime($ranged['start'])) . ' to ' . date('d M', strtotime($ranged['end'])) . ')';
    }

    $to_return = array(
        'name'         => $cron_name,
        'display_name' => $name,
        'budget'       => $budget,
        'fb_budget'    => $fb_budget ? $fb_budget : 'N/A',
        'fb_projected' => $fb_budget ? $fb_projected : 'N/A',
        'spent'        => round($spent, 2),
        'projected'    => round($projected, 2),
        'offset'       => round($offset, 2),
        'adjustment'   => $adjustment,
        'status'       => $status,
        'on15'         => $on15,
        'ranged'       => !!$ranged,
    );

    return $to_return;
}

/**
 * { function_description }
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function tomorrow()
{
    $time = time() + (86400); // 1 day = 86400 sec

    return mktime(0, 0, 0, date("n", $time), date("j", $time), date("Y", $time));
}

/**
 * { function_description }
 *
 * @param      <type>  $analyticsReport      The analytics report
 * @param      <type>  $analyticsReport_l    The analytics report l
 * @param      <type>  $campaigns            The campaigns
 * @param      <type>  $campaigns_lastmonth  The campaigns lastmonth
 * @param      <type>  $campaigns_yesterday  The campaigns yesterday
 * @param      <type>  $campaigns_today      The campaigns today
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function compile_campaigns($analyticsReport, $analyticsReport_l, $campaigns, $campaigns_lastmonth, $campaigns_yesterday, $campaigns_today)
{
    foreach ($campaigns as $campaign_name => $campaign) {
        $campaigns[$campaign_name]['spent']           = $campaign['cost'];
        $campaigns[$campaign_name]['spent_yesterday'] = isset($campaigns_yesterday[$campaign_name]) ? $campaigns_yesterday[$campaign_name]['cost'] : 0;
        $campaigns[$campaign_name]['spent_today']     = isset($campaigns_today[$campaign_name]) ? $campaigns_today[$campaign_name]['cost'] : 0;

        $bounceRate   = null;
        $bounceRate_l = null;

        if ($analyticsReport) {
            $bounceRate = 0;
        }
        if ($analyticsReport_l) {
            $bounceRate_l = 0;
        }

        if ($analyticsReport && $analyticsReport->rows) {
            foreach ($analyticsReport->rows as $areport) {
                if ($areport[0] == $campaign_name) {
                    $bounceRate = $areport[2] / 100;
                    break;
                }
            }
        }

        if ($analyticsReport_l && $analyticsReport_l->rows) {
            foreach ($analyticsReport_l->rows as $areport) {
                if ($areport[0] == $campaign_name) {
                    $bounceRate_l = $areport[2] / 100;
                    break;
                }
            }
        }

        $campaign_l = isset($campaigns_lastmonth[$campaign_name]) ? $campaigns_lastmonth[$campaign_name] : null;

        $campaigns[$campaign_name]['bounce_rate']              = $bounceRate;
        $campaigns[$campaign_name]['bounce_rate_pp']           = $bounceRate_l;
        $campaigns[$campaign_name]['cost_per_engaged_user']    = $bounceRate !== null ? ($campaign['clicks'] > 0 ? ($campaign['clicks'] - ($campaign['clicks'] * $bounceRate) > 0 ? (round($campaign['cost'] / ($campaign['clicks'] - ($campaign['clicks'] * $bounceRate)), 2)) : 'INF') : 0) : 'N/A';
        $campaigns[$campaign_name]['cost_per_engaged_user_pp'] = $bounceRate_l !== null ? ($campaign_l && $campaign_l['clicks'] > 0 ? ($campaign_l['clicks'] - ($campaign_l['clicks'] * $bounceRate_l) > 0 ? (round($campaign_l['cost'] / ($campaign_l['clicks'] - ($campaign_l['clicks'] * $bounceRate_l)), 2)) : 'INF') : 0) : 'N/A';
        unset($campaigns[$campaign_name]['cost']);
    }

    return $campaigns;
}
