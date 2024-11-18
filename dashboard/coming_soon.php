<?php

	require_once 'config.php';
    require_once 'includes/loader.php';
    require_once 'includes/crm-defaults.php';

    # ini_set('display_errors', 1);
    # ini_set('display_startup_errors', 1);
    # error_reporting(E_ALL);

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    include 'bolts/header.php'
?>


    <div class="inner-wrapper">
			<div class="alert alert-info user">
			<h1>Coming Soon!</h1> 
			<h3>Our team has taken your feedback to heart and we are launching our new dashboard soon. We are going to include engaged user statistic correlations, break downs and tools for comparing the ROI of campaigns.</h3>
			<br>
			<br>
			<br>
			<h4>If you have any ideas or things you would like to see in our dashboard please reach out to your account manager or email our CEO <strong>Marshal Finch</strong> (<i>marshal@smedia.ca</i>)</h4>
		</div>

	</div>


<style type="text/css">
	.user
	{
		margin-left: 15%;
		margin-right: 15%;
		margin-top: 5%;
		padding: 5%;
		text-align: center;
	}
</style>

<?php
    include 'bolts/footer.php';