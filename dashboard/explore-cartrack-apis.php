<?php

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

require_once dirname(__DIR__) . '/cartracker/car_tracker.php';

global $scrapper_configs, $CronConfigs;

$dealership_list = array_intersect(array_keys($scrapper_configs), array_keys($CronConfigs));
$dealer = filter_input(INPUT_GET, 'dealer');
$db_connect  = new DbConnect('');

include 'bolts/header.php';
?>

<div class="inner-wrapper">

<?php
$select = 'cartrack-apis';
include 'bolts/sidebar.php';
?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <form id="filter-form" method="GET" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                    <section class="panel panel-info">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title"> Car Tracker APIs </h2>
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
                                                foreach ($dealership_list as $value) {
                                                ?>
                                                    <option value="<?= $value ?>" <?= $dealer == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                <?php
                                                }
                                                ?>
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
                                            <button id="btn-filter" type="button" class="btn btn-info mr-xs pull-right ml-xs"> Generate API </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
?>