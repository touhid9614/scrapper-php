<?php
// @apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);

ignore_user_abort(true);
set_time_limit(0);

session_start();

use sMedia\Config\GoogleConf;
use sMedia\Google\Authenticator;
use sMedia\Google\ShortCut\Get;

ob_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>AdWords Cron Configuration</title>

	<style type="text/css">
		.txtn {
			width: 320px;
			padding: 2px;
		}

		.subt {
			margin: 10px 0px;
			width: 150px;
			height: 32px;
		}

		.ed {
			border: 1px solid #3F6;
			color: #0C3;
			padding: 10px;
		}

		.txtl {
			width: 646px;
			height: 200px;
			resize: vertical;
			padding: 10px;
		}

		.wrapper {
			margin: 100px 200px;
			width: 700px;
			overflow: hidden;
		}
	</style>
</head>

<body>

	<?php
	require_once('config.php');
	$customer = Get::Customer('marshal');
	$current_token = Authenticator::getTokenFor($customer, true);
	$google_config = GoogleConf::account($customer);

	if ($google_config == null) {
		die("<h1>Error: No google configuration found for $customer.</h1>");
	}

	if (!$current_token || filter_input(INPUT_GET, 'refresh')) {
		$url = Authenticator::getInstance()->GetRequestURL($google_config);
		echo "<script>window.location.href = \"" . Authenticator::getInstance()->GetRequestURL($google_config) . "\";</script>";
	} else if ($customer) {
		echo "<h1>Already Authorized.</h1>";
	}
	?>

</body>

</html>
