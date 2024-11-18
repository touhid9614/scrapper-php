<?php

	exec ("ps aux |  grep -i php | grep placement-scrapper.php | grep -v grep | grep -v root | awk '{print $2}' | xargs kill");
	die();

	require_once 'bootstrapper.php';

	global $db_config, $connection, $carlist, $site_scrappers, $tolog, $proxy_list, $site_rules;

	$search_string  = isset($_GET['q'])?"\"{$_GET['q']}\"":'"2014 Honda Accord Review"';
	$page           = 0;
	$has_more       = true;

	while($has_more && $page < 10) 
	{
	    $results[] = google($search_string, $page, $has_more);
	    $page++;
	}

	echo "<pre>";
	//print_r($results);
	foreach($results as $result) 
	{
	    if($result) 
	    {
	        foreach($result as $res) 
	        {
	            echo $res['url'] . "\n";
	        }
	    }
	}

	echo "</pre>";