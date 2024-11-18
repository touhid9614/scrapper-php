<?php

function config_keys_enclosed($config, $leading_key) {
    if(!endsWith($leading_key, '[')) {
        $leading_key .= '[';
    }
    $trailing_key = ']';
    if(!isset($config['fields'])) {return $config; }
    
    $fields = [];
    
    foreach($config['fields'] as $key => $value) {
        if(isset($value['conditions'])) {
            foreach($value['conditions'] as $kv => $condition) {
                
                $names = [];
                
                foreach($condition as $c) {
                    $names[] = $leading_key . $c . $trailing_key;
                }
                
                $value['conditions'][$kv] = $names;
            }
        }
        $fields[$leading_key . $key . $trailing_key] = $value;
    }
    
    $config['fields'] = $fields;
    
    return $config;
}

function array_asoc_to_named($arr) {
    
    $retval = [];
    
    foreach($arr as $name => $val) {
        if(!is_array($val)) { $val = ['value' => $val ]; }
        $val['name'] = $name;
        
        $retval[] = $val;
    }
    
    return $retval;
}

function array_named_to_asoc($arr) {
    
    $retval = [];
    
    foreach($arr as $val) {
        if(!is_array($val) || !key_exists('name', $val)) { continue; }
        
        $name = $val['name'];
        
        unset($val['name']);
        
        $retval[$name] = $val;
    }
    
    return $retval;
}

function array_remake($data, $prefix = '') {
    $retval = [];
    
    foreach($data as $k => $v) {
        if($prefix) {
            $k = "{$prefix}[$k]";
        }
        
        $retval[$k] = $v;
        
        if(is_array($v)) {
            $retval = array_merge($retval, array_remake($v, $k));
        }
    }
    
    return $retval;
}

function array_asoc_to_pair($arr) {
    $retval = [];
    
    foreach($arr as $key => $value) {
        $retval[] = [$key, $value];
    }
    
    return $retval;
}

function array_pair_to_assoc($arr) {
    $retval = [];
    
    foreach($arr as $value) {
        if(!is_array($value) || count($value) != 2) { continue; }
        $retval[$value[0]] = $value[1];
    }
    
    return $retval;
}