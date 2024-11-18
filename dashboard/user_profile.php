<?php

error_reporting(E_ERROR | E_PARSE);

require_once 'config.php';
require_once 'includes/loader.php';
session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

global $user;

$db_connect  = new DbConnect('');
$user_id_md5 = md5($user['id']);

if ($user['type'] == 'g') {
    $cron_name = filter_input(INPUT_GET, 'dealership');

    if (!$cron_name) {
        $cron_name = $user['cron_name'];
    }

    if (!(isset($user['image_url'][$cron_name])) || $user['image_url'][$cron_name] == '') {
        $user['image_url'][$cron_name] = "assets/images/smedia-logo-1024.png";
        $user['image_url'][$cron_name] = "assets/images/smedia-logo-36.png";
    }

    $result = $db_connect->query("SELECT email FROM users WHERE dealership='{$cron_name}'");
    $row    = mysqli_fetch_assoc($result);

    $group_member_email = $row['email'];

    $user_id_md5 = md5($group_member_email);
}

// create new user when a dealer is registered.
// in register new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btn   = filter_input(INPUT_POST, 'btn');
    $email = $user['id'];

    switch ($btn) {
        case 'update_image':

            $error = false;
            $image = false;

            if ($_FILES['image']['error'] > 0) {
                $error = 'An error occurred when uploading.';
            }

            if (!getimagesize($_FILES['image']['tmp_name'])) {
                $error = 'Please ensure you are uploading an image.';
            }

            if (!$error && in_array($_FILES['image']['type'], ['image\/png', 'image\/jpg', 'image\/jpeg'])) {
                $error = 'Unsupported file type uploaded. Please upload png, jpg or jpeg';
            }

            if (!$error && $_FILES['image']['size'] > 20 * 1024 * 1024) {
                $error = 'File uploaded exceeds maximum upload size of 20 MB.';
            }

            $upload_dir = DATA_DIR . "user_images";

            if (!is_dir(DATA_DIR)) {
                mkdir(DATA_DIR, 0755, true);
            }

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_name     = "$user_id_md5.jpg";
            $file_name_512 = "$user_id_md5-512.jpg";
            $file_name_36  = "$user_id_md5-36.jpg";

            if (!$error && in_array($_FILES['image']['type'], ['image/jpg', 'image/jpeg'])) {
                $image_temp = imagecreatefromjpeg($_FILES['image']['tmp_name']);
            } else if (!$error && in_array($_FILES['image']['type'], ['image/png'])) {
                $image_temp = imagecreatefrompng($_FILES['image']['tmp_name']);
            }

            if (!$error && $image_temp) {
                if (!imagejpeg($image_temp, "{$upload_dir}/{$file_name}", 100)) {
                    $error = 'Error uploading file - check destination is writable.';
                } else {
                    $image_512 = image_resize_rectangle("{$upload_dir}/{$file_name}");

                    if (!$error && !imagejpeg($image_512, "{$upload_dir}/{$file_name_512}", 100)) {
                        $error = 'Error uploading file - check destination is writable..';
                    }

                    $image_36 = image_resize_rectangle("{$upload_dir}/{$file_name}", 36);

                    if (!$error && !imagejpeg($image_36, "{$upload_dir}/{$file_name_36}", 100)) {
                        $error = 'Error uploading file - check destination is writable...';
                    }

                }

                imagedestroy($image_temp);
                imagedestroy($image_36);
                imagedestroy($image_512);
            }

            if ($error == false) {
                $url    = DATA_DIR_URL . "user_images/{$file_name_512}?" . time();
                $url_36 = DATA_DIR_URL . "user_images/{$file_name_36}?" . time();

                $image_update_query = "UPDATE users SET image_url = '{$url}', thumbnail_url = '{$url_36}' WHERE email = '$email'";

                if ($user['type'] == 'g') {
                    $image_update_query = "UPDATE users SET image_url = '{$url}', thumbnail_url = '{$url_36}' WHERE email = '$group_member_email'";
                }

                $db_connect->query($image_update_query);
            }

            echo json_encode(['image' => [$url, $url_36], 'error' => $error]);
            exit();
            break;

        case 'update_profile':
            $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
            $about_me     = filter_input(INPUT_POST, 'about_me', FILTER_SANITIZE_STRING);

            if ($user['type'] == 'g') {
                $db_connect->query("UPDATE users SET phone_number = '{$phone_number}', about_me = '{$about_me}' WHERE email = '$group_member_email'");
            } else {
                $db_connect->query("UPDATE users SET phone_number = '{$phone_number}', about_me = '{$about_me}' WHERE email = '$email'");
            }

            break;

        case 'social_media':
            $fb_url = filter_input(INPUT_POST, 'fb_url', FILTER_SANITIZE_URL);
            $ig_url = filter_input(INPUT_POST, 'ig_url', FILTER_SANITIZE_URL);
            $in_url = filter_input(INPUT_POST, 'in_url', FILTER_SANITIZE_URL);

            if ($user['type'] == 'g') {
                $db_connect->query("UPDATE users SET facebook = '$fb_url', instagram = '$ig_url', linkedin = '$in_url' WHERE email = '$group_member_email'");
            } else {
                $db_connect->query("UPDATE users SET facebook = '$fb_url', instagram = '$ig_url', linkedin = '$in_url' WHERE email = '$email'");
            }

            break;

        case 'reset_pass':
            $pwd       = '' . filter_input(INPUT_POST, 'current_pass');
            $new_pwd   = '' . filter_input(INPUT_POST, 'new_pass');
            $new_pwd_r = '' . filter_input(INPUT_POST, 'new_pass_repeat');
            $error     = null;

            if ($db_connect->verify_login($user['id'], $pwd)) {
                if ($new_pwd != $new_pwd_r) {
                    $error         = true;
                    $error_message = "New Passwords don't match";
                }

                $passReg = '/^\S*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#%^&*?|\.,\-_=+\/}{)(\]\[])\S*$/m';

                if (preg_match($passReg, $new_pwd)) {
                    $params =
                        [
                        'pass_hash'  => password_hash($new_pwd, PASSWORD_DEFAULT),
                        'last_reset' => date('Y-m-d H:i:s'),
                    ];

                    $query_prep = $db_connect->prepare_query_params($params, DbConnect::PREPARE_EQUAL);
                    $db_connect->query("UPDATE users SET $query_prep WHERE email = '$email'");
                } else {
                    $error         = true;
                    $error_message = "Password doesn't meet necessary requirements.";

                }
            } else {
                $error         = true;
                $error_message = "Current password is wrong.";
            }

            if ($error) {
                //echo $error_message;
            }

            break;
    }

    if (!isset($error_message)) {
        echo ("<script type='text/javascript'> location.href = location.href; </script>");
    }
}
include 'bolts/header.php';
?>



<div class="inner-wrapper">

<?php
$select = 'my_account';
include 'bolts/sidebar.php';
?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2> User Profile </h2>
        </header>

        <form method="POST" class="form-horizontal form-bordered">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="thumb-info mb-md">
                                <img src=
                                "<?php
if ($user['type'] == 'g') {
    echo $user['image_url'][$cron_name];
} else {
    echo $user['image_url'];
}
?>"
                                class="rounded img-responsive" alt="<?=$user['name'];?>">
                                <div class="thumb-info-title">
                                    <span class="thumb-info-inner"> <?=$user['name'];?> </span>
                                    <span class="thumb-info-type"> <?=ucwords($user['designation']);?> </span>
                                </div>

                                <div id="image-uploader">
                                    <input type="file" name="profile-image" id="profile-image" accept=".jpg, .png, .jpeg">
                                    <label for="profile-image" data-toggle="popover"
                                           data-placement="bottom"
                                           data-trigger="hover"
                                           data-content="Upload profile image. Allowed images are png, jpg and jpeg."
                                           data-original-title="" title="">
                                        <i class="fa fa-camera"></i>
                                    </label>
                                </div>
                            </div>

                            <div id="upload_status"></div>

                            <hr class="dotted short">
                            <h6 class="text-muted"> About Me : </h6>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="3" id="about_me" name="about_me"
                                    placeholder=
                                    "<?php
if ($user['type'] == 'g') {
    echo $user['about_me'][$cron_name];
} else {
    echo $user['about_me'];
}
?>"
                                    data-current=
                                    "<?php
if ($user['type'] == 'g') {
    echo $user['about_me'][$cron_name];
} else {
    echo $user['about_me'];
}
?>"
                                    value=
                                    "<?php
if ($user['type'] == 'g') {
    echo $user['about_me'][$cron_name];
} else {
    echo $user['about_me'];
}
?>"
                                    data-toggle="popover" data-placement="bottom"
                                    data-trigger="hover" data-content = "Tell us about yourself."><?php // Don't insert any space between textarea tag and php tag
if ($user['type'] == 'g') {
    echo $user['about_me'][$cron_name];
} else {
    echo $user['about_me'];
}
?></textarea>
                                </div>
                            </div>

                            <hr class="dotted short">

                            <div class="social-icons-list">
                                <a rel="tooltip" data-placement="bottom" target="_blank" href="<?=$user['facebook']?>" target="_blank"
                                    data-original-title="Facebook">
                                    <i class="fab fa-facebook-f" aria-hidden=true></i>
                                    <span> Facebook </span>
                                </a>
                                <a rel="tooltip" data-placement="bottom" href="<?=$user['instagram']?>" target="_blank"
                                    data-original-title="Instagram">
                                    <i class="fab fa-instagram" aria-hidden=true></i>
                                    <span> Instagram </span>
                                </a>
                                <a rel="tooltip" data-placement="bottom" href="<?=$user['linkedin']?>" target="_blank"
                                    data-original-title="Linkedin">
                                    <i class="fab fa-linkedin" aria-hidden=true></i>
                                    <span> Linkedin </span>
                                </a>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-8 col-lg-6">
                    <div class="tabs">
                        <div class="tab-content">
                            <?php
if (isset($error_message)) {
    ?>
                                <div class="alert alert-warning">
                                    <p class="m-none text-weight-semibold h6"> <?=$error_message?> </p>
                                </div>
                                <?php
}
?>
                            <div id="edit" class="tab-pane active">
                                <form class="form-horizontal" method="get">
                                    <h4 class="mb-xlg"> Personal Information </h4>

                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="user_name"> Name : </label>
                                            <label class="col-md-6 align-left-user"> <?=ucwords($user['name']);?> </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="user_email"> Email : </label>
                                            <label class="col-md-6 align-left-user"> <?=$user['id'];?> </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="user_role"> Role : </label>
                                            <label class="col-md-6 align-left-user"> <?=ucwords($user['designation']);?> </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="user_role"> Website : </label>
                                            <label class="col-md-6 align-left-user">
                                                <i>
                                                <?php
if ($user['type'] == 'g') {
    echo $user['website'][$cron_name];
} else {
    echo $user['website'];
}
?>
                                                </i>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="phone_number"> Phone : </label>
                                            <div class="col-md-9">
                                                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                                placeholder=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['phone_number'][$cron_name];
} else {
    echo $user['phone_number'];
}
?>"
                                                data-current=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['phone_number'][$cron_name];
} else {
    echo $user['phone_number'];
}
?>"
                                                value=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['phone_number'][$cron_name];
} else {
    echo $user['phone_number'];
}
?>"
                                                data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content = "Phone number">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" id="update_profile" name="btn" value="update_profile"
                                                class="btn btn-primary  pull-right"> Update Profile </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="dotted tall">
                                    <h4 class="mb-xlg"> Social Media </h4>

                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="fb_url"> My Facebook URL : </label>
                                            <div class="col-md-9">
                                                <input type="url" class="form-control italic-placeholder" id="fb_url" name="fb_url"
                                                placeholder=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['facebook'][$cron_name];
} else {
    echo $user['facebook'];
}
?>"
                                                data-current=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['facebook'][$cron_name];
} else {
    echo $user['facebook'];
}
?>"
                                                value=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['facebook'][$cron_name];
} else {
    echo $user['facebook'];
}
?>" data-toggle="popover" data-placement="bottom"
                                                data-trigger="hover" data-content = "Enter your facebook page.">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="ig_url"> My Instagram URL : </label>
                                            <div class="col-md-9">
                                                <input type="url" class="form-control italic-placeholder" id="ig_url"
                                                name="ig_url" placeholder=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['instagram'][$cron_name];
} else {
    echo $user['instagram'];
}
?>"
                                                data-current=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['instagram'][$cron_name];
} else {
    echo $user['instagram'];
}
?>"
                                                value=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['instagram'][$cron_name];
} else {
    echo $user['instagram'];
}
?>" data-toggle="popover" data-placement="bottom"
                                                data-trigger="hover" data-content = "Enter your instagram page.">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="in_url"> My LinkedIn URL : </label>
                                            <div class="col-md-9">
                                                <input type="url" class="form-control italic-placeholder" id="in_url"
                                                name="in_url" placeholder=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['linkedin'][$cron_name];
} else {
    echo $user['linkedin'];
}
?>"
                                                data-current=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['linkedin'][$cron_name];
} else {
    echo $user['linkedin'];
}
?>"
                                                value=
                                                "<?php
if ($user['type'] == 'g') {
    echo $user['linkedin'][$cron_name];
} else {
    echo $user['linkedin'];
}
?>" data-toggle="popover" data-placement="bottom"
                                                data-trigger="hover" data-content = "Enter your linkedin page.">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" id="social_media" name="btn" value="social_media"
                                                class="btn btn-primary  pull-right"> Save Social Media </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="dotted tall">
                                    <h4 class="mb-xlg"> Change Password </h4>

                                    <div class="alert alert-info">
                                        <ul>
                                            <li> Password must be at least 8 characters long.</li>
                                            <li> Password must contain at least one capital case charcter.</li>
                                            <li> Password must contain at least one small case charcter.</li>
                                            <li> Password must contain at least one number.</li>
                                            <li> Password must contain at least one special charcter among the followings.
                                                <br>
                                                ~!@#%^&*?|.,-_=+/}{)(][</li>
                                            <li> Password can not contain any spaces.</li>
                                        </ul>
                                    </div>

                                    <fieldset class="mb-xl">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="current_pass"> Current Password </label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control copy_disable" id="current_pass" name="current_pass"
                                                placeholder="xxxxxxxxxxxxxxxx" data-toggle="popover" data-placement="bottom"
                                                data-trigger="hover" data-content = "Enter your current password.">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="new_pass"> New Password </label>

                                            <div class="col-md-9">
                                                <div class="password-strength">
                                                    <input type="password" class="form-control copy_disable" id="new_pass" name="new_pass"
                                                    placeholder="xxxxxxxxxxxxxxxx" data-toggle="popover" data-placement="bottom" data-trigger="hover"
                                                    data-content = "Enter your new password.">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="new_pass_repeat"> Repeat New Password </label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control copy_disable" id="new_pass_repeat"
                                                name= "new_pass_repeat" placeholder="xxxxxxxxxxxxxxxx" data-toggle="popover"
                                                data-placement="bottom" data-trigger="hover"
                                                data-content = "Enter your new password again.">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" id="reset_pass" name="btn" value="reset_pass"
                                                class="btn btn-primary  pull-right"> Reset Password </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<style type="text/css">
    .align-left-user
    {
        padding-top: 7px;
        margin-bottom: 0;
    }
</style>

<?php
include 'bolts/footer.php';
?>

<!-- Password strength JS  -->
<script src="app/js/password.js"></script>
