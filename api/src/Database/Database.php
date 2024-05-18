<?php

namespace Api\Database;

use \PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!isset(self::$connection)) {
            $config = [
                'dsn' => 'mysql:host=database;dbname=assess_db',
                'username' => 'root',
                'password' => 'secret',
                'options' => [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ],
            ];
            
            $dsn = $config['dsn'];
            $username = $config['username'];
            $password = $config['password'];
            $options = $config['options'];

            self::$connection = new PDO($dsn, $username, $password, $options);
        }

        return self::$connection;
    }
}
