<?php



// connect to mongodb
$m = new MongoClient('mongodb://tradesmart:sHL5hQPFTMdWKsjksw@mongo-dev.smedia.ca:27017/?authSource=tradesmart_dev&readPreference=primary&appname=MongoDB%20Compass%20Community&ssl=false');

echo "Connection to database successfully";
// select a database
$db = $m->mydb;

echo "Database mydb selected";


echo '<pre>';
print_r($db);
