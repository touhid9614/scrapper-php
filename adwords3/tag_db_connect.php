<?php

if (!defined("STOP_ADDING_CONFIG_PHP_EVERYWHERE_FOR_CRYING_OUT_LOUD")) {
    require_once __DIR__ . '/config.php';
}

require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/uuid.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

global $db_config, $offers, $offers_checked, $connection;

/**
 * { function_description }
 *
 * @param      <type>  $escapestr  The escapestr
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function tagdb_real_escape_string($escapestr)
{
    return mysqli_real_escape_string(DbConnect::get_connection_write(), $escapestr);
}

/**
 * { function_description }
 *
 * @param      <type>  $query  The query
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function tagdb_query($query)
{
    $queryType = strtok(trim($query), " ");

    if ((strtolower($queryType) == "select") || (strtolower($queryType) == "show")) {
        return mysqli_query(DbConnect::get_connection_read(), $query);
    } else {
        return mysqli_query(DbConnect::get_connection_write(), $query);
    }
}

/**
 * Stores an adwords tag.
 *
 * @param      <type>  $url            The url
 * @param      <type>  $cron_name      The cron name
 * @param      <type>  $year           The year
 * @param      <type>  $make           The make
 * @param      <type>  $model          The model
 * @param      <type>  $conversion_id  The conversion identifier
 * @param      <type>  $label          The label
 * @param      <type>  $userlist_id    The userlist identifier
 */
function store_adwords_tag($url, $cron_name, $year, $make, $model, $conversion_id, $label, $userlist_id)
{
    $query = "Insert into tracker_tags (url, cron_name, year, make, model, conversion_id, label, userlist_id) values ('"
    . tagdb_real_escape_string($url) . "', '"
    . tagdb_real_escape_string($cron_name) . "', '"
    . tagdb_real_escape_string($year) . "', '"
    . tagdb_real_escape_string($make) . "', '"
    . tagdb_real_escape_string($model) . "', '"
    . tagdb_real_escape_string($conversion_id) . "', '"
    . tagdb_real_escape_string($label) . "', '"
    . tagdb_real_escape_string($userlist_id) . "');";

    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>         $cron_name  The cron name
 * @param      <type>         $year       The year
 * @param      <type>         $make       The make
 * @param      <type>         $model      The model
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function retrive_tag($cron_name, $year, $make, $model)
{
    $query = "SELECT conversion_id, label, userlist_id FROM tracker_tags WHERE "
	. "cron_name = '" . tagdb_real_escape_string($cron_name)
	. "' AND year = '" . tagdb_real_escape_string($year)
	. "' AND make = '" . tagdb_real_escape_string($make)
	. "' AND model = '" . tagdb_real_escape_string($model) . "';";

    $result = tagdb_query($query);

    $to_return = false;

    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row) {
            $to_return = [
                'conversion_id' => $row['conversion_id'],
                'label'         => $row['label'],
                'userlist_id'   => $row['userlist_id']
            ];
        }
    }

    mysqli_free_result($result);

    return $to_return;
}

/**
 * { function_description }
 *
 * @param      <type>         $url    The url
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function retrive_adwords_tag($url)
{
    //insert
    $query = "SELECT cron_name, conversion_id, label, userlist_id FROM tracker_tags WHERE url='"
    . tagdb_real_escape_string($url) . "';";

    $result = tagdb_query($query);

    $to_return = false;

    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row) {
            $to_return = [
                'cron_name'     => $row['cron_name'],
                'conversion_id' => $row['conversion_id'],
                'label'         => $row['label'],
                'userlist_id'   => $row['userlist_id']
            ];
        }
    }

    mysqli_free_result($result);

    return $to_return;
}

/**
 * Stores a combined userlist.
 *
 * @param      <type>  $cron_name    The cron name
 * @param      <type>  $userlist_id  The userlist identifier
 */
function store_combined_userlist($cron_name, $userlist_id)
{
    $query = "INSERT INTO combined_userlist (cron_name, userlist_id) VALUES ('"
    . tagdb_real_escape_string($cron_name) . "', '"
    . tagdb_real_escape_string($userlist_id) . "');";

    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>   $cron_name  The cron name
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function retrive_combined_userlist($cron_name)
{
    $query = "SELECT userlist_id FROM combined_userlist WHERE cron_name = '"
    . tagdb_real_escape_string($cron_name) . "';";

    $result = tagdb_query($query);
    $to_return = false;

    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row) {
            $to_return = $row['userlist_id'];
        }
    }

    mysqli_free_result($result);

    return $to_return;
}

/**
 * Creates a meta table.
 *
 * @param      string  $meta_name  The meta name
 */
function create_meta_table($meta_name)
{
    $query = "CREATE TABLE IF NOT EXISTS "
    . tagdb_real_escape_string($meta_name . "_meta_data") . " (
        meta_key varchar(255) NOT NULL DEFAULT '',
        meta_value longtext NOT NULL,
        PRIMARY KEY (meta_key)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    tagdb_query($query);
}

/**
 * Gets the meta.
 *
 * @param      string  $meta_name  The meta name
 * @param      <type>  $meta_key   The meta key
 *
 * @return     <type>  The meta.
 */
function get_meta($meta_name, $meta_key)
{
    $query = "SELECT meta_value FROM " . tagdb_real_escape_string($meta_name . "_meta_data")
    . " WHERE meta_key = '" . tagdb_real_escape_string($meta_key) . "';";

    $result = tagdb_query($query);
    $to_return = null;

    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row) {
            $to_return = unserialize($row['meta_value']);
        }
    }

    mysqli_free_result($result);

    return $to_return;
}

/**
 * Gets the keys by value.
 *
 * @param      string  $meta_name  The meta name
 * @param      <type>  $meta_key   The meta key
 *
 * @return     <type>  The meta.
 */
function get_keys($meta_name, $meta_value)
{
    $query = "SELECT meta_key FROM " . tagdb_real_escape_string($meta_name . "_meta_data")
    . " WHERE meta_value LIKE '%" . tagdb_real_escape_string($meta_value) . "%';";

    $result = tagdb_query($query);
	$keys = [];

    while ($row = mysqli_fetch_array($result)) {
		$keys[] = $row['meta_key'];
    }

    mysqli_free_result($result);

    return $keys;
}

/**
 * { function_description }
 *
 * @param      string  $meta_name   The meta name
 * @param      <type>  $meta_key    The meta key
 * @param      <type>  $meta_value  The meta value
 */
function update_meta($meta_name, $meta_key, $meta_value = null)
{
    $prev  = get_meta($meta_name, $meta_key);
    $query = null;

    if (is_null($meta_value)) {
        if (!is_null($prev)) {
            $query = "DELETE FROM " . tagdb_real_escape_string($meta_name . "_meta_data")
            . " WHERE meta_key = '" . tagdb_real_escape_string($meta_key) . "';";
        }
    } else {
        $data = serialize($meta_value);

        if (is_null($prev)) {
            $query = "INSERT INTO " . tagdb_real_escape_string($meta_name . "_meta_data")
            . " (meta_key, meta_value) VALUES ('"
            . tagdb_real_escape_string($meta_key) . "', '"
            . tagdb_real_escape_string($data) . "');";
        } else {
            $query = "UPDATE " . tagdb_real_escape_string($meta_name . "_meta_data")
            . " SET meta_value = '" . tagdb_real_escape_string($data) . "' "
            . " WHERE meta_key = '" . tagdb_real_escape_string($meta_key) . "';";
        }
    }

    if (!is_null($query)) {
        tagdb_query($query);
    }
}

/**
 * Gets the car data by field value.
 *
 * @param      <type>  $cron_name    The cron name
 * @param      <type>  $field_name   The field name
 * @param      <type>  $field_value  The field value
 *
 * @return     <type>  The car data by.
 */
function get_car_data_by($cron_name, $field_name, $field_value)
{
    return get_car_data($cron_name, "{$field_name} = '" . tagdb_real_escape_string($field_value) . "'");
}

/**
 * { function_description }
 *
 * @param      string  $cron_name  The cron name
 */
function check_offers($cron_name)
{
    global $offers, $offers_checked;

    if (!$offers_checked) {
        $offers_checked = true;
        $file           = __DIR__ . '/price-pool/' . $cron_name . '.json';

        if (file_exists($file)) {
            $offers = json_decode(file_get_contents($file));
        }
    }
}

/**
 * Gets the car data.
 *
 * @param      string         $cron_name  The cron name
 * @param      <type>         $where      The where
 *
 * @return     array|boolean  The car data.
 */
function get_car_data($cron_name, $where)
{
    global $offers, $debug;

    $query = "SELECT * FROM " . tagdb_real_escape_string($cron_name . "_scrapped_data") . " WHERE ($where) and deleted = 0;";

    if ($debug) {
        echo "// {$query}";
    }

    check_offers($cron_name);
    $result    = tagdb_query($query);
    $to_return = false;

    if ($result) {
        $row = mysqli_fetch_array($result);

        if ($row) {
            $all_images   = $row["all_images"];
            $images_array = explode("|", $all_images);

            if (count($images_array) >= 1) {
                $main_photo = $images_array[0];
            } else {
                $main_photo = '';
            }

            $to_return = [
                "stock_number"   => $row["stock_number"],
                "vin"            => $row["vin"],
                "svin"           => $row["svin"],
                "vehicle_id"     => $row["vehicle_id"],
                "stock_type"     => $row["stock_type"],
                "year"           => $row["year"],
                "make"           => $row["make"],
                "model"          => $row["model"],
                "trim"           => $row["trim"],
                "price"          => $row["price"],
                "msrp"           => $row["msrp"],
                "price_history"  => $row["price_history"] ? unserialize($row["price_history"]) : [],
                "body_style"     => $row["body_style"],
                "engine"         => $row["engine"],
                "cylinder"       => $row["cylinder"],
                "passenger"      => $row["passenger"],
                "doors"          => $row["doors"],
                "warranty"       => $row["warranty"],
                "transmission"   => $row["transmission"],
                "kilometers"     => $row["kilometres"],
                "kilometres"     => $row["kilometres"],
                "color"          => $row["exterior_color"],
                "interior_color" => $row["interior_color"],
                "fuel_type"      => $row["fuel_type"],
                "drivetrain"     => $row["drivetrain"],
                "url"            => $row["url"],
                "host"           => $row["host"],
                "custom"         => $row["custom"],
                "arrival_date"   => $row["arrival_date"],
                "handled_at"     => $row["handled_at"],
                "certified"      => $row["certified"] ? 1 : 0,
                "deleted"        => $row["deleted"] ? 1 : 0,
                "description"    => $row["description"],
                "main_photo"     => $main_photo,
                "all_images"     => $all_images
            ];

            if (isset($row["cylinder"]) && $row["cylinder"]) {
                $to_return["cylinder"] = (int) ($row["cylinder"]);
            }

            if (isset($row["doors"]) && $row["doors"]) {
                $to_return["doors"] = (int) ($row["doors"]);
            }

            if (isset($row["passenger"]) && $row["passenger"]) {
                $to_return["passenger"] = (int) ($row["passenger"]);
            }

            if (isset($row["warranty"]) && $row["warranty"]) {
                $to_return["warranty"] = $row["warranty"];
            }

            if ($offers && property_exists($offers, $row["url"])) {
                $to_return['price'] = $offers->{$row["url"]}->sale;
                $to_return['was']   = $offers->{$row["url"]}->price;
            }
        }
    }

    mysqli_free_result($result);

    return $to_return;
}

/**
 * Gets the url variations.
 *
 * @param      <type>  $_url   The url
 *
 * @return     array   The url veriations.
 */
function get_url_veriations($_url)
{
    $url  = str_replace('http:', '', str_replace('https:', '', $_url));
    $urls = [$url];

    if (endsWith($url, '/')) {
        $urls[] = substr($url, 0, strlen($url) - 1);
    } else {
        $urls[] = $url . '/';
    }

    $host_name = parse_url($url, PHP_URL_HOST);

    if (startsWith($host_name, 'www.')) {
        $new_host = substr($host_name, 4);
    } else {
        $new_host = 'www.' . $host_name;
    }

    $retval = $urls;

    foreach ($urls as $url) {
        $retval[] = str_replace($host_name, $new_host, $url);
    }

    return $retval;
}

/**
 * Creates an url where.
 *
 * @param      <type>          $url              The url
 * @param      array           $required_params  The required parameters
 *
 * @return     boolean|string  ( description_of_the_return_value )
 */
function create_url_where($url, $required_params = [])
{
    $url_data = parse_url($url);
    $base_url = "//{$url_data['host']}{$url_data['path']}";
    $urls     = get_url_veriations($base_url);

    $where = '(';

    foreach ($urls as $_url) {
        if ($where != '(') {
            $where .= ' OR ';
        }

        $where .= "url like '%" . tagdb_real_escape_string($_url) . "%'";
    }

    if ($where) {
        $where .= ")";
    }

    $queries = [];
    parse_str($url_data['query'], $queries);

    foreach ($required_params as $param) {
        if (!isset($queries[$param])) {
            return false;
        }

        $queries[$param] = mild_url_encode($queries[$param], $required_params);
        $where .= " AND (url like '%?$param={$queries[$param]}&%' OR url like '%?$param={$queries[$param]}' OR url like '%&$param={$queries[$param]}&%' OR url like '%&$param={$queries[$param]}')";
    }

    return $where;
}

function get_all_active_cars($cron_name)
{
    global $offers;

    check_offers($cron_name);

    $query = "SELECT * FROM "
    . tagdb_real_escape_string($cron_name . "_scrapped_data")
    . " WHERE deleted = 0;";

    $result = tagdb_query($query);

    $to_return = [];

    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $all_images   = $row["all_images"];
            $images_array = explode("|", $all_images);

            if (count($images_array) >= 1) {
                $main_photo = $images_array[0];
            } else {
                $main_photo = '';
            }

            $to_return[$row["stock_number"]] = [
                "stock_number"   => $row["stock_number"],
                "vin"            => $row["vin"],
                "svin"           => $row["svin"],
                "vehicle_id"     => $row["vehicle_id"],
                "stock_type"     => $row["stock_type"],
                "year"           => $row["year"],
                "make"           => $row["make"],
                "model"          => $row["model"],
                "trim"           => $row["trim"],
                "price"          => $row["price"],
                "msrp"           => $row["msrp"],
                "price_history"  => $row["price_history"] ? unserialize($row["price_history"]) : [],
                "body_style"     => $row["body_style"],
                "engine"         => $row["engine"],
                "cylinder"       => $row["cylinder"],
                "passenger"      => $row["passenger"],
                "doors"          => $row["doors"],
                "warranty"       => $row["warranty"],
                "transmission"   => $row["transmission"],
                "kilometers"     => $row["kilometres"],
                "kilometres"     => $row["kilometres"],
                "color"          => $row["exterior_color"],
                "interior_color" => $row["interior_color"],
                "fuel_type"      => $row["fuel_type"],
                "drivetrain"     => $row["drivetrain"],
                "url"            => $row["url"],
                "host"           => $row["host"],
                "custom"         => $row["custom"],
                "arrival_date"   => $row["arrival_date"],
                "handled_at"     => $row["handled_at"],
                "certified"      => $row["certified"] ? 1 : 0,
                "deleted"        => $row["deleted"] ? 1 : 0,
                "description"    => $row["description"],
                "main_photo"     => $main_photo,
                "all_images"     => $all_images
            ];

            if (isset($row["cylinder"]) && $row["cylinder"]) {
                $to_return[$row["stock_number"]]["cylinder"] = (int) ($row["cylinder"]);
            }

            if (isset($row["doors"]) && $row["doors"]) {
                $to_return[$row["stock_number"]]["doors"] = (int) ($row["doors"]);
            }

            if (isset($row["passenger"]) && $row["passenger"]) {
                $to_return[$row["stock_number"]]["passenger"] = (int) ($row["passenger"]);
            }

            if (isset($row["warranty"]) && $row["warranty"]) {
                $to_return[$row["stock_number"]]["warranty"] = $row["warranty"];
            }

            if ($offers && property_exists($offers, $row["url"])) {
                $to_return[$row["stock_number"]]['price'] = $offers->{$row["url"]}->sale;
                $to_return[$row["stock_number"]]['was']   = $offers->{$row["url"]}->price;
            }
        }
    }

    mysqli_free_result($result);

    return $to_return;
}

/**
 * Gets the customer by uuid.
 *
 * @param      <type>         $uuid   The uuid
 *
 * @return     array|boolean  The customer by uuid.
 */
function get_customer_by_uuid($uuid)
{
    $query = "SELECT id, uuid, name, email, phone FROM smart_offer_customers WHERE uuid = '"
    . tagdb_real_escape_string($uuid) . "'";

    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $row = mysqli_fetch_array($result);

    if (!$row) {
        return false;
    }

    $retval = [
        'id'    => $row['id'],
        'uuid'  => $row['uuid'],
        'name'  => $row['name'],
        'email' => $row['email'],
        'phone' => $row['phone']
    ];

    mysqli_free_result($result);

    return $retval;
}

/**
 * Gets the customers by email.
 *
 * @param      <type>         $email  The email
 *
 * @return     array|boolean  The customers by email.
 */
function get_customers_by_email($email)
{
    $query = "SELECT id, uuid, name, email, phone FROM smart_offer_customers WHERE email = '" . tagdb_real_escape_string($email) . "'";
    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $retval = [];

    while ($row = mysqli_fetch_array($result)) {
        $retval[] = [
            'id'    => $row['id'],
            'uuid'  => $row['uuid'],
            'name'  => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone']
        ];
    }

    mysqli_free_result($result);

    return $retval;
}

/**
 * Creates a customer.
 *
 * @param      <type>  $uuid   The uuid
 * @param      string  $name   The name
 * @param      string  $email  The email
 * @param      string  $phone  The phone
 */
function create_customer($uuid, $name = '', $email = '', $phone = '')
{
    $query = "INSERT INTO smart_offer_customers (uuid, name, email, phone) VALUES ('" . tagdb_real_escape_string($uuid) . "', '" . tagdb_real_escape_string($name) . "', '"
    . tagdb_real_escape_string($email) . "', '" . tagdb_real_escape_string($phone) . "')";

    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>  $uuid   The uuid
 * @param      <type>  $name   The name
 * @param      <type>  $email  The email
 * @param      <type>  $phone  The phone
 */
function update_customer($uuid, $name, $email, $phone)
{
    $query = "UPDATE smart_offer_customers SET name = '" . tagdb_real_escape_string($name) . "', "
    . "email = '" . tagdb_real_escape_string($email) . "', "
    . "phone = '" . tagdb_real_escape_string($phone) . "' WHERE uuid = '"
    . tagdb_real_escape_string($uuid) . "'";
    tagdb_query($query);
}

/**
 * Creates a smart offer customers fillups data.
 *
 * @param      <type>  $uuid              The uuid
 * @param      string  $dealership        The dealership
 * @param      string  $url               The url
 * @param      string  $referrer          The referrer
 * @param      string  $nearest_location  The nearest location
 * @param      string  $client_ip         The client ip
 */
function create_smart_offer_customers_fillups_data($uuid, $dealership = '', $url = '', $referrer = '', $nearest_location = '', $client_ip = '')
{
    $query = "INSERT INTO smart_offer_customers_fillups_data (uuid, dealership, url, referrer, nearest_location, client_ip) VALUES ('" . tagdb_real_escape_string($uuid) . "', '" . tagdb_real_escape_string($dealership) . "', '" . tagdb_real_escape_string($url) . "', '" . tagdb_real_escape_string($referrer) . "', '" . tagdb_real_escape_string($nearest_location) . "' , '" . $client_ip . "')";
    tagdb_query($query);
}

/**
 *
 * @param   type $uuid  uuid for current session (this is record is merged with any other existing session and deleted, if no other is present, then this record is kept as is)
 * @return  type $uuid  uuid for other session (used to replace current sessions uuid
 */
function merge_customers($uuid)
{
    # Todo: Complete merge customers (can't work from within ajax requests)
}

/**
 * { function_description }
 *
 * @param      <type>  $uuid        The uuid
 * @param      <type>  $dealership  The dealership
 */
function customer_add_view($uuid, $dealership)
{
    $views = customer_get_views($uuid, $dealership);

    if ($views) {
        $views['count']++;
        $views['at'][] = time();
        customer_update_views($views);
    } else {
        customer_create_views([
            'uuid'       => $uuid,
            'dealership' => $dealership,
            'count'      => 1,
            'at'         => [time()]
        ]);
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $uuid        The uuid
 * @param      <type>  $dealership  The dealership
 */
function customer_add_fillup($uuid, $dealership)
{
    $fillups = customer_get_fillups($uuid, $dealership);

    if ($fillups) {
        $fillups['count']++;
        $fillups['at'][] = time();

        if (count($fillups['at']) > 2) {
            $fillups['at'] = array_slice($fillups['at'], count($fillups['at']) - 2);
        }

        customer_update_fillups($fillups);
    } else {
        customer_create_fillups([
            'uuid'       => $uuid,
            'dealership' => $dealership,
            'count'      => 1,
            'at'         => [time()]
        ]);
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $value  The value
 */
function customer_create_views($value)
{
    $customer = get_customer_by_uuid($value['uuid']);

    if (!$customer) {
        create_customer($value['uuid']);
    }

    $query = "INSERT INTO smart_offer_customer_views (uuid, dealership, count, at) VALUES ("
    . "'" . tagdb_real_escape_string($value['uuid']) . "', " . "'" . tagdb_real_escape_string($value['dealership']) . "', " . "'{$value['count']}', " . "'" . tagdb_real_escape_string(serialize($value['at'])) . "')";
    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>  $value  The value
 */
function customer_update_views($value)
{
    $query = "UPDATE smart_offer_customer_views SET "
    . "count = '{$value['count']}', at = '" . tagdb_real_escape_string(serialize($value['at'])) . "' WHERE uuid = '" . tagdb_real_escape_string($value['uuid']) . "' AND dealership = '" . tagdb_real_escape_string($value['dealership']) . "';";
    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>  $value  The value
 */
function customer_create_fillups($value)
{
    $customer = get_customer_by_uuid($value['uuid']);

    if (!$customer) {
        create_customer($value['uuid']);
    }

    $query = "INSERT INTO smart_offer_customer_fillups (uuid, dealership, count, at) VALUES ("
    . "'" . tagdb_real_escape_string($value['uuid']) . "', " . "'" . tagdb_real_escape_string($value['dealership']) . "', " . "'{$value['count']}', " . "'" . tagdb_real_escape_string(serialize($value['at'])) . "')";
    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>  $value  The value
 */
function customer_update_fillups($value)
{
    $query = "UPDATE smart_offer_customer_fillups SET "
    . "count = '{$value['count']}', at = '" . tagdb_real_escape_string(serialize($value['at'])) . "' WHERE uuid = '" . tagdb_real_escape_string($value['uuid']) . "' AND dealership = '" . tagdb_real_escape_string($value['dealership']) . "';";
    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>         $uuid        The uuid
 * @param      <type>         $dealership  The dealership
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function customer_get_views($uuid, $dealership)
{
    $query = "SELECT id, uuid, dealership, count, at FROM smart_offer_customer_views WHERE uuid = '" . tagdb_real_escape_string($uuid) . "' AND dealership = '" . tagdb_real_escape_string($dealership) . "';";

    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $row = mysqli_fetch_array($result);

    if (!$row) {
        return false;
    }

    $retval = [
        'id'         => $row['id'],
        'uuid'       => $row['uuid'],
        'dealership' => $row['dealership'],
        'count'      => $row['count'],
        'at'         => unserialize($row['at'])
    ];

    mysqli_free_result($result);

    return $retval;
}

/**
 * { function_description }
 *
 * @param      <type>         $uuid        The uuid
 * @param      <type>         $dealership  The dealership
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function customer_get_fillups($uuid, $dealership)
{
    $query = "SELECT id, uuid, dealership, count, at FROM smart_offer_customer_fillups WHERE uuid = '" . tagdb_real_escape_string($uuid) . "' AND dealership = '" . tagdb_real_escape_string($dealership) . "';";

    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $row = mysqli_fetch_array($result);

    if (!$row) {
        return false;
    }

    $retval = [
        'id'         => $row['id'],
        'uuid'       => $row['uuid'],
        'dealership' => $row['dealership'],
        'count'      => $row['count'],
        'at'         => unserialize($row['at'])
    ];

    mysqli_free_result($result);

    return $retval;
}

/**
 * { function_description }
 *
 * @param      <type>  $session_id  The session identifier
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $uuid        The uuid
 */
function customer_add_session($session_id, $dealership, $uuid)
{
    $session = customer_get_session($session_id, $dealership);

    if ($session) {
        customer_update_session($session_id, $dealership, $uuid);
    } else {
        customer_create_session($session_id, $dealership, $uuid);
    }
}

/**
 * { function_description }
 *
 * @param      <type>         $session_id  The session identifier
 * @param      <type>         $dealership  The dealership
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function customer_get_session($session_id, $dealership)
{
    $query = "SELECT id, uuid, dealership, session_id, count, closed_at FROM smart_offer_customers_session WHERE session_id = '" . tagdb_real_escape_string($session_id) . "' AND dealership = '" . tagdb_real_escape_string($dealership) . "';";

    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $row = mysqli_fetch_array($result);

    if (!$row) {
        return false;
    }

    $retval = [
        'id'         => $row['id'],
        'uuid'       => $row['uuid'],
        'dealership' => $row['dealership'],
        'session_id' => $row['session_id'],
        'count'      => $row['count'],
        'closed_at'  => $row['closed_at']
    ];

    mysqli_free_result($result);

    return $retval;
}

/**
 * { function_description }
 *
 * @param      <type>  $session_id  The session identifier
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $uuid        The uuid
 */
function customer_update_session($session_id, $dealership, $uuid)
{
    $query = "UPDATE smart_offer_customers_session SET "
    . "uuid = '" . tagdb_real_escape_string($uuid) . "', closed_at = NOW(), count = count + 1 WHERE session_id = '" . tagdb_real_escape_string($session_id) . "' AND dealership = '"
    . tagdb_real_escape_string($dealership) . "';";
    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>  $session_id  The session identifier
 * @param      <type>  $dealership  The dealership
 * @param      <type>  $uuid        The uuid
 */
function customer_create_session($session_id, $dealership, $uuid)
{
    $query = "INSERT INTO smart_offer_customers_session (uuid, dealership, session_id, count, closed_at) VALUES ("
    . "'" . tagdb_real_escape_string($uuid) . "', " . "'" . tagdb_real_escape_string($dealership) . "', " . "'" . tagdb_real_escape_string($session_id) . "', " . "1, NOW())";
    tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>         $dealership  The dealership
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function dealership_get_offers($dealership)
{
    $query = "SELECT name, email, phone, count, at FROM smart_offer_customers, smart_offer_customer_fillups WHERE smart_offer_customers.uuid = smart_offer_customer_fillups.uuid AND dealership = '" . tagdb_real_escape_string($dealership) . "';";

    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $retval = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if (isset($row['at'])) {
            $row['at'] = unserialize($row['at']);
        }

        $retval[] = $row;
    }

    mysqli_free_result($result);

    return $retval;
}

/**
 * { function_description }
 *
 * @param      <type>  $uuid        The uuid
 * @param      <type>  $dealership  The dealership
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function update_user_visit($uuid, $dealership)
{
    $user_visit = user_visit_get_count($uuid, $dealership);

    if ($user_visit) {
        $visit_count = $user_visit['visit_count'] + 1;
        $query       = "UPDATE user_visit SET visit_count=$visit_count, updated_at=now() WHERE uuid = '" . tagdb_real_escape_string($uuid) . "' AND dealership = '" . tagdb_real_escape_string($dealership) . "';";
    } else {
        $query = "INSERT INTO user_visit (uuid, dealership, created_at) VALUES ("
        . "'" . tagdb_real_escape_string($uuid) . "', " . "'" . tagdb_real_escape_string($dealership) . "', " . "now());";
    }

    return tagdb_query($query);
}

/**
 * { function_description }
 *
 * @param      <type>         $uuid        The uuid
 * @param      <type>         $dealership  The dealership
 *
 * @return     array|boolean  ( description_of_the_return_value )
 */
function user_visit_get_count($uuid, $dealership)
{
    $query  = "SELECT id, uuid, dealership, visit_count FROM user_visit WHERE uuid = '" . tagdb_real_escape_string($uuid) . "' AND dealership = '" . tagdb_real_escape_string($dealership) . "';";
    $result = tagdb_query($query);

    if (!$result) {
        return false;
    }

    $row = mysqli_fetch_array($result);

    if (!$row) {
        return false;
    }

    $retval = [
        'id'          => $row['id'],
        'uuid'        => $row['uuid'],
        'dealership'  => $row['dealership'],
        'visit_count' => $row['visit_count']
    ];

    mysqli_free_result($result);

    return $retval;
}

/**
 * Gets the dealer tracking status.
 *
 * @param      <type>  $dealership  The dealership
 *
 * @return     <type>  The dealer tracking status.
 */
function getDealerTrackingStatus($dealership)
{
    $query        = "SELECT status FROM dealerships WHERE dealership = '" . tagdb_real_escape_string($dealership) . "' AND status IN('active', 'trial-setup', 'trial');";
    $query_result = DbConnect::get_instance()->query($query);

    return mysqli_num_rows($query_result);
}
