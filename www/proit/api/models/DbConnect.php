<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/db.php');

class DbConnect
{

    private static $dbName;
    private static $dbHost;
    private static $dbUser;
    private static $dbPassword;
    protected static $connectLink = null;
    public static $errorMessage = '';

    //Чтобы нельзя было создать через вызов new MySQLiWorker
    private function __construct()
    { /* ... */
    }

    //Чтобы нельзя было создать через клонирование
    private function __clone()
    { /* ... */
    }

    //Чтобы нельзя было создать через unserialize
    private function __wakeup()
    { /* ... */
    }

    public static function getConnection()
    {
        if (is_null(self::$connectLink)) {
            self::setConfig();
            self::openConnection();

        }
        return self::$connectLink;
    }

    private static function setConfig() {
        self::$dbName = DbConfig::DBNAME;
        self::$dbHost = DbConfig::HOST;
        self::$dbUser = DbConfig::USER;
        self::$dbPassword = DbConfig::PASS;
    }
    /**
     * Подключение к базе данных
     *
     * @author Oleg Gorbatov <o.i.gorbatov@yandex.ru>
     */
    private static function openConnection()
    {
        try {
            $dsn = 'mysql:host='.self::$dbHost.';dbname='.self::$dbName;
            self::$connectLink = new PDO($dsn, self::$dbUser, self::$dbPassword);
        } catch (PDOException $e) {
            self::$errorMessage = "Error!: " . $e->getMessage();
        }
    }
}