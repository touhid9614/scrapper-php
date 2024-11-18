<?php
    require_once 'config.php';
    require_once 'includes/loader.php';
    
    session_start();
    
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'Facebook/Fb.php';
    
    global $fb_config, $fb_access_token, $CronConfigs;

    $cron_name = isset($_GET['dealership']) ? filter_input(INPUT_GET, 'dealership') : null;

    if ($cron_name)
    {
        $cron_config = $CronConfigs[$cron_name];
    }
    else
    {
        $cron_config = $CronConfigs[0];
    }
    
    $fb = new Fb($fb_config['app_id'], // App ID
    $fb_config['app_secret'], $fb_access_token, null /* Account Id */, null /* Page Id */, null /* Pixel Id */, null, null, $cron_config);
    
    if (filter_input(INPUT_GET, 'code'))
    {
        $fb_access_token = $fb->getAccessToken();
    }

    include 'bolts/header.php'
?>

<div class="inner-wrapper">
    
    <?php 
    $select = 'fb-status';  include 'bolts/sidebar.php' 
    ?>
    
    <section role="main" class="content-body">
        <header class="page-header">
            
        </header>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">Facebook Access Status</h2>
                    </header>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if(!$fb_access_token || !$fb->isValidAccessToken()) { ?>
                                <p class="lead text-danger">Facebook API is not connected</p>
                                <a class="btn btn-facebook" href="<?php echo $fb->getLoginUrl(); ?>">Connect Now</a>
                                <?php } else { $token_status = $fb->getTokenStatus(); $user_details = $fb->getUserDetails(); ?>
                                <p class="lead text-success">Facebook API is connected using profile <b><?php echo $user_details->name ?></b>. Expires at <b><?php echo date_format($token_status->getField('expires_at'), 'Y-m-d H:i:s') ?></b></p>
                                <a class="btn btn-facebook" href="<?php echo $fb->getLoginUrl(); ?>">Renew Now</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php include 'bolts/footer.php';