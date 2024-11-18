<?php
#/usr/local/lib/php
#/home/spidri/public_html/adwords/adwords3/weblauncher.php
echo exec('php ' . escapeshellarg(__DIR__ . '/ng_process_launcher.php') . ' marshal ');

echo exec('php ' . escapeshellarg(__DIR__ . '/ng_sold_ad_cleaner_launcher.php') . ' marshal ');
#Launch FB sync processes
#echo exec('php ' . escapeshellarg(__DIR__ . '/ng_fbsync_launcher.php') . ' marshal ');
