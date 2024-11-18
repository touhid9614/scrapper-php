<?php

require_once __DIR__ . '/loader.php';

use Predis\Client as RedisClient;

$redis = new RedisClient($redis_config);

$redshift = new PDO(
    "pgsql:dbname={$event_db_config['dbname']};host={$event_db_config['host']};port={$event_db_config['port']}",
    $event_db_config['user'], $event_db_config['pass']
);

$cursor = '0';

echo "Starting to process\n";

$user_processed = 0;

do {

    echo "Requesting with cursor $cursor\n";

    $list = $redis->scan($cursor, ['MATCH' => 'user_*', 'COUNT' => 10000]);

    $user_processed += count($list[1]);
    foreach ($list[1] as $user_key) {
        $user = $redis->hgetall($user_key);
        $vals = [
            'last_visited' => $user['lastVisit'],
            'last_updated' => $user['lastUpdate'],
        ];
        upsert_table($redshift, 'users', $vals, [], ['user_id' => $user['userId']]);
    }

    $cursor = $list[0];

} while ($cursor != '0');

function upsert_table(PDO $connection, $table, $update_vals, $insert_vals, $where)
{
    $set_clause = format_parameters(array_keys($update_vals), function ($v) {
        return "$v = :$v";
    });
    $where_clause = format_parameters(array_keys($where), function ($v) {
        return "$v = :$v";
    });
    $update_statement = "UPDATE $table SET $set_clause WHERE $where_clause;";

    $statement = $connection->prepare($update_statement);
    $statement->execute(array_merge($update_vals, $where));
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
        $statement->execute($full_insert_vals);

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