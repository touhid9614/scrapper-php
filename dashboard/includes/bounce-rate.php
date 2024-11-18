<?php

function get_avg_bounce_rate($connection, $mutex, $debug = false)
{
    $cache_name = "global-bounce-rate-v1.cache";
    
    if(!$debug)
    {
        $retval = get_object_cache($cache_name, 24);

        if($retval) { return $retval; }
    }
    
    global $CronConfigs, $scrapper_configs, $CurrentConfig;

    $cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

    $result = array();
    
    $db_connect = new DbConnect('');

    foreach($cron_names as $cron_name)
    {
        $domain = getDealerDomain($cron_name);
        $analytics = new Analytics(get_current_google_customer());
        $profileId_key = "{$cron_name}_profileId";
        $profileId = $db_connect->get_meta('dealer_domain', $profileId_key);
        if(!$profileId)
        {
            $profileId = retrive_best_profileId($analytics, $domain);
            if($profileId)
            {
                $db_connect->update_meta('dealer_domain', $profileId_key, $profileId);
            }
        }

        $startDate = new DateTime(date('Y-m-d'));
        $startDate->sub(new DateInterval('P45D'));

        $filters = ""; //"ga:adDistributionNetwork%3D%3DContent";
        
        $report = get_analytics_report($analytics, $profileId, $startDate->format('Y-m-d'), date('Y-m-d'), array('ga:bounceRate'), array('ga:adDistributionNetwork','ga:date'), $filters, 24);

        if(!$report || !$report->rows) { continue; }
        
        foreach($report->rows as $row)
        {
            if($row[0] != 'Content') { continue; }
            
            if(!isset($result[$row[1]]))
            {
                $result[$row[1]] = array(
                    'accumulatedBR' => $row[2],
                    'count'         => 1
                );
            }
            else
            {
                $result[$row[1]]['accumulatedBR'] += $row[2];
                $result[$row[1]]['count']++;
            }
        }
    }
    
    $retval = array();
    
    foreach ($result as $date_str => $row)
    {
        $date = date_create_from_format("Ymd", $date_str);
        $retval[$date->format('M, d')] = round($row['accumulatedBR']/$row['count'], 2);
    }
    
    store_object_cache($cache_name, $retval);
    
    return $retval;
}