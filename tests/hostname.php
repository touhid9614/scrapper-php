<?php

$hostname = $_SERVER['HTTP_HOST'];

if ($hostname != 'tools.smedia.ca' && $hostname != 'localhost' && $hostname != 'tm-dev.smedia.ca') {
    header("Location: https://tools.smedia.ca" . $_SERVER['REQUEST_URI']);
    exit;
}

var_dump($_SERVER);
