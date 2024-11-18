<?php

require_once __DIR__ . '/init.php';

$resp = [];

for($i = 0; $i < 1000; $i++) {
    $p = filter_button_option(null, 'arlingtonacura', [
        'WHAT\'S YOUR TRADE WORTH',
        'Value Your Trade',
        'Get Your Trade-In Value',
        'Get Financed Today',
        'Explore Payments'
    ], null /* Force don't store */, 'financing', 'text_financing', 'used');
    
    if(isset($resp[$p])) { $resp[$p]++; } else { $resp[$p] = 1; }
}

var_dump($resp);