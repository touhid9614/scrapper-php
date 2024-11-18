<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$show_msg   = false;
$msg        = '';
$db_connect = new DbConnect('');
$all_names  = $db_connect->getCronNames();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$dealer = filter_input(INPUT_POST, 'dealer');
	$dealer_action = filter_input(INPUT_POST, 'dealer_action');

	switch ($dealer_action) {
        case 'clear-db':
        	$show_msg = true;
        	$time_now = time();
            $db_connect->query("UPDATE {$dealer}_scrapped_data SET deleted = 1, deleted_at = {$time_now}, manually_deleted_at = {$time_now} WHERE deleted = 0;");
        	$msg = "All active vehicles of <i>{$dealer}</i> has been marked as manually sold.";
        	break;
        case 'purge-dealer':
            $query1 = "DELETE FROM dealerships WHERE dealership = '{$dealer}';";
            $query2 = "DELETE FROM dealer_domain_meta_data WHERE meta_value LIKE '%{$dealer}%';";
            $query3 = "DROP TABLE IF EXISTS {$dealer}_scrapped_data;";
            $query4 = "DROP TABLE IF EXISTS {$dealer}_rank_data;";
            $query5 = "DROP TABLE IF EXISTS {$dealer}_cartrack_data;";
            $query6 = "DROP TABLE IF EXISTS {$dealer}_source_data;";
            $query7 = "DROP TABLE IF EXISTS tbl_adwords_keyword_{$dealer};";

            $db_connect->query($query1);
            $db_connect->query($query2);
            $db_connect->query($query3);
            $db_connect->query($query4);
            $db_connect->query($query5);
            $db_connect->query($query6);
            $db_connect->query($query7);

            $config_path  = get_config_path($dealer);
            $sconfig_path = str_replace('/config/', '/scrapper-config/', $config_path);

            unlink($config_path);
            unlink($sconfig_path);

            $msg = "<i>{$dealer}</i> is no longer with us!!!";
        case 'run-cron':
            $show_msg = true;
            break;
        case 'stop-cron':
        	$show_msg = true;
        	break;
        case 'rerun-cron':
        	$show_msg = true;
        	break;
        default:
        	break;
    }
}

$db_connect->close_connection();

include 'bolts/header.php';
?>

<div class="inner-wrapper">

<?php
$select = 'dealer-ops';
include 'bolts/sidebar.php';
?>
    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <form id="filter-form" method="POST" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Dealer Operations </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row mb-md">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> Dealership </label>
                                        <div class="col-sm-9">
                                            <select data-plugin-selectTwo class="form-control populate" name="dealer">
                                                <option value="">-- Select --</option>
                                                <?php
                                                foreach ($all_names as $value) {
                                                ?>
                                                    <option value="<?= $value ?>" <?= $dealer == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> Actions </label>
                                        <div class="col-sm-9">
                                            <select data-plugin-selectTwo class="form-control populate" name="dealer_action">
                                                <option value="">-- Select --</option>
                                                <option value="clear-db"> Clear DB </option>
                                                <option value="purge-dealer"> Purge Dealer </option>
                                                <option value="run-cron" disabled="true"> Run Cron </option>
                                                <option value="stop-cron" disabled="true"> Stop Cron </option>
                                                <option value="rerun-cron" disabled="true"> Stop and Run Cron </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-md">
                                <div class="col-md-6 col-sm-12"> </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8 clearfix">
                                            <button id="btn-filter" type="submit" class="btn btn-info mr-xs pull-right ml-xs"> Execute Action </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>

            <?php if ($show_msg) { ?>
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                           <h3> <?= $msg ?> </h3>
                        </div>
                    </div>
                </div>
            </div>
        	<?php } ?>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
?>