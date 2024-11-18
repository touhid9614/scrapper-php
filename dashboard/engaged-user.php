<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once 'includes/button.php';

// Customize for this page because we want to show default all times data here
$date_range = filter_input_default(INPUT_GET, 'date_range');

if (!$date_range) {
    $start_date = '2010-01-01';
    $end_date   = date("Y-m-d");
    $date_range = 'all_time';
}

global $CronConfigs, $scrapper_configs, $connection;

$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

$scrapper_table = $cron_name . '_scrapped_data';
$engaged_query  = DbConnect::get_instance()->query("SELECT SUM(engaged_vdp.count) as count, title, deleted, vdp_url, stock_number FROM engaged_vdp JOIN $scrapper_table ON engaged_vdp.vdp_url = $scrapper_table.url WHERE dealership = '$cron_name' AND (engaged_vdp.day BETWEEN '$start_date' AND '$end_date') GROUP BY vdp_url");
$engaged_data   = [];
$i              = 0;

while ($record = mysqli_fetch_assoc($engaged_query)) {
    $i++;
    $engaged_data[$i]['title']               = $record['title'];
    $engaged_data[$i]['stock_number']        = $record['stock_number'];
    $engaged_data[$i]['url']                 = $record['vdp_url'];
    $engaged_data[$i]['count']               = $record['count'];
    $engaged_data[$i]['availability_export'] = $record['deleted'] ? 'Sold Out' : 'Available';
    $engaged_data[$i]['availability']        = $record['deleted'] ? '<span class="label label-danger">Sold Out</span>' : '<span class="label label-success">Available</span>';
}

include 'bolts/header.php'
?>

<div class="inner-wrapper">

<?php
$select = 'engaged-user';
include 'bolts/sidebar.php'
?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <div class="col-lg-12">
                <?php if (filter_input(INPUT_GET, 'dealership') != $cron_name) {?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                        <strong><?= filter_input(INPUT_GET, 'dealership') ?></strong> is either Inactive or doesn't have Buttons configured.
                    </div>
                <?php }?>

                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Details for :: <?=$cron_name?></h2>
                    </header>
                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership">Dealership</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
                                <?php
                                if ($user['type'] == 'a') {
                                    foreach ($cron_names as $c_name) {
                                        $selected = ($cron_name == $c_name) ? ' selected' : '';
                                ?>
                                        <option value="<?=$c_name?>"<?=$selected?>><?=$c_name?></option>
                                <?php
                                    }
                                } else {
                                ?>
                                    <option value="<?=$user['cron_name']?>"<?=' selected'?>><?=$user['cron_name']?> </option>
                                <?php
                                }
                                ?>
                            </select>

                            <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="date_range">Date Range</label>
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="date_range" id="date_range">
                                <?php
                                foreach (($date_ranges = date_range_data()) as $key => $val) {
                                    $selected = $date_range == $key ? ' selected' : '';
                                ?>
                                    <option value="<?=$key?>"<?=$selected?>><?=$val?></option>
                                <?php
                                }
                                ?>
                            </select>

                            <div class="form-group" id="custom_date_range" style="<?php if ($date_range != 'custom'): ?>display:none<?php endif;?>">
                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="start_date">Start Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="start_date" id="start_date" type="date" value="<?=$start_date?>" required=""/>

                                <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="end_date">End Date</label>
                                <input class="form-control mb-2 mr-sm-2 mb-sm-0" name="end_date" id="end_date" type="date" value="<?=$end_date?>" required=""/>
                            </div>
                            <button class="btn btn-primary ml-md"> Apply Filter </button>
                            <button type="button" class="btn btn-gplus ml-md" id="export"> Export </button>
                        </form>
                    </div>
                </section>
            </div>

            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped mb-none table-advanced">
                                    <thead>
                                        <tr>
                                            <th> Title </th>
                                            <th> Stock Number </th>
                                            <th> VDP URL </th>
                                            <th> No of Engagement </th>
                                            <th> Availability </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($engaged_data as $key => $value): ?>
                                            <tr>
                                                <td> <?=$value['title']?> </td>
                                                <td> <?=$value['stock_number']?> </td>
                                                <td>
                                                    <a href="<?=$value['url']?>" target="_blank">
                                                        <i><?=$value['url']?></i>
                                                    </a>
                                                </td>
                                                <td style="text-align: center"> <?=$value['count']?> </td>
                                                <td> <?=$value['availability']?> </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>

                                <table id="export-table" style="display: none">
                                    <tr>
                                        <th> Title </th>
                                        <th> Stock Number </th>
                                        <th> VDP URL </th>
                                        <th> No of Engagement </th>
                                        <th> Availability </th>
                                    </tr>
                                <?php
                                foreach ($engaged_data as $key => $value) {
                                ?>
                                    <tr>
                                        <td> <?=$value['title']?> </td>
                                        <td> <?=$value['stock_number']?> </td>
                                        <td> <?=$value['url']?>  </td>
                                        <td> <?=$value['count']?> </td>
                                        <td> <?=$value['availability_export']?>  </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
?>

<script>
    $("#date_range").change(function () {
        if (this.value == "custom")
        {
            $("#custom_date_range").show();
        }
        else
        {
            $("#custom_date_range").hide();
        }
    });

    $( "#export" ).click(function() {
        $('table#export-table').csvExport(
        {
            title:'engaged_user_car'
        });
    });
</script>