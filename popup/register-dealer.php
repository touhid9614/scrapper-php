<?php
session_start();

if (isset($_SESSION["smedia_popup_email"]) && $_SESSION["smedia_popup_email"]) {
    if (!isset($_COOKIE['smedia_popup_remember'])) {
        header("Location: logout.php");
    }
} else {
    header("Location: login.php");
}

$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'config.php';
require_once $adwords_path . 'db_connect.php';
require_once $adwords_path . 'utils.php';
require_once $adwords_path . 'tag_db_connect.php';

$email      = $_SESSION["smedia_popup_email"];
$name       = $_SESSION["smedia_popup_name"];
$dealership = $_SESSION["smedia_popup_dealership"];
$userType   = $_SESSION["smedia_popup_userType"];

if ($userType != 'a') {
    header("Location: popup-setting.php");
}
$data       = array();
$db_connect = new DbConnect('');
$query      = "SELECT * from covid19login;";
$result     = $db_connect->query($query);
$i          = 1;
while ($details = mysqli_fetch_assoc($result)) {

    if ($details['userType'] == 'd') {
        $data[$i]['count']    = $i;
        $data[$i]['name']     = $details['name'];
        $data[$i]['cron']     = $details['dealership'];
        $data[$i]['domain']   = $details['domain'];
        $data[$i]['email']    = $details['email'];
        $data[$i]['reg_date'] = $details['createdAt'];
        $meta                 = (array) get_meta('popup_config', $details['dealership']);
        $data[$i]['status']   = !empty($meta['live']) ? true : false;
        $i++;
    }
}
?>

<html>

<head>
    <title> sMedia popup Dashboard </title>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Web Fonts  -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="setting-design.css">
    <link rel="shortcut icon" href="./smedia.png" type="png" alt="Smedia logo">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.0.4/jscolor.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
</head>

<body class="mb-5">
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="./smedia.png" width="30" height="30" class="d-inline-block align-top" alt="">
            sMedia
        </a>
        <?php
        if ($userType == "a") {
        ?>
            <a class="navbar-brand btn btn-outline-warning" href="./popup-setting.php">
                Setting
            </a>
        <?php
        }
        ?>
        <a class="navbar-brand btn btn-outline-warning" href="./logout.php">
            Logout
        </a>
    </nav>
    <div class="container">
        <div class="header-popup mb-3">
            <h3 class="mb-1"> Welcome <?= $name ?></h3>
        </div>
        <div class="mx-4 ">
            <p>List of dealer who use COVID-19 SmartMemo</p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="example" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name </th>
                            <th scope="col">Cron</th>
                            <th scope="col">Domain</th>
                            <th scope="col">Email</th>
                            <th scope="col">Live</th>
                            <th scope="col">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $item) {
                        ?>
                            <tr>
                                <th scope="row"><?= $item['count'] ?></th>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['cron'] ?></td>
                                <td><?= $item['domain'] ?></td>
                                <td><?= $item['email'] ?></td>
                                <?php
                                if ($item['status']) {
                                ?>
                                    <td style="color: green">Yes</td>
                                <?php
                                } else {
                                ?>
                                    <td style="color: red">No</td>
                                <?php
                                }
                                ?>
                                <td><?= $item['reg_date'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>