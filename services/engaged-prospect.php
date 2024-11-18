<?php

use Illuminate\Database\Capsule\Manager as DB;

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";
require_once $adwords_dir . 'config.php';
require_once $base_dir . 'includes/init-db.php';
require_once $adwords_dir . 'utils.php';

$client = new MongoDB\Client(
    'mongodb://smedia:6Qrt2WPqd4qB3HUvzG@mongo-dev.smedia.ca:27017/smedia_apps?authSource=admin&readPreference=primary&appname=smedia&ssl=false'
);

$db                   = $client->smedia_apps;
$dealershipCollection = $db->dealerships;

// $insertOneResult = $collection->insertOne([
// 'username' => 'admin',
// 'email' => 'admin@example.com',
// 'name' => 'Admin User',
// ]);

// printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

// var_dump($insertOneResult->getInsertedId());
//

$cursors = $dealershipCollection->find();

$dealership_domains = [];

$query = DB::table('dealerships')->select(['dealership', 'websites']);

foreach ($cursors as $dealership) {
    $id                             = (array) $dealership['_id'];
    $dealership_domains[$id['oid']] = $dealership['domain'];
    $query->orWhere('websites', 'regexp', "^https{0,1}://(www.)*({$dealership['domain']})/*");
}

$results = $query->get();
// $sql = vsprintf(str_replace(array('?'), array('\'%s\''), $query->toSql()), $query->getBindings());

//$results = DB::select("SELECT dealership,  REGEXP_REPLACE(websites, '^https{0,1}://(www.)*([^/]+)/*', '\\\\2') as domain FROM dealerships WHERE REGEXP_REPLACE(websites, '^https{0,1}://(www.)*([^/]+)/*', '\\\\2') IN ('" . implode("', '", $dealership_domains) . "')");

$dealerships = [];
foreach ($results as $r) {
    $domain = preg_replace("/^https{0,1}:\/\/(www.)*([^\/]*)\/.*/", '$2', $r->websites);
    $id     = array_search($domain, $dealership_domains);
    if ($id) {
        //$dealerships[$id] = $r->dealership;
        $dealerships[$r->dealership] = $id;
    }
}

$query = "SELECT dealership ,DATE_FORMAT(day,'%Y-%m-01') as month, SUM(count) as total  FROM engaged_vdp
WHERE dealership IN ('" . implode("', '", array_keys($dealerships)) . "')
GROUP BY dealership ,month ORDER BY dealership, day;";

$results = DB::select($query);

// $query = DB::table('engaged_vdp')
// ->select(['dealership', DB::raw("DATE_FORMAT(day,'%Y-%m-01') as month"), DB::raw('SUM(count) as total')])
// ->where('dealership', 'IN', "('" . implode("', '", array_keys($dealerships)) . "')");
// $results = $query->get();
// exit();

//$sql = vsprintf(str_replace(array('?'), array('\'%s\''), $query->toSql()), $query->getBindings());

$json_format = '{ "dealerId": "%s", "key" : "engagedProspective", "data" : { "date" : "%s", "count": %s } }';

foreach ($results as $r) {
    $post_data = vsprintf($json_format, [$dealerships[$r->dealership], $r->month, $r->total]);
    $res       = HttpPost('https://api-dev.smedia.ca/engaged-prospect', $post_data, '', $nothing, false, false, 'application/json');
    echo $post_data;
    echo "<br>";
    echo $res;
    echo "<br><br>";
}
