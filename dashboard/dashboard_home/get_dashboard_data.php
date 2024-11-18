<?php

    define('noprint', true);
    define('NO_USER_SESSION', true);

    require_once dirname(__DIR__) . '/config.php';
    require_once dirname(__DIR__) . '/includes/loader.php';

    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'Google/Adwords.php';
    require_once ADSYNCPATH . 'Google/Analytics.php';
    require_once ADSYNCPATH . 'Google/TokenHelper.php';
    require_once ADSYNCPATH . 'db_connect.php';

    require_once ABSPATH . 'includes/search-inventory.php';
    require_once ABSPATH . 'includes/bounce-rate.php';
    require_once ABSPATH . 'includes/ajax_inc.php';

    global $CronConfigs, $user, $set_path, $connection;

    $Configs = LoadConfig($set_path);
    $CurrentConfig = $Configs->AccessTokens['marshal'];
    $mutex = null;
    $count = 0;

    $log_file = fopen(ADSYNCPATH . 'caches/dashboard-home/log.txt', "w");

    echo "Updating Home Analytics: " . PHP_EOL;

    foreach ($CronConfigs as $cron_name => $cron_config) 
    {
        $count++;
        echo "{$count}. {$cron_name} ... ";
        
        $total_result = [];
        $summary = get_summary($CurrentConfig, $cron_config, $cron_name);
        $total_result['summary_data'] = $summary;
        $monthly = get_monthly($CurrentConfig, $cron_config, $cron_name, $mutex);
        $total_result['monthly_data'] = $monthly;
        $yearly = get_yearly($CurrentConfig, $cron_config, $cron_name, $mutex);
        $total_result['yearly_data'] = $yearly;
        $encodedString = json_encode($total_result, JSON_PRETTY_PRINT);

        $cache_path = ADSYNCPATH . 'caches/dashboard-home/' . $cron_name . '.txt';
        file_put_contents($cache_path, $encodedString);
        $Time=date('m/d/Y h:i:s a', time()) . "   " . $count . '=>' . $cron_name;
        fwrite($log_file, $Time);
        fwrite($log_file, "\n");
        
        echo "Done." .PHP_EOL;
    }

    fclose($log_file);