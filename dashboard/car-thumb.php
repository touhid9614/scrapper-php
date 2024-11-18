<?php

header('Content-type: image/png');

require_once 'config.php';
require_once 'includes/loader.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once 'includes/search-inventory.php';

function logme($data){}

global $user, $connection, $distances;

$url = isset($_GET['lparam'])?base64_decode($_GET['lparam']):null;

if(!$url)
{
    die();
}


$db_connect = new DbConnect($user['cron_name']);
$search     = new InventorySearch($db_connect);

$data = $search->load_url_with_cache($url, 1);

try
{
    $img = imagecreatefromstring($data);
}
catch (Exception $ex)
{
    die();
}

if(!$img)
{
    die();
}

$sw = imagesx($source);
$sh = imagesy($source);

$width  = 200;
$height = round(($sh/$sw)*$width);

$image = imagecreatetruecolor($width, $height);
imageantialias($image, true);

imagecopyresampled($image, $img, 0, 0, 0, 0, $width, $height, $sw, $sh);

imagepng ($image);
imagedestroy($img);
imagedestroy($image);
$db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);