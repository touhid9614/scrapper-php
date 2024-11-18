<?php

//header('Content-type: image/png');

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once 'includes/search-inventory.php';

function logme($data)
{echo $data;}

global $user, $connection, $distances;

$url   = isset($_GET['lparam']) ? base64_decode($_GET['lparam']) : null;
$width = isset($_GET['w']) ? intval($_GET['w']) : 200;

if (!$url) {
    die();
}

//$loc_mutex = Mutex::create();
$db_connect = new DbConnect($user['cron_name']);
$search     = new InventorySearch($db_connect);

$cache_name = md5("$url $width") . '.png';

$filename = IMGCACHEDIR . $cache_name;
$target   = resolve_file_url($filename);

if (file_exists($filename)) {
    redirect_to($target);
}

$data = $search->load_url_with_cache($url, 1);

try
{
    $img = imagecreatefromstring($data);
} catch (Exception $ex) {
    die();
}

if (!$img) {
    die();
}

$sw = imagesx($img);
$sh = imagesy($img);

$height = round(($sh / $sw) * $width);

$image = imagecreatetruecolor($width, $height);
imageantialias($image, true);

imagecopyresampled($image, $img, 0, 0, 0, 0, $width, $height, $sw, $sh);

ob_start();
imagepng($image);
$imagedata = ob_get_contents(); // read from buffer
ob_end_clean(); // delete buffer
imagedestroy($img);
imagedestroy($image);
//Mutex::destroy($loc_mutex);
file_put_contents($filename, $imagedata);
redirect_to($target);
