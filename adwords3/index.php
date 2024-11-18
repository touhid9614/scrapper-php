<?php
session_start();
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
	require_once('Google/TokenHelper.php');
	require_once('Google/Types.php');
	require_once('Google/SessionManager.php');
	require_once('Google/Util.php');
	require_once('Google/Adwords.php');
	require_once('Google/Consts.php');

	global $customer, $access_token, $token_helper, $google_config , $google_config_new;

	if (!$access_token || filter_input(INPUT_GET, 'refresh')) {
		$_SESSION['customer'] = $customer;

		echo "<script>window.location.href=\"" . $token_helper->GetRequestURL($google_config_new[$customer]) . "\"</script>";
	} else if ($customer) {
		echo "<h1>Already Authorized.</h1>";
	}
?>

</body>

</html>
