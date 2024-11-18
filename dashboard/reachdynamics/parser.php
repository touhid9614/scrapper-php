<?php

$params = filter_input_array(INPUT_GET);

if($params) {
    extract($params);
}