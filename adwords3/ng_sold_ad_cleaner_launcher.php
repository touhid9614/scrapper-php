<?php
if (!isset($argv[1])) die("Nothing to do, need cutomer arguments");
$customer = $argv[1];
global $CronConfigs;
$root_dir = dirname(__DIR__);

require_once "{$root_dir}/adwords3/config.php";

$data_file = "{$root_dir}/adwords3/data/cleaner_array.php";

$max = 20;
$count = 1;
$dealerships = [];
$cleaner_array = null;
$php_binary = 'php';

if (file_exists($data_file)) {
    $cleaner_array = file_get_contents($data_file);
}

if (!empty($cleaner_array)) {
    $dealerships = unserialize($cleaner_array);
    $cleaner_array = null;
} else {
    $dealerships = array_keys($CronConfigs);
}

while (true) {

    $worker_list  = array_filter(explode("\n", `ps aux |  grep -i php | grep adwords-v2.php | grep -v grep | awk '{print $13}'`));
    $worker_list_sold  = array_filter(explode("\n", `ps aux |  grep -i php | grep adwords-v2.php | grep sold | grep -v grep | awk '{print $13}'`));
    if (count($worker_list_sold) >= $max) {
        break;
    }
    $next = array_shift($dealerships);

    if (in_array($next, $worker_list)) {
        echo "Already running {$next} \n";
        $dealerships[] = $next;
        continue;
    }

    if (isset($CronConfigs[$next]) && isset($CronConfigs[$next]['customer_id'])) {
        if (!empty($customer) && !empty($next)) {
            $launch_str = $php_binary . ' '
                . escapeshellarg($root_dir . '/services/adwords-v2.php') . ' '
                . escapeshellarg($next) . ' '
                . 'sold'
                . ' > /dev/null 2>/dev/null &';

            exec($launch_str, $outputr);
            $dealerships[] = $next;
            file_put_contents($data_file, serialize($dealerships));
            echo $count++ .  " Starting $next \n";
        }
    } else {
        $dealerships[] = $next;
        file_put_contents($data_file, serialize($dealerships));
        echo "No config for $next \n";
    }
}
