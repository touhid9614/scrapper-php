<?php
define('REGISTRATION_COMPLETE_PAGE', true);
error_reporting(E_ERROR | E_PARSE);

if (isset($_POST['domain'])) {
    $domain = $_POST['domain'];
} else {
    header("Location: registration.php");
}

$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'db_connect.php';
require_once $adwords_path . 'config.php';
require_once $adwords_path . 'utils.php';

$db_connect  = new DbConnect('');
$url         = $db_connect->getOnlyDomain($domain);
$query       = "SELECT * from covid19login where domain = '$url';";
$result      = $db_connect->query($query);
$dealerCheck = mysqli_fetch_array($result, MYSQLI_ASSOC);

if (isset($dealerCheck['name'])) {
    $dealerFind = false;
    $dealerName = $dealerCheck['name'];
    $msg        = "An account for {$dealerName} has already been created.";
} else {
    $dealerInfo = $db_connect->checkDealerExist($url);
    $dealerFind = false;
    $msg        = "We couldn’t find an account for that URL in our system. A member of our support team will reach out to you shortly to get you set up.";
    $count      = 0;
    while ($details = mysqli_fetch_array($dealerInfo, MYSQLI_ASSOC)) {
        if (isset($details['dealership'])) {
            $company_name = $details['company_name'];
            if ($details['status'] == 'active') {
                $count++;
                $dealership = $details['dealership'];
                $dealerFind = true;
            } else {
                $dealerFind = false;
                $msg        = "The account status of $company_name isn’t active in our system. A member of our support team will reach out to you shortly to get you set up.";
            }
        }
    }
    if ($count > 1) {
        $dealerFind = false;
        $domain     = trim($domain, '/');
        $query      = "SELECT * FROM dealerships WHERE websites = '$domain' and status = 'active';";
        $dealerInfo = $db_connect->query($query);
        $count      = 0;

        while ($details = mysqli_fetch_assoc($dealerInfo)) {
            if (!empty(isset($details['dealership']))) {
                $count++;
                $dealership   = $details['dealership'];
                $company_name = $details['company_name'];
                $dealerFind   = true;
            }
        }
        if ($count > 1) {
            $dealerFind = false;
            $msg        = "An error occurred. A member of our support team will reach out to you shortly to get you set up.";
        }
    }
}
if (!$dealerFind) {
    $email   = ['trevor@smedia.ca'];
    $from    = "smartmemo@smedia.ca";
    $subject = "COVID-19 SmartMemo Registration ERROR";
    $message = "<b>Hello</b>,<br><p>Dealer registration fail. Dealer Info ::</p><br> Dealer Domain : <b>$domain</b><br><b>Message :</b>   $msg  <br><br> Thanks.";
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet"
          type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="./styles.css">
    <link rel="shortcut icon" href="./smedia.png" type="png" alt="Smedia logo">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
if (!$dealerFind) {
    ?>
            <p class="mx-5"><?=$msg?></p>
        <?php
} else {
    ?>
            <p class="mx-5">Enter your email address and choose a password to finalize the registration process</p>
        <?php
}
?>

        <!-- Login Form -->
        <form id="registration-complete" method="post" action="registration-final.php">
            <input type="url" id="domain" class="fadeIn second" name="domain" placeholder="Domain Address" required
                   value="<?=$domain?>" disabled>
            <?php
if ($dealerFind) {
    ?>

                <input type="hidden" id="username" class="fadeIn " name="username" required value="<?=$dealership?>">
                <input type="hidden" id="company_name" class="fadeIn " name="company_name" required value="<?=$company_name?>">
                <input type="hidden" id="url" class="fadeIn " name="url" required value="<?=$url?>">
                <input type="email" id="userEmail" class="fadeIn second" name="userEmail" placeholder="Email address" required>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required>
                <input type="password" id="confirm_password" class="fadeIn third" name="confirm_password" placeholder="Confirm password" required>

                <div class="actions fadeIn fourth  remember-me ">
                    <div class="float-left">
                        <input type="checkbox" id="showPasssword" onclick="myFunction()">
                        <label for="showPasssword">Show Password</label>
                    </div>
                    <div class="float-right">
                        <label id='message'> </label>
                    </div>
                </div>
                <input id="save-registration" type="submit" class="btn btn-primary fadeIn fifth" value="Register" name="register">
                <?php
} else {
    ?>
                <a class="mybutton fadeIn fifth" href="./registration.php"> Try another website URL</a>
                <a class="" href="./login.php">Already have an account? Login</a>
                <?php
}
?>
        </form>
        <div id="formFooter">
            <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2020. All Rights Reserved.</p>
        </div>
    </div>
</div>
</body>
<script>
    $('#password, #confirm_password').on('keyup', function () {
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if (password === confirm_password) {
            if(confirm_password.length >5) {
                $('#message').html('Good to go!').css('color', 'green');
            } else {
                $('#message').html('Password must be a minimum of 6 characters').css('color', 'red');
            }
        } else
            $('#message').html('Passwords must be the same ').css('color', 'red');
    });

    function myFunction() {
        var x = document.getElementById("password");
        var y = document.getElementById("confirm_password");
        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
        } else {
            x.type = "password";
            y.type = "password";
        }
    }

    $('#save-registration').click(function (e) {
        $('.is-invalid').removeClass('is-invalid')
        var form        = $('#registration-complete');
        var userEmail   = form.find('input[name="userEmail"]');
        var pass        = form.find('input[name="password"]');
        var conPass     = form.find('input[name="confirm_password"]');

        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(userEmail.val()) == false) {
            userEmail.addClass('is-invalid')
            userEmail.focus();
            e.preventDefault();
            console.log('No Valid email');
            $('#message').html('Please provide a valid email address').css('color', 'red');
        }

        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        if (password === confirm_password) {
            if(password.length < 6) {
                pass.addClass('is-invalid');
                pass.focus();
                e.preventDefault();
            }
            if(confirm_password.length < 6) {
                conPass.addClass('is-invalid');
                conPass.focus();
                e.preventDefault();
            }
        } else {
            pass.addClass('is-invalid');
            pass.focus();
            e.preventDefault();
        }
    })
</script>