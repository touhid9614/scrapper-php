<?php
include_once('../tradeScan/db.php');
$servername = $db_config['db_host_name'];
$username = $db_config['db_user'];
$password = $db_config['db_pass'];
$dbname = $db_config['db_name'];

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
