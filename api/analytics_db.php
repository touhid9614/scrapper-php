<?php

$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";
require_once $adwords_dir . 'config.php';
$db_config['db_name'] = 'analytics';
require_once $adwords_dir . 'db_connect.php';

DbConnect::get_instance()->query("TRUNCATE TABLE accumulated_clicks;");

$init   = 1005000;
$length = 1000;

while (1) {
	$get_events = DbConnect::get_instance()->query("SELECT viewId, value FROM events WHERE action='Click' LIMIT $init,$length");
	echo "offset: " . $init;
	print_r($get_events);
	$noof_rows = mysqli_num_rows($get_events);
	if ($noof_rows) {
		/*  // This should have been moved outside this check
          // Puting it in here will cause it to ignore very last query if the result set is less than 100 which is expected for the last page of the query
          // This problem has been fixed by below condition */
		while ($row = mysqli_fetch_assoc($get_events)) {
			$viewId = $row['viewId'];
			$click_value = $row['value'];
			$get_aclicks = DbConnect::get_instance()->query("SELECT viewId, value FROM accumulated_clicks WHERE viewId='$viewId'");
			if (mysqli_num_rows($get_aclicks)) {
				$value = mysqli_fetch_assoc($get_aclicks)['value'] + 1;
				DbConnect::get_instance()->query("UPDATE accumulated_clicks SET value = '$value' WHERE viewId='$viewId'");
			} else {
				DbConnect::get_instance()->query("INSERT INTO accumulated_clicks(viewId,value) VALUES('$viewId', '$click_value')");
			}
		}
	}

	// Break when limit is less than 100
	if ($noof_rows < $length) {
		break;
	}
	$init += $length;
}
