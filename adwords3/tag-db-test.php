<?php

$adwords_dir = "";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'uuid.php';

$dealership = 'titanauto';

$user_unique_id = '9f048779-70fa-4cf4-a823-ead19bdcf7c9';

if (!$user_unique_id) {
	$user_unique_id = UUID::v4();
	$customer = get_customer_by_uuid($user_unique_id);
	/* This loop shall gurantee a UUID */
	while ($customer !== false) {
		$user_unique_id = UUID::v4();
		$customer = get_customer_by_uuid($user_unique_id);
	}
	//We don't know customer's name, email and phone number yet
	create_customer($user_unique_id);
}

customer_add_view($user_unique_id, $dealership);
