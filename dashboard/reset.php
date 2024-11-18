<?php

    //error_reporting(E_ERROR | E_PARSE);

    require_once 'config.php';
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'utils.php';
    //require_once 'includes/loader.php';
    require_once ADSYNCPATH . 'db_connect.php';
    require_once 'includes/functions.php';

    $user = null;

    if (strtolower($_SERVER['REQUEST_METHOD']) == 'get')
    {
        if (isset($_GET['smedia_reset_token']))
        {
            $token_data = json_decode(sm_decrypt($_GET['smedia_reset_token']), true);

            if ((time() - $token_data['timestamp']) <= 1800) // 30 minute window
            {
                $db_connect = new DbConnect();
                $user = $db_connect->getUser($token_data['email']);
            }
        }
    }
    elseif (strtolower($_SERVER['REQUEST_METHOD']) == 'post')
    {
        if (isset($_POST['token']) && isset($_POST['new_pass']) && isset($_POST['new_pass_repeat']))
        {
            $token_data = json_decode(sm_decrypt($_POST['token']), true);

            if ((time() - $token_data['timestamp']) <= 300) // 5 minute window
            {
                $db_connect = new DbConnect();
                $user = $db_connect->getUser($token_data['email']);
                if ($_POST['new_pass'] == $_POST['new_pass_repeat'])
                {
                    $password = filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_STRING);
                    $regex = '/^\S*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#%^&*?|\.,\-_=+\/}{)(\]\[])\S*$/m';

                    if (preg_match($regex, $password))
                    {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $db_connect->query("UPDATE users SET pass_hash='{$password_hash}', last_reset=CURRENT_TIMESTAMP WHERE email='{$token_data['email']}'");
                        redirect_to(DASHBOARD_URL . "/login.php?reset=1");
                        exit();
                    }
                    else
                    {
                        $error = 'Invalid password. Please follow the requirements.';
                    }

                }
            }
        }
    }

    if (empty($user))
    {
        redirect_to(DASHBOARD_URL . "/recover-password.php?error=1");
    }
    else
    {
        $token =
        [
            'email' => $user['email'],
            'timestamp' => time()
        ];

        $reset_token = sm_encrypt(json_encode($token));
    }
?>

<!doctype html>
<html class="fixed">
<head>
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
    <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme.css">

    <!-- Skin CSS -->
    <link rel="stylesheet" href="assets/stylesheets/skins/default.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="app/css/dashboard_global.css">

    <!-- Head Libs -->
    <script src="assets/vendor/modernizr/modernizr.js"></script>
    <title>Reset Password</title>
</head>

<body>
<!-- start: page -->
<section class="body-sign">
    <div class="center-sign">
        <a href="/" class="logo pull-left">
            <img src="assets/images/logo.png" height="54" alt="sMedia Logo" />
        </a>

        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Reset Password </h2>
            </div>

            <div class="panel-body">
                <?php
                if( isset($error) )
                {
                ?>
                    <div class="alert alert-warning">
                        <?= $error ?>
                    </div>
                <?php
                }
                ?>

                <div class="alert alert-info">
                    <ul>
                        <li> Password must be at least 8 characters long.</li>
                        <li> Password must contain at least one capital case charcter.</li>
                        <li> Password must contain at least one small case charcter.</li>
                        <li> Password must contain at least one number.</li>
                        <li> Password must contain at least one special charcter among the followings. 
                            <br> 
                            ~!@#%^&*?|.,-_=+/}{)(][
                        </li>
                    </ul>
                </div>
                
                <form  method="post" id="reset-password" class="reset-password">
                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left"> Password </label>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="new_pass" type="password" id="new_pass" class="form-control input-lg" required>
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left"> Renter Password </label>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="new_pass_repeat" id="new_pass_repeat" type="password" class="form-control input-lg" required >
                            <span class="input-group-addon">
                                <span class="icon icon-lg">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <input type="hidden" name="token" value="<?= $reset_token ?>">

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button id="reset_pass" type="submit" class="btn btn-primary btn-block btn-lg mt-lg" disabled> Reset Password </button>
                        </div>
                    </div>

                    <p class="text-center mt-lg"> Remembered Password? <a href="login.php"> Sign In! </a></p>
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
<script src="assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="assets/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="assets/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="assets/javascripts/theme.init.js"></script>

<!-- Password strength JS  -->
<script src="app/js/password.js"></script>

<!-- Custom JS  -->
<script src="app/js/validation.js"></script>


<script type="text/javascript">
(function($)
{

}(jQuery));
</script>
</body>
</html>
