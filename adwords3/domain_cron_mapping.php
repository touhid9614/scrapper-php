<?php

require_once 'config.php';
require_once 'utils.php';
require_once 'db_connect.php';
require_once 'cron_misc.php';
require_once 'Google/Util.php';


$str = <<<EOF
<form method="post">
        <label>URL</label></br>
        <input type="test" name="domain"></br>
        <label>Cron name</label></br>
        <input type="test" name="cron"></br></br></br>
        <button type="submit" name="submit">Update</button></br>
        </form>
EOF;
echo $str;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $domain = getDomain(filter_input(INPUT_POST, 'domain', FILTER_SANITIZE_URL));
        $cron_name = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['cron']);

        global $connection;

        $db_connect = new DbConnect('');
        $db_connect->update_meta('dealer_domain', $domain, $cron_name);
        $db_connect->close_connection(DbConnect::CLOSE_WRITE_CONNECTION);
    }
}





