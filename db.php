<?php 

namespace CMS;

class DB
{

    private static $db = null;

    public static function connectDB($dsn, $user, $pass)
    {
        try{
            $db = self::$db;
            self::$db = new \PDO($dsn, $user, $pass);
        } catch(PDOException $e){
            self::$db = $db;
            return $e->getMessage();
        }

        return self::$db;
    }

    public static function getDB()
    {
        return self::$db;
    }

}
