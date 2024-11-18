<?php

require_once __DIR__ . '/loader.php';

$redshift = new PDO(
    "pgsql:dbname={$event_db_config['dbname']};host={$event_db_config['host']};port={$event_db_config['port']}",
    $event_db_config['user'], $event_db_config['pass']
);

#var_dump(getSessionFilePath('http://www.barbermotors.com/VehicleDetails/new-2018-Chevrolet-Equinox-LT-Weyburn-SK/3208615633'));
#var_dump(getUserFilePath('1a242130bc851f3cc37a2c13c3c6ca2e6a31b22589ba628a62fd265dfebef4a5'));

upsert_table($redshift, 'test_table', ['content' => 'test string 4'], [], ['id' => 4]);



function upsert_table(PDO $connection, $table, $update_vals, $insert_vals, $where)
{
   
    $connection->beginTransaction();
    $set_clause = format_parameters(array_keys($update_vals), function ($v) {
        return "$v = :$v";
    });
    $where_clause = format_parameters(array_keys($where), function ($v) {
        return "$v = :$v";
    });
    $update_statement = "UPDATE $table SET $set_clause WHERE $where_clause;";
    echo $update_statement.PHP_EOL;
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
        echo $insert_statement.PHP_EOL;
        $statement = $connection->prepare($insert_statement);
        $statement->execute($full_insert_vals);
        $result = $statement->rowCount();
    }
    $connection->commit();
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