<?php

require_once __DIR__ . '/SWFTag.php';

global $Tags;

$Tags = [];

foreach (array_filter(glob(__DIR__ . '/SWFTypes/*.php'), 'is_file') as $file) {
    require_once $file;
}

foreach (array_filter(glob(__DIR__ . '/SWFTags/*.php'), 'is_file') as $file) {
    require_once $file;
}
