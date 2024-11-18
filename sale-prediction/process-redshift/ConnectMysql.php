<?php
global $db_config;

class ConnectMysql
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
            global $db_config;
            $hostname = $db_config['db_host_name'];
            $username = $db_config['db_user'];
            $password = $db_config['db_pass'];
            $dbname = $db_config['db_name'];

            self::$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public static function get_instance()
    {
        if (!self::$_instance) {
            self::$_instance = new ConnectMysql();
        }
        return self::$_instance;
    }

    public function exeQuery($queryStr)
    {
        return self::getConnection()->query($queryStr);
    }


    /*
     * $table = table name, must be a string
     * $param = array contain (key = table column, value)
     * $where = array contain (key = table column, value)
     */
    public function exeInsertOrUpdate($table, $params, $where = [])
    {
        if (empty($where)) {
            $key = implode(",", array_keys($params));
            $value = "'" . implode("','", $params) . "'";
            $query = "INSERT INTO $table ( $key ) VALUES ($value)";
            return self::get_instance()->exeQuery($query);
        } else {
            $query = "UPDATE $table SET ";
            foreach ($params as $key => $value) {
                $query .= "$key = '$value', ";
            }
            $query = rtrim($query, ', ');
            $Co=1;
            foreach ($where as $key => $value) {
                if($Co){
                    $query .= " WHERE $key = '$value'";
                    $Co=0;
                } else {
                    $query .= " AND $key = '$value'";
                }
            }
            return self::get_instance()->exeQuery($query);
        }
    }

    public function getAlldataAsdealer($table, $dealership)
    {
        $select_statement = "SELECT * FROM $table WHERE dealership='{$dealership}'";
        return self::get_instance()->exeQuery($select_statement);
    }


}



