<?php 

namespace CMS;

class DB
{

    public static function getDB($dsn, $user, $pass)
    {
        return new \PDO($dsn, $user, $pass);
    }

}
