<?php
namespace Thumbsupcat\IcedAmericano\Database;

class Adaptor
{
    private static $pdo;
    private static $stm;

    public static function setup($dsn, $username, $password)
    {
        self::$pdo = new \PDO($dsn, $username, $password);
    }

    public static function exec($query, $params = [])
    {
        if (self::$stm = self::$pdo->prepare($query)) {
            return self::$stm->execute($params);
        }
    }

    public static function getAll($query, $params = [], $classname = 'stdClass')
    {
        if(self::exec($query, $params)) {
            return self::$stm->fetchAll(\PDO::FETCH_CLASS, $classname);
        }
    }
}