<?php

require_once __DIR__ . '/loader.php';

use Predis\Client as RedisClient;

$redis = new RedisClient($redis_config);


$cursor = '0';

echo "Starting to process\n";

$user_processed = 0;

do {
    
    echo "Requesting with cursor $cursor\n";
    
    $list = $redis->scan($cursor, ['MATCH' => 'user_*', 'COUNT' => 10000]);
    
    $user_processed += count($list[1]);
    
    foreach($list[1] as $user_key) {
        $user   = $redis->hgetall($user_key);
        
        $file = getUserFilePath($user['userId']);
        
        $current = file_exists($file)? unserialize(file_get_contents($file)) : [];
        
        $current[$user['userId']] = $user;
        
        file_put_contents($file, serialize($current));
    }
    
    $cursor = $list[0];
    
} while($cursor != '0');