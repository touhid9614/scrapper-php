<?php

	require_once 'config.php';
	require_once 'includes/loader.php';
	require_once 'includes/crm-defaults.php';

	session_start();

	require_once ADSYNCPATH . 'config.php';
	require_once ADSYNCPATH . 'Google/Util.php';
	require_once ADSYNCPATH . 'utils.php';
	require_once ADSYNCPATH . 'db_connect.php';
	require_once 'includes/debugger.php';

    global $debugger, $user;
    $cron_name = $user['cron_name'];

    $FBFeedMissingStyle    	= new FBFeedMissingStyle();
	$FBFeedMissingTemplate 	= new FBFeedMissingTemplate();
	$InvalidImage 			= new InvalidImage();
	//$InvalidTemplateFile 	= new InvalidTemplateFile();
	$PriceNotPicked        	= new PriceNotPicked();
	$SpecialCharacterCheck 	= new SpecialCharacterCheck();

	$debugger->Register($FBFeedMissingStyle);
	$debugger->Register($FBFeedMissingTemplate);
	$debugger->Register($InvalidImage);
	//$debugger->Register($InvalidTemplateFile);
	$debugger->Register($PriceNotPicked);
	$debugger->Register($SpecialCharacterCheck);
	$debugger->Debug($cron_name);

	include 'bolts/header.php';
        
        //Get ai buttons log
        $error_message = "";
        $log_path = ADSYNCPATH . 'caches/ai-button-log/' . $cron_name . '.txt';
        if(file_exists($log_path)) {
            $error_message  = file_get_contents($log_path);
        } else {
            $error_message = "No log file found";
        }

?>


	<div class="inner-wrapper">
		<?php
			$select = 'debug-report';
			include 'bolts/sidebar.php'
		?>

	    <section role="main" class="content-body">
	        <header class="page-header">
	            <h2 class="panel-title"> Debug Result For This Dealership <?php $cron_name ?> </h2>
	        </header>

	        <div class="panel-body">
	                    <div class="row">
	                        <div class="col-md-12">
	                        	<?= $debugger->getResult(); ?>
                                        <div class="alert alert-danger"><strong>AI Button Error Log</strong><p> <?= $error_message ?> </p></div>
	                        </div>
	            </div>
	        </div>
	    </section>
	</div>


<?php
	include 'bolts/footer.php';