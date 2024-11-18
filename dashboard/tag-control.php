<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

$db_connect    = new DbConnect('');
$dealer_list   = $db_connect->getCronNames();

?>

<div class="inner-wrapper">
    <?php
    $select = 'tag-control';
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
                            <h2 class="panel-title"> Tag Control </h2>
                        </header>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"> Dealership </label>
                                        <div class="col-md-9">
                                            <select data-plugin-selectTwo class="form-control populate" name="dealership" style="width: 50%">
                                                <option value="">-- Select --</option>
                                                <?php
                                                foreach ($dealer_list as $value) {
                                                ?>
                                                    <option value="<?= $value ?>" <?= $dealership == $value ? 'selected' : '' ?>><?= $value ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12"> </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8 clearfix">
                                            <button id="btn-filter" type="submit" class="btn btn-info mr-xs pull-right ml-xs">Apply Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>

        <div class="row">
            
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';