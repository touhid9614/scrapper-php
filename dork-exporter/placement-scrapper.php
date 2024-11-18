<?php

    ini_set('display_errors', 1);
    ini_set('memory_limit', -1);

    ini_set("log_errors", 1);
    error_reporting(E_ALL);

    $argv[2] = true;

    //print_r($argv);

    $worker_log_dir = __DIR__ . '/logs/placements' ;

    if(!file_exists($worker_log_dir)) 
    {
        if(!mkdir($worker_log_dir)) 
        {
            die('can not create logging directory');
        }
    }

    $worker_logfile = $worker_log_dir .'/'. date('Y-m-d_H:i:s_') .substr((string)microtime(), 1, 8) . '.log';

    ini_set("error_log", $worker_logfile);


    /**
     * { function_description }
     *
     * @param      <type>  $text   The text
     */
    function logme_nostrip($text)
    {
        //global $worker_logfile;
        echo "$text\n";
        //file_put_contents($worker_logfile, $text."\n", FILE_APPEND);
    }


    /**
     * { function_description }
     *
     * @param      <type>  $text   The text
     */
    function logme($text)
    {
        //global $worker_logfile;
        echo "$text\n";
        //file_put_contents($worker_logfile, strip_tags($text)."\n", FILE_APPEND);
    }

    logme(print_r($argv, true));
    logme('Starting thread');
    $grepstring = 'ps aux  | grep -v grep | grep '. escapeshellarg('placement-scrapper.php ' . $argv[1]) .' | grep -v sudo';
    logme($grepstring);
    logme(`$grepstring`);

    if (`$grepstring | wc -l` > 2)
    {
        logme("already running, quitting");
        die();
    }
    else
    {
        logme("Not already running");
    }

    require_once 'bootstrapper.php';

    global $db_config, $carlist, $advanced_carlist, $site_scrappers, $tolog, $proxy_list, $site_rules,
           $CronConfigs, $scrapper_configs, $already_searched;

    loadCarList();
    loadAdvancedCarList();

    $max_pages          = 3;               //300 result is more than planty (100 results per page)
    $already_searched   = [];

    if(isset($argv[1]) && isset($CronConfigs[$argv[1]]) && isset($scrapper_configs[$argv[1]])) 
    {
        $cron_name      = $argv[1];
        $cron_config    = $CronConfigs[$cron_name];
        process_dealership($cron_name, $cron_config, $max_pages);
    } 
    else 
    {
        foreach($CronConfigs as $cron_name => $cron_config) 
        {
            if(!isset($scrapper_configs[$cron_name])) 
            { 
                continue; 
            }

            process_dealership($cron_name, $cron_config, $max_pages);
        }
    }


    /**
     * { function_description }
     *
     * @param      <type>  $cron_name    The cron name
     * @param      <type>  $cron_config  The cron configuration
     * @param      <type>  $max_pages    The maximum pages
     */
    function process_dealership($cron_name, $cron_config, $max_pages) 
    {
        global $already_searched;
        
        $cars_db        = array();
        $ads_db         = array();
        $all_cars_db    = array();
        
        $db_connect = new DbConnect($cron_name);
        $db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);
        
        foreach($all_cars_db as $stock_number => $car)
        {
            if($car['deleted']) 
            { 
                continue; 
            }
            
            $search_strings = array(
                "{$car['year']} {$car['make']} {$car['model']} Review"
            );
            
            if(isset($cron_config['city'])) 
            {
                $search_strings[] = "{$car['year']} {$car['make']} {$car['model']} {$cron_config['city']}";
            }
            
            foreach($search_strings as $search_query) 
            {
                if(in_array($search_query, $already_searched)) {
                    slecho("Already serached for : '$search_query'");
                    continue;
                }
                
                $already_searched[] = $search_query;
                
                $query = "SELECT id, last_attempt, results FROM posible_placement_criterias WHERE criteria = '$search_query'";
                
                $id             = 0;
                $last_attempt   = 0;
                $result_count   = 0;
                
                $res = $db_connect->query($query);
                
                if($res) 
                {
                    $row = mysqli_fetch_array($res);
                    
                    if($row) 
                    {
                        $id             = $row['id'];
                        $last_attempt   = $row['last_attempt'];
                        $result_count   = $row['results'];
                    }
                }
                
                if(!$id) 
                {
                    $uquery = "INSERT INTO posible_placement_criterias (criteria, last_attempt, results) VALUES ('$search_query', CURRENT_TIMESTAMP, 0);";
                    $db_connect->query($uquery);
                    $res = $db_connect->query($query);
                
                    if($res) 
                    {
                        $row = mysqli_fetch_array($res);

                        if($row) 
                        {
                            $id             = $row['id'];
                        }
                    }
                }
                
                if(time() - $last_attempt > 604800 || $result_count < 10) /* 1 Week  or Not any result*/
                {
                    slecho("Starting google search for $search_query");
                    process_search_query($db_connect, $search_query, $id, $max_pages);
                } 
                else 
                {
                    slecho("Search for query $search_query was performed within last 7 days");
                }
            }
        }    

        $db_connect->close_connection();
    }


    /**
     * { function_description }
     *
     * @param      DbConnect  $db_connect     The database connect
     * @param      <type>     $search_string  The search string
     * @param      <type>     $query_id       The query identifier
     * @param      integer    $max_pages      The maximum pages
     */
    function process_search_query(DbConnect $db_connect, $search_string, $query_id, $max_pages) 
    {
        $current_page = 0;
        $has_more = true;
        
        while($has_more && $current_page < $max_pages) 
        {
            $results = google($search_string, $current_page, $has_more);
            
            foreach($results as $result) 
            {
                $query = "SELECT id FROM posible_placement_urls WHERE criteria_id = $query_id AND url = '{$result['url']}';";
                $found = false;
                
                $res = $db_connect->query($query);

                if($res) 
                {
                    $row = mysqli_fetch_array($res);

                    if($row) 
                    {
                        $found = true;
                    }
                }
                
                if(!$found) 
                {
                    $iquery = "INSERT INTO posible_placement_urls (criteria_id, url) VALUES ($query_id, '{$result['url']}');";
                    $db_connect->query($iquery);
                    
                    $uquery = "UPDATE posible_placement_criterias SET results = results + 1 WHERE id = $query_id";
                    $db_connect->query($uquery);
                    slecho("New URL for '$search_string' : {$result['url']}");
                } 
                else 
                {
                    slecho("URL already exist for '$search_string' : {$result['url']}");
                }
            }
            
            $current_page++;
        }
        
        $uquery = "UPDATE posible_placement_criterias SET last_attempt = CURRENT_TIMESTAMP WHERE id = $query_id";
        $db_connect->query($uquery);
    }
    
    slecho('************************* THE END *************************');
