<?php
define('LOGIN_PAGE', true);
error_reporting(E_ERROR | E_PARSE);

session_start();

if (isset($_SESSION["smedia_popup_email"]) && $_SESSION["smedia_popup_email"]) {
    if (!isset($_COOKIE['smedia_popup_remember'])) {
        header("Location: logout.php");
    } else {
        header("Location: popup-setting.php");
    }
}

?>
<html>
<head>
    <title> Login To sMedia popup Dashboard </title>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Web Fonts  -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet"
          type="text/css">

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
        <h2>COVID-19 SmartMemo</h2>

            <a class="mybutton fadeIn fifth" href="./login.php">Login</a>
            <a class="mybutton fadeIn fifth" href="./registration.php">Register</a>

        <div id="formFooter">
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2020. All Rights Reserved.</p>
        </div>

    </div>
</div>
</body>
