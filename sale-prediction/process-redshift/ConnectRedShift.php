<?php
global $event_db_config;

class ConnectRedShift
{
    protected static $pdo = null;
    private static $_instance;

    public static function getConnection()
    {
        if (self::$pdo == null) {
            self::init();
        }
        try {
            $old_errlevel = error_reporting(0);
            self::$pdo->query("SELECT 1");
        } catch (PDOException $e) {
            self::init();
        }
        error_reporting($old_errlevel);

        return self::$pdo;
    }

    protected static function init()
    {
        try {
            global $event_db_config;
            $hostname = $event_db_config['host'];
            $port = $event_db_config['port'];
            $username = $event_db_config['user'];
            $password = $event_db_config['pass'];
            $dbname = $event_db_config['dbname'];

            self::$pdo = new PDO("pgsql:dbname={$dbname};host={$hostname};port={$port}", $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function get_instance()
    {
        if (!self::$_instance) {
            self::$_instance = new ConnectRedShift();
        }
        return self::$_instance;
    }

    public function exeQuery($queryStr)
    {
        $conn = self::getConnection();
        $statement = $conn->prepare($queryStr);
        $statement->execute();
        return $statement;
    }

}



