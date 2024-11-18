<?php

error_reporting(E_ERROR | E_PARSE);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Predis\Client as RedisClient;

// This class describes a database connect.
class DbConnect
{
  private static $_connection, $_connection_read, $_connection_write, $_instance;
  public $cron_name, $cron_config, $scrapper_config, $redis;

  const PREPARE_PARENTHESES = 1; // For Insert
  const PREPARE_EQUAL       = 2; // For Update
  const PREPARE_WHERE       = 3; // Where

  const CLOSE_CONNECTION       = 1;
  const CLOSE_READ_CONNECTION  = 2;
  const CLOSE_WRITE_CONNECTION = 3;

  /**
   * Constructs a new instance.
   *
   * @param      string  $cron_name  The cron name
   */
  public function __construct($cron_name = '')
  {
    global $CronConfigs, $scrapper_configs;

    $this->cron_name       = $cron_name;
    $this->cron_config     = array_key_exists($cron_name, $CronConfigs) ? $CronConfigs[$cron_name] : null;
    $this->scrapper_config = array_key_exists($cron_name, $scrapper_configs) ? $scrapper_configs[$cron_name] : null;
    $this->VarifyTables();
  }

  /**
   * Gets the connection.
   *
   * @return     <type>  The connection.
   */
  public static function get_connection()
  {
    global $db_config;

    if (self::$_connection && mysqli_ping(self::$_connection)) {
      return self::$_connection;
    }

    if (!self::$_connection = mysqli_connect($db_config['db_host_name'], $db_config['db_user'], $db_config['db_pass'], $db_config['db_name'])) {
      $msg = "Database is required in this context. Failed to establish database connection. " . mysqli_connect_error();

      if (function_exists('slecho')) {
        slecho($msg);
      } else {
        echo $msg;
      }

      exit();
    }

    return self::$_connection;
  }

  /**
   * Gets the connection read.
   *
   * @return     <type>  The connection read.
   */
  public static function get_connection_read()
  {
    global $db_config_read;

    if (self::$_connection_read && mysqli_query(self::$_connection_read, "SELECT 1")) {
      return self::$_connection_read;
    }

    if (!self::$_connection_read = mysqli_connect($db_config_read['db_host_name'], $db_config_read['db_user'], $db_config_read['db_pass'], $db_config_read['db_name'])) {
      $msg = "Database is required in this context. Failed to establish database READ connection. " . mysqli_connect_error();

      if (function_exists('slecho')) {
        slecho($msg);
      } else {
        echo $msg;
      }

      exit();
    }

    return self::$_connection_read;
  }

  /**
   * Gets the connection write.
   *
   * @return     <type>  The connection write.
   */
  public static function get_connection_write()
  {
    global $db_config_write;

    if (self::$_connection_write && mysqli_query(self::$_connection_write, "SELECT 1")) {
      return self::$_connection_write;
    }

    if (!self::$_connection_write = mysqli_connect($db_config_write['db_host_name'], $db_config_write['db_user'], $db_config_write['db_pass'], $db_config_write['db_name'])) {
      $msg = "Database is required in this context. Failed to establish database WRITE connection. " . mysqli_connect_error();

      if (function_exists('slecho')) {
        slecho($msg);
      } else {
        echo $msg;
      }

      exit();
    }

    return self::$_connection_write;
  }

  /**
   * Determines whether the specified query is select query.
   *
   * @param      <type>  $query  The query
   *
   * @return     bool    True if the specified query is select query, False otherwise.
   */
  public static function is_select_query($query)
  {
    $queryType = strtok(trim($query), " ");
    return (strtolower($queryType) == "select") || (strtolower($queryType) == "show") ? true : false;
  }

  /**
   * Closes a connection.
   *
   * @param      <type>  $connection_type  The connection type
   */
  public static function close_connection($connection_type = self::CLOSE_CONNECTION)
  {
    if ($connection_type == self::CLOSE_CONNECTION) {
      if (self::$_connection && mysqli_query(self::$_connection, "SELECT 1")) {
        mysqli_close(self::$_connection);
      }
      if (self::$_connection_read && mysqli_query(self::$_connection_read, "SELECT 1")) {
        mysqli_close(self::$_connection_read);
      }
      if (self::$_connection_write && mysqli_query(self::$_connection_write, "SELECT 1")) {
        mysqli_close(self::$_connection_write);
      }
    } else if ($connection_type == self::CLOSE_READ_CONNECTION) {
      if (self::$_connection_read && mysqli_query(self::$_connection_read, "SELECT 1")) {
        mysqli_close(self::$_connection_read);
      }
    } else if ($connection_type == self::CLOSE_WRITE_CONNECTION) {
      if (self::$_connection_write && mysqli_query(self::$_connection_write, "SELECT 1")) {
        mysqli_close(self::$_connection_write);
      }
    }
  }

  /**
   * { function_description }
   *
   * @param      <type>  $query  The query
   *
   * @return     mixed ( description_of_the_return_value )
   */
  public function query($query)
  {
    if (self::is_select_query($query)) {
      if (!($result = mysqli_query(self::get_connection_read(), $query))) {

        if (function_exists('slecho')) {
          slecho('Database error: ' . $query);
          slecho(mysqli_error(self::get_connection_read()));
        } else {
          echo 'Database error: ' . $query;
          echo mysqli_error(self::get_connection_read());
        }
      }

      return $result;
    } else {
      if (!($result = mysqli_query(self::get_connection_write(), $query))) {
        if (function_exists('slecho')) {
          slecho('Database error: ' . $query);
          slecho(mysqli_error(self::get_connection_write()));
        } else {
          echo 'Database error: ' . $query;
          echo mysqli_error(self::get_connection_write());
        }
      }

      return $result;
    }
  }

  /**
   * { function_description }
   *
   * @param      <type>  $str    The string
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function real_escape_string($str)
  {
    return mysqli_real_escape_string(self::get_connection(), $str);
  }

  /**
   * { function_description }
   *
   * @param      <type>  $str    The string
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function real_escape_string_read($str)
  {
    return mysqli_real_escape_string(self::get_connection_read(), $str);
  }

  /**
   * { function_description }
   *
   * @param      <type>  $str    The string
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function real_escape_string_write($str)
  {
    return mysqli_real_escape_string(self::get_connection_write(), $str);
  }

  /**
   * { function_description }
   */
  public function VarifyTables()
  {
    $table_create_query = "CREATE TABLE IF NOT EXISTS "
      . $this->real_escape_string_write($this->cron_name . "_scrapped_data") . " (
            `svin` VARCHAR(255) NOT NULL DEFAULT '',
            `stock_number` VARCHAR(255) NOT NULL DEFAULT '',
            `vin` VARCHAR(255) NOT NULL DEFAULT '',
            `vehicle_id` VARCHAR(255) NOT NULL DEFAULT '',
            `stock_type` VARCHAR(255) NOT NULL,
            `title` VARCHAR(256) NOT NULL,
            `year` VARCHAR(255) NULL DEFAULT NULL,
            `make` VARCHAR(255) NULL DEFAULT NULL,
            `model` VARCHAR(255) NULL DEFAULT NULL,
            `trim` VARCHAR(255) NULL DEFAULT NULL,
            `msrp` VARCHAR(255) NOT NULL DEFAULT '',
            `price` VARCHAR(255) NULL DEFAULT NULL,
            `currency` VARCHAR(255) NULL DEFAULT NULL,
            `city` VARCHAR(255) NULL DEFAULT NULL,
            `biweekly` VARCHAR(255) NULL DEFAULT NULL,
            `lease` VARCHAR(255) NULL DEFAULT NULL,
            `lease_term` VARCHAR(255) NULL DEFAULT NULL,
            `lease_rate` VARCHAR(255) NULL DEFAULT NULL,
            `finance` VARCHAR(255) NULL DEFAULT NULL,
            `finance_term` VARCHAR(255) NULL DEFAULT NULL,
            `finance_rate` VARCHAR(255) NULL DEFAULT NULL,
            `price_history` LONGTEXT NULL,
            `body_style` VARCHAR(500) NULL DEFAULT NULL,
            `engine` VARCHAR(500) NULL DEFAULT NULL,
            `cylinder` INT(11) NULL DEFAULT NULL,
            `transmission` VARCHAR(500) NULL DEFAULT NULL,
            `fuel_type` VARCHAR(255) NULL DEFAULT NULL,
            `drivetrain` VARCHAR(255) NULL DEFAULT NULL,
            `exterior_color` VARCHAR(500) NULL DEFAULT NULL,
            `interior_color` VARCHAR(500) NULL DEFAULT NULL,
            `kilometres` VARCHAR(255) NULL DEFAULT NULL,
            `all_images` VARCHAR(4096) NULL DEFAULT NULL,
            `doors` INT(11) NULL DEFAULT NULL,
            `passenger` INT(11) NULL DEFAULT NULL,
            `auto_texts` VARCHAR(4096) NULL DEFAULT NULL,
            `description` LONGTEXT NULL DEFAULT NULL,
            `disclaimer` LONGTEXT NULL DEFAULT NULL,
            `url` VARCHAR(2048) NOT NULL,
            `host` VARCHAR(2048) NULL DEFAULT NULL,
            `arrival_date` BIGINT(20) NOT NULL DEFAULT '0',
            `updated_at` BIGINT(20) NOT NULL DEFAULT '0',
            `handled_at` BIGINT(20) NOT NULL DEFAULT '0',
            `bing_handled_at` BIGINT(20) NOT NULL DEFAULT '0',
            `deleted_at` BIGINT(20) UNSIGNED NULL,
            `manually_deleted_at` BIGINT(20) UNSIGNED NULL,
            `certified` BIT(1) NOT NULL DEFAULT b'0',
            `deleted` BIT(1) NOT NULL DEFAULT b'0',
            `readded` BIT(1) NOT NULL DEFAULT b'0',
            `no_feed` BIT(1) NOT NULL DEFAULT b'0',
            `options` TEXT NULL,
            `custom` VARCHAR(255) NULL DEFAULT NULL,
            `warranty` VARCHAR(255) NULL DEFAULT NULL,
            `engaged` INT(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (svin)
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

    $this->query($table_create_query);

    // $this->query($inventory_create_query);

    $rank_create_query = "CREATE TABLE IF NOT EXISTS "
      . $this->real_escape_string_write($this->cron_name . "_rank_data") . " (
            stock_number varchar(255) NOT NULL,
            price int(11) NOT NULL DEFAULT '0',
            image_count int(11) NOT NULL DEFAULT '0',
            desc_count int(11) NOT NULL DEFAULT '0',
            day_count int(11) NOT NULL DEFAULT '0',
            time_on_page int(11) NOT NULL DEFAULT '0',
            avg_image_count int(11) NOT NULL DEFAULT '0',
            avg_desc_count int(11) NOT NULL DEFAULT '0',
            avg_day_count int(11) NOT NULL DEFAULT '0',
            avg_time_on_page int(11) NOT NULL DEFAULT '0',
            quality_score int(11) NOT NULL DEFAULT '0'
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

    $this->query($rank_create_query);

    $unmatched_titles_query = "CREATE TABLE IF NOT EXISTS `unmatched_titles` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `title` varchar(512) NOT NULL,
            `url` varchar(2048) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1;";

    $this->query($unmatched_titles_query);

    $account_state_query = "CREATE TABLE IF NOT EXISTS `account_state` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `cid` varchar(255) NOT NULL,
            `day` bigint(20) NOT NULL,
            `cost` decimal(20,2) NOT NULL,
            `clicks` bigint(20) NOT NULL,
            `impressions` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1 ;";

    $this->query($account_state_query);

    $leads_ai_dealerships = "CREATE TABLE IF NOT EXISTS `leads_ai_dealerships` (
            `id` bigint(20) NOT NULL AUTO_INCREMENT,
            `uuid` char(46) NOT NULL,
            `dealership` varchar(255) NOT NULL,
            `month`  char(6) NOT NULL,
            `params` blob NOT NULL,
            `at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`), KEY `uuid` (`uuid`,`dealership`)
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1 AUTO_INCREMENT = 1;";

    $this->query($leads_ai_dealerships);

    $page_source_query = "CREATE TABLE IF NOT EXISTS "
      . $this->real_escape_string_write($this->cron_name . "_source_data") . " (
            `svin` VARCHAR(255) NOT NULL DEFAULT '',
            `url` VARCHAR(2048) NOT NULL COLLATE 'latin1_swedish_ci',
            `page_source` LONGTEXT NULL DEFAULT NULL,
            `stock_number_proposal` VARCHAR(255) NOT NULL DEFAULT '',
            `vin_proposal` VARCHAR(255) NOT NULL DEFAULT '',
            `stock_type_proposal` VARCHAR(255) NOT NULL,
            `title_proposal` VARCHAR(256) NOT NULL,
            `year_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `make_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `model_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `trim_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `msrp_proposal` VARCHAR(255) NOT NULL DEFAULT '',
            `price_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `currency_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `city_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `body_style_proposal` VARCHAR(500) NULL DEFAULT NULL,
            `engine_proposal` VARCHAR(500) NULL DEFAULT NULL,
            `transmission_proposal` VARCHAR(500) NULL DEFAULT NULL,
            `fuel_type_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `drivetrain_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `exterior_color_proposal` VARCHAR(500) NULL DEFAULT NULL,
            `interior_color_proposal` VARCHAR(500) NULL DEFAULT NULL,
            `kilometres_proposal` VARCHAR(255) NULL DEFAULT NULL,
            `all_images_proposal` VARCHAR(4096) NULL DEFAULT NULL,
            `description_proposal` LONGTEXT NULL DEFAULT NULL,
            PRIMARY KEY (svin)
        ) ENGINE = InnoDB DEFAULT CHARSET = latin1;";

    $this->query($page_source_query);

    $cartracker_query = "CREATE TABLE IF NOT EXISTS "
      . $this->real_escape_string_write($this->cron_name . "_cartrack_data") . " (
            `svin` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
            `current_svin` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
            `current_url` VARCHAR(1024) NOT NULL COLLATE 'latin1_swedish_ci',
            `previous_url` VARCHAR(1024) NOT NULL COLLATE 'latin1_swedish_ci',
            `current_stock_number` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `previous_stock_number` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `current_vin` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `previous_vin` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `stock_type` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `year` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `make` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `model` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `title` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
            `readded_by` ENUM('svin','vin','url','stock_number') NULL COLLATE 'latin1_swedish_ci',
            `readded_at` BIGINT(20) NOT NULL DEFAULT '0',
            `arrival_date` BIGINT(20) NOT NULL DEFAULT '0',
            `deleted_at` BIGINT(20) NOT NULL DEFAULT '0',
            `active` BIT(1) NOT NULL DEFAULT b'1',
            `add_delete_history` BLOB NULL,
            PRIMARY KEY (`svin`) USING BTREE
        ) COLLATE='latin1_swedish_ci' ENGINE=InnoDB;";

    $this->query($cartracker_query);

    $this->create_meta_table('template_hash');
    $this->create_meta_table('cache_time');
    $this->create_meta_table('dealer_domain');
    $this->create_meta_table('tag_stat');
    $this->create_meta_table('general_config');
  }

  /**
   * Gets the rank data.
   *
   * @param      <type>  $stock_number  The stock number
   *
   * @return     array   The rank data.
   */
  public function get_rank_data($stock_number)
  {
    $query = "SELECT * FROM " . $this->real_escape_string_read($this->cron_name . "_rank_data") . " WHERE stock_number = '$stock_number';";
    $res   = $this->query($query);

    if (!$res) {
      return null;
    }

    $row = mysqli_fetch_array($res);

    if (!$row) {
      return null;
    }

    $retval = [
      'price'            => $row['price'],
      'image_count'      => $row['image_count'],
      'desc_count'       => $row['desc_count'],
      'day_count'        => $row['day_count'],
      'time_on_page'     => $row['time_on_page'],
      'avg_image_count'  => $row['avg_image_count'],
      'avg_desc_count'   => $row['avg_desc_count'],
      'avg_day_count'    => $row['avg_day_count'],
      'avg_time_on_page' => $row['avg_time_on_page'],
      'quality_score'    => $row['quality_score'],
    ];

    mysqli_free_result($res);

    return $retval;
  }

  /**
   * Stores a rank data.
   *
   * @param      <type>  $stock_number  The stock number
   * @param      <type>  $rank_data     The rank data
   */
  public function store_rank_data($stock_number, $rank_data)
  {
    $rd = $this->get_rank_data($stock_number);

    if ($rd) {
      $query = "UPDATE " . $this->real_escape_string_write($this->cron_name . "_rank_data") . " SET " . " price = '" . $this->real_escape_string_write($rank_data['price'])
        . "', image_count = '" . $this->real_escape_string_write($rank_data['image_count'])
        . "', desc_count = '" . $this->real_escape_string_write($rank_data['desc_count'])
        . "', day_count = '" . $this->real_escape_string_write($rank_data['day_count'])
        . "', time_on_page = '" . $this->real_escape_string_write($rank_data['time_on_page'])
        . "', avg_image_count = '" . $this->real_escape_string_write($rank_data['avg_image_count'])
        . "', avg_desc_count = '" . $this->real_escape_string_write($rank_data['avg_desc_count'])
        . "', avg_day_count = '" . $this->real_escape_string_write($rank_data['avg_day_count'])
        . "', avg_time_on_page = '" . $this->real_escape_string_write($rank_data['avg_time_on_page'])
        . "', quality_score = '" . $this->real_escape_string_write($rank_data['quality_score'])
        . "' WHERE stock_number = '" . $this->real_escape_string_write($stock_number) . "';";
    } else {
      $query = "INSERT INTO " . $this->real_escape_string_write($this->cron_name . "_rank_data")
        . "(stock_number, price, image_count, desc_count, day_count, time_on_page, avg_image_count, avg_desc_count, avg_day_count, avg_time_on_page, quality_score) VALUES " . "('" . $this->real_escape_string_write($stock_number)
        . "', '" . $this->real_escape_string_write($rank_data['price'])
        . "', '" . $this->real_escape_string_write($rank_data['image_count'])
        . "', '" . $this->real_escape_string_write($rank_data['desc_count'])
        . "', '" . $this->real_escape_string_write($rank_data['day_count'])
        . "', '" . $this->real_escape_string_write($rank_data['time_on_page'])
        . "', '" . $this->real_escape_string_write($rank_data['avg_image_count'])
        . "', '" . $this->real_escape_string_write($rank_data['avg_desc_count'])
        . "', '" . $this->real_escape_string_write($rank_data['avg_day_count'])
        . "', '" . $this->real_escape_string_write($rank_data['avg_time_on_page'])
        . "', '" . $this->real_escape_string_write($rank_data['quality_score']) . "');";
    }

    $this->query($query);
  }

  /**
   * Stores an account state.
   *
   * @param      <type>  $cid          The cid
   * @param      <type>  $day          The day
   * @param      <type>  $cost         The cost
   * @param      <type>  $clicks       The clicks
   * @param      <type>  $impressions  The impressions
   */
  public function store_account_state($cid, $day, $cost, $clicks, $impressions)
  {
    $day     = mktime(0, 0, 0, date("n", $day), date("j", $day), date("Y", $day));
    $query   = '';
    $current = $this->get_account_state($cid, $day);

    if ($current) {
      $id    = $current['id'];
      $query = "UPDATE account_state SET cost = $cost, clicks = $clicks, impressions = $impressions WHERE id = $id;";
    } else {
      $query = "INSERT INTO account_state (cid, day, cost, clicks, impressions) VALUES ('$cid', $day, $cost, $clicks, $impressions);";
    }

    $this->query($query);
  }

  /**
   * Gets the account state.
   *
   * @param      <type>  $cid       The cid
   * @param      <type>  $from_day  The from day
   * @param      bool    $to_day    To day
   *
   * @return     array   The account state.
   */
  public function get_account_state($cid, $from_day, $to_day = false)
  {
    $from_day  = mktime(0, 0, 0, date("n", $from_day), date("j", $from_day), date("Y", $from_day));
    $array_out = !!$to_day;

    if ($to_day) {
      $to_day = mktime(23, 59, 59, date("n", $to_day), date("j", $to_day), date("Y", $to_day));
    } else {
      $to_day = mktime(23, 59, 59, date("n", $from_day), date("j", $from_day), date("Y", $from_day));
    }

    $where_claus = "cid = '{$cid}' AND day BETWEEN {$from_day} AND {$to_day}";
    $query       = "SELECT id, cost, clicks, impressions FROM account_state WHERE $where_claus ORDER BY id ASC;";
    $result      = $this->query($query);
    $to_return   = null;

    if (!$result) {
      if ($array_out) {
        $to_return = [];

        while ($row = mysqli_fetch_array($result)) {
          $to_return[] = [
            'id'          => $row['id'],
            'cost'        => $row['cost'],
            'clicks'      => $row['clicks'],
            'impressions' => $row['impressions'],
          ];
        }
      } else {
        $row = mysqli_fetch_array($result);

        if ($row) {
          $to_return = [
            'id'          => $row['id'],
            'cost'        => $row['cost'],
            'clicks'      => $row['clicks'],
            'impressions' => $row['impressions'],
          ];
        }
      }
    }

    mysqli_free_result($result);

    return $to_return;
  }

  /**
   * Stores a template hash.
   *
   * @param      <type>  $cron_name  The cron name
   * @param      <type>  $hash       The hash
   */
  public function store_template_hash($cron_name, $hash)
  {
    $this->update_meta('template_hash', $cron_name, $hash);
  }

  /**
   * { function_description }
   *
   * @param      <type>  $cron_name  The cron name
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function retrive_template_hash($cron_name)
  {
    return $this->get_meta('template_hash', $cron_name);
  }

  /**
   * Gets the last url.
   *
   * @return     <type>  The last url.
   */
  public function GetLastURL()
  {
    $query = "SELECT url FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " WHERE deleted = 0 ORDER BY updated_at DESC limit 1;";

    $result = $this->query($query);
    $url    = null;

    if (!$result) {
      $row = mysqli_fetch_array($result);

      if ($row) {
        $url = $row['url'];
      }
    }

    mysqli_free_result($result);

    return $url;
  }

  /**
   * { function_description }
   */
  public function reset_cars()
  {
    $query = "UPDATE " . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
      . " SET updated_at = " . $this->real_escape_string_write(time())
      . " WHERE deleted = 0 AND handled_at > updated_at;";

    $this->query($query);
  }

  /**
   * Loads car ads.
   *
   * @param      array  $cars_db      The cars database
   * @param      array  $ads_db       The ads database
   * @param      array  $all_cars_db  All cars database
   * @param      array  $cron_config  The cron configuration
   */
  public function LoadCarAds(&$cars_db, &$ads_db, &$all_cars_db, $cron_config = [])
  {
    $cars_db     = [];
    $ads_db      = [];
    $all_cars_db = [];

    $query = ("SELECT * FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " WHERE updated_at > handled_at");
    $result = $this->query($query);

    while ($row = mysqli_fetch_array($result)) {
      $images = explode("|", $row["all_images"]);

      if ($images[0] == "") {
        $images = [];
      }

      $auto_text = explode("|", $row["auto_texts"]);

      if ($auto_text[0] == "") {
        $auto_text = [];
      }

      $required_fields = [
        "stock_number"    => $row["stock_number"],
        "vin"             => $row["vin"],
        "svin"            => $row["svin"],
        "vehicle_id"      => $row["vehicle_id"],
        "stock_type"      => $row["stock_type"],
        "year"            => $row["year"],
        "make"            => $row["make"],
        "model"           => $row["model"],
        "trim"            => $row["trim"],
        "title"           => $row["title"],
        "msrp"            => $row["msrp"],
        "price"           => $row["price"],
        "currency"        => $row["currency"],
        "city"            => $row["city"],
        "biweekly"        => $row["biweekly"],
        "lease"           => $row["lease"],
        "lease_term"      => $row["lease_term"],
        "lease_rate"      => $row["lease_rate"],
        "finance"         => $row["finance"],
        "finance_term"    => $row["finance_term"],
        "finance_rate"    => $row["finance_rate"],
        "weekly"          => butifyPrice(numarifyPrice($row["biweekly"]) >> 1),
        "price_history"   => $row["price_history"] ? unserialize($row["price_history"]) : [],
        "body_style"      => $row["body_style"],
        "engine"          => $row["engine"],
        "cylinder"        => $row["cylinder"],
        "transmission"    => $row["transmission"],
        "fuel_type"       => $row["fuel_type"],
        "drivetrain"      => $row["drivetrain"],
        "kilometers"      => $row["kilometres"],
        "kilometres"      => $row["kilometres"],
        "color"           => $row["exterior_color"],
        "exterior_color"  => $row["exterior_color"],
        "interior_color"  => $row["interior_color"],
        "url"             => $row["url"],
        "host"            => $row["host"],
        "arrival_date"    => $row["arrival_date"],
        "updated_at"      => $row["updated_at"],
        "handled_at"      => $row["handled_at"],
        "bing_handled_at" => isset($row["bing_handled_at"]) ? $row["bing_handled_at"] : 0,
        "deleted_at"      => $row["deleted_at"],
        "certified"       => $row["certified"] ? 1 : 0,
        "deleted"         => $row["deleted"] ? 1 : 0,
        "images"          => $images,
        "all_images"      => $row["all_images"],
        "doors"           => $row["doors"],
        "passenger"       => $row["passenger"],
        "description"     => $row["description"],
        "disclaimer"      => $row["disclaimer"],
        "auto_texts"      => $auto_text,
        "custom"          => $row["custom"],
        "warranty"        => $row["warranty"],
        "engaged"         => $row["engaged"],
        "no_feed"         => $row["no_feed"],
      ];

      $cars_db[$row["stock_number"]] = apply_filters("{$this->cron_name}_post_process_car_data", $required_fields);
      $price                         = butifyPrice($cars_db[$row["stock_number"]]["price"]);
      $biweekly                      = butifyPrice($cars_db[$row["stock_number"]]["biweekly"]);

      if (!$biweekly) {
        $priceVal        = numarifyPrice($price);
        $biweekly_config = @$cron_config['biweekly'][$row["year"]][$row["stock_type"]];

        if ($priceVal && is_array($biweekly_config)) {
          $biweekly = calculateByWeekly(
            $priceVal,
            $biweekly_config['tax'],
            isset($biweekly_config['deposit']) ? $biweekly_config['deposit'] : 0,
            $biweekly_config['interest'],
            $biweekly_config['months'],
            $biweekly_config['fee']
          );

          $biweekly = butifyPrice($biweekly . '');
        }
      }

      $cars_db[$row["stock_number"]]["biweekly"] = $biweekly;
      $cars_db[$row["stock_number"]]["price"]    = $price;
    }

    mysqli_free_result($result);

    /***********************************************************************
     * All active cars
     ***********************************************************************/

    $query = "SELECT * FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " WHERE deleted = 0 AND no_feed = 0;";
    $result3 = $this->query($query);

    while ($row = mysqli_fetch_array($result3)) {
      $images = explode("|", $row["all_images"]);

      if ($images[0] == '') {
        $images = [];
      }

      $auto_text = explode('|', $row["auto_texts"]);

      if ($auto_text[0] == '') {
        $auto_text = [];
      }

      $required_fields = [
        "stock_number"    => $row["stock_number"],
        "vin"             => $row["vin"],
        "svin"            => $row["svin"],
        "vehicle_id"      => $row["vehicle_id"],
        "stock_type"      => $row["stock_type"],
        "year"            => $row["year"],
        "make"            => $row["make"],
        "model"           => $row["model"],
        "trim"            => $row["trim"],
        "title"           => $row["title"],
        "msrp"            => $row["msrp"],
        "price"           => $row["price"],
        "currency"        => $row["currency"],
        "city"            => $row["city"],
        "biweekly"        => $row["biweekly"],
        "lease"           => $row["lease"],
        "lease_term"      => $row["lease_term"],
        "lease_rate"      => $row["lease_rate"],
        "finance"         => $row["finance"],
        "finance_term"    => $row["finance_term"],
        "finance_rate"    => $row["finance_rate"],
        "weekly"          => butifyPrice(numarifyPrice($row["biweekly"]) >> 1),
        "price_history"   => $row["price_history"] ? unserialize($row["price_history"]) : [],
        "body_style"      => $row["body_style"],
        "engine"          => $row["engine"],
        "cylinder"        => $row["cylinder"],
        "transmission"    => $row["transmission"],
        "fuel_type"       => $row["fuel_type"],
        "drivetrain"      => $row["drivetrain"],
        "kilometers"      => $row["kilometres"],
        "kilometres"      => $row["kilometres"],
        "color"           => $row["exterior_color"],
        "exterior_color"  => $row["exterior_color"],
        "interior_color"  => $row["interior_color"],
        "url"             => $row["url"],
        "host"            => $row["host"],
        "arrival_date"    => $row["arrival_date"],
        "updated_at"      => $row["updated_at"],
        "handled_at"      => $row["handled_at"],
        "bing_handled_at" => isset($row["bing_handled_at"]) ? $row["bing_handled_at"] : 0,
        "deleted_at"      => $row["deleted_at"],
        "certified"       => $row["certified"] ? 1 : 0,
        "deleted"         => $row["deleted"] ? 1 : 0,
        "images"          => $images,
        "all_images"      => $row["all_images"],
        "doors"           => $row["doors"],
        "passenger"       => $row["passenger"],
        "description"     => $row["description"],
        "disclaimer"      => $row["disclaimer"],
        "auto_texts"      => $auto_text,
        "custom"          => $row["custom"],
        "warranty"        => $row["warranty"],
        "engaged"         => $row["engaged"],
        "no_feed"         => $row["no_feed"],
        "custom_title"        => json_decode($row["custom_title"]),
        "custom_description"  => json_decode($row["custom_description"]),
        "custom_make"         => $row["custom_make"],
        "custom_year"         => $row["custom_year"],
        "custom_model"        => $row["custom_model"],
        "custom_price"        => $row["custom_price"],
        "inactive"            => $row["inactive"],
        "blocked_images"        => json_decode($row["blocked_images"]),
        "image_priority"  => json_decode($row["image_priority"]),
      ];

      $all_cars_db[$row["stock_number"]] = apply_filters("{$this->cron_name}_post_process_car_data", $required_fields);
      $price                             = butifyPrice($all_cars_db[$row["stock_number"]]["price"]);
      $biweekly                          = butifyPrice($all_cars_db[$row["stock_number"]]["biweekly"]);

      if (!$biweekly) {
        $priceVal        = numarifyPrice($price);
        $biweekly_config = @$cron_config['biweekly'][$row["year"]][$row["stock_type"]];

        if ($priceVal && is_array($biweekly_config)) {
          $biweekly = calculateByWeekly(
            $priceVal,
            $biweekly_config['tax'],
            isset($biweekly_config['deposit']) ? $biweekly_config['deposit'] : 0,
            $biweekly_config['interest'],
            $biweekly_config['months'],
            $biweekly_config['fee']
          );

          $biweekly = butifyPrice($biweekly . '');
        }
      }

      $all_cars_db[$row["stock_number"]]["biweekly"] = $biweekly;
      $all_cars_db[$row["stock_number"]]["price"]    = $price;
    }

    mysqli_free_result($result3);

    return true;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $stock_number  The stock number
   */
  public function update_handled($stock_number)
  {
    $query = "UPDATE "
      . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
      . " SET handled_at = " . time() . " WHERE stock_number = '"
      . $this->real_escape_string_write($stock_number) . "';";
    $this->query($query);
  }

  /**
   * Stores a matched title.
   *
   * @param      string  $title  The title
   * @param      <type>  $url    The url
   */
  public function store_matched_title($title, $url)
  {
    $title = trim($title);
    $url   = trim($url);

    if (!$title || $title == '') {
      return;
    }

    $titleRegx = '/(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]*)/';
    $match     = [];

    if (!preg_match($titleRegx, $title, $match)) {
      return;
    }

    $year  = $match['year'];
    $make  = strtolower($match['make']);
    $model = $match['model'];

    global $carlist;

    loadCarList();

    if (isset($carlist[$year]) && isset($carlist[$year][$make]) && isset($carlist[$year][$make][$model])) {
      return;
    }

    $found         = false;
    $initial_query = "SELECT id FROM unmatched_titles WHERE title = '" . $this->real_escape_string_read($title) . "';";
    $result        = $this->query($initial_query);

    if (!$result) {
      if (mysqli_fetch_array($result)) {
        $found = true;
      }
    }

    mysqli_free_result($result);

    if (!$found) {
      $query = "INSERT INTO unmatched_titles (title, url) VALUES ('"
        . $this->real_escape_string_write($title) . "', '"
        . $this->real_escape_string_write($url) . "');";

      $this->query($query);
    }
  }

  /**
   * Gets the unmatched titles.
   *
   * @return     array  The unmatched titles.
   */
  public function get_unmatched_titles()
  {
    $query  = "SELECT id, title, url FROM unmatched_titles WHERE 1;";
    $res    = $this->query($query);
    $result = [];

    while ($row = mysqli_fetch_array($res)) {
      $result[] = [
        'id'    => $row['id'],
        'title' => trim($row['title']),
        'url'   => $row['url'],
      ];
    }

    mysqli_free_result($res);

    return $result;
  }

  /**
   * Removes an unmatched title.
   *
   * @param      <type>  $id     The identifier
   */
  public function remove_unmatched_title($id)
  {
    $query = "DELETE FROM unmatched_titles WHERE id = " . $this->real_escape_string_write($id) . ";";

    $this->query($query);
  }

  /**
   * Gets the car table.
   *
   * @return     array  The car table.
   */
  public function get_car_table()
  {
    $query = "SELECT svin FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " WHERE deleted = 0;";

    $result = $this->query($query);

    if (!$result) {
      var_dump(mysqli_error(self::get_connection_read())
        . " for " . $this->cron_name . "_scrapped_data table");
    }

    $to_return = [];

    while ($row = mysqli_fetch_array($result)) {
      $to_return[$row['svin']] = false;
    }

    mysqli_free_result($result);

    return $to_return;
  }

  /**
   * { function_description }
   */
  public function clear_cron_data()
  {
    $query = "UPDATE " . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
      . " SET deleted = 1, handled_at = " . time() . ", deleted_at = " . time() . " where 1;";
    $this->query($query);
  }

  /**
   * { function_description }
   *
   * @param      <type>  $svin   The svin
   */
  public function delete_car_data($svin)
  {
    $query = "UPDATE " . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
      . " SET deleted = 1, updated_at = " . time() . ", deleted_at = " . time()
      . " WHERE svin = '"
      . $this->real_escape_string_write($svin)
      . "' AND deleted != 1;";

    $this->query($query);
  }

  public function delete_car_data_by_svin_list($svinList)
  {
    $in_query = "('" . implode("','", $svinList) . "')";
    $query    = "UPDATE " . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
      . " SET deleted = 1, updated_at = " . time() . ", deleted_at = " . time()
      . " WHERE svin IN {$in_query} AND deleted != 1;";
    $this->query($query);
  }

  public function filterCarData(&$car)
  {
    // $invalids = [",", "!", "@", "%", "^", "(", ")", "=", "{", "}", ";", "~", "`", "<", ">", "?", "\\", "|"];
    $invalid_regex = '/[,!@%\^\(\)\={};~`<>\?\\\\|]/';

    $car['make']  = preg_replace($invalid_regex, '', $car['make']);
    $car['model'] = preg_replace($invalid_regex, '', $car['model']);
    $car['trim']  = preg_replace($invalid_regex, '', $car['trim']);
    $car['title'] = preg_replace($invalid_regex, '', $car['title']);
    $car['price'] = numarifyPrice($car['price']);
    // $car['url']   = strtolower($car['url']);
  }

  /**
   * Stores a car data.
   *
   * @param      <type>  $car    The car
   */
  public function store_car_data(&$car)
  {
    global $redis_config;

    if (!isset($car['svin']) || !trim($car['svin'])) {
      if (function_exists('slecho')) {
        slecho("ERROR: There is no SVIN present.");
      }

      return;
    }

    $sanitize_fields = [
        'description',
        'exterior_color',
        'interior_color',
        'title',
        'body_style',
        'transmission',
        'engine',
        'drivetrain',
        'fuel_type',
        'make',
        'model',
        'stock_type'
    ];

    foreach ($sanitize_fields as $field) {
        if (isset($car[$field])) {
            $car[$field] = trim(strip_tags($car[$field]));
        }
    }

    $msrp       = isset($car['msrp']) ? $car['msrp'] : '';
    $biweekly   = isset($car['biweekly']) ? $car['biweekly'] : '';
    $certified  = isset($car['certified']) && $car['certified'] ? 1 : 0;
    $car['url'] = mild_url_encode($car['url'], isset($this->scrapper_config['required_params']) ? $this->scrapper_config['required_params'] : []);

    $check = "SELECT svin, stock_number, price, price_history FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " WHERE svin = '" . $this->real_escape_string_read($car['svin']) . "';";

    $result = $this->query($check);

    if (!$result) {
      var_dump(mysqli_error(self::get_connection_read()) . " for " . $this->cron_name
        . "_scrapped_data table");
    }

    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);
    $store_query = '';

    $this->filterCarData($car);

    if ($row) {
      $price         = $row['price'];
      $price_history = $row['price_history'] ? unserialize($row['price_history']) : [];

      if ($price != $car['price']) {
        $price_history[time()] = $car['price'];
      }

      $store_query .= "UPDATE "
        . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
        . " SET msrp = '" . $this->real_escape_string_write($msrp)
        . "', stock_number = '" . $this->real_escape_string_write($car['stock_number'])
        . "', price = '" . $this->real_escape_string_write($car['price'])
        . "', currency = '" . $this->real_escape_string_write($car['currency'])
        . "', city = '" . $this->real_escape_string_write(isset($car['city']) ? $car['city'] : '')
        . "', vin = '" . $this->real_escape_string_write(isset($car['vin']) ? $car['vin'] : '')
        . "', vehicle_id = '" . $this->real_escape_string_write(isset($car['vehicle_id']) ? $car['vin'] : '')
        . "', biweekly = '" . $this->real_escape_string_write($biweekly)
        . "', lease = '" . $this->real_escape_string_write(isset($car['lease']) ? $car['lease'] : '')
        . "', lease_term = '" . $this->real_escape_string_write(isset($car['lease_term']) ? $car['lease_term'] : '')
        . "', lease_rate = '" . $this->real_escape_string_write(isset($car['lease_rate']) ? $car['lease_rate'] : '')
        . "', finance = '" . $this->real_escape_string_write(isset($car['finance']) ? $car['finance'] : '')
        . "', finance_term = '" . $this->real_escape_string_write(isset($car['finance_term']) ? $car['finance_term'] : '')
        . "', finance_rate = '" . $this->real_escape_string_write(isset($car['finance_rate']) ? $car['finance_rate'] : '')
        . "', price_history = '" . $this->real_escape_string_write(serialize($price_history))
        . "', title = '" . $this->real_escape_string_write($car['title'])
        . "', year = '" . $this->real_escape_string_write($car['year'])
        . "', make = '" . $this->real_escape_string_write($car['make'])
        . "', model = '" . $this->real_escape_string_write($car['model'])
        . "', trim = '" . $this->real_escape_string_write($car['trim'])
        . "', body_style = '" . $this->real_escape_string_write($car['body_style'])
        . "', engine = '" . $this->real_escape_string_write($car['engine'])
        . "', cylinder = '" . $this->real_escape_string_write($car['cylinder'])
        . "', doors = '" . $this->real_escape_string_write($car['doors'])
        . "', passenger = '" . $this->real_escape_string_write($car['passenger'])
        . "', warranty = '" . $this->real_escape_string_write($car['warranty'])
        . "', transmission = '" . $this->real_escape_string_write($car['transmission'])
        . "', fuel_type = '" . $this->real_escape_string_write(isset($car['fuel_type']) ? $car['fuel_type'] : '')
        . "', drivetrain = '" . $this->real_escape_string_write(isset($car['drivetrain']) ? $car['drivetrain'] : '')
        . "', exterior_color = '" . $this->real_escape_string_write(isset($car['exterior_color']) ? $car['exterior_color'] : '')
        . "', interior_color = '" . $this->real_escape_string_write(isset($car['interior_color']) ? $car['interior_color'] : '')
        . "', kilometres = '" . $this->real_escape_string_write($car['kilometres'])
        . "', all_images = '" . $this->real_escape_string_write($car['all_images'])
        . "', custom = '" . $this->real_escape_string_write($car['custom'])
        . "', description = '" . $this->real_escape_string_write(isset($car['description']) ? trim(strip_tags($car['description'])) : '')
        . "', disclaimer = '" . $this->real_escape_string_write(isset($car['disclaimer']) ? trim(strip_tags($car['disclaimer'])) : '')
        . "', url = '" . $this->real_escape_string_write($car['url'])
        . "', updated_at = " . $this->real_escape_string_write(time())
        . ", certified = $certified, deleted = 0, auto_texts = '" . $this->real_escape_string_write(isset($car['auto_texts']) ? $car['auto_texts'] : '') .
        "'  WHERE svin = '" . $this->real_escape_string_write($car['svin']) .
        "' AND (price != '" . $this->real_escape_string_write($car['price']) .
        "' OR msrp != '" . $this->real_escape_string_write($msrp) .
        "' OR stock_number != '" . $this->real_escape_string_write($car['stock_number']) .
        "' OR vin != '" . $this->real_escape_string_write(isset($car['vin']) ? $car['vin'] : '') .
        "' OR vehicle_id != '" . $this->real_escape_string_write(isset($car['vehicle_id']) ? $car['vin'] : '') .
        "' OR biweekly != '" . $this->real_escape_string_write($biweekly) .
        "' OR lease != '" . $this->real_escape_string_write(isset($car['lease']) ? $car['lease'] : '') .
        "' OR lease_term != '" . $this->real_escape_string_write(isset($car['lease_term']) ? $car['lease_term'] : '') .
        "' OR lease_rate != '" . $this->real_escape_string_write(isset($car['lease_rate']) ? $car['lease_rate'] : '') .
        "' OR finance != '" . $this->real_escape_string_write(isset($car['finance']) ? $car['finance'] : '') .
        "' OR city != '" . $this->real_escape_string_write(isset($car['city']) ? $car['city'] : '') .
        "' OR finance_term != '" . $this->real_escape_string_write(isset($car['finance_term']) ? $car['finance_term'] : '') .
        "' OR finance_rate != '" . $this->real_escape_string_write(isset($car['finance_rate']) ? $car['finance_rate'] : '') .
        "' OR title != '" . $this->real_escape_string_write($car['title']) .
        "' OR currency != '" . $this->real_escape_string_write($car['currency']) .
        "' OR year != '" . $this->real_escape_string_write($car['year']) .
        "' OR make != '" . $this->real_escape_string_write($car['make']) .
        "' OR model != '" . $this->real_escape_string_write($car['model']) .
        "' OR trim != '" . $this->real_escape_string_write($car['trim']) .
        "' OR body_style != '" . $this->real_escape_string_write($car['body_style']) .
        "' OR engine != '" . $this->real_escape_string_write($car['engine']) .
        "' OR cylinder != '" . $this->real_escape_string_write($car['cylinder']) .
        "' OR doors != '" . $this->real_escape_string_write($car['doors']) .
        "' OR passenger != '" . $this->real_escape_string_write($car['passenger']) .
        "' OR warranty != '" . $this->real_escape_string_write($car['warranty']) .
        "' OR transmission != '" . $this->real_escape_string_write($car['transmission']) .
        "' OR fuel_type != '" . $this->real_escape_string_write(isset($car['fuel_type']) ? $car['fuel_type'] : '') .
        "' OR drivetrain != '" . $this->real_escape_string_write(isset($car['drivetrain']) ? $car['drivetrain'] : '') .
        "' OR exterior_color != '" . $this->real_escape_string_write(isset($car['exterior_color']) ? $car['exterior_color'] : '') .
        "' OR interior_color != '" . $this->real_escape_string_write(isset($car['interior_color']) ? $car['interior_color'] : '') .
        "' OR kilometres != '" . $this->real_escape_string_write($car['kilometres']) .
        "' OR custom != '" . $this->real_escape_string_write($car['custom']) .
        "' OR all_images != '" . $this->real_escape_string_write($car['all_images']) .
        "' OR description != '" . $this->real_escape_string_write(isset($car['description']) ? $car['description'] : '') .
        "' OR disclaimer != '" . $this->real_escape_string_write(isset($car['disclaimer']) ? $car['disclaimer'] : '') .
        "' OR auto_texts != '" . $this->real_escape_string_write(isset($car['auto_texts']) ? $car['auto_texts'] : '') .
        "' OR url != '" . $this->real_escape_string_write($car['url']) .
        "' OR certified != $certified" . " OR deleted = 1);";

      $this->query($store_query);
    } else {
      $price_history = [time() => $car['price']];

      $store_query .= "INSERT INTO "
        . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
        . ' (options, svin, stock_number, vin, vehicle_id, stock_type, title, year, make, model, trim, msrp, price, currency, city, biweekly, lease, lease_term, lease_rate, finance, finance_term, finance_rate, price_history, '
        . 'body_style, engine, cylinder, doors, passenger, warranty, transmission, fuel_type, drivetrain, exterior_color, interior_color, '
        . 'kilometres, all_images, custom, auto_texts, description, disclaimer, url, host, arrival_date, updated_at, handled_at, certified) VALUES (\''
        . $this->real_escape_string_write($car['options']) . "', '"
        . $this->real_escape_string_write($car['svin']) . "', '"
        . $this->real_escape_string_write($car['stock_number']) . "', '"
        . $this->real_escape_string_write(isset($car['vin']) ? $car['vin'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['vehicle_id']) ? $car['vehicle_id'] : '') . "', '"
        . $this->real_escape_string_write(strtolower($car['stock_type'])) . "', '"
        . $this->real_escape_string_write($car['title']) . "', '"
        . $this->real_escape_string_write($car['year']) . "', '"
        . $this->real_escape_string_write($car['make']) . "', '"
        . $this->real_escape_string_write($car['model']) . "', '"
        . $this->real_escape_string_write($car['trim']) . "', '"
        . $this->real_escape_string_write($msrp) . "', '"
        . $this->real_escape_string_write($car['price']) . "', '"
        . $this->real_escape_string_write($car['currency']) . "', '"
        . $this->real_escape_string_write(isset($car['city']) ? $car['city'] : '') . "', '"
        . $this->real_escape_string_write($biweekly) . "', '"
        . $this->real_escape_string_write(isset($car['lease']) ? $car['lease'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['lease_term']) ? $car['lease_term'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['lease_rate']) ? $car['lease_rate'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['finance']) ? $car['finance'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['finance_term']) ? $car['finance_term'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['finance_rate']) ? $car['finance_rate'] : '') . "', '"
        . $this->real_escape_string_write(serialize($price_history)) . "', '"
        . $this->real_escape_string_write(@$car['body_style']) . "', '"
        . $this->real_escape_string_write(@$car['engine']) . "', '"
        . $this->real_escape_string_write(@$car['cylinder']) . "', '"
        . $this->real_escape_string_write(@$car['doors']) . "', '"
        . $this->real_escape_string_write(@$car['passenger']) . "', '"
        . $this->real_escape_string_write(@$car['warranty']) . "', '"
        . $this->real_escape_string_write(@$car['transmission']) . "', '"
        . $this->real_escape_string_write(isset($car['fuel_type']) ? $car['fuel_type'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['drivetrain']) ? $car['drivetrain'] : '') . "', '"
        . $this->real_escape_string_write(@$car['exterior_color']) . "', '"
        . $this->real_escape_string_write(@$car['interior_color']) . "', '"
        . $this->real_escape_string_write(@$car['kilometres']) . "', '"
        . $this->real_escape_string_write(@$car['all_images']) . "', '"
        . $this->real_escape_string_write(isset($car['custom']) ? $car['custom'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['auto_texts']) ? $car['auto_texts'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['description']) ? $car['description'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['disclaimer']) ? $car['disclaimer'] : '') . "', '"
        . $this->real_escape_string_write($car['url']) . "', '"
        . $this->real_escape_string_write(isset($car['host']) ? $car['host'] : '') . "', " . time() . ", " . time() . ", 0, $certified);";

      $this->query($store_query);
    }

    if (mysqli_errno(self::get_connection_write())) {
      if (function_exists('slecho')) {
        slecho(mysqli_error(self::get_connection_write()));
        slecho("**Info: Query - " . $store_query);
      }
    }

    $query = "SELECT arrival_date FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " where svin = '" . $this->real_escape_string_read($car['svin']) . "';";
    $result = $this->query($query);

    if ($result) {
      $row                 = mysqli_fetch_array($result);
      $car['arrival_date'] = $row['arrival_date'];
    } else {
      $car['arrival_date'] = 0;
    }

    mysqli_free_result($result);

    # Store in redis
    $required_params = isset($this->scrapper_config['required_params']) ? $this->scrapper_config['required_params'] : [];
    $car_data_key    = 'car_data_' . url_to_svin($car['url'], $required_params);

    if (!$this->redis) {
      $this->redis = new RedisClient($redis_config);
    }

    $this->redis->set($car_data_key, serialize($car));
    $this->redis->expire($car_data_key, 604800); // Keep vehicle data for 7 days
  }

  /**
   * Stores a byowner car data.
   *
   * @param      <type>  $car    The car
   */
  public function store_byowner_car_data($car)
  {
    if (!isset($car['stock_number'])) {
      if (function_exists('slecho')) {
        slecho("ERROR: There is no stock number present.");
      }

      return;
    }

    $check = "SELECT stock_number, price, price_history FROM "
      . $this->real_escape_string_read($this->cron_name . "_scrapped_data")
      . " WHERE stock_number = '"
      . $this->real_escape_string_read($car['stock_number']) . "';";

    $result = $this->query($check);

    if (!$result) {
      var_dump(mysqli_error(self::get_connection_read()) . " for "
        . $this->cron_name . "_scrapped_data table");
    }

    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);
    $store_query = '';

    if ($row) {
      $price         = $row['price'];
      $price_history = $row['price_history'] ? unserialize($row['price_history']) : [];

      if ($price != $car['price']) {
        $price_history[time()] = $car['price'];
      }

      $store_query .= "UPDATE "
        . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
        . " SET price = '" . $this->real_escape_string_write($car['price'])
        . "', price_value = '" . $this->real_escape_string_write(numarifyPrice($car['price']))
        . "', price_history = '" . $this->real_escape_string_write(serialize($price_history))
        . "', make = '" . $this->real_escape_string_write($car['make'])
        . "', model = '" . $this->real_escape_string_write($car['model'])
        . "', trim = '" . $this->real_escape_string_write($car['trim'])
        . "', currency = '" . $this->real_escape_string_write($car['currency'])
        . "', city = '" . $this->real_escape_string_write($car['city'])
        . "', body_style = '" . $this->real_escape_string_write($car['body_style'])
        . "', engine = '" . $this->real_escape_string_write($car['engine'])
        . "', transmission = '" . $this->real_escape_string_write($car['transmission'])
        . "', kilometres = '" . $this->real_escape_string_write($car['kilometres'])
        . "', no_feed = '" . $this->real_escape_string_write($car['no_feed'])
        . "', all_images = '" . $this->real_escape_string_write($car['all_images'])
        . "', description = '" . $this->real_escape_string_write(isset($car['description']) ? $car['description'] : '')
        . "', disclaimer = '" . $this->real_escape_string_write(isset($car['disclaimer']) ? $car['disclaimer'] : '')
        . "', url = '" . $this->real_escape_string_write($car['url'])
        . "', updated_at = " . $this->real_escape_string_write(time())
        . ", deleted = 0, auto_texts = '" . $this->real_escape_string_write(isset($car['auto_texts']) ? $car['auto_texts'] : '') .
        "'  WHERE stock_number = '" . $this->real_escape_string_write($car['stock_number']) .
        "' AND (price != '" . $this->real_escape_string_write($car['price']) .
        "' OR make != '" . $this->real_escape_string_write($car['make']) .
        "' OR model != '" . $this->real_escape_string_write($car['model']) .
        "' OR trim != '" . $this->real_escape_string_write($car['trim']) .
        "' OR body_style != '" . $this->real_escape_string_write($car['body_style']) .
        "' OR engine != '" . $this->real_escape_string_write($car['engine']) .
        "' OR transmission != '" . $this->real_escape_string_write($car['transmission']) .
        "' OR kilometres != '" . $this->real_escape_string_write($car['kilometres']) .
        "' OR no_feed != '" . $this->real_escape_string_write($car['no_feed']) .
        "' OR all_images != '" . $this->real_escape_string_write($car['all_images']) .
        "' OR description != '" . $this->real_escape_string_write(isset($car['description']) ? $car['description'] : '') .
        "' OR disclaimer != '" . $this->real_escape_string_write(isset($car['disclaimer']) ? $car['disclaimer'] : '') .
        "' OR auto_texts != '" . $this->real_escape_string_write(isset($car['auto_texts']) ? $car['auto_texts'] : '') .
        "' OR url != '" . $this->real_escape_string_write($car['url']) .
        "' OR deleted = 1);";
    } else {
      $price_history = array(
        time() => $car['price'],
      );

      $store_query .= "INSERT INTO "
        . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
        . ' (options, stock_number, stock_type, title, year, make, model, trim, city, price, currency, price_value,price_history, '
        . 'body_style, engine, transmission, exterior_color, interior_color, '
        . 'kilometres, kilometres_value, all_images, auto_texts, description, disclaimer, url, host, arrival_date, updated_at, handled_at, lat, no_feed, `long`) VALUES (\''
        . $this->real_escape_string_write($car['options']) . "', '"
        . $this->real_escape_string_write($car['stock_number']) . "', '"
        . $this->real_escape_string_write($car['stock_type']) . "', '"
        . $this->real_escape_string_write($car['title']) . "', '"
        . $this->real_escape_string_write($car['year']) . "', '"
        . $this->real_escape_string_write($car['make']) . "', '"
        . $this->real_escape_string_write($car['model']) . "', '"
        . $this->real_escape_string_write($car['trim']) . "', '"
        . $this->real_escape_string_write($car['city']) . "', '"
        . $this->real_escape_string_write($car['price']) . "', '"
        . $this->real_escape_string_write($car['currency']) . "', '"
        . $this->real_escape_string_write(numarifyPrice($car['price'])) . "', '"
        . $this->real_escape_string_write(serialize($price_history)) . "', '"
        . $this->real_escape_string_write(@$car['body_style']) . "', '"
        . $this->real_escape_string_write(@$car['engine']) . "', '"
        . $this->real_escape_string_write(@$car['transmission']) . "', '"
        . $this->real_escape_string_write(@$car['exterior_color']) . "', '"
        . $this->real_escape_string_write(@$car['interior_color']) . "', '"
        . $this->real_escape_string_write(@$car['kilometres']) . "', '"
        . $this->real_escape_string_write(numarifyKm(@$car['kilometres'])) . "', '"
        . $this->real_escape_string_write(@$car['all_images']) . "', '"
        . $this->real_escape_string_write(isset($car['auto_texts']) ? $car['auto_texts'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['description']) ? $car['description'] : '') . "', '"
        . $this->real_escape_string_write(isset($car['disclaimer']) ? $car['disclaimer'] : '') . "', '"
        . $this->real_escape_string_write($car['url']) . "', '"
        . $this->real_escape_string_write(isset($car['host']) ? $car['host'] : '') . "', " . $this->real_escape_string_write(isset($car['arrival_date']) ? $car['arrival_date'] : time()) . ", " . time() . ", 0,"
        . $this->real_escape_string_write(isset($car['lat']) ? $car['lat'] : 0) . ", "
        . $this->real_escape_string_write(isset($car['no_feed']) ? $car['no_feed'] : 0) . ", "
        . $this->real_escape_string_write(isset($car['long']) ? $car['long'] : 0) . ");";
    }

    $this->query($store_query);

    if (mysqli_errno(self::get_connection_write())) {
      if (function_exists('slecho')) {
        slecho(mysqli_error(self::get_connection_write()));
        slecho("**Info: Query - " . $store_query);
      }
    }
  }

  /**
   * Stores a page source.
   *
   * @param      <type>  $payload  The payload
   */
  public function store_page_source($payload)
  {
    if (!isset($payload['svin']) || !trim($payload['svin'])) {
      if (function_exists('slecho')) {
        slecho("ERROR: There is no SVIN present.");
      }

      return;
    }

    if (!isset($payload['url']) || !trim($payload['url'])) {
      if (function_exists('slecho')) {
        slecho("ERROR: There is no url present.");
      }

      return;
    }

    $check = "SELECT svin FROM "
      . $this->real_escape_string_read($this->cron_name . "_source_data")
      . " WHERE svin = '" . $this->real_escape_string_read($payload['svin']) . "';";
    $result = $this->query($check);

    if (!$result) {
      var_dump(mysqli_error(self::get_connection_read()) . " for " . $this->cron_name . "_source_data table");
    }

    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);
    $store_query = '';

    if ($row) {
      $query_parameters = $this->prepare_query_params($payload, self::PREPARE_EQUAL);
      $store_query      = "UPDATE "
        . $this->real_escape_string_read($this->cron_name . "_source_data")
        . " SET {$query_parameters} WHERE svin = '"
        . $this->real_escape_string_read($payload['svin']) . "';";
    } else {
      $query_parameters = $this->prepare_query_params($payload, self::PREPARE_PARENTHESES);
      $store_query      = "INSERT INTO "
        . $this->real_escape_string_read($this->cron_name . "_source_data")
        . " {$query_parameters};";
    }

    $this->query($store_query);

    if (mysqli_errno(self::get_connection_write())) {
      if (function_exists('slecho')) {
        slecho(mysqli_error(self::get_connection_write()));
        slecho("**Info: Query - " . $store_query);
      }
    }
  }

  /**
   * Stores a readd car.
   *
   * @param      <type>  $payload  The payload
   */
  public function store_readd_car($payload)
  {
    // This is always oldest svin, not new one(s)
    if (!isset($payload['svin']) || !trim($payload['svin'])) {
      if (function_exists('slecho')) {
        slecho("ERROR: There is no SVIN present.");
      }

      return;
    }

    if (!isset($payload['current_url']) || !trim($payload['current_url'])) {
      if (function_exists('slecho')) {
        slecho("ERROR: There is no current url present.");
      }

      return;
    }

    $check = "SELECT add_delete_history FROM "
      . $this->real_escape_string_read($this->cron_name . "_cartrack_data")
      . " WHERE svin = '" . $this->real_escape_string_read($payload['svin']) . "';";

    $result = $this->query($check);

    if (!$result) {
      var_dump(mysqli_error(self::get_connection_read()) . " for " . $this->cron_name . "_cartrack_data table");
    }

    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);
    $store_query = '';

    if ($row) {
      $old_history = $row['add_delete_history'] ? unserialize($row['add_delete_history']) : [$payload['arrival_date'] => 'arrival'];

      $old_history[$payload['deleted_at']] = 'deleted';
      $old_history[$payload['readded_at']] = 'readded';
      $payload['add_delete_history']       = serialize($old_history);

      $query_parameters = $this->prepare_query_params($payload, self::PREPARE_EQUAL);
      $store_query      = "UPDATE "
        . $this->real_escape_string_read($this->cron_name . "_cartrack_data")
        . " SET {$query_parameters} WHERE svin = '"
        . $this->real_escape_string_read($payload['svin']) . "';";
    } else {
      $old_history = [
        $payload['arrival_date'] => 'arrival',
        $payload['deleted_at']   => 'deleted',
        $payload['readded_at']   => 'readded',
      ];
      $payload['add_delete_history'] = serialize($old_history);

      $query_parameters = $this->prepare_query_params($payload, self::PREPARE_PARENTHESES);
      $store_query      = "INSERT INTO "
        . $this->real_escape_string_read($this->cron_name . "_cartrack_data")
        . " {$query_parameters};";
    }

    $this->query($store_query);

    if (mysqli_errno(self::get_connection_write())) {
      if (function_exists('slecho')) {
        slecho(mysqli_error(self::get_connection_write()));
        slecho("**Info: Query - " . $store_query);
      }
    }
  }

  /**
   * Stores an adwords tag.
   *
   * @param      <type>  $url            The url
   * @param      <type>  $year           The year
   * @param      <type>  $make           The make
   * @param      <type>  $model          The model
   * @param      <type>  $conversion_id  The conversion identifier
   * @param      <type>  $label          The label
   * @param      <type>  $userlist_id    The userlist identifier
   */
  public function store_adwords_tag($url, $year, $make, $model, $conversion_id, $label, $userlist_id)
  {
    $query = 'INSERT INTO tracker_tags '
      . '(url, cron_name, year, make, model, conversion_id, label, userlist_id) values (\''
      . $this->real_escape_string_write($url) . "', '"
      . $this->real_escape_string_write($this->cron_name) . "', '"
      . $this->real_escape_string_write($year) . "', '"
      . $this->real_escape_string_write($make) . "', '"
      . $this->real_escape_string_write($model) . "', '"
      . $this->real_escape_string_write($conversion_id) . "', '"
      . $this->real_escape_string_write($label) . "', '"
      . $this->real_escape_string_write($userlist_id) . "');";

    $this->query($query);
  }

  /**
   * { function_description }
   *
   * @param      <type>      $year   The year
   * @param      <type>      $make   The make
   * @param      <type>      $model  The model
   *
   * @return     array|bool  ( description_of_the_return_value )
   */
  public function retrive_tag($year, $make, $model)
  {
    // insert
    $query = "SELECT conversion_id, label, userlist_id FROM tracker_tags WHERE "
      . "cron_name='" . $this->real_escape_string_read($this->cron_name)
      . "' AND year='" . $this->real_escape_string_read($year)
      . "' AND make='" . $this->real_escape_string_read($make)
      . "' AND model='" . $this->real_escape_string_read($model) . "';";

    $result    = $this->query($query);
    $to_return = false;

    if ($result) {
      $row = mysqli_fetch_array($result);

      if ($row) {
        $to_return = [
          'conversion_id' => $row['conversion_id'],
          'label'         => $row['label'],
          'userlist_id'   => $row['userlist_id'],
        ];
      }
    }

    mysqli_free_result($result);

    return $to_return;
  }

  /**
   * { function_description }
   *
   * @param      <type>      $url    The url
   *
   * @return     array|bool  ( description_of_the_return_value )
   */
  public function retrive_adwords_tag($url)
  {
    // insert
    $query = "SELECT conversion_id, label, userlist_id FROM tracker_tags WHERE url = \""
      . $this->real_escape_string_read($url) . "\";";
    $result    = $this->query($query);
    $to_return = false;

    if ($result) {
      $row = mysqli_fetch_array($result);

      if ($row) {
        $to_return = [
          'conversion_id' => $row['conversion_id'],
          'label'         => $row['label'],
          'userlist_id'   => $row['userlist_id'],
        ];
      }
    }

    mysqli_free_result($result);

    return $to_return;
  }

  /**
   * Stores a combined userlist.
   *
   * @param      <type>  $userlist_id  The userlist identifier
   */
  public function store_combined_userlist($userlist_id)
  {
    // insert
    $query = "INSERT INTO combined_userlist (cron_name, userlist_id) VALUES ('"
      . $this->real_escape_string_write($this->cron_name)
      . "', '" . $this->real_escape_string_write($userlist_id) . "');";
    $this->query($query);
  }

  /**
   * { function_description }
   *
   * @return     bool  ( description_of_the_return_value )
   */
  public function retrive_combined_userlist()
  {
    $query = "SELECT userlist_id FROM combined_userlist WHERE cron_name = '"
      . $this->real_escape_string_read($this->cron_name) . "';";
    $result    = $this->query($query);
    $to_return = false;

    if ($result) {
      $row = mysqli_fetch_array($result);

      if ($row) {
        $to_return = $row['userlist_id'];
      }
    }

    return $to_return;
  }

  /**
   * Creates a meta table.
   *
   * @param      string  $meta_name  The meta name
   */
  public function create_meta_table($meta_name)
  {
    $this->query("CREATE TABLE IF NOT EXISTS "
      . $this->real_escape_string_write($meta_name . "_meta_data") . " (
            meta_key varchar(255) NOT NULL DEFAULT '',
            meta_value longtext NOT NULL,
            PRIMARY KEY (meta_key)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
  }

  /**
   * { function_description }
   *
   * @param      string  $meta_name   The meta name
   * @param      <type>  $meta_key    The meta key
   * @param      <type>  $meta_value  The meta value
   */
  public function update_meta($meta_name, $meta_key, $meta_value = null)
  {
    $prev  = $this->get_meta($meta_name, $meta_key);
    $query = null;

    if (is_null($meta_value)) {
      if (!is_null($prev)) {
        $query = "DELETE FROM " . $this->real_escape_string_write($meta_name . "_meta_data")
          . " WHERE meta_key = '" . $this->real_escape_string_write($meta_key) . "';";
      }
    } else {
      $data = serialize($meta_value);

      if (is_null($prev)) {
        $query = "INSERT INTO " . $this->real_escape_string_write($meta_name . "_meta_data")
          . " (meta_key, meta_value) VALUES ('"
          . $this->real_escape_string_write($meta_key) . "', '"
          . $this->real_escape_string_write($data) . "');";
      } else {
        $query = "UPDATE " . $this->real_escape_string_write($meta_name . "_meta_data")
          . " SET meta_value = '" . $this->real_escape_string_write($data) . "' "
          . " WHERE meta_key = '" . $this->real_escape_string_write($meta_key) . "';";
      }
    }

    if (!is_null($query)) {
      $this->query($query);
    }
  }

  /**
   * Gets the meta.
   *
   * @param      string  $meta_name  The meta name
   * @param      <type>  $meta_key   The meta key
   *
   * @return     <type>  The meta.
   */
  public function get_meta($meta_name, $meta_key)
  {
    $query = "SELECT meta_value FROM " . $this->real_escape_string_read($meta_name . "_meta_data")
      . " WHERE meta_key = '" . $this->real_escape_string_read($meta_key) . "';";
    $result    = $this->query($query);
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
   * Stores a dealership.
   *
   * @param      <type>  $dealership  The dealership
   *
   * @return     bool    ( description_of_the_return_value )
   */
  public function store_dealership($dealership)
  {
    $id = isset($dealership['id']) ? $dealership['id'] : null;

    if ($id) {
      $query = "UPDATE dealerships SET ";
      $count = 0;

      foreach ($dealership as $key => $value) {
        if ($key == 'id' || $key == 'created_by' || $key == 'notes') {
          continue;
        }

        if ($value === null) {
          continue;
        }

        if ($count != 0) {
          $query .= ', ';
        }

        $query .= "{$key}='{$value}'";
        $count++;
      }

      $query .= " WHERE id={$id}";

      $this->query($query);
    } else {
      $created_by = $dealership['created_by'];
      $count      = 0;
      $keys       = '';
      $values     = '';

      foreach ($dealership as $key => $value) {
        if ($key == 'created_by' || $key == 'current_editor') {
          continue;
        }

        if ($count != 0) {
          $keys .= ', ';
          $values .= ', ';
        }

        $keys .= $key;
        $values .= "'$value'";

        $count++;
      }

      $keys .= ', created_by, current_editor';
      $values .= ", '$created_by', 1";
      $query = "INSERT INTO dealerships ($keys) VALUES ($values);";
      $this->query($query);
      $id = mysqli_insert_id(self::get_connection_write());
    }

    return $id;
  }

  /**
   * Gets the dealerships.
   *
   * @param      <type>  $role      The role
   * @param      <type>  $sortby    The sortby
   * @param      <type>  $sortmode  The sortmode
   *
   * @return     array   The dealerships.
   */
  public function get_dealerships($role, $sortby, $sortmode)
  {
    global $admins;

    $result = [
      'todo' => [],
      'done' => [],
    ];

    $query = "SELECT * FROM dealerships WHERE current_editor = {$role} ORDER BY {$sortby} {$sortmode};";
    $res   = $this->query($query);

    while ($row = mysqli_fetch_array($res)) {
      $result['todo'][] = [
        'id'                 => $row['id'],
        'job_title'          => $row['job_title'],
        'contact_name'       => $row['contact_name'],
        'email'              => $row['email'],
        'phone'              => $row['phone'],
        'website'            => $row['website'],
        'dealership_name'    => $row['dealership_name'],
        'dealership_id'      => $row['dealership_id'],
        'accountid'          => $row['accountid'],
        'geographic_targets' => $row['geographic_targets'],
        'promotions'         => $row['promotions'],
        'new_campaigns'      => $row['new_campaigns'],
        'used_campaigns'     => $row['used_campaigns'],
        'start_type'         => $row['start_type'],
        'budget'             => $row['budget'],
        'border_color'       => $row['border_color'],
        'text_color'         => $row['text_color'],
        'created_by'         => isset($admins[$row['created_by']]) ? [
          'id'   => $row['created_by'],
          'name' => $admins[$row['created_by']]['name'],
        ] : [
          'id'   => $row['created_by'],
          'name' => $row['created_by'],
        ],

        'current_editor'     => $row['current_editor'],
        'status'             => $row['status'],
        'notes'              => $this->get_notes($row['id']),
      ];
    }

    mysqli_free_result($res);

    $query2 = "SELECT * FROM dealerships WHERE current_editor > {$role} ORDER BY {$sortby} {$sortmode};";
    $res2   = $this->query($query2);

    while ($row = mysqli_fetch_array($res2)) {
      $result['done'][] = [
        'id'                 => $row['id'],
        'job_title'          => $row['job_title'],
        'contact_name'       => $row['contact_name'],
        'email'              => $row['email'],
        'phone'              => $row['phone'],
        'website'            => $row['website'],
        'dealership_name'    => $row['dealership_name'],
        'dealership_id'      => $row['dealership_id'],
        'accountid'          => $row['accountid'],
        'geographic_targets' => $row['geographic_targets'],
        'promotions'         => $row['promotions'],
        'new_campaigns'      => $row['new_campaigns'],
        'used_campaigns'     => $row['used_campaigns'],
        'start_type'         => $row['start_type'],
        'budget'             => $row['budget'],
        'border_color'       => $row['border_color'],
        'text_color'         => $row['text_color'],

        'created_by'         => isset($admins[$row['created_by']]) ? [
          'id'   => $row['created_by'],
          'name' => $admins[$row['created_by']]['name'],
        ] : [
          'id'   => $row['created_by'],
          'name' => $row['created_by'],
        ],

        'current_editor'     => $row['current_editor'],
        'status'             => $row['status'],
        'notes'              => $this->get_notes($row['id']),
      ];
    }

    mysqli_free_result($res2);

    return $result;
  }

  /**
   * Gets the dealership by identifier.
   *
   * @param      <type>  $id     The identifier
   *
   * @return     array   The dealership by identifier.
   */
  public function get_dealership_by_id($id)
  {
    global $admins;

    $result = null;
    $query  = "SELECT * FROM dealerships WHERE id = '{$id}';";
    $res    = $this->query($query);
    $row    = mysqli_fetch_array($res);

    if ($row) {
      $result = [
        'id'                 => $row['id'],
        'job_title'          => $row['job_title'],
        'contact_name'       => $row['contact_name'],
        'email'              => $row['email'],
        'phone'              => $row['phone'],
        'website'            => $row['website'],
        'dealership_name'    => $row['dealership_name'],
        'dealership_id'      => $row['dealership_id'],
        'accountid'          => $row['accountid'],
        'geographic_targets' => $row['geographic_targets'],
        'promotions'         => $row['promotions'],
        'new_campaigns'      => $row['new_campaigns'],
        'used_campaigns'     => $row['used_campaigns'],
        'start_type'         => $row['start_type'],
        'budget'             => $row['budget'],
        'border_color'       => $row['border_color'],
        'text_color'         => $row['text_color'],
        'created_by'         => isset($admins[$row['created_by']]) ? [
          'id'   => $row['created_by'],
          'name' => $admins[$row['created_by']]['name'],
        ] : [
          'id'   => $row['created_by'],
          'name' => $row['created_by'],
        ],

        'current_editor'     => $row['current_editor'],
        'status'             => $row['status'],
        'notes'              => $this->get_notes($row['id']),
      ];
    }

    mysqli_free_result($res);

    return $result;
  }

  /**
   * Gets the imported dealerships.
   *
   * @param      int     $start  The start
   * @param      int     $count  The count
   * @param      string  $where  The where
   *
   * @return     array   The imported dealerships.
   */
  public function get_imported_dealerships($start = 0, $count = 0, $where = '1')
  {
    $query = "SELECT * FROM imported_dealerships WHERE {$where}";

    if ($count) {
      $query .= " LIMIT {$start}, {$count};";
    } else {
      $query .= ";";
    }

    $res    = $this->query($query);
    $result = [];

    while ($row = mysqli_fetch_array($res)) {
      $result[] = [
        'id'               => $row['id'],
        'host_name'        => $row['host_name'],
        'entry_points'     => unserialize($row['entry_points']),
        'rule_name'        => $row['rule_name'],
        'rule_matched'     => ord($row['rule_matched']),
        'scrapper_name'    => $row['scrapper_name'],
        'scrapper_matched' => ord($row['scrapper_matched']),
        'address'          => unserialize($row['address']),
        'status'           => $row['status'] ? unserialize($row['status']) : [],
      ];
    }

    mysqli_free_result($res);

    return $result;
  }

  /**
   * Gets the imported dealership.
   *
   * @param      <type>  $host   The host
   *
   * @return     array   The imported dealership.
   */
  public function get_imported_dealership($host)
  {
    $host   = $this->real_escape_string_read($host);
    $query  = "SELECT * FROM imported_dealerships WHERE host_name = '{$host}';";
    $res    = $this->query($query);
    $row    = mysqli_fetch_array($res);
    $result = null;

    if ($row) {
      $result = [
        'id'               => $row['id'],
        'host_name'        => $row['host_name'],
        'entry_points'     => unserialize($row['entry_points']),
        'rule_name'        => $row['rule_name'],
        'rule_matched'     => ord($row['rule_matched']),
        'scrapper_name'    => $row['scrapper_name'],
        'scrapper_matched' => ord($row['scrapper_matched']),
        'address'          => unserialize($row['address']),
      ];
    }

    mysqli_free_result($res);

    return $result;
  }

  /**
   * Stores an imported dealership.
   *
   * @param      <type>  $dealership  The dealership
   */
  public function store_imported_dealership($dealership)
  {
    $new      = true;
    $existing = $this->get_imported_dealership($dealership['host_name']);

    if ($existing) {
      $dealership['id'] = $existing['id'];

      if (isset($existing['country_code'])) {
        $dealership['address'] = $existing['address'];
      }

      $new = false;
    }

    $host_name        = $this->real_escape_string_write($dealership['host_name']);
    $t_entry_points   = serialize($dealership['entry_points']);
    $entry_points     = $this->real_escape_string_write($t_entry_points);
    $rule_name        = $this->real_escape_string_write($dealership['rule_name']);
    $rule_matched     = $dealership['rule_matched'] ? '1' : '0';
    $scrapper_name    = $this->real_escape_string_write($dealership['scrapper_name']);
    $scrapper_matched = $dealership['scrapper_matched'] ? '1' : '0';
    $t_address        = serialize($dealership['address']);
    $address          = $this->real_escape_string_write($t_address);

    $lat  = isset($dealership['address']['lat']) ? $dealership['address']['lat'] : 0;
    $long = isset($dealership['address']['long']) ? $dealership['address']['long'] : 0;

    if ($new) {
      $query = "INSERT INTO imported_dealerships (host_name, entry_points, rule_name, rule_matched, scrapper_name, scrapper_matched, address, `lat`, `long`) VALUES ";
      $query .= "(";
      $query .= "'$host_name',";
      $query .= "'$entry_points',";
      $query .= "'$rule_name',";
      $query .= "$rule_matched,";
      $query .= "'$scrapper_name',";
      $query .= "$scrapper_matched,";
      $query .= "'$address',";
      $query .= "$lat,";
      $query .= "$long";
      $query .= ");";
    } else {
      $id    = $dealership['id'];
      $query = "UPDATE imported_dealerships SET ";
      $query .= "host_name = '$host_name',";
      $query .= "entry_points = '$entry_points',";
      $query .= "rule_name = '$rule_name',";
      $query .= "rule_matched = $rule_matched,";
      $query .= "scrapper_name = '$scrapper_name',";
      $query .= "scrapper_matched = $scrapper_matched,";
      $query .= "address = '$address',";
      $query .= "`lat` = $lat,";
      $query .= "`long` = $long ";
      $query .= "WHERE id = $id;";
    }

    $this->query($query);
  }

  /**
   * Gets all dealers.
   *
   * @param      string  $where  The where
   *
   * @return     array   All dealers.
   */
  public function get_all_dealers($where = "status = 'active' OR status = 'trial';")
  {
    $query  = "SELECT * FROM dealerships WHERE {$where};";
    $result = $this->query($query);

    if (!$result) {
      return [];
    }

    $retval = [];

    while ($details = mysqli_fetch_assoc($result)) {
      $keys = array_keys($details);

      foreach ($keys as $index => $key) {
        $finfo = mysqli_fetch_field_direct($result, $index);

        if ($finfo->type == MYSQLI_TYPE_BLOB) {
          $details[$key] = $details[$key] ? unserialize($details[$key]) : [];
        }
      }

      $retval[$details['dealership']] = $details;
    }

    mysqli_free_result($result);

    return $retval;
  }

  /**
   * Gets the dealer details.
   *
   * @param      <type>  $dealership  The dealership
   *
   * @return     array    The dealer details.
   */
  public function get_dealer_details($dealership)
  {
    $query  = "SELECT * FROM dealerships WHERE dealership = '{$dealership}';";
    $result = $this->query($query);
    $retval = $result ? mysqli_fetch_assoc($result) : null;

    if (!$result || !$retval) {
      return null;
    }

    $keys = array_keys($retval);

    foreach ($keys as $index => $key) {
      $finfo = mysqli_fetch_field_direct($result, $index);

      if ($finfo->type == MYSQLI_TYPE_BLOB) {
        $retval[$key] = $retval[$key] ? unserialize($retval[$key]) : [];
      }
    }

    mysqli_free_result($result);

    return $retval;
  }

  /**
   * Determines whether the specified dealership is bing ad enabled.
   *
   * @param      <type>  $dealership  The dealership
   *
   * @return     bool    True if the specified dealership is bing ad enabled, False otherwise.
   */
  public function is_bing_ad_enabled($dealership)
  {
    $details = $this->get_dealer_details($dealership);
    return is_array($details) && in_array('Bing Ads', $details['campaign_types']);
  }

  /**
   * Gets the fb page identifier.
   *
   * @param      <type>  $dealership  The dealership
   *
   * @return     bool    The fb page identifier.
   */
  public function get_fb_page_id($dealership)
  {
    $query  = "SELECT fb_page_id FROM dealerships WHERE dealership = '{$dealership}';";
    $result = $this->query($query);
    $retval = $result ? mysqli_fetch_assoc($result) : null;

    if (!$result || !$retval || $retval['fb_page_id'] == '') {
      return null;
    }

    return $retval['fb_page_id'];
  }

  /**
   * Stores dealer details.
   *
   * @param      <type>  $dealership  The dealership
   * @param      <type>  $details     The details
   *
   * @return     bool    ( description_of_the_return_value )
   */
  public function store_dealer_details($dealership, $details)
  {
    $existing              = $this->get_dealer_details($dealership);
    $details['dealership'] = $dealership;
    $query_parameters      = $this->prepare_query_params($details, $existing ? self::PREPARE_EQUAL : self::PREPARE_PARENTHESES);
    $update_query          = "UPDATE dealerships SET {$query_parameters} WHERE dealership = '{$dealership}';";
    $insert_query          = "INSERT INTO dealerships {$query_parameters};";
    $query                 = $existing ? $update_query : $insert_query;
    $this->query($query);

    return $existing ? $existing['id'] : mysqli_insert_id(self::get_connection_write());
  }

  /**
   * Gets all pending calldrip data.
   *
   * @param      string  $where  The where
   *
   * @return     array   All pending calldrip data.
   */
  public function get_all_pending_calldrip_data($where = "`updated_at` is null")
  {
    $query  = "SELECT * FROM calldrip_data WHERE {$where};";
    $result = $this->query($query);

    if (!$result) {
      return [];
    }

    $retval = [];

    while ($details = mysqli_fetch_assoc($result)) {
      $retval[] = $details;
    }

    mysqli_free_result($result);

    return $retval;
  }

  /**
   * { function_description }
   *
   * @param      array   $salesman_numbers  The salesman numbers
   * @param      <type>  $lead_id           The lead identifier
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function update_pending_calldirp_data($salesman_numbers = [], $lead_id)
  {
    $ss_num = serialize($salesman_numbers);
    $query  = "UPDATE calldrip_data SET `updated_at` = now(), `salesman_numbers` = '{$ss_num}' WHERE `lead_id` = '{$lead_id}';";
    $result = $this->query($query);

    return $result;
  }

  /**
   * Gets the notes.
   *
   * @param      <type>  $dealership  The dealership
   *
   * @return     array   The notes.
   */
  public function get_notes($dealership)
  {
    $query  = "SELECT * FROM dealership_followups WHERE `dealership` = '{$dealership}' ORDER BY at DESC;";
    $result = $this->query($query);

    if (!$result) {
      return [];
    }

    $retval = [];

    while ($details = mysqli_fetch_assoc($result)) {
      $retval[] = $details;
    }

    mysqli_free_result($result);

    return $retval;
  }

  /**
   * Stores a note.
   *
   * @param      <type>  $dealership  The dealership
   * @param      <type>  $happiness   The happiness
   * @param      <type>  $note        The note
   * @param      <type>  $at          { parameter_description }
   * @param      string  $note_type   The note type
   * @param      <type>  $note_by     The note by
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function store_note($dealership, $happiness, $note, $at, $note_type, $note_by)
  {
    $details = [
      'dealership' => $dealership,
      'happiness'  => $happiness,
      'note'       => $note,
      'at'         => $at,
      'note_type'  => $note_type,
      'note_by'    => $note_by,
    ];

    $query_parameters = $this->prepare_query_params($details, '', self::PREPARE_PARENTHESES);
    $query            = "INSERT INTO dealership_followups {$query_parameters};";
    $this->query($query);
    $id = mysqli_insert_id(self::get_connection_write());

    if ($note_type == 'Follow Up') {
      $this->store_dealer_details($dealership, [
        'last_contacted' => $at,
        'happiness'      => $happiness,
      ]);
    }

    return $id;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $params        The parameters
   * @param      <type>  $prepare_type  The prepare type
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function prepare_query_params($params, $prepare_type = self::PREPARE_EQUAL)
  {
    unset($params['id']);

    foreach ($params as $key => $value) {
      $value = is_array($value) ? $this->real_escape_string_write(serialize($value)) : $this->real_escape_string_write($value);

      if ($prepare_type == self::PREPARE_EQUAL || $prepare_type == self::PREPARE_WHERE) {
        $value = "{$key}='{$value}'";
      } else {
        $value = "'{$value}'";
      }

      $params[$key] = $value;
    }

    $query_params = $prepare_type == self::PREPARE_EQUAL ? implode(', ', array_values($params)) : ($prepare_type == self::PREPARE_WHERE ? implode(' AND ', array_values($params)) :
      "(" . implode(', ', array_keys($params)) . ") VALUES (" . implode(', ', array_values($params)) . ")");

    return $query_params;
  }

  /**
   * Gets the enum.
   *
   * @param      <type>      $table_name  The table name
   * @param      <type>      $field_name  The field name
   *
   * @return     array|bool  The enum.
   */
  public function get_enum($table_name, $field_name)
  {
    $query  = "DESC {$table_name} {$field_name};";
    $result = $this->query($query);

    if (!$result) {
      return false;
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if ($row === false) {
      return false;
    }

    $type_dec = $row['Type'];

    if (substr($type_dec, 0, 5) !== 'enum(') {
      return false;
    }

    $values = [];

    foreach (explode(',', substr($type_dec, 5, (strlen($type_dec) - 6))) as $v) {
      array_push($values, trim($v, "'"));
    }

    return $values;
  }

  /**
   * Gets the instance.
   *
   * @param      string  $cron_name  The cron name
   *
   * @return     <type>  The instance.
   */
  public static function get_instance($cron_name = '')
  {
    if (self::$_instance) {
      self::$_instance->cron_name = $cron_name;
    } else {
      self::$_instance = new DbConnect($cron_name);
    }

    return self::$_instance;
  }

  /**
   * Stores a log.
   *
   * @param      string       $user_id     The user identifier
   * @param      string       $user_role   The user role
   * @param      string       $action      The action
   * @param      string       $details     The details
   * @param      bool|string  $dealership  The dealership
   */
  public static function store_log($user_id = '', $user_role = '', $action = '', $details = '', $dealership = '')
  {
    $ip = DbConnect::get_instance()->get_client_ip();

    if ($action == "Login") {
      try {
        $ip_server  = "https://ipinfo.io/{$ip}/json";
        $ip_details = json_decode(file_get_contents($ip_server), true);
      } catch (Exception $e) {
        $ip_details = ['error' => true, 'response' => 'Request Error' . $e];
      }
    } else {
      $ip_details = ['error' => false];
    }

    $device      = gethostbyaddr($ip);
    $gethostname = gethostname();

    $log_details = [
      'user_id'    => $user_id,
      'user_role'  => $user_role,
      'action'     => $action,
      'details'    => $details,
      'dealership' => $dealership ? $dealership : null,
      'ip'         => $ip,
      'ip_details' => serialize($ip_details),
      'host_name'  => $device . '--' . $gethostname,
    ];

    $query_parameters = DbConnect::get_instance()->prepare_query_params($log_details, '', self::PREPARE_PARENTHESES);
    $query            = "INSERT INTO log_data {$query_parameters};";
    DbConnect::get_instance()->query($query);
  }

  /**
   * Gets the client ip.
   *
   * @return     string  The client ip.
   */
  public function get_client_ip()
  {
    $ipaddress = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
      $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
  }

  /**
   * Determines if table exists.
   *
   * @param      <type>  $table_name  The table name
   *
   * @return     <type>  True if table exists, False otherwise.
   */
  public static function table_exists($table_name)
  {
    $query      = "SHOW TABLES LIKE '{$table_name}';";
    $query_exec = DbConnect::get_instance()->query($query);

    return mysqli_num_rows($query_exec);
  }

  /**
   * Loads car bing ads.
   *
   * @param      array  $cars_new      The cars new
   * @param      array  $cars_updated  The cars updated
   * @param      array  $cars_deleted  The cars deleted
   * @param      array  $cars_all      The cars all
   * @param      array  $cron_config   The cron configuration
   *
   * @return     bool   ( description_of_the_return_value )
   */
  public function LoadCarBingAds(&$cars_new, &$cars_updated, &$cars_deleted, &$cars_all, $cron_config = [])
  {
    $cars_new     = [];
    $cars_updated = [];
    $cars_deleted = [];
    $cars_all     = [];

    $query  = ("SELECT * FROM " . $this->real_escape_string_read($this->cron_name . "_scrapped_data") . ";");
    $result = $this->query($query);

    while ($row = mysqli_fetch_array($result)) {
      $images = explode("|", $row["all_images"]);

      if ($images[0] == "") {
        $images = [];
      }

      $auto_text = explode("|", $row["auto_texts"]);

      if ($auto_text[0] == "") {
        $auto_text = [];
      }

      $required_fields = [
        "stock_number"    => $row["stock_number"],
        "vin"             => $row["vin"],
        "svin"            => $row["svin"],
        "vehicle_id"      => $row["vehicle_id"],
        "stock_type"      => $row["stock_type"],
        "year"            => $row["year"],
        "make"            => $row["make"],
        "model"           => $row["model"],
        "trim"            => $row["trim"],
        "title"           => $row["title"],
        "msrp"            => $row["msrp"],
        "price"           => $row["price"],
        "currency"        => $row["currency"],
        "city"            => $row["city"],
        "biweekly"        => $row["biweekly"],
        "lease"           => $row["lease"],
        "lease_term"      => $row["lease_term"],
        "lease_rate"      => $row["lease_rate"],
        "finance"         => $row["finance"],
        "finance_term"    => $row["finance_term"],
        "finance_rate"    => $row["finance_rate"],
        "weekly"          => butifyPrice(numarifyPrice($row["biweekly"]) >> 1),
        "price_history"   => $row["price_history"] ? unserialize($row["price_history"]) : [],
        "body_style"      => $row["body_style"],
        "engine"          => $row["engine"],
        "cylinder"        => $row["cylinder"],
        "transmission"    => $row["transmission"],
        "fuel_type"       => $row["fuel_type"],
        "drivetrain"      => $row["drivetrain"],
        "kilometers"      => $row["kilometres"],
        "kilometres"      => $row["kilometres"],
        "color"           => $row["exterior_color"],
        'exterior_color'  => $row['exterior_color'],
        'interior_color'  => $row['interior_color'],
        "url"             => $row["url"],
        "host"            => $row["host"],
        "arrival_date"    => $row["arrival_date"],
        "updated_at"      => $row["updated_at"],
        "handled_at"      => $row["handled_at"],
        "bing_handled_at" => isset($row["bing_handled_at"]) ? $row["bing_handled_at"] : 0,
        "deleted_at"      => $row["deleted_at"],
        "certified"       => $row["certified"] ? 1 : 0,
        "deleted"         => $row["deleted"] ? 1 : 0,
        "images"          => $images,
        "all_images"      => $row["all_images"],
        "doors"           => $row["doors"],
        "passenger"       => $row["passenger"],
        "description"     => $row["description"],
        "disclaimer"      => $row["disclaimer"],
        "auto_texts"      => $auto_text,
        "custom"          => $row["custom"],
        "warranty"        => $row["warranty"],
        "engaged"         => $row["engaged"],
      ];

      $cars_all[$row["stock_number"]] = apply_filters("{$this->cron_name}_post_process_car_data", $required_fields);

      $price    = butifyPrice($cars_all[$row["stock_number"]]["price"]);
      $biweekly = butifyPrice($cars_all[$row["stock_number"]]["biweekly"]);

      if (!$biweekly) {
        $priceVal        = numarifyPrice($price);
        $biweekly_config = @$cron_config['biweekly'][$row["year"]][$row["stock_type"]];

        if ($priceVal && is_array($biweekly_config)) {
          $biweekly = calculateByWeekly(
            $priceVal,
            $biweekly_config['tax'],
            isset($biweekly_config['deposit']) ? $biweekly_config['deposit'] : 0,
            $biweekly_config['interest'],
            $biweekly_config['months'],
            $biweekly_config['fee']
          );

          $biweekly = butifyPrice($biweekly . '');
        }
      }

      $cars_all[$row["stock_number"]]["biweekly"] = $biweekly;
      $cars_all[$row["stock_number"]]["price"]    = $price;
    }

    mysqli_free_result($result);

    foreach ($cars_all as $stock_number => $car) {
      if (!$car['deleted'] && !$car['bing_handled_at']) {
        $cars_new[$stock_number] = $car;
      } else if (!$car['deleted'] && $car['bing_handled_at'] && ($car['updated_at'] > $car['bing_handled_at'])) {
        $cars_updated[$stock_number] = $car;
      } else if ($car['deleted']) {
        $cars_deleted[$stock_number] = $car;
      }
    }

    return true;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $stock_number  The stock number
   */
  public function update_bing_handled($stock_number)
  {
    $query = "UPDATE "
      . $this->real_escape_string_write($this->cron_name . "_scrapped_data")
      . " SET bing_handled_at = " . time() . " WHERE stock_number = '"
      . $this->real_escape_string_write($stock_number) . "';";
    $this->query($query);
  }

  /**
   * { function_description }
   *
   * @param      int   $sleep_time  The sleep time
   */
  public function bing_sleep($sleep_time = 0)
  {
    sleep($sleep_time);
  }

  /**
   * Gets the user.
   *
   * @param      <type>  $user_email  The user email
   * @param      bool    $ad          { parameter_description }
   *
   * @return     bool    The user.
   */
  public function getUser($user_email, $ad = true)
  {
    $user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);

    if ($ad) {
      $query = "SELECT * FROM users WHERE email = '{$user_email}' AND account_disabled = 0;";
    } else {
      $query = "SELECT * FROM users WHERE email = '{$user_email}';";
    }

    $result = $this->query($query);

    if ($result && mysqli_num_rows($result) > 1) {
      // handle grouping by same email
      // currently getting first row only
    }

    $user = $result ? mysqli_fetch_assoc($result) : null;

    if (!$result || !$user) {
      return null;
    }

    $user_id_md5 = md5($user['email']);

    if (file_exists(DATA_DIR . "user_images/{$user_id_md5}.jpg")) {
      $user['image_url']     = DATA_DIR_URL . "user_images/{$user_id_md5}-512.jpg";
      $user['thumbnail_url'] = DATA_DIR_URL . "user_images/{$user_id_md5}-36.jpg";
    }

    if (!(isset($user['image_url'])) || $user['image_url'] == '') {
      $user['image_url']     = "assets/images/smedia-logo-1024.png";
      $user['thumbnail_url'] = "assets/images/smedia-logo-36.png";
    }

    return $user;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $user_email  The user email
   * @param      <type>  $password    The password
   *
   * @return     bool    ( description_of_the_return_value )
   */
  public function verify_login($user_email, $password)
  {
    $user = $this->getUser($user_email);

    if (password_verify($password, $user['pass_hash'])) {
      return true;
    }

    return false;
  }

  /**
   * Gets the user type.
   *
   * @param      <type>  $user_email  The user email
   *
   * @return     <type>  The user type.
   */
  public function getUserType($user_email)
  {
    $user = $this->getUser($user_email);

    return $user['user_type'];
  }

  /**
   * Gets the user dealer.
   *
   * @param      <type>  $user_email  The user email
   *
   * @return     <type>  The user dealer.
   */
  public function getUserDealer($user_email)
  {
    $user = $this->getUser($user_email);

    return $user['dealership'];
  }

  /**
   * Determines whether the specified user email is pass set.
   *
   * @param      <type>  $user_email  The user email
   *
   * @return     bool    True if the specified user email is pass set, False otherwise.
   */
  public function isPassSet($user_email)
  {
    $user = $this->getUser($user_email);

    if (isset($user) && is_array($user) && isset($user['pass_hash']) && !$user['account_disabled']) {
      return true;
    }

    return false;
  }

  /**
   * Gets the group.
   *
   * @param      <type>  $user_email  The user email
   *
   * @return     array   The group.
   */
  public function getGroup($user_email)
  {
    $user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);
    $query_str  = "SELECT *  FROM users WHERE dealer_group = (SELECT dealer_group FROM users WHERE email = '$user_email') AND account_disabled = 0;";
    $result     = $this->query($query_str);
    $group      = [];

    while ($row = mysqli_fetch_assoc($result)) {
      if (!isset($row['pass_hash']) && $row['account_disabled']) {
        continue;
      }

      if (!isset($row['name'])) {
        $row['name'] = '';
      }

      if (!isset($row['designation'])) {
        $row['designation'] = '';
      }

      if (!isset($row['about_me'])) {
        $row['about_me'] = "I'm proud to be a part of sMedia.";
      }

      if (!isset($row['image_url']) || $row['image_url'] == '') {
        $row['image_url'] = "assets/images/smedia-logo-1024.png";
      }

      if (!isset($row['thumbnail_url']) || $row['thumbnail_url'] == '') {
        $row['thumbnail_url'] = "assets/images/smedia-logo-36.png";
      }

      if (!isset($row['website'])) {
        $row['website'] = 'https://smedia.ca/';
      }

      if (!isset($row['facebook']) || $row['facebook'] == '') {
        $row['facebook'] = 'https://www.facebook.com/sMedia.ca/';
      }

      if (!isset($row['instagram']) || $row['instagram'] == '') {
        $row['instagram'] = 'https://www.instagram.com/smedia.ca/';
      }

      if (!isset($row['linkedin']) || $row['linkedin'] == '') {
        $row['linkedin'] = 'https://www.linkedin.com/company/smedia.ca/';
      }

      $group['name']                              = $row['name'];
      $group['dealer_group']                      = $row['dealer_group'];
      $group['accounts'][]                        = $row['dealership'];
      $group['image_url'][$row['dealership']]     = $row['image_url'];
      $group['thumbnail_url'][$row['dealership']] = $row['thumbnail_url'];
      $group['website'][$row['dealership']]       = $row['website'];
      $group['facebook'][$row['dealership']]      = $row['facebook'];
      $group['instagram'][$row['dealership']]     = $row['instagram'];
      $group['linkedin'][$row['dealership']]      = $row['linkedin'];
      $group['phone_number'][$row['dealership']]  = $row['phone_number'];
      $group['about_me'][$row['dealership']]      = $row['about_me'];
    }

    if (count($group) == 0) {
      return null;
    }

    return $group;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $leads_ai_params  The leads ai parameters
   */
  public function submit_ai_buttons($leads_ai_params)
  {
    $query_prep = $this->prepare_query_params($leads_ai_params, self::PREPARE_PARENTHESES);
    $query_str  = "INSERT INTO leads_ai_dealerships {$query_prep};";
    $this->query($query_str);
  }

  /**
   * Gets the adf.
   *
   * @param      <type>  $dealership  The dealership
   *
   * @return     bool    The adf.
   */
  public function getADF($dealership)
  {
    if (!isset($dealership)) {
      return null;
    }

    $query_str = "SELECT adf_to, lead_to, star_to, lead_from, lead_to_new, adf_to_new, lead_to_used, adf_to_used, form_live, buttons_live, crm FROM dealerships WHERE dealership = '{$dealership}';";
    $result    = $this->query($query_str);
    $adf_db    = $result ? mysqli_fetch_assoc($result) : null;

    $properties = ['adf_to', 'lead_to', 'star_to', 'lead_to_new', 'lead_to_used', 'adf_to_new', 'adf_to_used'];

    foreach ($properties as $property) {
      $adf_db[$property] = unserialize($adf_db[$property]);

      if (!isset($adf_db[$property]) || $adf_db[$property] == "") {
        $adf_db[$property] = [];
      }
    }

    $adf_db['buttons_live'] = ($adf_db['buttons_live'] == "1") ? true : false;
    $adf_db['form_live']    = ($adf_db['form_live'] == "1") ? true : false;

    return $adf_db;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $calldrip_query_params  The calldrip query parameters
   */
  public function callDripInsert($calldrip_query_params)
  {
    $cqp = $this->prepare_query_params($calldrip_query_params, DbConnect::PREPARE_PARENTHESES);
    $this->query("INSERT INTO calldrip_data {$cqp};");
  }

  /**
   * Gets the admins.
   *
   * @return     array  The admins.
   */
  public function getAdmins()
  {
    $query  = "SELECT name, role, email FROM users WHERE user_type = 'a' AND account_disabled = 0 ORDER BY name ASC;";
    $result = $this->query($query);

    if (!$result || !mysqli_num_rows($result)) {
      return null;
    }

    $admins = [];

    while ($row = mysqli_fetch_assoc($result)) {
      $admins[$row['email']] = [
        'role'      => $row['role'],
        'name'      => $row['name'],
        'user_type' => 'a',
      ];
    }

    return $admins;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $cron_name  The cron name
   *
   * @return     bool    ( description_of_the_return_value )
   */
  public function scraperType($cron_name)
  {
    $result       = $this->query("SELECT scrapper_type FROM dealerships WHERE dealership = '{$cron_name}' AND (status = 'active' OR status = 'trial');");
    $fetch_result = $result ? mysqli_fetch_assoc($result) : ['scrapper_type' => 'RegEx'];

    return $fetch_result['scrapper_type'];
  }

  public function isScrapedByVS($cron_name)
  {
    $scrapper_type = $this->scraperType($cron_name);

    if ($scrapper_type === 'VS') {
      return true;
    }

    return false;
  }

  /**
   * Gets the only domain.
   *
   * @param      string  $url    The url
   *
   * @return     <type>  The only domain.
   */
  public function getOnlyDomain($url)
  {
    $url = trim($url, '/');

    if (!preg_match('#^http(s)?://#', $url)) {
      $url = 'http://' . $url;
    }

    $urlParts    = parse_url($url);
    $domain_name = preg_replace('/^www\./', '', $urlParts['host']);

    return $domain_name;
  }

  /**
   * { function_description }
   *
   * @param      <type>  $domain  The domain
   *
   * @return     <type>  ( description_of_the_return_value )
   */
  public function checkDealerExist($domain)
  {
    return $this->query("SELECT * FROM dealerships WHERE websites like '%{$domain}%';");
  }

  /**
   * Gets the cron names.
   *
   * @return     array  The cron names.
   */
  public function getCronNames($status = ['active', 'trial', 'inactive'])
  {
    if (!is_array($status) && is_string($status)) {
      $status = [$status];
    }

    $return = [];
    $in_que = "('" . implode("','", $status) . "')";
    $query  = "SELECT dealership from dealerships WHERE status IN {$in_que} ORDER BY dealership ASC;";
    $fetchs = $this->query($query);

    while ($row = mysqli_fetch_assoc($fetchs)) {
      $return[] = $row['dealership'];
    }

    return $return;
  }

  /**
   * Gets the group names.
   */
  public function getGroupNames()
  {
    $dealer_groups = [];

    $fetch_dealer_groups = $this->query("SELECT DISTINCT(group_name) FROM dealerships WHERE group_name != '' AND group_name IS NOT NULL ORDER BY group_name ASC;");

    while ($row = mysqli_fetch_assoc($fetch_dealer_groups)) {
      $dealer_groups[] = $row['group_name'];
    }

    return $dealer_groups;
  }

  /**
   * Gets the web providers.
   *
   * @return     array  The web providers.
   */
  public function getWebProviders()
  {
    $website_provider = [];
    $fetch_website_provider = $this->query("SELECT DISTINCT(website_provider) FROM dealerships WHERE  website_provider IS NOT NULL AND website_provider != '' AND website_provider != 'N/A' ORDER BY website_provider ASC;");

    while ($row = mysqli_fetch_assoc($fetch_website_provider)) {
      $website_provider[] = $row['website_provider'];
    }

    return $website_provider;
  }

  public function GetVdpUrl($cron, $type)
  {
    $query = "SELECT url FROM "
      . $this->real_escape_string_read($cron . "_scrapped_data")
      . " WHERE deleted = 0 and stock_type='$type' ORDER BY updated_at DESC limit 1;";

    $result = $this->query($query);
    $url    = null;

    $row = mysqli_fetch_array($result);
    if ($row) {
      $url = $row['url'];
    }

    mysqli_free_result($result);
    return $url;
  }
}
