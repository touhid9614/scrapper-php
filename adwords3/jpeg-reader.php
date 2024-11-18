<?php

$file = filter_input(INPUT_GET, 'file');
$filename = "test-imgs/{$file}.jpg";

if (!file_exists($filename)) {
	die("File doesn't exist");
}

$image = imagecreatefromjpeg($filename);

if (!$image) {
	die("Unable to load image");
}

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
