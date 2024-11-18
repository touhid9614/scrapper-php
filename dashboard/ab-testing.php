<?php

error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$ab_path = dirname(dirname(__FILE__)) . '/ab-test/tests/';
$files = scandir($ab_path);
$flag = false;
foreach ($files as $file) {
    if (preg_match("/php/", $file, $match)) {
        require_once $ab_path . $file;
        $flag = true;
    }
}

include 'bolts/header.php';
?>

<div class="inner-wrapper">

    <?php
    $select = 'ab-testing';
    include 'bolts/sidebar.php'
    ?>
    <section role="main" class="content-body">
        <header class="page-header"></header>
        <div class="row">
            <div class="col-lg-12">

                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title"> All A\B Testing Option </h2>
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
                                    if ($flag) {
                                        foreach ($all_ab_tests as $ab => $value) {
                                    ?>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?= $value['name'] ?></label>
                                                <div class="col-sm-2">
                                                    <div class="checkbox-custom chekbox-primary">
                                                        <input id="vdp-install_analytics" value="true" type="checkbox" name="<?= $ab ?>" disabled <?= $value['active'] ? 'checked' : '' ?> />
                                                        <label for="vdp-install_analytics"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php
                                                    foreach ($value['option'] as $option => $item) {
                                                    ?>
                                                        <div class="checkbox-custom chekbox-primary">
                                                            <input id="vdp-fbq-pageview" value="pageview" type="checkbox" name="<?= $option ?>" disabled <?= $item['active'] ? 'checked' : '' ?> />
                                                            <label for="vdp-fbq-pageview"><?= $item['name'] ?></label>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    } else {
                                        echo "<h3>No A\B Testing found. . . </h3>";
                                    }
                                    ?>
                                    <!--
                                        <div class="form-group">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <button class="btn btn-primary ">Update</button>
                                            </div>
                                        </div>
                                        -->
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
