<?php

use sMedia\Config\Conf;
use sMedia\Config\GoogleConf;
use sMedia\Google\Authenticator;
use sMedia\Google\ShortCut\Get;
use sMedia\Google\Utils;

require_once 'config.php';

$Configs  = Utils::loadTokenConfig(Conf::GOOGLE_TOKEN_PATH);
$accounts = GoogleConf::accounts();
$account_names = array_keys($accounts);
$customer = Get::Customer('');
$link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!empty($customer)) {
	$helper   = new Authenticator();
	$global_logfile = __DIR__ . '/ng_logs/global_log.txt';

	try {
		$access_token = $helper->GetAccessToken(GoogleConf::account($customer), true, $global_logfile);
		file_put_contents($global_logfile, time() . " $customer : Token create successfully \n", FILE_APPEND);
	} catch (Exception $ex) {
		file_put_contents($global_logfile, time() . " $customer : Their is a error when token create\n", FILE_APPEND);
	}

	if ($access_token) {
		Utils::saveTokenFor($customer, $access_token, Conf::GOOGLE_TOKEN_PATH);
		$msg = "Access token updated for {$customer} and stored.";
		echo $msg;
		file_put_contents($global_logfile, time() . " $msg\n", FILE_APPEND);
	} else {
		$msg = "Unable to update access token for {$customer}.";
		echo $msg;
		file_put_contents($global_logfile, time() . " $msg\n", FILE_APPEND);
	}
} else {
?>
	<!DOCTYPE html>
	<html>

	<body>
		<form action="<?= $link ?>" method="GET">
			<label>Select account</label>
			<select name="customer">
				<?php
				echo implode('', array_map(function ($s) {
					return "<option value='$s'>$s</option>";
				}, $account_names));
				?>
			</select>
			<?php
			echo implode('', array_map(function ($g) {
				return "<input type='hidden' name='$g' value='" . $_GET[$g] . "'>";
			}, array_keys($_GET)));
			?>
			<button type="submit">Submit</butto>
		</form>
	</body>

	</html>
<?php
}
