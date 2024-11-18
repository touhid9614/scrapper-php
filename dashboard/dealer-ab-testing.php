<?php

global $user;
error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once '../includes/init-db.php';

use sMedia\AbTest\AbTestController;

$dealership = $user['cron_name'];
$abTest = new AbTestController($dealership, null, '../ab-test');

if (isset($_POST)) {
    $abTest->updateConfig($_POST);
}

$db_connect = new DbConnect('');
$all_dealerships = $db_connect->get_all_dealers(1);

include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
    $select = 'dealer-ab-testing';
    include 'bolts/sidebar.php'
    ?>
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <div class="row">
            <div class="col-lg-12">

                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> Configuration Panel </h2>
                    </header>

                    <div class="panel-body">
                        <form method="GET" class="form-inline">
                            <label class="  mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
                            &nbsp; &nbsp;
                            <select class="form-control mb-2 mr-sm-2 mb-sm-0 populate" name="dealership" id="dealership" data-plugin-selectTwo>
                                <?php
                                if ($user['type'] == 'a') {
                                    foreach ($all_dealerships as $dealer) {
                                        $selected = ($dealership == $dealer['dealership']) ? ' selected' : '';
                                ?>
                                        <option value="<?= $dealer['dealership'] ?>" <?= $selected ?>><?= $dealer['dealership'] ?></option>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <option value="<?= $user['cron_name'] ?>" <?= ' selected' ?>><?= $user['cron_name'] ?> </option>
                                <?php
                                } ?>
                            </select>

                            <button class="btn btn-primary ml-md"> Submit</button>
                        </form>
                    </div>
                </section>

                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> Available A\B Testing Option <strong><?= strtoupper($dealership) ?></strong></h2>
                    </header>

                    <div class="panel-body">
                        <form method="POST" class="form-horizontal form-bordered">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-sm-5 " style="text-align: center">
                                            <h4><b>Testing Group</b></h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <h4><b>Testing Option</b></h4>
                                        </div>
                                    </div>
                                    <?php
                                    if ($abTest->haveTests) {
                                        foreach ($abTest->getOptions() as $test_name => $test_configs) {
                                            ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label"></label>
                                                <div class="col-sm-3">
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="test-<?= $test_name ?>" class="ab-test" value="true" type="checkbox" name="<?= $test_name ?>[active]" <?= $test_configs['active'] ? 'checked' : '' ?> />
                                                        <label for="test-<?= $test_name ?>"><?= $test_configs['name'] ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="options-<?= $test_name ?>">
                                                    <?php
                                                    foreach ($test_configs['options'] as $test_option => $option_config) {
                                                    ?>
                                                        <div class="checkbox-custom chekbox-primary">
                                                            <input id="<?= $test_name ?>-<?=$test_option ?>" value="true" type="checkbox" name="<?= $test_name ?>[options][<?= $test_option ?>]" <?= $option_config['active'] ? 'checked' : '' ?> />
                                                            <label for="<?= $test_name ?>-<?=$test_option ?>"><?= $option_config['name'] ?></label>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "<h3>No A\B Test found. . . </h3>";
                                    }
                                    ?>

                                    <div class="form-group">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                            <button class="btn btn-primary ">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';