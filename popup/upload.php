<?php
session_start();
$email        = $_SESSION["smedia_popup_email"];
$userType     = $_SESSION["smedia_popup_userType"];
$tmp_path     = dirname(__FILE__) . '/';
$abs_path     = str_replace('\\', '/', $tmp_path);
$adwords_path = dirname($abs_path) . '/adwords3/';

require_once $adwords_path . 'db-config.php';
require_once $adwords_path . 'config.php';
require_once $adwords_path . 'db_connect.php';
require_once $adwords_path . 'tag_db_connect.php';
require_once $adwords_path . 'utils.php';

$db_connect = new DbConnect('');
$dealership = isset($_POST['dealership']) ? $_POST['dealership'] : '';

if ($userType != "a") {
    $query     = "SELECT * from covid19login where email = '$email' AND  dealership = '$dealership'";
    $result    = $db_connect->query($query);
    $userCheck = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!isset($userCheck['name'])) {
        header("Location: popup-setting.php?dealer=$dealership");
    }
}

$meta_data    = get_meta('popup_config', $dealership);
$data['live'] = isset($_POST['live']) ? $_POST['live'] : '';

$data['image_include'] = isset($_POST['image_include']) ? $_POST['image_include'] : '';
$data['image_file']    = isset($meta_data['image_file']) ? $meta_data['image_file'] : '';
$image_file            = isset($_FILES['image_file']) ? $_FILES['image_file'] : '';
$allowed_mime_type     = [
    'image/png',
    'image/jpeg'
];

$image = $_FILES['image_file'];

if (empty($image['error']) && in_array($image['type'], $allowed_mime_type)) {
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    
    if (s3SaveFile("popup-$dealership.$ext", $image['tmp_name'], "smedia-user-photos")) {
        $data['image_file'] = "popup-$dealership.$ext";
    }
}

$data['text_include']        = isset($_POST['text_include']) ? $_POST['text_include'] : '';
$data['headline']            = isset($_POST['headline']) ? $_POST['headline'] : '';
$data['details']             = isset($_POST['details']) ? $_POST['details'] : '';
$data['headline_text_color'] = isset($_POST['headline_text_color']) ? '#' . $_POST['headline_text_color'] : '';
$data['text_color']          = isset($_POST['text_color']) ? '#' . $_POST['text_color'] : '';
$data['background_color']    = isset($_POST['background_color']) ? '#' . $_POST['background_color'] : '';

$data['button_include']    = isset($_POST['button_include']) ? $_POST['button_include'] : '';
$data['button_text']       = isset($_POST['button_text']) ? $_POST['button_text'] : '';
$data['button_link']       = isset($_POST['button_link']) ? $_POST['button_link'] : '';
$data['button_color']      = isset($_POST['button_color']) ? '#' . $_POST['button_color'] : '';
$data['button_text_color'] = isset($_POST['button_text_color']) ? '#' . $_POST['button_text_color'] : '';
$data['open_in_new']       = isset($_POST['open_in_new']) ? $_POST['open_in_new'] : '';

if (isset($_POST['preview'])) {
    $data['live']             = '';
    $_SESSION['open_preview'] = true;
}

create_meta_table('popup_config');
update_meta('popup_config', $dealership, $data);
$meta_data = get_meta('popup_config', $dealership);
header("Location: popup-setting.php?dealer=$dealership");