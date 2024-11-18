<?php
require_once 'config.php';
require_once 'includes/loader.php';
require_once 'includes/crm-defaults.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';


include 'bolts/header.php'
?>

<div class="inner-wrapper">

    <?php
    $select = 'ai-button-alert';
    include 'bolts/sidebar.php'
    ?>

    <section role="main" class="content-body">
        <header class="page-header">

        </header>
        <div class="row">
            <form id="filter-form" method="GET" class="form-horizontal form-bordered">
                <div class="col-lg-12">
                 
                </div>

                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                          
                        </header>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered table-striped mb-none table-advanced">
                                       
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
