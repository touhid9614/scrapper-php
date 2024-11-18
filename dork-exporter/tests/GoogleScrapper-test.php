<?php

ini_set ( 'max_execution_time', 0);

require_once dirname(__DIR__) . '/includes/GoogleScrapper.php';


$obj=new GoogleScraper();

// Pass your keyword and proxy ip here.
$arr=$obj->getUrlList(urlencode('2019 Mazda CX-3 GT Calgary'), '50.117.102.127:1212', 'user-06440:3k9ZArLGx62Q6Wv7');

print_r($arr);