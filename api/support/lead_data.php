<?php

$base_dir    = dirname(dirname(__DIR__));
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'utils.php';

$query = DbConnect::get_instance()->query("SELECT name, email, phone, at FROM smart_offer_customer_fillups JOIN smart_offer_customers ON smart_offer_customer_fillups.uuid=smart_offer_customers.uuid  WHERE dealership = 'recar'");
while ($car = mysqli_fetch_assoc($query)) {
    print_r(unserialize($car['at'])) . '<br>';
}