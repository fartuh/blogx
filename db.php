<?php 

namespace CMS;

class DB
{

    private static $db;

    public static function connectDB($dsn, $user, $pass)
    {
        try{
            self::$db = new \PDO($dsn, $user, $pass);
        } catch(PDOException $e){
            return $e->getMessage();
        }
        return self::$db;
    }

    public static function getDB()
    {
        return self::$db;
    }

}
