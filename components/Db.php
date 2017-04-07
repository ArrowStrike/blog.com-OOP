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
        $paramsPath = ROOT . '/config/dbParams.php';
        $params = include($paramsPath);

        try {
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
            $db = new PDO($dsn, $params['user'], $params['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Подключение к БД не удалось: ' . $e->getMessage();
            die();
        }


        return $db;

    }
}