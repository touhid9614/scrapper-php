<?php

error_reporting(E_ERROR | E_PARSE);

require_once ADSYNCPATH . 'db_connect.php';

global $CronConfigs, $scrapper_configs, $admins, $account_groups, $user, $error_message, $cron_names, $super_admins;

$user = [
    'id'          => null,
    'type'        => null,
    'cron_name'   => null,
    'cron_config' => null,
];

$error_message = null;

$cookie = isset($_COOKIE['_adsync_auth']) ? $_COOKIE['_adsync_auth'] : null;

if ($cookie) {
    $data  = base64_decode($cookie);
    $parts = explode('|', $data);

    // Get the cron names which have both config and scrapper_config even though they might not be inactive.
    $db_connect = new DbConnect('');
    $cron_names = array_keys($db_connect->get_all_dealers("1=1 ORDER BY status ASC, dealership ASC;"));
    natcasesort($cron_names);

    if (count($parts) >= 5) {
        $user_id   = $parts[0];
        $user_type = $parts[1];
        $signature = $parts[2];
        $pipeCount = end($parts);

        if (!$pipeCount && count($parts) == 5) {
            $hash = $parts[3];
        } else {
            $temp = $parts;
            unset($temp[count($test) - 1]);
            unset($temp[0]);
            unset($temp[1]);
            unset($temp[2]);
            $hash = implode("|", $temp);
        }

        if ($user_type === 'u') {
            $db_user     = $db_connect->getUser($user_id);
            $cron_name   = $db_user['dealership'];
            $cron_config = isset($CronConfigs[$cron_name]) ? $CronConfigs[$cron_name] : null;

            if ($db_connect->isPassSet($user_id)) {
                $computed_signature = compute_signature($user_id, $user_type, $hash);

                if ($signature === $computed_signature) {
                    $user['id']            = $user_id;
                    $user['type']          = $user_type;
                    $user['cron_config']   = $cron_config;
                    $user['cron_name']     = $cron_name;
                    $user['accounts']      = false;
                    $user['image_url']     = $db_user['image_url'];
                    $user['thumbnail_url'] = $db_user['thumbnail_url'];
                    $user['website']       = $db_user['website'];
                    $user['facebook']      = $db_user['facebook'];
                    $user['instagram']     = $db_user['instagram'];
                    $user['linkedin']      = $db_user['linkedin'];
                    $user['phone_number']  = $db_user['phone_number'];
                    $user['about_me']      = $db_user['about_me'];
                    $user['name']          = $db_user['name'];
                    $user['designation']   = isset($db_user['designation']) ? $db_user['designation'] : 'dealer';
                    $user['role']          = isset($db_user['role']) ? $db_user['role'] : 'dealership';

                    if (!isset($user['name'])) {
                        $user['name'] = '';
                    }

                    if (!isset($user['designation'])) {
                        $user['designation'] = '';
                    }

                    if (!isset($user['about_me'])) {
                        $user['about_me'] = "I'm proud to be a part of sMedia.";
                    }

                    if (!isset($user['image_url']) || $user['image_url'] == '') {
                        $user['image_url'] = "assets/images/smedia-logo-1024.png";
                    }

                    if (!isset($user['thumbnail_url']) || $user['thumbnail_url'] == '') {
                        $user['thumbnail_url'] = "assets/images/smedia-logo-36.png";
                    }

                    if (!isset($user['website'])) {
                        $user['website'] = 'https://smedia.ca/';
                    }

                    if (!isset($user['facebook']) || $user['facebook'] == '') {
                        $user['facebook'] = 'https://www.facebook.com/sMedia.ca/';
                    }

                    if (!isset($user['instagram']) || $user['instagram'] == '') {
                        $user['instagram'] = 'https://www.instagram.com/smedia.ca/';
                    }

                    if (!isset($user['linkedin']) || $user['linkedin'] == '') {
                        $user['linkedin'] = 'https://www.linkedin.com/company/smedia.ca/';
                    }
                } else {
                    if (!defined('LOGIN_PAGE')) {
                        redirect_to('login.php');
                    } else {
                        $error_message = '';
                    }
                }
            } else {
                if (!defined('LOGIN_PAGE')) {
                    redirect_to('login.php');
                } else {
                    $error_message = 'This account is not configured for user login';
                }
            }
        } elseif ($user_type === 'g') {
            $group = $db_connect->getGroup($user_id);

            if (isset($group) && count($group['accounts']) > 0) {
                $computed_signature = compute_signature($user_id, $user_type, $hash);

                if ($signature === $computed_signature) {
                    $user['id']            = $user_id;
                    $user['name']          = isset($group['name']) ? $group['name'] : null;
                    $user['type']          = $user_type;
                    $user['accounts']      = array_intersect($group['accounts'], $cron_names);
                    $user['cron_name']     = isset($_GET['dealership']) ? (in_array($_GET['dealership'], $user['accounts']) ? $_GET['dealership'] : $user['accounts'][0]) : $user['accounts'][0];
                    $user['cron_config']   = $CronConfigs[$user['cron_name']];
                    $user['image_url']     = $group['image_url']; // array
                    $user['thumbnail_url'] = $group['thumbnail_url']; // array
                    $user['website']       = $group['website']; // array
                    $user['facebook']      = $group['facebook']; // array
                    $user['instagram']     = $group['instagram']; // array
                    $user['linkedin']      = $group['linkedin']; // array
                    $user['phone_number']  = $group['phone_number']; // array
                    $user['about_me']      = $group['about_me']; // array
                    $user['designation']   = 'Dealer Group';
                    $user['role']          = 'Dealership Group';
                } else {
                    if (!defined('LOGIN_PAGE')) {
                        redirect_to('login.php');
                    } else {
                        $error_message = '';
                    }
                }
            }
        } elseif ($user_type === 'a') {
            $admin = $db_connect->getUser($user_id);

            if ($admin) {
                $computed_signature = compute_signature($user_id, $user_type, $hash);

                // We need to consider active or trial status
                if ($signature === $computed_signature) {
                    $user['id']          = $user_id;
                    $user['name']        = isset($admin['name']) ? $admin['name'] : $user_id;
                    $user['type']        = $user_type;
                    $user['role']        = isset($admin['role']) ? $admin['role'] : none;
                    $user['designation'] = isset($admin['designation']) ? $admin['designation'] : null;
                    $user['accounts']    = $cron_names;
                    $user['cron_name']   = isset($_GET['dealership']) ?
                    (in_array($_GET['dealership'], $user['accounts']) ?
                        $_GET['dealership'] : $user['accounts'][0]) : $user['accounts'][0];
                    $user['cron_config']   = $CronConfigs[$user['cron_name']];
                    $user['image_url']     = $admin['image_url'];
                    $user['thumbnail_url'] = $admin['thumbnail_url'];
                    $user['website']       = $admin['website'];
                    $user['facebook']      = $admin['facebook'];
                    $user['instagram']     = $admin['instagram'];
                    $user['linkedin']      = $admin['linkedin'];
                    $user['phone_number']  = $admin['phone_number'];
                    $user['about_me']      = $admin['about_me'];

                    if (in_array($user_id, $super_admins)) {
                        $user['super_admin'] = true;
                    }

                    if (in_array($user_id, $developers)) {
                        $user['developer'] = true;
                    }

                    if (!isset($user['name'])) {
                        $user['name'] = '';
                    }

                    if (!isset($user['designation'])) {
                        $user['designation'] = '';
                    }

                    if (!isset($user['about_me'])) {
                        $user['about_me'] = "I'm proud to be a part of sMedia.";
                    }

                    if (!isset($user['image_url']) || $user['image_url'] == '') {
                        $user['image_url'] = "assets/images/smedia-logo-1024.png";
                    }

                    if (!isset($user['thumbnail_url']) || $user['thumbnail_url'] == '') {
                        $user['thumbnail_url'] = "assets/images/smedia-logo-36.png";
                    }

                    if (!isset($user['website'])) {
                        $user['website'] = 'https://smedia.ca/';
                    }

                    if (!isset($user['facebook']) || $user['facebook'] == '') {
                        $user['facebook'] = 'https://www.facebook.com/sMedia.ca/';
                    }

                    if (!isset($user['instagram']) || $user['instagram'] == '') {
                        $user['instagram'] = 'https://www.instagram.com/smedia.ca/';
                    }

                    if (!isset($user['linkedin']) || $user['linkedin'] == '') {
                        $user['linkedin'] = 'https://www.linkedin.com/company/smedia.ca/';
                    }
                } else {
                    if (!defined('LOGIN_PAGE')) {
                        redirect_to('login.php');
                    } else {
                        $error_message = '';
                    }
                }
            }
        } else {
            redirect_to('login.php');
        }
    } else {
        if (!defined('LOGIN_PAGE')) {
            redirect_to('login.php');
        }
    }
} else {
    if (!defined('LOGIN_PAGE')) {
        redirect_to('login.php');
    }
}

/**
 * Gets the request url.
 *
 * @return     <type>  The request url.
 */
function getRequestURL()
{
    return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}