<?php
	
	//error_reporting(E_ERROR | E_PARSE);

	require_once 'config.php';
    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'utils.php';
	require_once ADSYNCPATH . 'db_connect.php';

	global $error_message, $user;

	$reset_msg = "Enter your e-mail below and we will send reset link in your email!";

	if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
		$reset_msg = "An email has been sent to your email address.";
		$email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
		$disable = true;

		$db_connect = new DbConnect('');

		if (validEmail($email, $db_connect)) {
			$domain 		= 'mail.smedia.ca';
			$from 			= 'Recovery sMedia <recovery@smedia.ca>';
			$subject 		= 'Recover sMedia Password';
			$message    	=  file_get_contents('./mail_template/recovery_email.html');

			$token = [
				'email' => $email,
				'timestamp' => time()
			];

			$access_token = sm_encrypt(json_encode($token));
			$message = str_replace('random_generated_encrypted_token', $access_token, $message);

			SendEmail($email, $from, $subject, $message);
		} else {
			$error_message = "Invalid email. Please enter a valid email registered at sMedia.";
		}
	}



    /**
     * { function_description }
     *
     * @param      <type>  $email       The email
     * @param      <type>  $db_connect  The database connect
     * @param      $value
     *
     * @return     bool
     */
	function validEmail($email, &$db_connect)
	{
        $emailRegEx = '/^(?=[A-z0-9][A-z0-9@._%+-]{5,253}$)[A-z0-9._%+-]{1,64}@(?:(?=[A-z0-9-]{1,63}\.)[A-z0-9]+(?:-[A-z0-9]+)*\.){1,8}[A-z]{2,7}$/';

        return (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($emailRegEx, $email) && $db_connect->isPassSet($email));
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
						<h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Recover Password </h2>
					</div>

					<div class="panel-body">
                        <?php
                            if (isset($_GET['error']))
                            {
                        ?>
                            <div class="alert alert-warning">
                                <p class="m-none text-weight-semibold h6"> Invalid or expired token. Please try again! </p>
                            </div>
                        <?php
                            }
                        ?>


                        <?php
                            if (isset($error_message))
                            {
                        ?>
                            <div class="alert alert-warning">
                                <p class="m-none text-weight-semibold h6"> <?= $error_message ?> </p>
                            </div>
                        <?php
                            }
                            else
                            {
                        ?>
                            <div class="alert alert-info">
                                <p class="m-none text-weight-semibold h6" id="reset_msg"> <?= $reset_msg ?> </p>
                            </div>
                        <?php
                            }
                        ?>
						<form  method="post" action="recover-password.php">
							<div class="form-group mb-none">
								<div class="input-group">
									<input name="user_email" type="email" placeholder="someone@example.com"
									class="form-control input-lg italic-placeholder" data-toggle="popover" data-placement="bottom" data-trigger="hover"
									data-content = "Enter your email which is registered to your sMedia account.">
									<span class="input-group-btn">  
									<?php 
										//if ($disable) echo ' disabled' 
									?>
										<button class="btn btn-primary btn-lg" type="submit"> Reset! </button>
									</span>
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

		<!-- Custom JS  -->
		<script src="app/js/validation.js"></script>
	</body>
</html>