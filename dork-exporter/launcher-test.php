<?php

$grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('ng_scrap_cars_launcher.php') . ' | grep -v sudo | grep -v root | wc -l';

var_dump(exec($grepstring));