<?php
    /**
     * Force redirect for dashboard and tools
     */
    $hostname = $_SERVER['HTTP_HOST'];

    if ($hostname != 'tools.smedia.ca' && $hostname != 'localhost' && $hostname!='tm-dev.smedia.ca') {
        header("Location: https://tools.smedia.ca" . $_SERVER['REQUEST_URI']);
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Dealership Budget Checker</title>

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css"/>

    <!-- font awesome -->
    <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/libs/bootstrap-3.3.6/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/libs/bootstrap-3.3.6/css/bootstrap-theme.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/easy-responsive-tabs.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/budgetchecker.css" />

    <script src="assets/js/jquery-2.2.1.min.js"></script>
    <script src="assets/js/easyResponsiveTabs.js" type="text/javascript"></script>
    <script src="assets/js/waitingDialog.js" type="text/javascript"></script>
    <script src="assets/js/budgetchecker.js?v=1.6" type="text/javascript"></script>
    <script src="assets/libs/bootstrap-3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="page">
        <div></div>
        <h2 class="logo"></h2>

        <!--Horizontal Tab-->
        <div id="horizontalTab">
            <ul class="resp-tabs-list">
                <li>Starting on 1st</li>
                <li>Youtube on 1st</li>
                <li>Custom</li>
                <li>Custom Youtube</li>
                <li>Ranged</li>
                <li>Ranged Youtube</li>
            </ul>
            <div class="resp-tabs-container">
                <div>
                    <table class="table on1st">
                        <tr>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table youtubeon1st">
                        <tr>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table custom">
                        <tr>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table customyoutube">
                        <tr>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table ranged">
                        <tr>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table rangedyoutube">
                        <tr>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <pre class="error-details" style="display: none;">

        </pre>
    </div>
    <div class="loading-dialog-div"></div>
    <div class="loading-dialog-animation-div"></div>
    <div class="sort-by-container">
        <p>Sort By</p>
        <select id="sort-by">
            <option value="name" selected="selected">Name</option>
            <option value="offset">Over/Under</option>
            <option value="bounce_rate">Bounce Rate</option>
            <option value="bounce_rate_pp">Bounce Rate (Last Month)</option>
            <option value="cost_per_engaged_user">Cost/Engagement</option>
            <option value="cost_per_engaged_user_pp">Cost/Engagement (Last Month)</option>
            <option value="y_adb">Diff. ADB</option>
        </select>
    </div>
</body>
</html>
