<?php

define('PREPARE_PARENTHESES', 1); //For Insert
define('PREPARE_EQUAL', 2); //For Update/Where

function prepare_query_params($params, $prepare_type = PREPARE_EQUAL)
{
    unset($params['id']);

    foreach ($params as $key => $value) {

        $value = is_array($value) ? serialize($value) : $value;

        if ($prepare_type == PREPARE_EQUAL) {
            $value = "$key='$value'";
        } else {
            $value = "'$value'";
        }

        $params[$key] = $value;
    }

    return $prepare_type == PREPARE_EQUAL ? implode(', ', array_values($params)) : "(" . implode(', ', array_keys($params)) . ") VALUES (" . implode(', ', array_values($params)) . ")";
}
