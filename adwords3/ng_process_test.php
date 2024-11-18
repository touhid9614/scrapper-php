<?php

/* EXECUTE THE SCRIPT */
$file   = __DIR__ . "/ng_process_scheduler.php";
$script = 'php ' . escapeshellarg($file) . ' marshal > /dev/null &';
exec($script);
echo $file;