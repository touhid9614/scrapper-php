<?php

require_once __DIR__ . '/loader.php';

use Predis\Client as RedisClient;

$redis = new RedisClient($redis_config);

$redshift = new PDO(
    "pgsql:dbname={$event_db_config['dbname']};host={$event_db_config['host']};port={$event_db_config['port']}",
    $event_db_config['user'], $event_db_config['pass']
);

#var_dump(getSessionFilePath('http://www.barbermotors.com/VehicleDetails/new-2018-Chevrolet-Equinox-LT-Weyburn-SK/3208615633'));
#var_dump(getUserFilePath('1a242130bc851f3cc37a2c13c3c6ca2e6a31b22589ba628a62fd265dfebef4a5'));

$cursor = '0';

$file_path   =   $core_path . "/caches/collectors-log/event-collector.txt";
writeLog($file_path, "Starting to process");
echo "Starting to process\n";

$events_processed = 0;
$events_missed = 0;

do {

    echo "Requesting with cursor $cursor\n";

    $list = $redis->scan($cursor, ['MATCH' => 'event_*', 'COUNT' => 10000]);

    echo "Match found: " . count($list[1]) . " next cursor is: {$list[0]}\n";

    $events_processed += count($list[1]);

    $counter = 0;
    foreach($list[1] as $event_key) {
        $counter++;
        echo "Processing event {$event_key}\n";
        
        $event          = $redis->hgetall($event_key);
        $view           = $redis->hgetall("view_{$event['viewId']}");
        $session        = $redis->hgetall("session_{$event['sessionId']}");
        
        print_r($event);
        exit;
        
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

        $event_vals = [
            'view_id' => $event['viewId'],
            'session_id' => $event['sessionId'],
            'user_id' => $session['userId'],
            'category_name' => $event['category'],
            'action_name' => $event['action'],
            'event_value' => $event['value'],
            'event_data' => $event['data'],
            'started_at' => $event['timestamp'],
            'last_updated' => $event['lastUpdate']
        ];
        $view_vals = [
            'session_id' => $view['sessionId'],
            'user_id' => $view['userId'],
            'domain_name' => $view['domain'],
            'url' => $view['url'],
            'referer_url' => $view['referrerURL'],
            'page_type' => $view['pageType'],
            'time_on_page' => $view['timeOnPage'],
            'started_at' => $view['timestamp'],
            'last_updated' => $view['lastUpdate'],
        ];
        $session_vals = [
            'user_id' => $session['userId'],
            'domain_name' => $session['domain'],
            'start_url' => $session['startURL'],
            'referer_url' => $session['referrerURL'],
            'device' => $session['device'],
            'user_agent' => $session['userAgent'],
            'display_size' => $session['displaySize'],
            'started_at' => $session['timestamp'],
            'last_updated' => $session['lastUpdate'],
        ];
 
        upsert_table($redshift, 'events', $event_vals, [], ['event_id' => $event['eventId']]);
        upsert_table($redshift, 'page_views', $view_vals, [], ['view_id' => $view['viewId']]);
        upsert_table($redshift, 'sessions', $session_vals, [], ['session_id' => $session['sessionId']]);
        if($counter==5)
            exit;
    }

    echo "Events processed so far $events_processed and missed $events_missed\n";

    $cursor = $list[0];

} while($cursor != '0');

echo "Done processing events\n";
writeLog($file_path, "Done processing events");

function upsert_table(PDO $connection, $table, $update_vals, $insert_vals, $where)
{
   
    /*$set_clause = format_parameters(array_keys($update_vals), function ($v) {
        return "$v = :$v";
    });
    $where_clause = format_parameters(array_keys($where), function ($v) {
        return "$v = :$v";
    });
    
    $select_statement = "SELECT * FROM $table WHERE $where_clause";
    $statement = $connection->prepare($select_statement);
    $statement->execute(prefix_bind_parameters($where));
    $rows = $statement->rowCount();
    
    if($rows){ // row exists; execute update
        $update_statement = "UPDATE $table SET $set_clause WHERE $where_clause;";

        $statement = $connection->prepare($update_statement);
        //$statement->execute(array_merge($update_vals, $where));
        $statement->execute(prefix_bind_parameters(array_merge($update_vals, $where)));
        $result = $statement->rowCount();
        
    }else { // row non-existent; execute insert

        $full_insert_vals = array_merge($where, $update_vals, $insert_vals);
        $keys_clause = format_parameters(array_keys($full_insert_vals), function ($v) {
            return $v;
        });
        $values_clause = format_parameters(array_keys($full_insert_vals), function ($v) {
            return ":$v";
        });
        $insert_statement = "INSERT INTO $table ($keys_clause) VALUES ($values_clause);";
        $statement = $connection->prepare($insert_statement);
        //$statement->execute($full_insert_vals);
        $statement->execute(prefix_bind_parameters($full_insert_vals));
        $result = $statement->rowCount();
    }*/
    $set_clause = format_parameters(array_keys($update_vals), function ($v) {
        return "$v = :$v";
    });
    $where_clause = format_parameters(array_keys($where), function ($v) {
        return "$v = :$v";
    });
    $update_statement = "UPDATE $table SET $set_clause WHERE $where_clause;";
    
    $statement = $connection->prepare($update_statement);
    $statement->execute(prefix_bind_parameters(array_merge($update_vals, $where)));
    $result = $statement->rowCount();

    if (!$result) {

        $full_insert_vals = array_merge($where, $update_vals, $insert_vals);
        $keys_clause = format_parameters(array_keys($full_insert_vals), function ($v) {
            return $v;
        });
        $values_clause = format_parameters(array_keys($full_insert_vals), function ($v) {
            return ":$v";
        });
        $insert_statement = "INSERT INTO $table ($keys_clause) VALUES ($values_clause);";
        $statement = $connection->prepare($insert_statement);
        $statement->execute(prefix_bind_parameters($full_insert_vals));
        $result = $statement->rowCount();
    }
   
    
    return $result;

}

function format_parameters($params, callable $callback, $glue = ', ')
{

    if (!is_array($params)) {
        $params = [$params];
    }
    
    foreach ($params as $key => $value) {
        $params[$key] = $callback($value);
    }

    return implode($glue, $params);
}

function prefix_bind_parameters($array)
{
    $bind_params_array = array_combine(
    array_map(function($k){ return ':'.$k; }, array_keys($array)),
    $array
    );
    
    return $bind_params_array;
}