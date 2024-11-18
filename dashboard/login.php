<?php

    define ('LOGIN_PAGE', true);
    error_reporting(E_ERROR | E_PARSE);

    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'db_connect.php';

    global $admins, $CronConfigs, $error_message, $user;

    if (strtolower($_SERVER['REQUEST_METHOD']) == 'post')
    {
        if (isset($_POST['email']) && isset($_POST['pwd']))
        {
            $user_id    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $pwd        = '' . $_POST['pwd'];
            $hash       = password_hash($pwd, PASSWORD_DEFAULT);
            $pipeCount  = substr_count($hash, '|');

            if (!filter_var($user_id, FILTER_VALIDATE_EMAIL))
            {
                $error_message = 'Invalid email';
                DbConnect::store_log($user_id, $user['type'], 'Login Failed','Message- '. $error_message);
            }
            elseif ($user_id && $pwd)
            {
                $db_connect = new DbConnect('');
                $user_type  = $db_connect->getUserType($user_id);
                $user_types = ['u', 'g', 'a'];

                if ($user_type && in_array($user_type, $user_types, true))
                {
                    if ($db_connect->verify_login($user_id, $pwd))
                    {
                        $data   = $user_id . '|' . $user_type . '|' . compute_signature($user_id, $user_type, $hash) . '|' . $hash . '|' . $pipeCount;
                        $cookie = base64_encode($data);
                        $expire_at = 0;

                        if (isset($_POST['rememberme']))
                        {
                            $expire_at = time() + 2592000;  // 30 days = 60*60*24*30 = 2592000
                        }

                        setcookie('_adsync_auth', $cookie, $expire_at, '/');
                        DbConnect::store_log($user_id, $user['type'], 'Login', 'successfully login');

                        if ($user_type === 'u')
                        {
                            //redirect_to('button-details.php?dealership=' . $db_connect->getUserDealer($user_id));
                            redirect_to('coming_soon.php');
                        }
                        elseif ($user_type === 'g')
                        {
                            //redirect_to('button-details.php');
                            redirect_to('coming_soon.php');
                        }
                        elseif ($user_type === 'a')
                        {
                            redirect_to('overview.php');
                        }
                        else
                        {
                            // generate error
                        }
                    }
                    else
                    {
                        $error_message = 'Username and password did not match';
                        DbConnect::store_log($user_id, $user['type'], 'Login Failed','Message- ' . $error_message);
                    }
                }
                else
                {
                    $error_message = 'Unknown user type.';
                    DbConnect::store_log($user_id, $user['type'], 'Login Failed','Message- ' . $error_message);
                }
            }
            else
            {
                $error_message = 'Username and Password is required';
                DbConnect::store_log($user_id, $user['type'], 'Login Failed','Message- ' . $error_message);
            }
        }
        else
        {
            $error_message = 'Username and Password is required';
                DbConnect::store_log($user_id, $user['type'], 'Login Failed','Message- ' . $error_message);
        }
    }
?>

<!doctype html>

<html class="fixed">
    <head>
        <title> Login To sMedia Dashboard </title>
        <!-- Basic -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Web Fonts  -->
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css">
        <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css">
        <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css">

        <!-- Theme CSS -->
        <link rel="stylesheet" href="assets/stylesheets/theme.css">

        <!-- Skin CSS -->
        <link rel="stylesheet" href="assets/stylesheets/skins/default.css">

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="assets/vendor/modernizr/modernizr.js"></script>
    </head>

    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <a href="/" class="logo pull-left">
                    <img src="assets/images/logo.png" height="54" alt="sMedia Logo">
                </a>

                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($_GET['reset'])) { ?>
                            <div class="alert alert-info">
                                <p class="m-none text-weight-semibold h6" id="reset_msg">Your password has been reset successfully.</p>
                            </div>
                        <?php } ?>
                        <form action="login.php" method="post">
                        <?php
                            if ($error_message)
                            {
                        ?>
                            <div class="form-group mb-lg">
                                <span class="error">*** <?= $error_message ?></span>
                            </div>

                        <?php
                            }
                        ?>

                            <div class="form-group mb-lg">
                                <label> Email </label>
                                <div class="input-group input-group-icon">
                                    <input name="email" type="email" class="form-control input-lg" required>
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left"> Password </label>
                                    <a href="recover-password.php" class="pull-right"> Forgot Password? </a>
                                </div>

                                <div class="input-group input-group-icon">
                                    <input name="pwd" type="password" class="form-control input-lg" required>
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="checkbox-custom checkbox-default">
                                        <input id="RememberMe" name="rememberme" type="checkbox">
                                        <label for="RememberMe"> Remember Me </label>
                                    </div>
                                </div>

                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs"> Sign In </button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg"> Sign In </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2019. All Rights Reserved.</p>
            </div>
        </section>
        <!-- end: page -->


        <!-- Vendor -->
        <script src="assets/vendor/jquery/jquery.js"></script>
        <script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
        <script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
        <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
        <script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="assets/javascripts/theme.js"></script>

        <!-- Theme Custom -->
        <script src="assets/javascripts/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="assets/javascripts/theme.init.js"></script>

        <!-- Custom JS  -->
        <script src="app/js/validation.js"></script>

    </body>
</html>
