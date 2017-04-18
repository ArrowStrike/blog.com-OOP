<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 06-Apr-17
 * Time: 23:30
 */
class Db
{
    public static function getConnection()
    {
        $params = Config::getConfig('db');
        $dsn = "mysql:host={$params['host']};dbname={$params['dbName']}";

        try {
            $db = new PDO($dsn,
                $params['user'],
                $params['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            // Задаем кодировку
            $db->exec("set names utf8");

        } catch (PDOException $e) {
            echo 'Подключение к БД не удалось: ' . $e->getMessage();
            die();
        }


        return $db;

    }
}