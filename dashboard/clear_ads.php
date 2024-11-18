<?php
session_start();
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';
require_once 'bolts/header.php';

global $CronConfigs,$user;


if ($user['type'] == 'a')
{

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    $select = 'clear_ads';
    require_once 'bolts/sidebar.php';



    $keys = array_keys($CronConfigs);

    $php_binary = '/usr/local/bin/php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'clear-ads'))
    {
        $customer   = $_POST['customer'];
        $cron_name  = $_POST['cron_name'];
        $full       = isset($_POST['full'])?$_POST['full']:'0';
        $ads_type   = $_POST['ads_type'];

        if($cron_name)
        {
            exec ('/usr/local/bin/php '
                . escapeshellarg(ADSYNCPATH . 'ng_clear.php') . ' '
                . escapeshellarg($cron_name) . ' '
                . escapeshellarg($customer) . ' '
                . escapeshellarg($full) . ' '
                . escapeshellarg($ads_type)
                . ' > /dev/null 2>/dev/null &', $outputr);

            /*
            * Log added start
            */
            DbConnect::store_log($user_id, $user['type'],  'Clear Add', 'Clear Add Start for- ' . $cron_name . ' and full clear status is- ' . $full , $cron_name );
            /*
            * Log added end
            */
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

                    /*
                    * Log added start
                    */
                    DbConnect::store_log($user_id, $user['type'],  'Clear Add', 'Clear Add Start for- ' . $cron_name . ' and full clear status is- ' . $full , $cron_name );
                    /*
                    * Log added end
                    */
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (filter_input(INPUT_POST, 'btn') == 'stop-clear-ads'))
    {
        exec ("ps aux |  grep -i php | grep ng_clear.php | grep -v grep | awk '{print $2}' | xargs kill");
    }

    $worker_list = explode("\n", `ps aux |  grep -i php | grep ng_clear.php | grep -v grep | awk '{print $2, $13, $14, $10, $8}'`);
?>

<div class="inner-wrapper">
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <div class="row">
            <div class="col-lg-10">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <h2 class="panel-title"> Clear Ads </h2>
                    </header>
                    <div class="panel-body">
                        <form method="POST">
                            <div class="row form-group-row" style="padding: 0px 15px 15px">
                                <div class="col-sm-12" style="padding: 0px; margin-bottom:15px;">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><b>Customer Name</b></label>
                                        <input type="text" class="form-control" name="customer" value="" required />
                                    </div>
                                </div>
                                <div class=" col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><b>Select Adwords to Clear</b></label>
                                        <select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="ads_type" data-plugin-selectTwo>
                                            <option value="1" selected>Google + Scrapper</option>
                                            <option value="2">Google Ads</option>
                                            <option value="3">Bing Ads</option>
                                            <option value="4">Full Bing Ads</option>
                                            <option value="5">Scrapper</option>
                                            <option value="0">All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><b>Select Dealership to Clear</b></label>
                                        <select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="cron_name" data-plugin-selectTwo>
                                            <?php
                                            if ($user['type'] == 'a') {
                                                foreach ($cron_names as $c_name) {
                                                    ?>
                                            <option value="<?= $c_name ?>"><?= $c_name ?></option>
                                            <?php

                                        }
                                    } else {
                                        ?>
                                            <option value="<?= $user['cron_name'] ?>" <?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                            <?php
                                        } ?>
                                            <option value="">Clear All</option>
                                        </select>

                                    </div>
                                </div>
                                <!--div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label"><b>Full Clear </b></label>
                                        <div class="checkbox-custom checkbox-default">
                                            <input type="checkbox" name="full" value="1">
                                            <label for="checkboxExample1">( Also clear AdGroups )</label>
                                        </div>
                                        <!-- <input class="form-control" type="checkbox" name="full" value="1" /> -- >

                                    </div>
                                </div-->
                                </div>
                                <div class="col-sm-4">

                                    <button name="btn" value="clear-ads" class="btn btn-block btn-primary ">Clear</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>
            </div>

            <div class="col-md-10">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">List of Active Clears</h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                    $count = 0;
                                    foreach ($worker_list as $worker_data)
                                    {
                                        if(trim($worker_data) == '') continue;
                                        $xp = explode(' ', $worker_data);
                                        $count++;
                                        echo "<h4>{$count}. {$xp[1]}</h4>";
                                    }
                                    if($count==0){
                                        echo "<h4>No Active Clear Add Found!!</h4>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="col-md-3">
                    <form method="POST">
                        <button name="btn" value="stop-clear-ads" class="btn btn-block btn-danger ">Stop All Active Clears</button>
                    </form>
                </div>
                <a class="btn btn-info" href="https://tm.smedia.ca/adwords3/keyword-filter.php?customer=marshal">Keyword filter</a>
                &nbsp; &nbsp;
                <a class="btn btn-info" href="https://tm.smedia.ca/adwords3/adgroup-filter.php?customer=marshal">Adgroup filter</a>
            </div>



        </div>

    </section>
</div>


<?php include 'bolts/footer.php' ;
} else {
    echo '<h2 style="margin: 100px;">/* Unable to find requested resource. */ </h2>';
}
?>
