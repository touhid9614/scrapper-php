<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    
    session_start();
    
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';
    
    global $CronConfigs, $scrapper_configs, $connection;
    
    $cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));
    
    $db_connect = new DbConnect($cron_name, $connection);

    
    mysqli_close($connection);
        
    include 'bolts/header.php'
?>

<div class="inner-wrapper">
    
    <?php $select = 'button-overall';  include 'bolts/sidebar.php' ?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel panel-info">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Overall Button Status</h2>
                    </header>
                    <div class="panel-body">
                         
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php include 'bolts/footer.php';