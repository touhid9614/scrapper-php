<?php

    require_once 'bootstrapper.php';

    global $connection;

    $query = isset($_GET['q'])? $_GET['q'] : false;

    if($query != 'process' && $query != 'check' && $query != 'geo' && $query != 'loc' && $query != 'temp' && $query != 'auto')
        die('Info: Dork query parameter is invalid');

    $db_connect = new DbConnect('');

    if($query == 'process')
    {
        $file = isset($_GET['f'])?$_GET['f']:null;
        
        $dork_queries = load_dork_queries($file);
        
        foreach($dork_queries as $query)
        {
            process_site_request($query, $db_connect);
        }
    }
    elseif($query == 'check')
    {
        process_check_providers($db_connect);
    }
    elseif($query == 'geo')
    {
        process_geo_coding($db_connect);
    }
    elseif($query == 'loc')
    {
        $queries = get_search_queries();
        
        foreach($queries as $query)
        {
            process_site_request($query, $db_connect, 3);
        }
    }
    elseif($query == 'temp')
    {
        $qt = isset($_GET['t'])?$_GET['t']:'[dork] [city]';
        
        $queries = load_templated_queries($qt);
        
        slecho(count($queries) . " queries has been generated for <pre>$qt</pre>");
        
        foreach($queries as $query)
        {
            process_site_request($query, $db_connect, 3);
        }
    }
    elseif($query == 'auto')
    {
        scrap_from_autotrader('http://www.autotrader.ca/dealer/dealerfinder/dealerfinder.aspx?rctry=true&c2t=Car&st=11', $db_connect);
    }

    $db_connect->close_connection();

    slecho('************************* THE END *************************');

?>