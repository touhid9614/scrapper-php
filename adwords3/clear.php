<?php session_start();

    require_once('config.php');
    require_once('utils.php');
    require_once('Google/TokenHelper.php');
    require_once('Google/Types.php');
    require_once('Google/Util.php');
    require_once('Google/Adwords.php');
    require_once('Google/Consts.php');
    require_once('Google/SessionManager.php');
    require_once('cron_misc.php');    
    require_once('db_connect.php');
    require_once('AdSyncer.php');
    require_once('scrapper.php');
    
    global $CronConfigs, $connection;
    
    //set it to run for no timeout
    secho("Trying to set timeout to no limit" . "<br/>");
    set_time_limit(0);
    secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");
    
    $start_time = time();
    
    $mutex = Mutex::create();
    
    $force = isset($_GET['full'])?$_GET['full'] == '1':false;
    
    if(isset($_GET['cron_name']) && $_GET['cron_name'])
    {
        $cron_name = $_GET['cron_name'];
        $cron_config = $CronConfigs[$cron_name];

        slecho("Starting Ad cleaner cron for '" . $cron_name . "'");
        ClearAds($cron_name, $cron_config, $force);

        slecho("Starting data eraser cron for '" . $cron_name . "'");
        ClearScrap($connection, $cron_name, $mutex);
    }
    else
    {
        foreach ($CronConfigs as $cron_name => $cron_config)
        {
            slecho("Starting Ad cleaner cron for '" . $cron_name . "'");
            ClearAds($cron_name, $cron_config, $force);
            slecho("Starting data eraser cron for '" . $cron_name . "'");
            ClearScrap($connection, $cron_name, $mutex);
        }
    }
    
    Mutex::destroy($mutex);
    mysqli_close($connection);
    
    $elapced = time() - $start_time;
    slecho("Info: Total time taken " . $elapced . "seconds");
?>
