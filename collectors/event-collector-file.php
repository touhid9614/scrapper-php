<?php

require_once __DIR__ . '/loader.php';

use Predis\Client as RedisClient;

$redis = new RedisClient($redis_config);

#var_dump(getSessionFilePath('http://www.barbermotors.com/VehicleDetails/new-2018-Chevrolet-Equinox-LT-Weyburn-SK/3208615633'));
#var_dump(getUserFilePath('1a242130bc851f3cc37a2c13c3c6ca2e6a31b22589ba628a62fd265dfebef4a5'));

$cursor = '0';

echo "Starting to process\n";

$events_processed = 0;
$events_missed = 0;

do {
    
    echo "Requesting with cursor $cursor\n";
    
    $list = $redis->scan($cursor, ['MATCH' => 'event_*', 'COUNT' => 10000]);
    
    echo "Match found: " . count($list[1]) . " next cursor is: {$list[0]}\n";
    
    $events_processed += count($list[1]);
    
    foreach($list[1] as $event_key) {
        
        $event          = $redis->hgetall($event_key);
        $event['date']  = unserialize($event['data']);
        $view           = $redis->hgetall("view_{$event['viewId']}");
        $session        = $redis->hgetall("session_{$event['sessionId']}");
        
        //Clear up
        if($event && (time() - $event['lastUpdate'] > 1200)) {              //Event isn't updated in last 20 minutes
            $redis->del("event_{$event['eventId']}");
        }
        
        if($view && (time() - $view['lastUpdate'] > 7 * 24 * 3600)) {       //Views are kept for 7 days
            $redis->del("view_{$event['viewId']}");
        }
        
        if($session && (time() - $session['lastUpdate'] > 7 * 24 * 7200)) { //Sessions are kept for 14 
            $redis->del("session_{$event['sessionId']}");
        }
        
        if(!$view) {
            echo "Warning: View wasn't found for the event {$event['eventId']}\n";
            $events_missed++;
            continue;
        }
        
        if(!$session) {
            $session = [];
        }
        
        $file = getSessionFilePath($view['url'], $view['lastUpdate']);
        
        //Load current data
        $current = file_exists($file)? unserialize(file_get_contents($file)) : [];
        
        //Update session
        if(key_exists($event['sessionId'], $current)) {
            $current[$event['sessionId']] = array_merge($current[$event['sessionId']], $session);
        } else {
            $current[$event['sessionId']] = $session;
        }
        
        if(!key_exists('_views', $current[$event['sessionId']])) { $current[$event['sessionId']]['_views'] = []; }
        
        //Update view
        if(key_exists($event['viewId'], $current[$event['sessionId']]['_views'])) {
            $current[$event['sessionId']]['_views'][$event['viewId']] = array_merge($current[$event['sessionId']]['_views'][$event['viewId']], $view);
        } else {
            $current[$event['sessionId']]['_views'][$event['viewId']] = $view;
        }
        
        if(!key_exists('_events', $current[$event['sessionId']]['_views'][$event['viewId']])) {
            $current[$event['sessionId']]['_views'][$event['viewId']]['_events'] = [];
        }
        
        //Update event
        if(key_exists($event['eventId'], $current[$event['sessionId']]['_views'][$event['viewId']]['_events'])) {
            $current[$event['sessionId']]['_views'][$event['viewId']]['_events'][$event['eventId']] = array_merge($current[$event['sessionId']]['_views'][$event['viewId']]['_events'][$event['eventId']], $event);
        } else {
            $current[$event['sessionId']]['_views'][$event['viewId']]['_events'][$event['eventId']] = $event;
        }
        
        file_put_contents($file, serialize($current));
    }
    
    echo "Events processed so far $events_processed and missed $events_missed\n";
    
    $cursor = $list[0];
} while($cursor != '0');

echo "Done processing events\n";