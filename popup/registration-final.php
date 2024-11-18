<?php

define('REGISTRATION_COMPLETE_PAGE', true);
error_reporting(E_ERROR | E_PARSE);

$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'db_connect.php';
require_once $adwords_path . 'config.php';
require_once $adwords_path . 'utils.php';

$db_connect = new DbConnect('');
$error      = "Please contact to support team for complete the registration.";

if (isset($_POST['url']) && isset($_POST['company_name']) && isset($_POST['username']) && isset($_POST['userEmail']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $domain           = $_POST['url'];
    $name             = $_POST['company_name'];
    $dealership       = $_POST['username'];
    $userEmail        = $_POST['userEmail'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $success          = true;

    $query      = "SELECT * from covid19login where email = '$userEmail';";
    $result     = $db_connect->query($query);
    $emailCheck = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (isset($emailCheck['name'])) {
        $success = false;
        $error   = "It looks like you already have an account";
    } else {
        if ($password == $confirm_password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $queryInsert  = "INSERT INTO covid19login (name, dealership,domain, email, password) VALUES ('$name', '$dealership', '$domain','$userEmail', '$passwordHash')";
            $db_connect->query($queryInsert);

            session_start();
            $_SESSION["smedia_popup_email"]      = $userEmail;
            $_SESSION["smedia_popup_name"]       = $name;
            $_SESSION["smedia_popup_userType"]   = 'd';
            $_SESSION["smedia_popup_dealership"] = $dealership;
            $_SESSION["smedia_popup_success"]    = true;
            setcookie("smedia_popup_remember", 'yes', time() + (30 * 24 * 3600));

            $email   = ['trevor@smedia.ca', 'rabbi@smedia.ca'];
            $from    = "smartmemo@smedia.ca";
            $subject = "COVID-19 SmartMemo New Registration";
            $message = "<b>Hello</b>,<br><p>Dealer registration to COVID-19 SmartMemo. Dealer Info ::</p><br> Dealer Domain : <b>$domain</b><br> Dealer Name :  $name <br> Email : $userEmail <br><br> Thanks.";
            SendEmail($email, $from, $subject, $message);

            $email   = $userEmail;
            $from    = "smartmemo@smedia.ca";
            $cc      = ['trevor@smedia.ca'];
            $subject = "COVID-19 SmartMemo Confirmation email";
            $message = "<b>Hello $name</b>,<br><p>Thanks for signing up for COVID-19 SmartMemo, the free popup tool we’re offering during this global pandemic that’s affecting our industry.</p><p>SmartMemo has been specifically designed to help you communicate the most timely and important COVID-19 messaging to your website visitors right on your homepage.</p><p>You can manage the content of the popup right from within the tool’s easy to use admin dashboard, allowing you to keep it current with the most relevant, up to date information.</p><p>Since this is a tool you’ll likely be updating often as the situation changes, it’s a good idea to bookmark this page.</p><p><b>Login to your admin dashboard</b> <span style=\"color: #39ace7\">https://tools.smedia.ca/popup/login.php</span></p><br><p><b>Stay Safe,</b></p><p>Your partners at sMedia</p>";
            SendEmail($email, $from, $subject, $message, '', $cc);

            header("Location: popup-setting.php");

        } else {
            $success = false;
            $error   = "Password And Confirm Password are not same";
        }
    }

} else {
    $success = false;
    $error   = "Please Fill All the data.";
}

if (!$success) {
    $email   = ['trevor@smedia.ca'];
    $from    = "smartmemo@smedia.ca";
    $subject = "COVID-19 SmartMemo New Registration Fail";
    $message = "<b>Hello</b>,<br><p>Dealer registration to COVID-19 SmartMemo Fail. Dealer Info ::</p><br> Dealer Domain : <b>$domain</b><br> Dealer Name :  $name <br> Email : $userEmail <br><b>Message : $error</b> <br><br> Thanks.";
    SendEmail($email, $from, $subject, $message);
}
?>

<html>
<head>
    <title> Registration To sMedia popup Dashboard </title>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Web Fonts  -->
    <link href="https::////fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="./smedia.png" type="png" alt="Smedia logo">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <img src="logo.png" id="icon" alt="sMedia Logo"/>
        </div>
        <!-- Login Form -->
        <?php
        if ($success) {
        ?>
            <h3 class="mx-4">Registration Successful.</h3>
            <p>Please login.</p>
            <a class="mybutton fadeIn fifth" href="./login.php">Login </a>
        <?php
        } else {
        ?>
            <!--            <h3 class="mx-4">Registration is not Successful.</h3>-->
            <p class="mx-5"><?=$error?></p>
            <a class="mybutton fadeIn fifth" href="./login.php">Login </a>
        <?php
        }
        ?>

        <div id="formFooter">
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2020. All Rights Reserved.</p>
        </div>
    </div>
</div>
</body>
