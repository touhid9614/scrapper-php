<?php
$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';
require_once $base_path . '/adwords3/config.php';
require_once ADSYNCPATH . 'db_connect.php';

header("Access-Control-Allow-Origin: *");

$query  = "SELECT * FROM dealerships";
$result = DbConnect::get_connection_read()->query($query);
$tag_state_dir  = dirname(ABSPATH) . '/tag-state/';
$tag_state_file = $tag_state_dir . $cron_name . '.any';
$all_dealers = [];

if (mysqli_num_rows($result) > 0) {
	while ($details = mysqli_fetch_assoc($result)) {
		extract($details);
		$tag_state_file = $tag_state_dir . $dealership . '.any';
		$tag_loaded = null;
		$tag_text = 'Not Installed';

		if (file_exists($tag_state_file)) {
			$tag_loaded = time() - filemtime($tag_state_file);

			if ($tag_loaded < 7 * 24 * 3600 && $tag_loaded > 24 * 3600) {
				$tag_text = 'Warning';
			} else if ($tag_loaded < 24 * 3600) {
				$tag_text = 'Installed';
			}
		}

		$vc_state_file = $tag_state_dir . $dealership . '.vc';
		$vc_loaded = null;
		$vc_text = 'Not Working';

		if (file_exists($vc_state_file)) {
			$vc_loaded = time() - filemtime($vc_state_file);

			if ($vc_loaded < 7 * 24 * 3600 && $vc_loaded > 24 * 3600) {
				$vc_text = 'Warning';
			} else if ($vc_loaded < 24 * 3600) {
				$vc_text = 'Working';
			}
		}

		$product_item = array(
			"id"           => $id,
			"company_name" => $company_name,
			"dealership"   => $dealership,
			"status"       => $status,
			"group_name"   => $group_name,
			"websites"     => $websites,
			"website_rep"  => unserialize($website_rep),
			"company_rep"  => unserialize($company_rep),
			"start_date"   => gmdate("Y-m-d", $start_date),
			"tag_text"     => $tag_text,
			"vc_text"      => $vc_text,
			"assigned_to"  => $assigned_to
		);

		array_push($all_dealers, $product_item);
	}

	mysqli_free_result($result);
	http_response_code(200);
	echo json_encode($all_dealers);
} else {
	http_response_code(404);

	echo json_encode(
		array("message" => "No products found.")
	);
}
