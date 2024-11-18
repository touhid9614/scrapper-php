<?php

$db_config = array(
    'db_host_name'  => '127.0.0.1',
    'db_user'       => 'spidri_scraper15',
    'db_pass'       => 'cakeing*1',
    'db_name'       => 'spidri_ads_db'
);

if (!$connection = pg_connect("host={$db_config['db_host_name']} port=5432 dbname={$db_config['db_name']} user={$db_config['db_user']} password={$db_config['db_pass']}")) {
    die("Database is required in this context. Failed to establish database connection. " . pg_errormessage());
}

die(pg_dbname($connection));