<?php
class PDOConnection {
    private static $dbhost = "db";
    private static $dbname = "mvcblog";
    private static $dbuser = "root";
    private static $dbpass = "secret";
    private static $dbinstance = NULL;

    public static function getInstance() {
        if (!self::$dbinstance) {
            $host = getenv('DB_HOST') ?: self::$dbhost;
            $dbname = getenv('DB_NAME') ?: self::$dbname;
            $user = getenv('DB_USER') ?: self::$dbuser;
            $pass = getenv('DB_PASSWORD') ?: self::$dbpass;

            self::$dbinstance = new PDO(
                "mysql:host=".$host.";dbname=".$dbname.";charset=utf8mb4",
                $user,
                $pass,
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        return self::$dbinstance;
    }
}
