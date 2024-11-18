<?php

$test_url1 = 'https://www.titanauto.ca/inventory/2017-acura-rdx-elite-awd-cam-leather-nav-htd-seats-awd-sport-utility-5j8tb4h7xhl804785?smedia_debug=true';
$test_url2 = 'https://www.titanauto.ca/inventory/2017-acura-rdx-elite-awd-cam-leather-nav-htd-seats-awd-sport-utility-5j8tb4h7xhl804785/?smedia_debug=true';
$test_url3 = 'https://www.alexandriacampingcentre.com/default.asp?page=xNewInventoryDetail&id=6951817&p=1&s=Year&d=D&t=new&fr=xNewInventory';

$required_params = ['page','id'];

function url_to_svin($url, $required_params = []) {
    if(!is_array($required_params)) { $required_params = []; }
    #Create a key value pair to get key intersection
    $required_query = array_combine($required_params, $required_params);

    #Parse the URL
    $components = parse_url($url);
    $path = rtrim($components['path'], '/');

    $queries     = [];
    parse_str($components['query'], $queries);

    #Clear unwanted parameters
    $valid_queries = http_build_query(array_intersect_key($queries, $required_query));

    #Generate the identity
    $identity = strtolower("$path?$valid_queries");

    #Returnt the hash
    return hash('sha256', $identity);
}

echo url_to_svin($test_url1) . "<br/>";
echo url_to_svin($test_url2, null) . "<br/>";
echo url_to_svin($test_url3, $required_params) . "<br/>";