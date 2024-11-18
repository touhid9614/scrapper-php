<?php
session_start();

if (isset($_SESSION["smedia_popup_email"]) && $_SESSION["smedia_popup_email"]) {
    if (!isset($_COOKIE['smedia_popup_remember'])) {
        header("Location: logout.php");
    }
} else {
    header("Location: login.php");
}

$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'config.php';
require_once $adwords_path . 'db_connect.php';
require_once $adwords_path . 'utils.php';
require_once $adwords_path . 'tag_db_connect.php';

$db_connect = new DbConnect('');

$email       = $_SESSION["smedia_popup_email"];
$name        = $_SESSION["smedia_popup_name"];
$dealership  = $_SESSION["smedia_popup_dealership"];
$userType    = $_SESSION["smedia_popup_userType"];
$regSuccess  = isset($_SESSION["smedia_popup_success"]) ? $_SESSION["smedia_popup_success"] : false;
$_SESSION["smedia_popup_success"] = false;

$dealer = isset($_GET['dealer']) ? $_GET['dealer'] : (!empty($dealership) ? $dealership : '');

if ($userType == "a") {
    $allDealers = $db_connect->get_all_dealers("status = 'active';");

    if (isset($_GET['dealer'])) {
        $dealer_details = $allDealers[$dealer];
    } else {
        $key            = array_keys($allDealers)[0];
        $dealer_details = $allDealers[$key];
    }
} else {
    $query     = "SELECT * from covid19login where email = '$email' AND  dealership = '$dealer';";
    $result    = $db_connect->query($query);
    $userCheck = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!isset($userCheck['name'])) {
        header("Location: popup-setting.php?dealer=$dealership");
    }

    $dealer_details = $db_connect->get_dealer_details($dealer);

    if (empty($dealer_details)) {
        header("Location: logout.php");
    }

    $check = ['active'];

    if (!in_array($dealer_details['status'], $check)) {
        header("Location: logout.php");
    }
}

if (empty(trim($dealer))) {
    $dealer = $dealer_details['dealership'];
}

$default_settings = [
    'headline_text_color' => '#000000',
    'text_color'          => '#5A5A5A',
    'background_color'    => '#EFEFEF',
    'button_color'        => '#AE2419',
    'button_text_color'   => '#FFFFFF'
];

$settigs = array_merge($default_settings, (array) get_meta('popup_config', $dealer));

if (!empty($settigs['image_file'])) {
    $image_url = s3GetUrl($settigs['image_file'], "smedia-user-photos");
} else {
    $image_url = './demo.png';
}
?>

<html>

<head>
    <title> sMedia popup Dashboard </title>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="setting-design.css">
    <link rel="shortcut icon" href="./smedia.png" type="png" alt="Smedia logo">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css" />

    <?php if (isset($_SESSION['open_preview'])) { ?>
        <?php unset($_SESSION['open_preview']) ?>
        <script type="text/javascript">
            window.open('<?= $dealer_details['websites'] ?>?cache_reset=true&smedia_debug=true&covid19_debug=true', '_blank')
        </script>
    <?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.0.4/jscolor.min.js"></script>
</head>

<body class="mb-5">


    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="./smedia.png" width="30" height="30" class="d-inline-block align-top" alt="">
            sMedia
        </a>
        <?php
        if ($userType == "a") {
        ?>
            <a class="navbar-brand btn btn-outline-warning" href="./register-dealer.php">
                Register Dealer
            </a>
        <?php
        }
        ?>
        <a class="navbar-brand btn btn-outline-warning" href="./logout.php">
            Logout
        </a>
    </nav>

    <?php
    if ($regSuccess) {
    ?>
        <div class="messageSmedia anim">
            <div class=" alert alert-success " role="alert">
                <strong>Success! </strong> You’re now registered and can use this admin dashboard to manage your COVID-19 SmartMemo popup.
                <button type="button" class="close ml-3" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="container">
        <div class="header-popup">
            <h3 class="mb-1"> Welcome <?= $name ?></h3>
            <?php
            if ($userType == "a") {
            ?>
                <div class="form-group row">
                    <label for="dealer" class="col-sm-2 col-form-label">Select Dealership</label>
                    <div class="col-sm-4">
                        <form method="GET">
                            <select class="form-control selectpicker " data-live-search="true" name="dealer" onchange="(function(e){e.target.closest('form').submit()})(event)">
                                <?php
                                foreach ($allDealers as $dealerid => $details) {
                                    $select = ($dealer == $dealerid) ? 'selected' : '';
                                    echo "<option $select>$dealerid</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <p class="mb-3">Use the settings below to configure the COVID-19 SmartMemo popup on your dealership’s
                    homepage to communicate important, up-to-the-minute information about how your dealership is managing
                    the COVID-19 situation. </p>
                <h6 class="mb-4">Stay Safe ❤ </h6>
            <?php
            }
            ?>
        </div>
        <div class="card">
            <h5 class="card-header">COVID-19 SmartMemo
                Settings <?= $userType == "a" ? ' for :: ' . $dealer : '' ?></h5>
            <div class="card-body">
                <form id="popup-settings" action="upload.php" method="post" enctype="multipart/form-data">
                    <input name="dealership" type="hidden" class="form-control" value="<?= $dealer ?>">
                    <div class="form-row">
                        <div class="custom-control custom-checkbox">
                            <input name="live" type="checkbox" class="custom-control-input" id="customCheck1" <?= !empty($settigs['live']) ? 'checked="checked"' : '' ?> />
                            <label class="custom-control-label" for="customCheck1"><b>Live</b><span class="fs12 ml-3"> When checked the COVID-19 SmartMemo will display on your website’s homepage </span></label>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-md-3 mb-1">
                            <div class="form-row">
                                <div class="custom-control custom-checkbox">
                                    <input name="image_include" type="checkbox" class="custom-control-input" id="customCheck2" <?= !empty($settigs['image_include']) ? 'checked="checked"' : '' ?>>
                                    <label class="custom-control-label" for="customCheck2"> Include an image
                                        (optional)</label>
                                </div>
                            </div>
                            <p class="fs12 mt-2 mr-5"> When checked, the uploaded image will be displayed at the top of the
                                popup </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="custom-file">
                                <input name="image_file" type="file" class="custom-file-input form-control" id="customFile" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <p class="fs12 mt-2 mx-2"> 2MB max file size</p>
                            <P class="fs12 mx-2">Browse your computer for an image from your device. Once an image is
                                selected, it will be saved and added to your popup when you click the Submit button
                                below</P>
                        </div>
                        <div class=" col-md-5">
                            <img class="rounded mx-auto d-block img-popup " src="<?= isset($image_url) ? $image_url : '' ?>" alt="Image">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-md-3 mb-1">
                            <div class="form-row mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input name="text_include" type="checkbox" class="custom-control-input" id="customCheck3" <?= !empty($settigs['text_include']) ? 'checked="checked"' : '' ?>>
                                    <label class="custom-control-label" for="customCheck3"> Include Text</label>
                                </div>
                            </div>
                            <p class="fs12 mt-2 mr-5"> When checked, text entered in the optional Headline and Body Copy
                                fields to the right will be displayed </p>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label">Headline (optional)<br>
                                    <span class="fs12">max 50 characters</span>
                                </label>
                                <div class="col-md-9">
                                    <input name="headline" type="text" class="form-control count-char" data-char="50" id="title" value="<?= $settigs['headline'] ?>">
                                    <span class="fs12 remaining">Remaining characters:
                                        <span class="remaining_count">50</span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="details" class="col-md-3 col-form-label">Body Copy (optional)<br><span class="fs12">max 1000 characters</span></label>
                                <div class="col-md-9">
                                    <textarea name="details" class="form-control count-char" data-char="1000" id="details" rows="3"><?= $settigs['details'] ?></textarea>
                                    <span class="fs12 remaining">Remaining characters: <span class="remaining_count">1000</span></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="details" class="col-md-3 col-form-label">Headline Text Color</label>
                                <div class="col-md-3">
                                    <input name="headline_text_color" type="text" class="form-control jscolor" value="<?= $settigs['headline_text_color'] ?>">
                                </div>
                                <label for="details" class="col-md-3 col-form-label text-center">Body Text Color</label>
                                <div class="col-md-3 ">
                                    <input name="text_color" type="text" class="form-control jscolor" value="<?= $settigs['text_color'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="details" class="col-md-3 col-form-label">Background Color</label>
                                <div class="col-md-3">
                                    <input name="background_color" type="text" class="form-control jscolor" value="<?= $settigs['background_color'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-2">
                        <div class="col-md-3 mb-1">
                            <div class="form-row mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input name="button_include" type="checkbox" class="custom-control-input" id="customCheck4" <?= !empty($settigs['button_include']) ? 'checked="checked"' : '' ?>>
                                    <label class="custom-control-label" for="customCheck4"> Include Button</label>
                                </div>
                            </div>
                            <p class="fs12 mt-2 mr-5"> When checked, a button will display at the bottom of your popup</p>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label">Button Text <br><span class="fs12">max 24 characters</span></label>
                                <div class="col-md-9">
                                    <input name="button_text" type="text" class="form-control count-char" data-char="24" value="<?= $settigs['button_text'] ?>">
                                    <span class="fs12 remaining">Remaining characters: <span class="remaining_count">24</span></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label">Button Link</label>
                                <div class="col-md-9">
                                    <input name="button_link" type="text" class="form-control" value="<?= $settigs['button_link'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="details" class="col-md-3 col-form-label ">Button Color</label>
                                <div class="col-md-3">
                                    <input name="button_color" type="text" class="form-control jscolor" value="<?= $settigs['button_color'] ?>">
                                </div>
                                <label for="details" class="col-md-3 col-form-label text-center">Text Color</label>
                                <div class="col-md-3">
                                    <input name="button_text_color" type="text" class="form-control jscolor" value="<?= $settigs['button_text_color'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input name="open_in_new" type="checkbox" class="custom-control-input" id="open_in_new" <?= !empty($settigs['open_in_new']) ? 'checked="checked"' : '' ?>>
                                        <label class="custom-control-label" for="open_in_new"> Open in new tab</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="buttons">
                        <input id="save-settings" type="submit" class="btn btn-primary" value="Publish" name="publish">
                        <input id="save-settings" type="submit" class="btn btn-primary" value="Preview" name="preview">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    var count_char  = function(e) {
        var val     = $(this).val();
        var limit   = parseInt($(this).attr('data-char'));
        val         = val.slice(0, limit);
        $(this).val(val);
        var remaining = limit - val.length;
        $(this).siblings('.remaining').find('.remaining_count').text(remaining);
    }

    $('.count-char').keyup(count_char).change(count_char).focus(count_char).trigger('focus');

    $('#save-settings').click(function(e) {
        $('.is-invalid').removeClass('is-invalid')
        $('.help-block').remove();

        var form     = $('#popup-settings');
        var btn_inc  = form.find('input[name="button_include"]');
        var url      = form.find('input[name="button_link"]');
        var desc     = form.find('textarea[name="details"]');
        var title    = form.find('input[name="headline"]');
        var btn      = form.find('input[name="button_text"]');
        var imgClass = form.find('input[name="image_file"]');
        var img      = document.getElementById('customFile');
        var imgSize  = img.files[0].size;

        console.log("Image file Size", imgSize);

        if (imgSize > 2000000) {
            console.log("Image file Size Error", imgSize);
            imgClass.addClass('is-invalid');
            console.log(imgClass);
            imgClass.focus();
            e.preventDefault();
        }

        if (btn_inc.is(':checked')) {
            console.log(url.val());
            if (/^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/.test(url.val()) == false) {
                url.addClass('is-invalid')
                url.focus();
                e.preventDefault();
            }
        }

        if (title.val() && title.val().length > 50) {
            title.addClass('is-invalid')
            title.focus();
            e.preventDefault();
        }

        if (desc.val() && desc.val().length > 1000) {
            desc.addClass('is-invalid')
            desc.focus();
            e.preventDefault();
        }

        if (btn.val() && btn.val().length > 24) {
            btn.addClass('is-invalid')
            btn.focus();
            e.preventDefault();
        }

    });
</script>