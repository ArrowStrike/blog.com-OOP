<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07-Apr-17
 * Time: 1:24
 */
class Config
{
    public static function getConfig($config)
    {
        $configs = array(
            'version' => 3,
            'title' => 'Блог Влада',
            'articlePerPage' => 4,
            'db' => array(
                'host' => "localhost",
                'dbName' => "test_blog",
                'user' => "root",
                'password' => ""
            ));
        return $configs[$config];
    }

}