<?php

	require_once '../config.php';
	require_once '../includes/loader.php';
	require_once '../includes/crm-defaults.php';

	require_once ADSYNCPATH . 'config.php';
	require_once ADSYNCPATH . 'Google/Util.php';
	require_once ADSYNCPATH . 'utils.php';
	require_once ADSYNCPATH . 'db_connect.php';

	$update_dealership_name 	= $_POST['update_dealership_name'];	
	$update_website_url 		= $_POST['update_website_url'];	
	$update_billing_address 	= $_POST['update_billing_address'];
	$update_city 				= $_POST['update_city_name'];
	$update_country 			= $_POST['update_country'];
	$update_sub_division_code 	= $_POST['update_sub_division_code'];
	$update_postal_code 		= $_POST['update_postal_code'];
	$update_billing_email 		= $_POST['update_billing_email'];

	$billingUpdateQuery 		= "UPDATE dealerships_billing 
	SET billaddrline1			= '$update_billing_address',
		billaddrcity			= '$update_city',
		billaddrcountry			= '$update_country',
		billaddrsubdivisioncode	= '$update_sub_division_code',
		billaddrpostalcode		= '$update_postal_code',
		billemaill 				= '$update_billing_email'
	WHERE dealership 			= '$update_dealership_name'";

	$billingUpdateQueryResult 	= DbConnect::get_instance()->query($billingUpdateQuery);
	
	if (!$billingUpdateQueryResult)
	{
		echo "Address update query failed for " . $dealership;
	}

	echo "Address update successful!";
