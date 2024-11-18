<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    
    session_start();
    
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';

    require_once 'includes/debugger.php';

    global $debugger, $user;
    
    $cron_name = $user['cron_name'];

    /**
     * Set Tasks for Debugger and Run it
     *******************************************************************/    
    $PriceNotPicked = new PriceNotPicked();
    $FBFeedMissingStyle = new FBFeedMissingStyle();
    $FBFeedMissingTemplate = new FBFeedMissingTemplate();

    //$debugger->Register($PriceNotPicked);
    //$debugger->Register($FBFeedMissingStyle);
    //$debugger->Register($FBFeedMissingTemplate);

    $debugger->Debug($cron_name);
    /**
     * End Debugger
     */
    
    include 'bolts/header.php'
?>

<div class="inner-wrapper">
    
    <?php $select = 'button-debugger';  include 'bolts/sidebar.php' ?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            <h2 class="panel-title">Button Debugger</h2>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">AI Button Status</h2>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                               
                               <?php echo $debugger->getResult(); ?>
   
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php include 'bolts/footer.php';