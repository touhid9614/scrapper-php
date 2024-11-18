<?php

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

$input_type = INPUT_GET;

if($method === 'POST') {
    $input_type = INPUT_POST;
}

$dealership     = filter_input($input_type, 'dealership', FILTER_SANITIZE_STRING);
$year           = filter_input($input_type, 'year', FILTER_SANITIZE_NUMBER_INT);
$make           = filter_input($input_type, 'make', FILTER_SANITIZE_STRING);
$model          = filter_input($input_type, 'model', FILTER_SANITIZE_STRING);
$stock_type     = filter_input($input_type, 'stock_type', FILTER_SANITIZE_STRING);
$stock_number   = filter_input($input_type, 'stock_number', FILTER_SANITIZE_STRING);
$url            = filter_input($input_type, 'url', FILTER_SANITIZE_URL);
