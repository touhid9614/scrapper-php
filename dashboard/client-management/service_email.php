<title>sMedia</title>
<link rel="shortcut icon" href="http://tm.smedia.ca/dashboard/assets/images/cropped-ICON-SMEDIA-32x32.png" type="png" sizes="32x32" alt="Smedia logo">
<style>

html,
body {
  height: 100%;
}

body {
  font: 600 18px/1.5 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
  /* background-color: #f69d75; */
  background-image: url(https://smedia.ca/wp-content/uploads/2018/12/background-top.jpg);
  background-repeat:no-repeat;
  background-size: cover;
  color: #555555
}

a {
  color: inherit;
}

.container {
  display: grid;
  justify-content: center;
  align-items: baseline;
  height: 80vh;
  margin-top: 100px;
}

.show {
  background-color: #fff;
  padding: 1em 1.5em;
  border-radius: 3px;
  text-decoration: none;
 
}
.my-div{
    padding: 5px 15px;
}


</style>
<?php

$base_dir = dirname(dirname(__DIR__));

require_once "$base_dir/adwords3/db_connect.php";
require_once "$base_dir/dashboard/includes/email_verification.php";
require_once "$base_dir/adwords3/config.php";
require_once "$base_dir/adwords3/utils.php";
require_once "$base_dir/dashboard/client-management/configUpdater.php";


use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;
use PhpParser\Node\Name;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\PrettyPrinter;

$token = htmlspecialchars($_GET["key"]);
$message;

$query = "SELECT * FROM email_verifications where match_key = '$token'";

$result = DbConnect::get_instance()->query($query);
$tokenInfo = mysqli_fetch_assoc($result);

$dealership = $tokenInfo['dealership'];
$service = $tokenInfo['service'];

if (!empty($tokenInfo)) {

    $date = strtotime($tokenInfo['date_time']);
    $checkDate = date('Y-m-d', strtotime("+7 day", $date));
    $date_now = date("Y-m-d");

    if ($checkDate >= $date_now) {

        $query = "UPDATE email_verifications SET varified='1' where match_key = '$token'";
        $result = DbConnect::get_instance()->query($query);

        $allVES = getAllVES($dealership, $service);

        $flag = true;
        while ($row = mysqli_fetch_array($allVES)) {
            if ($row['varified'] == 0) {
                $flag = false;
                break;
            }
        }
        if ($service == 'forward_to') {
            $flag = true;
        }
        if ($flag) {

            $config_file_name = "$base_dir/adwords3/config/$dealership.php";
            $code = file_get_contents($config_file_name);




            $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

            try {
                $ast = $parser->parse($code);
            } catch (Error $error) {
                echo "Parse error: {$error->getMessage()}\n";
                // return 'hello';
            }


            $traverser = new NodeTraverser();
            if ($tokenInfo['service'] == 'forward_to') {

                include $config_file_name;
                $lead_arr = $CronConfigs[$dealership]['lead'];
                $lead_arr['live'] = true;

                $traverser->addVisitor(new configUpdater([
                    'key' => ['lead'],
                    'value' => $lead_arr
                ]));
            } else {
                $traverser->addVisitor(new configUpdater([
                    'key' => ['form_live'],
                    'value' => true
                ]));
            }


            $ast = $traverser->traverse($ast);
            $prettyPrinter = new ePrinter();
            $config_file_content = $prettyPrinter->prettyPrintFile($ast);
            $config_file = fopen($config_file_name, "w");
            fwrite($config_file, $config_file_content);
            fclose($config_file);

            if ($service == 'forward_to') {
                $message = "Successful!!<br> Thanks for activation. Your Smart Offer Service is now active.";
            } else {
                $message = "Successful!!<br> Thanks for activation. Your Form Live Service is now active.";
            }
        } else {
            $message = "Successful!!<br> Thanks for activation. Your Form Live Service will be active soon.";
        }

    } else {
        $message = "Sorry!!<br> Something is wrong. This link is expired. Please contact the related person for more info. Thanks.";
    }

} else {
    $message = "Sorry!!<br> Something is wrong. This link is not valid. Please contact the related person for more info. Thanks.";
}



?>
<div class="container">
    <div class="show">
    <a href="https://smedia.ca"><img src="http://tm.smedia.ca/dashboard/assets/images/logo.png"/></a>
    <hr>
    <div class="my-div"><?= $message ?></div>
    </div>
</div>