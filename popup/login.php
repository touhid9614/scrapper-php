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

global $error_message;

$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'db_connect.php';
require_once $adwords_path . 'config.php';
require_once $adwords_path . 'utils.php';

$error_status = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $error_message = 'Invalid email';
        }

        $db_connect = new DbConnect('');
        $query      = "SELECT * from covid19login where email = '$username'";
        $result     = $db_connect->query($query);
        $user       = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user['name']) {
            if ($user['active']) {
                if (password_verify($password, $user['password'])) {

                    $_SESSION["smedia_popup_name"]       = $user['name'];
                    $_SESSION["smedia_popup_email"]      = $username;
                    $_SESSION["smedia_popup_userType"]   = trim($user['userType']);
                    $_SESSION["smedia_popup_dealership"] = $user['dealership'];

                    if (!empty($_POST['remember'])) {
                        setcookie("smedia_popup_remember", 'yes', time() + (30 * 24 * 60 * 60));
                    } else {
                        setcookie("smedia_popup_remember", 'no', 0);
                    }
                    header("Location: popup-setting.php");
                } else {
                    $error_message = "Username or Password is incorrect";
                }
            } else {
                $error_message = "This account has been deactivated. A member of our support team will reach out to you shortly to get you set up.";
                $error_status  = true;
            }
        } else {
            $error_message = "There is no account associated with this email address. A member of our support team will reach out to you shortly to get you set up.";
            $error_status  = true;
        }
    } else {
        $error_message = "Username and password are required";
    }
}

if ($error_status) {
    $email   = ['trevor@smedia.ca'];
    $from    = "smartmemo@smedia.ca";
    $subject = "COVID-19 SmartMemo Login ERROR";
    $message = "<b>Hello</b>,<br><p>Dealer Login fail. Other Info ::</p><br> Login Email : <b>$username</b><br><b>Message :</b>   $error_message  <br><br> Thanks.";
    SendEmail($email, $from, $subject, $message);
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
          rel="stylesheet"
          type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="styles.css">

    <link rel="shortcut icon" href="./smedia.png" type="png" alt="Smedia logo">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
          id="bootstrap-css">
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
        <?php
        if (!empty($error_message)) {
        ?>
            <div class="error">
                *** <?=$error_message?>
            </div>
        <?php
        }
        ?>

        <!-- Login Form -->
        <form method="post">
            <input type="email" id="login" class="fadeIn second" name="username" placeholder="Email address" required>
            <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required>
            <div class="actions fadeIn fourth text-left remember-me">
                <input type="checkbox" id="remember" name="remember" value="on">
                <label for="remember">Remember me</label>
            </div>
            <input type="submit" value="Log In" class="fadeIn fifth">
            <p>Don’t have an account yet?</p>
            <a class="" href="./registration.php">Register for COVID-19 SmartMemo</a>
        </form>
        <div id="formFooter">
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2020. All Rights Reserved.</p>
        </div>

    </div>
</div>
</body>
