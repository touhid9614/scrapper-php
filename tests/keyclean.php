<?php

$keywords = [
    '+2011 +Toyota +Tacoma +V6 +(A5) +4x4 +Double-Cab',
];

$invalid_pattern = '/[^A-Z a-z0-9\-\+\?\[\]\"\$\,\.]/';

foreach ($keywords as $keyword) {
    echo preg_replace($invalid_pattern, "", $keyword) . PHP_EOL;
}
