<?php

require_once 'config.php';
require_once 'includes/loader.php';
global $user;

?>
<?php include 'bolts/header.php' ?>
<div class="inner-wrapper">
    <?php $select = 'Bounce Rate'; include 'bolts/sidebar.php' ?>
    <script> var bounce_rate_page = true; </script>
    <section role="main" class="content-body">
        <header class="page-header">
        </header>
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="fa fa-caret-down"></a>
                        </div>
                        <h2 class="panel-title">Bounce Rate</h2>
                        <p class="panel-subtitle">Average daily bounce rate for all dealerships</p>
                    </header>
                    <div class="panel-body">
                        <div class="chart chart-md" id="avgBounceRate"></div>
                    </div>
                </section>
            </div>   
        </div>
    </section>
</div>

<?php include 'bolts/footer.php';