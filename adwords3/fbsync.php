<?php

ob_start();
require_once('config.php');
require_once('carlist-loader.php');
require_once('cron_misc.php');
require_once('db_connect.php');
require_once('utils.php');


$php_binary = '/usr/local/bin/php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['killme']))
    {
        $pid = preg_replace('/[^0-9]/', '', $_POST['killme']);
        if (`ps aux |grep -v grep | grep $pid | grep ng_fbsync_worker.php | wc -l ` == 1) { `kill $pid`; }
    }
    else if (isset($_POST['killall']))
    {
        if($_POST['killall']) { exec ("ps aux |  grep -i php | grep ng_fbsync_worker.php | grep -v grep | awk '{print $2}' | xargs kill"); }
    }
    else if(isset($_POST['startall']))
    {
        exec($php_binary . ' ' 
            . escapeshellarg(__DIR__ . '/ng_fbsync_launcher.php')
            . ' > /dev/null 2>/dev/null &', $outputr);	
        sleep(2); //needs time to update before generating list after location redirect
    }
    else if(isset($_POST['start_one']))
    {
        $dealership = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['start_one']);

        if(($dealership != ''))
        {
            exec($php_binary . ' ' 
                . escapeshellarg(__DIR__ . '/ng_fbsync_worker.php') . ' ' 
                . escapeshellarg($dealership)
                . ' > /dev/null 2>/dev/null &', $outputr);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$worker_list = explode("\n", `ps aux |  grep -i php | grep ng_fbsync_worker.php | grep -v grep | awk '{print $2, $13, $3, $10, $8}'`);

echo '<h2>FbSync Control Panel</h2><p>List does not automatically refresh for now, please refresh page to get updates.</p><table style="border:1px solid black">';
echo '<tr><th>PID</th><th>cron name</th><th>CPU(%)</th><th>RAM(%)</th><th>status</th><th>stop</th></tr>';
foreach ($worker_list as $worker_data)
{
    if(trim($worker_data) == '') { continue; }

    echo "<tr>";
    $xp = explode(' ', $worker_data);
    $top = "top -b -n 1 -p {$xp[0]} | grep -i php | awk '{print $9, $10}'";
    $cm = explode(' ', `$top`);
    $xp[2] = $cm[0];
    $xp[3] = $cm[1];
    foreach($xp as $column)
    {
        echo "<td style='border-right:1px solid grey; padding:0.4em'>$column</td>";
    }

    echo <<<eoform
<td><form action="{$_SERVER['PHP_SELF']}" method="POST">
<input type="hidden" name="killme" value="{$xp[0]}">
<input type="submit" name="killer" value="Stop worker">
</form></td>
eoform;
	echo "</tr>";
}

echo '</table>';

echo <<<eoform2
<form action="{$_SERVER['PHP_SELF']}" method="POST">
<input type="hidden" name="killall" value="true">
<input type="submit" value="End all workers!">
</form>
eoform2;

echo <<<eoform2
<form action="{$_SERVER['PHP_SELF']}" method="POST">
<input type="submit" name="startall" value="Start ALL workers using this customer:">
<input type="text" name="startall_customer" value="" required>
</form>
eoform2;


echo 'Start one worker:';
echo "<form action='{$_SERVER['PHP_SELF']}' method='POST'>";
echo "<select name='start_one'><option value='-----'>-----</option>";
foreach($scrapper_configs as $cron_name => $project_config)
{
    if(!isset($CronConfigs[$cron_name]) || !isset($CronConfigs[$cron_name]['fb_config'])) { continue; }
    echo "<option value='" .  htmlspecialchars($cron_name) 
            . "'>".htmlspecialchars($cron_name).'</option>';
}
echo '<input type="text" name="start_one_customer" value="" required>';
echo '<input type="submit" value="Start just this"></form>';

$mysqli_load = explode(' ', `top -b -n 1 | grep -w mysqld | awk '{print $9, $10}'`);

echo "<div>";
echo "<p><b>CPU Used by MySql:</b> {$mysqli_load[0]}%</p>";
echo "<p><b>RAM Used by MySql:</b> {$mysqli_load[1]}%</p>";
echo "<div>";