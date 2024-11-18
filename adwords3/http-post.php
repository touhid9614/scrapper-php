<?php
    error_reporting(E_ERROR);
    ini_set('display_errors', 1);
    require_once 'utils.php';

/*$url            = 'https://www.motorinnautogroup.com/Incentives/GetBestOffer';
$post_data      = 'vid=4313494&category=';
$content_type   = 'text/html;';
$in_cookies     = '';
$out_cookies    = '';
$resp = HttpPost($url, $post_data, $in_cookies, $out_cookies);

if($out_cookies) {
    $in_cookies = $out_cookies;
}

print_r($resp);*/

$nlp_api 		= "https://crawler-dev.smedia.ca/";
$nlp_add_api 	= $nlp_api . "api/domains/add/";

$postData 		=
[
    "id"        => null,
    "hostname"  => "www.fakedealer.com",
    "scheme"    => "https",
    "status"    => "",
    "enabled"   => true
];

$out_cookies 	= '';
$in_cookies 	= '';
$content_type 	= 'application/json';

$res = HttpPost($nlp_add_api, json_encode($postData), $in_cookies, $out_cookies, false, false, $content_type);
//$res = HttpPost($nlp_add_api, $postData, $in_cookies, $out_cookies, false, false, $content_type);
print_r($res);


/*$url = 'http://server.com/path';
$data = array('key1' => 'value1', 'key2' => 'value2');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($postData)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($nlp_add_api, false, $context);


var_dump($result);*/

/*function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

$tes = httpPost($nlp_add_api, $postData);
var_dump($tes);*/