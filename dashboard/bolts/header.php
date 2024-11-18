<?php

    global $user;

    if ($user['type'] == 'g')
    {
        $thumbnail_url =  $user['thumbnail_url'][$cron_name];
    }
    else
    {
        $thumbnail_url =  $user['thumbnail_url'];
    }

    $uri = $_SERVER['REQUEST_URI'];
    $keys = parse_url($uri);
    $path = explode("/", $keys['path']);
    $last = end($path);

    if (($user['type'] == 'g' || $user['type'] == 'u') && $last != "coming_soon.php")
    {
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
        <script src="assets/vendor/jquery/jquery.js"></script>

        <!-- Web Fonts  -->
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
        <link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
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
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.3/css/intlTelInput.css">

        <!-- Dashboard -->
        <link rel="stylesheet" href="app/css/dashboard.css?v=1.1">
        <link rel="stylesheet" href="configuration-manager/app/css/config-manager.css">

        <!-- Fav Icon -->
        <link rel="shortcut icon" href="../dashboard/assets/images/cropped-ICON-SMEDIA-32x32.png" type="png" sizes="32x32" alt="Smedia logo">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

        <!--  Our Custom CSS  -->
        <link rel="stylesheet" type="text/css" href="app/css/calldrip.css">
        <link rel="stylesheet" type="text/css" href="app/css/dashboard_global.css">
    </head>

    <body>
        <section class="body">
            <!-- start: header -->
            <header class="header">
                <div class="logo-container">
                    <a href="../" class="logo">
                        <img src="assets/images/logo.png" height="35" alt="Porto Admin" />
                    </a>
                    <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>

                <div id="userbox" class="userbox pull-right">
                    <a href="#" data-toggle="dropdown">
                        <figure class="profile-picture">
                            <img src="<?= $thumbnail_url ?>" alt="<?= $user['name'] ?>" class="img-circle" data-lock-picture="<?= $user['thumbnail_url'] ?>" />
                        </figure>
                        <div class="profile-info" data-lock-name="<?= $user['name'] ?>" data-lock-email="<?= $user['id'] ?>">
                            <span class="name"><?= $user['name'] ?></span>
                            <span class="role"><?= $user['designation'] ?></span>
                        </div>
        
                        <i class="fa custom-caret"></i>
                    </a>
        
                    <div class="dropdown-menu">
                        <ul class="list-unstyled">
                            <li class="divider"></li>

                            <?php if ($user['type'] == 'g' || $user['type'] == 'a') { ?>
                            <li>
                                <a role="menuitem" tabindex="-1" href="user_profile.php"><i class="fa fa-user"></i> My Profile </a>
                            </li>
                            <?php } ?>
                            <!--li>
                                <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
                            </li-->
                            <li>
                                <a role="menuitem" tabindex="-1" href="signout.php"><i class="fa fa-power-off"></i> Logout </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <!-- end: header -->