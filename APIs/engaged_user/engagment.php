<?php

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';
require_once $base_path . '/adwords3/config.php';
require_once ADSYNCPATH . 'db_connect.php';

header("Access-Control-Allow-Origin: *");

$url = isset($_GET['url']) ? $_GET['url'] : null;
$day = isset($_GET['day']) ? $_GET['day'] : null;

if ($day) {
	$splitDay = explode('-', $day);

	if (count($splitDay) == 3) {
		if (!checkdate($splitDay[1], $splitDay[2], $splitDay[0]))   // checkdate(month, day, year)
		{
			http_response_code(404);
			echo json_encode(
				array("message" => "Invalid Day Format")
			);
			exit();
		}
	} else {
		http_response_code(404);
		echo json_encode(
			array("message" => "Invalid Day Format")
		);
		exit();
	}
}

if ($url) {
	$finalUrl = remove_http($url);

	if ($day) {
		$query = "SELECT SUM(COUNT) AS total FROM engaged_vdp WHERE vdp_url like '%$finalUrl%' and day = date($day);";
	} else {
		$query = "SELECT SUM(COUNT) AS total FROM engaged_vdp WHERE vdp_url like '%$finalUrl%';";
	}

	$result = DbConnect::get_connection_read()->query($query);

	if (mysqli_num_rows($result) > 0) {
		while ($engaged_user = mysqli_fetch_assoc($result)) {
			$all_dealers[$finalUrl] = $engaged_user['total'];
		}
	}

	mysqli_free_result($result);
	http_response_code(200);
	echo json_encode($all_dealers);
} else {
	http_response_code(404);
	echo json_encode(
		array("message" => "Pass the Url")
	);
}


/**
 * Removes scheme part and returns domain.
 *
 * @param      string  $url    The url
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function remove_http($url)
{
	// If not have http:// or https:// then prepend it
	if (!preg_match('#^http(s)?://#', $url)) {
		$url = 'https://' . $url;
	}

	$urlParts = parse_url($url);

	// Remove www.
	$domain_name = preg_replace('/^www\./', '', $urlParts['host']);

	// Output
	return $domain_name;
}
