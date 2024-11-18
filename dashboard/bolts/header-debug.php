<?php

global $user;

if ($user['type'] == 'g') {
    $thumbnail_url = $user['thumbnail_url'][$cron_name];
} else {
    $thumbnail_url = $user['thumbnail_url'];
}

$uri  = $_SERVER['REQUEST_URI'];
$keys = parse_url($uri);
$path = explode("/", $keys['path']);
$last = end($path);

if (($user['type'] == 'g' || $user['type'] == 'u') && $last != "coming_soon.php") {
    redirect_to('coming_soon.php');
}
?>
<!doctype html>
<html class="fixed">
    <head>
        <!-- Basic -->
        <meta charset="UTF-8">
        <title>Dashboard</title>

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />


        <!-- Web Fonts  -->
        <?php
$start_time = microtime(true);
?>
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of Web Fonts //fonts.googleapis.com/css script = " . $execution_time . " sec<br>";
?>

        <?php
$start_time = microtime(true);
?>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" />
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of font-awesome script = " . $execution_time . " sec<br>";
?>

        <?php
$start_time = microtime(true);
?>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of w3schools script = " . $execution_time . " sec<br>";
?>

        <?php
$start_time = microtime(true);
?>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of smoothness/jquery-ui.css script = " . $execution_time . " sec<br>";
?>

        <?php
$start_time = microtime(true);
?>
        <script src="assets/vendor/jquery/jquery.js"></script>
        <!-- Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

        <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />


        <!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
        <link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />

        <link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
        <link rel="stylesheet" href="assets/vendor/morris/morris.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.theme.css" />
        <link rel="stylesheet" href="assets/vendor/pnotify/pnotify.custom.css" />

        <!-- jQuery TextExt -->
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.core.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.plugin.arrow.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.plugin.autocomplete.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.plugin.clear.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.plugin.focus.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.plugin.prompt.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-textext/src/css/textext.plugin.tags.css" />
        <link rel="stylesheet" href="assets/vendor/summernote/summernote.css" />
        <link rel="stylesheet" href="assets/vendor/codemirror/lib/codemirror.css" />
        <link rel="stylesheet" href="assets/vendor/codemirror/theme/monokai.css" />

        <!-- Markdown -->
        <link rel="stylesheet" href="assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />

        <!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/jstree/themes/default/style.css" />

        <!-- ios7 switch -->
        <link rel="stylesheet" href="assets/vendor/ios7-switch/ios7-switch.modernizr.css" />
        <link rel="stylesheet" href="assets/vendor/ios7-switch/ios7-switch.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="assets/stylesheets/theme.css" />

        <!-- Skin CSS -->
        <link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="assets/vendor/modernizr/modernizr.js"></script>

        <!-- Country code css -->
        <!--link rel="stylesheet" href="app/css/intlTelInput.min.css"-->


        <!-- Dashboard -->
        <link rel="stylesheet" href="app/css/dashboard.css?v=1.1">
        <link rel="stylesheet" href="configuration-manager/app/css/config-manager.css">

        <!-- Fav Icon -->
        <link rel="shortcut icon" href="../dashboard/assets/images/cropped-ICON-SMEDIA-32x32.png" type="png" sizes="32x32" alt="Smedia logo">


        <!--  Our Custom CSS  -->
        <link rel="stylesheet" type="text/css" href="app/css/calldrip.css">
        <link rel="stylesheet" type="text/css" href="app/css/dashboard_global.css">
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of local script = " . $execution_time . " sec<br>";
?>

        <?php
$start_time = microtime(true);
?>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.3/css/intlTelInput.css">
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of //cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.3/css/intlTelInput.css script = " . $execution_time . " sec<br>";
?>

        <?php
$start_time = microtime(true);
?>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <?php
$end_time       = microtime(true);
$execution_time = ($end_time - $start_time);
echo " Execution time of jquery.timepicker.min.css script = " . $execution_time . " sec<br>";
?>

    </head>

    <body>
        <section class="body">
            <!-- start: header -->    <!-- end: header -->