<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(dirname(__DIR__)) . '/adwords3/cron_misc.php';
require_once dirname(dirname(__DIR__)) . '/adwords3/utils.php';
require_once __DIR__ . '/include/functions.php';
require_once __DIR__ . '/include/analytics.php';

$data_directory = dirname(dirname(__DIR__)) . '/adwords3/data';
if(!defined('DATA_DIR')) {
    define('DATA_DIR', $data_directory);
}

$make_data  = DATA_DIR . '/make-data.json';
if(!defined('MAKE_DATA_FILE')) {
    define('MAKE_DATA_FILE', $make_data);
}

$model_data = DATA_DIR . '/model-data.json';
if(!defined('MODEL_DATA_FILE')) {
    define('MODEL_DATA_FILE', $model_data);
}

//Vehicles sold before this date shall be ignored
$oldest_date    = strtotime('07-09-2018');
$lastest_date   = strtotime('05-10-2018');

$cron_name          = 'patmillikenford';

//Date Points to consider
$dates = [];

$date = substractday($oldest_date);

while($date < getlastfriday()) {
    $friday = getnextfriday($date);
    
    $dates[] = [
        'prev'      => getlastfriday(substractday($friday)),
        'current'   => $friday,
        'next'      => getnextfriday(addday($friday))
    ];
    
    $date = addday($friday);
    #Deal with latest date
    if($date > $lastest_date) { break; }
}

# General Database Configuration
$db_config = [
    'db_host' => 'smedia-dev.chzwnt9wkmln.us-east-1.rds.amazonaws.com',
    'db_user' => 'spidri',
    'db_pass' => 'c5ZCpG1!D14s$155*7'
];

$scrapped_data_db   = 'spidri_ads';
$analytics_db       = 'analytics';

$dsn = "mysql:host={$db_config['db_host']};dbname={$scrapped_data_db};";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
//try {
    $pdo = new PDO($dsn, $db_config['db_user'], $db_config['db_pass'], $options);

    $stmt  = $pdo->prepare("SELECT * FROM " . get_data_table($cron_name) . " WHERE deleted = 0 OR (deleted = 1 AND updated_at > :oldest_sold)");
    $stmt->execute(['oldest_sold' => $oldest_date]);
    
    $vehicles = [];
    $url_maps = [];

    while($row = $stmt->fetch()) {
        $vehicles[$row['stock_number']] = $row;
        $url_maps[$row['stock_number']] = [
            'url'       => $row['url'],
            'stock'     => $row['stock_number'],
            'year'      => $row['year'],
            'make'      => $row['make'],
            'model'     => $row['model'],
            'price'     => numarifyPrice($row['price']),
            'sold'      => $row['deleted'],
            'sold_on'   => $row['updated_at']
        ];
    }

    //SWITCH to analytics DB
    $pdo->exec("USE $analytics_db;");

    /*
    //Start collecting all the pageviews and then events
    $domains = ['www.lithiahyundaireno.com', 'www.crestviewchrysler.ca', 'www.formulanissan.com'];
    refactor_pageViews($pdo, $domains);
    */
    
    $csv_dir = DATA_DIR . "/trainingdata/$cron_name";

    if(!file_exists($csv_dir)) {
        if(!mkdir($csv_dir, 0777, true)) {
            die("Error: Unable to write to data directory.");
        }
    }
    
    $training_set   = "$csv_dir/training.csv";
    $test_set       = "$csv_dir/test.csv";
    
    unlink($training_set);
    unlink($test_set);
   
    $date_count = 0;
    $total_dates = count($dates);
    $total_vehicles = count($url_maps);
    
    //Prepare for each data points
    foreach($dates as $date) {
        
        $csv_file = "$csv_dir/" . date('jS \of F Y', $date['current']) . ".csv";
        
        unlink($csv_file);
        
        $vehicle_count = 0;
        
        foreach($url_maps as $vehicle) {
            
            echo "Dates Processed: $date_count of $total_dates Vehicles Processed: $vehicle_count of $total_vehicles" . PHP_EOL;
            
            $res = prepareData($pdo, $vehicle, $date);
            
            if($res) {
                //Write Out
                csv_write_line($csv_file, $res);
                
                $rnd = rand(0, 100);
                if($rnd < 10) {
                    csv_write_line($test_set, $res);
                } else {
                    csv_write_line($training_set, $res);
                }
            }
            
            $vehicle_count++;
        }
        $date_count++;
    }
    
//} catch (\PDOException $e) {
//    throw new \PDOException($e->getMessage(), (int)$e->getCode());
//}


