<?php

require_once __DIR__ . '/loader.php';

use Predis\Client as RedisClient;

$redis = new RedisClient($redis_config);


$cursor = 0;

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

    $cursor = $list[0];

} while($cursor != 0);

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