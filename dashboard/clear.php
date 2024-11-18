<?php

require_once 'config.php';
require_once ADSYNCPATH . 'config.php';

global $CronConfigs;

$keys = array_keys($CronConfigs);

$php_binary = '/usr/local/bin/php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $customer   = $_POST['customer'];
    $cron_name  = $_POST['cron_name'];
    $full       = isset($_POST['full']) ? $_POST['full'] : '0';
    
    if ($cron_name)
    {
        exec ('/usr/local/bin/php ' 
            . escapeshellarg(ADSYNCPATH . 'ng_clear.php') . ' ' 
            . escapeshellarg($cron_name) . ' ' 
            . escapeshellarg($customer) . ' ' 
            . escapeshellarg($full) 
            . ' > /dev/null 2>/dev/null &', $outputr);
    }
    else
    {
        foreach ($keys as $cron_name)
        {
            exec ('/usr/local/bin/php ' 
                . escapeshellarg(ADSYNCPATH . 'ng_clear.php') . ' ' 
                . escapeshellarg($cron_name) . ' ' 
                . escapeshellarg($customer) . ' ' 
                . escapeshellarg($full) 
                . ' > /dev/null 2>/dev/null &', $outputr);
        }
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    die();
}

$worker_list = explode("\n", `ps aux |  grep -i php | grep ng_clear.php | grep -v grep | awk '{print $2, $13, $14, $10, $8}'`);

if (count($worker_list) > 1)
{
    echo '<h4>Active Clears</h4>';
    echo '<pre>';
    $count = 0;

    foreach ($worker_list as $worker_data)
    {
        if (trim($worker_data) == '')
        {
            continue;
        }

        $xp = explode(' ', $worker_data);
        $count++;
        echo "{$count}. {$xp[1]}\n";
    }
    echo '</pre><br/>';
}

?>

<form method="post" stype="margin:10px;">
    <span>Customer Name:</span><br/>
    <input name="customer" value="" type="text"><br/><br/>
    <span>Select Dealership to Clear:</span><br/>
    <select name="cron_name">
        <option value="" selected>Clear All</option>
        <?php foreach($keys as $key) {?>
        <option value="<?= $key ?>"><?= $key ?></option>
        <?php }?>
    </select><br/><br/>
    <!--input type="checkbox" name="full" value="1"/> Full Clear (Also clear AdGroups)<br/><br/-->
    <input type="submit" value="Clear"/>
</form>
<br/>
<a href="https://tm.smedia.ca/adwords3/keyword-filter.php?customer=marshal">Keyword filter</a><br>
<a href="https://tm.smedia.ca/adwords3/adgroup-filter.php?customer=marshal">Adgroup filter</a><br>