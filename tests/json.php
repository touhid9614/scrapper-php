<?php

$data = file_get_contents('test.json');
$obj  = json_decode($data);
$data = "{$obj->results}\n{$obj->pagination}";

echo $data;
