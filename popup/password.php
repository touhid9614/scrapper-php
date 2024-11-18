<?php

$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'db_connect.php';

$db_connect = new DbConnect('');

echo '<h3>Default Password Generated for All Active Dealer <br></h3>';
echo '<h4>Password ::<b> Dealer#123 </b></h4>';

$allDealers = $db_connect->get_all_dealers();

foreach ($allDealers as $dealer => $data) {
    $password   = password_hash('Dealer#123', PASSWORD_DEFAULT);
    $query      = "Select * from users where dealership = '$dealer'";
    $result     = $db_connect->query($query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $id    = $row['id'];
        $email = $row['email'];

        $queryUpdate  = "UPDATE users SET pass_hash='$password' where id = '$id';";
        $resultUpdate = $db_connect->query($queryUpdate);
        echo "Password change for :: $dealer  Email:: $email <br>";
    }
}
