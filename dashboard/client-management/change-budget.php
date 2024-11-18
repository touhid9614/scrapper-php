<?php

	require_once '../config.php';
	require_once '../includes/loader.php';
	require_once '../includes/crm-defaults.php';

	require_once ADSYNCPATH . 'config.php';
	require_once ADSYNCPATH . 'Google/Util.php';
	require_once ADSYNCPATH . 'utils.php';
	require_once ADSYNCPATH . 'db_connect.php';

	$dealership_data 		= $_POST['dealership_data'];
	$dealership_data 		= json_decode($dealership_data, true);
	$len  					= sizeof($dealership_data);

	for ($i=0; $i < $len; $i++)
	{
		$dealership 		= $dealership_data[$i]['dealership'];
		$url 				= $dealership_data[$i]['url'];
		$linedescription 	= $dealership_data[$i]['linedescription'];
		$budget 			= $dealership_data[$i]['budget'];
		$lineamount 		= $dealership_data[$i]['lineamount'];

		$addressUpdateQuery = "UPDATE dealerships_invoice_data
		SET budget			= '$budget',
			lineamount		= '$lineamount'
		WHERE dealership 	= '$dealership'
		AND url 			= '$url'
		AND linedescription = '$linedescription'";

		$result 			= DbConnect::get_instance()->query($addressUpdateQuery);

		if (!$result)
		{
			echo "Budget update query failed for " . $dealership . " where Line_Description = " . $linedescription;
		}
	}

	DbConnect::store_log($user_id, $user['type'], 'Dealer change budget', 'Dealer budget form change where dealer name- ' . $dealership, $dealership);

	echo "Budget update successful!";
